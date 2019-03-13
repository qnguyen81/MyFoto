<?php
      require("connection.php");


    if(isset($_POST['submit']))
    {
       if($_POST && !empty($_POST['password']) && !empty($_POST['password']) )
       {
            $account = filter_input(INPUT_POST,'account', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
            $confirm = filter_input(INPUT_POST,'con-password',FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);

            if($password == $confirm )
            {
               header("location: firstProfile.php");

            }
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>
<body>
    <div class="container">
        <div class="row">
			<div class="col-md-5 mx-auto">
			<div id="first">
				<div class="myform form ">
					 <div class="logo mb-3">
						 <div class="col-md-12 text-center">
							<h1>Create Account</h1>
						 </div>
					</div>
                   <form action="newAccount.php" method="post" name="login">
                   <div class="form-group">
                   <a class="float-right" href="Login.php">Login</a>
                              <label for="account">Account</label>
                              <input type="input" name="account" id="account"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Account">
                           </div>
                           <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                           </div>
                           <div class="form-group">
                              <label for="con-password">Confirm Password</label>
                              <input type="password" name="con-password" id="con-password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password Again">
                           </div>
                           <div class="form-group">
                              <label for="email">Email address</label>
                              <input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                           </div>
                           <div class="col-md-12 text-center ">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm" name="submit">Next</button>
                           </div>
                           <div class="col-md-12 ">
                              <div class="login-or">
                                 <hr class="hr-or">
                              </div>
                           </div>
                        </form>
                
				</div>
			</div> 
    
</body>
</html>
