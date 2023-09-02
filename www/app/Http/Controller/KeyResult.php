<?php

namespace App\Http\Controller;

use App\Entity\KeyResultEntity;
use App\Model\KeyResultModel;
use App\Model\ObjectiveModel;

class KeyResult extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

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

    public function save(){
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST') {
            $title = $_POST['title'] ?: '';
            $objetiveId = $_POST['objective_id'] ?: '';
            $description = $_POST['description'] ?: '';
            $type = $_POST['type'] ?: '';
            $id = $_POST['id'] ?: false;

            $keyResultEntity = new KeyResultEntity();
            $keyResultEntity->setDescription($description);
            $keyResultEntity->setType($type);
            $keyResultEntity->setTitle($title);
            $keyResultEntity->setObjectiveId($objetiveId);

            if ($id) {
                (new KeyResultModel())->update($keyResultEntity, $id);

                $this->sendJson([
                    'result' => 'success',
                ]);
            }

            (new KeyResultModel())->save($keyResultEntity);

            $this->sendJson([
                'result' => 'success',
            ]);
        }
    }

    public function remove()
    {
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST' && isset($_POST['id']) && $_POST['id'] != '') {
            if ((new KeyResultModel())->remove($_POST['id'])) {
                $this->sendJson([
                    'result' => 'success'
                ]);
            }

            $this->sendJson([
                'result' => 'error'
            ]);
        }
    }

    public function edit()
    {
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST' && isset($_POST['id']) && $_POST['id'] != '') {
            $_SESSION['edit_id'] = $_POST['id'];

            $this->sendJson([
                'result' => 'success',
            ]);
        }
    }
}