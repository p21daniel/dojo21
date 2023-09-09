<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use PDO;

/**
 * Base model
 */
class Model
{
    private PDO $conn;

    /**
     * Constructor to define conn content
     */
    public function __construct()
    {
        $this->conn = (new DatabaseConnection())->getConnection();
    }

    /**
     * @return PDO
     */
    public function getConn(): PDO
    {
        return $this->conn;
    }
}