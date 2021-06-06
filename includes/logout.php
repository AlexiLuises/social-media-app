<?php
// page to end session and log out
session_start();
session_unset();
session_destroy();

header("Location: ../index.php");
