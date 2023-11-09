<?php


    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";

    // PRG --> orders.php --> POST (order-id) --> order-details.php ;

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) { // isset($_POST)  ̶&̶&̶ ̶!̶ ̶e̶m̶p̶t̶y̶(̶$̶_̶P̶O̶S̶T̶)̶   GET / POST ...

        if (isset($_POST["order-id"]) && !empty($_POST["order-id"])) { // check if POST value (order-id) exists and is not empty;

            unset($_SESSION["change-status"]); // reset boolean flag;

            if (isset($_POST["change-status"]) && !empty($_POST["change-status"]) && $_POST["change-status"] === "true") { // orders.php -> "Zmień status"
                $_SESSION["change-status"] = true; // show update-status box (if there was second post parameter --> true);
            }

            // Process the form data and perform necessary validations ;

            $orderId = filter_var($_POST["order-id"], FILTER_SANITIZE_NUMBER_INT); // sanitize input - order-id ;
                // Sanitization -> remove all characters except digits, plus and minus sign.
                    // array_keys($_POST)[0] - order-id (id_zamówienia);
                    // "1135"

                // validate order-id - ✓ valid integer ;
            $_SESSION["order-id"] = filter_var($orderId, FILTER_VALIDATE_INT); // ✓ it ensures that the value is an integer - order-id ;

            // check if there is really an order with that id ;
            $_SESSION["order-exists"] = false;

            // check if there is really an order with that id (post - order-id);
            query("SELECT zm.id_zamowienia, zm.data_zlozenia_zamowienia, kl.imie, kl.nazwisko
                            FROM orders AS zm, customers AS kl
                         WHERE zm.id_klienta = kl.id_klienta AND zm.id_zamowienia = '%s'", "orderDetailsVerifyOrderExists", $_SESSION["order-id"]);
            // przestawi zmienną --> $_SESSION['order-exists'] na "true" - jeśli jest takie zamówienie (o takim id), jeśli num_rows > 0 ;

            if ($orderId === false || $_SESSION["order-id"] === false || $_SESSION["order-exists"] === false || ($_SESSION["order-id"] != $_POST["order-id"])) {
                // ✓ id-zamówienia (order-id) nie przeszło walidacji, LUB ✓ nie istnieje zamówienie o takim id; // invalid order-id OR order doesnt exist";
                // musi być komunikat o błędzie (np okienko) + exit() ! ;
                    // obsługa błędu - np przekierowanie na poprzednią stronę (orders.php) + wyświetlenie okienka z okmunikatem
                    // na stronie index.php można sprawdzić, czy np ustawiona wartość $_SESSION["error_costam"] ma wartosc true, i wtedy wyswietlic okienko
                        // $_SESSION["error"] = true ;

                $_SESSION["application-error"] = true;

                /*unset($_POST, $orderId, $_SESSION["order-id"], $_SESSION["order-exists"]);
                    header('Location: orders.php');
                        exit();*/

                unset($_SESSION["order-id"]);

            } else { // input is OK - order-id passed validation,    there is a order with that ID;
                //               Valid order-id           and           order exist
                // Execute code (such as database updates) here;
                // Perform any required actions with the form data (e.g., database update);

                //unset($_POST, $orderId, $_SESSION["order-exists"]); // keep $_SESSION["order-id"]
                    // redirect to the page itself
                    // header('Location: ___book.php', true, 303);

                unset($_POST, $orderId, $_SESSION["order-exists"]); // $_SESSION["order-id"] <--

                // Redirect to \order-details.php - prevent form resubmission
                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);  // $_SESSION["order-id"] <--
                    exit();
                // to prevent resubmitting the form
            }

            unset($_POST, $orderId, $_SESSION["order-exists"]);

        } else {
            // zmienna POST nie istnieje,   nastąpiło wejście pod http://localhost:8080/online_bookstore/admin/order-details.php bez podania wartości w POST[] ;
                //echo "<br> POST value (order-id) doesnt exist ! <br>" ;

            //echo "<br>70<br>"; exit();

            $_SESSION["application-error"] = true;
                /*header('Location: orders.php');
                    exit();*/
                            // $_SESSION["error"] = true ;
                            /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                            echo "GET ->"; print_r($_GET); echo "<hr><br>";
                            echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                            //exit();
        }

        header('Location: orders.php', true, 303);
            exit();


    } elseif ($_SERVER['REQUEST_METHOD'] === "GET" && (empty($_SESSION["order-id"]))) {

        $_SESSION["application-error"] = true;
            header('Location: orders.php', true, 303);
                exit();
    }

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
                    <h3 class="section-header">Szczegóły zamówienia</h3>
                </header>

                <?php
                    /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                ?>

                <h4 class="section-header order-details-header order-details-id">Zamówienie nr <span class="order-details-id"><?= $_SESSION["order-id"]; ?></h4>
                <h4 class="section-header order-details-header order-details-date"><?= $_SESSION["order-date"]; ?></h4>
                <h4 class="section-header order-details-header">Klient: <span class="order-details-id"><?= $_SESSION["client-name"], " ", $_SESSION["client-surname"] ?></span></h4>

                <?php require "../view/admin/order-details-header.php"; // first row, header of columns ?>

                <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && !empty($_SESSION["order-id"]) ) : ?>
                        <!-- prg -> orders.php -> POST - (order-id) -> order-details.php -->

                    <?php
                        query("SELECT zm.id_zamowienia,
                                      ks.tytul,
                                      au.imie, au.nazwisko,
                                      sz.ilosc, sz.id_ksiazki,
                                      ks.cena, ks.rok_wydania,
                                      pl.kwota, MIN(mgk.id_magazynu) AS id_magazynu
                               FROM books AS ks, payments AS pl, order_details AS sz, orders AS zm, author AS au, warehouse_books AS mgk
                               WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND ks.id_autora = au.id_autora AND ks.id_ksiazki = mgk.id_ksiazki AND zm.id_zamowienia = '%s'
                               GROUP BY zm.id_zamowienia, ks.tytul, au.imie, au.nazwisko, sz.ilosc, sz.id_ksiazki, ks.cena, ks.rok_wydania, pl.kwota",
                                    "getOrderDetailsAdmin", $_SESSION["order-id"]);
                        // (!) content of table;  $_SESSION["order_details_books_id"];
                        // template/admin/order-details.php
                        // szczegóły danego zamówienia;
                                           // (content) id_zamowienia,  tytul,   cena, ilosc, kwota;
                                           //               1121         php       5    10    327.75;

                        query("SELECT pl.kwota 
                               FROM payments AS pl, orders AS zm 
                               WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'",
                                "getOrderSumAdmin", $_SESSION["order-id"]);
                        // footer of table;
                        // kwota (suma) zamówienia; // "SUMA 279.3 PLN";

                        echo '<div id="order-det-container">';

                        query("SELECT pl.id_metody_platnosci, pl.data_platnosci, 
                                      zm.id_formy_dostawy, zm.status, fd.nazwa AS forma_dostarczenia, mp.nazwa AS metoda_platnosci
                               FROM orders AS zm, payments AS pl, delivery_methods AS fd, payment_methods AS mp
                               WHERE zm.id_zamowienia = pl.id_zamowienia AND 
                                     zm.id_formy_dostawy = fd.id_formy_dostawy AND
                                     pl.id_metody_platnosci = mp.id_metody_platnosci AND
                                     zm.id_zamowienia='%s'",
                               "getOrderSummary", $_SESSION["order-id"]);
                        // sposób_płatności, data_platnosci, forma_dostarczenia, dodaj_komentarz;
                    ?>

                    <div id="order-status">

                        <span>Status :</span>

                        <?php echo '<span class="order-status-name">' . $_SESSION["status"] . '</span>'; ?> <!-- <br> -->

                        <div id="order-details-status">

                            <?php if(isset($_SESSION["status"]) && !empty($_SESSION["status"]) && $_SESSION["status"] === "W trakcie realizacji") : ?>

                                <?php query("SELECT zm.termin_dostawy FROM orders AS zm WHERE zm.id_zamowienia='%s'", "showOrderStatusDate",  $_SESSION["order-id"]); ?>

                            <?php elseif(isset($_SESSION["status"]) && ! empty($_SESSION["status"]) && $_SESSION["status"] === "Wysłano") : ?>

                                <?php query("SELECT zm.termin_dostawy, zm.data_wysłania_zamowienia FROM orders AS zm WHERE zm.id_zamowienia='%s'", "showOrderStatusDate",  $_SESSION["order-id"]); ?>

                            <?php elseif(isset($_SESSION["status"]) && ! empty($_SESSION["status"]) && $_SESSION["status"] === "Dostarczono") : ?>

                                <?php query("SELECT zm.data_dostarczenia FROM orders AS zm WHERE zm.id_zamowienia='%s'", "showOrderStatusDate",  $_SESSION["order-id"]); ?>

                            <?php endif; ?>

                        </div>

                        <button class="update-order-status btn-link btn-link-static">Aktualizuj</button>

                    </div>

                    <!--</div>--> <!-- #content -->

                    <!--<div style="clear: both"></div>-->

                <?php endif; ?>

                <?php

                    // przed zastosowaniem prg -->
                        // $_SESSION["order-id"] = array_keys($_GET)[0]; // $_GET -> id_zamówienia - "1038";
                    // $_SESSION["order-id"] = array_keys($_POST)[0]; // PRG
                        /*  $array = array(
                                "name" => "John",
                                "age" => 30,
                                "city" => "New York",
                                "gender" => "Male"
                            );
                            $keys = array_keys($array);
                            print_r($keys);
                            // output -->
                            Array
                            (
                                [0] => name
                                [1] => age
                                [2] => city
                                [3] => gender
                            )
                        */
                        // var_dump($_SESSION);
                   /* query("SELECT zm.id_zamowienia, ks.tytul, ks.cena, sz.ilosc, pl.kwota FROM ksiazki AS ks, platnosci AS pl, szczegoly_zamowienia AS sz, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND zm.id_zamowienia = '%s'",
                        "get_order_details_admin", $_SESSION["order-id"]); // content of table;  $_SESSION['order_details_books_id'];
                                                                                // (content) id_zamowienia, tytul, cena, ilosc, kwota;
                    query("SELECT pl.kwota FROM platnosci AS pl, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'",
                        "get_order_sum_admin", $_SESSION["order-id"]); // footer of table;
                                                                           // kwota (suma) zamówienia;
                    echo '<div id="order-det-container">';
                    query("SELECT pl.sposob_platnosci, pl.data_platnosci, zm.forma_dostarczenia, zm.status FROM zamowienia AS zm, platnosci AS pl WHERE zm.id_zamowienia = pl.id_zamowienia AND zm.id_zamowienia='%s'",
                        "get_order_summary", $_SESSION["order-id"]); // sposób_płatności, data_platnosci, forma_dostarczenia, status;*/
                ?>

                <!--<div id="order-status">

                    <span>Status :</span>

                    <?php /*echo '<span class="order-status-name">' . $_SESSION["status"] . '</span>'; */?> <br>

                    <button class="update-order-status updateBtn-link updateBtn-link-static">Aktualizuj</button>

                </div>

                </div>

                <div style="clear: both"></div>-->

            </div> <!-- ✓ #order-det-container -->

            <!--<span style="color: lightskyblue; font-weight: normal;">dodać tutaj informacje o tym, czy wybrane produkty są dostępne w magazynie.</span>-->

            </div> <!-- ✓ #content -->

        </main>

    </div> <!-- ✓ #container -->

</div> <!-- ✓ #main-container -->

<div id="update-status" class="hidden"> <!-- okno zmiany statusu zamówienia -->

    <h2>Zmień status zamówienia</h2>

    <i class="icon-cancel"></i><hr>

    <h4 class="section-header-update-order status-title"><label for="status-list">Status:</label></h4>

    <select id="status-list">
        <option value="pending">Oczekujące na potwierdzenie</option>
        <option value="inProgress">W trakcie realizacji</option>
        <option value="shipped">Wysłano</option>
        <option value="delivered">Dostarczono</option>
    </select>

    <div class="delivery-date hidden">

        <form id="update-order-date" action="update-order-date.php" method="post">

            <label>
                <span class="order-label">Termin dostawy</span><input type="date" name="order-date">
            </label>
                <div style="clear: both;"></div>

            <label class="hidden">
                <span class="order-label">Data wysłania</span><input type="date" name="dispatch-date">
            </label>
                <div style="clear: both;"></div>

            <label class="hidden">
                <span class="order-label">Godzina wysłania</span><input type="time" name="dispatch-time" step="1">
            </label>
                <div style="clear: both;"></div>

            <label class="hidden">
                <span class="order-label">Data dostarczenia</span><input type="date" name="delivered-date">
            </label>
                <div style="clear: both;"></div>

                <span class="date-error">Podaj poprawną datę</span><div style="clear: both;"></div>

            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>

        </form>

        <button class="update-order-status cancel-order btn-link btn-link-static">Anuluj</button>

    </div> <!-- div . delivery-date -->

</div> <!-- div # update-status -->

<script>

</script>

<script src="order-date-jq.js"></script> <!-- obsługa i wysłanie żądania AJAX -->
<script src="../scripts/admin-order-details.js"></script>

<?php
    // to powinno być odkomentowane - ponieważ ta zmienna istnieje tylko wtedy - gdy udało się zaktualizować dane;
    // (jednak nie bo ajax nie odswieza strony);

    /* if(isset($_SESSION["update-successful"]) && $_SESSION["update-successful"] === false ) {
        unset($_SESSION["update-successful"]);
        echo '<script>finishUpdate();</script>';
    } */
?>

<?php
    //if(isset($_GET["status"]) && ($_GET["status"] == "true")) { // admin/orders - kliknięcie "Zmień status";
    if(isset($_SESSION["change-status"]) && ($_SESSION["change-status"] == true)) { // admin/orders - kliknięcie "Zmień status";
        //unset($_SESSION["change-status"]);
        echo '<script>toggleBox();</script>';
        //echo '<script>resetUrl();</script>'; // (aktualnie wyłączone z użycia - zakomentowana linia kodu wewnątrz funkcji)
    }
?>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">

<!-- // ------------------------------------------------------------------------------------------------------------ -->

<div class="update-status hidden" id="add-comment"> <!-- class -> update-status%s--> <!-- id_zamowienia -->

    <h2>Dodaj komentarz do zamówienia</h2>

    <i class="icon-cancel"></i><hr> <!-- icon-cancel%s - id_zamowienia -->

    <div class="delivery-date"> <!--  delivery-date%s - id_zamowienia -->

        <form class="add-order-comment" action="remove-order.php" method="post"> <!-- class zamienić na add-order-comment -->

            <input type="hidden" name="order-id" value="<?= $_SESSION["order-id"]; ?>"> <!-- order-id -->

            <span class="info">Dodaj komentarz do zamówienia</span>

            <textarea name="comment" id="comment" class="comment" onfocus="resetError(this)" minlength="10" maxlength="255"></textarea>
            <!-- maxlength="50" minlength="10" -->

            <span class="remove-order-error">Komentarz powinien zawierać od 10 do 255 znaków, oraz nie zawierać znaków specjalnych</span>
            <!-- add-order-comment-error -->
            <div style="clear: both;"></div>

            <button type="submit" class="update-order-status btn-link btn-link-static">Dodaj</button>

        </form>

        <button class="cancel-order update-order-status btn-link btn-link-static">Anuluj</button> <!-- cancel-order%s - id_zamowienia -->

    </div> <!-- .delivery-date -->

</div>

<script>
    // dodaj komentarz do zamówienia (okno) -->
    document.getElementById("add-order-comment").addEventListener("click", () => {
        let commentBox = document.getElementById("add-comment");
        commentBox.classList.remove("hidden");
    });
</script>

</body>
</html>