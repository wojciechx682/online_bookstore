<?php
    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<!-- ✓✓✓ Zamówienia (orders) -> admin/orders.php --- POWINNY WYŚWEITLAĆ TYLKO TE ZAMÓWIENIA, KTÓRE SĄ PRZYPISANE DLA DANEGO (zalogowanego) PRACOWNIKA! -->

<body>

    <div id="main-container">

        <div id="container">

            <main>

                <?php require "../template/admin/nav.php"; ?>

                <?php require "../template/admin/top-nav.php"; ?>

                <div id="content">

                    <header>
                        <h3 class="section-header">Zamówienia</h3>
                    </header>

                    <?php require "../view/admin/order-header.php"; // table header; ?>

                    <?php
                        query("SELECT zm.id_zamowienia,
                                            zm.data_zlozenia_zamowienia, 
                                            zm.status,
                                        kl.imie, kl.nazwisko,
                                        pl.kwota, pl.sposob_platnosci                                        
                                    FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                                    WHERE zm.id_zamowienia = pl.id_zamowienia AND
                                    zm.id_klienta = kl.id_klienta AND zm.id_pracownika = '%s'", "get_all_orders", $_SESSION["id"]); // content of the table;
                        // wszystkie zamówienia złożone przez klientów - (przypisane do zalogowanego pracownika) ;

                        // ..\template\admin\orders.php

                        // |1121| 2023-07-08 18:23:58 | Jakub | Wojciechowski | 327.75 | Blik     | Zarchiwizowane
                        // |1123| 2023-07-08 18:29:42 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
                        // |1125| 2023-07-08 21:25:53 | Jakub | Wojciechowski | 128.3  | Blik     | Oczekujące na potwierdzenie
                        // |1126| 2023-07-08 22:25:13 | Adam  | Nowak         | 222.5  | Blik     | Dostarczono
                        // |1127| 2023-07-09 16:19:38 | Jakub | Wojciechowski | 377.5  | Blik     | Oczekujące na potwierdzenie
                        // |1129| 2023-07-10 00:11:49 | Jakub | Wojciechowski | 700    | Blik     | Oczekujące na potwierdzenie

                    ?>

                </div> <!-- content -->

            </main>

        </div> <!-- container -->

    </div> <!-- main-container -->

        <?php
                /*query("SELECT zm.id_zamowienia,
                                zm.data_zlozenia_zamowienia, 
                                kl.imie, kl.nazwisko,
                                pl.kwota, pl.sposob_platnosci,
                                zm.status 
                            FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                            WHERE zm.id_zamowienia = pl.id_zamowienia AND
                            zm.id_klienta = kl.id_klienta", "get_orders_boxes", "");*/
                // remove (archive) order box; used another query because of the brightness effect - to be outside <div#all-container>


            // zamiana na pojedyncze okno Archiwizowania zamówienia -->

            require "../template/admin/archive-order-box.php"; // order-box - okno archiwizowania zamówienia

        ?>

<script>

    function resetError(textarea) {

        console.log("\n\n orders.php -> resetError() function was executed ! \n\n");

        // archiwizowanie zamówienia - kliknięcie (focus) na <textarea> usuwa komunikat o błędzie (jeśli był on widoczny);

        let spanError = textarea.nextElementSibling; // span z komunikatem o błędzie;
                                                        // "Opinia powinna zawierać od 10 do 255 znaków ..."
        if(spanError.style.display === "block") {    // jeśli komunikat jest widoczny
            spanError.style.display = "none";        // usuń komunikat
        }
    }

    /*function finishArchive(textarea) {
        // (?)
    }*/

    document.addEventListener('keydown', function(event) {

        console.log("\n\n orders.php -> Esc key was pressed ! \n\n");

        // kliknięcie "Esc" zamyka okno archiwizowania;

            // ~ ̶/̶/̶ ̶~̶ ̶m̶o̶ż̶n̶a̶ ̶b̶y̶ ̶t̶o̶ ̶z̶r̶o̶b̶i̶ć̶ ̶l̶e̶p̶i̶e̶j̶,̶ ̶t̶a̶k̶ ̶a̶b̶y̶ ̶p̶ę̶t̶l̶a̶ ̶n̶i̶e̶ ̶i̶t̶e̶r̶o̶w̶a̶ł̶a̶ ̶p̶r̶z̶e̶z̶ ̶w̶s̶z̶y̶s̶t̶i̶e̶ ̶e̶l̶e̶m̶e̶n̶t̶y̶ ̶(̶w̶s̶z̶y̶s̶t̶k̶i̶e̶ ̶z̶a̶m̶ó̶w̶i̶e̶n̶i̶a̶)̶;̶

            //let removeBoxes = document.querySelectorAll('div.update-status');
        let removeBox = document.querySelector('div.update-status');        // okienka Archiwizowania zamówienia;
        let mainContainer = document.getElementById("main-container");

        //console.log("\n removeBox --> ", removeBox);

        if(!removeBox.classList.contains("hidden")) { // jeśli nie zawiera klasy hidden (tzn jest widoczny);

            if (event.key === 'Escape') {

                //resetRemoveBox();

                removeBox.classList.toggle("hidden"); // zamknięcie okna;
                mainContainer.classList.toggle("bright");

                //mainContainer.removeAttribute("style");
                mainContainer.classList.toggle("unreachable");

                let textArea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
                resetError(textArea);

                    //let successMsg = document.querySelector(".archive-success");
                    //let successMsg = $("span.archive-success");
                let successMsg = removeBox.querySelector("span.archive-success"); // serwer zwraca te dane (remove-order.php);
                let errorMsg = removeBox.querySelector("span.update-failed");

                // console.log("successMsg -> ", successMsg)

                if(successMsg) {     // jeśli element istnieje w kodzie HTML (jeśli "istnieje");
                    successMsg.remove();
                }

                if(errorMsg) {     // jeśli element istnieje w kodzie HTML (jeśli "istnieje");
                    errorMsg.remove();
                }

                    //let confirmButton = $('form.remove-order button[type="submit"]');
                let confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
                    //let cancelButton = $('button.cancel-order');
                let cancelButton = removeBox.querySelector('button.cancel-order');
                    //let textarea = $('textarea[name="comment"]');
                let textarea = removeBox.querySelector('textarea[name="comment"]');

                    //console.log("confirmButton -> ", confirmButton);
                    //console.log("cancelButton -> ", cancelButton);

                    //confirmButton.css("display", "block");
                confirmButton.style.display = "initial";
                    //cancelButton.css("display", "block");
                cancelButton.style.display = "initial";
                    //textarea.val("");
                textarea.value = "";

            }
        }

        /*for (let i = 0; i < removeBoxes.length; i++) { // dla każdego okienka;
            let removeBox = removeBoxes[i]; // perform actions on each element;

        }*/
    });

</script>

    <img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="remove-order.js"></script> <!-- admin\remove-order.js -->


</body>
</html>