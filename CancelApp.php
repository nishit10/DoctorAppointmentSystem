<?php
session_start ();
if (empty ( $_SESSION ['email'] ))
	header ( 'Location:Login.php' );
@$spec_name = $_GET ['spec_name'];
$appId = $_REQUEST ["appId"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (! $conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}
$query = "DELETE FROM appointment WHERE appid = $appId";
$get = mysqli_query ( $conn, $query );
header ( 'Location:Home.php' );
?>