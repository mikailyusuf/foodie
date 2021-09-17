<?php
$servername = "us-cdbr-east-04.cleardb.com";
$username = "b3b7a278827dcb";
$password = "bd4020e6";
$dbname = "foodie";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: bla bla bla" . mysqli_connect_error());
}
else{
    // echo ("SUCCESS");
}
?>