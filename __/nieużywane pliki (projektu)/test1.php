<?php
	
	session_start();

	//$var = "You've clicked me !";

	include_once "functions.php";


	$values = array();

	array_push($values, "12");
	array_push($values, "23");
	array_push($values, "34");

	echo "<br> values [ 0 ] = " . $values[0] . "<br>";
	echo " values [ 1 ] = " . $values[1] . "<br>";
	echo " values [ 2 ] = " . $values[2] . "<br>";


	/*
		echo "<br> wynik zapytania : <br><hr>";

		//query("SELECT * FROM ksiazki", "get_books", "");

		$id_klienta = 1;

		//query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_ksiazki='%s'", "get_books_by_id", "$id_ksiazki");

		echo " koszyk ilosc ksiazek = ";

		//$res = query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);
		//echo "<br>res = " . $res;

		query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id_klienta);

		
		echo "<br> $ _SESSION koszyk_ilosc_ksiazek = " ;
		echo $_SESSION['koszyk_ilosc_ksiazek'] . "<br>";
		
		//echo $_SESSION['koszyk_ilosc_ksiazek'];


		echo "<hr>";
		exit();
	*/


	if((isset($_POST['radio_input'])))
	{
		//echo "<br> name 1 = " . $_POST['name1'] . "<br>";
		//echo "<br> name 2 = " . $_POST['name2'] . "<br>";
		echo "<br> radio input value = " . $_POST['radio_input'] . "<br>";
	}
	if((empty($_POST['radio_input'])))
	{
		//echo "<br> name 1 = " . $_POST['name1'] . "<br>";
		//echo "<br> name 2 = " . $_POST['name2'] . "<br>";
		echo "<br> radio input value = empty <br>";
	}

	echo "<br><hr>";

	echo "Data i czas serwera (DateTimeImmutable) ";

	$datetime = new DateTimeImmutable();

	echo "<br>Data i czas serwera = ";
	echo $datetime->format('Y-m-d H:i:s');

	$termin_dostawy = $datetime->add(new DateInterval('P1D')); // + 1 day

	echo "<br>termin_dostawy = ";
	echo $termin_dostawy->format('Y-m-d H:i:s');;
	//echo $datetime->format('Y-m-d H:i:s');

	echo "<br>Data i czas serwera = ";
	echo $datetime->format('Y-m-d H:i:s');


	echo "<br><hr>";



?>

<hr><br>
---------------------------------------------------------------------<br><br>
<br><hr>

<form method="post">

	<!-- <label>
		
		<input type="checkbox" name="regulamin">
		
		Akceptuję regulamin

	</label> -->

	<input type="radio" name="radio_input" value="Kurier DPD"> value1 <br>
	<input type="radio" name="radio_input" value="value2"> value2 <br>

	<input type="submit" value="Wyślij dane do skryptu">

</form>






