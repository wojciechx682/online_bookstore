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

<?php require "template\head.php"; ?>

<body>

<?php require "template\header-container.php"; ?>

	<div id="container">

		<div id="nav">
		</div>

		<div id="content">

			<h3>Koszyk</h3>		

			<hr>

            <?php
                echo query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']);
            ?>

			<form action="order.php" method="post">

				<br>
					Wybierz formę dostawy :
				<br>

				<input type="radio" id="dostawa_kurier_dpd" name="zamowienie_typ_dostawy" value="Kurier DPD"> <!-- value="kurier_dpd" -->
					Kurier DPD<br>
				<input type="radio" id="dostawa_kurier_inpost"  name="zamowienie_typ_dostawy" value="Kurier Inpost"> <!-- value="kurier_inpost" -->
					Kurier Inpost<br> 
				<input type="radio" id="odbior_paczkomaty_inpost" name="zamowienie_typ_dostawy" value="Paczkomaty 24/7 (Inpost)"> <!-- value="odbior_inpost" -->
					Paczkomaty 24/7 (Inpost)<br>	
				<input type="radio" id="odbior_poczta_polska" name="zamowienie_typ_dostawy" value="Odbiór w punkcie (Poczta polska)"> <!-- value="odbior_poczta" -->
					Odbiór w punkcie (Poczta polska)<br>
                <input type="radio" id="odbior_w_ksiegarni" name="zamowienie_typ_dostawy" value="Odbiór w sklepie (Księgarnia)"> <!-- value="odbior_sklep" -->
                Odbiór w sklepie (Księgarnia)<br>

				<br>
					Wybierz typ płatności :
				<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="Blik"> <!-- value="blik" -->
					Blik<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="Pobranie"> <!-- value="pobranie" --> 
					Pobranie<br>

				<input type="radio" name="zamowienie_typ_platnosci" value="Karta płatnicza (online)"> <!-- value="karta_platnicza" -->
					Karta płatnicza (online)<br>	

				<br><input type="submit" value="Zamawiam">

			</form>

			<!-- <button onclick="test_order()">Wyswietl wartosci formularza</button> -->

		</div>

<?php require "template/footer.php"; ?>

        <script src="set-span-width.js"></script>

	</div>
	
</body>
</html>