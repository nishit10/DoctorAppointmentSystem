<?php
session_start ();
if (empty ( $_SESSION ['email'] ))
	header ( 'Location:Login.php' );
@$spec_name = $_GET ['spec_name'];
$drEmail = $_REQUEST ["drEmail"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (! $conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}

$query = "INSERT INTO patient (email,predoctor) VALUES ('" . $_SESSION ['email'] . "','$drEmail') ON DUPLICATE KEY UPDATE predoctor='$drEmail'";
$get = mysqli_query ( $conn, $query );

echo "Updated!";
?>