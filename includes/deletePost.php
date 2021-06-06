<?php
// page to delete posts
session_start();
include_once 'loadPosts.php';
include_once 'database.php';
include_once 'functions.php';
include_once 'loadComments.php';
include_once 'getProfilePage.php';
include_once 'displayProfilePost.php';

if ($_SESSION["login"] == false) {
    exit();
}


$postId = $_POST["postId"];

// function to delete a specific post
function deletePost($conn, $postId)
{
    // ? placeholders for first name, last name and userId
    $sql = "DELETE FROM posts WHERE Id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $postId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
deletePost($conn, $postId);
