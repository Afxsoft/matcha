<?php

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec(file_get_contents('database.sql'));
    echo "Database created successfully<br><a href='../index.php'>Back to home</a>";
    $_SESSION['database'] = true;
}
catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
    $_SESSION['database'] = null;
    unset($_SESSION['database']);
    session_destroy();
}