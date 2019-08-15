<?php
require 'config/database.php';
require 'control/authenController.php';

$customerOrders = array();
$processOrders = array();
$myapprovedOrders = array();
$orderDetails = array();

if(session_status() == PHP_SESSION_ACTIVE){
  global $conn;

  $user = $_SESSION['id'];
// for employee
  if($_SESSION['employee']){
    $status = false;
    $approved = true;
    $sql = "SELECT * FROM orders WHERE approved='$status' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    if(mysqli_num_rows($result) > 0){
      while($order = mysqli_fetch_assoc($result)){
          $processOrders[$i] = array(
          'orderID' => $order['id'],
          'delivery' => $order['delivery'],
          'payment' => $order['payment']
        );
        $i++;
      }
  }
    $query = "SELECT * FROM orders WHERE approved='$approved' ORDER BY id DESC";
    $response = mysqli_query($conn, $query);
    $a = 0;
    if(mysqli_num_rows($response) > 0){
    while($order = mysqli_fetch_assoc($response)){
        $myapprovedOrders[$a] = array(
        'orderID' => $order['id'],
        'delivery' => $order['delivery'],
        'payment' => $order['payment'],
        'approved' => $order['approved']
      );
      $a++;
    }
  }

}
// for customer
  $sql = "SELECT * FROM orders WHERE userID = '$user' ORDER BY id DESC";

  $result = mysqli_query($conn, $sql);
  $i = 0;
  if(mysqli_num_rows($result) > 0){
    while($order = mysqli_fetch_assoc($result)){
      $customerOrders[$i] = array(
        'orderID' => $order['id'],
        'delivery' => $order['delivery'],
        'approved' => $order['approved'],
        'payment' => $order['payment']
      );
      $i++;
    }
}
if(isset($_POST["order_id"]))
 {
    //  $_SESSION['orderID'] = $_POST['order_id'];
  //    echo $_SESSION['orderID'];
      $output = '';
      global $conn;
      $query = "SELECT * FROM products WHERE orderid = '".$_POST["order_id"]."'";
      $result = mysqli_query($conn, $query);
      $output .= '
      <input name="order" value="'.$_POST['order_id'].'" hidden>
      <input name="approved" value=1 hidden>
      <div class="table-responsive">
           <table class="table table-bordered">
           <tr>
           <td>Width</td>
           <td>Height</td>
           <td>Type</td>
           <td>Quantity</td></tr>';
      while($row = mysqli_fetch_array($result))
      {
           $output .= '
                <tr>
                     <td>'.$row['width'].'</td>
                     <td>'.$row['height'].'</td>
                     <td>'.$row['type'].'</td>
                     <td>'.$row['quantity'].'</td>
                </tr>
                ';
      }
      $output .= "</table></div>";
      echo $output;
 }
  }


  function approvedOrder($order, $approved){
    global $conn;
     $query = "UPDATE orders SET approved=1 WHERE id = '".$order."'";
     $result = mysqli_query($conn, $query);
      // unset($_SESSION['orderID']);
       header('location:employeeprofile.php');
       exit();
   }

?>
