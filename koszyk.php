<?php
	session_start();
	include_once "functions.php";
	if(!(isset($_SESSION['zalogowany'])))
	{
        header("Location: index.php?login-error");
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "template/head.php"; ?>

<body onload="displayNav()">

<?php require "template/header-container.php"; ?>

	<div id="container">

		<div  id="nav"></div>

		<div id="content">

			<h3>Koszyk</h3>

			<hr>

			<?php
                // var_dump($_SESSION); echo "<br><br>";
				query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']); // Książki które zamówił klient o danym ID;
			?>

			<br><a href="submit_order.php">Złóż zamówienie</a>

		</div>

<?php require "template/footer.php"; ?>

	</div>

    <script src="set-span-width.js"></script>

</body>
</html>