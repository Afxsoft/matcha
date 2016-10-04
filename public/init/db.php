<?php
$DB_HOST     = 'localhost';
$DB_DSN      = 'matcha';
$DB_USER     = 'root';
$DB_PASSWORD = 'root';
global $DBH;
try {
    $DBH = new PDO('mysql:host='. $DB_HOST .';dbname='.$DB_DSN, $DB_USER, $DB_PASSWORD);
} catch (PDOException $e) {
    $tab = explode('/', $_SERVER['REQUEST_URI']);
    $checker = 0;
    foreach ($tab as $value)
    {
        if ($value == 'setup.php')
            $checker++;
    }
    if (!$checker)
        setMessage('error', 'Connexion échouée : ' . $e->getMessage().' |_| Maybe go at ===> <a href="http://'.$_SERVER['HTTP_HOST'].'/'.$tab[1].'/config/setup.php">http://'.$_SERVER['HTTP_HOST'].'/'.$tab[1].'/config/setup.php</a>');
}
