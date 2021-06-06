<?php
// since header is being included on every page, every page will have session started
session_start();
?>

<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP project</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<!-- wrapper container that wraps the entire website -->
<div class="wrapper">

  <body>
    <nav class="navbar navbar is-fixed-top" role="navigation" aria-label="main navigation" href="index.php">
      <div class="navbar-start">
        <a class="navbar-item">
          <img src="/photos/arcus_logo.png">
        </a>
        <a class="navbar-item" href="index.php">
          Home
        </a>
        <?php
        // check to see if user is logged in
        // if this exists, it means the user is logged in
        if (isset($_SESSION['useruid'])) {
          echo "<a class='navbar-item' href='profile.php?profileName=" . $_SESSION["useruid"] . "'>Profile</a>";
        }
        ?>
      </div>
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <?php
            // check to see if user is logged in
            // if this exists, it means the user is logged in
            if (isset($_SESSION['useruid'])) {
              echo "<a class='navbar-item button is-primary' href='includes/logout.php'> log out!</a>";
            } else {
              echo "<a class='navbar-item button is-primary' href='signup.php'>sign up</a>";
              echo "<a class='navbar-item button is-primary' href='login.php'>log in</a>";
            }
            ?>
          </div>
        </div>
      </div>
    </nav>