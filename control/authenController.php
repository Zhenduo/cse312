<?php
require_once 'config/constants.php';
session_start();
require 'config/database.php';
require 'emailController.php';
$errors = array();
$email = "";
$phoneNum ="";

// sign up
if (isset($_POST['signup-btn'])){
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $passwordConf = $_POST['passwordConf'];
  $phoneNum = $_POST['phoneNum'];
  $address1 = $_POST['address1'];
  $address2 = $_POST['address2'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zipcode = $_POST['zipcode'];
//  $agree = $_POST['agree'];

  if(empty($firstName)){
    $errors['firstName'] = "First name required";
  }
  if(empty($lastName)){
    $errors['lastName'] = "Last name required";
  }
  if(empty($email)){
    $errors['email'] = "Email required";
  }
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Email address is not valid.";
  }
  if(empty($phoneNum)){
    $errors['phoneNum'] = "Phone number required";
  }
  if(empty($password)){
    $errors['password'] = "Password required";
  }
  if(strlen($password) < 9){
    $errors['password'] = "You need to create a password with more than 8 characters.";
  }
  if($password != $passwordConf){
    $errors['password'] = "Passwords are not matched.";
  }
  if(!isset($_POST['agree'])){
    $errors['agree'] = "You must read and agree our agreements to use our website.";
  }

  $emailQuery = "SELECT * FROM users WHERE email = ? LIMIT 1";
  $stmt = $conn -> prepare($emailQuery);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt ->get_result();
  $userCount = $result ->num_rows;

  if($userCount > 0){
    $errors['email'] = "Email already registered.";
  }

  $phoneQuery = "SELECT * FROM users WHERE phoneNumber = ? LIMIT 1";
  $stmt2 = $conn -> prepare($phoneQuery);
  $stmt2->bind_param('i', $phoneNum);
  $stmt2->execute();
  $result2 = $stmt2 ->get_result();
  $userCount2 = $result2 ->num_rows;

  if($userCount2 > 0){
    $errors['phone'] = "Phone number already registered.";
  }

  // if no errors
  if(count($errors) === 0){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));
    $verified = false;
    $employee = false;

    $newUser = "INSERT INTO users (firstName, lastName, email, password, phoneNumber, streetAddress, aptAdress, city, stateCode, zipCode, verified, employee, token)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn -> prepare($newUser);
    $stmt->bind_param('ssssissssibbs', $firstName, $lastName, $email, $password, $phoneNum, $address1, $address2, $city, $state, $zipcode, $verified, $employee, $token);
    if($stmt->execute()){
      //login user
      $id = $conn -> insert_id;
      $_SESSION['id'] = $id;
      $_SESSION['firstName'] = $firstName;
      $_SESSION['lastName'] = $lastName;
      $_SESSION['email'] = $email;
      $_SESSION['phoneNum'] = $phoneNum;
      $_SESSION['verified'] = $verified;
      $_SESSION['employee'] = $employee;
      $_SESSION['token'] = $token;

      sendVerificationEmail($email, $token);
      //flash
      $_SESSION['verify-warning'] = "You still need to verify your email address!";
      $_SESSION['alert-class'] = "alert-sucess";
      header('location: customerprofile.php');
      exit();
    }else{
      $errors['db_error'] = $stmt->error;
    }
  }

}

// verify user email
function verifyUser($token){
  global $conn;
  $sql = "SELECT * FROM users WHERE token = '$token' LIMIT 1";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
    $update_query = "UPDATE users SET verified=1 WHERE token = '$token'";

    if(mysqli_query($conn, $update_query)){
      $_SESSION['id'] = $user['id'];
      $_SESSION['firstName'] = $user['firstName'];
      $_SESSION['lastName'] = $user['lastName'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['phoneNum'] = $user['phoneNumber'];
      $_SESSION['verified'] = 1;
      $_SESSION['employee'] = $user['employee'];
      //flash
      $_SESSION['verify-warning'] = "Your email address was successfully verified!";
      $_SESSION['alert-class'] = "alert-sucess";
      header('location: customerprofile.php');
      exit();
    }
  }else{
    echo 'User not found';
  }
}

// log in
if(isset($_POST['login-btn'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(empty($email)){
    $errors['email'] = "Email/Phone number required";
  }
  if(empty($password)){
    $errors['password'] = "Password required";
  }

  if(count($errors) === 0){
  $sql = "SELECT * FROM users WHERE email=? OR phoneNumber =? LIMIT 1";
  $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $email, $email);
    $stmt->execute();
    // if the user exists
    $result = $stmt ->get_result();
    $user = $result->fetch_assoc();
    if(empty($user)){
      $errors['invalid-user'] = "User did not exist";
    }else{
    // if the password matched
      if (password_verify($password, $user['password'])){

        $_SESSION['id'] = $user['id'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phoneNum'] = $user['phoneNumber'];
        $_SESSION['verified'] = $user['verified'];
        $_SESSION['employee'] = $user['employee'];
        //flash
        $_SESSION['verify-warning'] = "You still need to verify your email address!";
        $_SESSION['alert-class'] = "alert-sucess";
        echo ADMIN;
        if($_SESSION['email'] === ADMIN){
          header('location: dash.php');
        }
        else if($_SESSION['employee']){
           header('location:employeeprofile.php');
        }else{
            header('location:customerprofile.php');
        }
        exit();
      }else{
        $errors['login-fail'] = "Wrong password";
      }
    }





}
}

//log out
if(isset($_GET['logout'])){
  session_destroy();
  unset($_SESSION['id']);
  unset($_SESSION['email']);
  unset($_SESSION['phoneNum']);
  unset($_SESSION['verified']);
  unset($_SESSION['employee']);
  unset($_SESSION['firstName']);
  unset($_SESSION['lastName']);
  header('location: index.php');
  exit();
}

//forgot password
if(isset($_POST['forgot-password-btn'])){
  $email = $_POST['email'];

  if(empty($email)){
    $errors['email'] = "Email required";
  }
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Email address is not valid.";
  }

  if(count($errors) === 0){
    $emailQuery = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $emailQuery);
    $userCount = $result ->num_rows;
    if($userCount > 0){
      $user = mysqli_fetch_assoc($result);
      $token = $user['token'];
      sendPasswordResetLink($email, $token);
      header('location: forgot_password.php?send=1');
      exit(0);
    }else{
      $errors['invalid-user'] = "No such user exist. Try to create a new account";
    }
  }
}
// reset password
if(isset($_POST['password-reset-btn'])){
  $password = $_POST['password'];
  $passwordConf = $_POST['passwordConf'];

  if(empty($password) || empty($passwordConf)){
    $errors['password'] = "Password required";
  }
  if(strlen($password) < 8){
    $errors['password'] = "You need to create a password with more than 8 characters.";
  }
  if($password != $passwordConf){
    $errors['password'] = "Passwords are not matched.";
  }

  $password=password_hash($password, PASSWORD_DEFAULT);
  $email=$_SESSION['email'];

  if(count($errors) === 0){
    $sql = "UPDATE users SET password='$password' WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if($result){
      header('location:login.php');
      exit(0);
    }
  }

}
function resetPassword($token){
  global $conn;
  $sql = "SELECT * FROM users WHERE token = '$token' LIMIT 1";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $user['email'];
    header('location:password_reset.php');
    exit(0);
}
}


 ?>
