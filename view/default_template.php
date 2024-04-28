<?php

use App\Check\Controller\AbstractController;

/**
 * @var $this AbstractController
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/style.css">
    <title><?= $this->getTitle() ?></title>
</head>
<body>
<div class="container">
    <header>
        <div class="header">
            <div class="logo">
                <a href="/">Logo</a>
            </div>
            <div class="user-container">
                <?php if (!$this->isLoggedIn()): ?>
                    <div class="login-form">
                        <form action="/user/log_in" method="POST">
                            <input type="email" required maxlength="255" name="email" placeholder="Email:"/>
                            <input type="password" required maxlength="255" name="password" placeholder="Password:"/>
                            <button type="submit">Log In</button>
                        </form>
                        <?= $this->messages['message'] ?? '' ?>
                    </div>
                <?php else: ?>
                    <div class="logged-in">
                        <p>User: <?= $_SESSION['email'] ?></p>
                        <p><?= $this->messages['message'] ?? '' ?></p>
                        <p><a href="/user/log_out">Log out</a></p>
                        <p><a href="/post/add">Add new post</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <?= $this->getContent() ?>
</div>
</body>
</html>