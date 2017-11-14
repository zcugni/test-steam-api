<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Temps de jeu</title>
	</head>
	<body>
		<?php 
			session_start();
			include_once("inc/header_inc.php"); 
		?>

		<div class="pageLoader"><p class="inline">Récupération des données</p></div>

		<section id="comment">
			<h3>Remarques:</h3>
			<ul>
				<li>Les heures n'ont commencées à être comptabilisées qu'à partir de 2009</li>
				<li>Les heures passer en mode hors-ligne ou sur des jeux partagés ne sont pas comptabilisé</li>
				<li>Je peux uniquement donner des informations sur les joueurs dont le profil est publique</li>
				<li>Steam ne renvoit pas d'informations sur les heures passées sur certains jeux, tel que Dota 2</li>
				<li>Le résultat trouver sur ce site peut être différent d'autres sites similaires car je n'arrondis pas les heures lors du calcul, seulement pour l'affichage</li>
			</ul>
		</section>

		<?php 
		require_once("functions/steamAPIRequest.php");
		require_once("functions/displayFunctions.php");
		require_once("functions/generalFunctions.php");

		verifyURLSteamid();

		if(!isset($_SESSION["publicUsers"]))
			createPublicUserSession();

		// --- Total play time --- //

		// -- Calculate the total time spent playing by each user --

		foreach ($_SESSION["publicUsers"] as $user){
			$totalPlaytimeMinute = 0; /* since it's in a loop; i need a clean variable each time */
			$result = getUserOwnedGames($user);

			if(isset($result["response"]["games"])) //won't be set if the user has 0 game
				foreach ($result["response"]["games"] as $game)
					$totalPlaytimeMinute += $game["playtime_forever"];

				$userPlaytime[$user] = $totalPlaytimeMinute;
		}

		//Display total playtime for each user

		$toDisplay = "<section class='hourSection inline'><h3>Temps de jeu total :</h3>";

		$maxPlaytimeMinute = findMaxPlaytime($userPlaytime); 

		foreach ($_SESSION["publicUsers"] as $user)
			$toDisplay .= displayedTotalHoursInfo($userPlaytime[$user], $maxPlaytimeMinute, $user);

		$toDisplay .= "</section>";



		// --- Last 2 weeks playtime --- //

		// -- Calculate the total time spent playing by each user --

		$toDisplay .= "<section class='hourSection inline'><h3>Temps de jeu sur les 2 dernières semaines :</h3>";
		
		foreach ($_SESSION["publicUsers"] as $user) {
			$recentPlaytimeMinute = 0;
			unset($recentGamesArray); /* since it's in a loop; i need a clean array each time */
			if(isset(getRecentlyPlayedGames($user)["response"]["games"])) //Won't be set if the player didn't play in the last two weeks.
				foreach(getRecentlyPlayedGames($user)["response"]["games"] as $recentlyPlayedGame){
					$recentPlaytimeMinute += $recentlyPlayedGame["playtime_2weeks"];

					if(isset($recentlyPlayedGame['img_icon_url']) && isset($recentlyPlayedGame['name'])) /* sometimes it doesn't exist */
						$recentGamesArray[$recentlyPlayedGame['appid']] = array('icon' => $recentlyPlayedGame['img_icon_url'], 'name' => $recentlyPlayedGame['name']);
				}

			$recentPlaytime[$user] = $recentPlaytimeMinute;

			if(isset($recentGamesArray)) /*The user didn't necessarily play in the last 2 weeks */
				$recentGames[$user] = $recentGamesArray;
			else
				$recentGames[$user] = null;
		}

		$maxRecentPlaytimeMinute = findMaxPlaytime($recentPlaytime);

		foreach ($_SESSION["publicUsers"] as $user)
			$toDisplay .= displayedRecentHoursInfo($recentPlaytime[$user], $maxRecentPlaytimeMinute, $user, $recentGames[$user]);

		$toDisplay .= "</section>";
		echo $toDisplay;
		?>
	</body>

	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="js/pageLoader.js"></script>
</html>