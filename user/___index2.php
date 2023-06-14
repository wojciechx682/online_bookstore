<?php
    session_start();
    include_once "../functions.php";

        //	sprawdź połączenie z BD
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

    // (?) można lepiej zapisać -->

    if(isset($_GET['kategoria']) && !empty($_GET['kategoria']))
    {
        // to się spełni, jeśli następiło wejście pod dowolna kategorię --> index.php?kategoria=Wszystkie;
            // chnage special characters to their HTML entities representation, and then the strip_tags() function is used to remove any HTML tags from the input. This helps prevent potential security vulnerabilities such as cross-site scripting (XSS) attacks;
        /*echo "<script>console.log('37');</script>";*/
        $_SESSION["kategoria"] = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
        // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert();</script>;
    }
    elseif(isset($_SESSION['kategoria']) && !empty($_SESSION['kategoria']) && isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"]))
    {
        // to się spełni, jeśli wsześniej następiło wejście pod dowolna kategorię --> index.php?kategoria=Wszystkie;
        // ORAZ           wprowadzono tytuł z input-search-nav;
                //echo "<script>console.log('43');</script>";
        $_SESSION["kategoria"] = htmlentities($_SESSION['kategoria'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
        // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert();</script>;
    }
    if(isset($_POST["adv-search-category"]))
    {
        // to się spełni, jeśli nastąpił submit z wyszukiwania-zaawansowanego;
            /*echo "<script>console.log('49');</script>";*/
        $_SESSION["kategoria"] = htmlentities($_POST['adv-search-category'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
        // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert("hahaha");</script>;
    }
    if(isset($_GET["input-search"]))
    {
        /*echo "<script>console.log('54');</script>";*/
        $_SESSION["kategoria"] = "Wszystkie";
    }
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

    <div id="all-container">

        <?php require "../view/___header-container.php"; ?>

        <div id="container">

            <main>

                <div id="main-content">

                    <nav id="category-nav">
                        <ul>
                            <?php
                                //query("SELECT DISTINCT nazwa FROM kategorie ORDER BY nazwa ASC", "get_categories", "");
                            ?>
                        </ul>
                    </nav>

                    <!-- div style="float: left; height: 45px; width: 200px; border: 1px solid black;">asdasdsds</div>-->

                    <section id="main-gallery">
                        <!-- <div class="slideshow-container">
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
                        </div> -->
                    </section>

                    <!-- <section id="latest-books-section">&lt;section&gt; for "Nowości"</section>
                    <section id="books-promotion-section">&lt;section&gt; for "Promocje"</section> -->
                    <!-- <br> -->

                </div>

                <aside id="book-filters">  <!-- nav -->

                    <div id="nav" class="nav-visible">

                        <?= "<h3>".$_SESSION["kategoria"]."</h3>"; ?>

                        <h3>Sortowanie</h3>

                        <select id="sortuj_wg">
                            <option value="1">ceny rosnąco</option>
                            <option value="2">ceny malejąco</option>
                            <option value="3">nazwy A-Z</option>
                            <option value="4">nazwy Z-A</option>
                            <option value="5">Najnowszych</option>
                            <option value="6">Najstarszych</option>
                        </select>

                        <!--<button id="sort_button" onclick="sortBooks()">Sortuj</button>-->

                        <h3>Cena</h3>

                        <div id="price-range">
                            <label>
                                <span>
                                    Min
                                </span>
                                    <input type="number" id="value-min">
                            </label>
                            <label>
                                <span>
                                    Max
                                </span>
                                    <input type="number" id="value-max">
                            </label>
                            <div id="slider"></div>
                        </div>

                        <!-- search by title in that category -->

                        <div id="input-search-nav">
                            <h3>Tytyuł</h3>
                            <!-- (szukaj tytułu w tej kategorii) -->
                            <!-- <div id="div-search">-->
                            <form action="___index2.php" method="get">
                                <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                                <input type="submit" value="">
                            </form>
                        </div>

                        <?php
                            query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", ""); // lista <ul> autorów
                        ?>

                        <button id="filter-authors">Zastosuj</button>

                    </div> <!-- #nav -->

                </aside> <!-- #book-filters -->

                <?php

                if( (isset($_GET['kategoria'])) &&
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

                        /*var_dump($_SESSION);
                        print_r($_SESSION);
                        print_r($_POST);*/

                    echo '<div id="content-books">';

                    displayBooks($_SESSION['kategoria']);
    //                            if($_SESSION['kategoria'] == "Wszystkie")
    //                            {
    //                                displayBooks($_SESSION['kategoria']);
    //                            }
                    /* else // --> "Dla dzieci" , "Fantastyka", "Informatyka", ...
                     {
                         //print_r($_SESSION);
                         //query("SELECT id_ksiazki, image_url, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books",  $_SESSION['kategoria']);
                         query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE kategoria LIKE '%s' AND ks.id_autora = au.id_autora", "get_books",  $_SESSION['kategoria']);

                         //($result = $polaczenie->query(sprintf("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login))))
                     }*/

                    echo '</div>'; // content-books
                    echo '</div>'; // content
                }
                elseif ((!(isset($_GET['kategoria'])) || (empty($_GET['kategoria']))) &&
                        (isset($_GET['autor'])) && !(empty($_GET['autor']))) // TYMCZASOWE wyświetlanie książek autora, po wpisaniu go w wyszukiwarce
                {
                    echo '<div id="content"></div>';
                    $autor = [$_GET['autor']];
                    echo '<div id="content-books">';
                        query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE id_autora='%s'", "get_books", $autor); // do zmiany -> id subkategoii
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

                        $search_value = filter_input(INPUT_GET, 'input-search', FILTER_SANITIZE_STRING);

                        //print_r($search_value); echo "<br>";

                        unset($_SESSION["kategoria"]);
                        $_SESSION["kategoria"] = "Wszystkie"; // ew. do zmiany w przyszłości

                        //query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE ks.id_autora = au.id_autora AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value);
                        /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, kt.nazwa, sb.id_kategorii
                                    ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value);*/
                        query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                         kt.nazwa, sb.id_kategorii, 
                                            au.imie, au.nazwisko 
                                         FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb 
                                         WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii 
                                         AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value); // kategorie => nazwa, id_kategorii

                        echo '</div>';
                        echo '</div>';
                    }
                    else if(isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"])) {
                        // wyszukiwanie tytuły z panelu <nav> (tytuł książki z danej kategorii - $_SESSION["kategoria"]);

                        if(isset($_SESSION["kategoria"]) && !empty($_SESSION["kategoria"])) {

                            /*print_r($_SESSION);*/

                            $title = filter_input(INPUT_GET, "input-search-nav", FILTER_SANITIZE_STRING);
                            $values = [$title];

                            echo '<div id="content">';
                            echo '<script> displayNav(); </script>';
                            echo '<div id="content-books">';

                            //echo "<br>266<br>";

                            /*$query = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                                     ks.kategoria,
                                     ks.rating, au.imie, au.nazwisko
                                     FROM ksiazki AS ks, autor AS au
                                     WHERE ks.id_autora = au.id_autora
                                     AND ks.tytul LIKE '%%%s%%'";*/

                            /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                                                ks.rating,
                                             kt.nazwa, sb.id_kategorii,
                                                au.imie, au.nazwisko
                                             FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb
                                             WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                             AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value); // kategorie => nazwa, id_kategorii*/

                            $query = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, 
                                             ks.rating,
                                             kt.nazwa, sb.id_kategorii, 
                                              au.imie, au.nazwisko 
                                             FROM ksiazki AS ks, 
                                                  autor AS au, 
                                                  kategorie AS kt, 
                                                  subkategorie AS sb 
                                             WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                               
                                             AND ks.tytul LIKE '%%%s%%'";

                            /*$query = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                                                 ks.rating,
                                                 ks.kategoria,
                                                  au.imie, au.nazwisko
                                                 FROM ksiazki AS ks,
                                                      autor AS au
                                                 WHERE ks.id_autora = au.id_autora
                                                 AND ks.tytul LIKE '%%%s%%'"; */

                            if($_SESSION["kategoria"] != "Wszystkie") {

                                $where = array();
                                //$where[] = " AND ks.kategoria LIKE '%%%s%%'"; //%%%s%%
                                $where[] = " AND kt.nazwa LIKE '%%%s%%'"; //%%%s%%
                                $values[] = $_SESSION['kategoria'];

                                /*echo "<br>276<br>";*/
                            }

                            if (!empty($where)) {
                                // Combine the conditions into a single WHERE clause
                                $query .= implode("", $where);

                                /*echo "<br>283<br>";*/
                            }

                            //echo "<br> query -> ".$query . "<br>";
                            //echo "<br> values -> ".var_dump($values) . "<br>";

                            query($query, "get_books", $values);
                            echo '</div>';
                            echo '</div>';
                        }
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

                        // $wyrazenie = filter_input(INPUT_GET, 'wyrazenie', FILTER_SANITIZE_STRING); // ✓

                        query("SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE tytul LIKE '%%%s%%'", "get_books", $wyrazenie);
                    }
                }
                ?>

                <!-- strona główna-->

                <!-- </div> koniec - content -->

                <?php

                // advanced search result -->

                //                    if ( isset($_POST["adv-search-title"]) && !empty($_POST["adv-search-title"]) && isset($_POST["adv-search-category"]) && !empty($_POST["adv-search-category"]) && isset($_POST["adv-search-author"]) && !empty($_POST["adv-search-author"]) && isset($_POST["year-min"]) && !empty($_POST["year-max"])
                //                    ) {
                //                        echo '<script>alert("yes !")</script>';
                //                        print_r($_POST);
                //                    }

                //                    if ( isset($_POST["adv-search-category"]) && !empty($_POST["adv-search-category"]))
                //                    {
                //                        echo '<script>alert("yes !")</script>';
                //                        print_r($_POST);
                //                    }

                if ( isset($_POST["year-min"]) && !empty($_POST["year-min"]) && isset($_POST["year-max"]) && !empty($_POST["year-max"]) && !isset($_GET["kategoria"])
                ) {

                    echo '<div id="content">';

                    echo '<script> displayNav(); </script>';

                    echo '<div id="content-books">';

    //                                                            echo '<script>alert("yes !")</script>';
    //                                                            echo "<br><br><br>";

                    /*echo "<br><hr> SESSION --> <br><br><br>";*/
                    /*print_r($_SESSION);*/
                    /*echo "<br><br><hr><br><br>";*/

                    /*echo "<br><hr> POST --> <br><br><br>";*/
                    /*print_r($_POST);*/
                    /*echo "<br><br><hr><br><br>";*/

    //                                                            echo "<br><br><br>";
    //
    //                                                            echo "<br> title -> " . $_POST["adv-search-title"] . ";<br>";
    //                                                            echo "<br> category -> " . $_POST["adv-search-category"] . ";<br>";
    //                                                            echo "<br> author -> " . $_POST["adv-search-author"] . ";<br>";
    //                                                            echo "<br> year-min -> " . $_POST["year-min"] . ";<br>";
    //                                                            echo "<br> year-max -> " . $_POST["year-max"] . ";<br>";
    //
    //                                echo "<hr><br><hr>";

                    ////////////////////////////////////////////////////////////////////////////////////////

                    /* query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                              kt.nazwa, sb.id_kategorii,
                                                 au.imie, au.nazwisko
                                              FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb
                                              WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                              AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value); // kategorie => nazwa, id_kategorii*/

                    // Set up the initial query string
                    //$query = "SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki";
                    $query = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, 
                          ks.rating,
                          kt.nazwa, sb.id_kategorii,  
                           au.imie, au.nazwisko 
                          FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb";

                    // Validate and sanitize input data

    //                                $_POST =>
    //                                (
    //                                    [       adv-search-title       ] => "bbb"
    //                                    [       adv-search-category       ] => Komiks
    //                                    [       adv-search-author       ] => 13   // id_autora
    //                                    [       year-min       ] => 2005
    //                                    [       year-max       ] => 2018
    //                                )

                    if (isset($_POST["adv-search-title"]) && !empty($_POST["adv-search-title"])) {
                        $title = filter_input(INPUT_POST, "adv-search-title", FILTER_SANITIZE_STRING);
                    }
                    if (isset($_POST["adv-search-category"]) && !empty($_POST["adv-search-category"])) {
                        $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING);
                    }

    //                                if((!is_numeric($_POST["adv-search-author"]))) {
    //                                    //echo '<script>displaySearchError();</script>';
    //                                    $_SESSION["advanced-search-error"] = "Podaj poprawne dane";
    //                                }

    //                                if (!is_numeric($_POST["adv-search-author"])) {
    //                                    $_SESSION["advanced-search-error"] = "Podaj poprawne dane";
    //                                    //header('Location: index.php');
    ////                                    echo '<script>window.location.href="index.php";</script>';/
    //                                    //exit();//
    //                                }
                    if (isset($_POST["adv-search-author"]) && !empty($_POST["adv-search-author"])) {
                        $author = filter_input(INPUT_POST, "adv-search-author", FILTER_VALIDATE_INT);
                        /*if (!$author || !is_numeric($_POST["adv-search-author"])) {
                            // Handle invalid input (e.g. display an error message)
                            $_SESSION["advanced-search-error"] = "Podaj poprawne dane";
                        }*/
                    }
                    //echo "<br> autor 438 --> ".$author; exit();
    //                                if(isset($_SESSION["advanced-search-error"]) && !empty($_SESSION["advanced-search-error"])) {
    //                                    echo "<br><br><span id='advanced-search-error'>" . $_SESSION["advanced-search-error"] . "</span>";
    //                                    $_SESSION["advanced-search-error"] = null;
    //                                }
                    // Initialize an array to store the conditions for the WHERE clause

                    $where = array();
                    $values = array();

                    // Check if the user provided a book title
                    if (!empty($_POST['adv-search-title'])) {
                        // Add a condition for the book title
                        //$where[] = "ks.tytul LIKE '%" . $_POST['adv-search-title'] . "%'";
                        $where[] = "ks.tytul LIKE '%%%s%%'"; //%%%s%%
                        $values[] = $_POST['adv-search-title'];
                    }

                    // Check if the user selected a category
                    if ($_POST['adv-search-category'] != 'Wszystkie') {
                        // Add a condition for the category
                        //$where[] = "ks.kategoria = '" . $_POST['adv-search-category'] . "'";
                        $where[] = "kt.nazwa = '%s'";
                        $values[] = $_POST['adv-search-category'];

                        $_SESSION["kategoria"] = $_POST["adv-search-category"];
                    }

                    // Check if the user selected an author
                    if (!empty($_POST['adv-search-author'])) {
                        // Add a condition for the author
                        //$where[] = "ks.id_autora = " . $_POST['adv-search-author'];
                        $where[] = "ks.id_autora = '%s'";
                        $values[] = $_POST['adv-search-author'];
                    }

                    // Check if the user provided a minimum year
                    if (!empty($_POST['year-min'])) {
                        // Add a condition for the minimum year
                        //$where[] = "ks.rok_wydania >= " . $_POST['year-min'];
                        $where[] = "ks.rok_wydania >= '%s'";
                        $values[] = $_POST['year-min'];
                    }

                    // Check if the user provided a maximum year
                    if (!empty($_POST['year-max'])) {
                        // Add a condition for the maximum year
                        //$where[] = "ks.rok_wydania <= " . $_POST['year-max'];
                        $where[] = "ks.rok_wydania <= '%s'";
                        $values[] = $_POST['year-max'];
                    }

                    // Check if any conditions were added to the WHERE clause
                    if (!empty($where)) {
                        // Combine the conditions into a single WHERE clause
                        $query .= " WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii AND " . implode(" AND ", $where);
                    }

                    // echo '<br><hr><br> <span style="color: blue;"> query ( ) &rarr; ' . $query . '</span><br><br>';

                    // echo "<hr><br> query ( ) -- > " . $query . "<br><br>"; //exit();

                    // Execute the query
                    query($query, "get_books", $values);

                    // echo '<div style="height: 300px; border: 1px dashed black;"></div>';

                    echo '</div>';
                    echo '</div>';
                }

                ?>

            </main>
        </div>

        <!-- <footer>
            <div id="footer">
                <script src="../scripts/set-theme.js"></script>
                <pre>
                    <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button>  © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
                </pre>
            </div>
        </footer> -->

        <?php require "../view/___footer.php"; ?>

    </div>


<?php
    if(!isset($_SESSION["kategoria"]) || empty($_SESSION["kategoria"])) {
        echo '<script src="../scripts/hide-search-nav.js"></script>';
    }
    else {
        echo '<script src="../scripts/show-search-nav.js"></script>';
    }
?>

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

    // nav-bar -->
    /*let slider = document.querySelector(".noUi-origin");
    console.log("\n\n slider--> ", slider);*/

</script>

</body>
</html>