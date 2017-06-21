<?php
require_once('db.php');

$fname=mysqli_escape_string($_POST['firstname']);
$lname=mysqli_escape_string($_POST['lastname']);
$birth=mysqli_escape_string($_POST['birth']);
$gender=mysqli_escape_string($_POST['gender']);
$service=mysqli_escape_string($_POST['service']);
$date=mysqli_escape_string($_POST['date']);
$email=mysqli_escape_string($_POST['email']);
$phone=mysqli_escape_string($_POST['phone']);
$description=mysqli_escape_string($_POST['description']);

$query=mysqli_query("INSERT INTO booking_info (firstname, lastname, birth, gender, service, date_time, email, phone, description) VALUES ('$fname','$lname','$birth','$gender','$service','$date','$email','$phone','$description')");

if($query){
  echo "form submitted";
}else{
  echo "error submitting form";
}
mysqli_close($con);
?>