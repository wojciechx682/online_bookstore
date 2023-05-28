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

        <?php
            query("SELECT zm.id_zamowienia,
                            zm.data_zlozenia_zamowienia, 
                            kl.imie, kl.nazwisko,
                            pl.kwota, pl.sposob_platnosci,
                            zm.status 
                        FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                        WHERE zm.id_zamowienia = pl.id_zamowienia AND
                        zm.id_klienta = kl.id_klienta", "get_orders_boxes", ""); // remove order box; used another query because of the brightness effect - to be outside <div#all-container>
        ?>

<script>

    function resetError(textarea) {
        // archiwizowanie zamówienia - kliknięcie na <textarea> usuwa komunikat o błędzie;
        let spanError = textarea.nextElementSibling; // span z komunikatem o błędzie;
        if(spanError.style.display === "block") {
            spanError.style.display = "none";
        }
    }

    function finishArchive(textarea) {

    }

    document.addEventListener('keydown', function(event) {

        // kliknięcie "Esc" zamyka okno archiwizowania;

        let removeBoxes = document.querySelectorAll('.update-status'); // okienka Archiwizowania zamówienia;
        let allContainer = document.getElementById("all-container");

        for (let i = 0; i < removeBoxes.length; i++) { // dla każdego okienka;
            let removeBox = removeBoxes[i]; // perform actions on each element;

            if(!removeBox.classList.contains("hidden")) {
                if (event.key === 'Escape') {

                    removeBox.classList.toggle("hidden"); // zamknięcie okna;
                    allContainer.classList.toggle("bright");
                }
            }
        }
    });

</script>

    <script src="remove-order.js"></script>
    <!--<script src="test.js"></script>-->

</body>
</html>