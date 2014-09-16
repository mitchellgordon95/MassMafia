<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Create An Account</title>
		<meta name="description" content="Sign up to play" />
		<meta name="author" content="Mitchell" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="icon" href="Media/favicon.ico" />
		<link rel="shortcut icon" href="Media/favicon.ico" />
		<link rel="apple-touch-icon" href="Media/favicon.ico" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<style>
			td {
				width: 50%;
			}
		</style>
		<script type="text/javascript">
			function validateForm() {
				//Get form object
				var form = document.forms["join"];
								
				//Remove everything but numbers from cell
				form["cell"].value = form["cell"].value.replace(/\D*/g, "");
				
				//Check cell length
				if(form["cell"].value.length != 10) {
					alert("Cell phone numbers should be 10 digits long");
					return false;
				}
				
				//Validate email
				if(form["email"].value.indexOf('@') == -1) {
					alert("Please enter a valid email address.");
					return false;
				}
				
				//Check if the emails match
				if(form["email"].value != form["emailConf"].value) {
					alert("Emails don't match.");
					return false;
				}
				
				//check for matching passwords
				if(!(form["pass"].value == form["passConf"].value)) {
					alert("Passwords don't match.");
					return false;
				}
				
				//Check image type
				var path = form["pic"].value;
				var ext = path.substr(path.length - 3, 3).toLowerCase();
				if (ext != "png" && ext != "jpg" && ext != "gif") {
					alert("Your picture uses an unsupported file type. Please select a png, jpg, or gif.");
					return false;
				}
				
				//Make sure all fields are filled out
				for (var i = 0; i < form.length; i++) {
					if (form.elements[i].value == "") {
						alert("Some fields are still not filled out.");
						return false;
					}
				}
			}
			
			function redirect() {
				document.body.innerHTML = "<div style='text-align:center'>Thank you for joining!<br>You'll be redirected to the login page.";
				window.setTimeout(function(){document.location.href="/login.php"}, 5000);
			}
		</script>
		
	</head>
	<div>
		<a href="index.php" class="indexlink">Mass Mafia</a>
		<div style="text-align:right; display:inline" class="right">
			<a href="schedule.php">Schedule</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="about.php">Rules</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<a href="login.php?logout=true">Logout</a>
		</div>
	</div>

	<body>
		<div style="text-align: center">
			<h1 style="	font-family: 'Impact', Charcoal, sans-serif">Create An Account</h1>
			<form action="join.php" method="post" name="join" id="form1" onsubmit="return validateForm()"  enctype="multipart/form-data">
				<table style="margin-left:auto; margin-right: auto;">
				<tr><td style="text-align: right">First Name:	</td><td style="text-align: left"><input type="text" name="first"/></td></tr>
				<tr><td style="text-align: right">Last Name:	</td><td style="text-align: left"><input type="text" name="last"/></td></tr>
				<tr><td style="text-align: right">Email: 		</td><td style="text-align: left"><input type="text" name="email"/></td></tr>
				<tr><td style="text-align: right">Confirm Email:</td><td style="text-align: left"><input type="text" name="emailConf"/></td></tr>
				<tr><td style="text-align: right">Cell Phone: </td><td style="text-align: left"><input type="text" name="cell"/></td></tr>
				<tr><td style="text-align: right">Password:   </td><td style="text-align: left"><input type="password" name="pass"/></td></tr>
				<tr><td style="text-align: right">Confirm Pass: </td><td style="text-align: left"><input type="password" name="passConf"/></td></tr>
				<tr><td style="text-align: right">First Period: </td><td style="text-align: left"><input type="text" name="1st"/></td></tr>
				<tr><td style="text-align: right">Eighth Period: </td><td style="text-align: left"><input type="text" name="8th"/></td></tr>
				<tr><td style="text-align: right">Current Club, Sport, or Work: </td><td style="text-align: left"><input type="text" name="club"/></td></tr>
				<tr><td style="text-align: right">Profile Pic: </td><td style="text-align: left"><input type="file" name="pic"/></td></tr>
				<tr><td style="text-align: right">(Face should be visible) </td></tr>
				<tr><td>I would not mind being the original zombie</td><td style="text-align: left"><input type="checkbox" name="zombie" value"yes"/></td></tr>
				<tr><td>Share my cell phone and email with other players</td><td style="text-align: left"><input type="checkbox" name="share" value"yes"/></td></tr>
				</table>
				<div style="width:50%; margin:auto; ">
					<p>*Only register using this form once. Also, this form only creates an account. You have to login and view a game in order to join that game.<br><br>
				**By joining this game, you are accepting all the rules found <a href="about.html">here</a>. Remember, nowhere is safe: your work, clubs,
				and home are all free game. When the zombies come for you, you have two options. You can stand there and take it like the piece of bait you are,
				OR you can forget about society and rules and fight like a real zombie hero. Your choice.
					</p>
				</div>	
				<input type="submit" name="join" value="Join" style="font-size: 20px;'Impact', Charcoal, sans-serif"/>
			</form>
		</div>
		<?php
			//Check that we actually have a picture
			if (!isset($_FILES["pic"]))
				die();
			
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

			//Connect to local SQL server, use massmafia database
			$con = mysqli_connect("massmafia.db.10210849.hostedresource.com", "massmafia", "hacktheplanet", "massmafia");
			
			//Make shortcuts for variables
			$first = mysqli_real_escape_string($con, $_POST["first"]);
			$last = mysqli_real_escape_string($con, $_POST["last"]);
			$email = strtolower(mysqli_real_escape_string($con, $_POST["email"]));
			$cell = mysqli_real_escape_string($con, $_POST["cell"]);
			$pass = mysqli_real_escape_string($con, $_POST["pass"]);
			$firstPeriod = mysqli_real_escape_string($con, $_POST["1st"]);
			$eighthPeriod = mysqli_real_escape_string($con, $_POST["8th"]);
			$club = mysqli_real_escape_string($con, $_POST["club"]);
			$zombie = (isset($_POST["zombie"]) ? 1 : 0);
			$share = (isset($_POST["share"]) ? 1 : 0);
			
			//Make sure email is unused.
			if (mysqli_num_rows(mysqli_query($con, "select * from users where email='" . $email . "'")) != 0) {
				die("<script type=\"text/javascript\"> alert(\"This email is already registered.\")</script>");	
			}
			
			//Find an unused ID
			$id = genId(25);
			while (mysqli_num_rows(mysqli_query($con, "select * from users where ID='" . $id . "'")) != 0) {
				$id = genId(25);
			}
			
			//Check file size and errors
			if ($_FILES["pic"]["size"] > 2000000) {
				die("<script type=\"text/javascript\"> alert(\"Sorry, your picture is too big. Please select another.\")</script>");
			}
			if ($_FILES["pic"]["error"] > 0) {
				echo $_FILES["pic"]["error"];	
				die("<script type=\"text/javascript\"> alert(\"Sorry, there were errors uploading your picture. Please try again.\")</script>");
			}
			if ($_FILES["pic"]["type"] == "applicaton/octet-stream") {
				die("<script type=\"text/javascript\"> alert(\"Sorry, there were errors uploading your picture. Please try again.\")</script>");
			}
			
			//Upload picture
			$exp = explode(".", $_FILES["pic"]["name"]);
			$ext = end($exp);
			$pic = $first . $last . "." . $ext;
			//Prevent duplicates
			while (file_exists("Headshots/" . $pic)) {
				$tmp = explode(".", $pic);
				$tmp[0] .= 1;
				$pic = $tmp[0] . "." . $ext;
			}
			
			include('SimpleImage.php');
			$image = new SimpleImage();
			
			//Resize the picture and upload it to headshots
			$image->load($_FILES["pic"]["tmp_name"]);
			if($image->getHeight() > 400) {
				$image->resizeToHeight(400);
			}
			$image->save("Headshots/" . $pic);
			
			//Resize the picture again and save it as a thumbnail
			$image->resizeToHeight(70);
			//Make the thumbnail name
			$exp = explode(".", $pic);
			$thumb = $exp[0] . "Thumb" . "." . $exp[1];
			//Save it
			$image->save("Headshots/" . $thumb);
			
			//Add user to users table
			$addUser = "insert into users values ('" . $id . "','" . $first . "','" . $last . "','" . $email . "','" . $cell . "','" . $pass . "','" . $firstPeriod . "','" . $eighthPeriod . "','" . $club . "','"
			 . $pic . "'," . $zombie . ", " . $share . ", '" . $thumb . "')";
			
		
			
			if (mysqli_query($con, $addUser)) {
				echo "<script type=\"text/javascript\"> redirect()</script>";
			}
			else {
				echo mysqli_error($con);
				die("<script type=\"text/javascript\"> alert(\"Sorry, there were errors creating your account. Please try again.\")</script>");
			}
		?>
	</body>
</html>
