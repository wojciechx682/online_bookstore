<?php

    // (!) dodać zabezpieczenie przed ponownym przesłaniem formularza (PRG !);

    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
    require_once "../authenticate-user.php";

echo "<br>"; echo "POST ->"; var_dump($_POST); echo "<hr><br>";
echo "GET ->"; var_dump($_GET); echo "<hr><br>";
echo "SESSION ->"; var_dump($_SESSION); echo "<hr><br>";

    if ( isset($_POST["delivery-type"]) && !empty($_POST["delivery-type"]) &&
         isset($_POST["payment-method"]) && !empty($_POST["payment-method"]) ) {

        // validate and sanitize user input;
        $deliveryType = filter_input(INPUT_POST, "delivery-type", FILTER_SANITIZE_STRING);
        $paymentMethod = filter_input(INPUT_POST, "payment-method", FILTER_SANITIZE_STRING);

        //$deliveryTypes = ["Kurier DPD", "Kurier Inpost", "Paczkomaty 24/7 (Inpost)", "Odbiór w punkcie (Poczta polska)", "Odbiór w sklepie (Księgarnia)"]; // --> $_SESSION["delivery-types"]
        //$paymentMethods = ["Blik", "Pobranie", "Karta płatnicza (online)"]; // --> $_SESSION["payment-methods"]

        if ( empty($deliveryType) || ($deliveryType !== $_POST["delivery-type"]) || !array_key_exists($_POST["delivery-type"], $_SESSION["delivery-types"]) ) {

            $_SESSION["order-error"] = "Podaj poprawną formę dostawy";

        } elseif ( empty($paymentMethod) || ($paymentMethod !== $_POST["payment-method"]) || !array_key_exists($_POST["payment-method"], $_SESSION["payment-methods"]) ) {

            $_SESSION["order-error"] = "Podaj poprawną formę płatności";

        } elseif ( !isset($_SESSION["koszyk_ilosc_ksiazek"]) || $_SESSION["koszyk_ilosc_ksiazek"] === 0) {

            $_SESSION["order-error"] = "Aby złożyć zamówienie, dodaj książki do koszyka";
        }

        if ( isset($_SESSION["order-error"]) && !empty($_SESSION["order-error"]) ) {

            header('Location: ___submit_order.php', true, 303); exit();
        }

        $datetime = new DateTimeImmutable(); // current date and time
                                             // object of DateTimeImmutable class;
                                             // values of the object "$datetime" cannot be changed
                                             // calling methods on the DateTimeImmutable object (e.g. add)
                                             // - will not change its value (original variable) - unlike DateTime.

                                             // print_r($datetime); exit();
                                             // DateTimeImmutable Object
                                             // (
                                             //     [date] => 2023-07-05 17:52:19.834668
                                             //     [timezone_type] => 3
                                             //     [timezone] => Europe/Berlin
                                             // )
                                             // $date = $datetime->format('Y-m-d H:i:s');
                                             // echo "<br>". $date;
                                             // echo "<br>". date('Y-m-d H:i:s');

                                             // $date = $data->format('d-m-Y H:i:s');
                                             // $datetime = $datetime->format('Y-m-d H:i:s'); // data i czas serwera
                                             // 2022-10-04 13:45:26  <-- Format MySQL'owy
                                             // $d = $datetime->format('d');
                                             // $m = $datetime->format('m');
                                             // $Y = $datetime->format('Y');
                                             // $H = $datetime->format('H');
                                             // $i = $datetime->format('i');
                                             // $s = $datetime->format('s');
                                             // $dzisiaj = $d."-".$m."-".$Y." ".$H.":".$i;
                                             // $dzisiaj = $Y."-".$m."-".$d." ".$H.":".$i.":".$s;
                                             //echo "<br> dzisiaj &rarr; " . $dzisiaj;

        $orderDate = $datetime->format('Y-m-d H:i:s'); // data złożenia zamówienia (datetime);

        $expDeliveryDate = NULL; // termin dostawy - oczekiwany (date);

        $dispatchDate = NULL; // data wysłania zamówienia (datetime);

        $deliveryDate = NULL; // data dostarczenia (date);

        $orderStatus =  "Oczekujące na potwierdzenie"; // status zamówienia - (varchar - 255); - ["Oczekujące na potwierdzenie", "W trakcie realizacji", "Wysłano", "Dostarczono", "Zrealizowano/Zakończono"];

        $paymentDate = $orderDate; // data płatności (datetime);

        $orderSum = isset($_SESSION["nowa-suma"]) ? $_SESSION["nowa-suma"] : $_SESSION["suma_zamowienia"]; // suma zamówienia;

        // get employee with the fewest orders assigned -->
        query("SELECT pr.id_pracownika, 
                      COUNT(zm.id_zamowienia) as liczba_zamowien 
               FROM employees AS pr 
               LEFT JOIN orders zm ON pr.id_pracownika = zm.id_pracownika 
               GROUP BY pr.id_pracownika 
               ORDER BY liczba_zamowien ASC 
               LIMIT 1", "getEmployeeId", ""); // $_SESSION["employee_id"] --> 4;

        // zamówienie zostanie przypisane do pracownika, który aktualnie posiada najmniej zamówień przypisanych do niego;

        $order = [$_SESSION["id"], $orderDate, $expDeliveryDate, $dispatchDate, $deliveryDate, $_SESSION["delivery-types"][$deliveryType]["id"], $orderStatus, NULL, $_SESSION["employee_id"]];
        // order data informations;

        query("INSERT INTO orders VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", "getLastOrderId", $order);
        // add new order - inserts data into the "orders" table,
        // gets the ID of the newly added order (row) -->
        // $_SESSION["last_order_id"]

        $payment = [$_SESSION["last_order_id"], $paymentDate, $orderSum, $_SESSION["payment-methods"][$paymentMethod]["id"]];

        query("INSERT INTO payments VALUES (NULL, '%s', '%s', '%s', '%s')", "", $payment);

        query("SELECT id_klienta, id_ksiazki, ilosc 
               FROM shopping_cart 
               WHERE id_klienta='%s'", "insertOrderDetails", $_SESSION["id"]); // aktualizacja tabeli "szczegóły zamówienia"

    } else {
        $_SESSION["order-error"] = "Aby złożyć zamówienie, wybierz formę dostawy i metodę płatności";
        header('Location: ___submit_order.php', true, 303); exit();
    }

?>




<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

<div id="main-container">

    <?php require "../view/___header-container.php"; ?>

    <div id="container">

        <main>

            <!-- <aside> <div id="nav"></div> </aside> -->

            <div id="content">

                <h3 id="order-summary-header">Podsumowanie zamówienia</h3>

                <p>Twoje zamówienie zostało przekazane do realizacji, aby śledzić postęp zamówienia przejdź do zakładki <a href="___my_orders.php"><strong>Moje konto / Zamówienia</strong></a></p>



            </div>

        </main>

    </div>

    <?php require "../view/footer.php"; ?>

</div>

<script>
    /*function setSpanWidth() {
        // ten skrypt pobiera maksymalną szerokość spana na stronie, i ustawia szerokość każdego spana na tą wartość
        let spans = document.getElementsByTagName("span"); // you can change it to querySelectorAll
        console.log("spans ->", spans);
        let max_width = 0;
        tab = [];
        for( let i=0; i<spans.length; i++){
            tab.push(spans.item(i).offsetWidth);
        }
        console.log(tab);
        max_width = Math.max(...tab);
        console.log("max ->", max_width);
        for( let i=0; i<spans.length; i++){
            spans.item(i).style.width = max_width + 8 + "px";
            spans.item(i).style.margin = 0;
            spans.item(i).style.display = "inline-block";
            spans.item(i).style.textAlign = "left";
            console.log(i);
        }
    }

    setSpanWidth();

    function clear_result() {
        let result = document.getElementById("result");
        result.innerHTML = "";
    }*/

    // set #content width to 100% -->
    content = document.getElementById("content");
    content.style.width = "100%";

</script>

</body>
</html>