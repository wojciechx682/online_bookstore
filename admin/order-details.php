<?php
    session_start();
    include_once "../functions.php";
    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: index.php?login-error"); // (?)
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

    <body>

        <?php
            /*echo "<div style='margin-left: 18px;'><br> hi admin <br></div>";
            echo "<div style='margin-left: 18px !important; margin-bottom: 15px; color: #002fad; font-weight: bold;'><i>";
                    echo var_dump($_SESSION);
                    echo "</i></div>";*/
        ?>

        <div id="all-container">

            <?php //require "../view/___header-container.php"; ?>

            <div id="container">

                <main>

                    <?php require "../template/admin/nav.php"; ?>

                    <?php require "../template/admin/top-nav.php"; ?>


                    <div id="content">

                        <h3 class="section-header">Szczegóły zamówienia</h3>

                        <?php require "../view/admin/order-details-header.php"; ?>  <!-- order header => ID, Data, Klient, ... -->

                        <?php

                        //var_dump($_GET);

                        $id = array_keys($_GET)[0]; // $_GET param => "987" (id_zamowienia)

                        query("SELECT zm.id_zamowienia, ks.tytul, ks.cena, sz.ilosc, pl.kwota FROM ksiazki AS ks, platnosci AS pl, szczegoly_zamowienia AS sz, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND zm.id_zamowienia = '%s'", "get_order_details_admin", $id); // --> $_SESSION['order_details_books_id'];

                        query("SELECT pl.kwota FROM platnosci AS pl, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'", "get_order_sum_admin", $id); // stopka (SUMA)

                        query("SELECT pl.sposob_platnosci, pl.data_platnosci, zm.forma_dostarczenia, zm.status FROM zamowienia AS zm, platnosci AS pl WHERE zm.id_zamowienia = pl.id_zamowienia AND zm.id_zamowienia='%s'", "get_order_summary", $id); // szczegółowe dane zamówienia
                        ?>



                    </div>

                </main>
            </div>

            <!--<footer>
                <div id="footer">
                    <script src="../scripts/set-theme.js"></script>
                    <pre>
                        <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
                    </pre>
                </div>
            </footer> -->

            <?php //require "../view/___footer.php"; ?>

        </div>

    </body>
</html>