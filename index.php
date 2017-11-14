<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Acceuil</title>
	</head>
	<body>
		<div class="pageLoader"><p class="inline">Récupération des données</p></div>
		<?php

			require_once("functions/steamAPIRequest.php");
			require_once("functions/displayFunctions.php");
			require_once("functions/generalFunctions.php");

			session_start();

			if(!isset($_SESSION['steamId']) || empty($_SESSION['steamId']) || empty($_GET['steamid'])){ //login
				$toDisplay = "<div id='login'>";

				if(isset($_GET['message']))
					$toDisplay .= "<p id='error'>" . $_GET['message'] . "</p>";

				$toDisplay .= "<form action='functions/authentification.php' method='get'>
								<label for='steamId'>Steam Id de l'utilisateur :</label>
								<input type='text' name='steamid' id='steamid'>
								<input type='submit'>
							  </form></div>";

				echo $toDisplay;
			} else {

				verifyURLSteamid();
				
				include_once("inc/header_inc.php"); 

				//Users (the connected user will be the first one the array, the others being his/her friends)
				$users = getUserFriends($_SESSION["steamId"])["friendslist"]["friends"]; //Even the one with private profile

				//I need to format the connected user data in the same way the friends are formatted in order to work with an unified array
				$connectedUserData = array("steamid" => $_SESSION["steamId"]); 
				array_unshift($users, $connectedUserData); /* put the connected user at the beginning of the array */
				$_SESSION["users"] = $users;

				/* display info of all his/her friends */

				$toDisplay = "";
					
				foreach ($users as $index => $user){
					if($index == 1) { //Before the first friend, i need to add an opening section with a friend class
						$toDisplay .= "<section id='friend'>";
						$toDisplay .= displayedUserInfoFull($user["steamid"]);
					} else {
						$toDisplay .= displayedUserInfoFull($user["steamid"]);
					}	
				}

				$toDisplay .= "</section>";
				echo $toDisplay;
			}
		?>
	</body>

	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="js/pageLoader.js"></script>
</html>