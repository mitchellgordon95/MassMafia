<?php
	//Globals
	static $host = 'massmafia.db.10210849.hostedresource.com';
	static $user = 'massmafia';
	static $pass = 'hacktheplanet';
	static $db = 'massmafia';
	static $userTable = 'users';
	$id;
	$user;
	$con;
	
	//Connects to database
	$con =  mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		die ("There seems to be an error with the database. Please try again later");
	}
	
	//Converts dates from (YYYYMMDD) to Month DD, YYYY
	function convertDate($date) {
		$date = str_replace("-", "", $date);
		$months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "November", "December");
		return $months[(int)substr($date, 4, 2)] . " " . substr($date, 6, 2) . ", " . substr($date, 0, 4);
	}
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Schedule</title>
		<meta name="description" content="Mass Mafia Welcome Page" />
		<meta name="author" content="Mitchell" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="icon" href="Media/favicon.ico" />
		<link rel="shortcut icon" href="Media/favicon.ico" />
		<link rel="apple-touch-icon" href="Media/favicon.ico" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<style>
			td, th {
				width: 33%;
			}
		</style>
		<script type="text/javascript">
		function imgHeight () {
			return screen.height / 10;	
		}
		</script>
	</head>
	<body>
	<div>
		<a href="index.php" class="indexlink">Mass Mafia</a>
		<div style="text-align:right; display:inline" class="right">
			<a href="schedule.php">Schedule</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="about.php">Rules</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<?php 
			if(isset($_COOKIE["id"])) {
				echo "<a href='login.php?logout=true'>Logout</a>";
			}
			else {
				echo "<a href='login.php'>Login</a>";	
			}	
			?>
		</div>
	</div>
	<div style="text-align:center">
		<h1 style="	font-family: 'Impact', Charcoal, sans-serif">Game Schedule</h1>
		<p>
			Here you can find an index of Mass Mafia games: past, present, and future.<br>
			To join a game that hasn't started yet, simply click "view" next to that game.<br>
			You will be asked if you want to signup, and then you will be able to see other players in that game<br>
		</p>
	</div>
	<div style="font-family: Arial, Helvetica, sans-serif; text-align: center">
		<table style='margin: auto'> 
			<thead>
				<th>Start Date</th>
				<th>Type</th>
				<th></th>
			</thead>
			<?php
				$res = mysqli_query($con, "select * from schedule order by Start") or die("There's a problem with the database. Please try again later.");
				while ($game = mysqli_fetch_array($res, MYSQLI_BOTH)) {
					echo "<tr>";	
					echo "<td>" . convertDate($game['Start']) . "</td>";
					echo "<td>" . $game['Type'] . "</td>";
					echo "<td><a href='home.php?game=" . str_replace("-", "", $game['Start']) . "'>View</a></td>";
					echo "</tr>";
				}
			?>	
		</table>
	</div>
	</body>
</html>
