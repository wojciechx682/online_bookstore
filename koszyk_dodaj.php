<?php
	session_start();
	include_once "functions.php";
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "template/head.php" ?>

<body>

<?php require "template/header-container.php" ?>

	<div id="container">

		<div id="nav">
		</div>

		<div id="content">

			<h3>Dodaj do koszyka</h3>

			<?php

				echo "<hr>";

				if(isset($_GET['id'])) // id_książki
				{
					$id_ksiazki = $_GET['id']; // <- przyczyna błędu. (już naprawionego ...)

					$id_ksiazki = htmlentities($id_ksiazki, ENT_QUOTES, "UTF-8");

					//$_SESSION['kategoria'] = "Horror";
					//$kategoria = $_SESSION['kategoria'];

					if(!is_numeric($id_ksiazki) || ($id_ksiazki < 1)) // jeśli $_GET['id'] nie jest liczbą
					{
						echo "Niepoprawny produkt<br>";
						echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">Wróć</a>';
						exit();
					}

					echo "id_ksiazki -> ".$id_ksiazki."<br>";

					echo "<br>lp." . " 1 <br><br>";

					echo "<b>Produkt: </b> ";
					echo query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_ksiazki='%s'", "get_books_by_id", "$id_ksiazki");	// wyświetla produkt (tyul, cena, rok_wydania)

					///////////////////////////////////////////////////////////////////////////

					echo '<form action="add_to_cart.php" method="post">';

							echo '<input type="hidden" name="id_ksiazki" value="'.$id_ksiazki.'">';

							echo "<b>Ilosc: </b> ";

							/*echo '<select name="koszyk_ilosc">';
							    echo '<option value="1">1</option>';
							    echo '<option value="2">2</option>';
							    echo '<option value="3">3</option>';
							    echo '<option value="4">4</option>';
							    echo '<option value="5">5</option>';
							echo '</select>';*/

							echo '<input type="text" id="koszyk_ilosc" name="koszyk_ilosc" value="1">';

							echo '<button type="button" onclick="increase()">+</button>';
							echo '<button type="button" onclick="decrease()">-</button>';


							echo '<br><br><input type="submit" value="Zapisz koszyk">';

					echo '</form>';

				}
			?>
			<?php

				/*if((isset($_POST['id_ksiazki'])) and (isset($_POST['ilosc'])))
				{
					echo "<br> id_ksiazki -> ".$id_ksiazki.'<br>';
					echo "<br> ilosc -> ".$ilosc.'<br>';
				}*/
			?>

			<?php

				/*if((isset($_POST['koszyk_ilosc']))   )
				{
					echo '<script>alert("940")</script>';
					echo "<br> 929 id_ksiazki -> ".$_POST['id_ksiazki'].'<br>';
					echo "<br> ilosc -> ".$_POST['koszyk_ilosc'].'<br>';
				}*/
			?>

		</div>

        <?php require "template/footer.php" ?>

	</div>

</body>
</html>