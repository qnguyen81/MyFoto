<?php 
    session_start();
        if(isset($_SESSION['user']))
        {
            echo "echo welcome"."  ".$_SESSION['user']; 
        }
        else
        {
            header("location:Login.php");
        }
?> 