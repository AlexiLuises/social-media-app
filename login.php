<?php
// page for users to log in from
include_once 'header.php';
?>
<br> <br>
<!-- bulma based login form -->
<div class="login-form">
    <h2 class="title is-4">Log In</h2>
    <div class="field">
        <form action="includes/loginValidate.php" method="post">
            <label class="label">Username</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-small" type="text" name="uid" placeholder="Username/email">
                <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
            </div>
    </div>

    <div class="field">
        <label label class="label">Password</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="password" name="pwd" placeholder="Password...">
            <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>

    <button class="button is-success" type="submit" name="submit">
        <span class="icon is-small">
            <i class="fas fa-check"></i>
        </span>
        <span>Submit!</span>
    </button>

    </form>
    <br>
    <!-- Password reset link -->
    <a href="resetPassword.php"> Forgot your password? </a>
</div>

<?php
// checking for information in the URL we can see since we are looking for GET not POST
if (isset($_GET["newpass"])) {
    if ($_GET["newpass"] == "passchanged") {
        echo "<p>Password has been changed!</p>";
    }
}
?>

<?php
// checking for information in the URL we can see since we are looking for GET not POST
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
    } else if ($_GET["error"] == "wronglogin") {
        echo "<p>incorrect login info</p>";
    }
}
?>

<?php
include_once 'footer.php';
?>