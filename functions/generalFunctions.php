<?php 
require_once("functions/steamAPIRequest.php");

function createPublicUserSession(){
	foreach ($_SESSION["users"] as $user){
		//I need to do the same thing with two differents API's key because of some bug. The same request don't always return the same thing with each one 
		$resultOwnKey = getUserOwnedGames($user["steamid"]);
		$resultOtherKey = getUserOwnedGamesOtherKey($user["steamid"]); 

		if(!empty($resultOwnKey["response"]) && !empty($resultOtherKey["response"])) /*empty with private profil */
			$publicUsers[] = $user["steamid"];
	}

	$_SESSION["publicUsers"] = $publicUsers;
}

function verifyURLSteamid(){
	$URLSteamID = filter_input(INPUT_GET, "steamid");
		if($URLSteamID != $_SESSION['steamId']){
			header("Location: functions/authentification.php?steamid=" . $URLSteamID);
			exit();
		}
}

function findMaxPlaytime($userPlaytimeArray){
	$maxPlaytimeMinute = 0;

	foreach ($userPlaytimeArray as $playtimeMinute) 
		if($playtimeMinute > $maxPlaytimeMinute)
				$maxPlaytimeMinute = $playtimeMinute;

	return $maxPlaytimeMinute;
}

function calculateLineWidth_HourFormat($minutePlayed, $maxMinutePlayed, $user){
	$hoursPercentange = ($minutePlayed / $maxMinutePlayed) * 100;
	$greenAreaWidth = ($hoursPercentange  / 2) . "%"; /* divide by 2 because we work on half a screen */
	$hours = number_format(($minutePlayed / 60), 2, ',', ' ') . "h"; /*number of hours in this format: 10,7h */ 

	return array("greenAreaWidth" => $greenAreaWidth, "formattedHours" => $hours);
}
?>