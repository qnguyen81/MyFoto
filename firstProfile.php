<?php

    if($_POST)
    {

    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
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
							<h1>Profile</h1>
						 </div>
					</div>
                   <form action="" method="post" name="login">
                   <div class="form-group">
                   <a class="float-right" href="Login.php">Login</a>
                              <label for="account">Full Name</label>
                              <input type="account" name="account" id="account"  class="form-control" aria-describedby="emailHelp">
                           </div>
                           <div class="form-group">
                              <label for="birthday">Birthday</label>
                              <input type="date" name="birthday" id="birthday"  class="form-control" aria-describedby="emailHelp">
                           </div>
                           <div class="form-group">
                              <label for="textarea">Let people know more about you</label>
                              <textarea class="form-control" name = "textarea" id="textArea" rows="3"></textarea>  
                           </div>   
                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Choose your profile picture</label>
                                <div class="input-group">
                                    <span class="input-group-btn">  
                                        <span class="btn btn-default btn-file">
                                            <input type="file" id="imgInp">
                                        </span>
                                    </span>
                                </div>
                                <img id='img-upload'/>
                            </div>
                        </div>
                           <div class="col-md-12 text-center ">
                              <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Create Account</button>
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
