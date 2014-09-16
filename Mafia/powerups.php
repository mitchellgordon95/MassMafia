<!DOCTYPE html>
<html lang="en">
		<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>PowerUps</title>
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
	<div style="text-align: center"><h1>Power Ups</h1></div>
	<body>
		
		<h1>Zombie Power Ups</h1><br>
			<h1>Human Power Ups</h1>
		
	</body>
</html>
