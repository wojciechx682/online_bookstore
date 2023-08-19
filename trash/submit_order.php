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

<body>

<?php require "../view/header-container.php"; ?>

	<div id="container">

        <main>

            <aside>
                <div id="nav"></div>
            </aside>

            <div id="content">

                <h3>Koszyk</h3><hr>

                <?php
                    query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']);
                ?>

    <!--			<form action="order.php" method="post">-->
    <!--				<br>-->
    <!--					Wybierz formę dostawy :-->
    <!--				<br>-->
    <!--				<input type="radio" id="dostawa_kurier_dpd" name="zamowienie-typ-dostawy" value="Kurier DPD">-->
    <!--                Kurier DPD<br>-->
    <!--				<input type="radio" id="dostawa_kurier_inpost" name="zamowienie-typ-dostawy" value="Kurier Inpost">-->
    <!--                Kurier Inpost<br>-->
    <!--				<input type="radio" id="odbior_paczkomaty_inpost" name="zamowienie-typ-dostawy" value="Paczkomaty 24/7 (Inpost)">-->
    <!--                Paczkomaty 24/7 (Inpost)<br>-->
    <!--				<input type="radio" id="odbior_poczta_polska" name="zamowienie-typ-dostawy" value="Odbiór w punkcie (Poczta polska)">-->
    <!--                Odbiór w punkcie (Poczta polska)<br>-->
    <!--                <input type="radio" id="odbior_w_ksiegarni" name="zamowienie-typ-dostawy" value="Odbiór w sklepie (Księgarnia)">-->
    <!--                Odbiór w sklepie (Księgarnia)<br>-->
    <!--				<br>-->
    <!--					Wybierz typ płatności :-->
    <!--				<br>-->
    <!--				<input type="radio" name="zamowienie-typ-platnosci" value="Blik">-->
    <!--					Blik<br>-->
    <!--				<input type="radio" name="zamowienie-typ-platnosci" value="Pobranie">-->
    <!--					Pobranie<br>-->
    <!--                <input type="radio" name="zamowienie-typ-platnosci" value="Karta płatnicza (online)">-->
    <!--					Karta płatnicza (online)<br>-->
    <!--				<br><input type="submit" value="Zamawiam">-->
    <!--			</form>-->

                <form action="order.php" method="post">

                    <p>
                        <strong>
                            Wybierz formę dostawy :
                        </strong>
                    <p>

                    <div>
                        <p>
                            <input type="radio" name="zamowienie-typ-dostawy" id="dostawa_kurier_dpd" value="Kurier DPD">
                            <span>
                                <label for="dostawa_kurier_dpd">
                                    Kurier DPD
                                </label>
                            </span>
                        </p>
                    </div>

                <div>
                    <p>
                        <input type="radio" name="zamowienie-typ-dostawy" id="dostawa_kurier_inpost" value="Kurier Inpost">
                        <span>
                            <label for="dostawa_kurier_inpost">
                                Kurier Inpost
                            </label>
                        </span>
                    </p>
                </div>

                <div>
                    <p>
                        <input type="radio" name="zamowienie-typ-dostawy" id="odbior_paczkomaty_inpost" value="Paczkomaty 24/7 (Inpost)">
                        <span>
                            <label for="odbior_paczkomaty_inpost">
                                Paczkomaty 24/7 (Inpost)
                            </label>
                        </span>
                    </p>
                </div>

                <div>
                    <p>
                        <input type="radio" name="zamowienie-typ-dostawy" id="odbior_poczta_polska" value="Odbiór w punkcie (Poczta polska)">
                        <span>
                            <label for="odbior_poczta_polska">
                                Odbiór w punkcie (Poczta polska)
                            </label>
                        </span>
                    </p>
                </div>

                <div>
                <p>
                    <input type="radio" name="zamowienie-typ-dostawy" id="odbior_w_ksiegarni" value="Odbiór w sklepie (Księgarnia)">
                    <span>
                        <label for="odbior_w_ksiegarni">
                            Odbiór w sklepie (Księgarnia)
                        </label>
                    </span>
                    </p>
                </div>

                <p>
                    <strong>
                        Wybierz typ płatności :
                    </strong>
                <br>

                <div>
                    <p>
                        <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-blik" value="Blik">
                        <span>
                            <label for="platnosc-blik">
                                Blik
                            </label>
                        </span>
                    </p>
                </div>

                <div>
                    <p>
                        <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-pobranie" value="Pobranie">
                        <span>
                            <label for="platnosc-pobranie">
                                Pobranie
                            </label>
                        </span>
                    </p>
                </div>

                <div>
                    <p>
                        <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-katra-online" value="Karta płatnicza (online)">
                        <span>
                            <label for="platnosc-katra-online">
                                Karta płatnicza (online)
                            </label>
                        </span>
                    </p>
                </div>

                <br><input type="submit" value="Zamawiam">

                </form>

                <?php

                    if(isset($_SESSION["order-error"])) {
                        unset($_SESSION["order-error"]);
                        echo "<p>Aby złożyć zamówienie, dodaj książki do koszyka !</p>";
                    }

                ?>

            </div>

            <script src="../scripts/set-span-width.js"></script>

        </main>

	</div>

    <?php require "../view/footer.php"; ?>
	
</body>
</html>