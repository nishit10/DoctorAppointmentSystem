<?php
// session_start ();
// if (empty ( $_SESSION ['email'] ))
// header ( 'Location:Login.php' );
@$spec_name = $_GET ['spec_name'];
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
$email = $fname = $lname = $gender = $password = $phone = $date = null;
?>
<!DOCTYPE html>
<html>
<head>
<title>Registration - AppointDoctor</title>
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
					<li><a href="about.html">About Us</a></li>
					<li><a href="Login.php">Login</a></li>
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
						USER<span>REGISTRATION</span>
					</h3>
				</div>
				<div class="features-info">
					<div class="features-text tg-wrap">
						<form id="form_register" class="appnitro" method="post"
							action="createProfile.php">
							<table class='tg'
								style="width: 60%; margin-left: 20%; margin-right: 20%">
								<tr>
									<td>Email</td>
									<td><input id="email" name="email"
										type="Email" required maxlength="255"
										value="<?php echo $email;?>" /></td>
								</tr>
								<tr>
									<td>Password</td>
									<td><input id="password" name="password" type="password" maxlength="255"
										value="<?php echo $password;?>" required /></td>
								</tr>
								<tr>
									<td>First Name</td>
									<td><input id="fname" name="fname"
										type="text" maxlength="255" value="<?php echo $fname;?>"
										required /></td>
								</tr>
								<tr>
									<td>Last Name</td>
									<td><input id="lname" name="lname"
										type="text" maxlength="255" value="<?php echo $lname;?>"
										required /></td>
								</tr>
								<tr>
									<td>Gender</td>
									<td><input id="element_7_1" name="element_7" type="radio"
										value="Male" required>Male <input id="element_7_2"
										name="element_7" type="radio" value="Female">Female</td>
								</tr>
								<tr>
									<td>Phone</td>
									<td><input id="phone" name="phone"
										type="number" maxlength="10" min="1000000000" max="9999999999"
										value="<?php echo $phone;?>" required /></td>
								</tr>
								<tr>
									<td>Birth Date</td>
									<td><input type="date" id="date" name="date"
										value="<?php echo $date?>" required /> <span id="calendar_5">
									</span> <script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_5_3",
			baseField    : "element_5",
			displayArea  : "calendar_5",
			button		 : "cal_img_5",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script></td>
								</tr>
								<tr>
									<td>Address : Street</td>
									<td><input id="address" name="address"
										class="element text large" value="" type="text" required></td>
								</tr>
								<tr>
									<td>City</td>
									<td><input id="City" name="city"
										value="" type="text" required></td>
								</tr>
								<tr>
									<td>State</td>
									<td><select class="element select medium" id="state"
										name="state" required>
											<option value="" selected="selected">State</option>
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="DC">District Of Columbia</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC">North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
									</select></td>
								</tr>
								<tr>
									<td>Postal Code</td>
									<td><input id="postal" name="postal"
										class="element text medium" maxlength="15" value=""
										type="text" required></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="hidden" name="form_id" value="1123787"
										required /><Button id="saveForm" class="btn1" type="submit"
										name="submit">Submit</button></td>
								</tr>
							</table>
						</form>
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

	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover"
		style="opacity: 1;"> </span></a>
	<!--//smooth-scrolling-of-move-up-->
</body>
</html>




























<html>
<body>Please fill out the following form:



</body>

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
		    
			var radioValue = $("input[name='gender']:checked").val();
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
				xmlhttp . open ( "GET", "doctorRatingStore.php?appId=" + $firstname + "&rating=" + $lastname + "&review=" + $Console, true);
				xmlhttp . send ();
	        }
			});
		});
	</script>

</html>