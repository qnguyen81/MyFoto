<?php 
    session_start();
    require('connection.php');
        $query = "SELECT * FROM users";
        $stmt = $db-> prepare($query);
        $stmt-> execute();

        $query1 = "SELECT * FROM post p JOIN users u ON p.userId = u.userId ORDER BY timeStamp desc";
        $stmt1 = $db-> prepare($query1);
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
            <li><a name="Home" href="index.php"><i class="fas fa-home"></i>Home</a></li>
            <li class="twitter__bird"><i class="fas fa-spa"></i></li>
            <li><a class="fas fa-user-alt" href="login.php"></a></li>
        </ul>
        <!-- The Modal -->
        <?php while($row = $stmt1 -> fetch()):?>
        <div class='post'>
            <ul>
                <li>
                    <h5> <?= "<img src='uploads/".$row['avatar']."' class='img' alt='test' />" ?>
                        <?=$row['userName']?><small>
                            <?=$row['timeStamp']?>
                        </small></span></li></h5>
                </li>
                <li><?=$row['content']?></li>
                <?php if($row['picture']): ?>
                <div class="square">
                    <?= "<img src='uploads/".$row['picture']."' class='img-responsive center-block'/>" ?>
                </div>
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