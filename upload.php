<?php
$img;
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
?>