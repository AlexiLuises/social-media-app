<?php
// Page to delete comments
// making sure session is started to get the session variables
session_start();
include_once 'loadPosts.php';
include_once 'database.php';
include_once 'functions.php';
include_once 'loadComments.php';
include_once 'getProfilePage.php';
include_once 'displayProfilePost.php';

// test to see if the user is loged into any accounts
if ($_SESSION["login"] == false) {
    exit();
}
// get sent comment ID through form or ajax
$commentId = $_POST["commentId"];

// function to delete selected comment from SQL table, depending on ID of comment given
function deleteComment($conn, $commentId)
{
    $sql = "DELETE FROM postcomments WHERE commentId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $commentId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

deleteComment($conn, $commentId);
