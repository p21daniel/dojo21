<?php

namespace App\Entity;

/**
 * KeyResult Entity
 */
class KeyResultEntity extends Entity
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var int
     */
    private int $objectiveId;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getObjectiveId(): int
    {
        return $this->objectiveId;
    }

    /**
     * @param int $objectiveId
     */
    public function setObjectiveId(int $objectiveId): void
    {
        $this->objectiveId = $objectiveId;
    }
}