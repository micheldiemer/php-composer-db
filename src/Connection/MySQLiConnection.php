<?php

namespace Md\Db\Connection;

use stdClass;

class MySQLiConnection extends Connection
{
    public static function fromConnection(Connection $c): MySQLiConnection
    {
        return new MySQLiConnection($c->dbname, $c->host, $c->user, $c->pass, $c->port);
    }

    public function getServer(): \mysqli
    {
        $mysqli = \mysqli_connect($this->host, $this->user, $this->pass, null, $this->port);
        if ($mysqli->connect_error) {
            throw new \Exception("Connection failed: " . $mysqli->connect_error);
        }
        return $mysqli;
    }

    public function getDb(): \mysqli
    {
        return new \mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);
    }
}
