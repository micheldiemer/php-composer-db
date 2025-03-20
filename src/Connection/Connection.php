<?php

namespace Md\Db\Connection;

abstract class Connection
{
    /**
     * @var string $dbname database name
     */
    protected string|null $dbname;

    /**
     * @var string $user user name
     */
    protected string $user;

    /**
     * @var string $pass password
     */
    protected string $pass;

    /**
     * @var string $host host name
     */
    protected string $host;

    /**
     * @var int $port port number
     */
    protected int $port;


    /**
     * @var string $dsn data source name
     */
    protected string $dsn;

    /**
     * @var string $dsn_s data source name
     */
    protected string $dsn_s;

    /**
     * Connection constructor.
     * @param string $dbname
     * @param string $host
     * @param string $user
     * @param string $pass
     * @param int $port
     */
    public function __construct(string|null $dbname, string $host, string $user, string $pass, int $port = 3306)
    {
        $this->dbname = $dbname;
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
    }

    /**
     * Create (child) Connection object from a Connection object
     *
     * @param Connection $c
     * @return void
     */
    abstract static function fromConnection(Connection $c);

    /**
     * Get an object connected to the server (without database)
     *
     * @return \PDO|\mysqli
     */
    abstract function getServer();

    /**
     * Get an object connected to the database
     *
     * @return \stdClass
     */
    abstract function getDb();


    /**
     * Get database name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->dbname;
    }



    /**
     * Get host name
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Get User name
     *
     * @return string user name
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Get Port number
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Returns a new Connection object with same settings
     * except a different database
     *
     * @param string $dbname
     * @return Connection
     */
    public function withDbName($dbname): Connection
    {
        $class = get_class($this);
        return new $class($dbname, $this->host, $this->user, $this->pass, $this->port);
    }
}
