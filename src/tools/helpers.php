<?php
/**
 * Created by PhpStorm.
 * User: aouloube
 * Date: 10/4/16
 * Time: 5:08 PM
 */

/**
 * This funciton return the url of route name
 * @param $app
 * @param string $path
 * @param array $param
 * @return mixed
 */
function path($app, $path = '', $param = array()){
    return $app->getContainer()->get('router')->pathFor($path, $param);
}

/**
 * This function render string with htmlentities traitement
 * @param string $string
 */
function render($string = '')
{
    echo htmlentities($string);
}

/**
 * setMessage allows you to put a main message
 * @param $type (info|error|success)
 * @param $msg
 * @return string
 */
function setMessage($type, $msg){
    $message = "";
    switch ($type)
    {
        case 'info':
            $message = "<div class=\"message_top  info\"><div class=\"center\">$msg</div></div>";
            break;
        case 'error':
            $message = "<div class=\"message_top  error\"><div class=\"center\">$msg</div></div>";
            break;
        case 'success':
            $message = "<div class=\"message_top  success\"><div class=\"center\">$msg</div></div>";
            break;
    }
    $_SESSION['MAIN_MESSAGE'] = $message;
}

/**
 * sendmail allows you to send mail
 * @param $to
 * @param $subject
 * @param $message
 */
function sendMail($to, $subject, $message){
    $headers = 'From: Matcha' . "\r\n" .
        'Reply-To: Matcha' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}


function dump($var){
    echo '<pre>';
    var_dump($var);
    die;
}