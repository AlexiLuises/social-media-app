<?php
    session_start();
    include_once 'header.php';
    include_once 'includes/getProfilePage.php';
    include_once 'includes/loadPosts.php';
    include_once 'includes/loadComments.php';
    include_once 'includes/database.php';
?>



<?php
            $profileName = $_GET['profileName'];
            if (isset($_SESSION['useruid'])) {
                // if this exists, it means the user is logged in
                $_SESSION["login"] = true;
            }

            if(isset($_GET["error"])){
            if($_GET["error"] == "notLoggedIn"){
            echo "<script language='javascript'>";
            echo 'alert("Please log in to see your profile page");';
            echo "</script>";
        }
      }
      ?>


    <?php

    $userData = getUsers($conn,$_GET['profileName']);
    $posts = getPosts($conn);
    $comments = getComments($conn);
    var_dump($userData["0"]["profilePicture"]);


    if($_SESSION['useruid'] == $profileName){
    echo '<br>';
    echo'<form action="includes/uploadImage.php" method="post" enctype="multipart/form-data">';
    echo 'Select image to upload:';
    echo '<br>';
    echo '<input type="file" name="profilePicture" id="profilePicture" required>';
    echo '<input type="hidden" name="profileName" value="'.$profileName.'">';
    echo '<br>';
    echo '<input type="submit" value="Upload Image" name="submit">';
    echo '</form>';


    echo '<br>';
    echo '<form action="includes/nameChange.php" method="post">';
    echo 'What would you like to change your name to?';
    echo '<br>';
    echo '<input type="text" name="newFirstName" id="newFirstName">';
    echo '<input type="text" name="newLastName" id="newLastName">';
    echo '<input type="hidden" name="profileName" value="'.$profileName.'">';
    echo '<br>';
    echo '<input type="submit" value="Submit new name" name="submit">';
    echo '</form>';
}

    echo '<h1> name: '.$userData["0"]["userFname"]." ".$userData["0"]["userLname"].'</h1>';
    echo "<img src=".$userData["0"]["profilePicture"].">";
    ?>

            <button id="refreshButton">
            <i class="fas fa-sync" id="spinButton"></i>
            REFRESH
            </button>

<section class="feed">
<?php
for($i = count($posts)-1; $i >= 0; $i--){
        if ($posts[$i]["userUid"] == $_GET['profileName']) {
            echo '<p>user:'.$posts[$i]["userFname"]. '</p>';
            echo '<p>Posts!!!:' .$posts[$i]["postContent"].'</p>';
            echo "<img src=".$posts[$i]["postImage"].">";
            echo '<button class="likeButton" id="'.$posts[$i]["Id"].'">';
            echo '<i class="fa fa-heart"></i>Like';
            echo '<p>'. $posts[$i]["postLikeCount"].'</p>';
            echo '</button>';

            for($h = count($comments)-1; $h >= 0; $h--){
                if ($comments[$h]["postId"] == $posts[$i]["Id"]) {
                    echo '<p>user:'.$comments[$h]["userFname"]. '</p>';
                    echo '<p>comments:' .$comments[$h]["commentContent"].'</p>';
                }
           
            }
            echo '<form action="includes/userComment.php" method="post">';
            echo '<input type="text" name="commentText" placeholder=" write a comment here!">';
            echo '<input type="hidden" name="postId" value="'.$posts[$i]["Id"].'">';
            echo'<button type="submit" placeholder="submit" name="submit">submit</button>';
            echo '</form>';
            echo '</section>';
        }

    }

    ?>

    </section>

    <?php
    include_once 'footer.php';
    ?>