<?php
// page to update likes
session_start();
include_once 'loadPosts.php';
include_once 'database.php';
include_once 'functions.php';
include_once 'loadComments.php';


if ($_SESSION["login"] == false) {
    exit();
}


function likePost($conn, $postId, $userName)
{
    $sql = "INSERT INTO likes (postId, userId) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $postId, $userName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
likePost($conn, $postId, $userName);
