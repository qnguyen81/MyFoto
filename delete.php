<?php 
    require('connection.php');
     if (isset($_POST['delete'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
   	 	$query = "DELETE FROM users WHERE userId = :id LIMIT 1";
   		 $statement = $db->prepare($query);
    	$statement->bindValue(':id', $id, PDO::PARAM_INT);
   		$statement->execute();
   		header("Location: manageUser.php");
    	EXIT;
    }
?>