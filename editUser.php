<?php 
session_start();
require("connection.php");
if(isset($_SESSION['user']))
{
    $id= $_GET['id'];
    $queryPost = "SELECT * FROM post p JOIN users u ON p.userId = u.userId WHERE p.userId = :id ORDER BY timeStamp desc";
    $stmt4 = $db-> prepare($queryPost);
    $stmt4->bindValue(":id",$id);
    $stmt4-> execute(); 


    if(isset($_POST['delete']))
    {
    // $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

      $query = "DELETE FROM users WHERE userId = :id";
        $statement = $db->prepare($query);
      $statement->bindValue(':id',$id);
     $statement->execute();
     header("location:manageUser.php");
    }
    //$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $id= $_GET['id'];
    $queryall = "SELECT * FROM users WHERE userId = :id";
    $stmt= $db->prepare($queryall);
    $stmt -> bindValue(":id",$id);
    $stmt->execute();

  if(isset($_POST['save']))
  {
    //$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $id= $_GET['id'];
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $account = filter_input(INPUT_POST, 'account', FILTER_SANITIZE_STRING);

    $update = "UPDATE users SET firstName =:firstName , lastName=:lastName , account =:account WHERE userId = :id";

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
    <script src="main.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="edit.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin [<?=$_SESSION['user']?>]</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" name="Home" href="admin.php">Home</a>
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
                            <form action="actions.php" method="post">
                                <?php while($row = $stmt -> fetch()):?>
                                <input type="hidden" name="id" value="<?=$row['userId']?>">
                                <input type="hidden" name="account" value="<?=$row['account']?>">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">First name:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" name='firstName' type="text"
                                            value='<?=$row['firstName']?>'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Last name:</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" name='lastName' type="text"
                                            value='<?=$row['lastName']?>'>
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
                                        <input class="form-control" name='account' type="text"
                                            value='<?=$row['account']?>'>
                                    </div>
                                </div>
                                <hr>
                                <input type="submit" class="btn btn-outline-primary" name='save' value='Save Change'
                                    onclick="return confirm('Are you sure you wish to modify this User?')">
                                <input type="submit" value="Delete" class="btn btn-outline-danger" name='delete'
                                    onclick="return confirm('Are you sure you wish to delete this User?')">
                                <?php endwhile ?>
                            </form>
                        </div>
                        <hr>
                        <h2>All Posts</h2>

                    </div>

                </div>

                <?php while($row = $stmt4 -> fetch()):?>
                <div class='post'>
                    <ul>
                        <li>
                            <h5><?=$row['userName']?><small>
                                    <?=$row['timeStamp']?>
                                </small></span>
                            </h5>
                        </li>

                        </li>
                        <li><?=$row['content']?><a class="float-right"
                                href='edit.php?id=<?=$row['postId']?>&user=<?=$row['userId']?>&acc=<?=$row['account']?>&a=y'
                                id="edit">Edit</a></li>
                        <?php if($row['picture']): ?>
                        <div class="square">
                            <li> <?= "<img src='uploads/".$row['picture']."' class='img-responsive center-block'/>" ?>
                            </li>
                        </div>
                        <?php endif?>
                        <hr>
                        <form action="actions.php" method="post">
                            <input type="hidden" name="postId" value="<?=$row['postId']?>">
                            <input type="hidden" name="acctId" value="<?=$_GET['id']?>">
                            <input type="submit" value="Delete Post" class="btn btn-outline-danger" name='deletePost'
                                onclick="return confirm('Are you sure you wish to delete this Post?')">
                            <?php if($row['picture']): ?>
                            <input type="submit" value="Delete Picture" class="btn btn-outline-danger" name='deletePic'
                                onclick="return confirm('Are you sure you wish to delete this Picture?')">
                            <?php endif?>
                        </form>
                </div>
                <?php endwhile ?>


</body>

</html>