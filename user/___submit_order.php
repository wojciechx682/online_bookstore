<?php

    /*session_start();
    include_once "../functions.php";
    if( ! isset($_SESSION['zalogowany']) ) {

        $_SESSION["login-error"] = true;
            header("Location: ___zaloguj.php");
                exit();
    }*/

    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
    require_once "../authenticate-user.php";

    if ( !isset($_SESSION["koszyk_ilosc_ksiazek"]) || $_SESSION['koszyk_ilosc_ksiazek'] == 0) {

        $_SESSION["quantity-error"] = true;
        header('Location: ___koszyk.php', true, 303);
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
                    query("SELECT kl.id_klienta, 
                                  ko.id_ksiazki, ko.ilosc, 
                                  ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, 
                                  au.imie, au.nazwisko 
                           FROM klienci AS kl, 
                                koszyk AS ko, 
                                ksiazki AS ks, 
                                autor AS au 
                           WHERE kl.id_klienta = ko.id_klienta AND 
                                 ko.id_ksiazki = ks.id_ksiazki AND 
                                 ks.id_autora = au.id_autora AND 
                                 kl.id_klienta='%s'", "get_product_from_cart", $_SESSION["id"]); // książki które zamówił klient o danym ID; (które posiada aktualnie w koszyku);
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
                                <input type="radio" name="delivery-type" value="Kurier DPD">
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
                                <input type="radio" name="delivery-type" value="Kurier Inpost">
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
                                <input type="radio" name="delivery-type" value="Paczkomaty 24/7 (Inpost)">
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
                                <input type="radio" name="delivery-type" value="Odbiór w punkcie (Poczta polska)">
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
                                <input type="radio" name="delivery-type" value="Odbiór w sklepie (Księgarnia)">
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
                            Wybierz metodę płatności
                        </strong>
                    </p>

                    <div>
                        <label>
                            <p class="option">
                                <input type="radio" name="payment-method" value="Blik">
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
                                <input type="radio" name="payment-method" value="Pobranie">
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
                                <input type="radio" name="payment-method" value="Karta płatnicza (online)">
                                <span>
                                    <img src="../assets/karta.png" title="Karta płatnicza (online)">
                                        Karta płatnicza (online)
                                </span>
                            </p>
                        </label>
                    </div>

                    <div style="clear: both;"></div>

                    <button type="submit" class="btn-link btn-link-static">
                        Zamawiam
                    </button>

                </form> <!-- POST -> order.php -->

                <?php
                    /*if( isset($_SESSION["order-error"]) ) {
                            unset($_SESSION["order-error"]);
                        echo "<p><strong>Aby złożyć zamówienie, dodaj książki do koszyka</strong></p>";
                    }*/
                    if ( isset($_SESSION["delivery-error"]) ) { // order_php -> "true";
                            unset($_SESSION["delivery-error"]);
                        echo "<p><strong>Podaj poprawną formę dostawy</strong></p>";
                    }
                    elseif ( isset($_SESSION["payment-error"]) ) { // order_php -> "true";
                            unset($_SESSION["payment-error"]);
                        echo "<p><strong>Podaj poprawną formę płatności</strong></p>";

                    } elseif ( isset($_SESSION["order-error"]) ) { // empty POST values ;
                            unset($_SESSION["order-error"]);
                        echo "<p><strong>Aby złożyć zamówienie, wybierz formę dostawy i metodę płatności</strong></p>";
                    }
                ?>

            </div>

            <!--<script src="../scripts/set-span-width.js"> </script>-->

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