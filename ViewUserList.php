<?php 
session_start();
require("connection.php");
$admin= "a";
$home=false;
    $query = "SELECT * FROM users WHERE role != :admin";
    $stmt = $db-> prepare($query);
    $stmt->bindValue(":admin",$admin);
    $stmt-> execute();

    if(isset($_SESSION['user']))
    {
        $home = true;
    }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
</head>

<body>
<main>
    <ul class="myfoto" role="navigation">
    <?php if($home==true): ?>
            <li><a name="Home" href="main.php?page=0&ord=1"><i class="fas fa-home"></i>Home</a></li>
        <?php else: ?>
        <li><a name="Home" href="index.php"><i class="fas fa-home"></i>Home</a></li>
        <?php endif ?>
            <li class="twitter__bird"><i class="fas fa-spa"></i></li>
               <?php if($home==true): ?>
            <li><a class="fas fa-sign-out-alt" href="logout.php"></a></li>
        <?php else: ?>
        <li><a class="fas fa-user-alt" href="login.php"></a></li>
        <?php endif ?>
            <li><a class="fas fa-list-alt" href="ViewUserList.php">User</a></li>
        </ul>
    <div class="container">
    <h2>People using Foto</h2>
        <div class="container" style="width:900px;">
            <ul class="list-group" id="result">
                <?php while($row = $stmt -> fetch()):?>
                <div class="list-group">
                    <input type="hidden" name="id" value="<?=$row['userId']?>">
                    <li class="list-group-item">
                        <?= "<img src='uploads/".$row['avatar']."' class='img-thumbnail' height='40' width='40' alt='test' />"?>
                        |  <a href='personal.php?id=<?=$row['userId']?>&acc=<?=$row['account']?>'
                            id="edit"><?=$row['account']?></a> </li>
                </div>
                <?php endwhile ?></ul>
            <br />
        </div>
    </div>
    </main>
</body>

</html>