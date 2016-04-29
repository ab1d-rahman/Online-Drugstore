<?php 

$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

if(mysqli_connect_errno()) echo "Failed to connect: " . mysqli_connect_errno();
?>