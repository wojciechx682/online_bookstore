<?php
    /*session_start();
        include_once "../functions.php";

    if( ! isset($_SESSION['zalogowany']) ) {
        header("Location: ../user/___index2.php?login-error");
            exit();
    }*/

    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

<!-- !!!!!!!! Zamówienia (orders) -> admin/orders.php --- POWINNY WYŚWEITLAĆ TYLKO TE ZAMÓWIENIA, KTÓRE SĄ PRZYPISANE DLA DANEGO PRACOWNIKA! -->

<body>

    <div id="main-container">

        <div id="container">

            <main>

                <?php require "../template/admin/nav.php"; ?>

                <?php require "../template/admin/top-nav.php"; ?>

                <div id="content">

                    <h3 class="section-header">Zamówienia</h3>

                    <?php require "../view/admin/order-header.php"; // table header; ?>

                    <?php
                        query("SELECT zm.id_zamowienia,
                                        zm.data_zlozenia_zamowienia, 
                                        kl.imie, kl.nazwisko,
                                        pl.kwota, pl.sposob_platnosci,
                                        zm.status 
                                    FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                                    WHERE zm.id_zamowienia = pl.id_zamowienia AND
                                    zm.id_klienta = kl.id_klienta", "get_all_orders", ""); // content of the table - wszystkie zamówienia złożone przez klientów;

                        // |1121| 2023-07-08 18:23:58 | Jakub | Wojciechowski | 327.75 | Blik     | Zarchiwizowane
                        // |1122| 2023-07-08 18:29:20 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
                        // |1123| 2023-07-08 18:29:42 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
                        // |1125| 2023-07-08 21:25:53 | Jakub | Wojciechowski | 128.3  | Blik     | Oczekujące na potwierdzenie
                        // |1126| 2023-07-08 22:25:13 | Adam  | Nowak         | 222.5  | Blik     | Dostarczono
                        // |1127| 2023-07-09 16:19:38 | Jakub | Wojciechowski | 377.5  | Blik     | Oczekujące na potwierdzenie
                        // |1128| 2023-07-09 21:33:59 | Jakub | Wojciechowski | 279.3  | Pobranie | Zarchiwizowane
                        // |1129| 2023-07-10 00:11:49 | Jakub | Wojciechowski | 700    | Blik     | Oczekujące na potwierdzenie
                        // |1130| 2023-07-14 03:00:56 | Jakub | Wojciechowski | 1695.5 | Blik     | Oczekujące na potwierdzenie
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

            require "../template/admin/orders-boxes.php";


        ?>

<script>

    function resetError(textarea) {                  // archiwizowanie zamówienia - kliknięcie (focus) na <textarea> usuwa komunikat o błędzie (jeśli był on widoczny);
        let spanError = textarea.nextElementSibling; // span z komunikatem o błędzie;
        if(spanError.style.display === "block") {
            spanError.style.display = "none";
        }
    }

    function finishArchive(textarea) {
        // (?)
    }

    document.addEventListener('keydown', function(event) {

        // kliknięcie "Esc" zamyka okno archiwizowania;
            // ~ można by to zrobić lepiej, tak aby pętla nie iterowała przez wszystie elementy (wszystkie zamówienia);

        //let removeBoxes = document.querySelectorAll('div.update-status'); // okienka Archiwizowania zamówienia;
        let removeBox = document.querySelector('div.update-status');        // okienka Archiwizowania zamówienia;
        let allContainer = document.getElementById("main-container");

        console.log("\n removeBox --> ", removeBox);

        if( ! removeBox.classList.contains("hidden") ) { // jeśli nie zawiera klasy hidden (tzn jest widoczny);

            if (event.key === 'Escape') {

                //resetRemoveBox();

                removeBox.classList.toggle("hidden"); // zamknięcie okna;
                allContainer.classList.toggle("bright");

                allContainer.removeAttribute("style");

            let textArea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
            resetError(textArea);

                //let successMsg = document.querySelector(".archive-success");
                //let successMsg = $("span.archive-success");
                let successMsg = removeBox.querySelector("span.archive-success");
                let errorMsg = removeBox.querySelector("span.update-failed");

                console.log("successMsg -> ", successMsg)

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

                console.log("confirmButton -> ", confirmButton);
                console.log("cancelButton -> ", cancelButton);

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

<script src="remove-order.js"></script> <!-- admin\remove-order.js -->

</body>
</html>