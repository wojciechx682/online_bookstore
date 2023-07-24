<?php

    //echo password_hash("adam1", PASSWORD_DEFAULT);


        //$data = date("2023-07-30");


echo "<br><hr><br>";

$_POST["dispatch-date"] = "2021-01-01";
$_POST["dispatch-time"] = "12:54";

$res = $_POST["dispatch-date"] . " " . $_POST["dispatch-time"] ;







// Now you have $dateTimeObject as a DateTime object with both date and time components
// You can use $dateTimeObject to perform date and time operations

echo "\n\n\n dispatch-date -> " . $_POST["dispatch-date"] . "<br>\n\n";
echo "\n\n\n dispatch-time -> " . $_POST["dispatch-time"]. "<br>\n\n";

echo "\n\n\n res -> " . $res. "<br>\n\n";



echo "<br><br><br>";
echo "<br><br><br>";

$dispatchDate = new DateTime('2021-01-01');









print_r($dispatchDate);


echo "<br><br><br>";
echo "<br><br><br>";




echo "<br><br>";