<?php

namespace App\Http\Controller;

use Exception;

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
     * @param $viewFolder
     * @param $title
     * @return void
     */
    public function getView ($viewName, $viewFolder = '', $title = 'OKR') {
        $viewStart = $this->path . 'base/start.phtml';
        $viewBody = $this->path . $viewFolder . '/' . $viewName . '.phtml';
        $viewEnd = $this->path . 'base/end.phtml';

        try {
            if (file_exists($viewStart) && file_exists($viewBody) && file_exists($viewEnd)) {
                $_GET['title'] = $title;

                include_once $viewStart;
                include_once $viewBody;
                include_once $viewEnd;

                unset($_GET['title']);
            } else {
                throw new Exception("View not found");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
     * Send jSON to ajax calls
     *
     * @param $json
     * @return void
     */
    protected function sendJson ($json){
        echo json_encode($json);
        exit;
    }
}