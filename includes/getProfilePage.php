<?php
session_start();
require 'database.php';
require 'functions.php';

if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
}

// Database query that retrieves all information about users to load profile pictures and so on
function fetch_users($conn, $username){
    // We don't get the passwords because that would be awful for security
    $sql = "SELECT userFname, userLname, usersUid, profilePicture FROM users WHERE usersUid = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../feed/?error=sql_error");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);
    // Create array for posts
    $users = array();

    while($row = mysqli_fetch_assoc($result_data)){
        // Add posts to array
        $users[] = $row;
    }

     return $users;
    // Close the connection
    mysqli_stmt_close($stmt);
    // We normally redirect but this is going to be running in the background
}