<?php
// Routes

//Home
$app->get('/', function ($request, $response, $args) use($app){
    $args['title'] = "Accueil";
    $args['app']   = $app;
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('home');

//Login
$app->get('/login', function ($request, $response, $args) use($app){
    $args['title'] = "login";
    $args['app']   = $app;
    return $this->renderer->render($response, 'login.phtml', $args);
})->setName('login');

//Signup
$app->get('/signup', function ($request, $response, $args) use($app){
    $args['title'] = "Signup";
    $args['app']   = $app;
    return $this->renderer->render($response, 'signup.phtml', $args);
})->setName('signup');
$app->post('/signup', function ($request, $response, $args) use($connexion, $app){
    $args['title'] = "Signup";
    $args['app']   = $app;
    $user = new User($connexion->get_cx());
    $user->addUser($_POST);
    return $this->renderer->render($response, 'signup.phtml', $args);
})->setName('signup');

//User
$app->get('/profil/{login}', function($resquest, $response, $args) use($connexion, $app){
    $user = new User($connexion->get_cx());
    dump($user->getUserByLogin($args['login']));
});