<?php 
    session_start();
    require('connection.php');
        if(isset($_SESSION['user']))
        {
            $user = $_SESSION['user'];
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
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin [<?=$_SESSION['user']?>]</a>
        <a class="navbar-brand" href="#">
            <?php while($row = $stmt -> fetch()):?>
            <?= "<img src='uploads/".$row['avatar']."' class='img-circle' alt='test' />" ?>
            <?php endwhile ?>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" name="Home" href="admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" name="post" href="#">Manage Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" name="user" href="manageUser.php">Manage User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


</body>

</html>