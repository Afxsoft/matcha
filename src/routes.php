<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    $args['title'] = "Accueil - Matcha";

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('generique', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('/login', function ($request, $response, $args) {
    $args['title'] = "login - Matcha";
    return $this->renderer->render($response, 'login.phtml', $args);
});

$app->get('/signup', function ($request, $response, $args) {
    $args['title'] = "Inscription - Matcha";
    return $this->renderer->render($response, 'signup.phtml', $args);
});
