<?php

	session_start();

	include_once "functions.php";

    //	sprawdź połączenie z BD :
    //	$value = array();
    //	array_push($value, "1");
    //	query("", "", ""); // w przypadku błędu połączenia z BD, wyświetli komunikat rzuconego wyjątku.
    //	należy dodać to do każdej podstrony, która korzysta z połączenia z BD
    //	echo $_SESSION['login'] . '<br>';
    //	if(isset($_SESSION['zalogowany']))
    //	{
    //		    //echo '<br>'.$_SESSION['account_error'];
    //		unset($_SESSION['account_error']);
    //		    //exit();
    //	}
    //	if(isset($_SESSION['blad'])) {
    //		echo $_SESSION['blad'];
    //		exit();
    //	}

    if(isset($_GET["login-error"])) {
        echo '
                <script>
                    alert("Musisz być zaloowany !")
                    let url = new URL(window.location.href);
                    url.searchParams.delete("login-error");
                    window.location.href = url.toString();
                </script>
             ';
    }

?>

<!DOCTYPE HTML> <!-- HTML5 template consistent with the latest W3C standards -->
<html lang="pl">

<?php require "template/head.php"; // <head> tag ?>

<body>

<?php require "template/header-container.php"; // header template ?>

	<div id="container">

		<div id="nav">

			<?php

				if((isset($_GET['kategoria'])) && (!empty($_GET['kategoria'])))
				{
					$kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8"); // Sanityzacja danych wprowadzonych od użytkownika : // html entities = encje html'a;// $kategoria = '<script>alert("hahaha");</script>;

					echo "<h3>".$kategoria."</h3><hr>";
				}

			?>

			<h3> Sortowanie </h3>

            <select id="sortuj_wg">
                <option value="1">ceny rosnąco</option>
                <option value="2">ceny malejąco</option>
                <option value="3">nazwy A-Z</option>
                <option value="4">nazwy Z-A</option>
                <option value="5">Najnowszych</option>
                <option value="6">Najstarszych</option>
            </select>

            <!-- <br><br><button id="sort_button" onclick="sortuj()">Sortuj</button> -->
            <button id="sort_button" onclick="sortBooks()">Sortuj</button>

            <hr><br>

<!--            <div id="slider"></div>-->

            <div id="price-range">
                Min: <input type="number" id="value-min" />
                Max: <input type="number" id="value-max" />
                <div id="slider">

                </div>

            </div>

            <br><hr>

            <?php
                query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", "");
            ?>

		</div>

		<div id="content">

			<?php

				echo "<hr>";

				if((isset($_GET['kategoria'])) && !(empty($_GET['kategoria'])) && (!(isset($_GET['autor'])) || (empty($_GET['autor']))) ) // <a href="index.php?kategoria=Wszystkie">Wszystkie</a>
				{
					echo '<script> displayNav(); </script>';

					$kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8"); // html entities = encje html'a	// Sanityzacja danych wprowadzonych od użytkownika; <script>alert("yey");</script>

                    $_SESSION['kategoria'] = $kategoria; // wstawienie kategorii do zmiennej sesyjnej -> (koszyk_dodaj.php - walidacja danych - czy jest to liczba ?)

                    //var_dump($_SESSION["kategoria"]);

					echo '<div id="content-books">';

                        if($_SESSION['kategoria'] == "Wszystkie")
                        {
                            //query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_books", ""); // get_books() - wyświetla książki (divy -> book0, ...)

                            displayBooks($_SESSION['kategoria']);
                        }
                        else // Kategoria -> "Dla dzieci" , "Fantastyka", "Informatyka", ...
                        {
                            query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books",  $_SESSION['kategoria']);

                            //($result = $polaczenie->query(sprintf("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login))))
                        }

					echo '</div>';
				}
                elseif ((!(isset($_GET['kategoria'])) || (empty($_GET['kategoria']))) && (isset($_GET['autor'])) && !(empty($_GET['autor']))) // TYMCZASOWE wyświetlanie książek autora, po wpisanio go w wyszukiwarce
                {
                     $values = array();
                     array_push($values, $_GET['autor']);
                     query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_autora='%s'", "get_books", $values);
                }
				else // jeśli (nie ustawiono kategorii i autora), lub (ustawiono kategorie ORAZ autora)
				{
                    print_r($_GET['input-search']);

					if((isset($_GET['input-search'])) && (!empty($_GET['input-search']))) // pole wyszukiwania
					{
						echo '<script> displayNav(); </script>';

                        echo '<div id="content-books">';

                            $search_value = htmlentities($_GET['input-search'], ENT_QUOTES, "UTF-8");

                            query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $search_value);

						echo '</div>';

					}
					else if((isset($_GET['input-search'])) && (empty($_GET['input-search']))) // puste pole wyszukiwania
					{
						echo '<script> displayNav(); </script>';
						echo '<div id="content-books">';
						    echo '<h3>Brak wyników</h3>';
						echo '</div>';
					}
					else
					{
						//////////////////////////////////////////////////////////////////////////////////////////////////
						// STRONA GŁÓWNA //
						//////////////////////////////////////////////////////////////////////////////////////////////////

                        // query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki", "get_books", "");
					}

				}

			?>

			<!-- Storna główna -->

			<!-- //////////////////////////////////////////////////////////////////////////////////////////////////
				 // STRONA GŁÓWNA //
				 ////////////////////////////////////////////////////////////////////////////////////////////////// -->


            <!-- np tytuł książki, lub imie autora --> <!-- "Jerzy", "Tomasz", "Symfonia C++", "Podstawy PHP" -->
<!--			<div id="div_advanced_search">-->
<!---->
<!--				<form action="index.php" method="get">-->
<!---->
<!--					<input type="search" name="wyrazenie"> -->
<!---->
<!--					<select id="metoda" name="metoda">-->
<!--						<option value="autor">autor</option>-->
<!--						<option value="tytul">tytul</option>-->
<!--					</select>-->
<!---->
<!--					<input type="submit" value="Szukaj">-->
<!---->
<!--				</form>-->
<!---->
<!--			</div>-->

<!--			<hr>-->

			<?php

				if(isset($_GET['wyrazenie']) && !empty($_GET['wyrazenie']) && isset($_GET['metoda']) && !empty($_GET['metoda']))
				{
					$wyrazenie = $_GET['wyrazenie'];
					$metoda = $_GET['metoda'];

					echo " <br>Wyrażenie = $wyrazenie <br>";
					echo " <br>Metoda = $metoda <br>";

					if($metoda == "autor")
					{
						//$query = "SELECT * FROM ksiazki, autor WHERE ksiazki.id_autora = autor.id_autora AND autor.imie == "
						//		 "SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC"

						$values = array();
						array_push($values, $wyrazenie);
						array_push($values, $wyrazenie);

						 query("SELECT id_ksiazki, autor.id_autora, tytul, cena, rok_wydania, kategoria FROM ksiazki, autor WHERE ksiazki.id_autora = autor.id_autora AND (autor.imie = '%s' OR autor.nazwisko = '%s')", "advanced_search", $values);
						 // dalej -> stworzyć funckję advanced_search ...

						//query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", ""); //
					}
					else if ($metoda == "tytul")
					{
						echo "<hr> ";
						echo " <br>Wyrażenie = $wyrazenie <br>";
						echo " <br>Metoda = $metoda <br>";

						query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $wyrazenie);
					}
				}
			?>

		</div>

        <?php require "template/footer.php"; ?>

	</div>

    <script>

        // save selected sorting option after page reload ->

        var selectElement = document.getElementById("sortuj_wg");

        selectElement.addEventListener("change", function() {
            var selectedValue = selectElement.value;
            localStorage.setItem("selectedValue", selectedValue);
        });

        window.addEventListener("load", function() {
            var selectedValue = localStorage.getItem("selectedValue");

            if (selectedValue && selectElement) {
                selectElement.value = selectedValue;
                <?php
                    if(isset($_GET['kategoria'])) {
                        echo 'sortBooks();';
                    }
                ?>
            }
        });

    </script>

	<script src="jquery.js"></script>
	<script src="jquery-3.6.3.js"></script>
	<script src="sortowanie_v3_2.js"></script>

    <script src="jquery.nouislider.js"></script>
    <script src="Filtrowanie,%20Wyszukiwanie,%20Sortowanie/filtrowanie.js"></script>


</body>
</html>