<?php
// page to display posts and other information in index.html
session_start();
include_once './loadPosts.php';
include_once './database.php';
include_once './functions.php';
include_once './loadComments.php';
include_once 'header.php';


// putting posts and comments associative array in variable to use
$posts = getPosts($conn);
$comments = getComments($conn);
echo '<br>';

// looping through the posts in the database
for ($i = count($posts) - 1; $i >= 0; $i--) {
    // Bulma Card space for name/profile picture/date
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

    // Check if there are any images in specific post entry
    if (!empty($posts[$i]["postImage"])) {
        // if not empty,  use bulma to output image from DB
        echo '<div class="image is-4by3 card-image posted-picture">';
        echo '<a target="_blank" href="' . $posts[$i]["postImage"] . '">';
        echo '<img class="fit-container" src="' . $posts[$i]["postImage"] . '">';
        echo '</a>';
        echo '</div>';
    }
    echo '<br>';

    // change whats shown depending on what is found in post associative array
    if (!empty($posts[$i]["postContent"]) || !empty($posts[$i]["postTags"])) {
        echo '<div class="content user-post">';
        if (!empty($posts[$i]["postContent"])) {
            // Container for main content of post
            echo '<div class="postContent">';
            echo '<p>' . $posts[$i]["postContent"] . '</p>';
            echo '</div>';
            echo '<br>';
        }
        if (!empty($posts[$i]["postTags"])) {
            // Container for tags of post
            echo '<div class="tagContainer">';
            echo '<p>' . $posts[$i]["postTags"] . ' </p>';
            echo '</div>';
        }
        echo '</div>';
    }

    // Bulma footer for buttons at end of content
    echo '<footer class="card-footer interaction-buttons">';
    if ($posts[$i]["userUid"] == $_SESSION['useruid']) {
        // Show these buttons if post belongs to logged in user
        // Edit button, delete button, and unclickable like count button
        // class deletePost used in ajax function/// Edit sent to editPost.php
        echo '<a href="editpost.php?postid=' . $posts[$i]["Id"] . '" class="button is-link card-footer-item">Edit</a>';
        echo '<button class="button is-danger card-footer-item deletePost" id="' . $posts[$i]["Id"] . '">Delete</button>';
        echo '<button class="button is-danger is-light is-outlined card-footer-item is-static">';
        echo '<span>' . $posts[$i]["postLikeCount"] . '</span>';
        echo '<span class="icon is-small">';
        echo '<i class="fa fa-heart"></i>';
        echo '</span>';
        echo '</button>';
    } else {
        // If not logged in users post, only show like button/like count capability
        // likeButton class linked to ajax
        echo '<button class="button is-danger is-light is-outlined card-footer-item likeButton" id="' . $posts[$i]["Id"] . '">';
        echo '<i class="fa fa-heart"></i>';
        echo '<p>' . $posts[$i]["postLikeCount"] . '</p>';
        echo '</button>';
    }
    echo '</footer>';
    // bulma field for comment text submission box
    // linked to userComment.php file
    echo '<br>';
    echo '<div class="field">';
    echo '<form class="post-comment-box" action="includes/userComment.php" method="post">';
    echo '<textarea class="textarea is-info is-small" name="commentText" placeholder=" write a comment here!"></textarea>';
    echo '<input type="hidden" name="postId" value="' . $posts[$i]["Id"] . '">';
    echo '<br>';
    echo '<button class="button is-info" type="submit" placeholder="submit" name="submit">submit</button>';
    echo '</form>';
    echo '</div>';

    // Comment section, loop through comments assoc array
    echo '<div class="comments">';
    for ($h = count($comments) - 1; $h >= 0; $h--) {
        // if posyID of comment is the same as postID of the post, show content
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
            // if logged in user uid is same as comment entry uid (their comment)
            // show extra functionality (edit/delete).
            // Edit linked to editComment.php file. class deleteComment used in Ajax function
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



// AJAX scripts
echo '<script>';
// script for like functionality, takes likebutton class and sends to likepost.php with data
echo '$(".likeButton").on("click",function(){';
echo 'console.log("Post Liked: " + $(this).attr("id"));';
echo '$.ajax({';
echo 'url: "includes/likePost.php",';
echo 'type: "POST",';
echo 'data:{';
//grabbing id of likeButton
echo 'postId: $(this).attr("id")';
echo '},';
echo 'success: function(returnData){';
// reload posts after function succesful
echo 'loadPosts();';
echo '}';
echo '});';
echo '';
echo '});';

// Delete post script
echo '$(".deletePost").on("click",function(){';
echo 'console.log("Post Deleted: " + $(this).attr("id"));';
echo '$.ajax({';
echo 'url: "includes/deletePost.php",';
echo 'type: "POST",';
echo 'data:{';
//grabbing id of deletePost button
echo 'postId: $(this).attr("id")';
echo '},';
echo 'success: function(returnData){';
echo 'loadPosts();';
echo '}';
echo '});';
echo '';
echo '});';

// delete comment script
echo '$(".deleteComment").on("click",function(){';
echo 'console.log("comment Deleted: " + $(this).attr("id"));';
echo '$.ajax({';
echo 'url: "includes/deleteComment.php",';
echo 'type: "POST",';
echo 'data:{';
//grabbing id of deleteComment button
echo 'commentId: $(this).attr("id")';
echo '},';
echo 'success: function(returnData){';
echo 'loadPosts();';
echo '}';
echo '});';
echo '';
echo '});';
echo '</script>';
