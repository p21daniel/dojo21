<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use PDO;

/**
 * Base model
 */
class Model
{
    /** @var PDO $conn */
    private $conn;

    /**
     * Constructor to define conn content
     */
    public function __construct()
    {
        $this->conn = (new DatabaseConnection())->getConnection();
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }
}