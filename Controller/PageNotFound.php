<?php

declare(strict_types=1);

namespace App\Check\Controller;

class PageNotFound extends AbstractController
{
    protected string $title = '404 Not Found';
    public function execute(): void
    {
        $this->renderView($_SERVER['REQUEST_URI']);
    }
}