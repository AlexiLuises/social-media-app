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
</head>
<body>
    <nav>
        <div class="wrapper">
            <div class="navigation">
            <a href="index.php"></a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="discover.php">about us</a></li>
                <li><a href="blog.php"> find blogs</a></li>
                <?php
                a
                // check to see if user is logged in
                if (isset($_SESSION['useruid'])) {
                    // if this exists, it means the user is logged in
                    echo "<li><a href='profile.php'>profile Page</a></li>";
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