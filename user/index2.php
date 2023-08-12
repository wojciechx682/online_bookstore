<?php
        // session_start();
        // include_once "../functions.php";

    require_once "../start-session.php";

    // ✓ sprawdź połączenie z BD;

    /*$value = array(); // [] ;
    array_push($value, "1");
    query("SELECT * FROM kkklienci", "", $value); exit();*/

    // ✓ w przypadku błędu połączenia z BD, wyświetli komunikat rzuconego wyjątku.
    // należy dodać to do każdej podstrony, która korzysta z połączenia z BD

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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // bez użycia wzorca PRG -->

        /*if( isset($_GET['kategoria']) && ! empty($_GET['kategoria']) )*/ // if variable EXISTS and has a NON-EMPTY value;

    /*if( isset($_POST['kategoria']) && ! empty($_POST['kategoria']) )
    {
        // przypadek wejśia w dowolną kategorię z górnego panelu;
            //echo '<script>console.log("\n38 - isset POST kategoria == true\n")</script>';
        $_SESSION["kategoria"] = htmlentities($_POST['kategoria'], ENT_QUOTES, "UTF-8"); // "Wszystkie", "Informatyka", "Horror"
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    }*/
        /*elseif( isset($_SESSION['kategoria']) && ! empty($_SESSION['kategoria']) && isset($_GET["input-search-nav"]) && ! empty($_GET["input-search-nav"]) )
        {
            // to się spełni, jeśli WCZEŚNIEJ następiło wejście pod dowolna kategorię --> index.php?kategoria=Wszystkie;
            // ORAZ           wprowadzono tytuł z input-search-nav;
                    // echo "<script>console.log('43');</script>";
            $_SESSION["kategoria"] = htmlentities($_SESSION['kategoria'], ENT_QUOTES, "UTF-8");
            $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
            // sanityzacja danych wprowadzonych od użytkownika; html-entities = encje html'a; $kategoria = <script>alert();</script>;
        }*/

        /*elseif( ! isset($_GET["kategoria"]) && ! isset($_GET["input-search-nav"]) )*/
    /*elseif( ! isset($_POST["kategoria"]) && ! isset($_POST["input-search-nav"]) )
    {
        //echo '<script>console.log("\n59 - kategoria nie była w parametrze POST\n")</script>'; // Strona główna, Input-search
        $_SESSION["kategoria"] = "Wszystkie";
    }*/

    // od teraz kategoria jest ZAWSZE ustawiona;

    /*if( isset($_POST["adv-search-category"]) )
    {
        // to się spełni, jeśli nastąpił submit z wyszukiwania-zaawansowanego; - zmienna $_SESSION["kategoria"] przejmie wartość z tego formularza;

        //echo "<script>console.log('65 - kategoria była ustawiona w wyszukiwaniu zaawansowanym (użyto wyszukiwania zaawansowanego)');</script>";
        $_SESSION["kategoria"] = htmlentities($_POST['adv-search-category'], ENT_QUOTES, "UTF-8");
        $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
    }*/

            /*if(isset($_GET["input-search"])) // nie ma sensu tego pisać, ponieważ kategoria i tak będzie ustawiona (warunek ! isset GET['kat'] )
            {
                echo "<script>console.log('\n77\n');</script>";
                $_SESSION["kategoria"] = "Wszystkie";
            }*/

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Implementacja wzorca PRG (Post-Redirect-Get);

    if( $_SERVER['REQUEST_METHOD'] === "POST" ) {        // Post - Redirect - Get ;

        if( isset($_POST["input-search-nav"]) ) {        // && ! empty($_POST["input-search-nav"])

                                                         // PRG - input-search-nav ;

                    // echo "<br> input-search-nav -> " . $_POST["input-search-nav"] . "<br>"; exit();  // <script>alert();</script>
                // input-search-nav - zmienna istnieje (może być pusta --> "");
            // wprowadzono tytuł z input-search-nav;

            $title = filter_input(INPUT_POST, "input-search-nav", FILTER_SANITIZE_STRING); // SANITYZACJA - input-search-nav;
            $_SESSION["input-search-nav"] = $title;

            if( $title === false || // dane nie przeszły walidacji przez filtr,
                $title === null ||  // zmienna nie istnieje ( == null, jeśli zmienna $_POST nie istnieje),
                ($_SESSION["input-search-nav"] !== $_POST["input-search-nav"]) ) {

                    // validation failed - redirect to main page (index.php);

                unset($_POST, $title, $_SESSION["input-search-nav"]);
                    header('Location: index.php', true,303);
                        exit();
            } else {
                // validation passed ; - input-search-nav - nie pusty, posiada wartość, która przeszła walidację
                    // przekierowanie ! (może być na dowolny adres, niekoniecznie ten sam);
                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                // $_SESSION["input-search-nav"];
                    exit();
            }

        } /*else {
            // pusty (nie istnieje) input-search nav;
            // -> do nothing !
        }*/
        elseif ( isset($_POST["kategoria"]) )   // && ! empty($_POST['kategoria'])
        {
            // PRG - top-nav -> kategoria; // przypadek wejśia w dowolną kategorię z górnego panelu;

                // echo "<br> kategoria -> " . $_POST["kategoria"] . "<br>"; exit();
                    //echo '<script>console.log("\n38 - isset GET kategoria == true\n")</script>';
                //$_SESSION["kategoria"] = htmlentities($_POST['kategoria'], ENT_QUOTES, "UTF-8"); // "Wszystkie", "Informatyka", "Horror"
                //$_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);

            $category = filter_input(INPUT_POST, "kategoria", FILTER_SANITIZE_STRING); // SANITYZACJA - kategoria;
            $_SESSION["kategoria"] = $category;

            // check if category exists in db ... ;
            $_SESSION["category-exists"] = false;
            query("SELECT nazwa FROM kategorie WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["kategoria"]); // ✓ przestawi $_SESSION["category-exists"] na true, jeśli taka kategoria (nazwa) istnieje;

            if( $category === false || $category === null || ($_SESSION["kategoria"] !== $_POST["kategoria"]) || $_SESSION["category-exists"] === false ) {
                // validation failed - redirect to main page (index.php);
                    // $_SESSION["kategoria"] = "Wszystkie";

                //unset($_POST, $category, $_SESSION["kategoria"]);
                unset($_POST, $category, $_SESSION["kategoria"], $_SESSION["category-exists"]); // , $_SESSION["kategoria"]
                    header('Location: index.php', true,303);
                        exit();
            } else {
                // validation passed (category) - kategoria - nie pusty, posiada wartość, która przeszła walidację;

                if ( isset($_POST["subcategory"]) ) { // && ! empty($_POST['subcategory'])

                    $subcategory = filter_input(INPUT_POST, "subcategory", FILTER_SANITIZE_STRING); // sanityzacja - podkategoria;
                    $_SESSION["subcategory"] = $subcategory;

                    // check if category exists in db ... ;
                    $_SESSION["subcategory-exists"] = false;
                    query("SELECT nazwa FROM subkategorie WHERE nazwa = '%s'", "verifySubcategoryExists", $_SESSION["subcategory"]); // ✓ przestawi $_SESSION["subcategory-exists"] na true, jeśli taka pod-kategoria (nazwa) istnieje;

                    if( $subcategory === false || $subcategory === null || ($_SESSION["subcategory"] !== $_POST["subcategory"]) || $_SESSION["subcategory-exists"] === false ) {
                        // validation failed - redirect to main page (index.php);

                        unset($_POST, $category, $subcategory, $_SESSION["kategoria"], $_SESSION["subcategory"], $_SESSION["category-exists"]);
                            header('Location: index.php', true, 303);
                                exit();
                    }
                } else {
                    unset($_SESSION["subcategory"]); // ✓ remove subcategory variable, if it not exists in $_POST[] (!)
                }

                // ✓ przekierowanie (redirect) - 303;
                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                exit();
            }
        }

        elseif ( isset($_POST["input-search"]) ) { // Post - Redirect - Get - input-search;

            $search_value = filter_input(INPUT_POST, 'input-search', FILTER_SANITIZE_STRING); // SANITYZACJA - input-search;
            $_SESSION["input-search"] = $search_value;

            $_SESSION["kategoria"] = "Wszystkie"; // ✓ - ponieważ szukamy książek w każdej kategorii;

            if( $search_value === false || $search_value === null || ($_SESSION["input-search"] !== $_POST["input-search"]) ) {

                // validation failed - redirect to main page (index.php);
                // unset($_POST, $category, $_SESSION["kategoria"]);
                unset($_POST, $search_value, $_SESSION["input-search"]); // , $_SESSION["kategoria"]
                    header('Location: index.php', true, 303);
                        exit();
            } else {
                // validation passed - input-search ;
                    unset($_SESSION["subcategory"]); // ✓ - ponieważ szukamy książek w każdej kategorii;
                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                exit();
            }
        }

        // PRG - wyszuiwanie zaawansowane ;

        elseif( isset($_POST["adv-search-title"]) &&
                isset($_POST["adv-search-category"]) &&
                isset($_POST["adv-search-author"]) &&
                isset($_POST["year-min"]) &&
                isset($_POST["year-max"])
        ) {
            // PRG - advanced search;
            //
                        // $_SESSION["kategoria"] = htmlentities($_POST['adv-search-category'], ENT_QUOTES, "UTF-8");
                        // $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);

            $valid = true; // flaga walidacyjna - "true" - zakładamy że wszystkie dane są OK (wstępnie);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING); // SANITYZACJA - adv-search-category;
            $_SESSION["adv-search-category"] = $category;
            $_SESSION["kategoria"] = $category; // chcemy zostawić kategorię po odświeżeniu strony;

            if($_SESSION["adv-search-category"] != "Wszystkie") {
                // check if that category exists in db ;
                $_SESSION["category-exists"] = false;
                query("SELECT nazwa FROM kategorie WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["adv-search-category"]);
                // ✓ przestawi $_SESSION["category-exists"] na true, jeśli taka kategoria (nazwa) istnieje;

                if( $category === false || $category === null || ($_SESSION["adv-search-category"] !== $_POST["adv-search-category"]) || $_SESSION["category-exists"] === false ) {
                    // category empty ("") or failed validation ;
                    $valid = false;
                }
            } else { // kategoria == "Wszystkie";
                if( $category === false || $category === null || ($_SESSION["adv-search-category"] !== $_POST["adv-search-category"])) {
                    // category empty ("") or failed validation ;
                    $valid = false;
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // ✓ Przenieść tutaj walidiację formularza zaawansowanego z linii 415 (!);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // validate and sanitize input data (advanced search);

            //                        $_POST =>
            //                        (
            //                            [       adv-search-title       ] => "bbb"
            //                            [       adv-search-category    ] => Komiks
            //                            [       adv-search-author      ] => 13   // id_autora
            //                            [       year-min               ] => 2005
            //                            [       year-max               ] => 2018
            //                        )

            // set up the initial query string --> ;

            // przed uwzględnieniem statusu - "dostępna / niedostępna" -->

            /* $_SESSION["adv-search-query"] = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                               ks.rating,
                               kt.nazwa, sb.id_kategorii,
                               au.imie, au.nazwisko
                               FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb";*/

            // dodanie statusu - "dostępna / niedostępna" -->

            $_SESSION["adv-search-query"] = "SELECT
                                ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                kt.nazwa, sb.id_kategorii,
                                au.imie, au.nazwisko,
                                SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                            FROM
                                ksiazki AS ks
                            JOIN
                                autor AS au ON ks.id_autora = au.id_autora
                            JOIN
                                subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                            JOIN
                                kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                            LEFT JOIN
                                magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki
                            ";

            if ( ! empty($_POST["adv-search-title"]) ) { // sanitize adv-seatch-title;

                $title = filter_input(INPUT_POST, "adv-search-title", FILTER_SANITIZE_STRING);
                $_SESSION["adv-search-title"] = $title;

                if( $title === false || ($_SESSION["adv-search-title"] !== $_POST["adv-search-title"]) || strlen($title)>255 ) {
                    $valid = false;
                }
            }
            /* // jest ustawiona wcześniej;
            if ( isset($_POST["adv-search-category"]) && ! empty($_POST["adv-search-category"]) ) {
                // sanitize category;
                $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING);
            }*/
            if ( ! empty($_POST["adv-search-author"]) ) { // sanitize adv-search-author;

                // get highest author-id from database ;
                query("SELECT id_autora FROM autor ORDER BY id_autora DESC LIMIT 1", "get_author_id", "");
                // $_SESSION["max-author-id"] => id_autora - "36";

                $author = filter_input(INPUT_POST, "adv-search-author", FILTER_SANITIZE_NUMBER_INT);
                    /* if (!$author || !is_numeric($_POST["adv-search-author"])) {
                        // Handle invalid input (e.g. display an error message)
                        $_SESSION["advanced-search-error"] = "Podaj poprawne dane";
                    } */

                // validate author-id - ✓ valid integer in specific range ;
                $_SESSION["adv-search-author"] = filter_var($author, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1,                         // Minimum allowed book-id value
                            'max_range' => $_SESSION["max-author-id"] // Maximum allowed author-id value (highest author-id in database) ; functions() -> "get_author_id()"
                        ]
                    ]
                ); // ✓ It ensures that the value is an integer within the specified range;

                // check if that author (id) exists in db ... ;
                $_SESSION["author-exists"] = false;
                query("SELECT id_autora FROM autor WHERE id_autora = '%s'", "verifyAuthorExists", $_SESSION["adv-search-author"]);
                // ✓ przestawi $_SESSION["author-exists"] na true, jeśli taki autor (id) istnieje

                if( $author === false || $_SESSION["adv-search-author"] === false || ($_SESSION["adv-search-author"] != $_POST["adv-search-author"]) || $_SESSION["author-exists"] === false ) {

                    /*echo "<br> 316 <br>";
                    if($author === false) {
                        echo "<br> autor == false ! <br>";
                    }
                    if($_SESSION["adv-search-author"] === false) {
                        echo "<br> $_SESSION - adv search author == false ! <br>";
                    }
                    if($_SESSION["adv-search-author"] !== $_POST["adv-search-author"]) {
                        echo "<br> SESSION adv-search-author !== POST adv-search-author <br>";
                        echo "<br>".$_SESSION["adv-search-author"] ."<br>";
                        echo "<br>".$_POST["adv-search-author"] ."<br>";
                    }
                    if($_SESSION["author-exists"] === false) {
                        echo "<br> author-exists === false <br>";
                    }
                    exit();*/

                    $valid = false;
                }
            }

            if ( ! empty($_POST['year-min']) ) { // check if the user provided a minimum year
                    // Add a condition for the minimum year
                    //$where[] = "ks.rok_wydania >= " . $_POST['year-min'];
                //$where[] = "ks.rok_wydania >= '%s'";
                //$values[] = $_POST['year-min'];
                $year_min = filter_input(INPUT_POST, "year-min", FILTER_VALIDATE_INT);

                $_SESSION["year-min"] = filter_var($year_min, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1900, // Minimum allowed year value
                            'max_range' => 2023  // Maximum allowed year value
                        ]
                    ]
                );

                // $_SESSION["year-min"] = $year_min;

                if( $year_min === false || $_SESSION["year-min"] === false ) {
                    $valid = false;
                }
            }

            // check if the user provided a maximum year
            if ( ! empty($_POST['year-max']) ) {
                // Add a condition for the maximum year
                //$where[] = "ks.rok_wydania <= " . $_POST['year-max'];
                //$where[] = "ks.rok_wydania <= '%s'";
                //$values[] = $_POST['year-max'];

                $year_max = filter_input(INPUT_POST, "year-max", FILTER_VALIDATE_INT);

                $_SESSION["year-max"] = filter_var($year_max, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1900, // Minimum allowed year value
                            'max_range' => 2023  // Maximum allowed year value
                        ]
                    ]
                );

                // $_SESSION["year-max"] = $year_max;

                if( $year_max === false || $_SESSION["year-max"] === false ) {
                    $valid = false;
                }
            }

            // $_SESSION["adv-search-category"]
            // $_SESSION["adv-search-title"]
            // $_SESSION["adv-search-author"]
            // ...

            ////////////////////////////////////////////////////////////////////////////

            if(
                    $valid === false
            ) {

                // validation failed - redirect to main page (index.php);   // echo "<br>error<br>";

                // ✖ $_SESSION["kategoria"] = "Wszystkie"; // ? - testowałem i - i tak jest ustawiana ;

                unset($_POST, $category, $_SESSION["adv-search-category"], $_SESSION["kategoria"], $_SESSION["category-exists"], $title, $_SESSION["adv-search-title"], $author, $_SESSION["adv-search-author"], $_SESSION["max-author-id"], $_SESSION["author-exists"], $_SESSION["adv-search-query"], $year_min, $year_max, $_SESSION["year-min"], $_SESSION["year-max"]);

                    header('Location: index.php', true, 303);
                        exit();
            } else {
                // validation passed - all POST values are valid (correct) ! ;

                //echo "<br> all POST values are valid (correct) ! <br>"; exit();
                // ✓ zmienne sesyjne z formularza ustawione
                // Initialize an array to store the conditions for the WHERE clause;
                // echo "<br> 351 <br>"; exit();

                /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr>"; exit();*/

                $where = [];  //   WHERE CONDITION
                $values = []; //   VALUES USED AS ARGUMENTS

                // check if the user provided a book title;
                if ( ! empty($_SESSION['adv-search-title']) ) {
                    // Add a condition for the book title (!)
                        // $where[] = "ks.tytul LIKE '%" . $_POST['adv-search-title'] . "%'";
                    $where[] = "ks.tytul LIKE '%%%s%%'"; //%%%s%%
                    $values[] = $_SESSION['adv-search-title']; // values += ["title"];
                }

                // check if the user selected a category
                if ( $_SESSION["adv-search-category"] != 'Wszystkie' ) {
                    // Add a condition for the category
                    //$where[] = "ks.kategoria = '" . $_POST['adv-search-category'] . "'"; // do usunięcia - ponieważ zmiena POST może mieć wartość "Wszystkie" - a takiej nazwy nie ma w tabeli "kategorie" !
                    $where[] = "kt.nazwa = '%s'";
                    $values[] = $_SESSION["adv-search-category"]; // values += ["kategoria"];

                    //$_SESSION["kategoria"] = $_POST["adv-search-category"]; // ✓
                }

                // Check if the user selected an author
                if ( ! empty($_SESSION['adv-search-author'])) {
                    // Add a condition for the author
                    //$where[] = "ks.id_autora = " . $_POST['adv-search-author'];
                    $where[] = "ks.id_autora = '%s'";
                    $values[] = $_SESSION['adv-search-author'];
                }

        // check if the user provided a minimum year
        if ( ! empty($_SESSION['year-min']) ) {
            // Add a condition for the minimum year
            //$where[] = "ks.rok_wydania >= " . $_POST['year-min'];
            $where[] = "ks.rok_wydania >= '%s'";
            $values[] = $_SESSION['year-min'];
        }

        // check if the user provided a maximum year
        if ( ! empty($_SESSION['year-max']) ) {
            // Add a condition for the maximum year
            //$where[] = "ks.rok_wydania <= " . $_POST['year-max'];
            $where[] = "ks.rok_wydania <= '%s'";
            $values[] = $_SESSION['year-max'];
        }

                echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                echo "GET ->"; print_r($_GET); echo "<hr><br>";
                echo "SESSION ->"; print_r($_SESSION); echo "<hr>";
                echo "WHERE ->"; print_r($where); echo "<hr>";
                echo "VALUES ->"; print_r($values); echo "<hr>"; //exit();

                // check if any conditions were added to the WHERE clause
                if ( ! empty($where) ) {
                    // Combine the conditions into a single WHERE clause
                        //$query .= " WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii AND " . implode(" AND ", $where);
                        // nie trzeba względniać relacji po WHERE, ponieważ użyto wsześniej klauzuli JOIN;

                    // $_SESSION["adv-search-query"] .= " WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii AND " . implode(" AND ", $where) . " GROUP BY ks.id_ksiazki ";

                    // WHERE -> Array ( [0] => ks.tytul LIKE '%%%s%%' [1] => kt.nazwa = '%s' [2] => ks.id_autora = '%s' [3] => ks.rok_wydania >= '%s' [4] => ks.rok_wydania <= '%s' )

                    $_SESSION["adv-search-query"] .= " WHERE " . implode(" AND ", $where) . " GROUP BY ks.id_ksiazki "; // implode() - połącz elementy tablicy jako string z separatorem "AND";

                    // $_SESSION["adv-search-query"] => SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, kt.nazwa, sb.id_kategorii, au.imie, au.nazwisko, SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy FROM ksiazki AS ks JOIN autor AS au ON ks.id_autora = au.id_autora JOIN subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii JOIN kategorie AS kt ON sb.id_kategorii = kt.id_kategorii LEFT JOIN magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki WHERE ks.tytul LIKE '%%%s%%' AND kt.nazwa = '%s' AND ks.id_autora = '%s' AND ks.rok_wydania >= '%s' AND ks.rok_wydania <= '%s' GROUP BY ks.id_ksiazki

                    //echo "<br><hr> adv-search-query --> <br><br>" . $_SESSION["adv-search-query"] . "<br>"; exit();

                    $_SESSION["adv-search-values"] = $values; // VALUES -> Array ( [0] => php [1] => Informatyka [2] => 2 [3] => 1992 [4] => 2018 )

                    // $_SESSION["adv-search-query"] = $query;
                }

                    // execute the query
                    // query($query, "get_books", $values);

                header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                exit();

            } // $valid == true;
        }
    }

    if ( ! isset($_SESSION["kategoria"]) || empty($_SESSION["kategoria"]) )
    {
        //echo '<script>console.log("\n59 - kategoria nie była w parametrze GET\n")</script>'; // Strona główna, , Input-search

        $_SESSION["kategoria"] = "Wszystkie";
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head2.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/___header-container.php"; ?>

        <div id="container">

            <main>

                <aside id="book-filters">

                    <div id="nav" class="nav-visible">

                        <?= "<h3>".$_SESSION["kategoria"]; ?>

                        <?= isset($_SESSION["subcategory"]) ? " \ " . $_SESSION["subcategory"] . "</h3>" : ""; ?>


                        <h3>
                            <label for="sortuj_wg">Sortowanie</label>
                        </h3>

                        <select id="sortuj_wg">
                            <option value="1">ceny rosnąco</option>
                            <option value="2">ceny malejąco</option>
                            <option value="3">nazwy A-Z</option>
                            <option value="4">nazwy Z-A</option>
                            <option value="5">Najnowszych</option>
                            <option value="6">Najstarszych</option>
                        </select>

                        <!-- <button id="sort_button" onclick="sortBooks()">Sortuj</button> -->

                        <h3>
                            <label for="value-min">Cena</label>
                        </h3>

                        <div id="price-range">
                            <label>
                                <span>
                                    Min
                                </span>
                                    <input type="number" id="value-min" step="1" min="5">
                            </label>
                            <label>
                                <span>
                                    Max
                                </span>
                                    <input type="number" id="value-max" step="1" max="150">
                            </label>
                            <div id="slider"></div> <!-- jQuery NoUISlider --> <!-- noUiSlider -->
                        </div>

                        <div id="input-search-nav-div">

                            <label for="input-search-nav">
                                <h3>Tytyuł</h3>
                            </label>

                            <form method="post"> <!-- action="index.php" -->
                                    <!-- (szukaj tytułu w tej kategorii) -->
                                    <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                                <input type="submit" value="">
                            </form>

                        </div>

                        <h3>
                            <label for="all-authors">Autorzy</label>
                        </h3>

                        <ul id="ul-authors">
                            <?php
                                query("SELECT DISTINCT imie, nazwisko, id_autora FROM autor ORDER BY imie ASC", "get_authors", "");
                                // filtrowanie autorów - <ul> authors list;
                            ?>
                        </ul>

                        <button id="filter-authors">Zastosuj</button>

                        <h3>Status</h3>

                        <ul id="ul-book-status-list">
                            <li>
                                <label>
                                    <input type="checkbox" name="available" class="book-status-checkbox" value="dostępna">dostępna
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="not-available" class="book-status-checkbox" value="niedostępna">niedostępna
                                </label>
                            </li>
                        </ul>

                        <button id="filter-book-status">Zastosuj</button>

                    </div> <!-- #nav -->

                </aside> <!-- #book-filters -->

                <?php

                    /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                    echo "GET ->"; print_r($_GET); echo "<hr><br>";
                    echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/

                    // nie ma sensu sprawdzać czy kategoria jest ustawiona, ponieważ zawsze jest (w zmiennej $_SESSION['kategoria']);
                        // (z wyjątkiem gdy wprowadzono tytuł w input-search-nav);
                ?>

                <?php

                    //   $_GET['kategoria'] --> $_SESSION["kategoria"] --> "Horror"    (zapis do ZS)
                    // ! $_GET['kategoria'] --> $_SESSION["kategoria"] --> "Wszystkie" (domyślnie)
                    // ✓ Kategoria jest ustawiona zawsze;

                        // isset($_GET["input-search"])

                        //  ̶ ̶k̶a̶t̶e̶g̶o̶r̶i̶a̶ ̶n̶i̶e̶ ̶b̶y̶ł̶a̶ ̶w̶ ̶p̶a̶r̶a̶m̶e̶t̶r̶z̶e̶ ̶G̶E̶T̶,̶ ̶w̶i̶ę̶c̶ ̶p̶r̶z̶y̶j̶m̶i̶e̶ ̶w̶a̶r̶t̶o̶ś̶ć̶ ̶"̶W̶s̶z̶y̶s̶t̶k̶i̶e̶"̶ ̶-̶ ̶l̶i̶n̶i̶a̶ ̶5̶2̶;̶

                        // $_SESSION["input-search"]
                    if ( isset($_SESSION["input-search"]) ) {

                        // PRG -> jeśli jest ustawiona Z.S. input-search, to tutaj kategoria zawsze będzie wynosić "Wszyskie"
                        // ponieważ input-search szuka książek we wszystkich kategoriach ;

                        //if( ! empty($_GET["input-search"]) ) {

                            //echo "180 input-seach -> " . $_SESSION["input-search"] . "<br>";
                            // echo '<script> displayNav(); </script>'; // do usunięcia - to funkcja tutaj NIC NIE ROBI ale zostawiam jakby coś;
                            // input-search sanitization;
                            //$search_value = filter_input(INPUT_GET, 'input-search', FILTER_SANITIZE_STRING);

                            $search_value = $_SESSION["input-search"];
                            unset($_SESSION["input-search"]);


                    //echo " 180 input-seach (sanitized) -> " . $search_value . "<br>";

                            // ew warunek jeśli jest różne od oryginalnej wartości wejściowej -> wyświetlić komunikat "podaj poprawne dane";

                            /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                                     kt.nazwa, sb.id_kategorii,
                                                        au.imie, au.nazwisko
                                                     FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb
                                                     WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                                     AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value);*/ // kategorie => nazwa, id_kategorii;

                            // dodanie statusu - "dostępna / niedostępna" -->

                            query("SELECT
                                            ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                            kt.nazwa, sb.id_kategorii, 
                                            au.imie, au.nazwisko,
                                            SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                                        FROM 
                                            ksiazki AS ks
                                        JOIN 
                                            autor AS au ON ks.id_autora = au.id_autora
                                        JOIN 
                                            subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                        JOIN 
                                            kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                                        LEFT JOIN 
                                            magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki
                                        WHERE ks.tytul LIKE '%%%s%%' 
                                        GROUP BY ks.id_ksiazki", "get_books", $search_value); // input-search => tytuł książki;


                        /*} else { // puste pole wyszukiwania;

                            echo '<h3>Brak wyników</h3>'; // (!) ewentualnie można to zrobić wewnątrz funkcji query (?);
                        }*/
                    }

                    /*elseif ( isset($_GET["input-search-nav"]) && !empty($_GET["input-search-nav"]) ) {*/

                    /*elseif ( isset($_POST["input-search-nav"]) && !empty($_POST["input-search-nav"]) ) {*/

                    elseif ( isset($_SESSION["input-search-nav"]) ) { //  && ! empty($_SESSION["input-search-nav"])
                                                                      // wystarczy sprawdzić czy istnieje, be sprawdaenie czy jest puste odbywa się wcześniej ;

                        // ✓ tutaj zmienna sesyjna "kategoria" przyjmuje wartość "Wszystkie" lub dowolną inną kategorią z istniejących - ponieważ wsześniej zostaje ustawiona;

                                    // echo "198 input-seach-nav -> " . $_GET["input-search-nav"] . "<br>";
                                        // input-search-nav sanitization;
                                   /* $title = filter_input(INPUT_GET, "input-search-nav", FILTER_SANITIZE_STRING);*/

                        /*$title = filter_input(INPUT_POST, "input-search-nav", FILTER_SANITIZE_STRING);*/

                        $title = $_SESSION["input-search-nav"];
                        unset($_SESSION["input-search-nav"]);

                //echo "198 input-seach-nav -> " . $title . "<br>";

                        $values = [$title];

                        //echo '<script> displayNav(); </script>'; // do usunięcia - to funkcja tutaj NIC NIE ROBI ale zostawiam jakby coś;

                        // budowanie kwerendy w zależności od tego czy kategoria == "Wszystkie" czy jest to konkretna kategoria;

                        /*$query = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                                                 ks.rating,
                                                 kt.nazwa, sb.id_kategorii,
                                                  au.imie, au.nazwisko
                                                 FROM ksiazki AS ks,
                                                      autor AS au,
                                                      kategorie AS kt,
                                                      subkategorie AS sb
                                                 WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                                 AND ks.tytul LIKE '%%%s%%'";*/

                        echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr>";

                        // dodanie statusu - "dostępna / niedostępna" -->

                        $query = "SELECT
                                    ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                    kt.nazwa, sb.id_kategorii, sb.nazwa,
                                    au.imie, au.nazwisko,
                                    SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                                FROM 
                                    ksiazki AS ks
                                JOIN 
                                    autor AS au ON ks.id_autora = au.id_autora
                                JOIN 
                                    subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                JOIN 
                                    kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                                LEFT JOIN 
                                    magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki
                                WHERE ks.tytul LIKE '%%%s%%'";

                        if($_SESSION["kategoria"] != "Wszystkie") { // kategoria zawsze jest ustawiona wsześniej, przyjmuje wartość "Wszystkie" lub dowolną inną z istniejących;

                            // jeśli kategoria to np. "Informatyka", "Horror", "Fantastyka";

                            $where = array(); // [] ?
                                //$where[] = " AND ks.kategoria LIKE '%%%s%%'"; //%%%s%%
                            $where[] = " AND kt.nazwa LIKE '%%%s%%'"; //%%%s%% // "Informatyka", "Horror", "Fantastyka";
                            $values[] = $_SESSION['kategoria']; // dodanie do tablicy argumentów zmiennej kategoria - do użycia w funkcji query(); // od teraz values = ["input-search-nav" (tytul), "kategoria"];

                            if(isset($_SESSION["subcategory"])) { // jeśli jest ustawiona pod-kateoria;
                                $where[] = " AND sb.nazwa LIKE '%%%s%%'"; // szukaj w także w tej podkategorii;
                                $values[] = $_SESSION['subcategory'];
                            }
                        }

                        if (!empty($where)) { // dodanie do zapytania warunku  w którym kategoria to ->  "Informatyka", "Horror", "Fantastyka";

                            // combine the conditions into a single WHERE clause
                            $query .= implode("", $where);

                            /*echo "<br>283<br>";*/
                        }

                        $query .= " GROUP BY ks.id_ksiazki";

                        echo "<br><hr><br> query --> <br><br>";
                            echo $query . "<br><br><hr><br>";

                        query($query, "get_books", $values);

                    }

                    // wyszukiwanie zaawansowane - advanced search result (POST);

                    else if ( isset($_SESSION["adv-search-query"])

                    ) {

                        echo "<br><hr><br>";
                            echo "<br> adv-search-query --> <br><br>";
                            echo $_SESSION["adv-search-query"];
                        echo "<br><hr><br>";

                        /*// set up the initial query string
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


                        if ( isset($_POST["adv-search-title"]) && ! empty($_POST["adv-search-title"]) ) {
                            // sanitize adv-seatch-title;
                            $title = filter_input(INPUT_POST, "adv-search-title", FILTER_SANITIZE_STRING);
                        }
                        if ( isset($_POST["adv-search-category"]) && ! empty($_POST["adv-search-category"]) ) {
                            // sanitize category;
                            $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING);
                        }
                        if ( isset($_POST["adv-search-author"]) && ! empty($_POST["adv-search-author"]) ) {
                            // sanitize adv-search-author
                            $author = filter_input(INPUT_POST, "adv-search-author", FILTER_VALIDATE_INT);
                                // if (!$author || !is_numeric($_POST["adv-search-author"])) {
                                    // Handle invalid input (e.g. display an error message)
                                //    $_SESSION["advanced-search-error"] = "Podaj poprawne dane";
                                //}
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
                        }*/

                        echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr>";

                        // execute the query - advanced-search;
                        query($_SESSION["adv-search-query"], "get_books", $_SESSION["adv-search-values"]);

                        unset($_SESSION["adv-search-query"], $_SESSION["adv-search-values"]);

                        unset($_SESSION["adv-search-title"], $_SESSION["adv-search-category"], $_SESSION["adv-search-author"], $_SESSION["year-min"], $_SESSION["year-max"]);

                    }


                    /*elseif ( !isset($_GET["input-search"]) ) {

                        echo "<br> input-seach is not set <br>";

                    }*/
                    else {
                        // domyślnie - strona główna - LUB - GET kategoria ?????? NA PEWNO ? DODAŁEM WIĘCEJ WARUNKÓW WYŻEJ

                // echo "<br>strona główna - LUB - GET kategoria<br>";

                        // echo '<script> console.log("170 --> \n\n"); displayNav(); </script>'; // odpala funkcję ale nie widać zmian z nav'em;

                        /*sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; <script>alert("hahaha");</script>;
                        $kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8"); // do usunięcia;
                        $kategoria = strip_tags($kategoria); // do usunięcia
                        $_SESSION['kategoria'] = $kategoria; // do usunięcia
                        ~ (?) wstawienie kategorii do zmiennej sesyjnej -> (koszyk_dodaj.php - walidacja danych - czy jest to liczba ?); // (?);*/
                        /*echo '<div id="content">';
                            echo '<div id="content-books">';*/

                            if(isset($_SESSION["subcategory"])) {
                                displayBooksWithSubcategory($_SESSION['kategoria'], $_SESSION["subcategory"]);
                            } else {
                                displayBooks($_SESSION['kategoria']);
                            }

                            //displayBooks($_SESSION['kategoria']);
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
            filterAuthors();
        }

        // ---------------------------------------------





    });


    //




</script>

    <script src="../scripts/filter-book-status.js"></script>

<script>

    function showCategories() {

        //console.log("\nshowCategories :)\n");

        let list = document.getElementById("categories-list"); // ul
            console.log("\nlist -> ", list);

       if(list.style.display === "block") {
            list.removeAttribute("style");
        } else {
            list.style.display = "block";
        }

        //console.log("\nlist.style.display -> ", list.style.display);
        //list.classList.toggle('hidden');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // kliknięcie na "Kategorie" wyświetla listę kategorii - click on "Kategorie" in top nav -> hiding/displaying <ul> list;

    let categoryButton = document.getElementById("a-categories-top-nav");
        console.log("\ncategoryButton -> ", categoryButton); // "Kategorie";

    function isMobileDevice() {
        return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    if (isMobileDevice()) {
        console.log("This website is being accessed from a mobile device.");
        categoryButton.addEventListener("click", showCategories);
    }

</script>

<script>
    /*let bookData = '<?php //query("SELECT sb.id_subkategorii, sb.nazwa, kt.nazwa FROM subkategorie AS sb, kategorie AS kt WHERE sb.id_kategorii = kt.id_kategorii", "getSubcategories", ""); ?>';*/
</script>


<script>

    // set height of the <ul> (categories) list based on how many categories are there

    /*let liItems = document.querySelectorAll('#categories-list li');
    console.log("\n\n\n liczb kategori --> ", liItems.length);

    let categoryList = document.getElementById("categories-list")
    let height = liItems[0];
    let a = height
    //categoryList.style.setProperty("--ul-list-height", "yellow");
    console.log("\n\n height --> ", height)*/

    let liItems = document.querySelectorAll('#categories-list li');
    console.log("\n\n Number of list items: ", liItems.length);

    let firstListItem = liItems[0];
    let height = firstListItem.offsetHeight; // 36
    console.log("\n\n Height of the first list item: ", height, "px");

    let ulListHeight = height * liItems.length;

    let categoryList = document.getElementById("categories-list");
    categoryList.style.setProperty("--ul-list-height", ulListHeight + "px");


    let secondList = document.getElementById("second-list");
    secondList.style.top = "-"+ulListHeight+"px";
    secondList.style.minHeight = ulListHeight+"px";


    let books = document.querySelectorAll("#content-books .book:not(.hidden-author)"); // kolekcja elementów DOM (NodeList) - divy z książkami;
    console.log("\n 1046 books -> ", books);
    console.log("\n 1046 typeof books -> ", typeof books);
    console.log("\n 1046 books instanceof NodeList -> ", books instanceof NodeList); // true

</script>

</body>
</html>