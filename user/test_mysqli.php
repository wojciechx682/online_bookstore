<?php

    session_start();

    function checkClient($result) {

        $_SESSION["num-rows"] = $result->num_rows;

        /*if ($result->num_rows) {

            $_SESSION["num-rows"] = $result->num_rows;

        }*/ /*else {
            $_SESSION["num-rows"] = 0;
        }*/
    }

    function query($query, $fun, $value)
    {
        require "../connect.php";
        //mysqli_report(MYSQLI_REPORT_STRICT); // throw Exceptions


        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if ($polaczenie->connect_errno) {

            return "<br>error: " . $polaczenie->connect_errno; //. "<br>opis: ".$polaczenie->connect_error;
        } else {

            $result = $polaczenie->query($query);

               /* echo "\n";

                print_r($result);

                echo "\n<br><br><hr><br>\n\n";


                var_dump($result);*/

                checkClient($result);


            //return $result;

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

    <hr>

    Testowanie funkcji query() - MySQLi (Improved)

    <br><hr>

    $result --> obiekty typu mysqli_result

    <br><hr><br>

    <?php
        query("SELECT * FROM customers WHERE email='jakub.wojciechowski.682@gmail.com'", "checkClient", "");

        echo "<br><hr><br>";

        echo '$_SESSION["num-rows"] --> ' . $_SESSION["num-rows"] . "<br>";

        echo "<br><hr><br>";

        /*  mysqli_result Object
            (
                    [current_field] => 0
                    [field_count] => 12
                    [lengths] =>
            [num_rows] => 20 | 0 <---- (!) - liczba zwróconych wierszy !
                [type] => 0
            )

            object(mysqli_result)#2 (5) {
                  ["current_field"]=> int(0)
                  ["field_count"]=> int(12)
                  ["lengths"]=> NULL
          ["num_rows"]=> int(20)
              ["type"]=> int(0)
            }
        */

        //query("INSERT INTO koszyk(id_klienta, id_ksiazki, ilosc) VALUES('349', '2', '15')", "", "");
    ?>

    <br><br><hr><br>

</body>
</html>

