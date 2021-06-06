<?php
// page to validate the sign up procedure
// seting all variables needed from fields inputted via a form
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $creationDate = date("jS M Y");
    date_default_timezone_set('GB');


    require_once 'database.php';
    require_once 'functions.php';
    // checking to make sure input is not empty or invalid, using functions from functions.php
    if (emptyInputSignup($name, $surname, $email, $username, $gender, $phone, $pwd, $pwdRepeat) !== false) {
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

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uidExists($conn, $username, $email, $phone) !== false) {
        header("location: ../signup.php?error=usernameoremailorphonenumbertaken");
        exit();
    }
    // if all is ok, call createUser function
    createUser($conn, $name, $surname, $email, $username, $pwd, $gender, $phone, $creationDate);
} else {
    header("location: ../signup.php");
    exit();
}
