<?php
require 'header.php';
?>
<!-- Page to reset your password -->
<br> <br>
<section class="Password-Reset-form">
    <P>Please reset your password here</P>
    <?php
    // takes selector/validator from url (found line 9 passwordReset.php)
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    // checking to see if selector/vaidator empty
    if (empty($selector) || empty($validator)) {
        echo "we couldnt validate request";
    } else {
        // check to make sure the token is hexedecimal
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
    ?>
            <form action="includes/resetCurrentPassword.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                <input type="password" name="password" value="Enter new password">
                <input type="password" name="password-repeat" value="Enter password again">
                <button type="submit" name="password-reset-submition">Reset password!</button>
            </form>
    <?php
        }
    }
    ?>

</section>

<?php
require 'footer.php';
?>