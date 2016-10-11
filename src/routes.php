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
$app->post('/login', function ($request, $response, $args) use ($connexion, $app){
    $args['title'] = "Login";
    $args['app']   = $app;
    $user = new User($connexion->get_cx());
    $user->login($_POST);
    return $response->withStatus(302)->withHeader('Location', 'profile/'.$_POST['login']);
});

//logout
$app->get('/logout', function ($request, $response, $args) use($connexion, $app){
    $args['title'] = "logout";
    $args['app']   = $app;
    $user = new User($connexion->get_cx());
    $user->logout();
    return $this->renderer->render($response, 'index.phtml', $args);
})->setName('logout');


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
    return $response->withStatus(302)->withHeader('Location', 'login');
})->setName('signup');

//Profile
$app->get('/profile/{login}', function($resquest, $response, $args) use($connexion, $app){

    $args['title'] = "Profile";
    $args['app']   = $app;
    $user = new User($connexion->get_cx());
    $userInfo = $user->getUserByLogin($args['login']);
    if(!empty($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] == $userInfo[0]->login){
        $args['user'] = $userInfo[0];
        return $this->renderer->render($response, 'profile.phtml', $args);
    }
    else{
        setMessage('error', 'Access denied');
        return $response->withStatus(302)->withHeader('Location', '/');
    }
})->setName('profile');
$app->post('/profile', function($resquest, $response, $args) use($connexion, $app){

    $args['title'] = "Profile";
    $args['app']   = $app;

    $user = new User($connexion->get_cx());
    $user->updateUser();

    return $response->withStatus(302)->withHeader('Location', 'profile/'.$_POST['login']);
})->setName('profileUpdate');

$app->get('/list', function ($request, $response, $args) use($connexion, $app){
    $args['title'] = "Found your love";
    $args['app']   = $app;
    $user = new User($connexion->get_cx());
    $args['users'] = $user->getAllUser();
    return $this->renderer->render($response, 'list.phtml', $args);
})->setName('list');