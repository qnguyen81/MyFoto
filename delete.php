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
	if (isset($_POST['deletePost'])) {
		$postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT);
		$acctId = filter_input(INPUT_POST, 'acctId', FILTER_SANITIZE_NUMBER_INT);
   	 	$query = "DELETE FROM post WHERE postId = :id LIMIT 1";
   		 $statement = $db->prepare($query);
    	$statement->bindValue(':id', $postId, PDO::PARAM_INT);
   		$statement->execute();
   		header("Location: editUser.php?id=$acctId");
    	EXIT;
    }
?>