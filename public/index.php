<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Gounsch\Controller;
use Gounsch\Files;

$app = require dirname(__DIR__).'/app/app.php';

if ('POST' === strtoupper($_SERVER['REQUEST_METHOD'])) {
    switch ($_GET['action']) {
        case 'login':
            $_SESSION['user'] = Controller::login($_POST);
            break; // break isn't technically needed, but doesn't hurt either
        case 'upload':
            $_FILES['file']['name'] = $_POST['filename'] ?: $_FILES['file']['name'];

            try {
                Controller::uploadFile($app['files'], $_FILES['file']);
            } catch (\InvalidArgumentException $exception) {
                $_GET['action'] = 'edit';
                $_GET['error'] = $exception->getMessage();
            }

            break; // break isn't technically needed, but doesn't hurt either
        case 'delete':
            Controller::deleteFile($app['files'], $_POST['filename']);
    };

    if (!isset($_GET['error'])) {
        Controller::home();
    }
}

if ('preview' === $_GET['action']) {
    Controller::preview(new finfo(\FILEINFO_MIME_TYPE), $app['files'], $_GET['filename']);
}

echo $app['view']->render(dirname(__DIR__)."/templates/base.php", $_GET + $app);

