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

mysqli_select_db ( $conn, $database );
$querySpecialization = "select * from appointment where appid=$appId";
$getSpecialization = mysqli_query ( $conn, $querySpecialization );
$g = mysqli_fetch_array ( $getSpecialization );
$date = $g ['date'];
$time = substr ( $g ['time'], 0, 5 );
$prescription = $g ['prescription'];
$patientId = $g ['patientid'];
$doctorId = $g ['doctorid'];

$querySpecialization = "select * from doctor inner join person on doctor.email=person.email where doctorid = '$doctorId'";
$getSpecialization = mysqli_query ( $conn, $querySpecialization );
$g = mysqli_fetch_array ( $getSpecialization );
$drName = "Dr." . $g ['fname'] . " " . $g ['lname'];
$specialization = $g ['specialization'];

$querySpecialization = "select * from doctorreview where appid=$appId";
$getSpecialization = mysqli_query ( $conn, $querySpecialization );
$g = mysqli_fetch_array ( $getSpecialization );

?>
<!DOCTYPE html>
<html>
<head>
<title>View Appointment - AppointDoctor</title>
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
					<li><a href="Home.php" class="active">Home</a></li>
					<li><a href="MakeAppointment.php">Make an Appointment</a></li>
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
		</div>
	</div>
	<!--//header-->
	<!--content-->
	<div class="content">
		<div class="container">
			<div class="content-grids">
				<div class="work-title humble-title">
					<h3>
						VIEW<span>APPOINTMENT</span>
					</h3>
				</div>
				<div class="features-info">
					<div class="features-text tg-wrap">
						<table class='tg'
							style="width: 60%; margin-left: 20%; margin-right: 20%">
							<tr>
								<td>Doctor Name</td>
								<td>
									<?php echo $drName;?>
									</td>
							</tr>
							<tr>
								<td>Specialization</td>
								<td>
									<?php echo $specialization;?>
									</td>
							</tr>
							<tr>
								<td>Date</td>
								<td>
									<?php echo $date;?>
									</td>
							</tr>
							<tr>
								<td>Time</td>
								<td>
									<?php echo $time;?>
									</td>
							</tr>
							<tr>
								<td>Prescription</td>
								<td>
									<?php echo $prescription;?>
									</td>
							</tr>
							<tr>
								<td>Rating</td>
								<td>
<?php
if ($g ['rating'] == 0) {
	?>	<input type="radio" class="rating" name="rating"
									<?php if (isset($rating) && $rating=="1") echo "checked";?>
									value="1">1 <input type="radio" class="rating" name="rating"
									<?php if (isset($rating) && $rating=="2") echo "checked";?>
									value="2">2 <input type="radio" class="rating" name="rating"
									<?php if (isset($rating) && $rating=="3") echo "checked";?>
									value="3">3 <input type="radio" class="rating" name="rating"
									<?php if (isset($rating) && $rating=="4") echo "checked";?>
									value="4">4 <input type="radio" class="rating" name="rating"
									<?php if (isset($rating) && $rating=="5") echo "checked";?>
									value="5">5
	<?php
} else {
	echo $g ['rating'];
}

?> 
								</td>
							</tr>
							<tr>
								<td>Review Comments</td>
								<td>
							<?php
							if ($g ['rating'] == 0) {
								?>	<input type="text" class="rating" id="review" name="review"
									id="review"></input>
									 
	<?php
							} else {
								echo $g ['review'];
							}
							
							?> 
							</td>
							</tr>
							<?php
							if ($g ['rating'] == 0) {
								?>
							<tr>
								<td></td>
								<td><Button class="btn1" id="submit">Submit</Button></td>
							</tr>
							<?php
							}
							?>
						</table>

					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
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

		$("#submit").click(function()
		{
			var urlParams;
			var match,
	        pl     = /\+/g,  // Regex for replacing addition symbol with a space
	        search = /([^&=]+)=?([^&]*)/g,
	        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
	        query  = window.location.search.substring(1);
	        urlParams = {};
	        while (match = search.exec(query))
		        urlParams[decode(match[1])] = decode(match[2]);
		    
			var radioValue = $("input[name='rating']:checked").val();
			var review = $("#review").val().replace(" ","_");
 	        if(radioValue)
	        {
				if (window . XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest ();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject ( "Microsoft.XMLHTTP" );
				}
				xmlhttp.onreadystatechange = function () {
					if (xmlhttp . readyState == 4 && xmlhttp . status == 200) {
						window.location.href = xmlhttp.responseText;
					}
				};
				xmlhttp . open ( "GET", "doctorRatingStore.php?appId=" + urlParams["appId"] + "&rating=" + radioValue + "&review=" + review, true);
				xmlhttp . send ();
	        }
			});
		});
	</script>
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover"
		style="opacity: 1;"> </span></a>
	<!--//smooth-scrolling-of-move-up-->
</body>
</html>