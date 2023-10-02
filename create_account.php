<?php
session_start();
require_once "config.php";
$username = $password ='';
$username2 = $password2 = "";

if($_SERVER["REQUEST_METHOD"] =="POST"){
    if(empty(trim($_POST["username"]))){
        $username2 = 'Please enter a username';
        echo "<!DOCTYPE HTML>
                <html lang=\"en\">
                <head>
                <title>
                    Error
                </title>
                </head>
                <p>
                    Please enter a username
                </p>
                <p>
                    <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
                </p>";
    }
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username2 = "Please enter a valid username";
        echo
        "<!DOCTYPE HTML>
        <html lang=\"en\">
        <head>
        <title>
            Error
        </title>
        </head>
        <p>
            Invalid username (please only put letters, numbers, and underscores);
        </p>
        <p>
            <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
        </p>";
    }
    else{
        $sql = "SELECT hashpassword FROM users WHERE username = ?";
        $stmt = $con->prepare($sql);
        if($stmt){
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if($stmt->execute()){
                $stmt->store_result();
                //checks if username exists
                if($stmt->num_rows() ==1){
                    $username2 = "username taken";
                    echo "<!DOCTYPE HTML>
                        <html lang=\"en\">
                        <head>
                        <title>
                            Error
                        </title>
                        </head>
                        <p>
                            Username is taken, please choose another
                        </p>
                        <p>
                            <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
                        </p>";
                }
                else{
                    $username = trim($_POST["username"]);
                }
            }
            else{
                echo "<!DOCTYPE HTML>
                        <html lang=\"en\">
                        <head>
                        <title>
                            Error
                        </title>
                        </head>
                        <p>
                            Error, Please Try Again
                        </p>
                        <p>
                            <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
                        </p>";
            }
            $stmt -> close();
        }
    }
    if(empty(trim($_POST["password"]))){
        $password2 = "please enter a password";
        echo "<!DOCTYPE HTML>
                <html lang=\"en\">
                <head>
                <title>
                    Error
                </title>
                </head>
                <p>
                    Please Enter a Password
                </p>
                <p>
                    <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
                </p>";
    }
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["password"]))){
        $username2 = "Please enter a valid username";
        echo
        "<!DOCTYPE HTML>
        <html lang=\"en\">
        <head>
        <title>
            Error
        </title>
        </head>
        <p>
            Invalid password (please only put letters, numbers, and underscores);
        </p>
        <p>
            <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
        </p>";
    }
    else{
        $password = trim($_POST["password"]);
    }
    if(empty($username2) && empty($password2)){
        $sql= "INSERT INTO users (username, hashpassword) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        if($stmt){
            $stmt->bind_param("ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_BCRYPT);
            if($stmt->execute()){
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $param_username;
                header("Location: registered_home.php");
                exit;
            }
            else{
                echo "Please Try Again";
            }
            $stmt->close();
        }
    }
    $con->close();
}
?>