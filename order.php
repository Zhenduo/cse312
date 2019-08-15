<?php
//require_once 'orderController.php';
require_once 'control/authenController.php';
require 'config/database.php';

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

$db = mysqli_connect('localhost', 'root', '', 'cse312') or die("Unable to connect");

if (isset($_POST['save'])) {
  $width = mysqli_real_escape_string($db, $_POST['width']);
  $height = mysqli_real_escape_string($db, $_POST['height']);
  $type = mysqli_real_escape_string($db, $_POST['type']);
  $quantity = mysqli_real_escape_string($db, $_POST['quantity']);
  $sql = "INSERT INTO products (width, height, type, quantity) VALUES ('$width', '$height', '$type', '$quantity')";
  mysqli_query($db, $sql);
  $_SESSION['width'] = $width;
  $_SESSION['height'] = $height;
  $_SESSION['type'] = $type;
  $_SESSION['quantity'] = $quantity;
  header("location: customerprofile.php");

}

if (isset($_POST['insert'])) {
    $delivery = mysqli_real_escape_string($db, $_POST['delivery']);
    $sql2 = "INSERT INTO orders (delivery) VALUES ('$delivery')";
    mysqli_query($db, $sql2);
    $_SESSION['delivery'] = $delivery;
    header("location: customerprofile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset = "UTF-8">
  <title>Place order</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />
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
.create-order{
  right: -70%;
  top:45px;
}
td{
  width:20%;
}
select.form-control:not([size]):not([multiple]) {
    height: auto!important;
}
.order-item{
  margin-left: 85%;
  margin-bottom: 2%;
}
#popup_add{
  font-family: 'Nunito', sans-serif;
  font-weight: 200;
}
.ui-widget-header{
  border: none !important;
  background: white !important;
  font-family: 'Nunito', sans-serif !important;
  font-size: 20px !important;
  font-weight: bold;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
  border: none !important;
  background: white !important;
}
.ui-dialog .ui-dialog-title{
  width:75%;
  padding:.3em 0;
}
.form-control{
  width:70%;
  margin-left:15%;
}
.form-group > label{
  margin-left: 15%;
}
.text-danger{
  margin-left: 15%;
}
.ui-widget{
  font-family: 'Nunito', sans-serif !important;
  font-size: 14px !important;
}
.ui-dialog .ui-dialog-titlebar-close{
  top:48%;
  border:none;
  background: none;
}
.delivery-type{
  width:100% !important;
  margin-left: 0% !important;
}
.delivery-type > label{
  margin-left:0% !important;
}
</style>

</head>

<body>

  <div class="flex-center position-ref">
  <div class="top-right links">
  <a href="index.php">Home</a>
  <a href="customerprofile.php">My Account</a>
  <a href="?logout=1">Log out</a>
  </div>
  </div>
  <h2>Place new order</h2>
  <div class="message-size">
    <?php if($_SESSION['employee']):?>
      <h4>Customer Information</h4>
      <form>
      <div class="form-row">
        <div class="delivery-type form-group col-md-6">
          <label for="inputFirstName">First Name</label>
          <input type="text" name="firstName" value="<?php echo isset($_POST["firstName"]) ? $_POST["firstName"] : ''; ?>" class="delivery-type form-control" id="inputFirstName" placeholder="First Name">
        </div>
        <div class="delivery-type form-group col-md-6">
          <label for="inputLastName">Last Name</label>
          <input type="text" name="lastName"  value="<?php echo isset($_POST["lastName"]) ? $_POST["lastName"] : ''; ?>" class="delivery-type form-control" id="inputLastName" placeholder="Last Name">
        </div>
      </div>
    <!-- Email-->
    <div class="delivery-type form-group">
      <label for="inputEmail">Email</label>
      <input type="email" name="email" value="<?php echo $email?>" class="delivery-type form-control" id="inputEmail" placeholder="Email">
    </div>
    <!-- Phone -->
  <div class="delivery-type form-group">
    <label for="inputPhone">Phone Number</label>
    <input type="text" name="phoneNum" value="<?php echo $phoneNum?>" class="delivery-type form-control" id="inputPhone" placeholder="(123)-456-7890">
  </div>
      <br/>
      <button type="submit" name="check-customer-btn" class="btn btn-success">Check for account</button>
    </form>
    <?php endif;?>
    <hr>
    <br/>


    <button type="button" name="add" id="add" class="order-item btn btn-success">Add Order Item</button>

             <form name="order_form" id="order_form" method="post">
              <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                      <tbody id="append-here">
                      <tr>
                        <td>Width</td>
                        <td>Height</td>
                        <td>Type</td>
                        <td>Quantity</td>
                        <td>Remove</td>
                      </tr>
                    </tbody>
                    </table>
                  </div>
                  <div class="delivery-type form-group">
                    <label for="delivery">Delivery Type</label>
                    <select type="text" name="delivery" id="delivery" class="delivery-type form-control">
                      <option selected>Choose...</option>
                      <option value="Pick Up">Pick Up At Store</option>
                        <option value="Deliver">Deliver</option>
                      </select>
                    </div>
                  <div>
                    <button type="submit" name="insert" id="insert" class="btn btn-success">Submit Order</button>
                      </div>
                  </form>

                <div id="popup_add" title="Add Order Item" method="post">
                  <div class="form-group">
                    <label>Width</label>
                    <input type="text" name="width" id="width" class="form-control" />
                      <span id="error_width" class="text-danger"></span>
                     </div>
                     <div class="form-group">
                      <label>Height</label>
                      <input type="text" name="height" id="height" class="form-control" />
                      <span id="error_height" class="text-danger"></span>
                     </div>
                     <div class="form-group">
                      <label>Type</label>
                      <input type="text" name="type" id="type" class="form-control" />
                      <span id="error_type" class="text-danger"></span>
                     </div>
                     <div class="form-group">
                      <label>Quantity</label>
                      <input type="text" name="quantity" id="quantity" class="form-control" />
                      <span id="error_quantity" class="text-danger"></span>
                     </div>
                     <div class="form-group" align="center">
                      <input type="hidden" name="row_id" id="hidden_row_id" />
                      <button type="button" name="save" id="save" class="btn btn-info">Save</button>
                    </div>
                </div>
                 <div id="action_alert" title="Action"></div>
               </div>

</body>
</html>

<script>
$(document).ready(function(){

 var count = 0;

 $('#popup_add').dialog({
  autoOpen:false,
  width:400
 });

 $('#add').click(function(){
  $('#popup_add').dialog('option', 'title', 'Add Order Item');
  $('#width').val('');
  $('#height').val('');
  $('#type').val('');
  $('#quantity').val('');
  $('#error_width').text('');
  $('#error_height').text('');
  $('#error_type').text('');
  $('#error_quantity').text('');
  $('#width').css('border-color', '');
  $('#height').css('border-color', '');
  $('#type').css('border-color', '');
  $('#quantity').css('border-color', '');
  $('#save').text('Save');
  $('#popup_add').dialog('open');
 });

 $('#save').click(function(){
  var error_width = '';
  var error_height = '';
  var error_type = '';
  var error_quantity = '';
  var width = '';
  var height = '';
  var type = '';
  var quantity = '';

  if($('#width').val() == '')
  {
   error_width = 'Width is required';
   $('#error_width').text(error_width);
   $('#width').css('border-color', '#cc0000');
   width = '';
 }else if(isNaN($('#width').val())){
   error_width = 'Width needs to be a number';
   $('#error_width').text(error_width);
   $('#width').css('border-color', '#cc0000');
   width = '';
 }
  else
  {
   error_width = '';
   $('#error_width').text(error_width);
   $('#width').css('border-color', '');
   width = $('#width').val();
  }

  if($('#height').val() == '')
  {
   error_height = 'Height is required';
   $('#error_height').text(error_height);
   $('#height').css('border-color', '#cc0000');
   height = '';
 }else if(isNaN($('#height').val())){
    error_width = 'Height needs to be a number';
    $('#error_height').text(error_width);
    $('#height').css('border-color', '#cc0000');
    height = '';
  }
  else
  {
   error_height = '';
   $('#error_height').text(error_height);
   $('#height').css('border-color', '');
   height = $('#height').val();
  }

  if($('#type').val() == '')
  {
   error_type = 'Type is required';
   $('#error_type').text(error_type);
   $('#type').css('border-color', '#cc0000');
   type = '';
  }
  else
  {
   error_type = '';
   $('#error_type').text(error_type);
   $('#type').css('border-color', '');
   type = $('#type').val();
  }

  if($('#quantity').val() == '')
  {
   error_quantity = 'Last Name is required';
   $('#error_quantity').text(error_quantity);
   $('#quantity').css('border-color', '#cc0000');
   quantity = '';
 }else if(isNaN($('#quantity').val())){
     error_width = 'Quantity needs to be a number';
     $('#error_quantity').text(error_width);
     $('#quantity').css('border-color', '#cc0000');
     quantity = '';
   }
  else
  {
   error_quantity = '';
   $('#error_quantity').text(error_quantity);
   $('#quantity').css('border-color', '');
   quantity = $('#quantity').val();
  }
  if(error_width != '' || error_height != '' || error_type != '' || error_quantity != '' )
  {
   return false;
  }
  else
  {
   if($('#save').text() == 'Save')
   {
    count = count + 1;
    output = '<tr id="row_'+count+'">';
    output += '<td>'+width+' <input type="hidden" name="hidden_width[]" id="width'+count+'" class="width" value="'+width+'" /></td>';
    output += '<td>'+height+' <input type="hidden" name="hidden_height[]" id="height'+count+'" value="'+height+'" /></td>';
    output += '<td>'+type+' <input type="hidden" name="hidden_type[]" id="type'+count+'" value="'+type+'" /></td>';
    output += '<td>'+quantity+' <input type="hidden" name="hidden_quantity[]" id="quantity'+count+'" value="'+quantity+'" /></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
    output += '</tr>';
    $('#append-here').append(output);
   }
   else
   {
    var row_id = $('#hidden_row_id').val();
    output = '<td>'+width+' <input type="hidden" name="hidden_width[]" id="width'+row_id+'" class="width" value="'+width+'" /></td>';
    output += '<td>'+height+' <input type="hidden" name="hidden_height[]" id="height'+row_id+'" value="'+height+'" /></td>';
    output += '<td>'+type+' <input type="hidden" name="hidden_type[]" id="tyoe'+row_id+'" value="'+type+'" /></td>';
    output += '<td>'+quantity+' <input type="hidden" name="hidden_quantity[]" id="quantity'+row_id+'" value="'+quantity+'" /></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+row_id+'">Remove</button></td>';
    $('#row_'+row_id+'').html(output);
   }

   $('#popup_add').dialog('close');
  }
 });

 $(document).on('click', '.remove_details', function(){
  var row_id = $(this).attr("id");
  if(confirm("Are you sure you want to remove this item?"))
  {
   $('#row_'+row_id+'').remove();
  }
  else
  {
   return false;
  }
 });

 $('#action_alert').dialog({
  autoOpen:false
 });

// did this reach?
 //$(document).on('click', '.database-access', function(event){
$('#order_form').on('submit', function(event){
  event.preventDefault();
  var count_data = 0;
  $('.width').each(function(){
   count_data = count_data + 1;
  });
  if(count_data > 0)
  {
    var form_data = $(this).serialize();
       $.ajax({
        url:"orderController.php",
        method:"POST",
        data:form_data,
        success:function(data)
    {
     $('#dynamic_field').find("tr:gt(0)").remove();
     $('#action_alert').html('<p>Order Placed Successfully</p>');
     $('#action_alert').dialog('open');
     if($('#action_alert').dialog('close')){
       window.location.href = "customerprofile.php";
     }


    }
   })
  }
  else
  {
   $('#action_alert').html('<p>Please Add at least one order item</p>');
   $('#action_alert').dialog('open');
  }
 });

});
</script>
