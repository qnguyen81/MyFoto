<?php
    include("connection.php");
    session_start();
    print_r($_SESSION);
    if($_POST && !empty($_POST['firstName']) &&!empty($_POST['birthday']) && isset($_POST['create']))
    {
        print_r($_SESSION);
        $firstName = filter_input(INPUT_POST,'firstName', FILTER_SANITIZE_STRING); 
        $lastName = filter_input(INPUT_POST,'lastName', FILTER_SANITIZE_STRING); 
        $fullName = $firstName.$lastName;
        $description = filter_input(INPUT_POST,'description', FILTER_SANITIZE_STRING); 
        $birthday = filter_input(INPUT_POST,'birthday', FILTER_SANITIZE_STRING); 
        $user = $_SESSION['user'];

        if(isset($_POST['file']))
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
        else
        {
           $img = "default.jpg";
        }

        $query = "UPDATE users  SET firstName =:firstName,lastName=:lastName, birthday=:birthday, description = :description ,avatar=:photo WHERE UPPER(account) = UPPER(:user)";

        $stmt = $db->prepare($query);
        $stmt-> bindValue(":firstName",$firstName);
        $stmt-> bindValue(":lastName",$lastName);
        $stmt-> bindValue(":birthday",$birthday);
        $stmt-> bindValue(":photo",$img);
        $stmt-> bindValue(":description",$description);
        $stmt-> bindValue(":user", $_SESSION['user']);
        $stmt->execute();

        if($stmt)
        {
           header("location:main.php");
        }
        else
        {
           echo "a problem occured.";
        }

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
                   <form action="firstProfile.php" method="post" name="login" enctype='multipart/form-data'>
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
                                      <input type="file" name='file'>
                                      <label  for="file"></label>
                                 </div>  
                                <img id='img-upload'/>
                            </div>
                        </div>
                           <div class="col-md-12 text-center ">
                              <button type="submit" name ="create" class=" btn btn-block mybtn btn-primary tx-tfm">Create Account</button>
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
