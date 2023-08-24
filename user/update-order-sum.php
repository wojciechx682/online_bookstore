<?php
require_once "../authenticate-user.php";

/*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
echo "GET ->"; print_r($_GET); echo "<hr><br>";
echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";*/




if( isset($_POST["delivery-price"]) ) {



    $deliveryPrice = filter_input(INPUT_POST, "delivery-price", FILTER_VALIDATE_FLOAT);

    $_SESSION["delivery-price"] = $deliveryPrice;



    // ------------------------------------------------------------------------------
    /*$cartData = [
        "suma_zamowienia" => $_SESSION["nowa-suma"]
    ];



    header('Content-Type: application/json'); // return DATA as JSON ;
    echo json_encode($cartData); exit();*/


}

if( isset($_POST["payment-price"]) ) {

    $paymentPrice = filter_input(INPUT_POST, "payment-price", FILTER_VALIDATE_FLOAT);


    $_SESSION["payment-price"] = $paymentPrice;



    //$_SESSION["payment-price"] = $_SESSION["suma_zamowienia"] + $paymentPrice;

    // ------------------------------------------------------------------------------
   /* $cartData = [
        "suma_zamowienia" => $_SESSION["nowa-suma"]
    ];

    unset($_SESSION["payment-price"]);

    header('Content-Type: application/json'); // return DATA as JSON ;
    echo json_encode($cartData); exit();*/
}

// Obliczanie nowej sumy na podstawie wartości bazowej oraz dodanych opłat za dostawę i płatność
$deliveryCost = isset($_SESSION["delivery-price"]) ? $_SESSION["delivery-price"] : 0;
$paymentCost = isset($_SESSION["payment-price"]) ? $_SESSION["payment-price"] : 0;

$_SESSION["nowa-suma"] = $_SESSION["suma_zamowienia"] + $deliveryCost + $paymentCost;

$cartData = [
    "suma_zamowienia" => $_SESSION["nowa-suma"]
];
header('Content-Type: application/json'); // return DATA as JSON
echo json_encode($cartData);
exit();


exit();

// przejście tutaj następuje po wysłaniu formularza (np. przyciskiem ENTER), w którym jest <input> z ilością książek w koszyku.
// dane pochodzące z koszyk.php;
// && not empty; !empty
?>