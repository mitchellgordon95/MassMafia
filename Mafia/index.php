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
				document.getElementById("title").height = window.innerHeight * 0.7;
				document.getElementById("title").width = document.getElementById("title").height;
			}
			window.onload = doResize;
			window.onresize = doResize;
		</script>
	</head>

	<body>
			<header style="text-align: center">
				<img src="Media/StandardTitleSmall.jpg" width="500" height="500" id="title"><br>
				<audio controls>
					<source src="Media/Theme.ogg" type="audio/ogg">
					<source src="Media/Theme.mp3" type="audio/mp3">
					Your browser doesn't support this audio. Sorry.
				</audio><br>
				Current Population: <?php $sql = new mysqli("massmafia.db.10210849.hostedresource.com", "massmafia", "hacktheplanet", "massmafia"); $res = $sql->query("select * from users"); echo $res->num_rows?><br>			
			</header>
			
			<br>
			<div>
				<div class="left"><a href="about.php" class="indexlink">About</a></div>
				<div class="center"><a href="login.php" class="indexlink">Login</a></div>
				<div class="right"><a href="join.php" class="indexlink">Join</a></div>
			</div>
		
	</body>
</html>
