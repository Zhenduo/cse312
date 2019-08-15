<?php

require 'config/database.php';
require 'control/authenController.php';

$errors = array();
// creating an order

$user = $_SESSION['id'];
//delivery is not found
$delivery = isset($_POST['delivery']) ? $_POST['delivery'] : '';
$approved = false;
$orderID = NULL;
if($_SESSION['employee']){
  $employeeID = $user;
  $user = NULL;
}

// if(empty($delivery)){
//   $errors['delivery'] = "Delivery type required";
// }
if(empty($user) && empty($employeeID)){
  $errors['login'] = "Log in required";
}
if(count($errors) === 0){
  $newOrder = "INSERT INTO orders (userID, employeeID, delivery, approved) VALUES (?,?,?,?)";
  $stmt = $conn ->prepare($newOrder);
  $stmt->bind_param('iisi', $user, $employeeID, $delivery, $approved);
  if($stmt->execute()){
    $orderID = $conn -> insert_id;
    $_SESSION['orderID'] = $orderID;
    //insert order details
    $widths =isset($_POST['hidden_width']) ? $_POST['hidden_width'] : '';
    $heights =isset($_POST['hidden_height']) ? $_POST['hidden_height'] : '';
    $types =isset($_POST['hidden_type']) ? $_POST['hidden_type'] : '';
    $quantities =isset($_POST['hidden_quantity']) ? $_POST['hidden_quantity'] : '';

    for($count = 0; $count<count($widths); $count++)
    {
      $width = $widths[$count];
      $height = $heights[$count];
      $type = $types[$count];
      $quantity = $quantities[$count];
    $query = "INSERT INTO products (orderid, width, height, type, quantity) VALUES (?, ?, ?, ?, ?)";
     $statement = $conn->prepare($query);
     $statement->bind_param('iiisi', $orderID, $width, $height, $type, $quantity);
     $statement->execute();
    }
  }
}

?>
