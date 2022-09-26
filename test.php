<?php
	
	session_start();

	//$var = "You've clicked me !";



	include_once "functions.php";

	echo "<br> wynik zapytania : <br><hr>";



	//query("SELECT * FROM ksiazki", "get_books", "");

	$id_ksiazki ="2";

	query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_ksiazki='%s'", "get_books_by_id", "$id_ksiazki");


	echo "<hr>";
	exit();







?>


<button onclick="my_function()"> Click me ! </button>

<p id="demo"></p>


<script>

	function my_function() 
	{
		document.getElementById("demo").innerHTML = "<?php echo $var; ?>";
	}

	
</script>


<hr>
<br>

<form method="post">

	<input type="text" name="login">

	<input type="submit" value="Wyślij dane do skryptu">

</form>


<!-- -------------------------------------------------- -->


<form method="post">

	<label>
		
		<input type="checkbox" name="regulamin">
		
		Akceptuję regulamin

	</label>
	
	<input type="submit" value="Wyślij dane do skryptu">

</form>

<form method="post">

	<br>
	
	<b>Przetestuj htmlentities() : </b><br>

	<input type="text" name="test_html_ent" value="<script>document.write('abcde');</script>">
	
	<input type="submit" value="Wyślij dane do skryptu">	

</form>


---------------------------------------------------------------------<br><br>


<script src="jquery.js"></script>
<script src="sortowanie_v2.js"></script>


<input type="text" id="add_quan">

<button id="add" onclick="sortuj()">+</button>
<button id="remove">-</button>




<br>---------------------------------------------------------------------<br><br>












	
<?php
	
	
	
	if(isset($_POST['regulamin']))
	{
		echo "<br> Checkbox jest zaznaczony <br>";		
	}
	
	$email = 'asd@wp.pl';

	//$email = htmlentities($email, ENT_QUOTES, "UTF-8");
	
	echo "<br> e-mail = $email";
	
	$email_sanitaze = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	$email_verify = filter_var($email_sanitaze, FILTER_VALIDATE_EMAIL);
	
	echo "<br><br> e-mail verify - FILTER_SANITIZE_EMAIL = $email_sanitaze";
	
	echo "<br><br> e-mail verify - FILTER_VALIDATE_EMAIL = $email_verify";
	
	echo "<br>";
	
	if((filter_var($email_sanitaze, FILTER_VALIDATE_EMAIL)==false) || ($email_sanitaze != $email))
	{
		echo "<br> -> false<br>";
	}
	else
	{
		echo "<br>true<br>";
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	if((isset($_POST['test_html_ent'])) && (!empty($_POST['test_html_ent'])))
	{
		$test_html_ent = $_POST['test_html_ent']; 
	
		echo "<br>test_html_ent = $test_html_ent";
		
		$result_html_ent = htmlentities($test_html_ent, ENT_QUOTES, "UTF-8");
		
		echo "<br>result_html_ent = " . $result_html_ent . "<br>";
	
	}
	
	//exit();
	
	
		
		
		
	//exit();
?>

	



<?php

		//$v = '<script>document.write("abcde!");</script>';
		
	$haslo = 'jason2';
	
	$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
	
	
		//$vh = htmlentities($login, ENT_QUOTES, "UTF-8"); 
		
		/*$v = htmlentities($v, ENT_QUOTES, "UTF-8");
		$vh = htmlentities($v, ENT_QUOTES, "UTF-8");
		
		
		require_once "connect.php"; 
		
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);	
		
		$ms = mysqli_real_escape_string($polaczenie, $vh); 	
		$ms = mysqli_real_escape_string($polaczenie, $vh); 	*/
	
	//echo "<br> haslo = $haslo";
	
	echo "<br> 148 haslo hash  = $haslo_hash";	
	
	//echo "<br> ms = $ms";


	///////////////////////////////////////////////////////////////////////////


	
	

	// konstrukcja wyrażenia regularnego
	// poprawność imienia oraz nazwiska

			//$sprawdz = '/(*UTF8)^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
			//$sprawdz = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+$/';
			//$sprawdz = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+ ?+[a-ząćęłńóśźż]*+ ?+[a-ząćęłńóśźż]*+ *$/';
	//$sprawdz = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+$/';
    //                                                  |             |            | | 

	// numer domu : 

	//$address_regex = '/^[0-9]{1,3}+\s?[-]?[/]?\s?[A-Za-z0-9]{1,3}+$/'; // miejscowosc, ulica ...
	//$address_regex = '/^[0-9]{1,3}+\s?+[-]?+$/'; // miejscowosc, ulica ...


	
	// 18     18A 18a   18 a   19/7   17/a   19/A 

	/* 18
	   18/
	   18-

	   18a
	   18 a
	   18 A
	   67/4



	*/

	//$zip_regex = '/^[0-9]{1,3}+\s?[\/-]?+\s?+[A-Za-z0-9]{0,3}$/'; // miejscowosc, ulica ...
	//$zip_regex = '/\b\d{2}\s*-\s*\d{3}\b/'; // zip code
	//$zip_regex = "/^[0-9]{2}(?:-[0-9]{3})?$/"; // zip code

	

	//$name_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+\s?+$/';	// imię -> "Jakub"

   

	//$pass_regex_big_L = '/(*UTF8)^[A-ZŁŚŻ]{1}+[a-ząęółśżźćń]+$/';
	//$pass_regex_big_L = '/[A-Z]+/';
	//$pass_regex_small_L = '/[A-Z]?/';

	///////////////////////////////////////////////////////
	// hasło - musi zawierać (przynajmniej) : 
	// Jedną dużą literę, 
	// jedną małą, 
	// znak specjalny 	 !# /? 	!@#$%^&*-
	// jedną cyfra

	$pass = "PassJacob33";

	//$pattern = '/^(?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z]).{8,25}$/';
	$pattern = '/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{8,25}$/';

	//$pass_regex_big_L = '/[A-Za-z]/';

	echo "<br><br> haslo =  $pass <br>";

	if(!(preg_match($pattern, $pass))) 
	{		
		echo "<br>Hasło musi posiadać od 8 do 25 znaków<br>";	
		echo "<br>Hasło musi zawierać przynajmniej jedną wielką literę<br>";	
		echo "<br>Hasło musi zawierać przynajmniej jedną małą literę<br>"; 	
		echo "<br>Hasło musi zawierać przynajmniej jedną cyfrę<br>"; 	
		echo "<br>Hasło musi zawierać przynajmniej jeden znak specjalny cyfrę<br>"; 	
		//exit();	
	}

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////

	echo "<br><hr><br>";
	echo "Miejscowosc regex :";

	

	//$pattern = '/^(?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z]).{8,25}$/';

	$pass_regex = '/^( (?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]) ).{8,25}$/';

	//$pattern = '/(*UTF8)^( (?=.*[!@#$%^&*-\/\?]) (?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{8,25}$/';

	//$pattern = '/(*UTF8)^( (?=.*[!@#$%^&*-\/\?]) (?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{8,25}$/';

	//$pattern = '/(*UTF8)^([A-Z]{1}+)$/';

	$pattern = '/(*UTF8)^([A-Z]{1})  $/';

	$pattern = '/(*UTF8)^([A-Z]{1})  $/';

	//'/^((?=.*[!@#$%^&*-\/\?])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])).{8,25}$/';

	//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+$/'; // miejscowosc, ulica ...

	//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}  $/';

	/////////////////////////////////////////////////////////////
	//$name_regex = '/(*UTF8)^[A-ZŁŚŻ]{1}[a-ząęółśżźćń]+$/';

	//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){4}$/'; 

	//Ą ą Ć ć Ę ę Ł ł Ń ń Ó ó Ś ś Ź ź Ż ż.

	//$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+\s?[-]?\s?+[A-ZĄĆĘŁŃÓŚŹŻ]?+[a-ząćęłńóśźż]+$/'; // miejscowosc, ulica ...

	//$pass_regex_big_L = '/[A-Za-z]/';

	$city = "Dębno-w-odrze";

	//$phone = str_replace(['!', '@', '#', '$', '%', '^', '&', , , , , '-', '[', ']', '.', ',' ], '', $phone);

	//$phone = str_replace(str_split('!"#$%&\'()*\'-./:;<>?@[\\]^_{}|~ '), '', $phone);


	//$phone_regex = "/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{3,6}$/";
		//$zip_regex = "/^[0-9]{2}(?:-[0-9]{3})?$/";
	$address_regex = '/(*UTF8)^[A-ZĄĆĘŁŃÓŚŹŻ]{1}[a-ząćęłńóśźż]+([\s|\-]?[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż]+){0,4}$/';	

	echo "<br><br> Miasto =  $city <br>";

	if(!(preg_match($address_regex, $city))) 
	{		
		echo "<br> Podaj poprawną miejscowość <br>"; 	
		//exit();	
	}

	echo "<br>------------------------------------------------------------------<br>";


	$values = array();

	$value = "abc";

	array_push($values, "1");
	array_push($values, "2");
	array_push($values, "3");

	echo "<br> values = <br>";
	print_r($values);

	echo "<br> is array ? --> <br>";

	if(!is_array($values))
	{
		echo "yes";
	}
	else 
	{
		echo "no";
	}

	echo "<br> values = <br>";
	print_r($values[0]);


	echo "<br>------------------------------------------------------------------<br>";





		






	exit();
	
	/*
	
		Nazwa miasta :

		Pierwsza litera duża, A a + polskie znaki
	
		L m+  [dowolna ilosc spacji]    myślnik


	*/




	

	exit();
	













	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	if(isset($_POST['login']))
	{
		$login = $_POST['login'];
		
		if((isset($login)) && (!empty($login)))
		{
			echo "<br> Zmienna login jest ustawiona (isset) i nie jest pusta (empty == false)";
			echo "<br> login = $login";	
		}	
	}	
























	

	//unset($login);




	exit();

	$_SESSION['login'] = $login;	
	
	
	//unset($_SESSION['login']);
	
	echo "<br> Login = " . $_SESSION['login'] . " <br>";	
	
	exit();
		
?>







