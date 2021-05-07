<?php
    session_start();
    include_once 'loadPosts.php';
    include_once 'database.php';
    include_once 'functions.php';
    include_once 'loadComments.php';


    if ($_SESSION["login"] == false) {
        exit();
    }

    $postId = $_POST["postId"];
    $userName = $_SESSION["useruid"];

    // VERIFT THAT THE USER HAS LIKED THE POST BEFORE RUNNING THIS (check like status or something)
    function checkLikedStatus($conn, $postId,$userName){
        $sql = "SELECT * FROM likes WHERE postId =? AND userId =?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
         exit();
        }

        mysqli_stmt_bind_param($stmt,"ss",$postId,$userName);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $result;
        //associative array, doesnt use index numbers but rather column names
    if ($row = mysqli_fetch_assoc($resultData)) {
       $result = 1;
   }
   else {
       $result = 0;
   }
   return $result;
   mysqli_stmt_close($stmt);
}

    function likePost($conn,$postId,$userName){
        // ? placeholders for first name, last name and userId
        $sql = "INSERT INTO likes (postId, userId) VALUES (?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
         exit();
        }
        mysqli_stmt_bind_param($stmt,"ss",$postId,$userName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $sql = "UPDATE posts SET postLikeCount = postLikeCount + 1 WHERE Id =?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
         exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$postId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function unlikePost($conn,$postId,$userName){
        // ? placeholders for first name, last name and userId
        $sql = "DELETE FROM likes WHERE postId =? AND userId =?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
         exit();
        }
        mysqli_stmt_bind_param($stmt,"ss",$postId,$userName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $sql = "UPDATE posts SET postLikeCount = postLikeCount - 1 WHERE Id =?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
         exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$postId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // if statement to check if the user has already liked, if not, send a like to the database
    if (!checkLikedStatus($conn,$postId,$userName)){
        likePost($conn,$postId,$userName);
    } else {
        unlikePost($conn,$postId,$userName);
    }
