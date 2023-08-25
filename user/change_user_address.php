<?php

    require_once "../start-session.php";

    if ( (isset($_POST["miejscowosc_edit"]) &&
          isset($_POST["ulica_edit"]) &&
          isset($_POST["numer_domu_edit"]) &&
          isset($_POST["kod_poczt_edit"]) &&
          isset($_POST["miasto_edit"])) &&
          (($_POST["miejscowosc_edit"] != $_SESSION["miejscowosc"]) ||
           ($_POST["ulica_edit"] != $_SESSION["ulica"]) ||
           ($_POST["numer_domu_edit"] != $_SESSION["numer_domu"]) ||
           ($_POST["kod_poczt_edit"]!= $_SESSION["kod_pocztowy"]) ||
           ($_POST["miasto_edit"] != $_SESSION["kod_miejscowosc"]))) {

        // jeśli podano dane (POST), i są one różne od tych które były aktualnie ustawione (w Sesji);

        // Edycja danych adresowych -> Miejscowość,
                                    // Ulica,
                                    // Numer_domu,
                                    // Kod_pocztowy,
                                    // Miasto;

        // sanitize address input;
        $miejscowosc = filter_input(INPUT_POST, "miejscowosc_edit", FILTER_SANITIZE_STRING);
        $ulica = filter_input(INPUT_POST, "ulica_edit", FILTER_SANITIZE_STRING);
        $numer_domu = filter_input(INPUT_POST, "numer_domu_edit", FILTER_SANITIZE_STRING);
        $kod_pocztowy = filter_input(INPUT_POST, "kod_poczt_edit", FILTER_SANITIZE_STRING);
        $miasto = filter_input(INPUT_POST, "miasto_edit", FILTER_SANITIZE_STRING);

        $valid = true;

        $miejscowosc = ucfirst(trim($miejscowosc, " "));

        $address_regex = '/^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){0,4}$/';

        //    Passing:
        //          "Warszawa"  "Kraków"  "Kostrzyn nad odrą"  "Poznań-Garaszewo"
        //    Not passing:
        //           Łódź 1
        //           123 ulica słoneczna
        //           Super długa nazwa miejscowości która nie istnieje
        //           #4A-23A
        //           $@!#$@#$

        if(!preg_match($address_regex, $miejscowosc)) {
            $valid = false;
            $_SESSION["address-data-error"] = "Podaj poprawną nazwę miejscowości";
        }

        if (isset($ulica)) {
            if (!empty($ulica)) {
                $street_regex = '/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s.-]{3,35}$/';
                //    Passing:
                //          "ul. Warszawska"  "al. Jana Pawła II"  "Plac Grunwaldzki"

                if ( !preg_match($street_regex, $ulica)) {
                    $valid = false;
                    $_SESSION["address-data-error"] = "Podaj poprawną nazwę ulicy";
                }
            }
        }

        $numer_domu = str_replace(str_split(' '), '', $numer_domu); // remove all white spaces; ' ' => '';

        $house_number_regex = '/^[0-9]{1,3}+[A-Z]{0,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/';

        //    Passing:
        //          18  18A   18a  18 a  19/7  17/a   19/A
        //          1   23A   45/2 67B   89C-1 1010   121-123    145E    167F/4    188G   123-AAA
        //    Not passing:
        //           54\AA
        //           AAA-123
        //           AAA-AAA

        if( !preg_match($house_number_regex, $numer_domu)) {
            $valid = false;
            $_SESSION["address-data-error"] = "Podaj poprawny numer domu";
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // kod pocztowy

        $kod_pocztowy = str_replace(str_split(' '), '', $kod_pocztowy);

        $zip_regex = "/^[0-9]{2}[\-]{1}[0-9]{3}$/";

        if( !preg_match($zip_regex, $kod_pocztowy)) {
            $valid = false;
            $_SESSION["address-data-error"] = "Podaj poprawny kod pocztowy";
        }

        $miasto = ucfirst(trim($miasto, " "));

        if( !preg_match($address_regex, $miasto)) {
            $valid = false;
            $_SESSION["address-data-error"] = "Podaj poprawną miejscowość";
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if( $valid )
        {
            $user_data = [$miejscowosc, $ulica, $numer_domu, $kod_pocztowy, $miasto, $_SESSION["adres_id"]]; // $id - id_adresu;

            // query("UPDATE klienci SET miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s' WHERE id_klienta='%s'", "", $user_data);

            query("UPDATE adres SET miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s' WHERE adres_id='%s'", "", $user_data);

            $_SESSION["is_address_data_changed"] = true;

            $_SESSION["miejscowosc"] = $miejscowosc;
            $_SESSION["ulica"] = $ulica;
            $_SESSION["numer_domu"] = $numer_domu;
            $_SESSION["kod_pocztowy"] = $kod_pocztowy;
            $_SESSION["kod_miejscowosc"] = $miasto;

            unset($_POST);

            header('Location: ___account.php');
                exit();
        }
        else // dane nie przeszły walidacji;
        {
                //echo '<script> alert("Niepoprawne dane") </script>';
            header('Location: ___account.php');
                exit();
        }
	}
	else // nie było danych w żądaniu POST lub były one te same co już istniejące w Sesji;
	{
		    // echo '<script> alert("Uzupełnij wszystkie pola") </script>';

        $_SESSION["address-data-error"] = "Podaj dane które różnią się od istniejących";
            header('Location: ___account.php');
                exit();
	}

?>

