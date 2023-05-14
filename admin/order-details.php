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

                        <h3 class="section-header">Szczegóły zamówienia</h3>

                        <?php require "../view/admin/order-details-header.php"; ?>

                        <?php
                            $_SESSION["order-id"] = array_keys($_GET)[0];

                            query("SELECT zm.id_zamowienia, ks.tytul, ks.cena, sz.ilosc, pl.kwota FROM ksiazki AS ks, platnosci AS pl, szczegoly_zamowienia AS sz, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND zm.id_zamowienia = '%s'", "get_order_details_admin", $_SESSION["order-id"]); // $_SESSION['order_details_books_id'];

                            query("SELECT pl.kwota FROM platnosci AS pl, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'", "get_order_sum_admin", $_SESSION["order-id"]);

                            echo '<div id="order-det-container">';

                            query("SELECT pl.sposob_platnosci, pl.data_platnosci, zm.forma_dostarczenia, zm.status FROM zamowienia AS zm, platnosci AS pl WHERE zm.id_zamowienia = pl.id_zamowienia AND zm.id_zamowienia='%s'", "get_order_summary", $_SESSION["order-id"]);

                        ?>

                        <div id="order-status">

                            <span>Status</span> <?= $_SESSION["status"] ?> <br>

                            <button class="update-order-status btn-link btn-link-static">Aktualizuj</button>

                        </div>

                        <div style="clear: both"></div>

                        <!-- </div> -->

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

        <div id="update-status" class="hidden">

            <h2>Zmień status zamówienia</h2>

            <i class="icon-cancel"></i><hr>

            <h4 class="section-header status-title"><label for="status-list">Status:</label></h4>

            <select id="status-list">
                <option>Oczekujące na potwierdzenie</option>
                <option>W trakcie realizacji</option>
                <option>Wysłano</option>
                <option>Dostarczono</option>
            </select>

            <div style="clear: both;"></div>

            <!--  form (?) -->

            <div class="delivery-date">

                <form id="update-order-date" action="update-order-date.php" method="post">
                    <label>Termin dostawy <input type="date" name="order-date"></label><div style="clear: both;"></div>
                    <span class="date-error">Podaj poprawną datę</span><div style="clear: both;"></div>
                    <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>
                </form>

                <button class="update-order-status cancel-order btn-link btn-link-static">Anuluj</button>
            </div>

        </div>

    <script>

        btn = document.querySelector('.update-order-status');        // "Aktualizuj" zmianę statusu
        let statusBox = document.getElementById("update-status");    // całe okiento zmiany statusu
        let allContainer = document.getElementById("all-container");

        btn.addEventListener("click", function() {
            toggleBox();
        });

        icon = document.querySelector('.icon-cancel');
        icon.addEventListener("click", function() {
            toggleBox();
        });

        cancelBtn = document.querySelector('.cancel-order');
        cancelBtn.addEventListener("click", function() {
            toggleBox();
        });

        function toggleBox() {
            statusBox.classList.toggle("hidden");
            allContainer.classList.toggle("bright");
        }

        dateInput = document.querySelector('form#update-order-date input[type="date"]'); // kliknięcie na datę usuwa kom. o błędzie

        dateInput.addEventListener("focus", function() {
            $("span.date-error").hide();
            $("div.delivery-date button").css('margin-top', '35px');
        });

        let list = document.getElementById("status-list"); // lista <select> - zmiana opcji wyboru;
        list.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex]; // get the <option> ELEMENT that was selected - after "change" event;
            const form = document.querySelector(".delivery-date");

            if(selectedOption.innerHTML === "W trakcie realizacji") {
                form.style.display = "block";
            } else if(selectedOption.innerHTML === "Wysłano") { // (!!!!!!!!!!!!!!!!!!!!!!)
                form.style.display = "block";

                const deliveryDate = document.createElement('input');
                deliveryDate.setAttribute('type', 'date');
                deliveryDate.setAttribute('name', 'delivery-date');
                //newInput.setAttribute('', 'Enter your new input here');

                form.appendChild(deliveryDate);

            } else {
                form.style.display = "none";
            }
        });

    </script>

    <!-- ukrycie formularza + buttona "Anuluj" - PO POMYŚLNYM ZREALIZOWANIU ZAPYTANIA TYPU UPDATE (!) -->

    <script>
        function finishUpdate() {
                console.log("\n212 finishedUpdate fun");
            const form = document.getElementById("update-order-date");
            const btn = document.querySelector(".cancel-order");
            form.style.display = "none";
            btn.style.display = "none";
        }
    </script>

    <script>

        // kliknięcie "Esc" zamyka okno zmiany statusu ->

        document.addEventListener('keydown', function(event) {
            let statusBox = document.getElementById("update-status"); // całe okieno zmiany statusu;
            if(!statusBox.classList.contains("hidden")) {
                if (event.key === 'Escape') {
                    console.log('Esc key pressed'); // add code here to perform an action when Esc key is pressed
                    toggleBox(); // zamknięcie okna;
                }
            }
        });

    </script>

    <script src="order-date-jq.js"></script>

    <?php
        /* !!! TO POWINNO BYĆ ODKOMENTOWANE ! - ponieważ ta zmienna istnieje TYLKO WTEDY - gdy udało się ZAKTUALIZOWAĆ DANE !!!!

        if(isset($_SESSION["update-successful"]) && $_SESSION["update-successful"] === true ) {
            unset($_SESSION["update-successful"]);
            echo '<script>finishUpdate();</script>';
        } */
    ?>

    </body>
</html>
