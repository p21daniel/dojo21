<?php

namespace App\Entity;

use PDO;
use PDOException;

/**
 * Base class to connect with mysql
 */
class DatabaseConnection
{
    /** @var PDO|null $connection */
    public ?PDO $connection = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $host = 'mysql';
        $database = 'okr';
        $user = 'root';
        $password = 'root';

        $dsn = "mysql:host=$host;dbname=$database";

        try {
            $pdoConnection = new PDO($dsn, $user, $password);
            $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdoConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $this->connection = $pdoConnection;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return DatabaseConnection|PDO|null
     */
    public function getConnection(): DatabaseConnection|PDO|null
    {
        if (!$this->connection) {
            $this->connection = new self();
        }

        return $this->connection;
    }
}