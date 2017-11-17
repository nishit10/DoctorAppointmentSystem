<?Php

@$doc_email=$_GET['doctor_email'];
@$date=$_GET['date'];

//$cat_id=2;
/// Preventing injection attack //// 
/// end of checking injection attack ////
$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	mysqli_select_db($conn, $database);
	
//for time dropdown
$sql2="SELECT starttime, endtime from doctor where doctor.email='$doc_email'";
$getTime = mysqli_query($conn, $sql2);
$result=mysqli_fetch_array($getTime);
$startTime=$result['starttime'];
$endTime = $result['endtime'];

$tStart = strtotime($startTime);
$tEnd = strtotime($endTime);
$tNow = $tStart;

$timeIntervals = array();
//echo "dfghd".$result;
	//echo "dfhd";
while($tNow <= $tEnd){
	array_push($timeIntervals, date("H:i",$tNow));
	$tNow = strtotime('+30 minutes',$tNow);
}

$sql= "select time from appointment where
doctorid in(select doctorid from doctor where email='$doc_email') and date='$date' ";
$getTime1 = mysqli_query($conn, $sql);

$booked=array();
while ($result1=mysqli_fetch_array($getTime1))
{
	array_push($booked, date("H:i",strtotime($result1['time'])));
}
$resultTime=array();

$result=array_diff($timeIntervals,$booked);
foreach ($result as $k => $v) {
	array_push($resultTime,$v);
}

echo json_encode($resultTime);
?>