<?php
	session_start();
	require_once("steamAPIRequest.php");

	if(isset($_GET['steamid']) && !empty($_GET['steamid'])){

		//I need to do the same thing with two differents API's key because of some bug. The same request don't always return the same thing with each one 
		$result = getUserInfo($_GET['steamid']);
		$resultOtherKey = getUserInfoOtherKey($_GET['steamid']);

		if(empty($result["response"]["players"])){ /* steamid doesn't exist */
			session_unset();
			header("Location:../index.php?message=Ce steam id n'existe pas");
		} else if ($result["response"]["players"][0]["communityvisibilitystate"] != 3 || $resultOtherKey["response"]["players"][0]["communityvisibilitystate"] != 3) {  /* profil is private */
			session_unset();
			header("Location:../index.php?message=Le profil du joueur est privé");
		} else { /* everythings good */
			$_SESSION['steamId'] = filter_input(INPUT_GET, 'steamid');
			unset($_SESSION["publicUsers"]); /* In case we change the steamId used, the other sessions need to be reinitialise with the new data, so we need this */
			header("Location:../index.php?steamid=" . $_SESSION['steamId']);
		}
	} else {
		header("Location:../index.php");
	}