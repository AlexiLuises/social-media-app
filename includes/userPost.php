<?php
// Page to upload and retrieve posts to/from the database
session_start();
require 'database.php';
require 'functions.php';

if ($_SESSION["login"] == false) {
    header("location: ../index.php?error=notLoggedIn");
    exit();
}

// function to post the contents
function postContent($conn, $userId, $content, $tags, $postDate, $newPostPicture)
{
    $sql = "INSERT INTO posts (userId,postContent,postTags, postDate, postImage) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $userId, $content, $tags, $postDate, $newPostPicture);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?posted");
    exit();
}

// function to retrieve posts from db
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

if (isset($_POST["submit"])) {
    // image checking for uploading images to your post
    if (is_uploaded_file($_FILES['postPicture']['tmp_name'])) {
        $target_dir = "../photos/";
        $newPostPicture = $target_dir . basename($_FILES["postPicture"]["name"]);
        $uploadOk = 1;
        // path parts breaks the path of the picture into different sections
        $path_parts = pathinfo($newPostPicture);
        // this gets just the extention of the path
        $extention = $path_parts['extension'];

        // renames file with a number at the end depending on how many times the name already exists
        if (file_exists($newPostPicture)) {
            $imageCount = 0; // initialize file count.

            // runs loop increasing image counter and appending to filename until untaken filename is found.
            // ends up doing img12.jpg instead of img2.jpg but this works
            do {
                $imageCount++;
                // makes a new name without extention using path parts filename
                $newName = $path_parts['filename'] .= "$imageCount";
                // adds target directory, new name with number, and the extention to profile picture
                $newPostPicture = $target_dir . $newName . '.' . $extention;
            } while (file_exists($newPostPicture));
        }

        $imageFileType = strtolower(pathinfo($newPostPicture, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["postPicture"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
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

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
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
                echo "The file " . htmlspecialchars(basename($_FILES["postPicture"]["name"])) . " has been uploaded.";
                // delete first character of $newPostPicture string before entering database
                // much more detailed explanation in includes/uploadImage.php
                $newPostPicture = substr($newPostPicture, 1);
            }
        }
    }
    postContent($conn, $userId, $content, $tags, $postDate, $newPostPicture);
}
getPosts($conn);
