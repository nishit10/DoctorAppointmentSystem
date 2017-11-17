<?Php
$doc_email='ashaah59@uncc.edu';
//@$doc_email=$_GET['doctor_email'];
//echo $doc_email;
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
	
 $sql="SELECT starttime, endtime from doctor where doctor.email='$doc_email'";

$getTime = mysqli_query($conn, $sql);
$result=mysqli_fetch_array($getTime);
$startTime=$result['starttime'];
$endTime = $result['endtime'];
$duration = $endTime - $startTime;

$tStart = strtotime($startTime);
$tEnd = strtotime($endTime);
$tNow = $tStart;

echo $startTime;
echo $tEnd;

$timeIntervals = array();
while($tNow <= $tEnd){
 array_push($timeIntervals, date("H:i",$tNow));
  $tNow = strtotime('+30 minutes',$tNow);
}
//echo $getdoctor->num_rows;
// $main=array();
// //$results_array = array();
// foreach($getdoctor as $doc)
// {      $main[] = array('docreviewid' => $doc['docreviewid'],
//                         'rating' => $doc['rating']);
// }

// //$main = array('data'=>$result);
 echo json_encode($timeIntervals);
?>