<?php
    require_once "../authenticate-user.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/header-container.php"; ?>

        <div id="container">

            <main>

                <div id="content" class="shopping-cart">

                    <h3 id="cart-header">Koszyk</h3>

                    <?php

                        query("SELECT kl.id_klienta, 
                                      ko.id_ksiazki, ko.ilosc, 
                                      ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, 
                                      au.imie, au.nazwisko,
                                      sb.nazwa AS podkategoria, kt.nazwa AS kategoria
                               FROM customers AS kl, 
                                    shopping_cart AS ko, 
                                    books AS ks, 
                                    author AS au,
                                    subcategories AS sb,
                                    categories AS kt                                                                                   
                               WHERE kl.id_klienta = ko.id_klienta AND 
                                     ko.id_ksiazki = ks.id_ksiazki AND 
                                     ks.id_autora = au.id_autora AND    
                                     sb.id_subkategorii = ks.id_subkategorii
                                     AND sb.id_kategorii = kt.id_kategorii AND
                                     kl.id_klienta='%s'", "getProductsFromCart", $_SESSION["id"]);
                    ?>

                    <h3 id='order-sum'>
                        <span class='order-sum order-sum-cart'>suma</span>
                        <?= isset($_SESSION["suma_zamowienia"]) ? $_SESSION["suma_zamowienia"] : "0"; ?> PLN
                    </h3>

                    <button class="btn-link btn-link-static">
                        <a href="submit_order.php">Złóż zamówienie</a>
                    </button>

                    <?php
                        if (isset($_SESSION["order-error"])) {
                            echo '<p><strong>'.$_SESSION["order-error"].'</strong></p>';
                            unset($_SESSION["order-error"]);
                        }
                    ?>

                </div>

            </main>

        </div>

        <?php require "../view/footer.php"; ?>

    </div>

    <script src="../scripts/change_cart_quantity.js"></script>

    <?php require "../view/app-error-window.php"; ?>

</body>
</html>