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
	<div style="text-align: center"><h1>Zombies</h1></div>
	<body>
		<p>
			 This is Humans vs. Zombies; game rules are taken from the official Humans vs. Zombies <a href="http://humansvszombies.org/rules">website</a> with a 
			 <y>few adjustments</y>.			
		</p>
		<h1>Overview</h1>
		<p>
			Humans vs. Zombies is a game of tag. All players begin as humans, except for the randomly selected
			"Original Zombie." Zombies try to infect humans by tagging them; if a zombie fails to infect a
			human for <y>48 hours</y>, it starves to death and is out of the game.
		</p>
		<h1>Objectives</h1>
		<p>
			&bull; Humans try to survive long enough for all the zombies to starve.<br>
			&bull; Zombies try to eat all the humans.
		</p>
		<h1>Required Equipment</h1>
		<p>
			All players must have:<br>
			<img src="Media/equip.png"/><br>
			&bull; A bandana (If you do not own one, they can be purchased from the <a href="/admin.html"> admin </a> for $1.50 at school)<br>
			&bull; A nerfgun or nerfsword<br>
			&bull; Because no toy guns are allowed in the school building, rolled up socks or silly string may be used as a substitute.<br>
			&bull; A notecard			
		</p>
		<h1>Safe Zones</h1>
		<p>
			&bull; <y>Classrooms</y> are safe all day until the final bell.<br>
			&bull; <y>School grounds</y>(meaning the entire building and parking lot) are safe between between the final bell in the morning and the last bell 
				in the afternoon.<br>
			&bull; Otherwise, everything else is game, including clubs, work, and home.			
		</p>
		<h1>Human Rules</h1><br>
		<img src="Media/human.png"/>
		<p>	
			&bull; <y>ID Card:</y> humans must write their unique ID number (recieved upon sign-up) on their
				notecard and keep it with them at all times.<br>
			&bull; <y>Stunning Zombies:</y> humans can stun zombies for 5 minutes by shooting them with a nerf
				gun or hitting them with folded up socks.<br>
			&bull; <y>Wearing the Bandana:</y> humans must wear a bandana on their arm or leg to be identified
				as a player of the game, except during school hours.<br>
			&bull; <y>Becoming a Zombie:</y> when tagged, the human must give his/her ID card to the zombie.
				After 5 minutes, they can tie the bandana around their head and start playing as a zombie.<br>
		</p>
		<h1>Zombie Rules</h1><br>
		<img src="Media/zombie.png"/>
		<p>	
			&bull; <y>Feeding:</y> zombies must tag a player every 48 hours, or else they will starve to death
				and be eliminated from the game.<br>
			&bull; <y>Wearing a Headband:</y> zombies must wear a bandana around their head at all times, except during school hours.
				The Original Zombie does not have to wear a headband on the first two days of play.<br>
			&bull; <y>Tagging:</y> A tag is a firm touch to any part of the Human. Upon tagging, the zombie 
				should take the human's ID card and report the tag on the website. <br> 
			&bull; <y>Getting Shot:</y> zombies that get hit with a dart or a sock will be stunned for 5
				minutes. During this time, the zombie is not allowed to interact with the game in any way,
				including acting as a shield for other zombies. If a zombie is shot again while stunned, the
				clock restarts.<br>  
		</p>
		<h1>Other Rules</h1>
		<p>	
			&bull; <y>NO NERF GUNS IN THE SCHOOL BUILDING.</y> You will be banned/publicly humiliated.<br>
			&bull; <y>Powerups:</y> powerup objects (immunity bandanas, super stun guns, etc.) will be periodically left
				in obscure places throughout the school. The abilities of these objects and hints about their locations
				will be announced a day before they come into play. You can read about released powerups <a href="powerups.php">here</a>. <br>
			&bull; Humans can stun zombies while standing in safe zones. Conversely, zombies must have both
				feet outside of the safe zone in order to tag a human.<br>
			&bull; <y>The Athlete Clause:</y> Athletes that are attacked during practice/games can stun zombies by
				hitting them with the object of play (ball, frisbee, hockey puck, etc.)<br>
			&bull; <y>The Club Clause:</y> If a zombie attacks someone participating in an event, such as work or sporting event,
				and gets stunned, that zombie cannot attack the person again while the event is still in session. <br>
			&bull; Zombies <y>do not ration food</y>. If you make multiple kills in one day, you MUST report them all.<br>
			&bull; <y>Non-players</y> should not interact with the game. However, multiple rounds will be
				played, so recruiting is encouraged for future rounds.
		</p>
	</body>
</html>
