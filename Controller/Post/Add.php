<?php

declare(strict_types=1);

namespace App\Check\Controller\Post;

use App\Check\Controller\AbstractController;

class Add extends AbstractController
{

    public function execute(): void
    {
        $this->renderView($_SERVER['REQUEST_URI']);
    }
}