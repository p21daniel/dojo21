<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use PDO;

class Model
{
    /** @var PDO $conn */
    private $conn;

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