<?php
include 'config.php';
include 'token_generator.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == "POST"){
 try{
   $json_string = file_get_contents( "php://input");
   $data = json_decode($json_string,true);

    if(sizeof($data) > 4){
		$name=$data['name'];
		$email=$data['email'];
		$phone=$data['phone'];
		$address=$data['address'];
    $password = md5(check_input($data['password']));
    
    $status=0;
    $activationcode=md5($email.time());

    verifyEmail($email);
    } //1f

     else{
        http_response_code(400);
    } //1e
  }

    catch(Exception $e){
      $message = json_encode(array("message" => "Bad Request $e", "status" => false));	
                http_response_code(400);
                echo $message;
    }
   
}  

else {
  $message = json_encode(array("message" => "Bad Request", "status" => false));	
            http_response_code(400);
            echo $message;
}


function sendMail($email,$username){

  $message = "
				<html>
				<head>
				<title>Verification Code</title>
				</head>
				<body>
				<h2>Thank you for Registering.</h2>
				<p>Your Account:</p>
				<p>Email: ".$email."</p>
		
				<p>Please click the link below to activate your account.</p>
				<h4><a href='http://localhost/email_verification.php?uid=$uid&code=$code'>Activate My Account</h4>
				</body>
				</html>
				";

 $mail = new PHPMailer(true);

 try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'devmikaeelkyusuf@gmail.com';                     //SMTP username
    $mail->Password   = 'mikail.kunle';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('devmikaeelkyusuf@gmail.com', 'Information');
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification';
    $mail->Body    = $message;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
  }
 catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


function verifyEmail($email){

  $token = bin2hex(random_bytes(50));

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(401);
    $message = json_encode(array("message" => "Email not valid","status" => false));	
    echo $message;
  }
  else{
    $query=mysqli_query($conn,"select * from user where email='$email'");
		if(mysqli_num_rows($query)>0){
      http_response_code(401);
      $message = json_encode(array("message" => "Email already taken","status" => false));	
      echo $message;
		}
		else{
      registerUser();
    }

  }
	
}

function registerUser(){

try{
    $sql = "INSERT INTO `restaurants`( `user_id`,`name`, `email`,`phone`,`is_verified`,`is_active`,`address`,`token`,`password`) 
    VALUES ('$uniqid()','$name','$email','$phone','$address','$token','$password')";

    if (mysqli_query($conn, $sql)) {

      http_response_code(201);
      $message = json_encode(array("message" => "User Created","status" => true));	
      echo $message;
      sendMail($email, $name);

    }
            
    
    else {
      $message = json_encode(array("message" => "mysqli_error($conn)", "status" => false));	
      http_response_code(400);

     }
 }

  catch (Exception $e){

  http_response_code(400);
  $message = json_encode(array("message" => "Error message = $e","status" => false));	
  echo $message;

  }

}
}
?>