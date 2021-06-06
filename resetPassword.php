<?php
// page used to interface with the reset password screen
require 'header.php';
?>

<section class="Password-Reset-form">
    <h2>Password Reset</h2>
    <p>You will be emailed instructions on how you can reset your password</p>
    <form action="/includes/passwordReset.php" method="post">
        <input type="text" name="email" placeholder="Enter email">
        <button type="submit" name="Password-Reset-Requested">Reset password via Email</button>
    </form>
    <?php
    // checks to see if you get the successful redirect from passwordReset.php
    // uses isset statement to check for a reset url param
    if (isset($_GET['reset'])) {
        if ($_GET['reset'] == "success") {
            echo '<p class="resetpasswordsucces> Check your e-mail for further instructions </p>';
        }
    }
    ?>
</section>

<?php
require 'footer.php';
?>