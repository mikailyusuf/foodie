<?php
include 'config.php';
include 'token_generator.php';

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
        $password= password_hash($data['password'], PASSWORD_DEFAULT);
        $token = generateToken();
        $user_id = uniqid();

        $sql = "INSERT INTO `restaurants`( `id`,`name`, `email`,`phone`,`address`,`token`,`password`) 
		VALUES ('$user_id','$name','$email','$phone','$address','$token','$password')";
		if (mysqli_query($conn, $sql)) {
            echo sizeof($data);
            $message = json_encode(array("message" => "Restaurant Created Successfully", "status" => true));	
            http_response_code(201);
            echo $message;
		} 
		else {
		    
            $message = json_encode(array("message" => mysqli_error($conn), "status" => false));	
            http_response_code(400);
            echo $message;
		}
      }
      else{
        http_response_code(400);
    } 
}   

catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }

}

else{
  $message = json_encode(array("message" => "Bad Request", "status" => false));	
            http_response_code(400);
            echo $message;
}

?>