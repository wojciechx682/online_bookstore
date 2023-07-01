<?php

	session_start();
	include_once "../functions.php";

    if( ! isset($_SESSION['zalogowany']) ) {

        $_SESSION["login-error"] = true;
        header("Location: ___zaloguj.php");
        exit();
    }

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/___header-container.php"; ?>

	<div id="container">

        <main>

            <div id="content">

                <h3 id="cart-header">Koszyk</h3>

                <?php
                    query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, au.imie, au.nazwisko FROM klienci AS kl, koszyk AS ko, ksiazki AS ks, autor AS au WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND ks.id_autora = au.id_autora AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION["id"]);
                    // książki które zamówił klient o danym ID; (które posiada aktualnie w koszyku)
                ?>

                <form action="___order.php" method="post" id="submit-order">

                    <p>
                        <strong>
                            Wybierz formę dostawy
                        </strong>
                    </p>

                    <div>
                        <label>
                            <p class="option">
                                <input type="radio" name="zamowienie-typ-dostawy" id="dostawa_kurier_dpd" value="Kurier DPD">

                                <span>
                                    <img src="../assets/dpd.png" title="Kurier DPD">
                                        Kurier DPD
                                </span>
                            </p>
                        </label>
                    </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="dostawa_kurier_inpost" value="Kurier Inpost">
                            <span>
                                <img src="../assets/inpost.png" title="Kurier Inpost">
                                    Kurier Inpost
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="odbior_paczkomaty_inpost" value="Paczkomaty 24/7 (Inpost)">
                            <span>
                                <img src="../assets/paczkomaty24_7.png" title="Paczkomaty 24/7 (Inpost)">
                                    Paczkomaty 24/7 (Inpost)
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="odbior_poczta_polska" value="Odbiór w punkcie (Poczta polska)">
                            <span>
                                <img src="../assets/odbior_poczta_polska.png" title="Odbiór w punkcie (Poczta polska)">
                                    Odbiór w punkcie (Poczta polska)
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="odbior_w_ksiegarni" value="Odbiór w sklepie (Księgarnia)">
                            <span>
                                <img src="../assets/odbior_osobisty.png" title="Odbiór w sklepie (Księgarnia)">
                                    Odbiór w sklepie (Księgarnia)
                            </span>
                        </p>
                    </label>
                </div>

                <div style="clear: both;"></div>

                <p>
                    <strong>
                        Wybierz typ płatności
                    </strong>
                <br>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-blik" value="Blik">
                            <span>
                                 <img src="../assets/blik.png" title="Blik">
                                    Blik
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-pobranie" value="Pobranie">
                            <span>
                                <img src="../assets/pobranie.png" title="Pobranie">
                                    Pobranie
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-katra-online" value="Karta płatnicza (online)">
                            <span>
                                <img src="../assets/karta.png" title="Karta płatnicza (online)">
                                    Karta płatnicza (online)
                            </span>
                        </p>
                    </label>
                </div>

                <div style="clear: both;"></div>

                <button type="submit" class="btn-link btn-link-static">Zamawiam</button>

                </form>

                <?php
                    if(isset($_SESSION["order-error"])) {
                        unset($_SESSION["order-error"]);
                        echo "<p>Aby złożyć zamówienie, dodaj książki do koszyka !</p>";
                    }
                ?>

            </div>

            <script src="../scripts/set-span-width.js"> </script>

        </main>

	</div> <!-- #container -->

    <script>
        content = document.getElementById("content");
        content.style.width = "100%";
    </script>

    <?php require "../view/footer.php"; ?>

</div> <!-- #main-container -->

</body>
</html>