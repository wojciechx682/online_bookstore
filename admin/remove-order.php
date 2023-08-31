<?php
    require_once "../authenticate-admin.php"; // check if user is logged-in, and user-type is "admin" - if not, redirect to login page ;

    // plik obsługujący żądanie POST - archiwizujące zamówienie + dodające komentarz (powód);
    // plik PHP obsługujący żądanie AJAX;
    // $orderId = $_POST["order-id"]; // id-zamówienia <input type="hidden">
    // $comment = $_POST["comment"];  // komentarz <textarea>
    // $_POST[] data =>  order-id=1039 & comment=test123;

header('Content-Type: application/json');
$response = [];

    $archiveSuccessful = true;

    if (isset($_POST["comment"]) && !empty($_POST["comment"]) && isset($_POST["order-id"]) && !empty($_POST["order-id"])) {

        $comment = filter_var($_POST["comment"],FILTER_SANITIZE_STRING); // sanityzacja (back-end);
        $orderId = filter_var($_POST["order-id"],FILTER_SANITIZE_NUMBER_INT);
        $orderId = filter_var($orderId, FILTER_VALIDATE_INT);

        if ($comment === false || $orderId === false || $comment !== $_POST["comment"] || $orderId !== $_POST["order-id"]) { // dane nie przeszły walidacji;

            $archiveSuccessful = false;

        } else {

            $archiveSuccessful = query("UPDATE zamowienia SET komentarz='%s', status='%s' WHERE id_zamowienia = '%s'", "", [$comment, "Zarchiwizowane", $orderId]); // --> true / false;
        }
    } else {

        $archiveSuccessful = false;
    }

    if ($archiveSuccessful === true) {
        //http_response_code(200);
        $response["status"] = true;
        $response["message"] = "Udało się zarchiwizować zamówienie";
        //echo "<span class='archive-success'>Udało się zmienić zarchiwizować zamówienie</span>";
    } else {
        //http_response_code(400);
        $response["status"] = false;
        $response["message"] = "Wystąpił problem. Nie udało się zarchiwizować zamówienia";
        //echo "<span class='update-failed'>Wystąpił problem. Nie udało się zarchiwizować zamówienia</span>";
    }

    echo json_encode($response);
?>
