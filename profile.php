<?php
    include_once 'header.php';
?>


<?php
            if (isset($_SESSION['useruid'])) {
                // if this exists, it means the user is logged in
                echo "<p>Hi, ".$_SESSION["useruid"] ."</p>";
                $_SESSION["login"] = true;
            }

            if(isset($_GET["error"])){
            if($_GET["error"] == "notLoggedIn"){
            echo "<script language='javascript'>";
            echo 'alert("Please log in to see your profile page");';
            echo "</script>";
        }
      }
      ?>
    //TODO Call php function? >pass through ID name as url?
      
