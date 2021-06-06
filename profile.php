<?php
// profile page
include_once 'header.php';
include_once 'includes/loadPosts.php';
include_once 'includes/database.php';
include_once 'includes/functions.php';
include_once 'includes/loadComments.php';
include_once 'includes/getProfilePage.php';

$userData = getUsers($conn, $_GET['profileName']);
$profileName = $_GET['profileName'];


if (isset($_SESSION['useruid'])) {
    // if this exists, it means the user is logged in
    $_SESSION["login"] = true;
}

if (isset($_GET["error"])) {
    if ($_GET["error"] == "notLoggedIn") {
        echo "<script language='javascript'>";
        echo 'alert("Please log in to see your profile page");';
        echo "</script>";
    }
}
// if it is the logged in users profile page
// show extra functionality (change profile picture and name)
if ($_SESSION['useruid'] == $profileName) {

    echo '<br>';
    echo '<form action="includes/uploadImage.php" method="post" enctype="multipart/form-data">';
    echo 'Select image to upload:';
    echo '<br>';
    echo '<input type="file" name="profilePicture" id="profilePicture" required>';
    echo '<input type="hidden" name="profileName" value="' . $profileName . '">';
    echo '<br>';
    echo '<input type="submit" value="Upload Image" name="submit">';
    echo '</form>';

    echo '<br>';
    echo '<form action="includes/nameChange.php" method="post">';
    echo 'What would you like to change your name to?';
    echo '<br>';
    echo '<input type="text" name="newFirstName" id="newFirstName" placeholder="First name">';
    echo '<input type="text" name="newLastName" id="newLastName" placeholder="Last name">';
    echo '<input type="hidden" name="profileName" value="' . $profileName . '">';
    echo '<br>';
    echo '<input type="submit" value="Submit new name" name="submit">';
    echo '</form>';
    echo '<br>';
}
?>
<section class="post">
    <!-- post refresh button -->
    <button id="refreshButton">
        <i class="fas fa-sync" id="spinButton"></i>
        REFRESH
    </button>
</section>

<br>
<section class="feed">
    <!-- centered container, uses displayProfilePost.php to handle outputting information -->
    <div class="content-container centered" id="content">
        <?php
        include_once 'includes/displayProfilePost.php';
        ?>
    </div>

    <!-- script to reload posts after using certain functions or when clicking refresh spinner -->
    <script>
        function loadPosts() {
            $('#content').load("includes/displayProfilePost.php?profileName=<?php echo $_GET["profileName"] ?>");
        }
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