<?php 
session_start();
require("connection.php");
if(isset($_SESSION['user']))
{
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $queryall = "SELECT * FROM users WHERE userId = :id";
    $stmt= $db->prepare($queryall);
    $stmt -> bindValue(":id",$id);
    $stmt->execute();

  if(isset($_POST['delete']))
  {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
   	 	$query = "DELETE FROM users WHERE userId = :id LIMIT 1";
   		 $statement = $db->prepare($query);
    	$statement->bindValue(':id', $id, PDO::PARAM_INT);
       $statement->execute();
       header("location:manageUser.php");
  }
  if(isset($_POST['save']))
  {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $account = filter_input(INPUT_POST, 'account', FILTER_SANITIZE_STRING);

    $update = "UPDATE users SET firstName = :firstName , lastName = :lastName , account =:account WHERE userId = :id";

    $stmt1 = $db->prepare($update);
    $stmt1-> bindValue(":firstName",$firstName);
    $stmt1-> bindValue(":lastName",$lastName);
    $stmt1-> bindValue(":account",$account);
    $stmt1->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt1-> execute();
    header("location:manageUser.php");
  }
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
                    <a class="nav-link" name="post" href="#">Manage Post</a>
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
    <div>

        <div class="container">
            <h2>Edit User </h2>
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <div id="first">
                        <div class="myform form ">
                            <div class="logo mb-3">
                                <div class="col-md-12 text-center">
                                </div>
                            </div>
                            <form action="editUser.php" method="post" enctype='multipart/form-data'>
                            <?php while($row = $stmt -> fetch()):?>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">First name:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" name='firstName' type="text" value='<?=$row['firstName']?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Last name:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" name='lastName' type="text" value='<?=$row['lastName']?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Email:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" name='email' type="text" value='<?=$row['email']?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Username:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" name='account' type="text" value='<?=$row['account']?>'>
                                    </div>
                                </div>
                                    <hr>
                                        <input type="submit" class="btn btn-outline-primary" name='save' value = 'Save Change'>
                                        <input type="submit" value="Delete" class="btn btn-outline-danger" name='delete' onclick="return confirm('Are you sure you wish to delete this User?')">
                                <?php endwhile ?>
                            </form>
                        </div>
                    </div>
</body>

</html>