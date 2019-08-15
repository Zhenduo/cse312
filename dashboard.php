<?php
require_once 'config/constants.php';
require_once 'dashController.php';
require_once 'control/authenController.php';
if(!isset($_SESSION['id'])){
  header('location: login.php');
  exit();
}
else if($_SESSION['employee'] === 1){
  header('location:employeeprofile.php');
  exit();
}
else if(!$_SESSION['employee'] === 0){
  header('location:customerprofile.php');
  exit();
}
else if(!($_SESSION['email']===ADMIN)){
  header('location:login.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset = "UTF-8">
  <title>My Dashboard</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
.my-work{
  width:auto;
  padding-left: 2%;
}
.create-order{
  right: -70%;
  top:45px;
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
  <h2>Dashboard</h2>
  <div class="message-size">
  <!-- <div class="position-ref links create-order"><a href="order.php">Place a new order</a></div> -->
  <h4>Employees</h4>
  <hr>
  <?php if(count($employees) === 0):?>
    <div class="links"><a>No employees yet.</a></div>
  <?php endif;?>
  <?php if(count($employees) > 0):?>
  <div id="employee-table">
  <table class="table table-bordered">

    <tr>
      <td>First Name</td>
      <td>Last Name</td>
      <td>Email</td>
      <td>Phone Number</td>
      <td>Edit</td>
    </tr>

    <?php foreach($employees as $employ):?>
      <tr>
        <td><?php echo $employ['firstName'];?></td>
        <td><?php echo $employ['lastName'];?></td>
        <td><?php echo $employ['email'];?></td>
        <td><?php echo $employ['phoneNumber'];?></td>
        <td><button type="button" id="<?php echo $employ['id'];?>"class="btn btn-outline-success view_data" data-toggle="modal" data-target="#exampleModalCenter">Edit</button></td>
      </tr>
    <?php endforeach; ?>
  </table>
  </div>
<?php endif; ?>
  <h4>Customers</h4>
  <hr>
  <?php if(count($customers) === 0):?>
    <div class="links"><a>No customers yet.</a></div>
  <?php endif;?>
  <?php if(count($customers)>0):?>
  <div id="customer-table">
  <table class="table table-bordered">
    <tr>
      <td>First Name</td>
      <td>Last Name</td>
      <td>Email</td>
      <td>Phone Number</td>
      <td>Edit</td>
    </tr>
    <?php foreach($customers as $employ):?>
      <tr>
        <td><?php echo $employ['firstName'];?></td>
        <td><?php echo $employ['lastName'];?></td>
        <td><?php echo $employ['email'];?></td>
        <td><?php echo $employ['phoneNumber'];?></td>
        <td><button type="button" id="<?php echo $employ['id'];?>"class="btn btn-outline-success view_data" data-toggle="modal" data-target="#exampleModalCenter">Edit</button></td>
      </tr>
    <?php endforeach; ?>
  <?php endif;?>
  </table>
  </div>

</div>
</body>
</html>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">User details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="user_detail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Edit</button>
      </div>
    </div>
  </div>
</div>

 <script>
 $(document).ready(function(){
      $('.view_data').click(function(){
           var user_id = $(this).attr("id");
           $.ajax({
                url:"dashboard.php",
                method:"post",
                data:{user_id:user_id},
                success:function(data){
                     $('#user_detail').html(data);
          //           $('#dataModal').modal();
                }
           });
      });

 });
  </script>
