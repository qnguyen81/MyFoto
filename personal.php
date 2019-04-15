<?php 
    session_start();
    require('connection.php');
    $home=false;
    $edit = false;
    if(isset($_SESSION['user']))
    {
        $home=true;
    }
    if(isset($_SESSION['user']) && $_SESSION['userId'] == $_GET['id'])
    {
        $edit = true;
    }

    print_r($_GET['id']);
    $id= $_GET['id'];
        $query = "SELECT * FROM users WHERE userId = :id";
        $stmt = $db-> prepare($query);
        $stmt->bindValue(":id",$id);
        $stmt-> execute();

        $id= $_GET['id'];
        $query1 = "SELECT * FROM post p JOIN users u ON p.userId = u.userId WHERE p.userId = :user ORDER BY timeStamp desc";
        $stmt1 = $db-> prepare($query1);
        $stmt1->bindValue(":user",$id);
        $stmt1-> execute(); 


        $comment = "SELECT * FROM comment  ORDER BY timeStamp desc";
        $stmt2 = $db-> prepare($comment);
        $stmt2-> execute(); 

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=29mo2x4983hehdzlv8pqr10yx62i9kyyzi79sak0p9px2ykk">
    </script>
    <link rel="stylesheet" type="text/css" media="screen" href="listUser.css">
    <script type="text/javascript" src="function.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

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
        <?php while($row = $stmt -> fetch()):?>
        <div class="card">
            <p><?= "<img src='uploads/".$row['avatar']."' style='width:100%' />" ?><?=$_GET['acc']?></p>
        </div>
        <hr>
        <?php endwhile?>
        <?php while($row = $stmt1 -> fetch()):?>
        <div class='post'>
            <ul>
                <li>
                    <h5><small>
                            <?=$row['timeStamp']?>
                        </small></span>
                </li>
                </h5>
                </li>
                <?php if($edit != true): ?>
                <li><?=$row['content']?></li>
                <?php else: ?>
                <li><?=$row['content']?><a class="float-right"
                        href='edit.php?id=<?=$row['postId']?>&user=<?=$row['userId']?>&acc=<?=$_GET['acc']?>&a=n'
                        id="edit">Edit</a></li>
                <?php endif?>
                <?php if($row['picture']): ?>
                <div class="square">
                    <?= "<img src='uploads/".$row['picture']."' class='img-responsive center-block'/>" ?>
                </div>
                <?php endif?>
                <?php if($edit == true): ?>
                <form action="actions.php" method="post">
                    <input type="hidden" name="postId" value="<?=$row['postId']?>">
                    <input type="hidden" name="acctId" value="<?=$_GET['id']?>">
                    <input type="hidden" name="acc" value="<?=$_GET['acc']?>">
                    <input type="submit" value="Delete Post" class="btn btn-outline-danger" name='deletePost1'
                        onclick="return confirm('Are you sure you wish to delete this Post?')">
                    <?php if($row['picture']): ?>
                    <input type="submit" value="Delete Picture" class="btn btn-outline-danger" name='deletePic1'
                        onclick="return confirm('Are you sure you wish to delete this Picture?')">
                    <?php endif ?>
                </form>
                <?php endif?>
                <?php while($row1 = $stmt2 -> fetch()):?>
                <div class="actionBox">
                    <hr>
                    <ul class="commentList">
                        <li>
                            <div class="commenterImage">

                            </div>
                            <div class=" commentText">
                                <p class=""><?=$row1['content']?></p> <span
                                    class="date sub-text"><?=$row1['timestamp']?></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php endwhile?>
        </div>
        </div>
        <?php endwhile ?>
    </main>
</body>

</html>