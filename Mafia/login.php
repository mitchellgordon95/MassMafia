<?php
	//Check for logout signal
	if(isset($_GET["logout"])) {
		setcookie("id", "", time() - 3600, '/');
		header("location: index.php");
		die();
	}
	
	//Check for cookie
	if(isset($_COOKIE["id"])) {
		header("location: schedule.php");
		die();
	}
	
	$incorrect = false;
	$notFound= false;
	
	//Check for form submission
	if(isset($_POST["submit"])) {	
		//Connect to local SQL server, use massmafia database
		$con = mysqli_connect("massmafia.db.10210849.hostedresource.com", "massmafia", "hacktheplanet") or die("<script type=\"text/javascript\"> alert(\"Sorry, the database appears to be down. Please try again later.
			\")</script>");
		mysqli_query($con, "use massmafia") or die("<script type=\"text/javascript\"> alert(\"Sorry, the database appears to be down. Please try again later.\")</script>");
		
		//Escape email, grab row with email, check pass
		$email = strtolower(mysqli_real_escape_string($con, $_POST["email"]));
		
		$array = mysqli_query($con, "select pass, id from users where email='" . $email . "'")->fetch_array(MYSQLI_NUM);
		if ($array) {
			$pass = $array[0];
			$id = $array[1];
			if ($pass == $_POST["pass"]) {
				setcookie("id", $id, 0, '/');
				header("location: schedule.php");
				die();
			}
			else {
				$incorrect = true;
			}
		}
		else {
			$notFound = true;
		}
	} 
		
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />

	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
	Remove this if you use the .htaccess -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Login</title>
	<meta name="author" content="Mitchell" />

	<meta name="viewport" content="width=device-width; initial-scale=1.0" />

	<link rel="icon" href="Media/favicon.ico" />
	<link rel="shortcut icon" href="Media/favicon.ico" />
	<link rel="apple-touch-icon" href="Media/favicon.ico" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		 function createCookie(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
	    }
	
	    function readCookie(name) {
	        var nameEQ = name + "=";
	        var ca = document.cookie.split(';');
	        for (var i = 0; i < ca.length; i++) {
	            var c = ca[i];
	            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
	            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	        }
	        return null;
	    }
	
	    function eraseCookie(name) {
	        createCookie(name, "", -1);
	    }
	
	    function areCookiesEnabled() {
	        var r = false;
	        createCookie("testing", "Hello", 1);
	        if (readCookie("testing") != null) {
	            r = true;
	            eraseCookie("testing");
	        }
	        return r;
	    }
	    
	    if(areCookiesEnabled() == false) {
	    	alert("You don't have cookies enabled. You need to enable cookies to login.");
	    }
	</script>	
</head>
<div><a href="index.php" class="indexlink">Mass Mafia</a></div>
<body>
<div style="text-align: center">	
	<?php
		if($incorrect) {
			echo ("Incorrect password. Please try again.");
		}
		if($notFound) {
			echo ("That email isn't registered yet.");
		}
	?>
	<form action="login.php" method="post">
		Email: <input type="text" name="email"/></br>
		Pass:  <input type="password" name="pass"/></br>
		<input type="submit" value="Login" name="submit"/>
	</form>
	<p>Not registered? Join <a href='join.php'>here</a>.</p><br>
	<p>*We've been getting some complaints about problems logging in. Most of the time the problems are with Safari. If that's the case, you might want to try a different browser.</p>

</div>

<div style="text-align: center">
	
<br>
<!--Google Ads-->
	<script type="text/javascript">
	google_ad_client = "ca-pub-9155697290692471";
	/* login */
	google_ad_slot = "3140544696";
	google_ad_width = 728;
	google_ad_height = 90;
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

</div>
</body>
</html>
