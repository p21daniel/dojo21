<?php

namespace App\Http\Controller;

use App\Entity\ObjectiveEntity;
use App\Model\KeyResultModel;
use App\Model\ObjectiveModel;
use App\Usefull\Validator;

class Objective extends Controller
{
    public function index()
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

    public function save(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?: '';
            $description = $_POST['description'] ?: '';
            $id = $_POST['id'] ?: false;

            $messages = (new Validator())->isEmpty([
                'title' => $title,
                'description' => $description,
            ]);

            if (count($messages) > 0) {
                $this->sendJson([
                    'success' => false,
                    'message' => $messages
                ]);
            }

            $objective = new ObjectiveEntity();
            $objective->setUser($_SESSION['user_id']);
            $objective->setTitle($title);
            $objective->setDescription($description);

            if ($id) {
                if((new ObjectiveModel())->update($objective, $id)) {
                    $this->sendJson([
                        'result' => 'success',
                    ]);
                }

                $this->sendJson([
                    'result' => 'success',
                ]);

            }

            (new ObjectiveModel())->save($objective);

            $this->sendJson([
                'result' => 'success',
            ]);
        }
    }







    public function list()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $objectiveModel = new ObjectiveModel();
        $keyResultsModel = new KeyResultModel();

        $objectives = $objectiveModel->list($_SESSION['user_id']);

        $args = [
            'objectives' => $objectives,
            'keyResultsModel' => $keyResultsModel
        ];

        $this->getView('list', 'objectives', 'Meus objetivos', $args);
    }



    public function remove()
    {
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST' && isset($_POST['id']) && $_POST['id'] != '') {
            if ((new ObjectiveModel())->remove($_POST['id'])) {
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