<?php
if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

//Connexion
require  __DIR__ . '/../src/library/connexion.php';

$connexion = new Connexion();
$connexion->connect_db();

//Model
require __DIR__ . '/../src/library/model.php';
require __DIR__ . '/../src/model/user.php';

// Helpers
require __DIR__ . '/../src/tools/helpers.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
