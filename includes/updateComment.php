<?php
// page to update edited comments
session_start();
include_once 'database.php';
include_once 'functions.php';

if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
    exit();
}

if (isset($_POST["submit"])) {
    $newComment = $_POST["newComment"];
    $commentId = $_POST["commentId"];
}


// function to update comment table
function updateComment($conn, $newComment, $commentId)
{
    $sql = "UPDATE postcomments SET commentContent = ? WHERE commentId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $newComment, $commentId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?commentUpdated");
}

updateComment($conn, $newComment, $commentId);
