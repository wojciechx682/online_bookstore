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

    /*if(isset($_GET["login-error"])) {
        echo '
                    <script>
                        alert("Musisz być zalogowany !")
                        let url = new URL(window.location.href);
                        url.searchParams.delete("login-error");
                        window.location.href = url.toString();
                    </script>
                 ';
    }*/

    // (?) można lepiej zapisać -->

    if( isset($_GET['kategoria']) && ! empty($_GET['kategoria']) ) // if variable EXISTS and has a NON-EMPTY value;
    {
        // przypadek wejśia w dowolną kategorię z górnego panelu;
            //echo '<script>console.log("\n38 - isset GET kategoria == true\n")</script>';
        $_SESSION["kategoria"] = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8"); // "Wszystkie", "Informatyka", "Horror"
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    }
    /*elseif(isset($_SESSION['kategoria']) && !empty($_SESSION['kategoria']) && isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"]))
    {
        // to się spełni, jeśli wsześniej następiło wejście pod dowolna kategorię --> index.php?kategoria=Wszystkie;
        // ORAZ           wprowadzono tytuł z input-search-nav;
                //echo "<script>console.log('43');</script>";
        $_SESSION["kategoria"] = htmlentities($_SESSION['kategoria'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
        // sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; $kategoria = <script>alert();</script>;
    }*/
    elseif( ! isset($_GET["kategoria"]) && ! isset($_GET["input-search-nav"]) )
    {
        //echo '<script>console.log("\n59 - kategoria nie była w parametrze GET\n")</script>'; // Strona główna, , Input-search

        $_SESSION["kategoria"] = "Wszystkie";
    }

    // od teraz kategoria jest ZAWSZE ustawiona;

        if( isset($_POST["adv-search-category"]) )
        {
            // to się spełni, jeśli nastąpił submit z wyszukiwania-zaawansowanego; - zmienna $_SESSION["kategoria"] przejmie wartość z tego formularza;

            //echo "<script>console.log('65 - kategoria była ustawiona w wyszukiwaniu zaawansowanym (użyto wyszukiwania zaawansowanego)');</script>";
            $_SESSION["kategoria"] = htmlentities($_POST['adv-search-category'], ENT_QUOTES, "UTF-8");
            $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
        }
    /*if(isset($_GET["input-search"])) // nie ma sensu tego pisać, ponieważ kategoria i tak będzie ustawiona (warunek ! isset GET['kat'] )
    {
        echo "<script>console.log('\n77\n');</script>";
        $_SESSION["kategoria"] = "Wszystkie";
    }*/

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/___header-container.php"; ?>

        <div id="container">

            <main>

                <aside id="book-filters">

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

                        <!-- <button id="sort_button" onclick="sortBooks()">Sortuj</button> -->

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

                        <div id="input-search-nav-div">
                            <label for="input-search-nav">
                                <h3>Tytyuł</h3>
                            </label>
                            <form action="___index2.php" method="get"> <!-- (szukaj tytułu w tej kategorii) -->
                                <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                                <input type="submit" value="">
                            </form>
                        </div>

                        <?php
                            query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor", "get_authors", ""); // <ul> authors list;
                        ?>

                        <button id="filter-authors">Zastosuj</button>

                    </div> <!-- #nav -->

                </aside> <!-- #book-filters -->

                <?php

                    /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr>"*/

                    // nie ma sensu sprawdzać czy kategoria jest ustawiona, ponieważ zawsze jest (w zmiennej $_SESSION['kat']);
                        // (z wyjątkiem gdy wprowadzono tytuł w input-search-nav);

                ?>

                <?php

                    //   $_GET['kategoria'] --> $_SESSION["kategoria"] --> "Horror"    (zapis do ZS)
                    // ! $_GET['kategoria'] --> $_SESSION["kategoria"] --> "Wszystkie" (domyślnie)
                    // ✓ Kategoria jest ustawiona zawsze;


                    if (
                            isset($_GET["input-search"])
                    ) {

                        // ✓ kategoria nie była w parametrze GET, więc przyjmie wartość "Wszystkie" - linia 52;

                        if( ! empty($_GET["input-search"]) ) {

                            //echo "180 input-seach -> " . $_GET["input-search"] . "<br>";
                            // echo '<script> displayNav(); </script>'; // do usunięcia - to funkcja tutaj NIC NIE ROBI ale zostawiam jakby coś;
                            // input-search sanitization;
                            $search_value = filter_input(INPUT_GET, 'input-search', FILTER_SANITIZE_STRING);

                            echo " 180 input-seach (sanitized) -> " . $search_value . "<br>";

                            // ew warunek jeśli jest różne od oryginalnej wartości wejściowej -> wyświetlić komunikat "podaj poprawne dane";
                            query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                                     kt.nazwa, sb.id_kategorii, 
                                                        au.imie, au.nazwisko 
                                                     FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb 
                                                     WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii 
                                                     AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value); // kategorie => nazwa, id_kategorii;
                        } else { // puste pole wyszukiwania;

                            echo '<h3>Brak wyników</h3>'; // (!) ewentualnie można to zrobić wewnątrz funkcji query (?);
                        }
                    }
                    elseif ( isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"]) ) {

                        // ✓ tutaj zmienna sesyjna "kategoria" przyjmuje wartość "Wszystkie" lub dowolną inną kategorią z istniejących - ponieważ wsześniej zostaje ustawiona;

                        // echo "198 input-seach-nav -> " . $_GET["input-search-nav"] . "<br>";

                        // input-search-nav sanitization;
                        $title = filter_input(INPUT_GET, "input-search-nav", FILTER_SANITIZE_STRING);

                        echo "198 input-seach-nav -> " . $title . "<br>";

                        $values = [$title];

                        //echo '<script> displayNav(); </script>'; // do usunięcia - to funkcja tutaj NIC NIE ROBI ale zostawiam jakby coś;

                        // budowanie kwerendy w zależności od tego czy kategoria == "Wszystkie" czy jest to konkretna kategoria;
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

                        if($_SESSION["kategoria"] != "Wszystkie") { // kategoria zawsze jest ustawiona wsześniej, przyjmuje wartość "Wszystkie" lub dowolną inną z istniejących;

                            // jeśli kategoria to np. "Informatyka", "Horror", "Fantastyka";

                            $where = array(); // [] ?
                                //$where[] = " AND ks.kategoria LIKE '%%%s%%'"; //%%%s%%
                            $where[] = " AND kt.nazwa LIKE '%%%s%%'"; //%%%s%% // "Informatyka", "Horror", "Fantastyka";
                            $values[] = $_SESSION['kategoria']; // dodanie do tablicy argumentów zmiennej kategoria - do użycia w funkcji query(); // od teraz values = ["input-search-nav" (tytul), "kategoria"];
                        }

                        if (!empty($where)) { // dodanie do zapytania warunku  w którym kategoria to ->  "Informatyka", "Horror", "Fantastyka";

                            // combine the conditions into a single WHERE clause
                            $query .= implode("", $where);

                            /*echo "<br>283<br>";*/
                        }

                        query($query, "get_books", $values);

                    }

                    // wyszukiwanie zaawansowane - advanced search result (POST);

                    else if ( isset($_POST["year-min"]) && !empty($_POST["year-min"]) &&
                              isset($_POST["year-max"]) && !empty($_POST["year-max"])

                    ) {
                        // set up the initial query string
                            // $query = "SELECT id_ksiazki, tytul, cena, rok_wydania, kategoria FROM ksiazki";
                        $query = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, 
                          ks.rating,
                          kt.nazwa, sb.id_kategorii,  
                           au.imie, au.nazwisko 
                          FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb";

                        // validate and sanitize input data (advanced search);

                        //                                $_POST =>
                        //                                (
                        //                                    [       adv-search-title       ] => "bbb"
                        //                                    [       adv-search-category       ] => Komiks
                        //                                    [       adv-search-author       ] => 13   // id_autora
                        //                                    [       year-min       ] => 2005
                        //                                    [       year-max       ] => 2018
                        //                                )


                        if ( isset($_POST["adv-search-title"]) && !empty($_POST["adv-search-title"]) ) {
                            // sanitize adv-seatch-title;
                            $title = filter_input(INPUT_POST, "adv-search-title", FILTER_SANITIZE_STRING);
                        }
                        if ( isset($_POST["adv-search-category"]) && !empty($_POST["adv-search-category"]) ) {
                            // sanitize category;
                            $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING);
                        }
                        if ( isset($_POST["adv-search-author"]) && !empty($_POST["adv-search-author"]) ) {
                            // sanitize adv-search-author
                            $author = filter_input(INPUT_POST, "adv-search-author", FILTER_VALIDATE_INT);
                                /* if (!$author || !is_numeric($_POST["adv-search-author"])) {
                                    // Handle invalid input (e.g. display an error message)
                                    $_SESSION["advanced-search-error"] = "Podaj poprawne dane";
                                } */
                        }

                        // Initialize an array to store the conditions for the WHERE clause;

                        $where = array();
                        $values = array();

                        // check if the user provided a book title;
                        if (!empty($_POST['adv-search-title'])) {
                            // Add a condition for the book title (!)
                            // $where[] = "ks.tytul LIKE '%" . $_POST['adv-search-title'] . "%'";
                            $where[] = "ks.tytul LIKE '%%%s%%'"; //%%%s%%
                            $values[] = $_POST['adv-search-title']; // values += ["title"];
                        }

                        // check if the user selected a category
                        if ($_POST['adv-search-category'] != 'Wszystkie') {
                            // Add a condition for the category
                                //$where[] = "ks.kategoria = '" . $_POST['adv-search-category'] . "'"; // do usunięcia - ponieważ zmiena POST może mieć wartość "Wszystkie" - a takiej nazwy nie ma w tabeli "kategorie" !
                            $where[] = "kt.nazwa = '%s'";
                            $values[] = $_POST['adv-search-category']; // values += ["kategoria"];

                            $_SESSION["kategoria"] = $_POST["adv-search-category"]; // ✓
                        }

                        // Check if the user selected an author
                        if (!empty($_POST['adv-search-author'])) {
                            // Add a condition for the author
                            //$where[] = "ks.id_autora = " . $_POST['adv-search-author'];
                            $where[] = "ks.id_autora = '%s'";
                            $values[] = $_POST['adv-search-author'];
                        }

                        // check if the user provided a minimum year
                        if (!empty($_POST['year-min'])) {
                            // Add a condition for the minimum year
                            //$where[] = "ks.rok_wydania >= " . $_POST['year-min'];
                            $where[] = "ks.rok_wydania >= '%s'";
                            $values[] = $_POST['year-min'];
                        }

                        // check if the user provided a maximum year
                        if (!empty($_POST['year-max'])) {
                            // Add a condition for the maximum year
                            //$where[] = "ks.rok_wydania <= " . $_POST['year-max'];
                            $where[] = "ks.rok_wydania <= '%s'";
                            $values[] = $_POST['year-max'];
                        }

                        // check if any conditions were added to the WHERE clause
                        if (!empty($where)) {
                            // Combine the conditions into a single WHERE clause
                            $query .= " WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii AND " . implode(" AND ", $where);
                        }

                        // execute the query
                        query($query, "get_books", $values);

                    }


                    /*elseif ( !isset($_GET["input-search"]) ) {

                        echo "<br> input-seach is not set <br>";

                    }*/
                    else {
                        // domyślnie - strona główna - LUB - GET kategoria ?????? NA PEWNO ? DODAŁEM WIĘCEJ WARUNKÓW WYŻEJ

                        echo "<br>strona główna - LUB - GET kategoria<br>";

                        // echo '<script> console.log("170 --> \n\n"); displayNav(); </script>'; // odpala funkcję ale nie widać zmian z nav'em;

                        /*sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; <script>alert("hahaha");</script>;
                        $kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8"); // do usunięcia;
                        $kategoria = strip_tags($kategoria); // do usunięcia
                        $_SESSION['kategoria'] = $kategoria; // do usunięcia
                        ~ (?) wstawienie kategorii do zmiennej sesyjnej -> (koszyk_dodaj.php - walidacja danych - czy jest to liczba ?); // (?);*/
                        /*echo '<div id="content">';
                            echo '<div id="content-books">';*/

                            displayBooks($_SESSION['kategoria']);
                            //                            if($_SESSION['kategoria'] == "Wszystkie")
                            //                            {
                            //                                displayBooks($_SESSION['kategoria']);
                            //                            }
                            /* else // --> "Dla dzieci" , "Fantastyka", "Informatyka", ...
                             {
                                 // print_r($_SESSION);
                                 // query("SELECT id_ksiazki, image_url, tytul, cena, rok_wydania, kategoria FROM ksiazki WHERE kategoria LIKE '%s'", "get_books",  $_SESSION['kategoria']);
                                 query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.rating, au.imie, au.nazwisko FROM ksiazki AS ks, autor AS au WHERE kategoria LIKE '%s' AND ks.id_autora = au.id_autora", "get_books",  $_SESSION['kategoria']);

                                 // ($result = $polaczenie->query(sprintf("UPDATE klienci SET imie='%s', nazwisko='%s', miejscowosc='%s', ulica='%s', numer_domu='%s', kod_pocztowy='%s', kod_miejscowosc='%s', wojewodztwo='%s', kraj='%s', PESEL='%s', data_urodzenia='%s', telefon='%s', email='%s', login='%s' WHERE id_klienta='$id'", mysqli_real_escape_string($polaczenie, $imie), mysqli_real_escape_string($polaczenie, $nazwisko), mysqli_real_escape_string($polaczenie, $miasto), mysqli_real_escape_string($polaczenie, $ulica), mysqli_real_escape_string($polaczenie, $numer_domu), mysqli_real_escape_string($polaczenie, $kod_pocztowy), mysqli_real_escape_string($polaczenie, $kod_miejscowosc), mysqli_real_escape_string($polaczenie, $wojewodztwo), mysqli_real_escape_string($polaczenie, $kraj), mysqli_real_escape_string($polaczenie, $pesel), mysqli_real_escape_string($polaczenie, $data_urodzenia), mysqli_real_escape_string($polaczenie, $telefon), mysqli_real_escape_string($polaczenie, $email), mysqli_real_escape_string($polaczenie, $login))))
                             } */

                            /*echo '</div>'; // #content-books;
                        echo '</div>'; // #content;*/

                    }

                ?>

            </main>

        </div> <!-- #container -->

        <?php require "../view/___footer.php"; ?>

    </div> <!-- #main-container -->

<script>

    // save selected sorting option after page reload;

    var selectElement = document.getElementById("sortuj_wg");

    selectElement.addEventListener("change", function() {
        var selectedValue = selectElement.value;
        localStorage.setItem("selectedValue", selectedValue);
    });

    window.addEventListener("load", function() {
        var selectedValue = localStorage.getItem("selectedValue");

        if (selectedValue && selectElement) {
            selectElement.value = selectedValue;

            sortBooks();

        }
    });

</script>

</body>
</html>