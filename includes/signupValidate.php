<?php

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'database.php';
    require_once 'functions.php';

    if (emptyInputSignup($name,$surname,$email,$username,$gender,$phone,$pwd,$pwdRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=inavlidemail");
        exit();
    }
    if (invalidPhone($phone) !== false) {
        header("location: ../signup.php?error=inavlidphonenumber");
    }
    if (invalidGender($gender) !== false) {
        header("location: ../signup.php?error=inavlidgender");
    }

    if (pwdMatch($pwd,$pwdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uidExists($conn,$username,$email,$phone) !== false) {
        header("location: ../signup.php?error=usernameoremailorphonenumbertaken");
        exit();
    }
    createUser($conn,$name,$surname,$email,$username,$pwd,$gender,$phone);
}
else{
    header("location: ../signup.php");
    exit();
}