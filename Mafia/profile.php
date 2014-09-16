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
	$game;
	$login = false;
	//End Globals
	
	//Connects to database
	$con =  mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		die ("There seems to be an error with the database. Please try again later");
	}
	
	//Do global authentication
	if(isset($_COOKIE["id"])) {
		$id = $_COOKIE['id'];
		$user = mysqli_fetch_array(mysqli_query($con, "select * from users where id='" . $id . "'"), MYSQLI_BOTH) or die("There seems to be a problem with the database. Please try again later.");
		if($user[0] == "") {
			header("location:login.php?logout=true");
		}
	}
	else {
		$login = true;	
	}
	
	//Validate game input
	if (isset($_GET['game'])) {
		$game = mysqli_real_escape_string($con, $_GET['game']);
		if(strlen($game) != 8 || !is_numeric($game)) {
			header("location: schedule.php");  
		}
	}
	else {
		header('location: schedule.php');	
	} 
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Mass Mafia</title>
		<meta name="description" content="Mass Mafia Welcome Page" />
		<meta name="author" content="Mitchell" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="icon" href="Media/favicon.ico" />
		<link rel="shortcut icon" href="Media/favicon.ico" />
		<link rel="apple-touch-icon" href="Media/favicon.ico" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			//Resize title to screen size.
			function doResize() {
				document.getElementById("pic").height = window.innerHeight * 0.4;
			}
			window.onload = doResize;
			window.onresize = doResize;
		</script>
	</head>
	<body>
	<div>
		<a href="index.php" class="indexlink">Mass Mafia</a>
		<div style="text-align:right; display:inline" class="right">
			<a href="schedule.php">Schedule</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="about.php">Rules</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="login.php?logout=true">Logout</a>
		</div>
	</div>
	<div style="text-align:center">
	<?php
		//Check for not logged in flag
		if ($login) {
			die("Sorry, you need to <a href='/login.php'>login</a> to see this page.");	
		}		
		//Get the profile's data from users table
		if (isset($_GET['first'])) {
			$first = mysqli_real_escape_string($con, $_GET["first"]);
			$last = mysqli_real_escape_string($con, $_GET["last"]);
			$res = mysqli_query($con, "select * from users left join _" . $game . " on users.id=_" . $game . ".id where users.first='" . $first . "' and users.last='" . $last . "'") or die("There seems to be a problem with our database. Please try again later.");
			while ($profile = mysqli_fetch_array($res, MYSQLI_BOTH)) {
				echo "<img id='pic' src='Headshots/" . $profile['Pic'] . "'/><br>";
				echo "<p>";
				echo "Name: " . $profile['First'] . " " . $profile['Last'] . "<br>";
				if(isset($profile['Status'])) {
					$actual;
					switch ($profile['Status']) {
						case 1: 
							$actual = "Human";
							break;
						case 0:
							$actual = "<r>Zombie</r>";
							break;
						case -1:
							$actual = "<g>Dead</g>";
							break;
					}
					echo "Status: " . $actual . "<br>";
					echo "Kills: " . $profile['Kills'] . "<br>";
				}
				if($profile["Share"] == 1) {
					echo "Email: " . $profile['Email'] . "<br>";
					echo "Cell phone: " . $profile['Cell'] . "<br>";
				}
				echo "First Period: " . $profile['FirstPeriod'] . "<br>";
				echo "Eighth Period: " . $profile['EighthPeriod'] . "<br>";
				echo "Club, Sport, or Work: " . $profile['Club'] . "<br>";
				echo "</p>";
			}			
		}
		else {
			echo "Sorry, this person does not exist.";
		}
	?>
	<a href="home.php?game=<?php echo $game;?>">Back</a>
	</div>
	</body>
</html>
