<?php
	session_start();
	include_once "../functions.php";
	if(!(isset($_SESSION['zalogowany']))) {
        header("Location: index.php?login-error");
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body onload="displayNav()">

<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <aside>
                <div  id="nav"></div>
            </aside>

            <div id="content">

                <h3>Koszyk</h3><hr>

                <?php
                    // echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">&larr; Wróć </a>';

                    $id = filter_var($_SESSION['id'], FILTER_SANITIZE_STRING);

                    query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id); // książki które zamówił klient o danym ID;

                    query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id);
                ?>

                <br><a href="submit_order.php">Złóż zamówienie</a>

            </div>

        </main>

	</div>

    <?php require "../view/footer.php"; ?>

<!--    <script src="../scripts/set-span-width.js"></script>-->

</body>
</html>