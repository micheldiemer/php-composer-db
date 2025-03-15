<?php


namespace Md\Db\Connection;

class PDOConnection extends Connection
{
    public static function fromConnection(Connection $c): PDOConnection
    {
        return new PDOConnection($c->dbname, $c->host, $c->user, $c->pass, $c->port);
    }

    public function getServer(): \Pdo
    {
        $this->dsn_s = "mysql:host=" . $this->host . ";port=" . $this->port;
        return new \PDO($this->dsn_s, $this->user, $this->pass);
    }

    public function getDb(): \Pdo
    {
        $this->dsn_s = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname;
        return new \PDO($this->dsn_s, $this->user, $this->pass);
    }
}
