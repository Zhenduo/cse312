<?php

require 'config/database.php';
require 'control/authenController.php';

$one = true;
$zero = false;
$employees = array();
$customers = array();
$errors = array();

if(session_status() == PHP_SESSION_ACTIVE){
  global $conn;

$employee = "SELECT * FROM users WHERE employee = '$one'";
$result = mysqli_query($conn, $employee);
$i = 0;
if(mysqli_num_rows($result) > 0){
  while($r = mysqli_fetch_assoc($result)){
    $employees[$i] = array(
      'firstName' => $r['firstName'],
      'lastName' => $r['lastName'],
      'email' => $r['email'],
      'phoneNumber' => $r['phoneNumber'],
      'id' => $r['id']
    );
    $i++;
  }
}

$customer = "SELECT * FROM users WHERE employee='$zero'";
$response = mysqli_query($conn, $customer);
$j = 0;
if(mysqli_num_rows($response) > 0){
  while($r = mysqli_fetch_assoc($response)){
    $customers[$j] = array(
      'firstName' => $r['firstName'],
      'lastName' => $r['lastName'],
      'email' => $r['email'],
      'phoneNumber' => $r['phoneNumber'],
      'id' => $r['id']
    );
    $j++;

  }
}

if(isset($_POST['user_id'])){
  global $conn;
  $output = '';
  $user = "SELECT * FROM users WHERE id='".$_POST['user_id']."' LIMIT 1";
  $re = mysqli_query($conn, $user);
  if(mysqli_num_rows($re) > 0){
    $u = mysqli_fetch_assoc($re);
    $output = '<div class"form-group links"><label>Choose a new role for '.$u['firstName'].'</label><br><select name="role" class="form-control"><option selected value="-1">Choose a role</option><option value="1">Employee</option><option value="0">Customer</option></select></div><input name="user" value="'.$u['id'].'" hidden>';
  //    $output = '<td>abc</td>';
  }

  echo $output;
}

function updateInfor($role, $user){
  global $conn;
  if($role === '-1'){
    echo "Rece";
  }else{
    $sql = "UPDATE users SET employee='$role' WHERE id='".$user."' ";
    $re = mysqli_query($conn, $sql);
  }

  header('location:dash.php');
  exit();
}

}

?>
