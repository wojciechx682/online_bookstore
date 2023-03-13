<?php

	session_start();

	include_once "../functions.php";

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

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

<?php

require "../view/header-container.php"; ?>


        <div id="container">

            <main>

            <div id="main-content">

                <nav id="category-nav">
                    <ul>
                        <?php
                            query("SELECT DISTINCT kategoria FROM ksiazki ORDER BY kategoria ASC", "get_categories", "");
                        ?>
                    </ul>
                </nav>

                <!-- div style="float: left; height: 45px; width: 200px; border: 1px solid black;">asdasdsds</div>-->

                <section id="main-gallery">
                    <div class="slideshow-container">

                        <div class="mySlides fade">
                            <div class="numbertext">1 / 3</div>
                            <img src="../assets/gallery/1.png" alt="gallery" style="width:100%">
                            <div class="text">Caption Text</div>
                        </div>

                        <div class="mySlides fade">
                            <div class="numbertext">2 / 3</div>
                            <img src="../assets/gallery/2.png" alt="gallery" style="width:100%">
                            <div class="text">Caption Two</div>
                        </div>

                        <div class="mySlides fade">
                            <div class="numbertext">3 / 3</div>
                            <img src="../assets/gallery/3.png" alt="gallery" style="width:100%">
                            <div class="text">Caption Three</div>
                        </div>

                        <a class="prev" onclick="plusSlides(-1)">❮</a>
                        <a class="next" onclick="plusSlides(1)">❯</a>


                        <div style="text-align:center">
                            <span class="dot" onclick="currentSlide(1)"></span>
                            <span class="dot" onclick="currentSlide(2)"></span>
                            <span class="dot" onclick="currentSlide(3)"></span>
                        </div>

                    </div>
                </section>

                <br><br><br><br><br><br>
                <br><br><br><br><br><br>
                <br><br><br><br><br><br>


                <section id="latest-books-section">&lt;section&gt; for "Nowości"</section>
                <section id="books-promotion-section">&lt;section&gt; for "Promocje"</section>

                <br>

            </div>

            <aside id="book-filters">

                <div id="nav">

                    <?php
                        if((isset($_GET['kategoria'])) && (!empty($_GET['kategoria'])))
                        {
                            $kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8");
                            $kategoria = strip_tags($kategoria);
                            // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert("hahaha");</script>;
                            echo "<h3>".$kategoria."</h3><hr>";
                        }
                    ?>

                    <h3>Sortowanie</h3>

                    <select id="sortuj_wg">
                        <option value="1">ceny rosnąco</option>
                        <option value="2">ceny malejąco</option>
                        <option value="3">nazwy A-Z</option>
                        <option value="4">nazwy Z-A</option>
                        <option value="5">Najnowszych</option>
                        <option value="6">Najstarszych</option>
                    </select>

                    <button id="sort_button" onclick="sortBooks()">Sortuj</button>

                    <hr><br>

                    <div id="price-range">
                            <label>
                                Min: <input type="number" id="value-min">
                            </label>
                            <label>
                                Max: <input type="number" id="value-max">
                            </label>
                        <div id="slider"></div>
                    </div>

                    <br><hr>

                    <?php
                        query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", "");
                    ?>

                </div>

            </aside> <!-- "book filters" -->

            <?php

                if((isset($_GET['kategoria'])) &&
                  !(empty($_GET['kategoria'])) &&
                 (!(isset($_GET['autor'])) ||
                   (empty($_GET['autor']))) ) // <a href="index.php?kategoria=Wszystkie">Wszystkie</a>
                {
                    echo '<div id="content">';

                        echo '<script> displayNav(); </script>';

                        // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; <script>alert("hahaha");</script>;
                        $kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8");
                        $kategoria = strip_tags($kategoria);
                        $_SESSION['kategoria'] = $kategoria; // wstawienie kategorii do zmiennej sesyjnej -> (koszyk_dodaj.php - walidacja danych - czy jest to liczba ?)

                        //var_dump($_SESSION["kategoria"]);

                        echo '<div id="content-books">';

                            if($_SESSION['kategoria'] == "Wszystkie")
                            {
                                displayBooks($_SESSION['kategoria']);
                            }
                            else // --> "Dla dzieci" , "Fantastyka", "Informatyka", ...
                            {
                                //print_r($_SESSION);
                                //query("SELECT id_ksiazki, image_url, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books",  $_SESSION['kategoria']);
                                query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE kategoria LIKE '%s' AND ks.id_autora = au.id_autora", "get_books",  $_SESSION['kategoria']);

                                //($result = $polaczenie->query(sprintf("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login))))
                            }

                        echo '</div>';
                    echo '</div>';
                }
                elseif ((!(isset($_GET['kategoria'])) || (empty($_GET['kategoria']))) && (isset($_GET['autor'])) && !(empty($_GET['autor']))) // TYMCZASOWE wyświetlanie książek autora, po wpisaniu go w wyszukiwarce
                {
                    echo '<div id="content"></div>';
                        $autor = [$_GET['autor']];
                        echo '<div id="content-books">';
                            query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_autora='%s'", "get_books", $autor);
                        echo '</div>';
                    echo '</div>';
                }
                else // jeśli (nie ustawiono kategorii i autora), lub (ustawiono kategorie ORAZ autora)
                {
                    //print_r($_SESSION);

                    if((isset($_GET['input-search'])) && (!empty($_GET['input-search']))) // pole wyszukiwania
                    {
                        echo '<div id="content">';
                            echo '<script> displayNav(); </script>';

                            echo '<div id="content-books">';

                                //$search_value = $_GET['input-search'];
                                //      <script>alert("hahaha");</script>
                                //$search_value = filter_input(INPUT_GET, 'input-search', FILTER_SANITIZE_STRING);
                                $search_value = htmlentities($_GET['input-search'], ENT_QUOTES, "UTF-8");
                                $search_value = strip_tags($search_value);

                                print_r($search_value); echo "<br>";

                                //query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $search_value);
                                query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE ks.id_autora = au.id_autora AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value);

            //                            echo '<script>
            //
            //                            const searchInput = document.getElementById("input-search");
            //                            const searchResults = document.getElementById("search-results");
            //
            //                            searchInput.addEventListener("input", () => {
            //                            const query = searchInput.value;
            //
            //                            if (query.trim() !== "") {
            //                            fetch(`index.php?q=${encodeURIComponent(query)}`)
            //                            .then(response => response.json())
            //                            .then(results => {
            //                            let html = "";
            //
            //                            if (results.length > 0) {
            //                            results.forEach(result => {
            //                            html += `<div class="search-result">${result}</div>`;
            //                            });
            //                            } else {
            //                            html += `<div class="search-result">No results found</div>`;
            //                            }
            //
            //                            searchResults.innerHTML = html;
            //                            })
            //                            .catch(error => {
            //                            console.error(error);
            //                            });
            //                            } else {
            //                            searchResults.innerHTML = "";
            //                            }
            //                            });
            //                            </script>';

                            echo '</div>';
                        echo '</div>';
                    }
                    else if((isset($_GET['input-search'])) && (empty($_GET['input-search']))) // puste pole wyszukiwania
                    {
                        echo '<div id="content"></div>';
                                echo '<script> displayNav(); </script>';
                            echo '<div id="content-books">';
                                echo '<h3>Brak wyników</h3>';
                            echo '</div>';
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

            <!-- strona główna-->

            <!-- </div> koniec - content -->

            </main>
        </div>

    <?php require "../view/footer.php"; ?>

    <script src="../scripts/jquery.nouislider.js"></script>
    <script src="../scripts/filtrowanie.js"></script>
    <script src="../scripts/sortowanie_v3_2.js"></script>

    <script src="../scripts/display-slider.js"></script>

<script>

    //save selected sorting option after page reload ->

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

</body>
</html>