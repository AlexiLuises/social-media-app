<?php
// page for name changing functionality (first and last name)
session_start();
include_once 'database.php';
include_once 'functions.php';



if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
    exit();
}




// if this exists, it means the user is logged in
if (isset($_POST["submit"])) {
    $userId = $_SESSION["userid"];
    $newFirstName = $_POST["newFirstName"];
    $newLastName = $_POST["newLastName"];
    $profileName = $_POST["profileName"];
}

// function to update name based on uid and form in profile.php
function updateName($conn, $newFirstName, $newLastName, $profileName)
{
    // ? placeholders for first name, last name and userId
    $sql = "UPDATE users SET userFname = ?, userLname = ? WHERE userUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $newFirstName, $newLastName, $profileName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?nameChanged");
}
updateName($conn, $newFirstName, $newLastName, $profileName);
