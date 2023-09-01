<?php

namespace App\Http\Controller;

use App\Entity\ObjectiveEntity;
use App\Model\KeyResultModel;
use App\Model\ObjectiveModel;
use App\Model\UserModel;
use App\Http\Controller\Controller;

class Objective extends Controller
{
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

    public function save(){
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST') {
            $title = $_POST['title'] ?: '';
            $description = $_POST['description'] ?: '';

            $objective = new ObjectiveEntity();
            $objective->setUser($_SESSION['user_id']);
            $objective->setTitle($title);
            $objective->setDescription($description);

            (new ObjectiveModel())->save($objective);

            $this->sendJson([
                'result' => 'success',
            ]);
        }
    }
}