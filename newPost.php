<?php
    session_start();
    require('connection.php');

    if(isset($_POST['submit']))
    {
        $query = "SELECT * FROM users";
        $stmt = $db-> prepare($query);
        $stmt-> execute();
        if(!empty($_POST['status'])){
            $content = filter_input(INPUT_POST,'status', FILTER_SANITIZE_STRING);
            $user = $_SESSION['user'];
            include('upload.php');
            $query = "INSERT INTO post (userName, content) VALUES (:user, :content)";
            $stmt = $db->prepare($query);
            $stmt->bindValue(":user",$user);
            $stmt->bindValue(":content",$content);
            $stmt->execute();
            header("location:main.php?id=$_GET['id']");
        } 
    }
    else
    {
        echo "error";
    }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"> <?=$_SESSION['user']?> </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="main.php">Newsfeed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="newPost.php">New Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>New Posts</h2>
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                            </div>
                        </div>
                        <form action="newPost.php" method="post" enctype='multipart/form-data'>
                        <?php while($row = $stmt -> fetch()):?>
                        <input type="hidden" name="id" value="<?=$row['userId'] ?>">
                        <?php endwhile ?>
                            <div class="form-group">
                                <label for="status"></label>
                                <TextArea class="form-control" rows="5" name='status'
                                    placeholder="What are you thinking?"></TextArea>
                            </div>
                    </div>
                    <div class="custom-file">
                        <input type="file" name='file'>
                        <label for="file"></label>
                    </div>
                    <div class="col-md-12 text-center ">
                        <button type="submit" id="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
                            name="submit">Post</button>
                    </div>
                    </form>
                </div>
            </div>
</body>

</html>