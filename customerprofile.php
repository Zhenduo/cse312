<?php

require 'orderDisplay.php';
require 'config/database.php';
require_once 'control/authenController.php';

if(isset($_GET['token'])){
  $token = $_GET['token'];
  verifyUser($token);
}
if(isset($_GET['password-token'])){
  $passwordtoken = $_GET['password-token'];
  resetPassword($passwordtoken);
}
if(!isset($_SESSION['id'])){
  header('location: login.php');
  exit();
}
if($_SESSION['employee']){
  header('location:employeeprofile.php');
  exit();
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset = "UTF-8">
  <title>My Profile</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
b{
  display: none;
}
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

.message-size{
  margin-left: 15%;
  padding-left: 2%;
  width:75%;
}
.verify-padding{
  width:auto;
  padding-left: 2%;
}
.my-profile{
  width:auto;
  padding-left: 2%;
  padding-top: 2%;
}
.my-order{
  width:auto;
  padding-left: 2%;
}
.create-order{
  right: -70%;
  top:45px;
}
p{
  color: green;
}
</style>

</head>

<body>

  <div class="flex-center position-ref">
  <div class="top-right links">
  <a href="index.php">Home</a>
  <a href="?logout=1">Log out</a>
  </div>
  </div>
  <h2>My Account</h2>
  <div class="message-size">
    <h4>Welcome, <?php echo $_SESSION['firstName']; ?>!</h4>
    <?php if(!$_SESSION['verified']): ?>
    <div class ="alert-danger verify-padding">
      <?php echo $_SESSION['verify-warning']; ?> <br/>Please verify <?php echo $_SESSION['email']; ?> to see your profile.
    <?php endif; ?>
    <?php if($_SESSION['verified']): ?>
    <div class ="my-profile">
      <h4>My Profile</h4> <hr/>
      <h5>First name: <strong> <?php echo $_SESSION['firstName'];?> </strong></h5>
      <h5>Last Name: <strong><?php echo $_SESSION['lastName'];?> </strong></h5>
      <h5>Email: <strong><?php echo $_SESSION['email'];?></strong></h5>
      <h5>Phone number: <strong><?php echo $_SESSION['phoneNum'];?></strong></h5>
    </div>
   <div class="position-ref links create-order"><a href="order.php">Place a new order</a></div>
    <div class="my-order">
      <h4>My Orders</h4>
      <hr/>

      <!-- <?php if(count($customerOrders) === 0):?>
          <div class="links"><a>You did not place any orders yet.</a></div>
        <?php endif; ?> -->

        <?php
          $db = mysqli_connect('localhost', 'root', '', 'cse312') or die("Unable to connect");
          $table = mysqli_query($db, 'SELECT * from products');
        ?>
        <?php if(mysqli_fetch_array($table) === 0):?>
          <div class="links"><a>You did not place any orders yet.</a></div>
        <?php endif; ?>
        <table class="table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Type</th>
              <th>Quantity</th>
              <th>Approval</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $db = mysqli_connect('localhost', 'root', '', 'cse312') or die("Unable to connect");
              $table = mysqli_query($db, 'SELECT * from products');
              while($row = mysqli_fetch_array($table)) { ?>
                <tr>
                  <td><?php echo $row['orderid'];?></td>
                  <td><?php echo $row['type'];?></td>
                  <td><?php echo $row['quantity'];?></td>
                </tr>
              <?php }
            ?>
          </tbody>



    <div class="container" style="width:700px;">
                  <br />
                  <?php if(count($customerOrders) > 0): ?>
                  <div class="table-responsive">
                       <table class="table table-bordered">
                         <tr>
                           <td>Order Ref.</td>
                           <td>Delivery Type</td>
                           <td>Approve Statue</td>
                           <td>Payment</td>
                           <td>View</td>
                         </tr>
                         <?php foreach($customerOrders as $order):?>
                           <tr>
                           <td><?php echo $order['orderID'];?></td>
                           <td><?php echo $order['delivery'];?></td>
                           <td>
                             <?php
                             if($order['approved']=== "0"){
                               echo "In progress";
                             }else{
                               echo "<p>Approved</p>";
                             }?>
                           </td>
                           <td><?php if($order['payment'] === "0"){echo "To be calculated";}?></td>
                           <td><button type="button" id="<?php echo $order['orderID'];?>"class="btn btn-success view_data" data-toggle="modal" data-target="#exampleModalCenter">View</button></td>
                           </tr>
                       <?php endforeach?>
                       </table>
                  </div>
                <?php endif; ?>

             </div>
           </div>

           <?php endif; ?>

</body>
</html>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="order_detail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <script>
 $(document).ready(function(){
      $('.view_data').click(function(){
           var order_id = $(this).attr("id");
           $.ajax({
                url:"orderDisplay.php",
                method:"post",
                data:{order_id:order_id},
                success:function(data){
                     $('#order_detail').html(data);
              //       $('#dataModal').modal();
                }
           });
      });
 });
  </script>
