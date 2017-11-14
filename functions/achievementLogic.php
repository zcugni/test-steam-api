<?php 
	session_start();

	require_once("steamAPIRequest.php");
	require_once("displayFunctions.php");

	$appId = filter_input(INPUT_POST, "appid", FILTER_VALIDATE_INT);
	$toDisplay = "";

	$result = getGameAchievements($appId);
	
	if(empty($result) || empty($result["availableGameStats"]["achievements"])) /* Some games don't have stats at all while others have stats but no achievements */
		$toDisplay = "<p class='center'>Pas de trophées disponibles pour ce jeu :(</p>";
	else { /*this game has achievement */
		$gameAchievements = $result["availableGameStats"]["achievements"];

		foreach($_SESSION["publicUsers"] as $user){
			$toDisplay .= "<div class='playerAchBlock'>" . displayedUserInfoBasic($user);
			$playerAchievements = getPlayerAchievementsOnGame($user, $appId);

		 	if(!isset($playerAchievements["playerstats"]["achievements"]) && $user != $_SESSION['steamId']) /* No achievement unlocked or the user don't own the game (i can't know which) */
			 	$toDisplay .= "<p>Ce joueur n'a pas ce jeu ou n'a pas débloqué de trophées dessus</p>";
			else if(!isset($playerAchievements["playerstats"]["achievements"]) && $user == $_SESSION['steamId']) /* same, but with the connected user, so i kown he/she own the game (=> meaning no achievement has been unlocked) */
				$toDisplay .= "<p>Ce joueur n'a pas débloqué de trophées sur ce jeu</p>";
			else { /* the player has unlocked achievement on this game */

				//get the name of the achievement 
				foreach($playerAchievements["playerstats"]["achievements"] as $playerAchievement)
					$playerAchievementsNames[] = $playerAchievement["name"];

				$toDisplay .= "<div class='achievementList'>";
				$cpt = 0; /* number of achievement unlocked by the player */

				//For each achievement of the game, if the user as unlocked it, display it's icon
				foreach($gameAchievements as $gameAchievement){
					if(in_array($gameAchievement["name"], $playerAchievementsNames)){
						if(isset($gameAchievement["description"])) /*description is not always present */
							$toDisplay .= "<img src='" . $gameAchievement["icon"] . "' title='" . $gameAchievement["description"] . "'>"; 
						else
							$toDisplay .= "<img src='" . $gameAchievement["icon"] . "'>"; 

						$cpt++;
					}
				}

				$toDisplay .= $cpt . "/" . count($gameAchievements) . " trophées débloqués";
			}

			$toDisplay .= "</div></div>";
		}
	}

	echo $toDisplay;
?>