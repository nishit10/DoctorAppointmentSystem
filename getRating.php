<?php
session_start ();
if (empty ( $_SESSION ['email'] ))
	header ( 'Location:Login.php' );
//@$spec_name = $_GET ['spec_name'];
$drEmail=$_REQUEST["drEmail"];
//$drEmail = request.querystring("drEmail");
//$drEmail='ashaah59@uncc.edu';
//echo $drEmail;
$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (!$conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}

$sql="SELECT ROUND(AVG(rating),2) as average FROM doctorreview inner join appointment on doctorreview.appid=appointment.appid WHERE doctorid=(select doctorid from doctor where email='$drEmail')";
$getrating = mysqli_query($conn, $sql);
$getrating= mysqli_fetch_array($getrating);
echo $getrating['average'];
