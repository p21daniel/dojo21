<?php

namespace App\Http\Controller;

/**
 * Main base controller responsible to login view and error view
 *
 */
class Index extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        $this->aclAuth();
        $this->getView('login', 'auth', 'Faça seu Login');
    }

    /**
     * @return void
     */
    public function fail(): void
    {
        http_response_code(404);
        $this->getView('error', 'base', 'Ops...');
    }
}