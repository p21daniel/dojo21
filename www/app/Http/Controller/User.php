<?php

namespace App\Http\Controller;

use App\Model\UserModel;

/**
 * User Controller
 */
class User extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->aclAllowed();
        $this->getView('index', 'home', 'O que é OKR?');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->aclAuth();
        $this->getView('register', 'auth', 'Cadastrar');
    }

    /**
     * @return void
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messages = [];

            $email = $_POST['email'] ?: '';
            $password = $_POST['password'] ?: '';

            $this->baseFormCheck([
                'email' => $email,
                'password' => $password
            ]);
        }

        $user = new \App\Entity\User();
        $user->email = $email;
        $user->password = $password;

        $userModel = new UserModel();

        if ($userModel->authenticate($user)) {
            $this->sendJson([
                'success' => true,
            ]);
        }

        session_destroy();

        $this->sendJson([
            'success' => false,
            'message' => 'O e-mail ou senha informados são inválidos'
        ]);
    }

    /**
     * @return void
     */
    public function logout()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();

            header('Location: /');
            exit;
        }
    }

    /**
     * @return void
     */
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messages = [];

            $name =  $_POST['name'] ?: '';
            $email = $_POST['email'] ?: '';
            $password =  $_POST['password'] ?: '';
            $passwordCheck =  $_POST['password-check'] ?: '';

            $this->baseFormCheck([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password-check' => $passwordCheck
            ], true);

            if((new UserModel())->save($name, $email, $password)) {
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