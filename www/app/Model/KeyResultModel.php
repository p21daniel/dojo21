<?php

namespace App\Model;

use App\Entity\DatabaseConnection;
use App\Entity\KeyResultEntity;

/**
 * KeyResult Model
 */
class KeyResultModel extends Model
{
    /**
     * @param KeyResultEntity $keyResultEntity
     * @return bool
     */
    public function save(KeyResultEntity $keyResultEntity): bool
    {
        $statement = $this->getConn()->prepare("INSERT INTO key_result (objective_id, title, description, `type`) VALUES (:objective_id, :title, :description, :type)");

        $statement->execute([
            ':objective_id' => $keyResultEntity->getObjectiveId(),
            ':title' =>  $keyResultEntity->getTitle(),
            ':description' => $keyResultEntity->getDescription(),
            ':type' => $keyResultEntity->getType()
        ]);

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param int $objectiveId
     * @return array|bool
     */
    public function list(int $objectiveId): array|bool
    {
        $statement = $this->getConn()->prepare("SELECT * FROM key_result WHERE key_result.objective_id = :objectiveId");
        $statement->bindParam(':objectiveId', $objectiveId);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function listSpecificKeyResult(int $id): bool|array
    {
        $statement = $this->getConn()->prepare("SELECT title, objective_id AS objectiveID, description, type FROM key_result WHERE key_result.id = :id");
        $statement->bindParam(':id', $id);

        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return reset($results);
    }

    /**
     * @param int $objectiveId
     * @return array|bool
     */
    public function findNotDeleted(int $objectiveId): array|bool
    {
        $pdoConnection = (new DatabaseConnection())->getConnection();
        $statement = $pdoConnection->prepare("SELECT * FROM key_result WHERE key_result.objective_id = :objectiveId AND deleted_at IS NULL");
        $statement->bindParam(':objectiveId', $objectiveId);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function remove(int $id): bool
    {
        $statement = $this->getConn()->prepare("UPDATE key_result SET deleted_at = NOW() WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        if ($statement->rowCount()) {
            return true;
        }

        return false;
    }

    /**
     * @param KeyResultEntity $keyResultEntity
     * @param int $id
     * @return bool
     */
    public function update(KeyResultEntity $keyResultEntity, int $id): bool
    {
        $statement = $this->getConn()->prepare("UPDATE key_result SET objective_id = :objective_id, title = :title, description = :description, `type` = :type, updated_at = NOW() WHERE id = :id");

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