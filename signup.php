<?php
// page used to sign up to the website
include_once 'header.php';
?>

<br> <br>
<!-- form for signup -->
<div class="signup-form">
    <h2 class="title is-4">Sign Up</h2>
    <div class="field">
        <form action="includes/signupValidate.php" method="post">
            <label class="label"></label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-small" type="text" name="name" placeholder="First name...">
                <input class="input is-small" type="text" name="surname" placeholder="Surname...">
                <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
            </div>
    </div>

    <div class="field">
        <label label class="label"></label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="text" name="email" placeholder="Email...">
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
    </div>

    <div class="field">
        <label label class="label"></label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="text" name="uid" placeholder="Username...">
            <span class="icon is-small is-left">
                <i class="fas fa-at"></i>
            </span>
        </div>
    </div>

    <div class="field">
        <label label class="label"></label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="text" name="gender" placeholder="Gender">
            <span class="icon is-small is-left">
                <i class="fas fa-venus-mars"></i>
            </span>
        </div>
    </div>

    <div class="field">
        <label label class="label"></label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="tel" name="phone" placeholder="Phone Nbr: 07234567891">
            <span class="icon is-small is-left">
                <i class="fas fa-mobile"></i>
            </span>
        </div>
    </div>

    <div class="field">
        <label label class="label"></label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="password" name="pwd" placeholder="Password...">
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
        </div>
    </div>


    <div class="field">
        <label label class="label"></label>
        <div class="control has-icons-left has-icons-right">
            <input class="input is-small" type="password" name="pwdrepeat" placeholder="Repeat password">
            <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
            </span>
        </div>
    </div>


    <button class="button is-success" type="submit" name="submit">
        <span class="icon is-small">
            <i class="fas fa-check"></i>
        </span>
        <span>Submit!</span>
    </button>
    <br><br>
    </form>
</div>





<?php
// checking for information in the URL we can see since we are looking for GET not POST
// checking for many different errors from functions.php to see if anything
// couldnt be validated
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
    } elseif ($_GET["error"] == "invaliduid") {
        echo "<p>Choose a proper Username</p>";
    } elseif ($_GET["error"] == "invalidemail") {
        echo "<p>Choose a proper email</p>";
    } elseif ($_GET["error"] == "passwordsdontmatch") {
        echo "<p>passwords dont match</p>";
    } elseif ($_GET["error"] == "stmtfailed") {
        echo "<p>something went wrong, try again!</p>";
    } elseif ($_GET["error"] == "usernameoremailtaken") {
        echo "<p>username or password already used</p>";
    } elseif ($_GET["error"] == "none") {
        echo "<p>Success!</p>";
    }
}
?>
<?php
include_once 'footer.php';
?>