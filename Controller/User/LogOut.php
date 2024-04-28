<?php

declare(strict_types=1);

namespace App\Check\Controller\User;

use App\Check\Controller\AbstractController;

class LogOut extends AbstractController
{
    public function execute(): void
    {
        $session = $this->getSession();

        unset($session['email'], $session['logged_in'], $session['login_error']);
        $this->session = $session;

        session_destroy();
        header('Location: /');
    }
}