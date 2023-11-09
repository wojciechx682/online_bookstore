<?php

    require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page;

    // plik obsługujący żądanie POST aktualizujące termin dostawy zamówienia;
        // $date = $_POST["order-date"]; // termin dostawy
        // $dispDate = $_POST["dispatch-date"]; // data swysyłki
        // data serialized (string) =>  order-date=2023-05-17&dispatch-date=2023-05-18;
            // walidacja + sanityzacja danych ?

header('Content-Type: application/json');
$response = [];

    $updateSuccessful = true;

    $format = "Y-m-d";                    // expected date format (YYYY-MM-DD)
    $todayDate = new DateTimeImmutable(); // dzisiejsza data (Y-m-d) --> "2021-01-01";
        //$todayDate->setTime(0,0,0); // set H:i:S to zeros, to compare only date values;

    if (isset($_POST["order-date"]) && !empty($_POST["order-date"]) && empty($_POST["dispatch-date"])) { // termin_dostawy --> "2023-08-29";

        $orderDate = DateTime::createFromFormat($format, $_POST["order-date"])->setTime(0,0,0);
        $today = $todayDate->setTime(0,0,0);

        // check if the date was parsed successfully and if it's a valid date;
        if (!$orderDate || ($orderDate->format($format) !== $_POST["order-date"]) || ($orderDate <= $today)) { // Invalid date format or an invalid date - or orderDate is previous that today's Date;

            $updateSuccessful = false;

        } else { // valid date, not past;

        $_SESSION["order-date"] = $_POST["order-date"]; // ?

            $updateSuccessful = query("UPDATE orders SET termin_dostawy='%s', data_wysłania_zamowienia='', data_dostarczenia='', status='W trakcie realizacji' WHERE id_zamowienia = '%s'", "", [$_POST["order-date"], $_SESSION["order-id"]]); // true / false;
        }
    }

    elseif (isset($_POST["dispatch-date"]) && !empty($_POST["dispatch-date"]) && !empty($_POST["order-date"])) { // data_wysłania

        $orderDate = DateTime::createFromFormat($format, $_POST["order-date"])->setTime(0,0,0);
        $dispatchDate = DateTime::createFromFormat("Y-m-d H:i:s", $_POST["dispatch-date"] . " " . $_POST["dispatch-time"]);

        // check if the date was parsed successfully and if it's a valid date
        if (!$dispatchDate || ($dispatchDate->format($format) !== $_POST["dispatch-date"]) || ($dispatchDate < $todayDate) || ($orderDate <= $dispatchDate)) {
            // Invalid date format or an invalid date - or dispatchDate is previous that today's Date;

            $updateSuccessful = false;

        } else { // valid date
        $_SESSION["dispatch-date"] = $_POST["dispatch-date"] . " " . $_POST["dispatch-time"]; // ?
            $updateSuccessful = query("UPDATE orders SET termin_dostawy='%s', data_wysłania_zamowienia='%s', data_dostarczenia='', status='Wysłano' WHERE id_zamowienia = '%s'", "", [$_POST["order-date"], $_SESSION["dispatch-date"], $_SESSION["order-id"]] ); // true/false;
            // "Wysłano" -> data_wyslania_zamowienia;
        }
    }

    elseif (isset($_POST["delivered-date"]) && !empty($_POST["delivered-date"]) && empty($_POST["order-date"]) && empty($_POST["dispatch-date"])) { // data_dostarczenia;

        $deliveredDate = DateTime::createFromFormat($format, $_POST["delivered-date"]);

        // check if the date was parsed successfully and if it's a valid date
        if (!$deliveredDate || ($deliveredDate->format($format) !== $_POST["delivered-date"]) || ($deliveredDate <= $todayDate)) {
            // Invalid date format or an invalid date
            $updateSuccessful = false;
        } else { // valid date
            $_SESSION["delivered-date"] = $_POST["delivered-date"];
            $updateSuccessful = query("UPDATE orders SET data_dostarczenia='%s', termin_dostawy='', data_wysłania_zamowienia='', status='Dostarczono' WHERE id_zamowienia = '%s'", "", [$_POST["delivered-date"], $_SESSION["order-id"]]); // true / false;
            // "Dostarczono" -> data_dostarczenia;
        }
    }

    if (isset($updateSuccessful) && ($updateSuccessful === true)) {

        $response["success"] = true;
        $response["message"] = "Udało się zmienić status zamówienia";
        /*echo "<span class='update-success'> Udało się zmienić status zamówienia</span>";*/

    } else { // false ;
        $response["success"] = false;
        $response["message"] = "Wystąpił problem. Nie udało się zarchiwizować zamówienia";
        /*echo "<span class='update-failed'>Wystąpił błąd. Nie udało się zmienić statusu zamówienia</span>";*/
    }

    echo json_encode($response);

    // (!) Dodać walidacje daty - tutaj albo w JS;
    // ✓ trzeba sprawdzić, czy udało się zrealizować ZAPYTANIE. można użyć do tego wartości zwrotnej z funkcji query();
?>
