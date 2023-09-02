<?php

namespace App\Http\Controller;

use App\Model\ObjectiveModel;
use App\Model\UserModel;
use App\Http\Controller\Controller;

class User extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $oldDataToUpdate = null;

        if (isset($_SESSION['edit_id'])) {
            $oldDataToUpdate = (new ObjectiveModel())->list2($_SESSION['edit_id']);
            $oldDataToUpdate['id'] = $_SESSION['edit_id'];

            unset($_SESSION['edit_id']);
        }

        $args = [
            'oldData' => $oldDataToUpdate
        ];

        $this->getView('index', 'home', 'O que é OKR?', $args);
    }

    public function register()
    {
        $this->getView('register', 'auth', 'Cadastrar');
    }

    public function save(){
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST') {
            $name = $_POST['name'] ?: '';
            $email = $_POST['email'] ?: '';
            $password = $_POST['password'] ?: '';

            if(empty($name)) {
                $this->sendJson([
                    'result' => 'error',
                    'message' => 'Invalid name'
                ]);
            }

            (new UserModel())->save($name, $email, $password);

            $this->sendJson([
                'result' => 'success',
            ]);
        }
    }

    public function login()
    {
        $isPost = $_SERVER['REQUEST_METHOD'];

        if ($isPost === 'POST') {
            $email = $_POST['email'] ?: '';
            $password = $_POST['password'] ?: '';

            if (!$email || !$password) {
                $this->sendJson([
                    'result' => 'error',
                    'message' => 'Usuário ou senha inválidos'
                ]);
            }
        }

        $user = new \App\Entity\User();
        $user->email = $email;
        $user->password = $password;

        $userModel = new UserModel();

        if ($userModel->authenticate($user)) {
            $this->sendJson([
                'result' => 'success',
            ]);
        }

        session_destroy();
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();

            header('Location: /');
            exit;
        }
    }
}