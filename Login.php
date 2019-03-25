<?php
Session_start();
require('connection.php');
      if($_POST && isset($_POST['username']) && isset($_POST['password']))
      {
         $user = filter_input(INPUT_POST,'username', FILTER_SANITIZE_STRING);
         $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING);

         $query = "SELECT * FROM users WHERE account = :user";
         $stmt = $db-> prepare($query);
         $stmt->bindValue(":user",$user);
         $stmt-> execute();
         $row = $stmt->fetch();

         if($row >0)
         {
            if(password_verify($password, $row['password']))
            {
               if($row['role']=='a'){
                  header("location:admin.php");
                  $_SESSION['user']= $user;
               }
               else
               {
                  header("location:main.php");
                  $_SESSION['user']= $user;
                  $_SESSION['userId'] = $row['userId'];
               }
            }
            else
            {
               echo "incorrrect password";
            }
         }
         else
         {
            echo "accountis not correct";
         }
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="logo mb-3">
                    <div class="col-md-12 text-center">
                        <h1>MyFoto</h1>
                    </div>
                </div>
                <form action="Login.php" method="post" name="login">
                    <div class="form-group">
                        <label for="username">User Name <i class="fas fa-user"></i></label>
                        <input type="input" name="username" class="form-control" id="email" aria-describedby="emailHelp"
                            placeholder="Enter user name">
                    </div>
                    <div class="form-group">
                        <a class="float-right" href="#">Forgot?</a>
                        <label for="exampleInputEmail1">Password <i class="fas fa-lock"></i></label>
                        <input type="password" name="password" id="password" class="form-control"
                            aria-describedby="emailHelp" placeholder="Enter Password">
                    </div>

                    <div class="col-md-12 text-center ">
                        <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                    </div>
                    <div class="col-md-12 ">
                        <div class="login-or">
                            <hr class="hr-or">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                    </div>
                    <div class="form-group">
                        <p class="text-center">Don't have account? <a href="newAccount.php" id="signup">Sign up here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>