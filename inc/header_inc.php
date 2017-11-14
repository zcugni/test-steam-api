<?php 
	echo "<header>
			<nav>
				<ul>
					<li class='inline'><a href='index.php?steamid=" . $_SESSION["steamId"] . "'>Acceuil</a></li>
					<li class='inline'><a href='hours.php?steamid=" . $_SESSION["steamId"] . "'>Temps de jeux</a></li>
					<li class='inline'><a href='achievements.php?steamid=" . $_SESSION["steamId"] . "'>Trophées débloqués</a></li>
				</ul>
			</nav>
		</header>"
?>