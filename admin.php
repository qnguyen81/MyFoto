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
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="function.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin [<?=$_SESSION['user']?>]</a>
        <a class="navbar-brand" href="#">
            <?php while($row = $stmt -> fetch()):?>
            <?= "<img src='uploads/".$row['avatar']."' class='img-circle' height='40' width='40' alt='test' />" ?>
            <?php endwhile ?>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" name="Home" href="admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" name="post" href="managePost.php">Manage Post</a>
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
    <br /><br />
    <div class="container" style="width:900px;">
        <h2 align="center">Search</h2>
        <h3 align="center">By account or key word</h3>
        <br /><br />
        <div align="center">
            <input type="text" name="search" id="search" placeholder="Search user Details" class="form-control" />
        </div>
        <ul class="list-group" id="result"></ul>
        <br />
    </div>
</body>

</html>
</body>

</html>