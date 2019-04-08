<?php
  require('connection.php');

  // This is the data that will be return from the API if the province id
  // is missing or is not a valid integer.
  $ajax_data = [
    "success" => false,
    "message" => 'The province_id GET parameter is missing or is not a number.',
    "cities"  => []
  ];

    // Query from all cities that belong to a particular province by foreign key.
    $account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);
    $query = 'SELECT * FROM users';
    $statement = $db->prepare($query);
    $statement->bindValue(':account', $account);
    $statement->execute();

    // Save all the returned cities to a $cities array of hashes.
    // Using the PDO::FETCH_ASSOC argument ensures that each city
    // hash includes keys for each city table column and nothing more.
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $number = count($result);

    if ($number === 0) {
      $ajax_data['message'] = "No users found";
    } else {
      $ajax_data['success'] = true;
      $ajax_data['message'] = "Found {$number} cities.";
      $ajax_data['cities'] = $cities;
    }

  // Return the data in JSON format.
  header('Content-Type: application/json');
  echo json_encode($ajax_data);
?>