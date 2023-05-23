<?php
    session_start();
    include_once "../functions.php";

    if(!(isset($_SESSION['zalogowany']))) {
        header("Location: ../user/___index2.php?login-error");
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

                    <?php require "../view/admin/order-header.php"; // table header ?>

                    <?php
                        query("SELECT zm.id_zamowienia,
                                        zm.data_zlozenia_zamowienia, 
                                        kl.imie, kl.nazwisko,
                                        pl.kwota, pl.sposob_platnosci,
                                        zm.status 
                                    FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                                    WHERE zm.id_zamowienia = pl.id_zamowienia AND
                                    zm.id_klienta = kl.id_klienta", "get_all_orders", ""); // content of the table;
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

    <!--<div id="update-status" class="hidden">

        <h2>Archiwizuj zamówienie</h2>

        <i class="icon-cancel"></i><hr>-->

                                                                            <!--<h4 class="section-header status-title"><label for="status-list">Status:</label></h4>
                                                                            <select id="status-list">
                                                                                <option>Oczekujące na potwierdzenie</option>
                                                                                <option>W trakcie realizacji</option>
                                                                                <option>Wysłano</option>
                                                                                <option>Dostarczono</option>
                                                                            </select>
                                                                            <div style="clear: both;"></div>-->

                                                                            <!--  form (?) -->

        <!--<div class="delivery-date">

            <form id="remove-order" action="remove-order.php" method="post">-->
                                                                           <!-- <label>
                                                                                <span class="order-label">Termin dostawy</span><input type="date" name="order-date">
                                                                            </label>
                                                                            <div style="clear: both;"></div>
                                                                            <label>
                                                                                <span class="order-label">Data wysłania</span><input type="date" name="dispatch-date">
                                                                            </label>
                                                                            <div style="clear: both;"></div>
                                                                            <label>
                                                                                <span class="order-label">Dostarczono</span><input type="date" name="delivered-date">
                                                                            </label>
                                                                            <div style="clear: both;"></div>
                                                                            <span class="date-error">Podaj poprawną datę</span><div style="clear: both;"></div>-->
                                                                            <!--<input type-->

                <!--<span class="info">Dodaj komentarz wyjaściajacy powód zarchiwizowania zamówienia</span>
                <textarea name="comment" id="comment"  maxlength="50" minlength="10">
					</textarea>
                <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>
            </form>
            <button class="update-order-status cancel-order btn-link btn-link-static">Anuluj</button>
        </div>
    </div>-->
</body>
</html>