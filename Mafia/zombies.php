<?php

function check() {
//Do game check
		global $con, $user, $game, $id;
		//Check if user id is in game table
		$res =  mysqli_query($con, "select * from _" . $game . " where id='" . $id . "'") or die("There seems to be a problem with the database. Please try again later.");
		$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
		$status = $arr[1];
		$user['idCard'] = $arr[2];
		$user['daysLeft'] = $arr[3];
		$user['Kills'] = $arr[4];
	
		//Check if the game has started
		$res = mysqli_query($con, "select status from schedule where Start='" . substr($game, 0, 4) . "-" . substr($game, 4, 2) . "-" . substr($game, 6, 2) . "'") or die("There seems to be a problem with the database. Please try again later.");
		$hasStarted = mysqli_fetch_array($res, MYSQLI_BOTH);
			
		//Check if user is signed up
		if($status == "") {
			//Check if the game has started
			if ($hasStarted[0] == 0) {
				//If it hasn't started, check if they already clicked the button. If they did, add them to the table.
				if (isset($_GET['signup'])) {
					//Find an unused ID
					$idCard = genId(7);
					while (mysqli_num_rows(mysqli_query($con, "select * from _" . $game . " where idCard='" . $idCard . "'")) != 0) {
						$idCard = genId(7);
					}
					if (mysqli_query($con, "insert into _" . $game . " values ('" . $id . "', 1, '" . $idCard . "', 3, 0)")) {
						die ("You've been added to the game. Your ID is <y>" . $idCard . "</y>. Write this down on your notecard now. Click <a href='home.php?game=" . $game . "'>here</a> to continue to the game's page.");
					}
					else {
						die ("There's something wrong with the database. Please try again later.");	
					}
				}
				//If they haven't clicked the button, show them the button.
				else { 
					die ("You aren't signed up for the game scheduled to start on " . convertDate($game) . ". To sign up, click <a href='home.php?game=" . $game . "&signup=true'>here</a>.<br>");
				}
			}
			//If the game has started, tell them the bad news
			die ("Sorry, the game has already started. Please check the <a href='schedule.php'>schedule</a> for the other games.");
		}

		//If they are signed up, print their status and, for zombies, a place to input id cards.
		$actualStatus;
		switch ($status) {
			case -1:
				$actualStatus = "dead person. Sorry.";
				break;
			case 0:
				$actualStatus = "zombie. You have " . $user["daysLeft"] . " (rounded up) days to live and have made " . $user["Kills"] . " kill(s).";
				break;
			case 1:				
				$actualStatus = "human. Your id is " . $user['idCard'] . '. Good luck.';
				break;
			default:
			$actualStatus = "dead person";
		}
		if(!isset($_POST["idCard"])) {
			echo "This is the game that starts/started on " . convertDate($game) . ".<br> If you have any problems, please contact the <a href='admin.html'>admin</a>. <br><br>You are a " . $actualStatus . "<br>";	
		}
		
		if ($status == 0) {
			//Check if they've already submitted this form. If they have, kill that person.
			if (isset($_POST['idCard'])) {
				$idCard = mysqli_real_escape_string($con, $_POST['idCard']);
				//Make sure that idCard is actually a player
				$res = mysqli_query($con, "select * from _" . $game . " where idCard='" . $idCard . "' and status=1") or die("There seems to be a problem with the database. Please try again later.");
				$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
				if($arr[0] == "") {
					die("Sorry, that person is either dead or non-existant. Try re-entering the code? <script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");
				}
				//Kill the player
				mysqli_query($con, "update _" . $game . " set status=0 where idCard='" . $idCard . "'") or die("There seems to be a problem with the database. Pleas try again later. 
				<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");
				//Reset the user's days left
				mysqli_query($con, "update _" . $game . " set daysLeft=3 where id='" . $id . "'") or die("We zombified the player, but we were unable to give you more days to live. Please see the admin to fix this.  
				<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script>");
				//Give the user another kill
				mysqli_query($con, "update _" . $game . " set kills=kills+1 where id='" . $id . "'") or die("We zombified the player, and gave you more days to live, but we couldn't increase your kill count.
				 Please see the admin to fix this.<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php\"}, 4000);</script>");
				die ("Good job! You've eaten enough for another full two days, plus tonight.<script type='text/javascript'>window.setTimeout(function(){document.location.href=\"/home.php?game=". $game . "\"}, 4000);</script><br>");
			}
			//If the game has started, let zombies kill people
			if($hasStarted) {
				echo("Have you eaten lately? Put your victim's ID here: <form action='home.php?game=". $game . "' method='post'><input type='text' name='idCard'/><br><input type='submit'></form><br>");
			}
		} 

		function show () {
				global $con, $user, $game, $id;
				//Count number of respective types
				$res = mysqli_query($con, "select count(*) from _" . $game . " where status=1") or die("There seems to be an error in our database. Please try again later.");
				$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
				$numHumans = $arr[0];
				$res = mysqli_query($con, "select count(*) from _" . $game . " where status=0") or die("There seems to be an error in our database. Please try again later.");
				$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
				$numZombies = $arr[0];
				$res = mysqli_query($con, "select count(*) from _" . $game . " where status=-1") or die("There seems to be an error in our database. Please try again later.");
				$arr = mysqli_fetch_array($res, MYSQLI_BOTH);
				$numDead = $arr[0];
				$humans = array();
				$zombies = array();
				$dead = array();
				$res = mysqli_query($con, "select First, Last, Pic, Kills, Thumb from _" . $game . " inner join users on _" . $game . ".id=users.id order by status, First") or die("There seems to be an error in our database. Please try again later.");
				
				for ($i = 0; $i < $numDead; $i++) {
					$dead[$i] = mysqli_fetch_array($res, MYSQLI_BOTH) or die("There seems to be an error in our database. Please try again later.");
				}
				$z = $i;
				for ($i = 0; $i < $numZombies; $i++) {
					$zombies[$i] = mysqli_fetch_array($res, MYSQLI_BOTH) or die("There seems to be an error in our database. Please try again later.");
				}	
				$z = ($i > $z) ? $i : $z;
				for ($i = 0; $i < $numHumans; $i++) {
					$humans[$i] = mysqli_fetch_array($res, MYSQLI_BOTH) or die("There seems to be an error in our database. Please try again later.");
				}
				$z = ($i > $z) ? $i : $z;
				for ($i = 0; $i < $z; $i++) {
					echo "<tr>";
					if(!isset($humans[$i])) {
						echo "<td></td>";
					}
					else {
						echo "<td><a href='profile.php?first=" . $humans[$i]['First'] . "&last=" . $humans[$i]['Last'] . "&game=" . $game . "'><img src='Headshots/" . $humans[$i]['Thumb'] . "'/><br>"
							. $humans[$i]['First'] . " " . $humans[$i]['Last'] . "</a></td>\n";
					}
					
					if(!isset($zombies[$i])) {
						echo "<td></td>";
					}
					else {
						echo "<td><a href='profile.php?first=" . $zombies[$i]['First'] . "&last=" . $zombies[$i]['Last'] . "&game=" . $game . "'><img src='Headshots/" . $zombies[$i]['Thumb'] . "'/><br><r>" 
							. $zombies[$i]['First']	. " " . $zombies[$i]['Last'] . "</r></a></td>\n";
					}
					
					if(!isset($dead[$i][0])) {
						echo "<td></td>";
					}
					else {
						echo "<td><a href='profile.php?first=" . $dead[$i]['First'] . "&last=" . $dead[$i]['Last'] . "&game=" . $game . "'><img src='Headshots/" . $dead[$i]['Thumb'] . "'/></a><br><g>"
							 . $dead[$i]['First'] . " " . $dead[$i]['Last'] . "</g></a></td>\n";
					}
					echo "</tr>";
						
				}
				
	}
}
				
			?>