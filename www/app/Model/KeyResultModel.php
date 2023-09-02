<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use App\Entity\KeyResultEntity;
use App\Entity\ObjectiveEntity;

class KeyResultModel
{
    public function save(KeyResultEntity $keyResultEntity){
        $pdoConnection = (new DatabaseConnection())->getConnection();

        /** @var $pdoConnection PDO */
        $statement = $pdoConnection->prepare("INSERT INTO key_result (objective_id, title, description, `type`) VALUES (:objective_id, :title, :description, :type)");
        $statement->execute([
            ':objective_id' => $keyResultEntity->getObjectiveId(),
            ':title' =>  $keyResultEntity->getTitle(),
            ':description' => $keyResultEntity->getDescription(),
            ':type' => $keyResultEntity->getType()
        ]);
    }

    public function list(int $objectiveId) {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("SELECT * FROM key_result WHERE key_result.objective_id = :objectiveId");
        $statement->bindParam(':objectiveId', $objectiveId);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listSpecificKeyResult(int $id) {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("SELECT title, objective_id AS objectiveID, description, type FROM key_result WHERE key_result.id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return reset($results);
    }

    public function listSemDeletados(int $objectiveId) {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("SELECT * FROM key_result WHERE key_result.objective_id = :objectiveId AND deleted_at IS NULL");
        $statement->bindParam(':objectiveId', $objectiveId);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function remove(int $id) {
        $pdoConnection = (new DatabaseConnection())->getConnection();

        $statement = $pdoConnection->prepare("UPDATE key_result SET deleted_at = NOW() WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        if ($statement->rowCount()) {
            return true;
        }

        return false;
    }

    public function update(KeyResultEntity $keyResultEntity, int $id) {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("UPDATE key_result SET objective_id = :objective_id, title = :title, description = :description, `type` = :type, updated_at = NOW() WHERE id = :id");

        $statement->execute([
            ':objective_id' => $keyResultEntity->getObjectiveId(),
            ':title' =>  $keyResultEntity->getTitle(),
            ':description' => $keyResultEntity->getDescription(),
            ':type' => $keyResultEntity->getType(),
            ':id' => $id
        ]);

        if ($statement->rowCount()) {
            return true;
        }

        return false;
    }
}