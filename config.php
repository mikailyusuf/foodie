<?php
$servername = "us-cdbr-east-04.cleardb.com";
$username = "b4648a63ce8915";
$password = "7fe1b683";
$dbname = "heroku_b245c64bace413b";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//show error
else{
    // echo ("SUCCESS");
}
?>