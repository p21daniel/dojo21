<?php

namespace App\Model;

use App\Entity\User;

/**
 * User Model
 */
class UserModel extends Model
{
    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        $password = md5($user->getPassword());

        $statement = $this->getConn()->prepare("INSERT INTO user (name, email, password) values (:name, :email, :password)");

        $statement->execute([
            ':name' => $user->getName(),
            ':email' =>  $user->getEmail(),
            ':password' => $password,
        ]);

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function authenticate(User $user): bool
    {
        $password = md5($user->password);

        $statement = $this->getConn()->prepare("SELECT * FROM user WHERE email = :email");
        $statement->bindParam(':email', $user->email);

        if(!$statement->execute()) {
            return false;
        }

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$result || $result['password'] != $password) {
            return false;
        }

        $_SESSION['user_id'] = $result['id'];

        return true;
    }
}