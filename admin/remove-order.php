<?php
    require_once "../authenticate-admin.php";

    header('Content-Type: application/json');
    $response = [];

    $archiveSuccessful = true;

    if (isset($_POST["comment"]) && !empty($_POST["comment"]) && isset($_POST["order-id"]) && !empty($_POST["order-id"])) {

        $comment = filter_var($_POST["comment"],FILTER_SANITIZE_STRING);
        $orderId = filter_var($_POST["order-id"],FILTER_SANITIZE_NUMBER_INT);

        if ($comment === false || $orderId === false || $comment !== $_POST["comment"] || $orderId !== $_POST["order-id"]) {

            $archiveSuccessful = false;

        } else {

            $archiveSuccessful = query("UPDATE orders SET komentarz='%s', status='%s' WHERE id_zamowienia = '%s'", "", [$comment, "Zarchiwizowane", $orderId]); // --> true / false;
        }
    } else {

        $archiveSuccessful = false;
    }


    if ($archiveSuccessful === true) {

        $response["success"] = true;
        $response["message"] = "Udało się zarchiwizować zamówienie";

    } else {

        $response["success"] = false;
        $response["message"] = "Wystąpił problem. Nie udało się zarchiwizować zamówienia";
    }

    echo json_encode($response);
?>
