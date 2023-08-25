<?php
    require_once "../authenticate-user.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/___header-container.php"; ?>

        <div id="container">

            <main>

                <div id="content" class="shopping-cart">

                    <h3 id="cart-header">Koszyk</h3>

                    <?php

                        // (!) Problem implementacyjny - (do zrobienia) - Zmiana użycia formularza do wysyłania i zapisywania ilości książek w koszyku na użycie technologii AJAX - ponieważ przy zmienie ilości książek w koszyku następuje każdorazowo odświeżenie strony ;

                        echo "<br>"; echo "POST ->"; var_dump($_POST); echo "<hr><br>";
                        echo "GET ->"; var_dump($_GET); echo "<hr><br>";
                        echo "SESSION ->"; var_dump($_SESSION); echo "<hr><br>";

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
                                     kl.id_klienta='%s'", "getProductsFromCart", $_SESSION["id"]);

                        // książki które zamówił klient o danym ID; (które posiada aktualnie w koszyku);

                        // $_SESSION["suma_zamowienia"] --> "285.45"

                    ?>

                    <h3 id='order-sum'>
                        <span class='order-sum order-sum-cart'>suma</span><?= $_SESSION["suma_zamowienia"]; ?> PLN
                    </h3>

                    <button class="btn-link btn-link-static">
                        <a href="___submit_order.php">Złóż zamówienie</a>
                    </button>

                    <?php
                        if ( isset($_SESSION["order-error"]) ) {
                            echo '<p><strong>'.$_SESSION["order-error"].'</strong></p>';
                            unset($_SESSION["order-error"]);
                        }
                    ?>

                </div> <!-- #content -->

            </main>

        </div> <!-- #container -->

        <?php require "../view/___footer.php"; ?>

    </div> <!-- #main-container -->

    <script src="../scripts/change_cart_quantity.js"></script> <!-- Ajax - zmiany ilości książek w koszyku -->

</body>
</html>