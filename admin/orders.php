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

<?php require "../view/head-admin.php"; ?>

    <body>

        <div id="all-container">

            <div id="container">

                <main>

                    <?php require "../template/admin/nav.php"; ?>

                    <?php require "../template/admin/top-nav.php"; ?>

                    <div id="content">

                        <h3 class="section-header">Zamówienia</h3>

                        <?php require "../view/admin/order-header.php"; ?>
                        <!-- order header => ID, Data, Klient, ... -->

                        <?php
                            query("SELECT zm.id_zamowienia,
                                zm.data_zlozenia_zamowienia, 
                                kl.imie, kl.nazwisko,
                                pl.kwota, pl.sposob_platnosci,
                                zm.status 
                                FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                                WHERE zm.id_zamowienia = pl.id_zamowienia AND
                                zm.id_klienta = kl.id_klienta", "get_all_orders", "");
                        ?>

                    </div>

                </main>
            </div>

            <!-- <footer>
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