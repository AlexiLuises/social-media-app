<?php

// checking to see if there is any empty input submitted when signing up
function emptyInputSignup($name,$surname,$email,$username,$pwd,$pwdRepeat,$gender,$phone){
    $result = NULL;
    if (empty($name) || empty($surname) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat) || empty($gender) || empty($phone)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}


function invalidUid($username){
    $result=NULL;
    // Regex to allow a-z, A-Z and 0-9 for a user name but no special characters
   if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// uses validate email built in function to validate an email entry
function invalidEmail($email){
    $result=NULL;

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}
function invalidPhone($phone){
    $result = null;
        // Regex to allow digits 0-9, exactly 11 times (uk phone number like 07912112189)
   if (!preg_match("/^(\d{11})$/", $phone)){
    $result = true;
}
else {
    $result = false;
}
return $result;
}

function invalidGender($gender){
    $result=null;
    // Regex to allow a-z, A-Z as well as - for gender
   if (!preg_match("/^[a-zA-Z-]{0,14}$/", $gender)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;

}


// simple check to compare password to repeated password
function pwdMatch($pwd,$pwdRepeat){
    $result=NULL;

    if (!$pwd == $pwdRepeat){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}


function uidExists($conn,$username,$email,$phone){
    // ? is placeholder for userUid and userEmail
   $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ? OR userPhone = ?;";
   $stmt = mysqli_stmt_init($conn);

    //if the sql orconnection fail to work, get a statement failed error
   if (!mysqli_stmt_prepare($stmt,$sql)) {
    header("location: ../signup.php?error=statementfailed");
    exit();
   }
   //binds database connection, username,email and phone number (ss = string string) and then executes the statement
   mysqli_stmt_bind_param($stmt, "sss",$username,$email,$phone);
   mysqli_stmt_execute($stmt);
   $resultData = mysqli_stmt_get_result($stmt);

    //associative array, doesnt use index numbers but rather column names
   if ($row = mysqli_fetch_assoc($resultData)) {
       return $row;
   }
   else {
       $result = false;
       return $result;
   }
   mysqli_stmt_close($stmt);
}

function createUser($conn,$name,$surname,$email,$username,$pwd,$gender,$phone){
    // ? placeholders for user first name,user Last name,userEmail,userUid,userPWD, user gender an user phone number
    $sql = "INSERT INTO users (userFname,userLname,userEmail,userUid,userPwd,userGender,userPhone) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
     header("location: ../signup.php?error=statementfailed");
     exit();
    }
    // password hashing builtin function
    $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss",$name,$surname,$email,$username,$hashedPwd,$gender,$phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
     exit();
 }

// checks to see if theres any empty input in the login screen
 function emptyInputLogin($username,$pwd){
    $result = NULL;
    if (empty($username) || empty($pwd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

    function loginUser($conn,$username,$pwd){
        // uidExists takes takes Username or email, so if I put username thrice, it will just fill in email and phone number as username, means they can log in with username or email
        $uidExists = uidExists($conn,$username,$username,$username);
        // checking to see if username exists in the database
        if ($uidExists === false){
            header("Location: ../login.php?error=wronglogin");
            exit();
        }
        // referencing column-name
        $pwdHashed = $uidExists["userPwd"];
        // if password given and hashed pwd match, returns true, if they dont, returns false
        $checkPwd = password_verify($pwd, $pwdHashed);

        if ($checkPwd === false) {
            header("Location: ../login.php?error=wronglogin");
            exit();
        }
        else if ($checkPwd === true){
            session_start();
            // starts a session if login succesful
            $_SESSION["userid"] = $uidExists["userId"];
            $_SESSION["useruid"] = $uidExists["userUid"];
            header("Location: ../index.php");
            exit();
        }
    }


