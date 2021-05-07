<?php
// since header is being included on every page, every page will have session started
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP project</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
    <nav>
        <div class="wrapper">
            <div class="navigation">
            <a href="index.php"></a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                // check to see if user is logged in
                if (isset($_SESSION['useruid'])) {
                    // if this exists, it means the user is logged in
                    echo "<li><a href='profile.php?profileName=".$_SESSION["useruid"]."'>profile Page</a></li>";
                    echo "<li><a href='includes/logout.php'>log out</a></li>";
                }
                else {
                    echo "<li><a href='signup.php'>sign up</a></li>";
                    echo "<li><a href='login.php'>log in</a></li>";
                }
                ?>
            </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper">