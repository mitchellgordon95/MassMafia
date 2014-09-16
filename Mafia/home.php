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
	//Connects to database
	$con =  mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		die ("There seems to be an error with the database. Please try again later");
	}
	
	//Do global authentication
	if(isset($_COOKIE["id"])) {
		$id = $_COOKIE['id'];
		$user = mysqli_fetch_array(mysqli_query($con, "select * from users where id='" . $id . "'"), MYSQLI_BOTH);
		if (empty($user)) {
			header("location: login.php?logout=true");
			die();
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
	
	//Check game type
	$res = mysqli_query($con, "select type from schedule where Start='" . substr($game, 0, 4) . "-" . substr($game, 4, 2) . "-" . substr($game, 6, 2) . "'") or die("There seems to be a problem with the database. Please try again later.");
	$type = mysqli_fetch_array($res, MYSQLI_BOTH);
		
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
		<style>
			td, th {
				width: 33%;
			}
		</style>
		<script type="text/javascript">
		function imgHeight () {
			return screen.height / <?php echo ($type[0] == "Assassins") ? 3 : 10; ?>;	
		}
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
	<div style="text-align:center"><p>
	<?php
		if($login){
			die("Sorry, you need to <a href='login.php'>login</a> to view or join games.");	
		}
		
		//generates random id
		function genId ($len) {
			$chars = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		    $id = array(); 
		    $keyRange = strlen($chars) - 1; 
		    for ($i = 0; $i < $len; $i++) {
				$n = rand(0, $keyRange);
		        $id[$i] = $chars[$n];
			}	
			return implode($id); 
		}
		
		//Converts dates from (YYYYMMDD) to Month DD, YYYY
		function convertDate($date) {
			$date = str_replace("-", "", $date);
			$months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "November", "December");
			return $months[(int)substr($date, 4, 2)] . " " . substr($date, 6, 2) . ", " . substr($date, 0, 4);
		}
		
		if ($type[0] == "Zombies")
			include 'zombies.php';
		if ($type[0] == "Assassins")
			include 'assassins.php';
			
		check();
		
		if ($type[0] == "Zombies")
			echo "
	</p>
	</div>
	<div style=\"text-align: center\">
		<table style=\"margin: auto; width: 75%\">
			<thead>
				<th><h1>Humans</h1></th>
				<th><r><h1>Zombies</h1></r></th>
				<th><g><h1>Dead People</h1></g></th>
			</thead>";
		
		
		 show();
		
		
		?>
		</table>
	</div>
	</body>
</html>
