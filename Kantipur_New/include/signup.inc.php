<?php

if(isset($_POST['signup-submit'])){

    $name = $_POST['username'];
    $email = $_POST['email'];
    $num = $_POST['tel'];
    $pass = $_POST['password'];
    $reward = 0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputSignup($name, $email, $pass) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if(invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }

    $conn =    $serverName = "localhost";
    $dbUsername = "sagwe";
    $dbPassword = "sagwe1";
    $dbName = "sql";

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    if(!$conn){
        die("Connection Failed:".mysqli_connect_error());
    };
    if(uidExists($conn, $email) !== false){
        header("location: ../signup.php?error=emailtaken");
        exit();
    }

    createUser($conn, $name, $email, $num, $pass, $reward);
}

else{
    header("location: ../signup.php");
    exit();
}