<?php 
session_start();
require("connection.php");
    $query = "SELECT * FROM users";
    $stmt = $db-> prepare($query);
    $stmt-> execute();

    // if(isset($_POST['move']))
    // {
    //   header("location:editUser.php"); 
    // }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="main.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin [<?=$_SESSION['user']?>]</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" name="Home" href="admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" name="post" href="managePost.php">Manage Post</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" name="user" href="manageUser.php">Manage User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="mt-5 mb-5">User List </h1>
        <!-- <form action="editUser.php" method="post"> -->
            <?php while($row = $stmt -> fetch()):?>
            <div class="list-group">
                <input type="hidden" name="id" value="<?=$row['userId']?>">
                <li class="list-group-item"><?=$row['account']?> <a class="float-right" href= 'editUser.php?id=<?=$row['userId']?>' id="edit">Edit</a> </li>
            </div>
            <?php endwhile ?>
        <!-- </form> -->

    </div>
</body>

</html>