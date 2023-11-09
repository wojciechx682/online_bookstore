<?php

    // zmiana danych adresowych zalogowanego klienta;

    require_once "../authenticate-user.php";

    if ( (isset($_POST["city"]) &&
          isset($_POST["street"]) &&
          isset($_POST["houseNo"]) &&
          isset($_POST["postCode"]) &&
          isset($_POST["cityCode"])) &&
          (($_POST["city"] != $_SESSION["miejscowosc"]) ||
           ($_POST["street"] != $_SESSION["ulica"]) ||
           ($_POST["houseNo"] != $_SESSION["numer_domu"]) ||
           ($_POST["postCode"]!= $_SESSION["kod_pocztowy"]) ||
           ($_POST["cityCode"] != $_SESSION["kod_miejscowosc"]))) {

        // jeśli podano wszystkie dane adresowe (POST), i są one różne od tych które były aktualnie ustawione (w Sesji);

        // Edycja danych adresowych -> Miejscowość, // Ulica, // Numer_domu, // Kod_pocztowy, // Miasto;

        // sanitize address input;
        $cityName = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
        $street = filter_input(INPUT_POST, "street", FILTER_SANITIZE_STRING);
        $houseNo = filter_input(INPUT_POST, "houseNo", FILTER_SANITIZE_STRING);
        $postCode = filter_input(INPUT_POST, "postCode", FILTER_SANITIZE_STRING);
        $cityCode = filter_input(INPUT_POST, "cityCode", FILTER_SANITIZE_STRING);

        $max_city_length = 255;
        $max_house_no_len = 25;

        $valid = true;

        $cityName = ucfirst(trim($cityName, " "));
        //$cityName = mb_convert_case($cityName, MB_CASE_TITLE, "UTF-8"); // firstletter = uppercase, rest = lowercase;

        $address_regex = '/^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){0,4}$/';

        //    Passing:
        //          "Warszawa"  "Kraków"  "Kostrzyn nad odrą"  "Poznań-Garaszewo"
        //    Not passing:
        //           Łódź 1
        //           123 ulica słoneczna
        //           Super długa nazwa miejscowości która nie istnieje
        //           #4A-23A
        //           $@!#$@#$

        if (!preg_match($address_regex, $cityName) || strlen($cityName)>$max_city_length || $cityName !== ucfirst(trim($_POST["city"], " ")))  {

            $valid = false;
            $_SESSION["address_data_error_message"] = "Podaj poprawną nazwę miejscowości";
        }

        if (isset($street)) {
            if (!empty($street)) {
                $street_regex = '/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s.-]{3,35}$/';
                //    Passing:
                //          "ul. Warszawska"  "al. Jana Pawła II"  "Plac Grunwaldzki"
                if (!preg_match($street_regex, $street) || strlen($street)>$max_city_length || $street !== $_POST["street"]) {

                    $valid = false;
                    $_SESSION["address_data_error_message"] = "Podaj poprawną nazwę ulicy";
                }
            }
        }

        $houseNo = str_replace(str_split(" "), "", $houseNo); // remove all white spaces; ' ' => '';

        $house_number_regex = '/^[0-9]{1,3}+[A-Z]{0,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/';

        //    Passing:
        //          18  18A   18a  18 a  19/7  17/a   19/A
        //          1   23A   45/2 67B   89C-1 1010   121-123    145E    167F/4    188G   123-AAA
        //    Not passing:
        //           54\AA
        //           AAA-123
        //           AAA-AAA

        if (!preg_match($house_number_regex, $houseNo) || strlen($houseNo)>$max_house_no_len || $houseNo !== str_replace(str_split(" "), "", $_POST["houseNo"]) ) {

            $valid = false;
            $_SESSION["address_data_error_message"] = "Podaj poprawny numer domu";
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // kod pocztowy

        $postCode = str_replace(str_split(' '), '', $postCode);

        $zip_regex = "/^[0-9]{2}[\-]{1}[0-9]{3}$/";

        if (!preg_match($zip_regex, $postCode) || strlen($postCode)>$max_house_no_len || $postCode !== str_replace(str_split(" "), "", $_POST["postCode"]) ) {

            $valid = false;
            $_SESSION["address_data_error_message"] = "Podaj poprawny kod pocztowy";
        }

        $cityCode = ucfirst(trim($cityCode, " "));

        if( !preg_match($address_regex, $cityCode) || strlen($cityCode)>$max_city_length || $cityName !== ucfirst(trim($_POST["city"], " "))) {

            $valid = false;
            $_SESSION["address_data_error_message"] = "Podaj poprawną miejscowość";
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if ($valid) {

            $user_data = [$cityName, $street, $houseNo, $postCode, $cityCode, $_SESSION["adres_id"]]; // $_SESSION["adres_id"] - id_adresu;

            // query("UPDATE klienci SET miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s' WHERE id_klienta='%s'", "", $user_data);

            $updateSuccessful = query("UPDATE address SET miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s' WHERE adres_id='%s'", "", $user_data);

            if ($updateSuccessful) { // jeśli UDAŁO się zrealizować zapytanie UPDATE - ORAZ -  zmieniło ono stan bazy (affected-rows);

                $_SESSION["is_address_data_changed"] = true;

                $_SESSION["miejscowosc"] = $cityName;
                $_SESSION["ulica"] = $street;
                $_SESSION["numer_domu"] = $houseNo;
                $_SESSION["kod_pocztowy"] = $postCode;
                $_SESSION["kod_miejscowosc"] = $cityCode;

                unset($_POST, $_SESSION["address_data_error_message"]);

            } else {

                $_SESSION["address_data_error_message"] = "Wystąpił błąd. Spróbuj jeszcze raz";
            }
        }
        /*else // dane nie przeszły walidacji;
        {
            //echo '<script> alert("Niepoprawne dane") </script>';
            header('Location: ___account.php');
                exit();
        }*/

	} else { // nie było danych w żądaniu POST lub były one te same co już istniejące w Sesji;

        $_SESSION["address_data_error_message"] = "Podaj dane które różnią się od istniejących";

	}

    header('Location: ___account.php', true, 303);
        exit();
?>

