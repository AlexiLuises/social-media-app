<?php
    include_once 'header.php';
    include_once 'includes/loadPosts.php';
    include_once 'includes/database.php';
    include_once 'includes/functions.php';
    include_once 'includes/loadComments.php';
?>

        <section class="index-intro">
            <?php
            if (isset($_SESSION['useruid'])) {
                // if this exists, it means the user is logged in
                echo "<p>Hi, ".$_SESSION["useruid"] ."</p>";
                $_SESSION["login"] = true;
            }

            if(isset($_GET["error"])){
            if($_GET["error"] == "notLoggedIn"){
            echo "<script language='javascript'>";
            echo 'alert("Please log in to post something");';
            echo "</script>";
        }
      }
      ?>
            <h1>this is a paragraph</h1>
            <p>hello hello yes intro</p>
        </section>

        <section class="post">
            <form action="includes/userPost.php" method="post" id="userPost">
            <button type="submit" name="submit">Post</button>
            </form>
            <br>
            <textarea rows="5" cols="40" name="posts" form="userPost" placeholder="Whats on your mind?"></textarea>
            <br>
            <textarea rows="2" cols="25" name="tags" form="userPost" placeholder="#tags"></textarea>
        </section>

    <section class="feed">
    <?php
    $posts = getPosts($conn);
    $comments = getComments($conn);

    for($i = count($posts)-1; $i >= 0; $i--){
            echo '<h1> name:' .$posts[$i]["userFname"] .'</h1>';
            echo '<p>'. $posts[$i]["postContent"]. '</p>';
            echo '<p>'. $posts[$i]["postTags"]. '</p>';
            echo '<p>'. $posts[$i]["postDate"]. '</p>';
            echo '<p>'. $posts[$i]["Id"]. '</p>';
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


    ?>
    </section>

<?php
    include_once 'footer.php';
?>