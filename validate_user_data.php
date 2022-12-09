<?php

	session_start();

	include_once "functions.php";	

	if(((isset($_POST['imie_edit'])) && (isset($_POST['nazwisko_edit'])) && (isset($_POST['email_edit'])) && (isset($_POST['telefon_edit']))) && ((($_POST['imie_edit']) != ($_SESSION['imie'])) || (($_POST['nazwisko_edit']) != ($_SESSION['nazwisko'])) || (($_POST['email_edit']) != ($_SESSION['email'])) || (($_POST['telefon_edit']) != ($_SESSION['telefon']))))
	{
		$imie = $_POST['imie_edit'];
		$nazwisko = $_POST['nazwisko_edit'];
		$email = $_POST['email_edit'];
		$telefon = $_POST['telefon_edit'];

		$imie = htmlentities($imie, ENT_QUOTES, "UTF-8"); 
		$nazwisko = htmlentities($nazwisko, ENT_QUOTES, "UTF-8"); 
		$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		$telefon = htmlentities($telefon, ENT_QUOTES, "UTF-8");

		$validation = true;

		if(((strlen($imie)<3) || (strlen($nazwisko)<3)))
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";		
		}					

		if((is_numeric($imie)) || (is_numeric($nazwisko)))  
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";		
		}					

		if((preg_match('/[0-9]/', $imie)) || (preg_match('/[0-9]/', $nazwisko)))
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";		
		}	

		$email_s = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanityzacja email

		if((filter_var($email_s, FILTER_VALIDATE_EMAIL)==false)) // email nie przeszedł walidacji
		{						
			$validation = false;
			//$_SESSION['error_form'] = "Podaj poprawne dane";
			$_SESSION['error_form'] = "Podaj poprawny adres e-mail";
		}
		else // MUSIMY SPRAWDZIĆ, CZY TAKI EMAIL NIE JEST JUŻ ZAJĘTY ! 
		{
			if($email_s != $_SESSION['email']) // czy jest różny od tego co było w polu formularza
			{
				$_SESSION['email_exists'] = false;				


				//query("SELECT * FROM klienci WHERE email='$email_s'", "check_email", $email_s); // to przełączy zmienną $_SESSION['email_exists'], jeśli taki email będzie istnieć
				query("SELECT * FROM klienci WHERE email='%s'", "check_email", $email_s); // to przełączy zmienną $_SESSION['email_exists'], jeśli taki email będzie istnieć

				//echo "53 email_s = " . $email_s;
				//exit();


				if($_SESSION['email_exists'] == true)
				{
					$validation = false;
					$_SESSION['error_form'] = "E-mail zajęty";				
				}						
			}			
		}			

		if(!(is_numeric($telefon)))
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";	
		}

		if((strlen($telefon)>15))
		{
			$validation = false;
			$_SESSION['error_form'] = "Podaj poprawne dane";		
		}
		
		if($validation == true)
		{
			$values = array();

			array_push($values, $imie);
			array_push($values, $nazwisko);
			array_push($values, $email);
			array_push($values, $telefon);

			$id = $_SESSION['id']; 

			echo query("UPDATE klienci SET imie='%s', nazwisko='%s', email='%s', telefon='%s' WHERE id_klienta='$id'", "", $values);			

			$_SESSION['validation_passed'] = true;

			$_SESSION['imie'] = $_POST['imie_edit'];
			$_SESSION['nazwisko'] = $_POST['nazwisko_edit'];
			$_SESSION['email'] = $_POST['email_edit'];
			$_SESSION['telefon'] = $_POST['telefon_edit'];

			unset($_POST['imie_edit']);
			unset($_POST['nazwisko_edit']);
			unset($_POST['email_edit']);
			unset($_POST['telefon_edit']);	

			unset($_SESSION['error_form']);

			header('Location: account.php');		
		}
		else
		{
			//echo '<script> alert("Niepoprawne dane") </script>';
			header('Location: account.php');	
		}
	}
	else
	{
		//echo '<script> alert("Uzupełnij wszystkie pola") </script>'; 
		header('Location: account.php');	
	}	

?>