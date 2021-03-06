<?php
      require("connection.php");
      session_start();
      $PassError= false;
      $matchError = false;
      $lengthError = false;
      $nameError = false;
    if($_POST&&isset($_POST['submit']))
    {
       if($_POST && !empty($_POST['password']) && !empty($_POST['password']) )
       {
          if(strlen($_POST['password']) < 6)
          {
            $lengthError = true;
          }
            $account = filter_input(INPUT_POST,'account', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
            $confirm = filter_input(INPUT_POST,'con-password',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);

            if($password == $confirm )
            {
               $pass = password_hash($password, PASSWORD_DEFAULT);
               $query = "SELECT userId FROM users WHERE UPPER(account) = UPPER(:account)";
               $statement = $db-> prepare($query);
               $statement-> bindValue(":account", $account);
               $statement->execute();
               $row = $statement -> fetch();

               if($row > 0 ) 
               {
                  $nameError = true;
               }
               else
               {
                  header("location: firstProfile.php");
                  $insert = "INSERT INTO users (account,password) VALUES (:account,:password)";
                  $stmt = $db-> prepare($insert);
                  $stmt-> bindValue(":account", $account);
                  $stmt->bindValue(":password",$pass);
                  $stmt-> execute();
                  $_SESSION['user']= $account;
                  $_SESSION['userId'] = $row['userId'];
               }              
            }
            else
            {
               $matchError = true;
            }
       }
       else
       {
         echo'Please fill both the username and password field!';
       }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="logo mb-3">
                </div>
                <form action="newAccount.php" method="post" name="login">
                    <h3>Create Account</h3>
                    <div class="form-group">
                        <a class="float-right" href="Login.php">Login</a>
                        <label for="account">Account</label>
                        <input type="input" name="account" id="account" class="form-control" placeholder="Account">
                        <?php if($nameError): ?>
                        <a class="float-right" name= "error"id='nameError'></a>
                        <?php endif?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Password">
                        <?php if($lengthError): ?>
                        <a class="float-right" id='length'>Must be more than 6 chacter.</a>
                        <?php endif?>
                    </div>
                    <div class="form-group">
                        <label for="con-password">Confirm Password</label>
                        <input type="password" name="con-password" id="con-password" class="form-control"
                            placeholder="Enter Password Again">
                        <?php if($matchError): ?>
                        <a class="float-right" id='length'>Pasword is not match.</a>
                        <?php endif?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="col-md-12 text-center ">
                        <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
                            name="submit">Next</button>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>