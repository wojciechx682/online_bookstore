<?php
	session_start();
	include_once "../functions.php";
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>


<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>
        <aside class="account-data">
            <div id="nav">
                <!-- <a href="edit_data.php">Edytuj dane użytkownika</a><br><br> -->
                <a href="account.php"> ← </a><br><br>
                <a href="my_orders.php">Zamówienia</a>
            </div>
        </aside>

		<div id="content">

			<!-- <h3>Zamówienia</h3><hr> -->
            <h3>Historia zamówień</h3><hr>

			<?php
				echo '<script> displayNav(); </script>';

				query("SELECT id_zamowienia, data_zlozenia_zamowienia, status FROM zamowienia WHERE id_klienta = '%s'", "get_orders", $_SESSION['id']);
			?>

			<br><br><a href="logout.php">[ Wyloguj ]</a>

		</div>

        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</body>
</html>