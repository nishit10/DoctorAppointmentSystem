<?Php
//echo $_GET['spec_name'];
@$spec_name=$_GET['spec_name'];
//@$spec_name='family physician';
//echo "test"+$spec_name;
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
 $sql="SELECT person.fname,person.email as doctorname 
 				from person JOIN doctor 
 				ON person.email=doctor.email 
 				where doctor.specialization='$spec_name'";
// $sql="SELECT p.fname,p.email as doctorname 
// 				from person p,doctor d
// 				where p.email=d.email 
//  				and d.specialization='$spec_name'";

// $sql="SELECT fname,email as doctorname 
// 				from person";
$getdoctor = mysqli_query($conn, $sql);
$result=mysqli_fetch_array($getdoctor);
//echo $getdoctor->num_rows;
$main=array();
//$results_array = array();
foreach($getdoctor as $doc)
{      $main[] = array('fname' => $doc['fname'],
                          'email' => 
                               $doc['doctorname']        
);
}

//$main = array('data'=>$result);
echo json_encode($main);
?>