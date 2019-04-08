<?php 
    session_start();
    require('connection.php');
    require_once('composer\vendor\autoload.php');
    print_r( $_SESSION['userId']);print_r( $_SESSION['user']);
    if(isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];
        $query = "SELECT avatar FROM users WHERE account = :user";
        $stmt = $db-> prepare($query);
        $stmt->bindValue(":user",$user);
        $stmt-> execute();

        $query1 = "SELECT * FROM post p JOIN users u ON p.userId = u.userId ORDER BY timeStamp desc";
        $stmt1 = $db-> prepare($query1);
        $stmt1->bindValue(":user",$user);
        $stmt1-> execute(); 


        $comment = "SELECT * FROM comment  ORDER BY timeStamp desc";
        $stmt2 = $db-> prepare($comment);
        $stmt2-> execute(); 
    }
    else
    {
        header("location:Login.php");
    }

    if(isset($_POST['addComment']))
    {
        if(!empty($_POST['txtcomment']))
        {
            $user = $_SESSION['user'];
            $userId = $_SESSION['userId'];
            $comment =filter_input(INPUT_POST,'txtcomment', FILTER_SANITIZE_STRING);
            $comt = "INSERT INTO comment (commenter, content,userId) VALUES (:user, :content,:userId)";
            $stmt3 = $db->prepare($comt);
            $stmt3->bindValue(":user",$user);
            $stmt3->bindValue(":content",$comment);
            $stmt3->bindValue(":userId",$userId);
            $stmt3->execute();
            header("location:main.php");
        }
    }

    if(isset($_POST['post']))
    {
        if(!empty($_POST['status'])){
            $content = $_POST['status'];
            $user = $_SESSION['user'];
            $userId = $_SESSION['userId'];
            if(file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name']) )
            {
             function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
                $current_folder = dirname(__FILE__);
                
                $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
                
                return join(DIRECTORY_SEPARATOR, $path_segments);
             }
          
             function file_is_valid($temporary_path, $new_path) {
                 $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
                 $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
                 
                 $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
                 $actual_mime_type        = getimagesize($temporary_path)['mime'];
                 
                 $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
                 $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
                 
                 return $file_extension_is_valid && $mime_type_is_valid;
             }
          
             $file_upload_detected = isset($_FILES['file']) && ($_FILES['file']['error'] === 0);
             $upload_error_detected = isset($_FILES['file']) && ($_FILES['file']['error'] > 0);
          
             if ($file_upload_detected) { 
                 $file_filename        = $_FILES['file']['name'];
                 $temporary_file_path  = $_FILES['file']['tmp_name'];
                 $new_file_path        = file_upload_path($file_filename);
                 if (file_is_valid($temporary_file_path, $new_file_path)) {
                     move_uploaded_file($temporary_file_path, $new_file_path);
                     $img = $_FILES['file']['name'];
                 }
             }
            }

            $query2 = "INSERT INTO post (userName, content,userId,picture) VALUES (:user, :content,:userId,:picture)";
            $stmt2 = $db->prepare($query2);
            $stmt2->bindValue(":user",$user);
            $stmt2->bindValue(":picture",$img);
            $stmt2->bindValue(":content",$content);
            $stmt2->bindValue(":userId",$userId);
            $stmt2->execute();
            header("location:main.php");
        } 
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
                            <TextArea class="form-control" rows="10" name='status'
                                placeholder="What are you thinking?"></TextArea>
                        </div>
                        <div class="custom-file">
                            <input type="file" name='file' class="inputfile">
                            <label for="file"></label>
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" id="post" class="btn btn-outline-primary" name="post"> Post <i
                            class="fas fa-paper-plane"></i></button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <main>
        <ul class="myfoto" role="navigation">
            <li><a name="Home" href="main.php"><i class="fas fa-home"></i>Home</a></li>
            <li class="twitter__bird"><i class="fas fa-spa"></i></li>
            <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i
                        class="fas fa-plus-square"></i></button></li>
            <li><i class="fas fa-user-alt" class="nav-item dropdown"></i></li>
            <li><a class="fas fa-sign-out-alt" href="logout.php"></a></li>
        </ul>
        <!-- The Modal -->
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
                <?php if($row['picture']): ?>
                <div class="square">
                    <?= "<img src='uploads/".$row['picture']."' class='img-responsive center-block'/>" ?>
                </div>
                <?php endif?>
                <hr>
                <div class="like">
                    <button type="submit" class="btn btn-outline-primary" name='like'> <i
                            class="far fa-thumbs-up"></i>Like</button>
                    <button type="submit" class="btn btn-outline-primary" name='comment'> <i
                            class="fas fa-comments"></i>Comment</button>
                </div>
                <hr>
                <form action="main.php" method="post" name="commentForm">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Your comments" name="txtcomment" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" name="addComment">Add</button>
                    </div>
                </form>
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