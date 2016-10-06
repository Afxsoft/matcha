<?php

class User extends  Model{

    protected $table = "user";
    protected $primary = "id";

    public function __construct($cx) {
        parent::__construct($cx);
    }

    /**
     * @param $case
     * @return array
     */
    public function userFormat($case) {
        foreach ($_POST as $key => $value)
        {
            $_POST[$key] = htmlentities($value);
        }
        switch ($case) {
            case "add" :
                $user = array(
                    'state'		    => 1,
                    'email'		    => $_POST['email'],
                    'login'		    => $_POST['login'],
                    'firstName'	    => $_POST['firstName'],
                    'lastName'	    => $_POST['lastName'],
                    'password'		=> hash("whirlpool", $_POST['password']),
                );
                break;
            case "modify":
                $user = array(
                    'username'		=> $_POST['login'],
                    'password'		=> hash("whirlpool", $_POST['passwd']),
                    'mai'			=> $_POST['email'],
                );
                break ;
            case "delete":
                $user = array(
                    'login'			=> $_POST['login'],
                    'passwd'		=> hash("whirlpool", $_POST['passwd']),
                );
                break ;
            default:
                $user = array();
        }
        return ($user);
    }

    /**
     * @return bool
     */
    function signupCheck() {

        if ($_POST['login'] === "" || $_POST['password'] === "" || $_POST['email'] === "" || $_POST['firstName'] === "" || $_POST['lastName'] === "")
            return (false);
        elseif(!preg_match("/^[a-zA-Z][a-zA-Z0-9]*[._-]?[a-zA-Z0-9]+$/", $_POST['login'])){
            return (false);
        }
        elseif(!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $_POST['email'])){
            return (false);
        }
        return (true);
    }

    /**
     * This function try in the database if login pwd combinaison work
     * @param $DBH
     * @param $login
     * @param $passwd
     * @return bool
     */
    function auth($login, $passwd) {
        $passwd = hash("whirlpool", $passwd);
        $data   = $this->fetchAll("login= '$login'");
        if ($data[0]->login === htmlentities($login) && $data[0]->password === $passwd) {
            return (true);
        }
        return (false);
    }

    /***
     * This function check if is aleredy loggued
     * @return bool
     */
    function already_loggued() {
        if (isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] !== "") {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * This function allows you to login if not working retrun false
     * @param $DBH
     * @return bool
     */
    function login() {
        if ($_POST['login'] === "" || $_POST['password'] === "" || $this->auth($_POST['login'], $_POST['password']) === false) {
            $_SESSION['loggued_on_user'] = "";
            setMessage('error', 'No such account');
            return (false);
        }
        if ($this->already_loggued()) {
            setMessage('info', 'You are already loggued');
        } else {
            $_SESSION['loggued_on_user'] = $_POST['login'];
            setMessage('success', 'Successfully loggued');
        }
        return (true);
    }

    /**
     * This function destroy login session
     */
    function logout() {
        $_SESSION = [];
        setMessage('info', 'Successfully Logout');
        session_destroy();
    }

    /**
     * [TODO]
     * @param type $post
     * @param type $id
     * @return type
     */
    public function updateUser($post, $id) {
        return $this->update(array(
            "nickname" => $post['nickname'],
            "mail" => $post['mail'],
            "password" =>  $post['password'],
            "id_role" => $post['role'],
        ), 'id = ' . $id);
    }

    /**
     * addUser allows you to add a new user
     * @param type $post
     * @return type
     */
    public function addUser($post){

        if ($this->signupCheck() === false) {
            setMessage("error", "Creation of account failed, please check your informations");
            return (false);
        }

        $user = $this->userFormat('add');

        if (empty($this->insert($user))) {
            $login = $user['login'];
            $email = $user['email'];
            $userNameCheck  = $this->fetchAll("login= '$login'");
            $userMailCheck  = $this->fetchAll("email= '$email'");
            if (!empty($userNameCheck[0]))
                setMessage("error", "Username already used");
            elseif (!empty($userMailCheck[0]))
                setMessage("error", "Mail already used");
            return (false);
        } else {
            setMessage("success", "Account successfully created");
            sendMail($user['mail'], 'Creation de compte', "Bonjour ".$user['username'].",\n Votre compte a bien ete creer");
            return (true);
        }
    }

    /**
     * Get user by id
     * @param type $name
     * @return type
     */
    public function getUserByLogin($login){
        return $this->fetchAll("login= '$login'");
    }


    /**
     * [TODO]
     * @param type $mail
     * @return type
     */
    public function getUserByMail($mail){
        return $this->fetchAll("mail= '$mail' ");
    }
    /**
     * [TODO]
     * @param type $name
     * @param type $password
     */
    public function getUserLogin($login,$password){
        return $this->fetchAll("nickname='$login' and password='$password' ");
    }
}