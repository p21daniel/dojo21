<?php

namespace App\Http\Controller;

use App\Util\Message;
use App\Util\Validator;

/**
 *  Abstract Controller responsible to centralize all common methods between controllers
 */
abstract class Controller
{
    /**
     * @var string
     */
    private $path = '../app/Views/';

    /**
     * Get a custom view based into name, folder and title
     *
     * @param $viewName
     * @param string $viewFolder
     * @param string $title
     * @param array $args
     * @return void
     */
    public function getView ($viewName, string $viewFolder = '', string $title = 'OKR', array $args = []): void
    {
        $args['title'] = $title;
        $viewStart = $this->path . 'base/start.phtml';
        $viewNavbar = $this->path . 'base/navbar.phtml';
        $viewModal = $this->path . 'base/modal.phtml';
        $viewBody = $this->path . $viewFolder . '/' . $viewName . '.phtml';
        $viewEnd = $this->path . 'base/end.phtml';

        if (!file_exists($viewStart) && file_exists($viewBody) && file_exists($viewEnd)) {
            $viewBody = $this->path . 'base/error.phtml';
        }

        include_once $viewStart;
        include_once $viewModal;
        include_once $viewBody;
        include_once $viewEnd;
    }

    /**
     * Base form data validation, for this task is used the validator class, a simple
     * class to store generic validations
     *
     * @param array $fields
     * @param bool $checkPassword
     * @return void
     */
    protected function baseFormCheck (Array $fields, bool $checkPassword = false): void
    {
        $messages = (new Validator())->isEmpty($fields);

        if ($checkPassword && !Validator::isSamePassword($fields['password'], $fields['password-check'])) {
            $messages[] = Message::NOT_EQUAL_PASSWORD;
        }

        if (count($messages) > 0) {
            $this->sendJson([
                'success' => false,
                'message' => $messages
            ]);
        }
    }

    /**
     * Send jSON to ajax calls
     *
     * @param $json
     * @return void
     */
    protected function sendJson ($json): void
    {
        echo json_encode($json);
        exit;
    }

    /**
     * @return void
     */
    protected function aclAuth(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /user');
            exit;
        }
    }

    /**
     * @return void
     */
    protected function aclAllowed(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
    }
}