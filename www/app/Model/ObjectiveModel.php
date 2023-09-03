<?php

namespace App\Model;

use App\Entity\ObjectiveEntity;

/**
 * Objetive Model
 */
class ObjectiveModel extends Model
{
    /**
     * @param ObjectiveEntity $objective
     * @return bool
     */
    public function save(ObjectiveEntity $objective): bool
    {
        $statement = $this->getConn()->prepare("INSERT INTO objective (user_id, title, description) values (:user_id, :title, :description)");

        $statement->execute([
            ':user_id' => $objective->getUser(),
            ':title' =>  $objective->getTitle(),
            ':description' => $objective->getDescription(),
        ]);

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param int $userId
     * @return array|false
     */
    public function list(int $userId): array|false
    {
        $statement = $this->getConn()->prepare("SELECT * FROM objective WHERE objective.user_id = :user_id");
        $statement->bindParam(':user_id', $userId);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return bool|object
     */
    public function find(int $id): bool|object
    {
        $statement = $this->getConn()->prepare("SELECT title, description FROM objective WHERE objective.id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return reset($result);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function remove(int $id): bool
    {
        $statement = $this->getConn()->prepare("UPDATE objective SET deleted_at = NOW() WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        if ($statement->rowCount()) {
            return true;
        }

        return false;
    }

    /**
     * @param ObjectiveEntity $keyResultEntity
     * @param int $id
     * @return bool
     */
    public function update(ObjectiveEntity $keyResultEntity, int $id): bool
    {
        $statement = $this->getConn()->prepare("UPDATE objective SET title = :title, description = :description, updated_at = NOW() WHERE id = :id");

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