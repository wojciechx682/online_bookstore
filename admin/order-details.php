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
                        //var_dump($_SESSION);

                        $_SESSION["order-id"] = array_keys($_GET)[0]; // $_GET param => "987" (id_zamowienia)

                        query("SELECT zm.id_zamowienia, ks.tytul, ks.cena, sz.ilosc, pl.kwota FROM ksiazki AS ks, platnosci AS pl, szczegoly_zamowienia AS sz, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND zm.id_zamowienia = '%s'", "get_order_details_admin", $_SESSION["order-id"]); // --> $_SESSION['order_details_books_id'];

                        query("SELECT pl.kwota FROM platnosci AS pl, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'", "get_order_sum_admin", $_SESSION["order-id"]); // stopka (SUMA)

                        echo '<div id="order-det-container">';

                        query("SELECT pl.sposob_platnosci, pl.data_platnosci, zm.forma_dostarczenia, zm.status FROM zamowienia AS zm, platnosci AS pl WHERE zm.id_zamowienia = pl.id_zamowienia AND zm.id_zamowienia='%s'", "get_order_summary", $_SESSION["order-id"]); // szczegółowe dane zamówienia
                        ?>


                        <div id="order-status">

                            <span>Status</span> <?= $_SESSION["status"] ?> <br>

                            <button class="update-order-status btn-link btn-link-static">Aktualizuj</button>

                        </div>

                        <div style="clear: both"></div>




                        <!--</div>-->


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

        <div id="update-status" class="hidden">

            <h2>Zmień status zamówienia</h2>

            <i class="icon-cancel"></i>

            <hr>

            <h4 class="section-header status-title">Status</h4>

            <select id="status-list">
                <option value="oczekujace">Oczekujące na potwierdzenie</option>
                <option value="wtrakcie">W trakcie realizacji</option>
                <option value="wyslano">Wysłano</option>
                <option value="dostarczono">Dostarczono</option>
            </select>

            <div style="clear: both;"></div>

            <!-- --->

            <!--  form (?) -->

            <div class="delivery-date">

                <form id="update-order-date" action="update-order-date.php" method="post">

                    <label>Termin dostawy <input type="date" name="order-date"></label><div style="clear: both;"></div>

                    <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>

                </form>




                <!--<button class="update-order-status btn-link btn-link-static">Potwierdź</button>-->
                <button class="update-order-status cancel-order btn-link btn-link-static">Anuluj</button>
            </div>


        </div>

    <script>
        btn = document.querySelector('.update-order-status');

        let statusBox = document.getElementById("update-status");
        let allContainer = document.getElementById("all-container");

        btn.addEventListener("click", function() {
                //alert("yey ! ");
                //console.log("statusBox => ", statusBox);
            /*statusBox.classList.toggle("hidden");
            allContainer.classList.toggle("bright");*/
            toggleBox();
        });

        icon = document.querySelector('.icon-cancel');
        icon.addEventListener("click", function() {
           /* console.log("statusBox => ", statusBox);*/
            /*statusBox.classList.toggle("hidden");
            allContainer.classList.toggle("bright");*/
            toggleBox();
        });

        cancelBtn = document.querySelector('.cancel-order');

        cancelBtn.addEventListener("click", function() {
            console.log("cancelBtn => ", cancelBtn);
            toggleBox();
        });

        function toggleBox() {
            statusBox.classList.toggle("hidden");
            allContainer.classList.toggle("bright");
        }


    </script>

    <script>
        // lista <select> - zmiana opcji wyboru -->

        let list = document.getElementById("status-list");

        /*list.addEventListener("change", function(){
            alert("changed!");
        })*/

        list.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex]; // get the <option> element that was selected - after "change" event;
            console.log(selectedOption.innerHTML);

            const form = document.querySelector(".delivery-date");

            if(selectedOption.innerHTML === "W trakcie realizacji") {
                console.log("form => ", form);
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });



    </script>

    <script src="order-date-jq.js"></script>


    </body>
</html>