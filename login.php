<?php
require_once 'control/authenController.php';
// require_once 'orderDispaly.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset = "UTF-8">
  <title>Log In</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>
html, body {
background-color: #fff;
color: #636b6f;
font-family: 'Nunito', sans-serif;
font-weight: bold;
height: 100vh;
margin: 0;
}
.register-form{
  width:75%;
  padding-left: 15%;
}
h2{
  padding-left: 15%;
  padding-bottom: 2%;
  padding-top:10%;
  font-weight: bold;
}
#outputError{
  margin-bottom: 3%;
}

.flex-center {
align-items: center;
display: flex;
justify-content: center;
}

.position-ref {
position: relative;
}

.top-right {
position: absolute;
right: 10px;
top: 18px;
}

.links > a {
color: #636b6f;
padding: 0 25px;
font-size: 13px;
font-weight: 600;
letter-spacing: .1rem;
text-decoration: none;
text-transform: uppercase;
}
.forgot-password > a{
  position:relative;
  color: #636b6f;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: .1rem;
  text-decoration: none;
  text-transform: uppercase;
  left:75px;
  top:-25px;
}
</style>

</head>

<body>

  <div class="flex-center position-ref">
  <div class="top-right links">
  <a href="index.php">Home</a>
  <a href="signup.php">Register</a>
  </div>
  </div>
  <h2>Log In</h2>

  <div class="register-form">
  <form action="login.php" method="post">
    <?php if(count($errors) > 0): ?>
    <div class = "alert alert-danger" id="outputError">
      <?php foreach($errors as $error):?>
        <li><?php echo $error;?></li>
      <?php endforeach?>
    </div>
    <?php endif; ?>

  <!-- Email and password -->
  <div class="form-group">
    <label for="inputEmail">Email/Phone Number</label>
    <input type="text" name="email" value="<?php echo $email?>" class="form-control" id="inputEmail" placeholder="Email">
  </div>
    <div class="form-group">
      <label for="inputPassword4">Password</label>
      <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>

  <button type="submit" name="login-btn" class="btn btn-outline-success">Log in</button>
  <div class="forgot-password">
  <a href="forgot_password.php">Forgot password?</a>
</div>
</form>

</div>

</body>
</html>
