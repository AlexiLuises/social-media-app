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
            echo 'alert("Please log in to use this feature");';
            echo "</script>";
        }
      }
      ?>
            <h1>this is a paragraph</h1>
            <p>hello hello yes intro</p>
        </section>

        <section class="post">
            <form action="includes/userPost.php" method="post" id="userPost" enctype="multipart/form-data">
            <br>
            <textarea rows="5" cols="40" name="posts" form="userPost" placeholder="Whats on your mind?"></textarea>
            <br>
            <textarea rows="2" cols="25" name="tags" form="userPost" placeholder="#tags"></textarea>
            <br>
            <input type="file" name="postPicture" id="postPicture">
            <br>
            <button type="submit" name="submit">Post</button>
            </form>
            <button id="refreshButton">
            <i class="fas fa-sync" id="spinButton"></i>
            REFRESH
            </button>
        </section>

    <section class="feed">
    <div id="content">
    <?php
    include_once 'includes/displayPost.php';
    ?>
    </div>

    <script>
    function loadPosts() {
        $('#content').load("includes/displayPost.php");
    }
    $(document).ready(function(){
        $('#content').load("includes/displayPost.php");
    });
    $("#refreshButton").on('click',function(){
        $("#spinButton").addClass("fa-spin");
        setTimeout(function(){
            // removing class "fa-spin" from #spinButton after 300 ms
            $("#spinButton").removeClass("fa-spin");
        },2000);
        loadPosts();
    });


    </script>
    </section>


<?php
    include_once 'footer.php';
?>