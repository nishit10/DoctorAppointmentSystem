<?php
session_start ();
if (empty ( $_SESSION ['email'] ))
	header ( 'Location:Login.php' );

$servername = "localhost";
$username = "root";
$password = "";
$database = "doctorappointmentsystem";

$conn = mysqli_connect ( $servername, $username, $password );
mysqli_select_db ( $conn, $database );

if (! $conn) {
	die ( "Connection failed: " . mysqli_connect_error () );
}

$queryPatient = "select * from patient where email='" . $_SESSION ['email'] . "'";
$getPatient = mysqli_query ( $conn, $queryPatient );
$patient = mysqli_fetch_array ( $getPatient );
$patientID = $patient ['patientid'];

$querySpecialization = 'select distinct specialization from doctor';
$getSpecialization = mysqli_query ( $conn, $querySpecialization );

if ($_SERVER ["REQUEST_METHOD"] == "POST") {
	$doc_email = $_POST ["doctorname"];
	$date = $_POST ["date"];
	$time = $_POST ["time"];
	
	$get_docid = mysqli_fetch_array ( mysqli_query ( $conn, "Select doctorid from doctor where email='$doc_email'" ) );
	$docid = $get_docid ["doctorid"];
	
	$queryInsert = "INSERT INTO appointment(patientid,doctorid,date,time) values('$patientID','$docid','$date','$time')";
	$getPatient = mysqli_query ( $conn, $queryInsert );
	header ( 'Location:Home.php' );
}

?>
<!--
Author: Anal Shah
-->
<!DOCTYPE html>
<html>
<head>
<title>Make an Appointment - AppointDoctor</title>
<link href="css/bootstrap.css" type="text/css" rel="stylesheet"
	media="all">
<link href="css/style.css" type="text/css" rel="stylesheet" media="all">
<!--web-font-->
<link
	href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
	rel='stylesheet' type='text/css'>
<link
	href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
	rel='stylesheet' type='text/css'>
<!--//web-font-->
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript">
	
	 addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 

</script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- //Custom Theme files -->
<!-- js -->
<script src="js/jquery.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!-- //js -->
<!-- start-smoth-scrolling-->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript" src="js/modernizr.custom.53451.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event) {
			event.preventDefault();
			$('html,body').animate({
				scrollTop : $(this.hash).offset().top
			}, 1000);
		});
	});
</script>
<!--//end-smoth-scrolling-->
</head>
<body>
	<!--header-->
	<div class="header">
		<div class="container">
			<div class="top-middle">
				<a href="Home.php">
					<h3>AppointDoctor</h3>
				</a>
			</div>
			<div class="top-nav">
				<span class="menu"><img src="images/menu-icon.png" alt="" /></span>
				<ul class="nav1">
					<li><a href="Home.php">Home</a></li>
					<li><a href="MakeAppointment.php" class="active">Make an
							Appointment</a></li>
					<li><a href="about.html">About Us</a></li>
					<li><a href="Logout.php">Logout</a></li>
				</ul>
				<!-- script-for-menu -->
				<script>
					$("span.menu").click(function() {
						$("ul.nav1").slideToggle(300, function() {
							// Animation complete.
						});
					});
				</script>
				<!-- /script-for-menu -->
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!--//header-->
	<!--banner-->
	<div class="content">
		<div class="container">
			<div class="content-grids">
				<div class="work-title humble-title">
					<h3>
						MAKE<span>AN APPOINTMENT</span>
					</h3>
				</div>
				<div class="features-info">
					<div class="features-text tg-wrap">
						<form class="form-horizontal" action="MakeAppointment.php"
							method="post" name="appt">
							<table class='tg'
								style="width: 60%; margin-left: 20%; margin-right: 20%">
								<tr>
									<td>Select Specialization</td>
									<td><select name="specialization" class="btn1" id="spec"
										onchange="AjaxFunctionForDoctor()" required="required">
											<option value="" selected="selected">---Select---</option>			
			<?php
			while ( $row = mysqli_fetch_array ( $getSpecialization ) ) {
				$specialization = $row ['specialization'];
				echo '<option value="' . $specialization . '" >' . $specialization . '</option>';
			}
			?>
		</select></td>
								</tr>
								<tr>
									<td>Select Doctor</td>
									<td><select name="doctorname" class="btn1" id="doctor"
										required="required">
											<option value="">---Select---</option>
									</select></td>
								</tr>
								<tr>
									<td>Avg. Rating</td>
									<td id="rating"></td>
								</tr>
								<tr>
									<td>Select Date</td>
									<td><input type="date" class="btn1" name="date" id="date"
										required="required" onchange="AjaxFunctionForTime()"></td>
								</tr>
								<tr>
									<td>Select Time</td>
									<td><select name="time" id="time" class="btn1"
										required="required">
											<option value="">---Select---</option>
									</select></td>
								</tr>
								<tr>
									<td></td>
									<td><button type="submit" class="btn1" id="book" name="book"
											onclick="">Book the Appointment</button></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>

	<script type="text/javascript">	
	     function AjaxFunctionForDoctor(){
		     
		     var httpxml=new XMLHttpRequest();
		     function stateck() {    
		     if(httpxml.readyState==4){	
			     
				 var myarray = JSON.parse(httpxml.responseText);
				 
				 // Remove the options from 2nd dropdown list 
				if(document.appt.doctorname.options.length >1){
				 for(j=document.appt.doctorname.options.length-1;j>0;j--){
		 				document.appt.doctorname.remove(j);
					 }
				}
				if(document.appt.time.options.length >0){
					 for(j=document.appt.time.options.length-1;j>0;j--){
			 				document.appt.time.remove(j);
						 }
					}
				
				 for (i=0;i<myarray.length;i++)
				 {					 
				 	var  optn = document.createElement("OPTION");
					var obj=myarray[i];
					var count=0;
					for(var id in obj){
			            var attrName = id;
			            var attrValue = obj[id];
						if(count==0){
							optn.text = attrValue;	
							count++;
						} else {
						optn.value=attrValue;
				        }
					}		
 					document.appt.doctorname.options.add(optn);
				 }
		       }
		     }
	     // var specs=document.getElementById('spec').value;
	      var url="doctordropdown.php";
	      var spec_name=document.getElementById('spec').value;
	      document.getElementById("rating").innerHTML = "";
	      document.getElementById("date").value = "";
	      document.getElementById("time").value = "";
	      //document.getElementById("message").innerHTML = "";
	      //alert(spec_name);
	      url=url+"?spec_name="+spec_name;
	      httpxml.onreadystatechange=stateck;
	      httpxml.open("GET",url,true);
	      httpxml.send(null);
	     }

	     function AjaxFunctionForTime(){
		     var httpxml=new XMLHttpRequest();
		     function stateck() {    
		    	 if(document.appt.time.options.length >1){
					 for(j=document.appt.time.options.length-1;j>0;j--){
			 				document.appt.time.remove(j);
						 }
					}
					
		     if(httpxml.readyState==4){	 
			     //alert(JSON.parse(httpxml.responseText));   	
				 var myarray = JSON.parse(httpxml.responseText);
				 if (!(document.getElementById('doctor').value==""))
				 {
						for (i=0;i<myarray.length;i++)
						 {
						 	var  optn = document.createElement("OPTION");
							optn.text=myarray[i];
							 document.appt.time.options.add(optn);
						 }	
				 }			
		     }
		     }
	      var specs=document.getElementById("doctor").value;
	      var url="timedropdown.php";
	      var doctor_email=document.getElementById('doctor').value;
	      url=url+"?doctor_email="+doctor_email+"&date=" + document.getElementById("date").value;
	      httpxml.onreadystatechange=stateck;
	      httpxml.open("GET",url,true);
	      httpxml.send(null);
	     }

	     $("#book").click(function(){	
		    // alert("Appointment booked successfully!!");
		 });
	     
	     $("#doctor").change(function(){
				
				if (window . XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest ();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject ( "Microsoft.XMLHTTP" );
				}
				xmlhttp.onreadystatechange = function () {
					
					if (xmlhttp . readyState == 4 && xmlhttp . status == 200) {
						document.getElementById("rating").innerHTML = (xmlhttp.responseText ? xmlhttp.responseText : "-") + "/5";
					}
				};
				
				xmlhttp . open ( "GET", "getRating.php?drEmail=" + document.getElementById("doctor").value, true );
				xmlhttp . send ();
			});
	</script>
	<!--//content-->
	<div class="footer">
		<div class="container">
			<div class="footer-left">
				<a href="Home.php">AppointDoctor</a>
			</div>
			<div class="footer-right">
				<p>&copy; 2016 All rights reserved</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!--smooth-scrolling-of-move-up-->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
			};
			 */

			$().UItoTop({
				easingType : 'easeOutQuart'
			});

		});
	</script>
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover"
		style="opacity: 1;"> </span></a>
	<!--//smooth-scrolling-of-move-up-->

</body>
</html>