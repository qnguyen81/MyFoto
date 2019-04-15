<?php 
session_start();
require("connection.php");
if(isset($_SESSION['user']))
{
    $id= $_GET['id'];

    if($_GET['a']=="n")
    {
            $save2=false;
    }
    else
    {
        $save2=true;
    }
    $queryPost = "SELECT * FROM post WHERE postId = :id ORDER BY timeStamp desc";
    $stmt4 = $db-> prepare($queryPost);
    $stmt4->bindValue(":id",$id);
    $stmt4-> execute(); 
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
    <title>MyFoto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=29mo2x4983hehdzlv8pqr10yx62i9kyyzi79sak0p9px2ykk">
    </script>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script type="text/javascript" src="function.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script>
    tinymce.init({
        selector: "textarea",
        forced_root_block: "",
    });
    </script>

</head>

<body>
    <main>
        <ul class="myfoto" role="navigation">
            <li><a name="Home" href="main.php?page=0&ord=1"><i class="fas fa-home"></i>Home</a></li>
            <li class="twitter__bird"><i class="fas fa-spa"></i></li>
            <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i
                        class="fas fa-plus-square"></i></button></li>
            <li><a class="fas fa-user-alt"
                    href='personal.php?id=<?=$_SESSION['userId']?>&acc=<?=$_SESSION['user']?>'></a></li>
            <li><a class="fas fa-sign-out-alt" href="logout.php"></a></li>
        </ul>
        <?php while($row = $stmt4 -> fetch()):?>
        <div class='post'>
            <form action="actions.php" method="post">
                <TextArea class="form-control" rows="10" name='status'><?=$row['content']?></TextArea>
                <input type="hidden" name="postId" value="<?=$row['postId']?>">
                <input type="hidden" name="acctId" value="<?=$_GET['user']?>">
                <input type="hidden" name="acc" value="<?=$_GET['acc']?>">
                <?php if($save2):?>
                <input type="submit" value="Save Changes" class="btn btn-outline-danger" name='save2'">
                                <?php else: ?>
                                <input type=" submit" value="Save Change" class="btn btn-outline-danger" name='save1'">
                                <?php endif ?>
                                </form>
        </div>
        </div>
        <?php endwhile ?>
    </main>
</body>

</html>