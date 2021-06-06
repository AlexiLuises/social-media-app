<?php
session_start();
// page for uploading profile pictures and storing them locally (locally hosted)
include_once 'database.php';
include_once 'functions.php';

if ($_SESSION["login"] == false) {
  header("location: ./index.php?error=notLoggedIn");
}
$profileName = $_POST["profileName"];



if (isset($_POST["submit"])) {
  // target directory images will be moved into after being checked
  $target_dir = "../photos/";
  // makes the uploaded photos string include the target files
  $newProfilePicture = $target_dir . basename($_FILES["profilePicture"]["name"]);
  $uploadOk = 1;
  // path parts breaks the path of the picture into different sections
  $path_parts = pathinfo($newProfilePicture);
  // gets only the extention part of the path
  $extention = $path_parts['extension'];

  // renames file with a number at the end depending on how many times the name already exists
  if (file_exists($newProfilePicture)) {
    $imageCount = 0; // initialize file count.

    // runs loop increasing image counter and appending to filename until untaken filename is found.
    // ends up doing img12.jpg instead of img2.jpg but this works
    do {
      $imageCount++;
      // makes a new name without extention using path parts filename
      $newName = $path_parts['filename'] .= "$imageCount";
      // adds target directory, new name with number, and the extention to profile picture
      $newProfilePicture = $target_dir . $newName . '.' . $extention;
    } while (file_exists($newProfilePicture));
  }
  $imageFileType = strtolower(pathinfo($newProfilePicture, PATHINFO_EXTENSION));
  // checking for image size, if too big it will be rejected
  $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  if ($_FILES["profilePicture"]["size"] > 5000000) {
    echo "Sorry, your file is either too large or does not exist.";
    $uploadOk = 0;
    header("location: ../index.php?error=imageTooLarge");
  }
  // check image type, if its not an image file, will be rejected
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    header("location: ../profile.php?error=filetypeNotSupported");
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $newProfilePicture)) {
      echo "The file " . htmlspecialchars(basename($_FILES["profilePicture"]["name"])) . " has been uploaded.";

      function profilePictureUpload($conn, $profileName, $newProfilePicture)
      {
        $sql = "UPDATE users SET profilePicture=? WHERE userUid = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("location: ../profile.php?error=sql_error");
          exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $newProfilePicture, $profileName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../profile.php?profileName=" . $profileName);
      }
      // due to this being in includes folder, but being called in profile.php
      // after checkup is done, remove the 1st character from the $newProfilePicture string
      // to make it accurate when moving to database
      // eg, ../photos/hi.png is what would be put in the database, when database requires
      //  .photos/hi.png instead
      $newProfilePicture = substr($newProfilePicture, 1);
      profilePictureUpload($conn, $profileName, $newProfilePicture);
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
} else {

  exit();
}
