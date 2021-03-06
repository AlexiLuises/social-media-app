<?php
// page to get content needed for profile page
session_start();
include_once 'database.php';
include_once 'functions.php';

// check to see if user is logged in (cant see profile pages without logging in)
if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
}

// Database query that retrieves all information about users to load profile pictures and so on
function getUsers($conn, $profileName)
{
    // We don't get the passwords because that would be awful for security
    $sql = "SELECT userFname, userLname, userUid, profilePicture, userGender, creationDate FROM users WHERE userUid = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=sql_error");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $profileName);
    mysqli_stmt_execute($stmt);
    $result_data = mysqli_stmt_get_result($stmt);

    //put all data in an assoc array
    $userData = array();

    while ($row = mysqli_fetch_assoc($result_data)) {
        $userData[] = $row;
    }
    return $userData;
    mysqli_stmt_close($stmt);
}
