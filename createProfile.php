<?php
$email = $_POST ['email'];
$fname = $_POST ['fname'];
$lname = $_POST ['lname'];
$state = $_POST ['state'];
$userPassword = $_POST ['password'];
$gender = $_POST ['element_7'];
$phone = $_POST ['phone'];
$role = 'patient';
$date = $_POST ['date'];
$streetaddress = $_POST ['address'];
$city = $_POST ['city'];
$state = $_POST ['state'];
$pincode = $_POST ['postal'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (! $conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}

$sql = "INSERT INTO person (city, dob, email,fname,gender,lname,pincode,role,state,streetaddress,phonenumber)
                VALUES ('$city', '$date', '$email','$fname','$gender','$lname','$pincode','$role','$state','$streetaddress','$phone') ";

$get = mysqli_query ( $conn, $sql );

$sql = "INSERT INTO login (email,password,role)
                VALUES ('$email','$userPassword','$role') ";

$get = mysqli_query ( $conn, $sql );
session_start ();
$_SESSION ['email'] = $email;
$_SESSION ['role'] = $role;
header ( 'Location:Home.php' );

?>
