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

<style>
    /* (tymczasowo) */

    /*#center {
        width: 335px;
        height: 150px;
        border: 1px solid white;    font-weight: normal;    padding: 5px 12px;

        text-align: center;
        margin: 0 auto 0 auto;

        position: relative;
    }*/



</style>

<body>

<div id="all-container">

    <div id="container">

        <main>

            <?php require "../template/admin/nav.php"; ?>

            <?php require "../template/admin/top-nav.php"; ?>

            <div id="content">

                <h3 class="section-header">Szczegóły zamówienia</h3>

                <?php require "../view/admin/order-details-header.php"; // first row, header of columns ?>

                <?php
                    $_SESSION["order-id"] = array_keys($_GET)[0]; // $_GET -> id_zamówienia

                    // var_dump($_SESSION);

                    query("SELECT zm.id_zamowienia, ks.tytul, ks.cena, sz.ilosc, pl.kwota FROM ksiazki AS ks, platnosci AS pl, szczegoly_zamowienia AS sz, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND sz.id_zamowienia = zm.id_zamowienia AND sz.id_ksiazki = ks.id_ksiazki AND zm.id_zamowienia = '%s' ",
                        "get_order_details_admin", $_SESSION["order-id"]); // content of table; $_SESSION['order_details_books_id'];

                    query("SELECT pl.kwota FROM platnosci AS pl, zamowienia AS zm WHERE pl.id_zamowienia = zm.id_zamowienia AND zm.id_zamowienia = '%s'",
                        "get_order_sum_admin", $_SESSION["order-id"]); // footer of table;

                    echo '<div id="order-det-container">';

                    query("SELECT pl.sposob_platnosci, pl.data_platnosci, zm.forma_dostarczenia, zm.status FROM zamowienia AS zm, platnosci AS pl WHERE zm.id_zamowienia = pl.id_zamowienia AND zm.id_zamowienia='%s' ",
                        "get_order_summary", $_SESSION["order-id"]); // sposób płatności, data, forma;
                ?>

                <div id="order-status">

                    <span>Status: </span>

                    <?php echo '<span class="order-status-name">' . $_SESSION["status"] . '</span>'; ?> <br>

                    <button class="update-order-status btn-link btn-link-static">Aktualizuj</button>

                </div>

                <div style="clear: both"></div>

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

    <?php // require "../view/___footer.php"; ?>

</div>

<div id="update-status" class="hidden">

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

    <!--  form (?) -->

    <div class="delivery-date">

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
                <span class="order-label">Dostarczono</span><input type="date" name="delivered-date">
            </label>
            <div style="clear: both;"></div>

            <span class="date-error">Podaj poprawną datę</span><div style="clear: both;"></div>
            <button type="submit" class="update-order-status btn-link btn-link-static">Potwierdź</button>
        </form>

        <button class="update-order-status cancel-order btn-link btn-link-static">Anuluj</button>
    </div>

</div>

<script>

    btn = document.querySelector('button.update-order-status');  // button - "Aktualizuj" zmianę statusu;
    let statusBox = document.getElementById("update-status");    // całe okiento zmiany statusu;
    let allContainer = document.getElementById("all-container");
    icon = document.querySelector('.icon-cancel');
    cancelBtn = document.querySelector('.cancel-order');         // przycisk "Anuluj"

    btn.addEventListener("click", function() {
        toggleBox(); // pojawienie się okienka po kliknięciu przycisku "Aktualizuj"
    });

    icon.addEventListener("click", function() {
        toggleBox(); // zamknięcie okna po kliknięciu "x";
    });

    cancelBtn.addEventListener("click", function() {
        toggleBox(); // przycisk "Anuluj"
    });

    function toggleBox() {
        statusBox.classList.toggle("hidden");
        allContainer.classList.toggle("bright");
        resetBox();
    }

    function resetUrl() {
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
        //window.location.href = modifiedURL;
    }

    function resetBox() {
        // zresetowanie zawartości okna - po jego zamknięciu, (po tym jak udało się zrealizować zmianę statusu) ! -->
        let form = document.querySelector("#update-order-date");
        //form.style.display = "none";
        //form.classList.toggle("hidden");
        if(form.style.display === "none") {
            form.style.display = "block";
        }
        let cancelBtn = document.querySelector('.cancel-order');
        //cancelBtn.style.display = "none";
        //cancelBtn.classList.toggle("hidden");
        if(cancelBtn.style.display === "none") {
            cancelBtn.style.display = "block";
        }
        $('.update-success').remove();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // kliknięcie na datę usuwa kom. o błędzie;

    let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"]'); // querySelectorAll() is a method of the Document object that allows you to select multiple elements in the document based on a CSS selector;

    // dateInput = document.querySelector('form#update-order-date input[type="date"]');
    /* dateInput.addEventListener("focus", function() {
        $("span.date-error").hide();
        $("div.delivery-date button").css('margin-top', '35px');
    }); */

    // Loop through each input element;
    dateInputs.forEach(function(dateInput) {
        // Add the event listener to each input element;
        dateInput.addEventListener("focus", function() {
            // Perform your desired actions when the input is focused;
            $("span.date-error").hide();
            $("div.delivery-date button").css('margin-top', '35px'); // ?
        });
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    let list = document.getElementById("status-list"); // lista <select> - zmiana opcji wyboru;

    list.addEventListener("change", function() {

        resetBox();

        const selectedOption = this.options[this.selectedIndex]; // get the <option> ELEMENT that was selected - after "change" event;
        const form = document.querySelector(".delivery-date");   // div > form
        // const deliveryDate = document.createElement('input');

        const fDate = document.querySelector("form#update-order-date label:nth-of-type(1)"); // <label> - input - termin dostawy;
        const deliveryDate = document.querySelector("form#update-order-date label:nth-of-type(2)"); // <label> - input - data wysłania zamówienia;
        const delDate = document.querySelector("form#update-order-date label:nth-of-type(3)"); // <label> - input - data dostarczenia;
        const div = document.querySelector("div.delivery-date"); // div > form
        const btns = document.querySelectorAll("div.delivery-date button");

        form.style.display = "block"; // <div class="delivery-date">

        if(selectedOption.innerHTML === "W trakcie realizacji") {

            //form.style.display = "block"; // <div class="delivery-date">

            if(fDate.style.display === "none") { // termin dostawy
                fDate.style.display = "block";
            }

            if(deliveryDate.style.display === "block") { // data wysłania
                deliveryDate.style.display = "none";
            }

            if(delDate.style.display === "block") { // data dostarczenia
                delDate.style.display = "none";
            }

            if(div.style.paddingTop !== "20px") { // (?)
                div.style.paddingTop = "20px";
            }

            $('.update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj"
                $(element).css('margin-top', '35px');
            });

        } else if(selectedOption.innerHTML === "Wysłano") {

            //form.style.display = "block"; // termin dostawy

            // console.log("\ndeliveryDate => ", deliveryDate);

            deliveryDate.style.display = "block"; // data wysłania
            deliveryDate.style.marginBottom = "15px";

            div.style.paddingTop = "5px"; // div > form

            if(delDate.style.display === "block") { // data dostarczenia
                delDate.style.display = "none";
            }

            if(fDate.style.display === "none") { // termin dostawy;  <input type="date" ...>
                fDate.style.display = "block";
            }

            /*for(let i=0; i<btns.length; i++) {
                btn[i].style.marginTop = "50px";
            }*/
            /*$('.update-order-status').each(function(element) {
                $(element).css('margin-top', '50px'); // Set margin-top for each element
                console.log("183");
            });*/

            $('.update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj"
                $(element).css('margin-top', '50px');
            });

            /* $(document).ready(function() {
                $('.my-class').each(function(index, element) {
                    $(element).css('margin-top', index * 10); // Set margin-top for each element
                });
            }); */
            //btn.style.marginTop = "50px";
            /* deliveryDate.setAttribute('type', 'date');
            deliveryDate.setAttribute('name', 'delivery-date'); */
            // newInput.setAttribute('', 'Enter your new input here');
            // form.appendChild(deliveryDate);

        } else if (selectedOption.innerHTML === "Dostarczono") {

            // form.style.display = "block";
            fDate.style.display = "none"; // termin dostawy

            if(deliveryDate.style.display === "block") { // data wysłania;
                deliveryDate.style.display = "none";
            }

            delDate.style.display = "block"; // data dostarczenia

        } else {
            form.style.display = "none";
            deliveryDate.style.display = "none";
        }
    });

</script>



<script>

    // <!-- ukrycie formularza + buttona "Anuluj" - PO POMYŚLNYM ZREALIZOWANIU ZAPYTANIA TYPU UPDATE (!) -->

    function finishUpdate() {
        // console.log("\n212 finishedUpdate fun");
        const form = document.getElementById("update-order-date"); // ukrycie formularza
        const btn = document.querySelector(".cancel-order");       // ukrycie przycisku "Anuluj"
        form.style.display = "none";
        btn.style.display = "none";

        let list = document.getElementById("status-list");  // <select> list;
        let option = list.options[list.selectedIndex];      // get currently selected <option> element;
        $("span.order-status-name").text(option.innerHTML); // zmiana wyświetlanego statusu po jego zmianie;

        //toggleBox();
    }

    // kliknięcie "Esc" zamyka okno zmiany statusu --->

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
//!!! TO POWINNO BYĆ ODKOMENTOWANE ! - ponieważ ta zmienna istnieje TYLKO WTEDY - gdy udało się ZAKTUALIZOWAĆ DANE !!!!; (jednak nie bo AJAX nie odswieza strony)
/*if(isset($_SESSION["update-successful"]) && $_SESSION["update-successful"] === true ) {
    unset($_SESSION["update-successful"]);
    echo '<script>finishUpdate();</script>';
}*/
?>

<?php
if(isset($_GET["status"]) && ($_GET["status"] == "true")) {
    echo '<script>toggleBox();</script>';
    echo '<script>resetUrl();</script>';


}
?>

<img id="loading-icon" class="not-visible" src="../assets/loading-2-4-fast-update-status-date.gif" alt="loading-2">
<!-- class="not-visible" -->
</body>
</html>