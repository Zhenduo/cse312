<?php
require_once 'vendor/autoload.php';
require_once 'config/constants.php';
// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD);
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($userEmail, $token){
  global $mailer;
  $body = '<!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
    </head>
  <body>
    <div class = "wrapper">
      <p>Thank you for signing up on our website. Please click the link below to verify your email.</p>
      <a href="http://localhost/Project/customerprofile.php?token=' . $token . '">Verify your email adddress.</a>
      </div>
    </body>
  </html>';
  // Create a message
  $message = (new Swift_Message('Verify your email address'))
    ->setFrom(EMAIL)
    ->setTo($userEmail)
    ->setBody($body, 'text/html');
    ;
  // Send the message
  $result = $mailer->send($message);
}

function sendPasswordResetLink($userEmail, $token){
  global $mailer;

  $body = '<!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    </head>
  <body>
    <div class = "wrapper">
      <p> Hello,<br/><br/>Please click on the link below to reset your password.</p>
      <a href="http://localhost/Project/customerprofile.php?password-token=' . $token . '">Reset your password.</a>

      <p><br/>If you did not initialize the action, please consider changing your email password and contact us.</p>
      </div>
    </body>
  </html>';
  // Create a message
  $message = (new Swift_Message('Reset your password'))
    ->setFrom(EMAIL)
    ->setTo($userEmail)
    ->setBody($body, 'text/html');
    ;
  // Send the message
  $result = $mailer->send($message);
}

function sendApproval($userEmail, $token){
  global $mailer;

  $body = '<!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Order Approval</title>
    </head>
  <body>
    <div class = "wrapper">
      <p> Dear customer,<br/><br/>your order has been approved.</p>

      <p><br/>If you did not initialize the action, please consider changing your email password and contact us.</p>
      </div>
    </body>
  </html>';
  // Create a message
  $message = (new Swift_Message('Order Approval'))
    ->setFrom(EMAIL)
    ->setTo($userEmail)
    ->setBody($body, 'text/html');
    ;
  // Send the message
  $result = $mailer->send($message);
}
 ?>
