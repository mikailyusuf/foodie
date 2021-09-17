<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "foodie";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: bla bla bla" . mysqli_connect_error());
}
else{
    // echo ("SUCCESS");
}
?>