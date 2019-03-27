<?php 
    session_start();
    require('connection.php');
    require_once("composer/vendor/autoload.php");
    print_r( $_SESSION['userId']);
    if(isset($_POST['post']))
    {
        if(!empty($_POST['status'])){
            $content = filter_input(INPUT_POST,'status', FILTER_SANITIZE_STRING);
            $user = $_SESSION['user'];
            $userId = $_SESSION['userId'];
            include('upload.php');
            $query2 = "INSERT INTO post (userName, content,userId) VALUES (:user, :content,:userId)";
            $stmt2 = $db->prepare($query2);
            $stmt2->bindValue(":user",$user);
            $stmt2->bindValue(":content",$content);
            $stmt2->bindValue(":userId",$userId);
            $stmt2->execute();
            header("location:main.php");
        } 
    }

        if(isset($_SESSION['user']))
        {
            $user = $_SESSION['user'];
            $query = "SELECT avatar FROM users WHERE account = :user";
            $stmt = $db-> prepare($query);
            $stmt->bindValue(":user",$user);
            $stmt-> execute();

            $query1 = "SELECT * FROM post p JOIN users u ON p.userId = u.userId ORDER BY timeStamp";
            $stmt1 = $db-> prepare($query1);
            $stmt1->bindValue(":user",$user);
            $stmt1-> execute(); 

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
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script type="text/javascript" src="function.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>

<body>
    <main>
        <ul class="myfoto" role="navigation">
            <li><i class="fas fa-home"></i>Home</li>
            <li class="twitter__bird"><i class="fas fa-spa"></i></li>
            <li><button type="button" class="fas fa-plus-square"data-toggle="modal" data-target="#myModal"></button></li>
            <li><i class="fas fa-user-alt" class="nav-item dropdown"></i></li>
            <li><i class="fas fa-sign-out-alt"></i></li>
        </ul>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Post</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="main.php" method="post" enctype='multipart/form-data'>
                            <div class="form-group">
                                <label for="status"></label>
                                <TextArea class="form-control" rows="5" name='status'
                                    placeholder="What are you thinking?"></TextArea>
                            </div>
                            <div class="custom-file">                         
                                <input type="file" name='file' class="inputfile">
                                <label for="file"></label>
                            </div>
                        
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="post" class="btn btn-outline-primary" name="post"> Post <i class="fas fa-paper-plane"></i></button>
                    </div>
    </form>
                </div>
            </div>
        </div>
        <?php while($row = $stmt1 -> fetch()):?>
        <div class='post'>
            <ul>
                <li>
                    <h5> <?= "<img src='uploads/".$row['avatar']."' class='img' alt='test' />" ?>
                        <?=$row['userName']?><small>
                            <?=$row['timeStamp']?>
                        </small></h5>
                </li>
                <li><?=$row['content']?></li>
                <button type="submit" class="btn btn-outline-primary" name='like'> <i
                        class="far fa-thumbs-up"></i>Like</button>
                <button type="submit" class="btn btn-outline-primary" name='comment'> <i
                        class="fas fa-comments"></i>Comment</button>
            </ul>
        </div>
        <?php endwhile ?>
        <div></div>
    </main>
</body>

</html>
