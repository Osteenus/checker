<?php

class Database
{

    private $params;
    private $connection;

    public function __construct()
    {
        $this->params = include_once './config/db.php';
    }

    public function getConnection()
    {

        $this->connection = null;

        try {
            $dsn = "{$this->params['type']}:host={$this->params['host']};
                     port={$this->params['port']};
                     dbname={$this->params['dbname']};";

            $this->connection = new PDO(
                $dsn,
                $this->params['user'],
                $this->params['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            if ($this->connection) {
                // echo "Connected to the {$this->params['dbname']} database successfully!";
            }
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        } finally {
            if ($this->connection) {
                $this->connection = null;
            }
        }
        return $this->connection;
    }
}
