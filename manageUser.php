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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            cache: false
        });
        $('#search').keyup(function() {
            $('#result').html('');
            $('#state').val('');
            var searchField = $('#search').val();
            var expression = new RegExp(searchField, "i");
            $.getJSON('json.php', function(data) {
                $.each(data, function(key, value) {
                    if (value.account.search(expression) != -1 || value.lastName.search(
                            expression) != -1) {
                        $('#result').append(
                            '<input type="hidden" name="id" value="' + value
                            .userId +
                            '"> <li class="list-group-item link-class"><img src="uploads/' +
                            value.avatar +
                            '" height="40" width="40" class="img-thumbnail" /> ' +
                            value.account + ' | <span class="text-muted">' + value
                            .lastName +
                            '| <a class="float-right" href="editUser.php?id=' +
                            value.userId + '" id="edit">Edit</a></span></li>');
                    }
                });
            });
        });

        $('#result').on('click', 'li', function() {
            var click_text = $(this).text().split('|');
            $('#search').val($.trim(click_text[0]));
            $("#result").html('');
        });
    });
    </script>
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
        <div class="container" style="width:900px;">
            <h2 align="center">Search User</h2>
            <h3 align="center">By account or last name.</h3>
            <br /><br />
            <div align="center">
                <input type="text" name="search" id="search" placeholder="Search user Details" class="form-control" />
            </div>
            <ul class="list-group" id="result">
                <?php while($row = $stmt -> fetch()):?>
                <div class="list-group">
                    <input type="hidden" name="id" value="<?=$row['userId']?>">
                    <li class="list-group-item">
                        <?= "<img src='uploads/".$row['avatar']."' class='img-thumbnail' height='40' width='40' alt='test' />"?>
                        | <?=$row['account']?> <a class="float-right" href='editUser.php?id=<?=$row['userId']?>'
                            id="edit">Edit</a> </li>
                </div>
                <?php endwhile ?></ul>
            <br />
        </div>
    </div>
</body>

</html>