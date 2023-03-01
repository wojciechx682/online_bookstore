


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Księgarnia online</title>
	<link rel="stylesheet" href="style.css">

	<script>


		
















	</script>




</head>

<body>

	<div id="container">
		
		<div id="header">
			<h1> Księgarnia internetowa </h1>
		</div>

		<div id="top-nav">

			<!-- <a href="index.php">Strona główna</a> -->

			<div id="div_search">				

				<form action="index.php" method="get">
					<!-- Wyszukaj : -->
					<input type="text" name="input_search">

					<input type="submit" value="Szukaj">	
				</form>	

			</div>

			<div id="div_log_in">
				
				<a class="top-nav-right" href="zaloguj.php">Zaloguj</a>

			</div>

			<div id="div_register">
				
				<a class="top-nav-right" href="rejestracja.php">Zarejestruj</a>
				
			</div>

			<div id="div_cart">
				
				<a class="top-nav-right" href="koszyk.php">Koszyk</a>
				
			</div>


			<div id="div_my_account">
				
				<a class="top-nav-right" href="account.php">Moje konto</a>
				
			</div>

		</div>

		<div id="nav">			

			<h3> Kategorie </h3>
			<hr>

			
			<h3> Sortuj wg </h3>			

				<input id="title_radio" type="radio" name="sortuj_wg" value="tytul">
				<label for="title_radio">Alfabetycznie<br></label>

				<input id="cena_radio" type="radio" name="sortuj_wg" value="cena">
				<label for="cena_radio">Cena<br></label>

				<input id="rok_radio" type="radio" name="sortuj_wg" value="rok_wydania">
				<label for="rok_radio">Data wydania<br></label>

				<br><input type="radio" name="sortuj_typ" value="rosnaco">
					Rosnąco<br>

				<input type="radio" name="sortuj_typ" value="malejaco">
					Malejąco<br>

				<button id="sortowanie" onclick="moja_funkcja()">moja_funkcja</button>			
		</div>

		<div id="content">

			<!-- <button onclick="moja_funkcja('asc')">moja_funkcja()</button> -->

			<button onclick="test_fun();">test_fun())</button>

			<script>
				
				function test_fun()
				{
					var ratings = [1,2,3,4,5];

					console.log("ratings -> " + ratings);

					let result = ratings.includes(4); 

					console.log("result -> " + result); // true


					result = ratings.includes(6); 
					console.log("result -> " + result); // false

				}

			</script>


			
		</div>		

		<div id="footer">

		</div>

	</div>


		<?php

			$r['select']="7891";

			echo '<td><center><img src="www.xxxxx.pl/img/'.($r['select']).'.gif"></center></td>';
			echo "<br><br>";	
			echo "<td><center><img src=\"www.xxxxx.pl/img/".($r['select']).".gif\"></td>";

		?>
	

		<?php			

			echo '<img src="www.xxxxx.pl/img/'.($r['select']).'.gif">';
			echo "<br><br>";	
			echo "<img src=\"www.xxxxx.pl/img/".($r['select']).".gif\">";

		?>
</body>
</html>