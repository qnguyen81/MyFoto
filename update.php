<?php
require('connection.php');

if(!empty($_POST['id']) && isset($_POST['save'])){
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $account = filter_input(INPUT_POST, 'account', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $update = "UPDATE users SET firstName =:firstName , lastName=:lastName , account =:account,email=:email WHERE userId = :id";

    $stmt1 = $db->prepare($update);
    $stmt1-> bindValue(":firstName",$firstName);
    $stmt1-> bindValue(":lastName",$lastName);
    $stmt1-> bindValue(":email",$email);
    $stmt1-> bindValue(":account",$account);
    $stmt1->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt1-> execute();
    header("Location: manageUser.php");
    EXIT;
}
?>