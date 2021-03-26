<?php
    include_once 'header.php';
    include_once 'includes/loadPosts.php';
    include_once 'includes/database.php';
    include_once 'includes/functions.php';
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
    for($i=0; $i < count($posts); $i++){
    echo '<h1> Post ID: ' . $posts[$i]["userId"] . '</h1>';
    echo '<br>';
    echo '<p>'. $posts[$i]["postContent"]. '</p>';
    echo '<hr>';
    }
    ?>
    </section>

<?php
    include_once 'footer.php';
?>