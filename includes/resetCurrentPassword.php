<?php
// page to get all information when reset password request is made

// taken post's from form in createNewPassword.php
if (isset($_POST["password-reset-submition"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["password-repeat"];

    if (empty($password) || empty($passwordRepeat)) {
        header("Location: ../login.php?newpassword=empty");
        exit();
    } else if ($password != $passwordRepeat) {
        header("Location: ../login.php?newpassword=passnotsame");
        exit();
    }
    $currentDate = date("U");
    require 'database.php';

    // used currentDate instead of ? (placeholder) because it was created by me, not something submitted by the user
    $sql = "SELECT * FROM passwordreset WHERE pwdResetSelector=? AND pwdResetExpire >=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        echo "Error has occured";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt,"ss", $selector,$currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        // associative array so we can refer to them by rows
        if (!$row = mysqli_fetch_assoc($result)) {
            echo "you need to resend your request";
            exit();
        }
        else {
            // match token in database with one in the form
            $binaryToken = hex2bin($validator);
            $tokenCheck = password_verify($binaryToken,$row["pwdResetToken"]);

            if ($tokenCheck === false) {
                echo "you need to resend your request";
                exit();


            } elseif ($tokenCheck === true) {
                // token email shows the specific email/user we are doing this for
                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE userEmail = ?;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    echo "Error has occured";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt,"s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)) {
                        echo "error occured";
                        exit();
                    }
                    else {
                        // updates password in users table
                        $sql = "UPDATE users SET userPwd=? WHERE userEmail=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt,$sql)) {
                            echo "Error has occured";
                            exit();
                        }
                        else{
                            $newPasswordHash = password_hash($password,PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash,$tokenEmail);
                            mysqli_stmt_execute($stmt);
                        }

                        $sql = "DELETE FROM passwordreset WHERE pwdResetEmail=?;";
                        $stmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt,$sql)) {
                            echo "Error has occured";
                            exit();
                        }
                        else{
                            // delete token linked to specific email (tokenEmail)
                            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../login.php?newpass=passchanged");
                        }
                    }
                }
            }
        }
    }
}

else {
    header("Location: ../index.php");
}
