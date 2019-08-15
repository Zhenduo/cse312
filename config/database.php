<?php
require_once 'constants.php';

$conn = new mysqli(HOST, USER, PASS, DB);

if($conn->connect_error) {
  die('Database error:' . $conn->connect_error);
}
  ?>
