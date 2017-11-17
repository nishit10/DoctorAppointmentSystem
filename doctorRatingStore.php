<?php
session_start ();
if (empty ( $_SESSION ['email'] ))
	header ( 'Location:Login.php' );
@$spec_name = $_GET ['spec_name'];
$rating = $_REQUEST ["rating"];
$review =str_replace("_", " ",$_REQUEST["review"]);
$appid=$_REQUEST["appId"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (! $conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}
$sql = "INSERT INTO doctorreview (review, rating, appid)
		VALUES ('$review', $rating, $appid) ";

$get = mysqli_query ( $conn, $sql );
echo "ViewAppointment.php?appId=$appid";
?>