<?php
    include("connection.php");
    session_start();
    print_r($_SESSION);
    if($_POST && !empty($_POST['firstName']) &&!empty($_POST['birthday']))
    {
        print_r($_SESSION);
        $firstName = filter_input(INPUT_POST,'firstName', FILTER_SANITIZE_STRING); 
        $lastName = filter_input(INPUT_POST,'lastName', FILTER_SANITIZE_STRING); 
        $fullName = $firstName.$lastName;
        $description = filter_input(INPUT_POST,'description', FILTER_SANITIZE_STRING); 
        $birthday = filter_input(INPUT_POST,'birthday', FILTER_SANITIZE_STRING); 
        $user = $_SESSION['user'];

        $query = "UPDATE users  SET firstName =:firstName,lastName=:lastName, birthday=:birthday, description = :description  WHERE UPPER(account) = UPPER(:user)";

        $stmt = $db->prepare($query);
        $stmt-> bindValue(":firstName",$firstName);
        $stmt-> bindValue(":lastName",$lastName);
        $stmt-> bindValue(":birthday",$birthday);
        $stmt-> bindValue(":description",$description);
        $stmt-> bindValue(":user", $_SESSION['user']);

        $stmt->execute();
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
                              <label for="account">First Name</label>
                              <input type="input" name="firstName" id="firstName"  class="form-control" aria-describedby="emailHelp">
                           </div>
                           <div class="form-group">
                              <label for="account">Last Name</label>
                              <input type="input" name="lastName" id="lastName"  class="form-control" aria-describedby="emailHelp">
                           </div>
                           <div class="form-group">
                              <label for="birthday">Birthday</label>
                              <input type="date" name="birthday" id="birthday"  class="form-control" aria-describedby="emailHelp">
                           </div>
                           <div class="form-group">
                              <label for="textarea">Let people know more about you</label>
                              <textarea class="form-control" name = "description" id="description" rows="3"></textarea>  
                           </div>   
                           <div class="col-md-6">
                            <div class="form-group">
                                <label>Choose your profile picture</label>
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="customFile">
                                      <label class="custom-file-label" for="customFile">Choose file</label>
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
