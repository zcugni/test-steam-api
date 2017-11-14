<?php
	require_once("steamAPIRequest.php");

	function displayedUserInfoFull($steamId) {
		$level = getPlayerLevel($steamId)["response"]["player_level"];
		$result = getUserInfo($steamId);
		$cleanResult = $result['response']['players'][0];
		$steamid = $cleanResult['steamid'];

		if(isset($cleanResult['lastlogoff']))
			$lastLog = "Dernière connexion : " . date('j M Y, H\hi', $cleanResult['lastlogoff']);
		else
			$lastLog = "Dernière connexion : jamais"; /*During test, i stumble on user who never logged in, don't ask me why */

		if(isset($cleanResult['timecreated'])) /* won't see if it's private */
			$timeCreated = "Date de création : " . date('j M Y', $cleanResult['timecreated']);
		else
			$timeCreated = "Date de création : Inconnu";

		return  "<div class='playerInfo inline'>
					<figure class='inline'>  
						<a href='functions/authentification.php?steamid=" . $steamid . "'><img src=" . $cleanResult['avatarfull'] . " alt='photo de profil' class='inline'></a>
						<figcaption>" . $cleanResult['personaname'] . "</figcaption>
					</figure>
					<div class='inline'>
						<p>Steam id: $steamid</p>
						<p>Steam Level: $level</p>
						<p>$lastLog</p>
						<p>$timeCreated</p>
					</div>
				</div>";
	}

	function displayedUserInfoBasic($steamId){
		$result = getUserInfo($steamId);
		$cleanResult = $result['response']['players'][0];

		return "<figure class='miniPlayerAvatar inline'><img src=" . $cleanResult['avatarmedium'] . 
		" alt='photo de profil' class='inline'><figcaption>" 
		. $cleanResult['personaname'] . "</figcaption></figure>";
	}

	function displayedTotalHoursInfo($minutePlayed, $maxMinutePlayed, $user){
		$result = calculateLineWidth_HourFormat($minutePlayed, $maxMinutePlayed, $user);
		$toDisplay = "<div class='playerHoursBlock'>";
		$toDisplay .= displayedUserInfoBasic($user);
		$toDisplay .= "<div class='green inline' style = 'width:" . $result['greenAreaWidth'] . "'></div><p class='nbHours inline'> " . $result['formattedHours'] . "</p></div>";

		return $toDisplay;
	}

	function displayedRecentHoursInfo($minutePlayed, $maxMinutePlayed, $user, $recentGames){
		$result = calculateLineWidth_HourFormat($minutePlayed, $maxMinutePlayed, $user);
		$toDisplay = "<div class='playerHoursBlock'>";
		$toDisplay .= displayedUserInfoBasic($user);

		$toDisplay .= "<div class='green inline' style = 'width:" . $result['greenAreaWidth'] . "'></div><p class='nbHours inline'> " . $result['formattedHours'] . "</p><div class='inline'>";

		if(!is_null($recentGames)) /* The user didn't necessarily play in the last 2 weeks */
			foreach ($recentGames as $appid => $game) 
				if(!empty($game['icon']) && !empty($game['name']))
					$toDisplay .= "<img src='http://media.steampowered.com/steamcommunity/public/images/apps/" . $appid . "/" . $game['icon'] . ".jpg' alt='icon d'un jeu récemment joué' title='". $game['name'] . "' class='gameIcon'>";
		
		$toDisplay .= "</div></div>";

		return $toDisplay;
	}

	function displayUserGames($steamId){
		$toDisplay = "";

		foreach(getUserOwnedGames($steamId)["response"]["games"] as $game){
			//by default. it's a get request, but we only need an head request (which would be a lot more efficient)
			stream_context_set_default(
			    array( 'http' => array( 'method' => 'HEAD') )
			);

			$header = get_headers("http://cdn.akamai.steamstatic.com/steam/apps/" . $game["appid"] . "/header.jpg");

			if($header[0] != "HTTP/1.0 404 Not Found") {
				$toDisplay .= "<a class='gameAchievement' href='' id='game". $game["appid"] . "'>";
				$toDisplay .= "<img src='http://cdn.akamai.steamstatic.com/steam/apps/" . $game["appid"] . "/header.jpg' class='gameImg'>";
				$toDisplay .= "<div class='achievementArea' id='ach" . $game["appid"] . "'></div></a>";
			}
		}

		return $toDisplay;
	}