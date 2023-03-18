<?php

	// koszyk.php - usunięcie książki
	
	session_start();

	include_once "../functions.php";

	if(
		(isset($_POST['komentarz'])) &&
		(isset($_POST['star']))

	)
	{
		echo "<br>komentarz --> " . $_POST["komentarz"] . "<br>";
		echo "<br>ocena --> " . $_POST["star"] . "<br>";
		exit();
	}

?>
