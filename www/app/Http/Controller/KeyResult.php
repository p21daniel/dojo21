<?php

namespace App\Http\Controller;

use App\Entity\KeyResultEntity;
use App\Model\KeyResultModel;
use App\Model\ObjectiveModel;

/**
 * KeyResult Controller
 */
class KeyResult extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->aclAllowed();

        $objectiveModel = new ObjectiveModel();
        $objectives = $objectiveModel->list($_SESSION['user_id']);
        $oldDataToUpdate = null;

        if (isset($_SESSION['edit_id'])) {
            $oldDataToUpdate = (new KeyResultModel())->listSpecificKeyResult($_SESSION['edit_id']);
            $oldDataToUpdate['id'] = $_SESSION['edit_id'];

            unset($_SESSION['edit_id']);
        }

        $args = [
            'objectives' => $objectives,
            'oldData' => $oldDataToUpdate
        ];

        $this->getView('index', 'key-results', 'Adicionar Key Result', $args);
    }

    /**
     * @return void
     */
    public function save(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?: '';
            $objetiveId = $_POST['objective_id'] ?: '';
            $description = $_POST['description'] ?: '';
            $type = $_POST['type'] ?: '';
            $id = $_POST['id'] ?: false;

            $this->baseFormCheck([
                'title' => $title,
                'description' => $description,
                'objective_id' => $objetiveId,
                'type' => $type,
            ]);

            $keyResultEntity = new KeyResultEntity();
            $keyResultEntity->setDescription($description);
            $keyResultEntity->setType($type);
            $keyResultEntity->setTitle($title);
            $keyResultEntity->setObjectiveId($objetiveId);

            $this->update($id, $keyResultEntity);

            if((new KeyResultModel())->save($keyResultEntity)){
                $this->sendJson([
                    'success' => true,
                ]);
            }

            $this->sendJson([
                'success' => false,
            ]);
        }
    }

    /**
     * @param mixed $id
     * @param KeyResultEntity $keyResult
     * @return void
     */
    public function update(mixed $id, KeyResultEntity $keyResult): void
    {
        if (!$id) {
            return;
        }

        if ((new KeyResultModel())->update($keyResult, $id)) {
            $this->sendJson([
                'success' => true,
            ]);
        }

        $this->sendJson([
            'success' => false,
            'message' => 'Ocorreu um problema ao atualizar o resultado chave'
        ]);
    }

    /**
     * @return void
     */
    public function edit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['id'] != '') {
            $_SESSION['edit_id'] = $_POST['id'];

            $this->sendJson([
                'success' => true,
            ]);
        }
    }

    /**
     * @return void
     */
    public function remove(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['id'] != '') {
            if ((new KeyResultModel())->remove($_POST['id'])) {
                $this->sendJson([
                    'success' => true,
                ]);
            }

            $this->sendJson([
                'success' => false,
            ]);
        }
    }
}