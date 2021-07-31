<?php
include 'config.php';
include 'token_generator.php';

try{
$json_string = file_get_contents( "php://input");
$data = json_decode($json_string,true);

		$name=$data['name'];
		$email=$data['email'];
		$phone=$data['phone'];
		$address=$data['address'];
        $password= password_hash($data['password'], PASSWORD_DEFAULT);
        $token = generateToken();

        $sql = "INSERT INTO `users`( `name`, `email`,`phone`,`address`,`token`,`password`) 
		VALUES ('$name','$email','$phone','$address','$token','$password')";
		if (mysqli_query($conn, $sql)) {
            $message = json_encode(array("message" => "User Created Successfully", "status" => true));	
            echo $message;
		} 
		else {
		
            $message = json_encode(array("message" => mysqli_error($conn), "status" => false));	
            echo $message;
 

		}
        // echo(json_encode($data));
        // echo($password);
}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }

?>