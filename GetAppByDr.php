<?php
session_start ();
if (empty ( $_SESSION ['email'] ))
	header ( 'Location:Login.php' );
@$spec_name = $_GET ['spec_name'];
$drId = $_REQUEST ["drId"];
$hist1 = $_REQUEST ["hist"];
$upc1 = $_REQUEST ["upc"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (! $conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}
if ($hist1 == 1) {
	$query = "SELECT appointment.patientid, person.fname, person.lname, appointment.date, appointment.prescription, appointment.appid FROM appointment inner join patient on appointment.patientid=patient.patientid INNER JOIN person on patient.email=person.email where doctorid=$drId and date <= CURDATE() ORDER BY appointment.date DESC";
	$get = mysqli_query ( $conn, $query );
	$hist = mysqli_fetch_all ( $get );
	
	if (count ( $hist ) > 0) {
		echo "
				<table id='tg-cHuKU1' class='tg'>
									<tr>
										<th>Patient</th>
										<th>Date</th>
										<th>Prescription</th>
										<th>Payment</th>
									</tr>";
		
		foreach ( $hist as $app ) {
			echo "<tr><td>$app[0] - $app[1] $app[2]</td><td>$app[3]</td><td>$app[4]</td>";
			$queryPayment = "select * from paymenthistory where appid=$app[5]";
			$getPayment = mysqli_query ( $conn, $queryPayment );
			$payment = mysqli_fetch_array ( $getPayment );
			$amount = $payment ['amount'];
			if ($amount) {
				echo "<td>$amount</td>";
			} else {
				echo "<td><input type='number'>&nbsp;&nbsp;&nbsp;&nbsp;<button class='btn1'>Save</button></td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "<p>No appointment history</p>";
	}
} else if ($upc1 == 1) {
	$queryUpc = "SELECT appointment.patientid, person.fname, person.lname, appointment.date, TIME_FORMAT(appointment.time, '%H:%i'),  appointment.appid FROM appointment inner join patient on appointment.patientid=patient.patientid INNER JOIN person on patient.email=person.email where doctorid=$drId and date > CURDATE() ORDER BY appointment.date, appointment.time";
	$getUpc = mysqli_query ( $conn, $queryUpc );
	$upc = mysqli_fetch_all ( $getUpc );
	if (count ( $upc ) > 0) {
		echo "
				<table id='tg-cHuKU' class='tg'>
									<tr>
										<th>Patient</th>
										<th>Date</th>
										<th>Time</th>
										<th></th>
									</tr>";
		
		foreach ( $upc as $app ) {
			echo "<tr><td>$app[0] - $app[1] $app[2]</td><td>$app[3]</td><td>$app[4]</td>";
			echo "<td><a href='MakeAppointment.php?appId=" . $app [5] . "'>Change</a><br />";
			echo "<a href='CancelApp.php?appId=" . $app [5] . "'>Cancel</a></td></tr>";
		}
		echo "</table>";
	} else {
		echo "<p>No upcoming appointments</p>";
	}
}
?>