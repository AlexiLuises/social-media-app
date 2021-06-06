<?php
// page used to interface with the reset password screen
include_once 'header.php';
?>
    <!-- <h2>Password Reset</h2>
    <p>You will be emailed instructions on how you can reset your password</p>
    <form action="/includes/passwordReset.php" method="post">
        <input type="text" name="email" placeholder="Enter email">
        <button type="submit" name="Password-Reset-Requested">Reset password via Email</button>
    </form> -->
    <br> <br>
    <section class="Password-Reset-form">
    <div class="Password-Reset-form">
    <h2 class="title is-4">Enter email</h2>
    <p>You will be emailed instructions on how you can reset your password</p>
    <div class="field">
    <form action="/includes/passwordReset.php" method="post">
            <label class="label">Enter email</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-small" type="text" name="email" placeholder="email">
            </div>
    </div>
    <button class="button is-success" type="submit" name="Password-Reset-Requested">
        <span>Reset password via email</span>
    </button>
    </form>

    <?php
    // checks to see if you get the successful redirect from passwordReset.php
    // uses isset statement to check for a reset url param
    if (isset($_GET['resetrequest'])) {
        if ($_GET['resetrequest'] == "success") {
            echo '<p class="label"> Check your e-mail for further instructions </p>';
        }
    }



    ?>
    </div>
    </section>

<?php
require 'footer.php';
?>