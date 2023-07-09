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

<style>
    /*.book-details {
        border: 1px solid blue;
    }
    .book-description {
        border: 1px solid pink;
    }*/

   /* form.change_quantity_form {
        border: 1px solid red;
    }*/
</style>

<body>

<div id="main-container">

<?php require "../view/___header-container.php"; ?>

	<div id="container">

        <main>

            <!-- <aside> <div id="nav"></div> </aside> -->

            <div id="content">

                <?php   /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr>"*/ ?>

                <h3 id="cart-header">Koszyk</h3>

                <?php

                    // (!) Problem implementacyjny - (do zrobienia) - Zmiana użycia formularza do wysyłania i zapisywania ilości książek w koszyku na użycie technologii AJAX - ponieważ przy zmienie ilości książek w koszyku następuje każdorazowo odświeżenie strony ;

                    // echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">&larr; Wróć </a>';

                    // $id = filter_var($_SESSION['id'], FILTER_SANITIZE_STRING); // id_klienta ;

                    query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, au.imie, au.nazwisko FROM klienci AS kl, koszyk AS ko, ksiazki AS ks, autor AS au WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND ks.id_autora = au.id_autora AND kl.id_klienta='%s'", "get_product_from_cart", $_SESSION['id']);
                                  // książki które zamówił klient o danym ID;
                                         //  220	1	5	Symfonia C++ wydanie V	65.55	2008	csymfoni_wyd_V.png	Jerzy	Grębosz
                                  // get_product_from_cart() --> $_SESSION['suma_zamowienia'] ;   "285.45" ;
                                     // \template\cart-products.php;


                    query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $_SESSION['id']);
                                // po to, aby przy zmianie ilości książek w koszyku aktualizowała się liczba w headerze przy "Koszyk (3)" ;
                                // count_cart_quantity() --> $_SESSION['koszyk_ilosc_ksiazek'] ;  "4" ;

                    echo "<h3 id='order-sum'>
                            <span class='order-sum order-sum-cart'>suma</span>" . $_SESSION["suma_zamowienia"] . " PLN 
                      </h3>";
                                   // get_product_from_cart () --> $_SESSION["suma_zamowienia"] ;
                ?>

                <button class="btn-link btn-link-static">
                    <a href="___submit_order.php">Złóż zamówienie</a>
                </button>

                <?php
                    if( isset($_SESSION["quantity-error"]) ) {  // submit_order -> no products in cart;
                            unset($_SESSION["quantity-error"]);
                        echo "<p><strong>Aby złożyć zamówienie, dodaj książki do koszyka</strong></p>";
                    }
                ?>


                <!-- <br><a href="submit_order.php">Złóż zamówienie</a> -->

            </div> <!-- #content -->

        </main>

	</div> <!-- #container -->

    <script>
        content = document.getElementById("content");
        content.style.width = "100%";
    </script>

    <?php require "../view/footer.php"; ?>

<!-- <script src="../scripts/set-span-width.js"></script>-->

</body>
</html>