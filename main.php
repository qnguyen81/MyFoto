<?php 
    session_start();
    require('connection.php');
        if(isset($_SESSION['user']))
        {
            $user = $_SESSION['user'];
            echo "welcome"."  ".$_SESSION['user']; 
            $query = "SELECT avatar FROM users WHERE account = :user";
            $stmt = $db-> prepare($query);
            $stmt->bindValue(":user",$user);
            $stmt-> execute();
        }
        else
        {
            header("location:Login.php");
        }
?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <?php while($row = $stmt -> fetch()):?>
        <?= "<img src='uploads/".$row['avatar']."' alt='test' />"?>
  <?php endwhile ?>
</body>
</html>