<!DOCTYPE html>
<html lang="en">
		<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>About</title>
		<meta name="description" content="These are the rules." />
		<meta name="author" content="Mitchell" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="icon" href="Media/favicon.ico" />
		<link rel="shortcut icon" href="Media/favicon.ico" />
		<link rel="apple-touch-icon" href="Media/favicon.ico" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		
	</head>
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
	<div style="text-align: center">
		<h1>Rules</h1><br>
		<p>
			Mass Mafia is a real-life game played at Ravenwood High School. Only currently enrolled
			 <y>juniors and seniors</y> may join the game. We've played four games since 2011, with game rules 
			 evolving every time.
		</p>
		<h2 style="font-family: Arial, Helvetica, sans-serif;">Choose a game:</h2>
	</div>
	<body>
		<div>
			<div class="leftMiddle">
				<h2 style="font-family: Arial, Helvetica, sans-serif;"><a style="color:white;" href="zombiesRules.php">Zombies</a></h2>
				
			</div>
			<div class="rightMiddle">
				<h2 style="font-family: Arial, Helvetica, sans-serif;"><a style="color:white;" href="assassinsRules.php">Assassins</a></h2>
				
			</div>
	</body>
</html>
