<?php

	$forma_dostawy = $_POST['zamowienie_typ_dostawy'];    // atrybut "value" elementu "input" (type radio)
	$forma_platnosci = $_POST['zamowienie_typ_platnosci'];	

	$datetime = new DateTime(); // obiekt klasy DateTime
						
		//$datetime = $datetime->format('Y-m-d H:i:s'); // Data i czas serwera 	
	//echo "<br> data i czas serwera = " . $datetime->format('Y-m-d H:i:s') . "<br>"; // Data i czas serwera 	
	
	///////////////////////////////////////////////////////////////////////
	/*$d = $data->format('d');
	$m = $data->format('m');
	$Y = $data->format('Y');

	$H = $data->format('H');
	$i = $data->format('i');
	$s = $data->format('s');*/
	
	$data_zlozenia_zamowienia = $datetime->format('Y-m-d H:i:s');

	// Data złożenia zamówienia : 
	echo "<br><br> Data złożenia zamówienia = " . $data_zlozenia_zamowienia ."<br>";







?>