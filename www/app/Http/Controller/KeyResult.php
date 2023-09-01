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

        $this->getView('index', 'key-results', 'Adicionar Key Result', ['objectives' => $objectives]);
    }

    public function save(){
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST') {
            $title = $_POST['title'] ?: '';
            $objetiveId = $_POST['objective_id'] ?: '';
            $description = $_POST['description'] ?: '';
            $type = $_POST['type'] ?: '';

            $keyResultEntity = new KeyResultEntity();
            $keyResultEntity->setDescription($description);
            $keyResultEntity->setType($type);
            $keyResultEntity->setTitle($title);
            $keyResultEntity->setObjectiveId($objetiveId);

            (new KeyResultModel())->save($keyResultEntity);

            $this->sendJson([
                'result' => 'success',
            ]);
        }
    }
}