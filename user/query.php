<?php

function query($query, $fun, $values) {

// $query - SQL - "SELECT imie, nazwisko FROM klienci";

// $fun   - callback function
// - wywołaj funkcję tylko wtedy, jeśli $result --> - jest obiektem, który posiada conajmniej jeden wiersz (num_rows) <-- zapytania typu SELECT
//                                                  - posiada wartość == "true" (bool) <-- dla zapytań INSERT, UPDATE, DELETE
//                                                    ORAZ stan BD został zmieniony (zaktualizowany, wstawiony, usunięty wiersz)

// jeśli nie udało się wykonać zapytania, $result zwróci false;
// ---------------------------------------------------------------------------------------------------------------------

    require_once "connect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);

    try {

        $connection = new mysqli($host, $db_user, $db_password, $db_name);

        if ($connection->connect_errno) {
            throw new Exception(mysqli_connect_errno()); // failed to connect to DB;
        } else {

            // connection successful

            if (!is_array($values)) {

                $values = [$values];
            }

            // zamiast tego --> mysqli --> prepared statements;

            for($i = 0; $i < count($values); $i++) {
                $values[$i] = mysqli_real_escape_string($connection, $values[$i]);
            }
                /*foreach ($values as &$value) {
                    $value = mysqli_real_escape_string($connection, $value);
                }
                unset($value); // Zalecane, aby uniknąć przypadkowych problemów z dalszym użyciem zmiennej $value.*/

            if ($result = $connection->query(vsprintf($query, $values))) {

                // $result --> obiekt || true

                if ($result instanceof mysqli_result) { // zapytanie typu SELECT <-- obiekt

                    // SELECT --> $result -> wyniki zapytania

                    if ($result->num_rows) { // 1, 2, 3, ...

                        $fun($result);

                        $result->free_result();
                    } /*else {

                        // nie zrwócono żadnych wierszy ! (SELECT)
                    }*/

                } elseif ($result === true ) { // dla zapytań INSERT, UPDATE, DELETE ...

                    if ($connection->affected_rows > 0) {
                        // Tutaj obsłuż przypadki, gdy zapytanie wpłynęło na co najmniej jeden wiersz

                        // zaktualizowany / wstawiony / usunięty

                        $fun($result);
                        //$fun($result, $polaczenie);

                    } else {
                        // Obsłuż przypadki, gdy zapytanie nie wpłynęło na żaden wiersz, ale nie wystąpiły błędy

                    }
                }

            } else {

                // nie udało się wykonać zapytania; <-- $result == false

                throw new Exception($connection->error);

            }

            $connection->close();


        }

    } catch(Exception $e) {
        echo '<div class="error"> [ Błąd serwera. Przepraszamy za niegodności ] </div>';
        // użycie "return" zamisat echo ?
        echo '<br><span style="color:red">Informacja developerska: </span>'.$e;
        // wyświetlenie komunikatu błędu - dla deweloperów
        //exit(); // (?)
    }

}