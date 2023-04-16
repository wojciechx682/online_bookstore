<?php

	session_start();

	include_once "../functions.php";

	// Do czego służy ten plik ? Zmienić jego nazwę na change password ?

	// jesli wszystkie pola sa ustawione i nie sa puste

	if(
        isset($_POST['stare_haslo_edit']) &&
        isset($_POST['nowe_haslo_edit']) &&
        isset($_POST['powtorz_haslo_edit']) &&
        !empty($_POST['stare_haslo_edit']) &&
        !empty($_POST['nowe_haslo_edit']) &&
        !empty($_POST['powtorz_haslo_edit'])
    )
	{
		//$stare_haslo =  md5($_POST['stare_haslo_edit']);
		//$nowe_haslo =  md5($_POST['nowe_haslo_edit']);
		//$powtorz_haslo =  md5($_POST['powtorz_haslo_edit']);		

		//$stare_haslo = $_POST['stare_haslo_edit']; // Powinienem to jakoś zakodować ? Zaszyfrować ? Tak aby nie było dostępne, bo ta zmienna trzyma jawnie hasło
		//$nowe_haslo = $_POST['nowe_haslo_edit'];
		//$powtorz_haslo = $_POST['powtorz_haslo_edit'];

            //$stare_haslo = htmlentities($stare_haslo, ENT_QUOTES, "UTF-8");
            //$nowe_haslo = htmlentities($nowe_haslo, ENT_QUOTES, "UTF-8");
            //$powtorz_haslo = htmlentities($powtorz_haslo, ENT_QUOTES, "UTF-8");

            $stare_haslo = filter_input(INPUT_POST, "stare_haslo_edit", FILTER_SANITIZE_STRING);
            $nowe_haslo = filter_input(INPUT_POST, "nowe_haslo_edit", FILTER_SANITIZE_STRING);
            $powtorz_haslo = filter_input(INPUT_POST, "powtorz_haslo_edit", FILTER_SANITIZE_STRING);
//            $stare_haslo = strip_tags($stare_haslo);
//            $nowe_haslo = strip_tags($nowe_haslo);
//            $powtorz_haslo = strip_tags($powtorz_haslo);

       /* echo " -> " .$stare_haslo. "<br>";
        echo " -> " .$nowe_haslo. "<br>";
        echo " -> " .$powtorz_haslo. "<br>"; //exit();*/

		$_SESSION['validation_password'] = true;

        $id = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);

		query("SELECT haslo FROM klienci WHERE id_klienta='%s'", "verify_password", $id); // ta funkcja ustawia zmienna sesyjna $_SESSION['stare_haslo'] ktora przechowuje haslo (hash hasła) z BD // CZY TO BEZPIECZNE ABY ZMIENNA SESYJNA PRZECHOWYWALA ZAHASHOWANE HASLO ?

		if(password_verify($stare_haslo, $_SESSION['stare_haslo'])) // czy haslo z inputa (bez hasha) jest równe haśle w bazie danych (zahashowane)
		{
            $pass_regex = '/^((?=.*[!@#$%^_&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{10,31}$/'; // https://regex101.com/

            if(!(preg_match($pass_regex, $nowe_haslo)))
            {
                $_SESSION['validation_password'] = false;
                $_SESSION['error_form_password'] = "Hasło musi posiadać od 10 do 30 znaków, zawierać przynajmniej jedną wielką literę, jedną małą literę, jedną cyfrę oraz jeden znak specjalny (!@#$%^&*-\/\?)";
            }

//            if((strlen($nowe_haslo)<5))
//            {
//                $_SESSION['validation_password'] = false;
//                $_SESSION['error_form_password'] = "Hasło musi posiadać conajmniej 5 znaków";
//            }

            if((strlen($nowe_haslo)<5))
			{
				$_SESSION['validation_password'] = false;
				$_SESSION['error_form_password'] = "Hasło musi posiadać conajmniej 5 znaków";
			}

			if($nowe_haslo != $powtorz_haslo) // sprawdzenie czy oba hasła są identyczne
			{
				$_SESSION['validation_password'] = false;			
				$_SESSION['error_form_password'] = "Podane hasła nie są identyczne";			
			}		
			else // hasla są te same (nowe i powtórzone)
			{
				if($stare_haslo == $nowe_haslo)
				{
					$_SESSION['validation_password'] = false;			
					$_SESSION['error_form_password'] = "Podaj hasło które różni się od aktualnego";		
				}
			}

			if($_SESSION['validation_password']) // jeśli wszystko jest dobrze
			{
				// zmien haslo na nowe (zahashowane)

				$new_password = password_hash($nowe_haslo, PASSWORD_DEFAULT);				

                $password = [$new_password, $id];

				query("UPDATE klienci SET haslo='%s' WHERE id_klienta='%s'", "", $password);

				$_SESSION['validation_passed_p'] = true;
			}

			header('Location: ___account.php');
            exit();
		}
		else // hasla sa rozne (stare_haslo i haslo z BD)
		{		
			$_SESSION['validation_password'] = false;
			$_SESSION['error_form_password'] = "Złe hasło";		

			header('Location: ___account.php');
            exit();
		}
	}
	else // nie wypełniono wszystkich pól
	{
		$_SESSION['validation_password'] = false;
		$_SESSION['error_form_password'] = "Uzupełnij wszystkie pola";

		header('Location: ___account.php');
        exit();
	}
?>