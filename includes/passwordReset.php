<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
require 'database.php';

// check if user gets to this page correctly (Via a post method called Password-Reset-Requested)
if (isset($_POST["Password-Reset-Requested"])) {
    // creating two tokens to restrict timing attacks (brute force attacks)
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    // . used to include php in url outside of double quotes
    $url = "http://localhost/social-media-app/createNewPassword.php?selector=".$selector."&validator=".bin2hex($token);

    // expire the token in half an hour (1800 seconds)
    $expire = date("U") + 1800;
    $userEmail = $_POST["email"];

    // ? is for prepared statement ($stmt)
    // this deletes any existing token from the user so they do not have multiple
    $sql = "DELETE FROM passwordreset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo "Error has occured";
        exit();
    }
    else{
        // says what the ? (prepared statement) will be replaced with by the user
        mysqli_stmt_bind_param($stmt,"s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO  passwordreset (pwdResetEmail,pwdResetSelector,pwdResetToken,PwdResetExpire) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo "Error has occured";
        exit();
    }
    else{

        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,"ssss", $userEmail,$selector,$hashedToken,$expire);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);



    $recipient = $userEmail;
    $subject = 'password reset for social media site';
    $emailMessage = '<p>A password reset request was received, click the link to reset your password.<br>If you did not make this request, ignore this email<br>
    Password Reset Link: <br>';
    $emailMessage .= '<a href="'.$url.'">'.$url.'</a></p>';

    // use PHPMailer to send the email
    function sendEmail($recipient, $subject, $emailMessage){
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'f47c1454168c63';                     // SMTP username
            $mail->Password   = 'eb438fbd081e1d';                       // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('staff@test.com', 'Mailer');
            $mail->addReplyTo('alexi.luises18@bathspa.ac.uk'); //incase they need to reply
            $mail->addAddress($recipient); // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $emailMessage;

            $mail->send();
            header("Location: ../resetPassword.php?resetrequest=success");
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    sendEmail($recipient,$subject,$emailMessage);
}
else {
    header("Location: ../index.php");
}
