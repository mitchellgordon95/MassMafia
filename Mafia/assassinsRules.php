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
	<div style="text-align: center"><h1>Assassins</h1></div>
	<body>
		<h1>Overview</h1>
		<p>
			Assassins is played in teams of five or less. The goal is to be the last team standing. Each team receives a target team, which they try to "assassinate," using nerf weapons, socks, etc.
			When a team assassinates all their targets, their entire team is revived, and they receive a new target list.
		</p>
		<h1>Objectives</h1>
		<p>
			&bull; Assassinate your target team.<br>
			&bull; Try not to be killed by whoever's targeting you.
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
		<h1>Gameplay Rules</h1>
		<p>	
			&bull; <y>Wearing a Bandana:</y> players who are alive must wear a bandana around their arm or leg at all times (except for school hours). Not doing so is grounds for immediate death.<br>
			&bull; <y>Making Assassinations:</y> you may only assassinate the people on your target list. You can do this by: shooting them with a nerf weapon, spraying them with silly string,
				or hitting them with rolled up socks (if you're in the school building). For a bonus kill point, sneak up behind them, tap them on the chin, and say "neck snap."	You must then take their ID card, 
				which will allow you to log your kill on the website. You do this on the page where you view your target.<br>
			&bull; <y>Getting Assassinated:</y> if you are assassinated by someone else, you must give them your ID card. If revived, you will receive a new ID. If you notice someone trying to assassinate you, you may
				stun them by using any of the methods mentioned above, except for the neck snap. They will be unable to attack you or anyone else for five minutes (see also Club Clause and Athlete Clause below).<br>
			&bull; <y>Getting a New Target List:</y> if you eliminate all the players on your target list, your entire team will be revived. You will then inherit your target's targets. 
					
			  
		</p>
		<h1>Other Rules</h1>
		<p>	
			&bull; <y>NO NERF GUNS IN THE SCHOOL BUILDING.</y> You will be banned/publicly humiliated.<br>
			&bull; <y>Settling Ties</y> In the event of a tie (players shooting/stabbing each other at the same time), use the same logic that would apply if the weapons were real. In other words, both hits count.
				The attacker is stunned, but the defender is killed.<br>
			&bull; <y>The MVP Clause:</y> Any player that logs 5 kills will receive a one-time use revival card.<br>
			&bull; <y>The Athlete Clause:</y> Athletes that are attacked during practice/games can stun their attackers by
				hitting them with the object of play (ball, frisbee, hockey puck, etc.)<br>
			&bull; <y>The Club Clause:</y> If an assassin attacks someone participating in an event, such as work or sporting event,
				and gets stunned, that assassin cannot attack the person again while the event is still in session. <br>
			&bull; <y>Non-players</y> should not interact with the game. However, multiple rounds will be
				played, so recruiting is encouraged for future rounds.
		</p>
	</body>
</html>
