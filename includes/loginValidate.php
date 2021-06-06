<?php
// page to validate login
// checking to see if user got to this page correctly (checking post for Username and password)
if (isset($_POST["submit"])) {

    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    // reference database and functions files
    require_once 'database.php';
    require_once 'functions.php';

    // error handling, if they did not log in using username/pass, send them back to login
    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    // if it all checks out, log in user, if not, send them back to login.php
    loginUser($conn, $username, $pwd);
} else {
    header("Location: ../login.php");
    exit();
}
