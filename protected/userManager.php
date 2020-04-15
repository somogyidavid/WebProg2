<?php
    function IsUserLoggedIn(){
        //die(var_dump($_SESSION));
        return $_SESSION != null && array_key_exists('uid',$_SESSION) && is_numeric($_SESSION['uid']);
    }

    function UserLogOut(){
        session_unset();
        session_destroy();
        header('Location: index.php');
    }

    function UserLogin($email,$password){
        $query = "SELECT id, first_name, last_name, email, permission FROM users WHERE email = :email AND password = :password";
        $params = [
            ':email' => $email,
            ':password' => sha1($password)
        ];

        require_once DATABASE_CONTROLLER;
        $record = getRecord($query,$params);
        if(!empty($record)){
            $_SESSION['uid'] = $record['id'];
            $_SESSION['fname'] = $record['first_name'];
            $_SESSION['lname'] = $record['last_name'];
            $_SESSION['email'] = $record['email'];
            $_SESSION['permission'] = $record['permission'];
            
            return true;
        }
        return false;
    }
    
    function UserRegister($email, $password, $fname, $lname){
        $query = "SELECT id FROM users email = :email";
        $params = [ ':email' => $email];

        require_once DATABASE_CONTROLLER;
        $record = getRecord($query,$params);
        if(empty($record)){
            $query = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
            $params = [
                ':first_name' => $fname,
                ':last_name' => $lname,
                ':email' => $email,
                ':password' => sha1($password)
            ];

            if(executeDML($query, $params))
                return true;
        }
        return false;
    }
?>