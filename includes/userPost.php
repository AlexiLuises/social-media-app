<?php
session_start();
require 'database.php';
require 'functions.php';



if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
}
// if this exists, it means the user is logged in
    if (isset($_POST["submit"])) {
        $userId = $_SESSION["userid"];
        $content = $_POST["posts"];
        $tags = $_POST["tags"];
        $postDate = date("D jS M Y H:i");
        echo"<p> $content, $tags, $userId, $postDate </p>";
    }

    function postContent($conn,$userId,$content,$tags,$postDate){
        // ? placeholders for user first name,user Last name,userEmail,userUid,userPWD, user gender an user phone number
        $sql = "INSERT INTO posts (userId,postContent,postTags, postDate) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
         header("location: ../index.php?error=statementfailed");
         exit();
        }
        mysqli_stmt_bind_param($stmt,"ssss",$userId,$content,$tags,$postDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../index.php?posted");
         exit();
     }

    postContent($conn,$userId,$content,$tags,$postDate);

    function getPosts($conn)
    {
        $sql = "SELECT * FROM posts;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: .//index.php?error=PostLoadFailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $postresults = mysqli_stmt_get_result($stmt);

        $postArray = array();

        while ($postlist = mysqli_fetch_assoc($postresults)) {
            //add posts into the array 1 by 1 until its done
            $postsArray = $postlist;
        }
        var_dump($postlist);
    }
    getPosts($conn);






