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

<!-- !!!!!!!! Zamówienia (orders) -> admin/orders.php --- POWINNY WYŚWEITLAĆ TYLKO TE ZAMÓWIENIA, KTÓRE SĄ PRZYPISANE DLA DANEGO PRACOWNIKA! -->

<body>

    <div id="all-container">

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
                    ?>

                </div> <!-- content -->

            </main>

        </div> <!-- container -->

    </div> <!-- all-container -->

        <?php
            query("SELECT zm.id_zamowienia,
                            zm.data_zlozenia_zamowienia, 
                            kl.imie, kl.nazwisko,
                            pl.kwota, pl.sposob_platnosci,
                            zm.status 
                        FROM zamowienia AS zm, klienci AS kl, platnosci AS pl 
                        WHERE zm.id_zamowienia = pl.id_zamowienia AND
                        zm.id_klienta = kl.id_klienta", "get_orders_boxes", "");
            // remove (archive) order box; used another query because of the brightness effect - to be outside <div#all-container>
        ?>

<script>

    function resetError(textarea) {                  // archiwizowanie zamówienia - kliknięcie na <textarea> usuwa komunikat o błędzie (jeśli był on widoczny);
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

        let removeBoxes = document.querySelectorAll('div.update-status'); // okienka Archiwizowania zamówienia;
        let allContainer = document.getElementById("all-container");

        for (let i = 0; i < removeBoxes.length; i++) { // dla każdego okienka;
            let removeBox = removeBoxes[i]; // perform actions on each element;
            if(!removeBox.classList.contains("hidden")) { // jeśli nie zawiera klasy hidden (tzn jest widoczny);
                if (event.key === 'Escape') {

                    //resetRemoveBox();

                    removeBox.classList.toggle("hidden"); // zamknięcie okna;
                    allContainer.classList.toggle("bright");

                    //let errorMsg = document.querySelector(".archive-success");
                    //let errorMsg = $("span.archive-success");
                    let errorMsg = removeBox.querySelector("span.archive-success");

                    console.log("errorMsg -> ", errorMsg)

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
        }
    });

</script>

<script src="remove-order.js"></script> <!-- admin\remove-order.js -->

</body>
</html>