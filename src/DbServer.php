<?php

namespace Md\Db;

use Md\Db\Connection\Connection;
use Md\Db\Connection\MySQLiConnection;
use Md\Db\Connection\PDOConnection;


class DbServer
{
    const DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS = [
        'utf8mb4_unicode_520_ci'
        => ["utf8mb4_0900_ai_ci", "utf8mb4_uca1400_ai_ci"]
    ];

    #region Properties
    /**
     *   @var \PDO $_pdo pdo object
     */
    private \PDO $_pdo;


    /**
     * Connection object
     *
     * @var Connection $c
     */
    private Connection $c;
    #endregion

    /**
     * Connection object
     *
     * @param Connection $c
     */
    public function __construct(Connection $c)
    {
        $this->c = $c;
        if ($c instanceof (__NAMESPACE__ . '/PDOConnection')):
            throw new \InvalidArgumentException("PDOConnection expected");
            return;
        endif;
        $this->_pdo = $this->c->getServer();
        $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->_pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    #region users
    /**
     * Create User for the current database
     *
     * @param string $newUser
     * @param string $newPass
     * @param boolean $dropIfExists
     * @param array $hosts list of hosts, defauts to ['localhost', '%']
     * @param array $databases list of databases, defaults to []
     * @return $this
     */
    public function createUser(string $newUser, string $newPass, $dropIfExists = false,  array $databases = [], array $hosts = ['localhost', '%']): DbServer
    {
        $pdo = $this->_pdo;
        if (!preg_match('/^[a-z0-9_]+$/', $newUser)):
            throw new \InvalidArgumentException("Invalid user name $newUser");
        endif;
        $qnewUser = $pdo->quote($newUser);
        $qnewPass = $pdo->quote($newPass);
        $exists = $dropIfExists ? 'IF NOT EXISTS' : '';

        foreach ($hosts as $host) {
            $qhost = '`' . $host . '`';
            if ($dropIfExists) {
                $this->dropUser($newUser, [$host]);
            }

            $sql = "CREATE USER $exists $qnewUser@$qhost IDENTIFIED BY $qnewPass";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            foreach ($databases as $db) {
                $qdb = $pdo->quote($db . '.*');
                $pdo->exec("GRANT ALL PRIVILEGES ON {$db}.* TO {$qnewUser}@{$qhost}");
            }
        }
        $pdo->exec('FLUSH PRIVILEGES');
        return $this;
    }


    /**
     * Drop User for the current server
     *
     * @param string $user
     * @param array $hosts list of hosts, defauts to ['localhost', '%']
     * @param boolean $ifExists
     * @return void
     */
    public function dropUser(string $user, array $hosts = ['localhost', '%'], $ifExists = true): void
    {
        $pdo = $this->_pdo;
        $quser = $pdo->quote($user);
        $exists = $ifExists ? 'IF EXISTS' : '';
        foreach ($hosts as $host) {
            $qhost = $pdo->quote($host);
            $pdo->exec("DROP USER $exists $quser@$qhost");
        }
    }
    #endregion

    #region createusers databases ...
    /**
     * Create a database on a server
     *
     * @param string $newDb      : new database name
     * @param string $newUser    : new user name for the new database
     * @param string $newPass    : password for the new user
     * @param string $charSet    : character set, defaults to utf8mb4
     * @param string $charCollation : character collation, defaults to utf8mb4_unicode_520_ci
     * @return Db
     */
    public function createDatabaseWithUser(
        string $newDb,
        string $newUser = '',
        string $newPass = '',
        string $charSet = 'utf8mb4',
        string $charCollation = 'utf8mb4_unicode_520_ci'
    ): Db {
        $db = $this->createDatabase($newDb, true, $charSet, $charCollation);
        $this->createUser($newUser, $newPass, true, [$newDb]);

        $dbConnect = new PDOConnection($newDb, $this->c->getHost(), $newUser, $newPass, $this->c->getPort());
        return new Db($dbConnect);
    }


    /*
        * Create a database
        *
        * @param string $dbname
        * @param bool $dropIfExists
        * @param string $charset
        * @param string $collation
        * @return Db
        */
    public function createDatabase(
        string $dbname,
        bool $dropIfExists = false,
        string $charset = 'utf8mb4',
        string $collation = 'utf8mb4_unicode_520_ci',
    ): Db {

        if (!preg_match('/^[0-9a-z_]+$/', $dbname)):
            throw new \InvalidArgumentException("Invalid database name");
        endif;
        $exists = $dropIfExists ? 'IF NOT EXISTS' : '';

        if ($dropIfExists) {
            $this->dropDatabase($dbname);
        }

        $qdbname = '`' . $dbname . '`';
	$sql = "CREATE DATABASE {$exists} {$qdbname} CHARACTER SET {$charset} COLLATE {$collation}";
        $this->_pdo->exec(
           $sql 
        );

        return new Db($this->c->withDbName($dbname));
    }

    /**
     * Create user for database
     */
    public function createUserForDatabase(string $dbname, string $newUser, string $newPass)
    {
        $this->createUser($newUser, $newPass, true, [$dbname]);
    }

    /**
     * Drop a database
     *
     * @param string $dbname
     * @param bool $ifExists
     * @return void
     */
    public function dropDatabase(string $dbname, $ifExists = true)
    {
        $exists = $ifExists ? 'IF EXISTS' : '';
        $this->_pdo->exec("DROP DATABASE $exists $dbname");
    }


    /**
     * Create a second root
     *
     * @param string $secondRoot
     * @param string $secondRootPass
     * @return void
     */
    public function createSecondRoot($secondRoot, $secondRootPass)
    {
        $pdo = $this->_pdo;
        $this->createUser($secondRoot, $secondRootPass, true);
        $qUser = $pdo->quote($secondRoot);
        $qPass = $pdo->quote($secondRootPass);
        $pdo->exec("GRANT ALL PRIVILEGES ON *.* TO {$qUser}@{$qPass}");
        $pdo->exec("GRANT GRANT OPTION ON *.* TO {$qUser}@{$qPass}");
        $pdo->exec("FLUSH PRIVILEGES");
    }
    #endregion



    private static function doImport(\mysqli $mysqli, string $sqlFile, array $replacements)
    {
        if ($mysqli === false) {
            throw new \mysqli_sql_exception('Error mysqli_connect Unable to connect to database ' . mysqli_connect_error());
        }

        if (!file_exists($sqlFile) || !file_exists($sqlFile) && is_readable($sqlFile)) {
            throw new \mysqli_sql_exception("Error importSql Erreur de lecture $sqlFile\n");
        }

        $query = file_get_contents($sqlFile);
	$r = mysqli_query($mysqli, "select database();");
	if(mysqli_num_rows($r) > 0) {
		$db = mysqli_fetch_column($r);
		if($db != ''):
		  $query = "use {$db};" . PHP_EOL . $query;
		endif;
	}
	mysqli_free_result($r);
        foreach ($replacements as $replace => $keys) {
            foreach ($keys as $search) {
                $query = mb_str_replace($search, $replace, $query);
            }

            // execute the SQL
            mysqli_multi_query($mysqli, $query);
            do {
                /* store the result set in PHP */
                if ($result = mysqli_store_result($mysqli)) {
                    while ($row = mysqli_fetch_row($result)) {
                        print_r($row);
                    }
                }
                /* print divider */
                if (mysqli_more_results($mysqli)) {
                    printf("-----------------\n");
                }
            } while (mysqli_next_result($mysqli));
        }
    }

    /*
     * importSql
     *
     * @param string $sqlFile      : file to import
     * @param array $replacements  : array of replacements
     *              [ replace => [search1, search2, ...], ...]
     *              useful for changing collation
     * @return string
     */
    public static function importSql(DbServer $server, Db|null $db, $sqlFile = __DIR__ . "/file.sql", $replacements = self::DEFAULT_MYSQL_TO_MARIADB_REPLACEMENTS)
    {
        $importUser = 'importsql_'
            . bin2hex(random_bytes(4))
            . substr(date_create()->format('Uv'), -3)
            . base_convert(random_int(37, 36 ** 2), 10, 36);

        $importPass = bin2hex(random_bytes(20));
        $name = $db?->getName() ?? null;
        $dbs = $name ? [$name] : [];

        $server->createUser($importUser, $importPass, true, $dbs);
        $importConnection = new MySQLiConnection($name, $server->c->getHost(), $importUser, $importPass, $server->c->getPort());

        $mysqli = is_null($name) ? $importConnection->getServer() : $importConnection->getDb();
        self::doImport($mysqli, $sqlFile, $replacements);
        $server->dropUser($importUser, [$host]);


        return true;
    }
}
