<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Trophés</title>
	</head>
	<body>
		<?php 
			session_start();
			include_once("inc/header_inc.php"); 
		?>

		<main class='center'>
			<div class="pageLoader"><p class="inline">Récupération des données</p></div>

			<?php 
			require_once("functions/steamAPIRequest.php");
			require_once("functions/displayFunctions.php");
			require_once("functions/generalFunctions.php");

			verifyURLSteamid();

			if(!isset($_SESSION["publicUsers"]))
				createPublicUserSession();

			echo displayUserGames($_SESSION["steamId"]);
			?>

			<div id="floatingCirclesG">
                <div class="f_circleG" id="frotateG_01"></div>
                <div class="f_circleG" id="frotateG_02"></div>
                <div class="f_circleG" id="frotateG_03"></div>
                <div class="f_circleG" id="frotateG_04"></div>
                <div class="f_circleG" id="frotateG_05"></div>
                <div class="f_circleG" id="frotateG_06"></div>
                <div class="f_circleG" id="frotateG_07"></div>
                <div class="f_circleG" id="frotateG_08"></div>
            </div>
		</main>

		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		<script src="js/pageLoader.js"></script>
		<script> /* ajax call to get all achievements of clicked game */

			var currentLightbox = 0;

			/* Hide the current lightbox (if it is displayed) when we click somewhere on the screen 
			   this won't do anything the first time we click on a game, but after that, currentLightbox will be set to an actual div */
			$("main").click(function(e){
				if($(currentLightbox).css("display") != "none"){
					e.preventDefault(); /* needed in case the user click on a game icon (since the ajax call is used with them) */
					$(currentLightbox).hide();
				}
			});

			$(".gameAchievement").click(function(e){
				var appid = $(this).attr("id").substring(4);
				var currentGameAchievementArea = "#ach" + appid; //it's the futur lightbox
				e.preventDefault();

				/* If it the first time we clicked on a game, or if no other lightbox are currently shown, do the ajax call to show an achievement lightbox */
				if(currentLightbox == 0 || $(currentLightbox).css("display") == "none"){
					if($(currentGameAchievementArea).is(":empty")){ /* If it is the first time we clicked on this specific game (otherwise there will already be achievement data) */
						$.post(
							'functions/achievementLogic.php',
							{ appid : appid },
							function(data){ 
								$(currentGameAchievementArea).append(data);
								$(currentGameAchievementArea).show();
								currentLightbox = currentGameAchievementArea;
								$("#floatingCirclesG").hide();
							},
							"text"
						);
					} else { /* if it isn't the first time we clicked on the game, we just need to show the existing data */
						$(currentGameAchievementArea).show();
						currentLightbox = currentGameAchievementArea;
						e.stopPropagation(); /* we don't want the main.click event to react in this case */
					}
				}
			});

			$( document ).ajaxStart(function() {
				$("#floatingCirclesG").show();
			});
		</script>
	</body>
</html>