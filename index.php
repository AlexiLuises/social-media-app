<?php
// main page of website, shows posts and has ajax functionality for refreshing the page
include_once 'header.php';
include_once 'includes/loadPosts.php';
include_once 'includes/database.php';
include_once 'includes/functions.php';
include_once 'includes/loadComments.php';
?>

<!-- says hello to the user if they are logged in -->
<section class="index-intro">
    <br>
    <?php
    if (isset($_SESSION['useruid'])) {
        // if this exists, it means the user is logged in, or says not logged in if not.
        echo "<p>Hi, " . $_SESSION["useruid"] . "</p>";
        $_SESSION["login"] = true;
    ?>
        <!-- form to submit a post if logged in -->
        <form action="includes/userPost.php" method="post" id="userPost" enctype="multipart/form-data">
            <br>
            <textarea class="Textarea" rows="5" cols="40" name="posts" form="userPost" placeholder="Whats on your mind?"></textarea>
            <br>
            <textarea class="Textarea" rows="2" cols="25" name="tags" form="userPost" placeholder="#tags"></textarea>
            <br>
            <input type="file" name="postPicture" id="postPicture">
            <br>
            <!-- <button type="submit" name="submit">Post</button> -->
            <button class="button is-success" type="submit" name="submit">
                <span>Post!</span>
            </button>
        </form>

    <?php
    } else {
        echo '<h1>NOT LOGGED IN</h1>';
    }
    // javascript error popup telling user they arent
    // logged in if they happen to try and features that require an account
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "notLoggedIn") {
            echo "<script language='javascript'>";
            echo 'alert("Please log in to use this feature");';
            echo "</script>";
        }
    }
    ?>


</section>

<!-- section dealing with the posts -->
<section class="post">
    <!-- post refreshing button -->
    <button id="refreshButton">
        <i class="fas fa-sync" id="spinButton"></i>
        REFRESH
    </button>
</section>


<section class="feed">
    <!-- centered tag to make sure everything within this div (everything in the feed)
is centered,. displaypost.php handles outputting all the content -->
    <div class="content-container centered" id="content">
        <?php
        include_once 'includes/displayPost.php';
        ?>
    </div>
    <!-- script to reload posts after certain functions or when the refresh spinner is clicked -->
    <script>
        function loadPosts() {
            $('#content').load("includes/displayPost.php");
        }
        $(document).ready(function() {
            $('#content').load("includes/displayPost.php");
        });
        $("#refreshButton").on('click', function() {
            $("#spinButton").addClass("fa-spin");
            setTimeout(function() {
                // removing class "fa-spin" from #spinButton after 300 ms
                $("#spinButton").removeClass("fa-spin");
            }, 2000);
            loadPosts();
        });
    </script>
</section>


<?php
include_once 'footer.php';
?>