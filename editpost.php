<?php
// page for editing posts, similar to editComment.php
session_start();
include_once 'includes/loadPosts.php';
include_once 'includes/database.php';
include_once 'includes/functions.php';
include_once './header.php';

$posts = getPosts($conn);
$postId = $_GET["postid"];

if ($_SESSION["login"] == false) {
    header("location: ./index.php?error=notLoggedIn");
    exit();
}

// loop through posts array
for ($i = count($posts) - 1; $i >= 0; $i--) {
    // if id of current looped post matches with chosen post id
    if ($posts[$i]["Id"] == $postId) {
        // and current logged in ID is the same as the ID linked with post
        // show the post/tags and the editing option
        if ($posts[$i]["userId"] == $_SESSION["userid"]) {
            echo '<br> <br>';
            echo '<div class="centered">';
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<div class="content user-post">';
            echo '<div class="postContent">';
            echo '<p>' . $posts[$i]["postContent"] . '</p>';
            echo '</div>';

            echo '<br>';

            echo '<div class="tagContainer">';
            echo '<p>' . $posts[$i]["postTags"] . ' </p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            // form to change both the post content and tag content
            // sent to includes/updatePost.php
            echo '<br>';
            echo '<h1>Change Post!</h1>';
            echo '<div class="field">';
            echo '<form class="post-comment-box" action="includes/updatePost.php" method="post">';
            echo '<br>';
            echo '<textarea class="textarea is-info is-small" type="textarea" name="newPost" id="newPost" placeholder="Post Contents"></textarea>';
            echo '<br>';
            echo '<textarea class="textarea is-info is-small" type="textarea" name="newTags" id="newTags" placeholder="New Tags"></textarea>';
            echo '<input type="hidden" name="postId" value="' . $postId . '">';
            echo '<br>';
            echo '<input class="button is-info" type="submit" value="edit post" name="submit">';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        } else {
            // should be used due to if statement checks, but best to be safe
            echo '<p>You Do not have permission to edit this post</p>';
            header("location: ./index.php?error=wronguser");
        }
    }
}


include_once 'footer.php';
