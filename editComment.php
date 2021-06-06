<?php
// page to allow you to edit your comments
session_start();
include_once 'includes/database.php';
include_once 'includes/functions.php';
include_once 'includes/loadComments.php';
include_once './header.php';

$comments = getComments($conn);
$commentId = $_GET["commentId"];
var_dump($commentId);

if ($_SESSION["login"] == false) {
    header("location: ./index.php?error=notLoggedIn");
    exit();
}

// loops through comment assoc array
for ($i = count($comments) - 1; $i >= 0; $i--) {
    // if current comment is same as the given comment id
    if ($comments[$i]["commentId"] == $commentId) {
        // and if the current logged in users userid is the same as the userid linked with
        // the found comment, then output the chosen comment
        if ($comments[$i]["userUid"] == $_SESSION["useruid"]) {

            echo '<br> <br>';
            echo '<div class="centered">';
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<div class="content user-post">';
            echo '<div class="postContent">';
            echo '<p>' . $comments[$i]["commentContent"] . '</p>';
            echo '</div>';
            echo '<br>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            // field to edit the chosen post and send to includes/updateComment.php
            echo '<br>';
            echo '<h1>Edit Comment</h1>';
            echo '<div class="field">';
            echo '<form class="post-comment-box" action="includes/updateComment.php" method="post">';
            echo '<br>';
            echo '<textarea class="textarea is-info is-medium" type="textarea" name="newComment" id="newComment" placeholder="Comment Contents"></textarea>';
            echo '<br>';
            echo '<input type="hidden" name="commentId" value="' . $commentId . '">';
            echo '<input class="button is-info" type="submit" value="edit comment" name="submit">';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        } else {
            // should never happen due to if statement checks above,but best to be safe
            echo '<p>You Do not have permission to edit this post</p>';
            header("location: ./index.php?error=wronguser");
        }
    }
}


include_once 'footer.php';
