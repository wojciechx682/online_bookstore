<?php


    // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;
    require_once "../authenticate-admin.php";

    // PRG --> orders.php --> POST (order-id) --> order-details.php ;

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) { // isset($_POST)  ̶&̶&̶ ̶!̶ ̶e̶m̶p̶t̶y̶(̶$̶_̶P̶O̶S̶T̶)̶   GET / POST ...

        if (isset($_POST["order-id"]) && !empty($_POST["order-id"])) { // check if POST value (order-id) exists and is not empty;

            //unset($_SESSION["change-status"]); // reset boolean flag;

            if (isset($_POST["change-status"])) && ! empty(array_keys($_POST)[1]) && array_keys($_POST)[1]) { // orders.php -> "Zmień status"

                $_SESSION["change-status"] = true; // show update-status box (if there was second post parameter --> true);
            }

            // Process the form data and perform necessary validations ;

                // sanitize input - order-id ;
            $orderId = filter_var(array_keys($_POST)[0], FILTER_SANITIZE_NUMBER_INT);
                // Sanitization -> remove all characters except digits, plus and minus sign.
                    // array_keys($_POST)[0] - order-id (id_zamówienia);
                    // "1135"

                // validate order-id - ✓ valid integer ;
            $_SESSION["order-id"] = filter_var($orderId, FILTER_VALIDATE_INT); // ✓ it ensures that the value is an integer - order-id ;

            // check if there is really a order with that id ;
            $_SESSION['order-exists'] = false;

            // check if there is really an order with that id (post - order-id);
            query("SELECT zm.id_zamowienia, zm.data_zlozenia_zamowienia, kl.imie, kl.nazwisko
                            FROM zamowienia AS zm, klienci AS kl
                         WHERE zm.id_klienta = kl.id_klienta AND zm.id_zamowienia = '%s'", "orderDetailsVerifyOrderExists", $_SESSION["order-id"]);
            // przestawi zmienną - $_SESSION['order-exists'] na "true" - jeśli jest takie zamówienie (o takim id), jeśli num_rows > 0 ;

            if ($orderId === false || $_SESSION["order-id"] === false || $_SESSION["order-exists"] === false || ($_SESSION["order-id"] !== array_keys($_POST)[0]) ) {
                    // tutaj trzeba odpowiednio obsłużyć błąd ;
                // ✓ id-zamówienia (order-id) nie przeszło walidacji, LUB ✓ nie istnieje zamówienie o takim id;
                    // musi być komunikat o błędzie (np okienko) + exit() ! ;
                //echo "<br><hr> 43 invalid order-id OR order doesnt exist ! <br><hr>";
                // obsługa błędu - np przekierowanie na poprzednią stronę (orders.php) + wyświetlenie okienka z okmunikatem
                // na stronie index.php można sprawdzić, czy np ustawiona wartość $_SESSION["error_costam"] ma wartosc true, i wtedy wyswietlic okienko
                    // $_SESSION["error"] = true ;
                unset($_POST, $orderId, $_SESSION["order-id"], $_SESSION['order-exists']);
                        /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                header('Location: orders.php'); exit();

            } else { // input is OK - order-id passed validation,    there is a order with that ID;
                //               Valid order-id           and           order exist
                // Execute code (such as database updates) here;
                // Perform any required actions with the form data (e.g., database update)

                // ✓✓✓ valid book-id, book exist in db;
                    //echo "\n 49 SESSION order-id -> " . $_SESSION["order-id"];
                    //echo "<br> 51 Valid order-id and order exist ! <br><hr>"; exit();
                unset($_POST, $orderId, $_SESSION["order-exists"]);
                // redirect to the page itself
                //header('Location: ___book.php', true, 303);

                // Redirect to prevent form resubmission
                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); exit();
                // to prevent resubmitting the form
            }

        } else {
            // zmienna POST nie istnieje,   nastąpiło wejście pod http://localhost:8080/online_bookstore/admin/order-details.php bez podania wartości w POST[] ;
                //echo "<br> POST value (order-id) doesnt exist ! <br>" ;
            header('Location: orders.php'); exit();
                // $_SESSION["error"] = true ;
                /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                //exit();
        }
                /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/

    } elseif (
        $_SERVER['REQUEST_METHOD'] === "GET" && ( ! isset($_SESSION["order-id"]) || empty($_SESSION["order-id"]) )
    ) {
        header('Location: orders.php'); exit();
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

                <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_SESSION["order-id"]) ) : ?>
                        <!-- prg -> orders.php -> POST - (order-id) -> order-details.php -->

                    <?php
                        query("SELECT zm.id_zamowienia, 
                                            ks.tytul, 
                                            au.imie, au.nazwisko,
                                            sz.ilosc, sz.id_ksiazki,
                                            ks.cena, ks.rok_wydania,                                       
                                            pl.kwota 
                                     FROM ksiazki AS ks, platnosci AS pl, szczegoly_zamowienia AS sz, zamowienia AS zm,
                                          autor AS au
                                     WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND ks.id_autora = au.id_autora AND zm.id_zamowienia = '%s'",
                                    "getOrderDetailsAdmin", $_SESSION["order-id"]);
                        // content of table;  $_SESSION['order_details_books_id'];
                        // szczegóły danego zamówienia;
                                           // (content) id_zamowienia,  tytul,   cena, ilosc, kwota;
                                               //  1121   Symfonia C++ wydanie V   5     10   327.75

                        query("SELECT pl.kwota 
                                     FROM platnosci AS pl, zamowienia AS zm 
                                     WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'",
                                    "getOrderSumAdmin", $_SESSION["order-id"]);
                        // footer of table;
                            // kwota (suma) zamówienia; // "SUMA 279.3 PLN";

                        echo '<div id="order-det-container">';

                        query("SELECT pl.id_metody_platnosci, pl.data_platnosci, 
                                      zm.id_formy_dostawy, zm.status, fd.nazwa AS forma_dostarczenia, mp.nazwa AS metoda_platnosci
                               FROM zamowienia AS zm, platnosci AS pl, formy_dostawy AS fd, metody_platnosci AS mp
                               WHERE zm.id_zamowienia = pl.id_zamowienia AND 
                                     zm.id_formy_dostawy = fd.id_formy_dostawy AND
                                     pl.id_metody_platnosci = mp.id_metody_platnosci AND
                                     zm.id_zamowienia='%s'",
                               "getOrderSummary", $_SESSION["order-id"]);

                        // sposób_płatności, data_platnosci, forma_dostarczenia, status;
                    ?>




                    <div id="order-status">

                        <span>Status :</span>

                        <?php echo '<span class="order-status-name">' . $_SESSION["status"] . '</span>'; ?> <!-- <br> -->

                        <div id="order-details-status">

                            <?php if(isset($_SESSION["status"]) && ! empty($_SESSION["status"]) && $_SESSION["status"] === "W trakcie realizacji") : ?>

                                <?php query("SELECT zm.termin_dostawy FROM zamowienia AS zm WHERE zm.id_zamowienia='%s'", "showOrderStatusDate",  $_SESSION["order-id"]); ?>

                            <?php elseif(isset($_SESSION["status"]) && ! empty($_SESSION["status"]) && $_SESSION["status"] === "Wysłano") : ?>

                                <?php query("SELECT zm.termin_dostawy, zm.data_wysłania_zamowienia FROM zamowienia AS zm WHERE zm.id_zamowienia='%s'", "showOrderStatusDate",  $_SESSION["order-id"]); ?>

                            <?php elseif(isset($_SESSION["status"]) && ! empty($_SESSION["status"]) && $_SESSION["status"] === "Dostarczono") : ?>

                                <?php query("SELECT zm.data_dostarczenia FROM zamowienia AS zm WHERE zm.id_zamowienia='%s'", "showOrderStatusDate",  $_SESSION["order-id"]); ?>

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
<span style="color: lightskyblue; font-weight: normal;">dodać tutaj informacje o tym, czy wybrane produkty są dostępne w magazynie.</span>
            </div> <!-- ✓ #content -->

        </main>

    </div> <!-- ✓ #container -->

</div> <!-- ✓ #main-container -->

<div id="update-status" class="hidden"> <!-- okno zmiany statusu zamówienia -->

    <h2>Zmień status zamówienia</h2>

    <i class="icon-cancel"></i><hr>

    <h4 class="section-header-update-order status-title"><label for="status-list">Status:</label></h4>

    <select id="status-list">
        <option>Oczekujące na potwierdzenie</option>
        <option>W trakcie realizacji</option>
        <option>Wysłano</option>
        <option>Dostarczono</option>
    </select>

    <div style="clear: both;"></div>

    <div class="delivery-date hidden">

        <form id="update-order-date" action="update-order-date.php" method="post">

            <label>
                <span class="order-label">Termin dostawy</span><input type="date" name="order-date">
            </label>
                <div style="clear: both;"></div>

            <label>
                <span class="order-label">Data wysłania</span><input type="date" name="dispatch-date">
            </label>
                <div style="clear: both;"></div>

            <label>
                <span class="order-label">Godzina wysłania</span><input type="time" name="dispatch-time" step="1">
            </label>
            <div style="clear: both;"></div>



            <label>
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

    let updateBtn = document.querySelector('button.update-order-status');  // button - "Aktualizuj" zmianę statusu
        console.log("\nupdateBtn --> ", updateBtn);

    let statusBox = document.getElementById("update-status");    // okiento zmiany statusu; div #update-status . hidden;
    let mainContainer = document.getElementById("main-container");
    let icon = document.querySelector('.icon-cancel');               // <i class="icon-cancel">
    let cancelBtn = document.querySelector('.cancel-order');         // przycisk "Anuluj"; button.cancel-order;

    console.log("\nstatusBox #update-status --> ", statusBox);
    console.log("\nmainContainer --> ", mainContainer);
    console.log("\nicon --> ", icon);
    console.log("\ncancelBtn --> ", cancelBtn);

            /* /!* v1 --> *!/ updateBtn.addEventListener("click", function() {
                toggleBox(); // pojawienie się okienka po kliknięciu przycisku "Aktualizuj";  <div id="update-status">;
                             // toggle class="hidden"; + resetBox();
            });
            icon.addEventListener("click", function() {
                toggleBox(); // zamknięcie okna po kliknięciu "x";
            });
            cancelBtn.addEventListener("click", function() {
                toggleBox(); // przycisk "Anuluj";
            });*/

    /* /!* v2 --> *!/ updateBtn.addEventListener("click", toggleBox);
    icon.addEventListener("click", toggleBox);
    cancelBtn.addEventListener("click", toggleBox);*/

    let buttons = [updateBtn, icon, cancelBtn];
    //             Aktualizuj  "X"   "Anuluj"

    /*for(let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", toggleBox);
    }*/

    buttons.forEach(function(button) {
        button.addEventListener("click", toggleBox);
    });

    function toggleBox() {
        // after clicking the button --> Aktualizuj  "X"   "Anuluj"
        statusBox.classList.toggle("hidden");
            // przełączenie widoczności okna;
            mainContainer.classList.toggle("bright");
                mainContainer.classList.toggle("unreachable");
        resetBox(); // po pomyślnej zmianie statusu - "Udało się zmienić ..."
    }

    // po kliknięciu dowolnego przycisku z tablicy `buttons` (zakładając, że tablica została poprawnie wypełniona elementami przycisków), zostanie wywołana funkcja `toggleBox`. Ta funkcja przełącza widoczność elementu `statusBox`, zmienia wygląd `mainContainer` i potencjalnie wykonuje dodatkowe działania, jeśli `resetBox` jest zdefiniowane i wywołane w ramach funkcji.

   /* function resetUrl() {
        // Get the current URL without the query parameters
        // let urlWithoutParams = window.location.href.split('?')[0];
        // Replace the current URL without query parameters in the browser's history
        // window.history.replaceState({}, document.title, urlWithoutParams);

        // Get the current URL
        var url = new URL(window.location.href);
        //var url = JSON.parse(window.location.href);
        // Create a URLSearchParams object from the URL's search parameters
        var searchParams = new URLSearchParams(url.search);
        // Remove the specific parameter
        searchParams.delete('status');
        // Replace the current URL's search parameters with the updated ones
        url.search = searchParams.toString();
        // Get the modified URL without the specified parameter
        var modifiedURL = url.toString();
        console.log("\n modifiedURL -> ", modifiedURL);
        //window.location.href = modifiedURL; // ta linia zmienia URL na taki, aby nie wyskakiwało okno zmiany statusu po odświeżeniu;
                                              // można to przenieść (?) gdzie indziej, np po kliknięciu (zamknięciu) okna zmiany statusu - tak aby po odświeżeniu storny nie pojawiało się ono ponownie;
    }
*/
    function resetBox() {
        // after clicking the button --> Aktualizuj  "X"   "Anuluj"
            // when changing status was succesfull - "Udało się zmienić ..."
        let form = document.getElementById("update-order-date");
        // zresetowanie zawartości okna - po jego zamknięciu;
        if(form.style.display === "none") {
            form.style.display = "block";
        }
        let cancelBtn = document.querySelector('.cancel-order'); // "Anuluj";
        if(cancelBtn.style.display === "none") {
            cancelBtn.style.display = "block";
        }
        $('.update-success').remove(); // "Udało się zmienić status zamówienia";
            $("span.date-error").hide(); // "Podaj poprawną datę"
                $("span.update-failed").remove(); // "Wystąpił problem. Nie udało się zmienić statusu zamówienia"

        resetDateInputs();
    }

    function resetDateInputs() {
        let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"]');
        dateInputs.forEach(function(dateInput) { // zmiana elementu listy wyboru resetuje zawartość inputów typu date;
            dateInput.value = "";
        });
    }

    // -----------------------------------------------------------------------------------------------------------------
    // kliknięcie na datę usuwa kom. o błędzie;

    let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"]'); // querySelectorAll() is a method of the Document object that allows you to select multiple elements in the document based on a CSS selector;

    dateInputs.forEach(function(dateInput) { // loop through each input element;
        dateInput.addEventListener("focus", function() { // add the event listener to each input element;
            $("span.date-error").hide(); // perform your desired actions when the input is focused;
                //$("div.delivery-date button").css('margin-top', '70px'); // (?)
        });
    });

    // -----------------------------------------------------------------------------------------------------------------

    let list = document.getElementById("status-list"); // lista <select> - zmiana opcji wyboru;

    list.addEventListener("change", function() {

        $("span.date-error").hide();

        resetDateInputs();

        //resetBox();

        const selectedOption = this.options[this.selectedIndex]; // <option> ELEMENT that was selected - after "change" event;
        const deliveryDate = document.querySelector(".delivery-date"); // div class="delivery-date" --> form id="update-order-date";

        const expDeliveryDate = document.querySelector("form#update-order-date label:nth-of-type(1)"); // <label> - input - termin_dostawy;
        const sentDate = document.querySelector("form#update-order-date label:nth-of-type(2)"); // <label> - input - data_wysłania_zamówienia;
        const sentTime = document.querySelector("form#update-order-date label:nth-of-type(3)"); // <label> - input - data_dostarczenia;
        const dateDelivered = document.querySelector("form#update-order-date label:nth-of-type(4)"); // <label> - input - data_dostarczenia;
            // const div = document.querySelector("div.delivery-date"); // div > form
            // const btns = document.querySelectorAll("div.delivery-date button");
        const dateError = document.querySelector('span.date-error');

        console.log("\nsentTime --> \n", sentTime);

        //deliveryDate.style.display = "block"; // <div class="delivery-date">
        deliveryDate.classList.toggle("hidden", false);

        if(selectedOption.innerHTML === "W trakcie realizacji") {

            //form.style.display = "block"; // <div class="delivery-date">

            dateError.style.marginTop = "-2px";

                    if(expDeliveryDate.style.display === "none") { // termin_dostawy
                        expDeliveryDate.style.display = "block";
                    }

                    if(sentDate.style.display === "block") { // data_wysłania_zamowienia
                        sentDate.style.display = "none";
                    }
                    if(sentTime.style.display === "block") {
                        sentTime.style.display = "none";
                    }
                    if(dateDelivered.style.display === "block") { // data_dostarczenia
                        dateDelivered.style.display = "none";
                    }

                    if(deliveryDate.style.paddingTop !== "20px") { // (?)
                        deliveryDate.style.paddingTop = "20px";
                    }

            $('div#update-status .update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj", (!)
                $(element).css('margin-top', '90px');
            });

        } else if (selectedOption.innerHTML === "Wysłano") {

            dateError.style.marginTop = "20px";

            // form.style.display = "block"; // termin dostawy
            // console.log("\ndeliveryDate => ", deliveryDate);

            sentDate.style.display = "block"; // data_wysłania
            sentDate.style.marginBottom = "20px"; // (!)

            deliveryDate.style.paddingTop = "20px"; // div.delivery-date --> form

            if(dateDelivered.style.display === "block") { // data_dostarczenia
                dateDelivered.style.display = "none";
            }

            if(expDeliveryDate.style.display === "none") { // termin dostawy;  <input type="date" ...>
                expDeliveryDate.style.display = "block";
            }
            sentTime.style.display = "block";

/*for(let i=0; i<btns.length; i++) {
updateBtn[i].style.marginTop = "50px";
}*/
/*$('.update-order-status').each(function(element) {
$(element).css('margin-top', '50px'); // Set margin-top for each element
console.log("183");
});*/

            $('div#update-status .update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj", (!) X "Aktualizuj";
                $(element).css('margin-top', '60px');
            });

/* $(document).ready(function() {
$('.my-class').each(function(index, element) {
$(element).css('margin-top', index * 10); // Set margin-top for each element
});
}); */
//updateBtn.style.marginTop = "50px";
/* deliveryDate.setAttribute('type', 'date');
deliveryDate.setAttribute('name', 'delivery-date'); */
// newInput.setAttribute('', 'Enter your new input here');
// form.appendChild(deliveryDate);

        } else if (selectedOption.innerHTML === "Dostarczono") {

            dateError.style.marginTop = "-2px";

            // form.style.display = "block";

            expDeliveryDate.style.display = "none"; // termin_dostawy

            if(sentDate.style.display === "block") { // data_wysłania;
                sentDate.style.display = "none";
            }
            if(sentTime.style.display === "block") { // data_wysłania;
                sentTime.style.display = "none";
            }

            dateDelivered.style.display = "block"; // data_dostarczenia;

            if(deliveryDate.style.paddingTop !== "20px") { // (?)
                deliveryDate.style.paddingTop = "20px";
            }

            $('div#update-status .update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj", (!) "Aktualizuj";
                $(element).css('margin-top', '95px');
            });

        } else {
            //deliveryDate.style.display = "none";
            deliveryDate.classList.toggle("hidden", true);
            sentDate.style.display = "none";
        }
    });

</script>

<script>

    function finishUpdate() {
        // ukrycie formularza + buttona "Anuluj" - po pomyślnym zrealizowaniu zapytania typu update (.done(), .fail());
        const form = document.getElementById("update-order-date"); // ukrycie formularza (zawiera przycisk "Potwierdź") - <form #update-order-date>
        const btn = document.querySelector(".cancel-order");       // ukrycie przycisku "Anuluj"
        form.style.display = "none";
        btn.style.display = "none";

        let list = document.getElementById("status-list");  // <select> list;
        let option = list.options[list.selectedIndex];      // currently selected <option> element;
        $("span.order-status-name").text(option.innerHTML); // zmiana wyświetlanego statusu po jego zmianie;
    }

    // kliknięcie "Esc" zamyka okno zmiany statusu;

    document.addEventListener('keydown', function(event) {
        let statusBox = document.getElementById("update-status"); // całe okieno zmiany statusu; <div id="update-status">
        if(!statusBox.classList.contains("hidden")) { // jeśli element jest widoczny;
            if (event.key === 'Escape') {
                //console.log('Esc key pressed'); // add code here to perform an action when Esc key is pressed
                toggleBox(); // zamknięcie okna;
            }
        }
    });

</script>

<script src="order-date-jq.js"></script> <!-- obsługa i wysłanie żądania AJAX -->

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