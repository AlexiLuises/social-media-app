<?php
    include_once 'header.php';
?>

        <section class="signup-form">
            <h2>Log In</h2>
            <form action="includes/loginValidate.php" method="post">
                <input type="text" name="uid" placeholder="Username/email">
                <input type="password" name="pwd" placeholder="Password...">
                <button type="submit" name="submit">Log In</button>
            </form>
                <!-- Password reset link -->
                <a href="resetPassword.php"> Forgot your password? </a>
                <?php
            // checking for information in the URL we can see since we are looking for GET not POST
            if (isset($_GET["newpass"]))
            {
                if ($_GET["newpass"] == "passchanged") {
                    echo "<p>Password has been changed!</p>";
                }
            }
    ?>

        <?php
            // checking for information in the URL we can see since we are looking for GET not POST
            if (isset($_GET["error"]))
            {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "wronglogin") {
                    echo "<p>incorrect login info</p>";
                }
            }
    ?>
        </section>

<?php
    include_once 'footer.php';
?>