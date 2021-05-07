<?php
session_start();
require 'database.php';
require 'functions.php';


function postContent($conn,$userId,$content,$tags,$postDate,$newPostPicture){
    // ? placeholders for user first name,user Last name,userEmail,userUid,userPWD, user gender an user phone number
    var_dump($userId,$content,$tags,$postDate,$newPostPicture);
    $sql = "INSERT INTO posts (userId,postContent,postTags, postDate, postImage) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
     header("location: ../index.php?error=statementfailed");
     exit();
    }
    mysqli_stmt_bind_param($stmt,"sssss",$userId,$content,$tags,$postDate,$newPostPicture);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?posted");
     exit();
 }

 function getPosts($conn)
 {
     $sql = "SELECT *, userFname FROM posts, users WHERE posts.userId = users.userId;";
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
         header("location: ../index.php?error=PostLoadFailed");
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



if ($_SESSION["login"] == false) {
    header("location: ./index.php?error=notLoggedIn");
}
// if this exists, it means the user is logged in
    if (isset($_POST["submit"])) {
        $userId = $_SESSION["userid"];
        $content = $_POST["posts"];
        $tags = $_POST["tags"];
        date_default_timezone_set('GB');
        $postDate = date("D jS M Y H:i");
        // echo"<p> $content, $tags, $userId, $postDate </p>";
        $postImage = $_POST["postPicture"];
    }





if(isset($_POST["submit"])) {

    if(is_uploaded_file($_FILES['postPicture']['tmp_name'])){
    $target_dir = "../photos/";
    $newPostPicture = $target_dir . basename($_FILES["postPicture"]["name"]);
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($newPostPicture,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["postPicture"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
        if ($_FILES["postPicture"]["size"] > 5000000) {
            echo "Sorry, your file is either too large or does not exist.";
            $uploadOk = 0;
            header("location: ../index.php?error=imageTooLarge");
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            header("location: ../index.php?error=filetypeNotSupported");
        }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["postPicture"]["tmp_name"], $newPostPicture)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["postPicture"]["name"])). " has been uploaded.";
        $newPostPicture = substr($newPostPicture, 1);
    }
    }

}
    // var_dump($userId,$content,$tags,$postDate,$newPostPicture);
    // exit();
    postContent($conn,$userId,$content,$tags,$postDate,$newPostPicture);

}
    getPosts($conn);






