<?php

namespace App\Http\Controller;

use App\Entity\ObjectiveEntity;
use App\Model\KeyResultModel;
use App\Model\ObjectiveModel;
use App\Util\Message;

/**
 * Objective Controller
 */
class Objective extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->aclAllowed();
        $oldDataToUpdate = null;

        if (isset($_SESSION['edit_id'])) {
            $oldDataToUpdate = (new ObjectiveModel())->find($_SESSION['edit_id']);
            $oldDataToUpdate['id'] = $_SESSION['edit_id'];

            unset($_SESSION['edit_id']);
        }

        $args = [
            'oldData' => $oldDataToUpdate
        ];

        $this->getView('index', 'objectives', 'O que é OKR?', $args);
    }

    /**
     * @return void
     */
    public function list(): void
    {
        $this->aclAllowed();

        $objectiveModel = new ObjectiveModel();
        $keyResultsModel = new KeyResultModel();

        $objectives = $objectiveModel->list($_SESSION['user_id']);

        $args = [
            'objectives' => $objectives,
            'keyResultsModel' => $keyResultsModel
        ];

        $this->getView('list', 'objectives', 'Meus objetivos', $args);
    }

    /**
     * @return void
     */
    public function save(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?: '';
            $description = $_POST['description'] ?: '';
            $id = $_POST['id'] ?: false;

            $this->baseFormCheck([
                'title' => $title,
                'description' => $description
            ]);

            $objective = new ObjectiveEntity();
            $objective->setUser($_SESSION['user_id']);
            $objective->setTitle($title);
            $objective->setDescription($description);

            $this->update($id, $objective);

            if ((new ObjectiveModel())->save($objective)) {
                $_SESSION['flash'] = Message::OBJECTIVE_SAVED;

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
     * @param ObjectiveEntity $objective
     * @return void
     */
    public function update(mixed $id, ObjectiveEntity $objective): void
    {
        if (!$id) {
            return;
        }

        if ((new ObjectiveModel())->update($objective, $id)) {
            $_SESSION['flash'] = Message::OBJECTIVE_EDITED;

            $this->sendJson([
                'success' => true,
            ]);
        }

        $this->sendJson([
            'success' => false,
            'message' => Message::OBJECTIVE_SAVE_ERROR
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
        $id = $_POST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($id) && $id != '') {
            $lista = (new KeyResultModel())->findNotDeleted($id);

            if (count($lista)) {
                $this->sendJson([
                    'success' => false,
                    'message' => Message::OBJECTIVE_CONSTRAINT
                ]);
            }

            if ((new ObjectiveModel())->remove($id)) {
                $_SESSION['flash'] = Message::OBJECTIVE_REMOVED;

                $this->sendJson([
                    'success' => true
                ]);
            }

            $this->sendJson([
                'success' => false
            ]);
        }
    }
}