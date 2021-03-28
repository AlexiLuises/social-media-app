<?php 
    include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    
    <script>
    $(document).ready(function() {
        var commentCount = 2;
        $("button").click(function(){
            commentCount = commentCount + 2;
            $("#comments").load("loadComments.php", {
             updatedCommentCount: commentCount
            });

        })
    });
    </script>
    
    <title>Ajax</title>
</head>
<body>
    <div id="comments">
     <?php 
      $sql = "SELECT * FROM comments LIMIT 2";
      $result = mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0 ) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<p>";
              echo $row['author'];
              echo "<br>";
              echo $row['message'];
              echo "<p>";
          }
      } else {
          echo "There are no comments to be loaded";
      }
     ?>
    </div>
    <button>Show more Comments</button>
</body>
</html>