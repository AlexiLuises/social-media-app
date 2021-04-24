<?php
include_once 'database.php';
include_once 'functions.php';

function getComments($conn)
    {
        $sql = "SELECT commentContent, commentDate, userFname, postId FROM postcomments, posts, users WHERE postcomments.postId = posts.Id AND postcomments.userId = users.userId;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=commentLoadFailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $commentResults = mysqli_stmt_get_result($stmt);
        $commentArray = array();

        while ($commentlist = mysqli_fetch_assoc($commentResults) ) {
            //add posts into the array 1 by 1 until its done
            $commentArray[] = $commentlist;
        }
        mysqli_stmt_close($stmt);
        return $commentArray;
    }