<!--
Author: Anal Shah
-->
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

$queryPerson = "select * from person where email='" . $_SESSION ['email'] . "'";
$getPerson = mysqli_query ( $conn, $queryPerson );
$person = mysqli_fetch_array ( $getPerson );
$firstName = $person ['fname'];
$lastName = $person ['lname'];

$querydoctor = "SELECT doctor.doctorid, person.fname, person.lname, doctor.specialization FROM person INNER JOIN doctor on person.email=doctor.email WHERE person.role='doctor'";
$getdoctor = mysqli_query ( $conn, $querydoctor );
$doctors = mysqli_fetch_all ( $getdoctor );
$firstDrId = $doctors [0] [0];

$queryHist = "SELECT appointment.patientid, person.fname, person.lname, appointment.date, appointment.prescription, appointment.appid FROM appointment inner join patient on appointment.patientid=patient.patientid INNER JOIN person on patient.email=person.email where doctorid=$firstDrId and date <= CURDATE() ORDER BY appointment.date DESC";
$getHist = mysqli_query ( $conn, $queryHist );
$hist = mysqli_fetch_all ( $getHist );

$queryUpc = "SELECT appointment.patientid, person.fname, person.lname, appointment.date, TIME_FORMAT(appointment.time, '%H:%i'),  appointment.appid FROM appointment inner join patient on appointment.patientid=patient.patientid INNER JOIN person on patient.email=person.email where doctorid=$firstDrId and date > CURDATE() ORDER BY appointment.date, appointment.time";
$getUpc = mysqli_query ( $conn, $queryUpc );
$upc = mysqli_fetch_all ( $getUpc );
?>
<!DOCTYPE html>
<html>
<head>
<title>Home - AppointDoctor</title>
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
					<li><a href="Registration.php">Add Doctor/Receptionist</a></li>
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
	<!--content-->
	<div class="content">
		<div class="container">
			<div class="content-grids">
				<div class="work-title humble-title">
					<h3>
						WELCOME,<span><?php
						echo "$firstName $lastName";
						?></span>
					</h3>
				</div>
				<div class="features-info">
					<div class="features-text">
						<h4>APPOINTMENT HISTORY</h4>
						<p>
							Select Doctor:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select
								id="chooseDrHist" class="btn1">
						<?php
						foreach ( $doctors as $doc ) {
							echo "<option value='$doc[0]'>Dr. $doc[1] $doc[2] ($doc[3])</option>";
						}
						?>
						</select>
						</p>
						<script type="text/javascript">
						$("#chooseDrHist").change(function(){
							if (window . XMLHttpRequest) {
								// code for IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp = new XMLHttpRequest ();
							} else {
								// code for IE6, IE5
								xmlhttp = new ActiveXObject ( "Microsoft.XMLHTTP" );
							}
							xmlhttp.onreadystatechange = function () {
								if (xmlhttp . readyState == 4 && xmlhttp . status == 200) {
									$("#histTable").html(xmlhttp . responseText);
								}
							};
							xmlhttp . open ( "GET", "GetAppByDr.php?hist=1&upc=0&drId=" + document.getElementById("chooseDrHist").value, true );
							xmlhttp . send ();
						});
						</script>
						<div id="histTable" class='tg-wrap'>
							<?php
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
							?>
						</div>
					</div>
				</div>
				<div class="features-info">
					<div class="features-text">
						<h4>UPCOMING APPOINTMENTS</h4>
						<p>
							Select Doctor:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select
								id="chooseDrUpc" class="btn1">
						<?php
						foreach ( $doctors as $doc ) {
							echo "<option value='$doc[0]'>Dr. $doc[1] $doc[2] ($doc[3])</option>";
						}
						?>
						</select>
						</p>
						<script type="text/javascript">
						$("#chooseDrUpc").change(function(){
							if (window . XMLHttpRequest) {
								// code for IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp = new XMLHttpRequest ();
							} else {
								// code for IE6, IE5
								xmlhttp = new ActiveXObject ( "Microsoft.XMLHTTP" );
							}
							xmlhttp.onreadystatechange = function () {
								if (xmlhttp . readyState == 4 && xmlhttp . status == 200) {
									$("#upcTable").html(xmlhttp . responseText);
								}
							};
							xmlhttp . open ( "GET", "GetAppByDr.php?upc=1&hist=0&drId=" + document.getElementById("chooseDrUpc").value, true );
							xmlhttp . send ();
						});
						</script>
						<div id="upcTable" class='tg-wrap'>
							<?php
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
							?>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript" charset="utf-8">var TgTableSort=window.TgTableSort||function(n,t){"use strict";function r(n,t){for(var e=[],o=n.childNodes,i=0;i<o.length;++i){var u=o[i];if("."==t.substring(0,1)){var a=t.substring(1);f(u,a)&&e.push(u)}else u.nodeName.toLowerCase()==t&&e.push(u);var c=r(u,t);e=e.concat(c)}return e}function e(n,t){var e=[],o=r(n,"tr");return o.forEach(function(n){var o=r(n,"td");t>=0&&t<o.length&&e.push(o[t])}),e}function o(n){return n.textContent||n.innerText||""}function i(n){return n.innerHTML||""}function u(n,t){var r=e(n,t);return r.map(o)}function a(n,t){var r=e(n,t);return r.map(i)}function c(n){var t=n.className||"";return t.match(/\S+/g)||[]}function f(n,t){return-1!=c(n).indexOf(t)}function s(n,t){f(n,t)||(n.className+=" "+t)}function d(n,t){if(f(n,t)){var r=c(n),e=r.indexOf(t);r.splice(e,1),n.className=r.join(" ")}}function v(n){d(n,L),d(n,E)}function l(n,t,e){r(n,"."+E).map(v),r(n,"."+L).map(v),e==T?s(t,E):s(t,L)}function g(n){return function(t,r){var e=n*t.str.localeCompare(r.str);return 0==e&&(e=t.index-r.index),e}}function h(n){return function(t,r){var e=+t.str,o=+r.str;return e==o?t.index-r.index:n*(e-o)}}function m(n,t,r){var e=u(n,t),o=e.map(function(n,t){return{str:n,index:t}}),i=e&&-1==e.map(isNaN).indexOf(!0),a=i?h(r):g(r);return o.sort(a),o.map(function(n){return n.index})}function p(n,t,r,o){for(var i=f(o,E)?N:T,u=m(n,r,i),c=0;t>c;++c){var s=e(n,c),d=a(n,c);s.forEach(function(n,t){n.innerHTML=d[u[t]]})}l(n,o,i)}function x(n,t){var r=t.length;t.forEach(function(t,e){t.addEventListener("click",function(){p(n,r,e,t)}),s(t,"tg-sort-header")})}var T=1,N=-1,E="tg-sort-asc",L="tg-sort-desc";return function(t){var e=n.getElementById(t),o=r(e,"tr"),i=o.length>0?r(o[0],"td"):[];0==i.length&&(i=r(o[0],"th"));for(var u=1;u<o.length;++u){var a=r(o[u],"td");if(a.length!=i.length)return}x(e,i)}}(document);document.addEventListener("DOMContentLoaded",function(n){TgTableSort("tg-cHuKU")});document.addEventListener("DOMContentLoaded",function(n){TgTableSort("tg-cHuKU1")});</script>
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