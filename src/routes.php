<?php
// Routes

//Home
$app->get('/', function ($request, $response, $args) use($app){
    $args['title'] = "Accueil";
    $args['app'] = $app;
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

//Login
$app->get('/login', function ($request, $response, $args) use($app){
    $args['title'] = "login";
    return $this->renderer->render($response, 'login.phtml', $args);
})->setName('login');

//Signup
$app->get('/signup', function ($request, $response, $args) use($app){
    $args['title'] = "Signup";
    return $this->renderer->render($response, 'signup.phtml', $args);
})->setName('signup');
