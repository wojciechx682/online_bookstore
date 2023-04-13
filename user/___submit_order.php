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

<?php require "../view/___head.php"; ?>

<body>

<div id="all-container">

    <!-- header -->

    <?php require "../view/___header-container.php"; ?>

    <!-- end header -->

	<div id="container">

        <main>

            <!--<aside>
                <div id="nav"></div>
            </aside>-->

            <div id="content">

                <h3>Koszyk</h3><hr>

                <?php
                query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, au.imie, au.nazwisko FROM klienci AS kl, koszyk AS ko, ksiazki AS ks, autor AS au WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND ks.id_autora = au.id_autora AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION["id"]); // książki które zamówił klient o danym ID;


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

                <form action="___order.php" method="post" id="submit-order">

                    <p>
                        <strong>
                            Wybierz formę dostawy :
                        </strong>
                    </p>

                    <div>
                        <label>
                            <p class="option">
                                <input type="radio" name="zamowienie-typ-dostawy" id="dostawa_kurier_dpd" value="Kurier DPD">



                                <span>
                                    <!--<label for="dostawa_kurier_dpd">-->
                                    <img src="../assets/dpd.png">
                                        Kurier DPD
                                    <!--</label>-->
                                </span>
                            </p>
                        </label>
                    </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="dostawa_kurier_inpost" value="Kurier Inpost">
                            <span>
                                <!--<label for="dostawa_kurier_inpost">-->
                                <img src="../assets/inpost.png">
                                    Kurier Inpost
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="odbior_paczkomaty_inpost" value="Paczkomaty 24/7 (Inpost)">
                            <span>
                                <img src="../assets/paczkomaty24_7.png">
                                <!--<label for="odbior_paczkomaty_inpost">-->
                                    Paczkomaty 24/7 (Inpost)
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="odbior_poczta_polska" value="Odbiór w punkcie (Poczta polska)">
                            <span>
                                <!--<label for="odbior_poczta_polska">-->
                                <img src="../assets/odbior_poczta_polska.png">
                                    Odbiór w punkcie (Poczta polska)
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-dostawy" id="odbior_w_ksiegarni" value="Odbiór w sklepie (Księgarnia)">
                            <span>
                                <!--<label for="odbior_w_ksiegarni">-->
                                <img src="../assets/odbior_osobisty.png">
                                    Odbiór w sklepie (Księgarnia)
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div style="clear: both;"></div>

                <p>
                    <strong>
                        Wybierz typ płatności :
                    </strong>
                <br>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-blik" value="Blik">
                            <span>
                                 <img src="../assets/blik.png">
                                <!--<label for="platnosc-blik">-->
                                    Blik
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-pobranie" value="Pobranie">
                            <span>
                                <img src="../assets/pobranie.png">
                                <!--<label for="platnosc-pobranie">-->
                                    Pobranie
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div>
                    <label>
                        <p class="option">
                            <input type="radio" name="zamowienie-typ-platnosci" id="platnosc-katra-online" value="Karta płatnicza (online)">
                            <span>
                                <img src="../assets/karta.png">
                                <!--<label for="platnosc-katra-online">-->
                                    Karta płatnicza (online)
                                <!--</label>-->
                            </span>
                        </p>
                    </label>
                </div>

                <div style="clear: both;"></div>

                <!--<br><input type="submit" value="Zamawiam">-->

                <button type="submit" class="btn-link btn-link-static">Zamawiam</button>

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

    <script>
        content = document.getElementById("content");
        content.style.width = "100%";
    </script>

    <?php require "../view/footer.php"; ?>

</div>
	
</body>
</html>