<?php

include '../Abstract/abstract.php';

class Database extends Dbname
{
    protected $conn;
    private $servername ="localhost";
    private $dbname ="defenseoop";

    public function setup()

    {
        $this->conn = new mysqli($this->servername, "root","");
        $this->conn->query("CREATE DATABASE IF NOT EXISTS $this->dbname");
        $this->conn = new mysqli($this->servername, "root","",$this->dbname);

    }
    public function getError()
    {
        return $this->conn->error;
    }
}

