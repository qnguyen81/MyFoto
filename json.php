<?php
  require('connection.php');

  $ajax_data = [];
    $account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);
    $query = 'SELECT * FROM users';
    $statement = $db->prepare($query);
    $statement->bindValue(':account', $account);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $number = count($result);
    if ($number === 0) {
      $ajax_data['message'] = "No users found";
    } else {
      $ajax_data = $result;
    }
  header('Content-Type: application/json');
  echo json_encode($ajax_data);
?>