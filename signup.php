<?php
require_once 'control/authenController.php';
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset = "UTF-8">
  <title>Register</title>
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
</style>

</head>

<body>

  <div class="flex-center position-ref">
  <div class="top-right links">
  <a href="index.php">Home</a>
  <a href="login.php">Log in</a>
  </div>
  </div>
  <h2>Register</h2>

  <div class="register-form">
  <form action="signup.php" method="post">

    <?php if(count($errors) > 0): ?>
    <div class = "alert alert-danger" id="outputError">
      <?php foreach($errors as $error):?>
        <li><?php echo $error;?></li>
      <?php endforeach?>
    </div>
    <?php endif; ?>

    <!-- Name -->
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputFirstName">First Name</label>
        <input type="text" name="firstName" value="<?php echo isset($_POST["firstName"]) ? $_POST["firstName"] : ''; ?>" class="form-control" id="inputFirstName" placeholder="First Name">
      </div>
      <div class="form-group col-md-6">
        <label for="inputLastName">Last Name</label>
        <input type="text" name="lastName"  value="<?php echo isset($_POST["lastName"]) ? $_POST["lastName"] : ''; ?>" class="form-control" id="inputLastName" placeholder="Last Name">
      </div>
    </div>
  <!-- Email and password -->
  <div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" class="form-control" id="inputEmail" placeholder="Email">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password Confirmation</label>
      <input type="password" name="passwordConf" class="form-control" id="inputPasswordConf" placeholder="Password Confirmation">
    </div>
  </div>
    <!-- Phone -->
  <div class="form-group">
    <label for="inputPhone">Phone Number</label>
    <input type="text" name="phoneNum" value="" class="form-control" id="inputPhone" placeholder="(123)-456-7890">
  </div>
  <!-- Address -->
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" name="address1"  value="<?php echo isset($_POST["address1"]) ? $_POST["address1"] : ''; ?>"class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address Line 2</label>
    <input type="text" name="address2"  value="<?php echo isset($_POST["address2"]) ? $_POST["address2"] : ''; ?>"class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" name="city" placeholder="Ex. Buffalo" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>"class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select name="state" id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option value="AL">Alabama</option>
          <option value="AK">Alaska</option>
          <option value="AZ">Arizona</option>
          <option value="AR">Arkansas</option>
          <option value="CA">California</option>
          <option value="CO">Colorado</option>
          <option value="CT">Connecticut</option>
          <option value="DE">Delaware</option>
          <option value="DC">District Of Columbia</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="HI">Hawaii</option>
          <option value="ID">Idaho</option>
          <option value="IL">Illinois</option>
          <option value="IN">Indiana</option>
          <option value="IA">Iowa</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="ME">Maine</option>
          <option value="MD">Maryland</option>
          <option value="MA">Massachusetts</option>
          <option value="MI">Michigan</option>
          <option value="MN">Minnesota</option>
          <option value="MS">Mississippi</option>
          <option value="MO">Missouri</option>
          <option value="MT">Montana</option>
          <option value="NE">Nebraska</option>
          <option value="NV">Nevada</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NM">New Mexico</option>
          <option value="NY">New York</option>
          <option value="NC">North Carolina</option>
          <option value="ND">North Dakota</option>
          <option value="OH">Ohio</option>
          <option value="OK">Oklahoma</option>
          <option value="OR">Oregon</option>
          <option value="PA">Pennsylvania</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="SD">South Dakota</option>
          <option value="TN">Tennessee</option>
          <option value="TX">Texas</option>
          <option value="UT">Utah</option>
          <option value="VT">Vermont</option>
          <option value="VA">Virginia</option>
          <option value="WA">Washington</option>
          <option value="WV">West Virginia</option>
          <option value="WI">Wisconsin</option>
          <option value="WY">Wyoming</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zipcode</label>
      <input type="text" name="zipcode"  value="<?php echo isset($_POST["zipcode"]) ? $_POST["zipcode"] : ''; ?>"placeholder="Zipcode" class="form-control" id="inputZip">
    </div>
  </div>
  <!--Consent-->
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" name="agree" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        I agree the terms and agreement from this website.
      </label>
    </div>
  </div>
  <button type="submit" name="signup-btn" class="btn btn-outline-success">Register</button>

</form>
</div>

</body>
</html>
