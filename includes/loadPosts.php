<?php
// page to get and load posts
include_once 'database.php';
include_once 'functions.php';

// takes required data for post functionality
function getPosts($conn)
{
    $sql = "SELECT *, userFname, profilePicture FROM posts, users WHERE posts.userId = users.userId;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=PostLoadFailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $postResults = mysqli_stmt_get_result($stmt);
    $postArray = array();

    while ($postlist = mysqli_fetch_assoc($postResults)) {
        //add posts into the array 1 by 1 until its done
        $postsArray[] = $postlist;
    }
    // var_dump($postsArray);
    mysqli_stmt_close($stmt);
    return ($postsArray);
}
