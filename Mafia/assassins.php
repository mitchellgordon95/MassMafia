<?php

function check() {
//Do game check

		//Get globals from calling page
		global $id, $game, $con, $user;
		//Check if user id is in game table
		$res =  mysqli_query($con, "select * from _" . $game . " where id='" . $id . "'") or die("There seems to be a problem with the database. Please try again later.");
		$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
		$status = $arr[1];
		$user['idCard'] = $arr[2];
		$user['Kills'] = $arr[3];
		$user['Team'] = $arr[4];
	
		//Check if the game has started
		$res = mysqli_query($con, "select status from schedule where Start='" . substr($game, 0, 4) . "-" . substr($game, 4, 2) . "-" . substr($game, 6, 2) . "'") or die("There seems to be a problem with the database. Please try again later.");
		$hasStarted = mysqli_fetch_array($res, MYSQLI_BOTH);
			
		//Check if user is signed up
		if($status == "") {
			//Check if the game has started
			if ($hasStarted[0] == 0) {
				//If it hasn't started, check if they already clicked the button.
				if (isset($_GET['signup'])) {
					//Trying to sign up. Check if they're creating or joining
					if(isset($_GET['create'])) {
						//They're creating.
						
						//parse team and pass
						$team = mysqli_real_escape_string($con, $_GET['team']);
						$pass = mysqli_real_escape_string($con, $_GET['pass']);
						
						//Find an unused ID
						$idCard = genId(7);
						while (mysqli_num_rows(mysqli_query($con, "select * from _" . $game . " where idCard='" . $idCard . "'")) != 0) {
							$idCard = genId(7);
						}
						
						//Make sure the name isn't taken
						if (mysqli_num_rows(mysqli_query($con, "select * from _" . $game . " where Team='" . $team . "'")) != 0) {								
							die ("Sorry, that team name is taken. Please try again. <script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");						
						}
						
						//Add the team name to roster
						mysqli_query($con, "insert into _" . $game . "_roster values('" . $team . "', 'none')") or die("There seems to be a problem with the database. Pleas try again later. 
						<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");	
						
						//Add them to the game table
						if(mysqli_query($con, "insert into _" . $game . " values('" . $id . "', 1, '" . $idCard . "', 0, '" . $team . "', '" . $pass . "')")) {
							die ("You've been added to the game. Your ID is <y>" . $idCard . "</y>. Write this down on your notecard now. If ressurected, you will receive a new ID. Click <a href='home.php?game=" . $game . "'>here</a> to continue to the game's page.");
						}
						else {
							die ("There's something wrong with the database. Please try again later.");	
						}
					}
					
					else {
					//Joining
						//Parse team and password
						$team = mysqli_real_escape_string($con, $_GET['team']);
						$pass = mysqli_real_escape_string($con, $_GET['pass']);
						//Check password
						$realPass = mysqli_fetch_array(mysqli_query($con, "select pass from _" . $game . " where Team='" . $team . "'"), MYSQLI_BOTH); 
						if ($realPass[0] != $pass) {
							die ("Sorry, that password is incorrect. Please try again. <script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");
						}
						
						//Find an unused ID
						$idCard = genId(7);
						while (mysqli_num_rows(mysqli_query($con, "select * from _" . $game . " where idCard='" . $idCard . "'")) != 0) {
							$idCard = genId(7);
						}
						
						if (mysqli_query($con, "insert into _" . $game . " values('" . $id . "', 1, '" . $idCard . "', 0, '" . $team . "', '" . $pass . "')")) {
							die ("You've been added to the game. Your ID is <y>" . $idCard . "</y>. Write this down on your notecard now. If you are ressurected, you will receive a new ID. Click <a href='home.php?game=" . $game . "'>here</a> to continue to the game's page.");
						}
						else {
							die ("There's something wrong with the database. Please try again later.");	
						}
					}
				}
				
				//If they haven't clicked the button, show them their options
				else {
					//Get the different team names
					$res = mysqli_query($con, "select Team from _" . $game . "_roster");
					$teamOptions = "";
				 	while ($team = mysqli_fetch_array($res, MYSQLI_NUM)) {
						$teamOptions .= "<option value=\"" . $team[0] . "\">" . $team[0] . "</option>";
					}
					
					die ("You aren't signed up for the game scheduled to start on " . convertDate($game) . ". You may either:
						<div>
							<div class=\"leftMiddle\">
								<h2 style=\"font-family: Arial, Helvetica, sans-serif;\">Join a Team</h2>
								<form method=\"get\">
									Team: <select name=\"team\">" . $teamOptions . "</select><br>
									Pass: <input type=\"password\" name=\"pass\"></input>
									<input type=\"hidden\" name=\"signup\" value=\"true\"><br>
									<input type=\"hidden\" name=\"game\" value=\"" . $game . "\">
									<input type=\"submit\" name=\"join\" value=\"Join\">
								</form>
							</div>
							<div class=\"rightMiddle\">
								<h2 style=\"font-family: Arial, Helvetica, sans-serif;\">Create a Team</h2>
								<form method=\"get\" action=\"home.php\">
									Team Name: <input type=\"text\" name=\"team\"></input><br>
									Pass: <input type=\"text\" name=\"pass\"></input><br>
									(Share this password with your teammates to let them join your team)
									<input type=\"hidden\" name=\"signup\" value=\"true\"><br>
									<input type=\"hidden\" name=\"game\" value=\"" . $game . "\">
									<input type=\"submit\" name=\"create\" value=\"Create\">								
								</form>
						</div>	
					
						<br>");
				}
			}
			//If the game has started, tell them the bad news
			die ("Sorry, the game has already started. Please check the <a href='schedule.php'>schedule</a> for the other games.");
		}

		//If they are signed up, print their status and, for humans, id cards.
		$actualStatus;
		switch ($status) {
			case -1:
				$actualStatus = "a dead person. Sorry.";
				break;
			case 0:
				$actualStatus = "rogue agent. Kill freely. ;)";
				break;
			case 1:				
				$actualStatus = "alive. Your id is " . $user['idCard'] . '. Good luck.';
				break;
			default:
			$actualStatus = "dead person";
		}
		if(!isset($_POST["idCard"])) {
			echo "This is the game that starts/started on " . convertDate($game) . ".<br> If you have any problems, please contact the <a href='admin.html'>admin</a>. <br><br>You are " . $actualStatus . "<br>";	
		}
		
		if (($status == 1 or $status == 0) and $hasStarted[0] == 1) {
			//Check if they've already submitted this form. If they have, kill that person.
			if (isset($_POST['idCard'])) {
				$idCard = mysqli_real_escape_string($con, $_POST['idCard']);
				
				//Make sure that idCard is actually a player
				$res = mysqli_query($con, "select * from _" . $game . " where idCard='" . $idCard . "' and status=1") or die("There seems to be a problem with the database. Please try again later.");
				$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
				if($arr[0] == "") {
					die("Sorry, that person is either dead or non-existant. Try re-entering the code? <script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");
				}
				
				//Find the team of the target
				$arr = mysqli_fetch_array(mysqli_query($con, "select team from _" . $game . " where idCard='" . $idCard . "'"));
				$team = $arr[0];							
				
				//Find the user's target team
				$arr = mysqli_fetch_array(mysqli_query($con, "select target from _" . $game . "_roster where Team='" . $user['Team'] . "'"));
				$target = $arr[0];			
				
				//Make sure the target team and the team of the person being killed match
				if ($target != $team) {
					die("Sorry, that person is not one of your targets. Try re-entering the code? <script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");				
				}	
				
				//Kill the player
				mysqli_query($con, "update _" . $game . " set status=-1 where idCard='" . $idCard . "'") or die("There seems to be a problem with the database. Please try again later. 
				<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");
				
				//Give the user another kill
				mysqli_query($con, "update _" . $game . " set kills=kills+1 where id='" . $id . "'") or die("We zombified the player, and gave you more days to live, but we couldn't increase your kill count.
				 Please see the admin to fix this.<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php\"}, 4000);</script>");
				
				//Check if that entire team is dead
				if (mysqli_num_rows(mysqli_query($con, "select * from _" . $game . " where Team='" . $team . "' and Status=1")) == 0) {
					//The entire team is dead. Get the target team's target
					$arr = mysqli_fetch_array(mysqli_query($con, "select Target from _" . $game . "_roster where Team='" . $target . "'"), MYSQLI_BOTH);
					$newTarget = $arr[0]; 
					
					//Set their new target as the user team's target
					mysqli_query($con, "update _" . $game . "_roster set Target='" . $newTarget . "' where Team='" . $user['Team'] . "'") or die("There was a problem eliminating your target team. Please notify an admin.");
					
					//Delete the eliminated team from the roster
					mysqli_query($con, "delete from _" . $game . "_roster where Team='" . $team . "'") or die("There was a problem eliminating your target team. Please notify an admin.");
					
					//Give all dead players a new ID					
					//Get dead players on user team
					$res = mysqli_query($con, "select ID from _20130408 where Status=-1 and Team='" . $user['Team'] . "'") or die("There's a problem reviving your team. Please notify an admin.");
					
					//Cycle through dead players
					while ($player = mysqli_fetch_array($res, MYSQLI_BOTH)) {
												
						//Find an unused ID
						$idCard = genId(7);
						while (mysqli_num_rows(mysqli_query($con, "select * from _" . $game . " where idCard='" . $idCard . "'")) != 0) {
								$idCard = genId(7);
						}
					
						//Set that as the player's new ID
						mysqli_query($con, "update _20130408 set idCard='" . $idCard . "' where ID='" . $player[0] . "'") or die("There's a problem reviving your team. Please notify an admin.");
					
					}
					
					//Revive user's team
					mysqli_query($con, "update _" . $game . " set status=1 where Team='" . $user['Team'] . "'") or die("There was a problem eliminating your target team. Please notify an admin.");
					echo "You have eliminated team " . $team . " completely. Your team will be revived.<br>";
				}
				 
				
				die ("Nice job. Your kill count has been updated. <script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script><br>");
			}
			//If the game has started, let people kill target
			if($hasStarted) {
				echo("Was the assassination succesful? Put your target's ID here: <form action='home.php?game=". $game . "' method='post'><input type='text' name='idCard'/><br><input type='submit'></form><br>");
			}
	}
}   

		function show() {
				global $game, $user, $con;
							
				//Check if the game is over
				$res = mysqli_query($con, "select status from schedule where Start='" . substr($game, 0, 4) . "-" . substr($game, 4, 2) . "-" . substr($game, 6, 2) . "'") or die("There seems to be a problem with the database. Please try again later.");
				$hasFinished = mysqli_fetch_array($res, MYSQLI_BOTH);
				
				//If the game is over, show the winning team
				if ($hasFinished[0] == 2) {
					//Find winning team (Anyone in table left alive)
					$arr = mysqli_fetch_array(mysqli_query($con, "select Team from _" . $game . " where Status=1"));
					$winners = $arr[0];				
					
					//Print all target team members
					echo "<h2 style=\"font-family: Arial, Helvetica, sans-serif;\">WINNERS: " . $winners . "</h2><br>";
											
					//Get all team members
					$res = mysqli_query($con, "select First, Last, Pic, Kills, Thumb, Status from _" . $game . " inner join users on _" . $game . ".id=users.id where Team='" . $winners . "' order by First") or die("There seems to be an error in our database. Please try again later.");
					
					echo "<div style=\"text-align: center\">
							<table style=\"margin: auto; width: 75%; table-layout: fixed;\"><tr>";
					//Print all target members to screen
					while ($member = mysqli_fetch_array($res, MYSQLI_BOTH)) {
						$color = ($member['Status'] == 1) ? "" : "<r>";
						$endColor = ($member['Status'] == 1) ? "" : "</r>";
	 
						echo "<td><a href='profile.php?first=" . $member['First'] . "&last=" . $member['Last'] . "&game=" . $game . "'><img src='Headshots/" . $member['Thumb'] . "'/><br>"
								. $color . $member['First'] . " " . $member['Last'] . $endColor . "</a></td>\n";
					}	
					die();
				}
			
				echo "<h2 style=\"font-family: Arial, Helvetica, sans-serif;\">Your Team: " . $user['Team'] . "</h2><br>";
										
				//Get all team members
				$res = mysqli_query($con, "select First, Last, Pic, Kills, Thumb, Status from _" . $game . " inner join users on _" . $game . ".id=users.id where Team='" . $user['Team'] . "' order by First") or die("There seems to be an error in our database. Please try again later.");
				
				echo "<div style=\"text-align: center\">
						<table style=\"margin: auto; width: 75%;table-layout: fixed;\"><tr>";
				//Print all team members to screen
				while ($member = mysqli_fetch_array($res, MYSQLI_BOTH)) {
					$color = ($member['Status'] == 1) ? "" : "<r>";
					$endColor = ($member['Status'] == 1) ? "" : "</r>";
 
					echo "<td><a href='profile.php?first=" . $member['First'] . "&last=" . $member['Last'] . "&game=" . $game . "'><img src='Headshots/" . $member['Thumb'] . "'/><br>"
							. $color . $member['First'] . " " . $member['Last'] . $endColor . "</a></td>\n";
				}
				echo "</tr></table></div><br>";
				
				//Find target team
				$arr = mysqli_fetch_array(mysqli_query($con, "select target from _" . $game . "_roster where Team='" . $user['Team'] . "'"));
				$target = $arr[0];				
				
				//Print all target team members
				echo "<h2 style=\"font-family: Arial, Helvetica, sans-serif;\">Your Target: " . $target . "</h2><br>";
										
				//Get all team members
				$res = mysqli_query($con, "select First, Last, Pic, Kills, Thumb, Status from _" . $game . " inner join users on _" . $game . ".id=users.id where Team='" . $target . "' order by First") or die("There seems to be an error in our database. Please try again later.");
				
				echo "<div style=\"text-align: center\">
						<table style=\"margin: auto; width: 75%; table-layout: fixed;\"><tr>";
				//Print all target members to screen
				while ($member = mysqli_fetch_array($res, MYSQLI_BOTH)) {
					$color = ($member['Status'] == 1) ? "" : "<r>";
					$endColor = ($member['Status'] == 1) ? "" : "</r>";
 
					echo "<td><a href='profile.php?first=" . $member['First'] . "&last=" . $member['Last'] . "&game=" . $game . "'><img src='Headshots/" . $member['Thumb'] . "'/><br>"
							. $color . $member['First'] . " " . $member['Last'] . $endColor . "</a></td>\n";
				}
				echo "</tr></table></div><br>";
				
				echo "<h2 style=\"font-family: Arial, Helvetica, sans-serif;\">Teams List:</h2><p>";
				
				$res = mysqli_query($con, "select Team from _" . $game . "_roster");
				while ($team = mysqli_fetch_array($res, MYSQLI_BOTH)) {
					echo $team[0] . "<br>";
				}
				
		}

				
?>