<?php

    require_once "../authenticate-user.php";

    if (isset($_POST["delivery-type"]) && !empty($_POST["delivery-type"]) &&
        isset($_POST["payment-method"]) && !empty($_POST["payment-method"])) {

        $deliveryType = filter_input(INPUT_POST, "delivery-type", FILTER_SANITIZE_STRING);
        $paymentMethod = filter_input(INPUT_POST, "payment-method", FILTER_SANITIZE_STRING);

        if (empty($deliveryType) || ($deliveryType !== $_POST["delivery-type"]) || !array_key_exists($_POST["delivery-type"], $_SESSION["delivery-types"])) {

            $_SESSION["order-error"] = "Podaj poprawną formę dostawy";

        } elseif (empty($paymentMethod) || ($paymentMethod !== $_POST["payment-method"]) || !array_key_exists($_POST["payment-method"], $_SESSION["payment-methods"])) {

            $_SESSION["order-error"] = "Podaj poprawną formę płatności";

        } elseif (!isset($_SESSION["koszyk_ilosc_ksiazek"]) || $_SESSION["koszyk_ilosc_ksiazek"] === 0) {

            $_SESSION["order-error"] = "Aby złożyć zamówienie, dodaj książki do koszyka";
        }

        if (isset($_SESSION["order-error"]) && !empty($_SESSION["order-error"])) {

            header('Location: submit_order.php', true, 303); exit();
        }

        $datetime = new DateTimeImmutable(); // current date and time

        $orderDate = $datetime->format('Y-m-d H:i:s'); // data złożenia zamówienia (datetime);

        $expDeliveryDate = NULL; // termin dostawy - oczekiwany (date);

        $dispatchDate = NULL; // data wysłania zamówienia (datetime);

        $deliveryDate = NULL; // data dostarczenia (date);

        $orderStatus =  "Oczekujące na potwierdzenie";
        // status zamówienia - (varchar - 255); - ["Oczekujące na potwierdzenie", "W trakcie realizacji", "Wysłano", "Dostarczono", "Zrealizowano/Zakończono"];

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

        // zmniejszenie stanów magazynowych o ilość egzemplarzy -->



        header('Location: order-summary.php', true, 303); exit();

    } else {
        $_SESSION["order-error"] = "Aby złożyć zamówienie, wybierz formę dostawy i metodę płatności";
        header('Location: submit_order.php', true, 303); exit();
    }

?>




