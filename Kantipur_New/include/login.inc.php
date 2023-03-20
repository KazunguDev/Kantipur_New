<?php
/* If you're reading this, you're Stupid...*/
if(isset($_POST['login-submit'])){

    $email = $_POST['email'];
    $pass = $_POST['password'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($email, $pass) !== false){
        header("location: ../login.php?error=emptyinput");
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
    loginUser($conn, $email, $pass);
}

else{
    header("location: ../login.php");
    exit();
}