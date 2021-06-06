<?php
// page to update posts
session_start();
include_once 'database.php';
include_once 'functions.php';

if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
    exit();
}

if (isset($_POST["submit"])) {
    $newContent = $_POST["newPost"];
    $newTags = $_POST["newTags"];
    $postId = $_POST["postId"];
}

function updatePost($conn,$newContent,$newTags,$postId){
    $sql = "UPDATE posts SET postContent = ?, postTags = ? WHERE Id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt,$sql)) {
     header("location: ../index.php?error=statementfailed");
     exit();
    }
    mysqli_stmt_bind_param($stmt,"sss",$newContent,$newTags,$postId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?postUpdated");
}

updatePost($conn,$newContent,$newTags,$postId);
