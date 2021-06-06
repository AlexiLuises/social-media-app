<?php
// displays posts/content to profile page
// Nearly identical to display post, but for the profile page
session_start();
include_once './loadPosts.php';
include_once './database.php';
include_once './loadComments.php';
include_once './getProfilePage.php';

$posts = getPosts($conn);
$comments = getComments($conn);
$userData = getUsers($conn, $_GET['profileName']);


// main bulma container specific user profile, shows name, profile picture and join date
echo '<div class="card">';
echo '<div class="card-image">';
echo '</div>';
echo '<div class="card-content">';
echo '<div class="media">';
echo '<div class="media-left">';
echo '<figure class="image is-96x96 is-1by1">';
echo "<img class='pfp is-rounded' src=" . $userData["0"]["profilePicture"] . ">";
echo '</figure>';
echo '</div>';
echo '<div class="media-content">';
echo '<p class="title is-4">' . $userData["0"]["userFname"] . '  ' . $userData["0"]["userLname"] . '</p>';
echo '</div>';
echo '</div>';
echo '';
echo '<div class="content">';
echo '<time datetime="YYYY-MM-DD">' . $userData["0"]["creationDate"] . '</time>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<br> <br>';

// loop through posts
for ($i = count($posts) - 1; $i >= 0; $i--) {
    // if userUid of post is same as profile name, show post on this page
    if ($posts[$i]["userUid"] == $_GET['profileName']) {
        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<div class="media">';
        echo '<div class="media-left">';
        echo '<figure class="image is-64x64 is-1by1">';
        echo '<img class= "is-rounded fit-container" src="' . $posts[$i]["profilePicture"] . '">';
        echo '</figure>';
        echo '</div>';
        echo '<div class="media-content">';
        echo '<p class="username"> <strong> <a href="profile.php?profileName=' . $posts[$i]["userUid"] . '">' . $posts[$i]["userFname"] . '</a></strong></p>';
        echo '<p>' . $posts[$i]["postDate"] . '</p>';
        echo '</div>';
        echo '</div>';


        // show image if image filepath is not empty
        if (!empty($posts[$i]["postImage"])) {
            // IMAGES
            echo '<div class="card-image posted-picture">';
            echo '<figure class="image is-4by3">';
            echo '<img class="fit-container" src="' . $posts[$i]["postImage"] . '">';
            echo '</figure>';
            echo '</div>';
        }

        echo '<br>';
        // show content/change container look based on if tags or content has been given
        if (!empty($posts[$i]["postContent"]) || !empty($posts[$i]["postTags"])) {
            echo '<div class="content user-post">';
            if (!empty($posts[$i]["postContent"])) {

                echo '<div class="postContent">';
                echo '<p>' . $posts[$i]["postContent"] . '</p>';
                echo '</div>';
                echo '<br>';
            }
            if (!empty($posts[$i]["postTags"])) {
                echo '<div class="tagContainer">';
                echo '<p>' . $posts[$i]["postTags"] . ' </p>';
                echo '</div>';
            }
            echo '</div>';
        }

        // bulma footer for buttons at end of card
        echo '<footer class="card-footer interaction-buttons">';
        // check if logged in user is owner of specific profile page
        // if yes, show edit/delete functionality. If no, show like button
        if ($posts[$i]["userUid"] == $_SESSION['useruid']) {

            echo '<a href="editpost.php?postid=' . $posts[$i]["Id"] . '" class="button is-link card-footer-item">Edit</a>';
            echo '<button class="button is-danger card-footer-item deletePost" id="' . $posts[$i]["Id"] . '">Delete</button>';

            echo '<button class="button is-danger is-light is-outlined card-footer-item is-static">';
            echo '<span>' . $posts[$i]["postLikeCount"] . '</span>';
            echo '<span class="icon is-small">';
            echo '<i class="fa fa-heart"></i>';
            echo '</span>';
            echo '</button>';
        } else {
            // LIKES
            echo '<button class="button is-danger is-light is-outlined card-footer-item likeButton" id="' . $posts[$i]["Id"] . '">';
            echo '<i class="fa fa-heart"></i>';
            echo '<p>' . $posts[$i]["postLikeCount"] . '</p>';
            echo '</button>';
        }
        echo '</footer>';
        echo '<br>';

        // field class for comment submition box
        echo '<div class="field">';

        echo '<form class="post-comment-box" action="includes/userComment.php" method="post">';

        echo '<textarea class="textarea is-info is-small" name="commentText" placeholder=" write a comment here!"></textarea>';
        echo '<input type="hidden" name="postId" value="' . $posts[$i]["Id"] . '">';
        echo '<br>';
        echo '<button class="button is-info" type="submit" placeholder="submit" name="submit">submit</button>';
        echo '</form>';
        echo '</p>';
        echo '</div>';


        echo '<div class="comments">';
        // loop through comments assoc array
        for ($h = count($comments) - 1; $h >= 0; $h--) {
            // if any comments link to same postId as post, output them
            if ($comments[$h]["postId"] == $posts[$i]["Id"]) {
                echo '<article class="media">';
                echo '<figure class="media-left">';
                echo '<p class="image is-48x48 is-1by1">';
                echo '<img class= "is-rounded fit-container" src="' . $comments[$h]["profilePicture"] . '">';
                echo '</p>';
                echo '</figure>';
                echo '<div class="media-content">';
                echo '<div class="content">';
                echo '<p>';
                echo '<a href="profile.php?profileName=' . $comments[$h]["userUid"] . '">' . $comments[$h]["userFname"] . '</a>';
                echo '<p>' . $comments[$h]["commentContent"] . '</p>';
                echo '</p>';
                echo '</div>';
                echo '</div>';
                echo '</article>';
                // if owner of comment gain edit/delete functionality
                if ($comments[$h]["userUid"] == $_SESSION['useruid']) {

                    echo '<footer class="card-footer interaction-buttons">';
                    echo '<a href="editComment.php?commentId=' . $comments[$h]["commentId"] . '" class="button is-link card-footer-item">Edit</a>';
                    echo '<button class="button is-danger card-footer-item deleteComment" id="' . $comments[$h]["commentId"] . '">Delete</button>';
                    echo '</footer>';
                    echo '<br>';
                }
            }
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<br><br>';
    }
}


// scripts to like,edit and delete things
// same code as in includes/displayPost.php, go there for better explanation
echo '<script>';
echo '$(".likeButton").on("click",function(){';
echo 'console.log("Post Liked: " + $(this).attr("id"));';
echo '$.ajax({';
echo 'url: "includes/likePost.php",';
echo 'type: "POST",';
echo 'data:{';
echo 'postId: $(this).attr("id")';
echo '},';

echo 'success: function(returnData){';
echo 'loadPosts();';
echo '}';
echo '});';
echo '';
echo '});';

echo '$(".deletePost").on("click",function(){';
echo 'console.log("Post Deleted: " + $(this).attr("id"));';
echo '$.ajax({';
echo 'url: "includes/deletePost.php",';
echo 'type: "POST",';
echo 'data:{';
echo 'postId: $(this).attr("id")';
echo '},';
echo 'success: function(returnData){';
echo 'loadPosts();';
echo 'console.log(returnData);';
echo '}';
echo '});';
echo '';
echo '});';

echo '$(".deleteComment").on("click",function(){';
echo 'console.log("comment Deleted: " + $(this).attr("id"));';
echo '$.ajax({';
echo 'url: "includes/deleteComment.php",';
echo 'type: "POST",';
echo 'data:{';
echo 'commentId: $(this).attr("id")';
echo '},';
echo 'success: function(returnData){';
echo 'loadPosts();';
echo '}';
echo '});';
echo '';
echo '});';
echo '</script>';
