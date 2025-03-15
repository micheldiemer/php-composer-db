<?php

namespace Md\Db;

use Md\Db\Connection\PDOConnection;
use Md\Db\Connection\Connection;

/**
 * Class Db
 * Database functions utilities
 */
class Db
{
    /*
     * @var array $sqlTables list of tables in the database
    */
    private array $sqlTables;

    /*
        * @var \PDO $pdo pdo object
        */
    private \PDO $pdo;

    /**
     * @var PDOConnection $c
     */
    private PDOConnection $c;

    /*
     * @var bool $dieOnError true=>die on error, false=>throw exception
     */
    private bool $dieOnError;


    /*
     * catchPdoException
     *
     * @param callable $callback
     * @param array $args
     * @return void
     */
    private function catchPdoException(callable $callback, array $args = [])
    {
        try {
            \call_user_func_array($callback, $args);
        } catch (\PDOException $e) {
            if ($this->dieOnError) {
                \header('content-type: text/plain; charset=utf-8');
                \ini_set('html_errors', 0);
                die('Erreur : ' . $e->getMessage());
            }
            throw $e;
        }
    }

    /*
     * connect the database
     *
     * @return $this
     */
    private function connect(): Db
    {
        $this->pdo = $this->c->getDb();
        return $this;
    }



    /*
     * setDieOnError
     *
     * @param bool $dieOnError
     * @return $this
     */
    public function setDieOnError($dieOnError): Db
    {
        $this->dieOnError = $dieOnError;
        return $this;
    }


    /**
     * Db constructor.
     *
     * @param string $db
     * @param string $user
     * @param string $pass
     * @param string $host
     * @param bool $dieOnError
     */
    public function __construct(Connection $c, $dieOnError = true)
    {
        $this->setDieOnError($dieOnError);

        $this->catchPdoException([$this, 'connect']);

        $this->catchPdoException([$this, 'setSqlTables'], []);
    }

    /*
     * setSqlTables
     *
     * @return $this
     */
    private function setSqlTables(): Db
    {
        $q = $this->pdo->quote($this->c->getName());
        $sqlTables = "SELECT table_name ";
        $sqlTables .= "FROM information_schema.tables ";
        $sqlTables .= " WHERE table_schema = " . $q;
        $stmt = $this->pdo->query($sqlTables);
        while ($table = $stmt->fetch(\PDO::FETCH_COLUMN)) {
            $this->sqlTables[] = $table;
        }
        return $this;
    }


    /*
        * dropTable
        *
        * @param string $sqlTable
        * @return void
        */
    private function dropTable(string $sqlTable): Db
    {
        $fk0 = "SET FOREIGN_KEY_CHECKS = 0;";
        $fk1 = "SET FOREIGN_KEY_CHECKS = 1;";
        $this->pdo->exec("$fk0  DROP TABLE $sqlTable; $fk1");
        return $this;
    }

    /*
     * dropTables
     *
     * @return $this
     */
    private function dropTables(): Db
    {
        while ($sqlTable = array_pop($this->sqlTables) > 0) {
            $this->dropTable($sqlTable);
        }
        return $this;
    }

    /*
     * resets the tables in the database by dropping all tables
     *
     * @return $this
     */
    public function reset(): Db
    {
        $this->catchPdoException([$this, 'dropTables'], []);
        return $this;
    }

    /**
     * Get database name
     */
    public function getName(): string
    {
        return $this->c->getName();
    }
}
