<?php

    //echo password_hash("adam1", PASSWORD_DEFAULT);


        //$data = date("2023-07-30");


$todayDate = new DateTime();
$todayDate->format('Y-m-d');

$_POST["order-date"] = "2023-07-24";

$orderDate = DateTime::createFromFormat('Y-m-d', $_POST["order-date"]);




echo "<br><br>";

    echo "\n\n\n\ntodayDate --> \n\n<br>";

    print_r($todayDate);

echo "\n\n\norderDate --> \n\n<br>";

print_r($orderDate);

echo "\n\n\n\ncomparison --> \n\n<br>";


echo "\n\n\n obliczanie różnicy czasu --> \n\n\n";

echo "<br>" . date('Y-m-d'); echo "<br>";

echo $_POST["order-date"]; echo "<br>";

if($_POST["order-date"] < date('Y-m-d')) {
    echo "\n\n\npodano przeszłą datę\n\n\n";
} else {
    echo "\n\n\ndata OK\n\n\n";
}




echo "<br><br>";