<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use App\Entity\ObjectiveEntity;

class ObjectiveModel extends Model
{
    public function save(ObjectiveEntity $objective){
        $pdoConnection = (new DatabaseConnection())->getConnection();

        /** @var $pdoConnection PDO */
        $statement = $pdoConnection->prepare("INSERT INTO objective (user_id, title, description) values (:user_id, :title, :description)");
        $statement->execute([
            ':user_id' => $objective->getUser(),
            ':title' =>  $objective->getTitle(),
            ':description' => $objective->getDescription(),
        ]);
    }

    public function list(int $userId) {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("SELECT * FROM objective WHERE objective.user_id = :user_id");
        $statement->bindParam(':user_id', $userId);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id) {
        $statement = $this->getConn()->prepare("SELECT title, description FROM objective WHERE objective.id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return reset($result);
    }

    public function remove(int $id) {
        $pdoConnection = (new DatabaseConnection())->getConnection();

        $lista = (new KeyResultModel())->listSemDeletados($id);

        if (count($lista)) {
            return false;
        }

        $statement = $pdoConnection->prepare("UPDATE objective SET deleted_at = NOW() WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        if ($statement->rowCount()) {
            return true;
        }

        return false;
    }

    public function update(ObjectiveEntity $keyResultEntity, int $id) {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("UPDATE objective SET title = :title, description = :description, updated_at = NOW() WHERE id = :id");

        $statement->execute([
            ':title' =>  $keyResultEntity->getTitle(),
            ':description' => $keyResultEntity->getDescription(),
            ':id' => $id
        ]);

        if ($statement->rowCount()) {
            return true;
        }

        return false;
    }
}