<?php
    session_start();
    include_once './loadPosts.php';
    include_once './database.php';
    include_once './functions.php';
    include_once './loadComments.php';

    $posts = getPosts($conn);
    $comments = getComments($conn);
for($i = count($posts)-1; $i >= 0; $i--){
            echo '<a href="profile.php?profileName='.$posts[$i]["userUid"].'"><h1> name:' .$posts[$i]["userFname"] .'</h1></a>';
            echo "<img src=".$posts[$i]["profilePicture"].">";
            echo '<p>'. $posts[$i]["postContent"]. '</p>';
            echo "<img src=".$posts[$i]["postImage"].">";
            echo '<p>'. $posts[$i]["postTags"]. '</p>';
            echo '<p>'. $posts[$i]["postDate"]. '</p>';
            echo '<p>'. $posts[$i]["Id"]. '</p>';

            echo '<button class="likeButton" id="'.$posts[$i]["Id"].'">';
            echo '<i class="fa fa-heart"></i>Like';
            echo '<p>'. $posts[$i]["postLikeCount"].'</p>';
            echo '</button>';

            echo '<section class="comments">';
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

    echo '<script>';
    echo '$(".likeButton").on("click",function(){';
    echo 'console.log("Post Liked: " + $(this).attr("id"));';
    echo '$.ajax({';
        echo 'url: "includes/likePost.php",';
        echo 'type: "POST",';
        echo 'data:{';
        //grabbing id of button in include/displaypost.php
        echo 'postId: $(this).attr("id")';
        echo '},';
        //on succesful run, return any data
        echo 'success: function(returnData){';
        //TODO: update post count here
        echo 'loadPosts();';
        // echo 'console.log(returnData);';
        echo '}';
        echo '});';
    echo '';
    echo '});';
    echo '</script>';
