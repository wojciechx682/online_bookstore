<?php
    require_once "../authenticate-admin.php";
    unset($_SESSION["order-id"], $_SESSION["order-date"], $_SESSION["client-name"], $_SESSION["client-surname"], $_SESSION["status"]);
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head-admin.php"; ?>

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

                    <?php
                            //require "../view/admin/order-header.php"; // table header; // ?
                        /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                    ?>

                    <?php
                        query("SELECT zm.id_zamowienia,
                                       zm.data_zlozenia_zamowienia,
                                       zm.status,
                                       kl.imie, kl.nazwisko,
                                       pl.kwota, mp.nazwa AS metoda_platnosci
                                FROM orders AS zm, customers AS kl, payments AS pl, payment_methods AS mp
                                WHERE zm.id_zamowienia = pl.id_zamowienia AND pl.id_metody_platnosci = mp.id_metody_platnosci AND zm.id_klienta = kl.id_klienta AND zm.id_pracownika = '%s'", "getAllOrders", $_SESSION["id"]);
                        // content of the table;
                        // wszystkie zamówienia złożone przez klientów - (przypisane do zalogowanego PRACOWNIKA);
                            // ..\template\admin\orders.php
                        // | 1121 | 2023-07-08 18:23:58 | Jakub | Wojciechowski | 327.75 | Blik     | Zarchiwizowane
                        // | 1123 | 2023-07-08 18:29:42 | Jakub | Wojciechowski | 222.5  | Pobranie | Oczekujące na potwierdzenie
                        // | 1125 | 2023-07-08 21:25:53 | Jakub | Wojciechowski | 128.3  | Blik     | Oczekujące na potwierdzenie
                        // | 1126 | 2023-07-08 22:25:13 | Adam  | Nowak         | 222.5  | Blik     | Dostarczono
                        // | 1127 | 2023-07-09 16:19:38 | Jakub | Wojciechowski | 377.5  | Blik     | Oczekujące na potwierdzenie
                        // | 1129 | 2023-07-10 00:11:49 | Jakub | Wojciechowski | 700    | Blik     | Oczekujące na potwierdzenie
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
                            zm.id_klienta = kl.id_klienta", "get_orders_boxes", "");
                // remove (archive) order box; used another query because of the brightness effect - to be outside <div#all-container>*/

            // zamiana na pojedyncze okno Archiwizowania zamówienia -->

            require "../template/admin/archive-order-box.php"; // order-box - okno archiwizowania zamówienia;
        ?>

<script>



</script>

    <img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<script src="remove-order.js"></script> <!-- AJAX - admin\remove-order.js -->
<script src="../scripts/admin-orders.js"></script> <!-- funkcje JS na stronie admin\orders.php - resetowanie okna Archiwizowania, -->

<script>

    /*window.addEventListener("load", () => {

        /!*let compare = {
            name: function(a, b) {
                if(a < b) {
                    return -1;
                } else {
                    return a > b ? 1 : 0;
                }
            }
        };*!/

        let isAscending = true;

        let orderRows = Array.from(document.querySelectorAll(".order-content")); // zamówienie - wiersz w tabeli;
        console.log("\n\n orderRows --> \n\n", orderRows);

        let client = document.querySelector('.order-client');
        console.log("\n\n client --> \n\n", client);

        client.addEventListener("click", function() {

            let sortOrder = this.dataset.sort; // Pobranie zawartości atrybutu data-sort

            console.log("\n\n sortOrder --> \n\n", sortOrder);

            orderRows.sort(function (a, b) {
                let clientA = $(a).find('.order-client').text().trim().toLowerCase();
                let clientB = $(b).find('.order-client').text().trim().toLowerCase();

                if (isAscending) {
                    return clientA.localeCompare(clientB);
                } else {
                    return clientB.localeCompare(clientA);
                }
            });

            isAscending = !isAscending;

            $('.order-content').remove();
            $(orderRows).insertAfter($('.order').last());
        });
    });*/

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // sortowanie zawartości (wierszy) - po kliknięciu nagłówka (pola)

    /*window.addEventListener("load", () => {

        let isAscending = true;

        let orderRows = Array.from(document.querySelectorAll(".order-content")); // wiersze z zamówieniami (rows)

        let headers = Array.from(document.querySelectorAll('[data-sort]'));

        headers.forEach(header => {
            header.addEventListener("click", function() {

                console.log("\n header --> ", header);

                $(header).siblings().find("i").remove();

                let icon = header.querySelector("i");

                if (!icon) {
                    icon = document.createElement("i");
                    icon.classList.add("icon-up-open-1");
                    header.appendChild(icon);
                } else if (icon.classList.contains("icon-down-open-1")) {
                    icon.classList.replace("icon-down-open-1", "icon-up-open-1");
                } else {
                    icon.classList.replace("icon-up-open-1", "icon-down-open-1");
                }


                let sortOrder = this.dataset.sort;

                orderRows.sort((a, b) => {
                    let valueA = $(a).find(`.${header.classList[0]}`).text().trim();
                    let valueB = $(b).find(`.${header.classList[0]}`).text().trim();

                    switch(sortOrder) {
                        case "string":
                            valueA = valueA.toLowerCase();
                            valueB = valueB.toLowerCase();
                            return isAscending ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
                        case "number":
                            return isAscending ? valueA - valueB : valueB - valueA;
                        case "date":
                            return isAscending ? new Date(valueA) - new Date(valueB) : new Date(valueB) - new Date(valueA);
                        case "currency":
                            valueA = parseFloat(valueA.replace(' PLN', ''));
                            valueB = parseFloat(valueB.replace(' PLN', ''));
                            return isAscending ? valueA - valueB : valueB - valueA;
                        default:
                            return 0;
                    }
                });

                isAscending = !isAscending;

                $('.order-content').remove();
                $(orderRows).insertAfter($('.order').last());
            });
        });
    });*/

    // Ten kod:

    // 1. Dodaje słuchacze zdarzeń do każdego nagłówka z atrybutem data-sort.
    // 2. Wybiera odpowiedni algorytm sortowania w zależności od wartości data-sort.
    // 3. Sortuje wiersze według wybranej kolumny i kierunku.
    // Możesz dostosować lub rozszerzyć funkcje sortujące w przypadku, gdybyś potrzebował innych typów sortowania lub gdybyś chciał wprowadzić jakieś specjalne zachowania dla konkretnych kolumn.
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>

<?php require "../view/app-error-window.php"; ?>

</body>
</html>