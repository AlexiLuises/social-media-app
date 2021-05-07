<?php
session_start();
require 'database.php';
require 'functions.php';


if ($_SESSION["login"] == false) {
    header("location: ./index.php?error=notLoggedIn");
    exit();
}

// if this exists, it means the user is logged in
    if (isset($_POST["submit"])) {
        $userId = $_SESSION["userid"];
        $commentContent = $_POST["commentText"];
        $postId = $_POST["postId"];
        date_default_timezone_set('GB');
        $commentDate = date("D jS M Y H:i");
        // echo "<p> $userContent </p>";
        // var_dump ($_POST);
    }

    function makeComments($conn,$userId, $postId, $commentContent,$commentDate){
        // ? placeholders for user first name,user Last name,userEmail,userUid,userPWD, user gender an user phone number
        $sql = "INSERT INTO postcomments (userId, postId, commentContent, commentDate) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt,$sql)) {
         header("location: ../index.php?error=statementfailed");
         exit();
        }
        mysqli_stmt_bind_param($stmt,"ssss",$userId, $postId ,$commentContent,$commentDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../index.php?posted");
         exit();
    }
    makeComments($conn,$userId, $postId ,$commentContent,$commentDate);


