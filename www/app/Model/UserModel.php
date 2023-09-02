<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use App\Entity\User;
use PDO;

class UserModel
{
    public function save($name, $email, $password){
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $password = md5($password);

        /** @var $pdoConnection PDO */
        $statement = $pdoConnection->prepare("INSERT INTO user (name, email, password) values (:name, :email, :password)");
        $statement->bindParam(':name', $name);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->execute();
    }

    public function authenticate(User $user): bool
    {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $password = md5($user->password);

        $statement = $pdoConnection->prepare("SELECT * FROM user WHERE email = :email");
        $statement->bindParam(':email', $user->email);

        if(!$statement->execute()) {
            return false;
        }

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result['password'] != $password) {
            return false;
        }

        $_SESSION['user_id'] = $result['id'];

        return true;
    }
}