<?php
    include_once 'header.php';
?>

        <section class="signup-form">
            <h2>Sign Up</h2>
            <form action="includes/signupValidate.php" method="post">
                <input type="text" name="name" placeholder="First name...">
                <input type="text" name="surname" placeholder="Surname">
                <input type="text" name="email" placeholder="Email...">
                <input type="text" name="uid" placeholder="Username...">
                <input type="text" name="gender" placeholder="Gender">
                <input type="tel" name="phone" placeholder="Phone Nbr: 07234567891">
                <input type="password" name="pwd" placeholder="Password...">
                <input type="password" name="pwdrepeat" placeholder="Repeat password...">
                <button type="submit" name="submit">Sign Up</button>
            </form>

            <?php
        // checking for information in the URL we can see since we are looking for GET not POST
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all fields!</p>";
            }
            elseif ($_GET["error"] == "invaliduid") {
                echo "<p>Choose a proper Username</p>";
            }
            elseif ($_GET["error"] == "invalidemail") {
                echo "<p>Choose a proper email</p>";
            }
            elseif ($_GET["error"] == "passwordsdontmatch") {
                echo "<p>passwords dont match</p>";
            }
            elseif ($_GET["error"] == "stmtfailed") {
                echo "<p>something went wrong, try again!</p>";
            }
            elseif ($_GET["error"] == "usernameoremailtaken") {
                echo "<p>username or password already used</p>";
            }
            elseif ($_GET["error"] == "none") {
                echo "<p>Success!</p>";
            }
        }
        ?>
        </section>

<?php
    include_once 'footer.php';
?>