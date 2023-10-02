<?php
session_start();
//connect to sql databases
require_once "config.php";

if(!isset($_POST['username'], $_POST['password'])){
    exit("<!DOCTYPE HTML>
    <html lang=\"en\">
    <head>
    <title>
        Error
    </title>
    </head>
    <p>
        Please Fill in the Missing Sections
    </p>
    <p>
        <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
    </p>
    </html>");
}
$sql = 'SELECT username, hashpassword FROM users WHERE username=?';
$stmt = $con->prepare($sql);
if($stmt){
    $user = $_POST['username'];
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows() > 0){
        $stmt->bind_result($username, $hashpassword);
        $stmt->fetch();
        $pwd_guess = $_POST['password'];
        if(password_verify($pwd_guess, $hashpassword)){
            echo 'a';
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            $_SESSION['token'] = bin2hex(random_bytes(32));
            header("Location: registered_home.php");
        }
        else{
            echo 
            "<!DOCTYPE HTML>
            <html lang=\"en\">
            <head>
            <title>
                Error
            </title>
            </head>
            <p>
                Incorrect username/password
            </p>
            <p>
                <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
            </p>
            </html>";
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
            Incorrect username/password
        </p>
        <p>
            <INPUT TYPE=\"button\" VALUE=\"Return\" onClick=\"history.go(-1);\">
        </p>
        </html>";
    }
    $stmt->close();
}
?>