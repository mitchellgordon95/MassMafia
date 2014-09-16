<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Admin Page</title>
		<meta name="description" content="Control" />
		<meta name="author" content="Mitchell" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="icon" href="Media/favicon.ico" />
		<link rel="shortcut icon" href="Media/favicon.ico" />
		<link rel="apple-touch-icon" href="Media/favicon.ico" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		
	</head>
	<div><a href="index.php" class="indexlink">Mass Mafia</a></div>
	<?php
		//Do authentication
		if (isset($_POST["pass"])){
			if($_POST["pass"] == "hacktheplanet") {	}
			else {exit("<form action='admin.php' method='POST'><input type='password' name='pass'><input type='submit'>");}
		}
		else {exit("<form action='admin.php' method='POST'><input type='password' name='pass'><input type='submit'>");}
	?>
	<body>
		<form action="admin.php" method="post" onsubmit="return confirm('Are you sure?');">
			<input type="hidden" name="pass" value="hacktheplanet"/>
			<input type="submit" value="Initiate Server" name="initServer"/><br>
			<input type="text" name="date" value="YYYYMMDD"/><input type="submit" value="Schedule Zombies" name="scheduleZombies"/><input type="submit" value="Schedule Assassins" name="scheduleAssassins"/><br>
			<input type="submit" value="End Game" name="endGame"/><br>
			<input type="submit" value="Start Game" name="startGame"/><br>
			<input type="submit" value="New Day" name="newDay"/>
		</form>
	<?php
		//Globals
		static $host = 'massmafia.db.10210849.hostedresource.com';
		static $user = 'massmafia';
		static $pass = 'hacktheplanet';
		static $db = 'massmafia';
		static $userTable = 'users';

		//Connects to database
		function dbConnect () {
			global $host, $user, $pass;
			$con =  mysqli_connect($host, $user, $pass);
			if (!$con) {
				echo "Error: " . mysqli_error();
			}
			else {
				return $con;
			}
		}
		
		/*
		 * Initiates the server by creating a database using the static database name
		 * and creating a users table.
		 * @param con a mysqli connection from mysqli_connect()
		 */
		function initiateServer ($con) {
			global $db, $userTable, $host;
			//Query steps
			$createDatabase = "create database " . $db;
			$createTable = "create table " . $userTable . "
							 (
							 ID text,
							 First varchar(20),
							 Last varchar(20),
							 Email varchar(30),
							 Cell char(10),
							 Pass varchar(30),
							 FirstPeriod varchar(20),
							 EighthPeriod varchar(20),
							 Club tinytext,
							 Pic tinytext,
							 Original tinyint,
							 Share tinyint,
							 Thumb tinytext,
							 PRIMARY KEY (email) 
							 )";
				if (mysqli_query($con, $createDatabase)) {
					echo "Created database " . $db . "<br>";
				}
				else {
					 echo "Error:" . mysqli_error($con) . "<br>";
				}
				mysqli_query($con, "USE ". $db);
				if (mysqli_query($con, $createTable)) {
					echo "Created table " . $userTable . "<br>";
				}
				else {
					echo "Error:" . mysqli_error($con) . "<br>";
				}		 
		}
		
		function endGame ($con) {
			global $db;
			mysqli_query($con, "use " . $db) or die("Error: database does not exist.");
			//Check if any games in progress
			$res = mysqli_query($con, "select * from schedule where Status = 1");
			if ($res) {
				$arr = mysqli_fetch_array($res);
			}
			else {
				die ("Error: " . mysqli_error($con) . "<br>");	
			}
			if($arr[0] == "") {
				die("No game in progress.");
			}
			
			//Set old game as terminated from schedule
			if (mysqli_query($con, "update schedule set Status=2 where Status=1")) {
				echo "Set old game as terminated.<br>";
			}
			else {
				echo ("Error: " . mysqli_error($con) . "<br>");
			}
		
		}
		
		function startGame ($con) {
			global $db;
			mysqli_query($con, "use " . $db) or die("Error: database does not exist.");
			//Check for games being signed up for.
			$dates = mysqli_query($con, "select Start, Type from schedule where Status=0 order by Start")->fetch_array() or die("No games currently being signed up for.<br>");
			//Stop signup and start game
			if (mysqli_query($con, "update schedule set Status=1  where Start='" . $dates[0] . "'")) {
				echo "Stopping sign up and setting game as 'In Progress' for the game on " . $dates[0] . "<br>";
			}
			else {
				die ("Error: " . mysqli_error($con) . "<br>");
			}
			
			if ($dates[1] == "Assassins") {
				echo "Assassins game detected. Randomizing team assignments.<br>";
				
				//Strip the dashes from the date (YYYY-MM-DD) -> (YYYYMMDD)
				$dates[0] = str_replace("-", "", $dates[0]);
				
				//Read all the current teams from the roster into the teams variable
				$teams = array();
				$res = mysqli_query($con, "select Team from _" . $dates[0] . "_roster") or die("Error: could not get team names.<br>");
				for($i = 0; $team = $res->fetch_array(); $i++) {
					$teams[$i] = $team[0];
				}
				
				//Get a random number
				$rand = rand(1, count($teams) - 1);
				
				//Put the teams array into a target array, shifting by the random number
				$targets = array();
				for ($i = 0; $i < count($teams); $i++) {
						$targets[$i] = $teams[($i + $rand) % count($teams)];
				} 
				
				//Put the target array into the database
				for ($i = 0; $i < count($teams); $i++) {
					mysqli_query($con, "update _" . $dates[0] . "_roster set Target='" . $targets[$i] . "' where Team='" . $teams[$i] . "'") or die("Error: could not put targets into database.<br>");
				}				
			}	
		}
		
		function scheduleZombies ($con) {
			global $db;
			mysqli_query($con, "use " . $db) or die("Error: database does not exist.");
			//Create table, if not already created
			if (mysqli_query($con, "create table schedule (Start date, Status tinyint, Type text, PRIMARY KEY (Start))")) {
				echo "Created schedule table<br>";
			}
			else {
				echo ("Error: " . mysqli_error($con) . "<br>");
			}
			//Check that we actually have a date
			if(!isset($_POST["date"])) {
				die("Error: No date given.");
			}
			//Create a table for this game, named by its start date
			if(mysqli_query($con, "create table _" . $_POST["date"] . " (ID char(25), Status tinyint, idCard char(7), daysLeft tinyint, Kills tinyint, PRIMARY KEY (ID))")) {
				echo "Created game table.<br>";
			}
			else {
				echo "Error: " . mysqli_error($con) . "<br>";
			}
			//Schedule the game
			if (mysqli_query($con, "insert into schedule values('" . $_POST["date"] . "'," . " 0, 'Zombies')")) {
				echo "Scheduled game.<br>";
			}
			else {
				die ("Error: " . mysqli_error($con) . "<br>");
			}
			
			
		}

		function scheduleAssassins($con) {
			global $db;
			mysqli_query($con, "use " . $db) or die("Error: database does not exist.");
			//Create table, if not already created
			if (mysqli_query($con, "create table schedule (Start date, Status tinyint, Type text, PRIMARY KEY (Start))")) {
				echo "Created schedule table<br>";
			}
			else {
				echo ("Error: " . mysqli_error($con) . "<br>");
			}
			//Check that we actually have a date
			if(!isset($_POST["date"])) {
				die("Error: No date given.");
			}
			//Create a table for this game, named by its start date
			if(mysqli_query($con, "create table _" . $_POST["date"] . " (ID char(25), Status tinyint, idCard char(7), Kills tinyint, Team varchar(255), Pass text, PRIMARY KEY (ID))")) {
				echo "Created game table.<br>";
			}
			else {
				echo "Error: " . mysqli_error($con) . "<br>";
			}
			
			//Create a roster for this game
			if(mysqli_query($con, "create table _" . $_POST["date"] . "_roster (Team varchar(255), Target text, PRIMARY KEY (Team))")) {
				echo "Created game roster.<br>";
			}
			else {
				echo "Error: " . mysqli_error($con) . "<br>";
			}
			
			//Schedule the game
			if (mysqli_query($con, "insert into schedule values('" . $_POST["date"] . "'," . " 0, 'Assassins')")) {
				echo "Scheduled game.<br>";
			}
			else {
				die ("Error: " . mysqli_error($con) . "<br>");
			}
			
			
		}

		//New day
		function newDay($con) {
			global $db;
			mysqli_query($con, "use " . $db) or die("Error: database does not exist.");
			//Get the current game
			$dates = mysqli_query($con, "select Start from schedule where Status=1 order by Start")->fetch_array() or die("No games currently in progress.<br>");
			//strip hyphens
			$dates[0] = str_replace("-", "", $dates[0]);
			//Decrement days left where people are zombies
			mysqli_query($con, "update _" . $dates[0] . " set daysLeft=daysLeft - 1 where status=0") or die("Error: " . mysqli_error($con));
			echo("Decremented daysLeft on all zombies.<br>");
			//Kill people who have no days left
			mysqli_query($con, "update _" . $dates[0] . " set status=-1 where daysLeft<1") or die("Error: " . mysqli_error($con));
			echo("Killed all zombies with no days left to live.<br>");
		}
		//Check which button was pressed
		if(isset($_POST["initServer"])) {
			initiateServer(dbConnect());
		}
		if(isset($_POST["endGame"])) {
			endGame(dbConnect());
		}
		if(isset($_POST["scheduleZombies"])) {
			scheduleZombies(dbConnect());
		}	
		if(isset($_POST["scheduleAssassins"])) {
			scheduleAssassins(dbConnect());
		}	
		if(isset($_POST["startGame"])) {
			startGame(dbConnect());
		}
		if(isset($_POST["newDay"])) {
			newDay(dbConnect());
		}
	?> 
	</body>
</html>
