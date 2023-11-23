<?php

    require_once "../start-session.php";

    // ✓ sprawdź połączenie z BD;

    /*$value = []; // [] ;
    array_push($value, "1");
    query("SELECT * FROM kkklienci", "", $value); exit();*/

    // ✓ w przypadku błędu połączenia z BD, wyświetli komunikat rzuconego wyjątku.
    // należy dodać to do każdej podstrony, która korzysta z połączenia z BD (w ramach testów...)
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    // Implementacja wzorca PRG (Post-Redirect-Get);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {        // Post - Redirect - Get ;

        if (isset($_POST["input-search-nav"])) {       // wprowadzono tytuł z input-search-nav (wyszukiwanie książek w tej kategorii);

            $title = filter_input(INPUT_POST, "input-search-nav", FILTER_SANITIZE_STRING); // SANITYZACJA - input-search-nav; --> $title | FALSE

            $_SESSION["input-search-nav"] = $title; // --> $title | FALSE

            if (empty($title) || ($_SESSION["input-search-nav"] !== $_POST["input-search-nav"])) {
                    // dane nie przeszły walidacji przez filtr, lub - wprowadzono pustą wartość --> ""
                    // wartość po sanityzacji jest rózna od wartości podanej przez użytkownika
                    // validation failed - redirect to main-page (index.php);
                    $_SESSION["application-error"] = true;
                    unset($_POST, $title, $_SESSION["input-search-nav"]);
                    /*header('Location: index.php', true,303);
                    exit();*/
            } else {
                // validation passed ; - input-search-nav - nie pusty, posiada wartość, która przeszła walidację;
            }

        } elseif (isset($_POST["category"])) {
            // post-redirect-get - top-nav -> kategoria; // przypadek wejśia w dowolną kategorię z górnego panelu;
                // $_SESSION["kategoria"] = htmlentities($_POST['kategoria'], ENT_QUOTES, "UTF-8"); // "Wszystkie", "Informatyka", "Horror"
                // $_SESSION["kategoria"] = strip_tags($_SESSION["kategoria"]);
            if ($_POST["category"] != "Wszystkie") {

                $category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING); // SANITYZACJA - kategoria; --> $category | FALSE
                $_SESSION["category"] = $category; // --> $category | FALSE

                // check if THAT category exists in db (!) ;
                $categoryExists = query("SELECT nazwa FROM categories WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["category"]); // --> true - if caterogy exists;
                // $_SESSION["category-exists"] --> true,                   jeśli taka kategoria (nazwa) istnieje;
                // -------------||------------- --> zmienna NIE ISTNIEJE !, jeśli taka kategoria (nazwa) NIE istnieje;

                if (empty($category) || ($_SESSION["category"] !== $_POST["category"]) || empty($categoryExists)) {
                        // pusta wartość "" (empty) - lub nie przeszła walidacji (false)
                        // nazwa kategorii po walidacji inna, niż podana w żądaniu POST
                        // kategoria nie istnieje
                    $_SESSION["application-error"] = true;
                    // validation failed - redirect to main-page (index.php);
                    unset($_POST, $category, $_SESSION["category"], $_SESSION["subcategory"], $categoryExists, $subcategoryExists);
                    /*header('Location: index.php', true,303);
                    exit();*/

                } else {
                    // validation passed (category) - kategoria - nie pusty, posiada wartość, która przeszła walidację;
                    //                                          - istnieje kategoria o takiej nazwie
                    if (isset($_POST["subcategory"])) {

                        $subcategory = filter_input(INPUT_POST, "subcategory", FILTER_SANITIZE_STRING); // SANITYZACJA - podkategoria; --> $subcategory | FALSE
                        $_SESSION["subcategory"] = $subcategory;
                        // check if THAT sub-category exists in db (!);
                        $subcategoryExists = query("SELECT nazwa FROM subcategories WHERE nazwa = '%s'", "verifySubcategoryExists", $_SESSION["subcategory"]);
                        // ✓ przestawi $_SESSION["subcategory-exists"] --> na true, jeśli taka pod-kategoria (nazwa) istnieje;
                        // w przeciwnym wypadku --> $_SESSION["subcategory-exists"] --> zmienna NIE ISTNIEJE; - jeśli taka pod-kategoria (nazwa) nie istnieje !

                        if (empty($subcategory) || ($_SESSION["subcategory"] !== $_POST["subcategory"]) || empty($subcategoryExists)) {
                            // pusta wartość podkategorii --> "", lub nie przeszła walidacji (false)
                            // nazwa podkategorii inna po walidacji niż ta podana w POST
                            // podkategoria nie istnieje
                            $_SESSION["application-error"] = true;

                            // validation failed - redirect to main page (index.php);
                            unset($_POST, $category, $subcategory, $_SESSION["category"], $_SESSION["subcategory"], $categoryExists, $subcategoryExists);
                            /*header('Location: index.php', true, 303);
                            exit();*/
                        }

                    } else {
                        unset($_SESSION["subcategory"]); // ✓ remove subcategory variable (SESSION), if it not exists in $_POST[] (!)
                    }
                    // kategoria + subkategoria (jeśli była ustawiona w POST) - przeszły walidację - ✓ przekierowanie (redirect) - 303;
                    /*header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                        exit();*/
                }

            } else {
                $_SESSION["category"] = "Wszystkie";
                unset($_SESSION["subcategory"], $categoryExists, $subcategoryExists);
                /*header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                exit();*/
            }
        }

        elseif (isset($_POST["input-search"])) { // Post - Redirect - Get - input-search (top-nav);

            $search_value = filter_input(INPUT_POST, "input-search", FILTER_SANITIZE_STRING); // SANITYZACJA - input-search; --> $search_value | FALSE;
            $_SESSION["input-search"] = $search_value;

            $_SESSION["category"] = "Wszystkie"; // ✓ - ponieważ szukamy książek w każdej kategorii ! ;

            if (empty($search_value) || ($_SESSION["input-search"] !== $_POST["input-search"])) {
                // pusta wartość --> "" - lub nie przeszła walidacji (false)
                // inna wartość po walidacji
                // validation failed - redirect to main-page (index.php);
                $_SESSION["application-error"] = true;
                unset($_POST, $search_value, $_SESSION["input-search"], $_SESSION["category"], $_SESSION["subcategory"]);
                /*header('Location: index.php', true, 303);
                exit();*/
            } else { // validation passed - input-search ;
                unset($_SESSION["subcategory"]); // ✓ - ponieważ szukamy książek w każdej kategorii;
                /*header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // to prevent resubmitting the form
                exit();*/
            }
        }

        // Post - Redirect - Get - wyszuiwanie zaawansowane (advanced-search) ;

        elseif( isset($_POST["adv-search-title"]) &&
                isset($_POST["adv-search-category"]) &&
                isset($_POST["adv-search-author"]) &&
                isset($_POST["year-min"]) &&
                isset($_POST["year-max"])
        ) {

            // print_r($_POST) =>
            //
            // Array ( [adv-search-title] => php
            //         [adv-search-category] => Informatyka
            //         [adv-search-author] => 2
            //         [year-min] => 1990
            //         [year-max] => 2020 )

            $valid = true; // flaga walidacyjna - "true" - zakładamy że wszystkie dane są OK (wstępnie);

            $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING); // SANITYZACJA - adv-search-category; --> $category | FALSE;
            // FILTER_SANITIZE_STRING - strip tags and HTML-encode double and single quotes, optionally strip or encode special characters;
            $_SESSION["adv-search-category"] = $category;
            $_SESSION["category"] = $category; // (chcemy zostawić kategorię po odświeżeniu strony, nawet jeśli dane nie przejdą walidacji);

            unset($_SESSION["subcategory"]);

            if (empty($category) || ($_SESSION["adv-search-category"] !== $_POST["adv-search-category"]) || strlen($category)>100) {
                // pusta wartość --> "" (empty), lub nie przeszła walidacji (false)
                // category empty ("") or failed validation ;
                    $valid = false;
            } else { // adv-search-category - passed validation;

                if ($_SESSION["adv-search-category"] != "Wszystkie") { // "Informatyka",  "Dla dzieci",  "Fantastyka", ...

                    $categoryExists = query("SELECT nazwa FROM categories WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["adv-search-category"]);
                    // $_SESSION["category-exists"] ==> true/NULL; (zależnie od tego czy istnieje taka kategoria);

                    if (empty($categoryExists)) {
                        unset($categoryExists);
                        $valid = false;
                    }

                } /*else { // "Wszystkie"

                }*/
            }

                    /*if($_SESSION["adv-search-category"] != "Wszystkie") {
                            // "Informatyka",  "Dla dzieci",  "Fantastyka", ...
                        // check if that category exists in db ;
                        $_SESSION["category-exists"] = false;
                        query("SELECT nazwa FROM kategorie WHERE nazwa = '%s'", "verifyCategoryExists", $_SESSION["adv-search-category"]);
                        // ✓ przestawi $_SESSION["category-exists"] na true, jeśli taka kategoria (nazwa) istnieje;
                        if( $category === false || $category === null || ($_SESSION["adv-search-category"] !== $_POST["adv-search-category"]) || $_SESSION["category-exists"] === false ) {
                            // category empty ("") or failed validation ;
                            $valid = false;
                        }
                    } else {
                        // kategoria == "Wszystkie";
                        if( $category === false || $category === null || ($_SESSION["adv-search-category"] !== $_POST["adv-search-category"])) {
                            // category empty ("") (null) or failed validation (false) ;
                            $valid = false;
                        }
                    }*/

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

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // set up the initial query string --> ;

            // przed uwzględnieniem statusu - "dostępna / niedostępna" -->

            /* $_SESSION["adv-search-query"] = "SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania,
                               ks.rating,
                               kt.nazwa, sb.id_kategorii,
                               au.imie, au.nazwisko
                               FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb";*/

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            // dodanie statusu - "dostępna / niedostępna" -->

            $_SESSION["adv-search-query"] = "SELECT
                                ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                kt.nazwa, sb.id_kategorii,
                                au.imie, au.nazwisko,
                                SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                            FROM
                                books AS ks
                            JOIN
                                author AS au ON ks.id_autora = au.id_autora
                            JOIN
                                subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                            JOIN
                                categories AS kt ON sb.id_kategorii = kt.id_kategorii
                            LEFT JOIN
                                warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                            ";


            if (!empty($_POST["adv-search-title"])) { // SANITIZE adv-seatch-title;

                $title = filter_input(INPUT_POST, "adv-search-title", FILTER_SANITIZE_STRING);
                $_SESSION["adv-search-title"] = $title;

                if (empty($title) || ($_SESSION["adv-search-title"] !== $_POST["adv-search-title"]) || strlen($title)>255 ) {
                    // (false) - nie przeszedł walidacji,
                    $valid = false;
                }
            }
            // ( jest ustawiona wcześniej ) ;
            // if ( isset($_POST["adv-search-category"]) && ! empty($_POST["adv-search-category"]) ) {
            //     // sanitize category;
            //     $category = filter_input(INPUT_POST, "adv-search-category", FILTER_SANITIZE_STRING);
            // }
            if (!empty($_POST["adv-search-author"])) { // sanitize adv-search-author;

                // get highest author-id from database ;
                //unset($_SESSION["max-author-id"]);
                $maxAuthorId = query("SELECT MAX(id_autora) AS id_autora FROM author", "getAuthorId", "");
                // $_SESSION["max-author-id"] => id_autora --> "36";

                $author = filter_input(INPUT_POST, "adv-search-author", FILTER_SANITIZE_NUMBER_INT);
                // Remove all characters except digits, plus and minus sign; --> $author | FALSE

                // validate author-id - ✓ valid integer in specific range ;
                $_SESSION["adv-search-author"] = filter_var($author, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1,                         // Minimum allowed author-id value
                            'max_range' => $maxAuthorId // Maximum allowed author-id value (highest author-id in database) ; functions() -> "get_author_id()"
                        ]
                    ]
                ); // ✓ It ensures that the value is an integer within the specified range;

                // check if that author (id) exists in db ... ;
                //unset($_SESSION["author-exists"]);
                $authorExists = query("SELECT id_autora FROM author WHERE id_autora = '%s'", "verifyAuthorExists", $_SESSION["adv-search-author"]);
                // ✓ $_SESSION["author-exists"] --> true/false, (zależnie od tego, czy istnieje taki autor o takim id)

                if( empty($author) // (false) - id nie przeszło walidacji
                    || empty($_SESSION["adv-search-author"]) || ($_SESSION["adv-search-author"] != $_POST["adv-search-author"]) || empty($authorExists) ) {
                    // author (id) didn't pass validation
                    $valid = false;
                }

                unset($author, $_SESSION["max-author-id"], $authorExists);
            }

            if (!empty($_POST['year-min'])) { // check if the user provided a minimum year

                $year_min = filter_input(INPUT_POST, "year-min", FILTER_SANITIZE_NUMBER_INT);

                $_SESSION["year-min"] = filter_var($year_min, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1900, // Minimum allowed year value
                            'max_range' => 2023  // Maximum allowed year value
                        ]
                    ]
                );

                if( $year_min === false || $_SESSION["year-min"] === false ) {
                    $valid = false;
                }
            }

            if (!empty($_POST['year-max'])) { // check if the user provided a maximum year

                $year_max = filter_input(INPUT_POST, "year-max", FILTER_SANITIZE_NUMBER_INT);

                $_SESSION["year-max"] = filter_var($year_max, FILTER_VALIDATE_INT, [
                        'options' => [
                            'min_range' => 1900, // Minimum allowed year value
                            'max_range' => 2023  // Maximum allowed year value
                        ]
                    ]
                );

                if( $year_max === false || $_SESSION["year-max"] === false ) {
                    $valid = false;
                }

                if ($_SESSION["year-min"] > $_SESSION["year-max"]) {
                    $valid = false;
                }
            }

            // $_SESSION["adv-search-category"]
            // $_SESSION["adv-search-title"]
            // $_SESSION["adv-search-author"]
            // ...

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////

            if ($valid === false) {
                // validation failed - data didn't pass validation -  redirect to main-page (index.php);

                $_SESSION["application-error"] = true;

                unset($_POST, $category, $_SESSION["adv-search-category"], $_SESSION["category"], $_SESSION["category-exists"], $title, $_SESSION["adv-search-title"], $author, $_SESSION["adv-search-author"], $_SESSION["max-author-id"], $_SESSION["author-exists"], $_SESSION["adv-search-query"], $year_min, $year_max, $_SESSION["year-min"], $_SESSION["year-max"]);
                    /*header('Location: index.php', true, 303);
                        exit();*/

            } else { // $valid === true;

                // validation passed - all POST values are valid (correct) ;
                // echo "<br> all POST values are valid (correct) <br>"; exit();
                    // ✓ zmienne sesyjne ($_SESSION) z formularza ustawione

                // Initialize an array to store the conditions for the WHERE clause;

                $where = [];  // WHERE CONDITION
                $values = []; // VALUES USED AS ARGUMENTS

                if (!empty($_SESSION["adv-search-title"])) { // check if the user provided a book title;
                    // Add a condition for the book title (!)
                        // $where[] = "ks.tytul LIKE '%" . $_POST['adv-search-title'] . "%'";
                    $where[] = "ks.tytul LIKE '%%%s%%'"; //%%%s%%
                    $values[] = $_SESSION['adv-search-title']; // values += ["title"];
                }

                if ($_SESSION["adv-search-category"] != "Wszystkie") { // check if the user selected a category;
                    // Add a condition for the category
                        // $where[] = "ks.kategoria = '" . $_POST['adv-search-category'] . "'"; // do usunięcia - ponieważ zmiena POST może mieć wartość "Wszystkie" - a takiej nazwy nie ma w tabeli "kategorie" !
                    $where[] = "kt.nazwa = '%s'";
                    $values[] = $_SESSION["adv-search-category"]; // values += ["kategoria"]; // ✓
                }

                if (!empty($_SESSION["adv-search-author"])) { // Check if the user selected an author (author-id)
                    // Add a condition for the author
                        // $where[] = "ks.id_autora = " . $_POST['adv-search-author'];
                    $where[] = "ks.id_autora = '%s'";
                    $values[] = $_SESSION["adv-search-author"];
                }

                if (!empty($_SESSION["year-min"])) { // check if the user provided a minimum year
                    // Add a condition for the minimum year
                        // $where[] = "ks.rok_wydania >= " . $_POST['year-min'];
                    $where[] = "ks.rok_wydania >= '%s'";
                    $values[] = $_SESSION["year-min"];
                }

                if (!empty($_SESSION["year-max"])) { // check if the user provided a maximum year
                    // Add a condition for the maximum year
                        // $where[] = "ks.rok_wydania <= " . $_POST['year-max'];
                    $where[] = "ks.rok_wydania <= '%s'";
                    $values[] = $_SESSION["year-max"];
                }

                if (!empty($where)) { // check if any conditions were added to the WHERE clause

                    // Combine the conditions into a single WHERE clause

                            //$query .= " WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii AND " . implode(" AND ", $where);
                            // nie trzeba względniać relacji po WHERE, ponieważ użyto wsześniej klauzuli JOIN (!);

                            // $_SESSION["adv-search-query"] .= " WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii AND " . implode(" AND ", $where) . " GROUP BY ks.id_ksiazki ";


                    // $where -> Array ( [0] => ks.tytul LIKE '%%%s%%'
                    //                   [1] => kt.nazwa = '%s'
                    //                   [2] => ks.id_autora = '%s'
                    //                   [3] => ks.rok_wydania >= '%s'
                    //                   [4] => ks.rok_wydania <= '%s' )

                    $_SESSION["adv-search-query"] .= " WHERE " . implode(" AND ", $where) . " GROUP BY ks.id_ksiazki ";; // implode() - połącz elementy tablicy jako string z separatorem "AND";

                    // $_SESSION["adv-search-query"] => SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, kt.nazwa, sb.id_kategorii, au.imie, au.nazwisko, SUM(magazyn_ksiazki.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy FROM ksiazki AS ks JOIN autor AS au ON ks.id_autora = au.id_autora JOIN subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii JOIN kategorie AS kt ON sb.id_kategorii = kt.id_kategorii LEFT JOIN magazyn_ksiazki ON magazyn_ksiazki.id_ksiazki = ks.id_ksiazki WHERE ks.tytul LIKE '%%%s%%' AND kt.nazwa = '%s' AND ks.id_autora = '%s' AND ks.rok_wydania >= '%s' AND ks.rok_wydania <= '%s' GROUP BY ks.id_ksiazki

                    $_SESSION["adv-search-values"] = $values; // VALUES => Array ( [0] => php [1] => Informatyka [2] => 2 [3] => 1992 [4] => 2018 )
                }

                    // (testing) - execute the query
                    // query($query, "get_books", $values);

                /*header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // prg - to prevent resubmitting the form
                exit();*/

            } // $valid == true;

        }     // if ( isset($_POST["adv-search-title"]) && isset($_POST["adv-search-category"]) && ... )

        header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); // prg - to prevent resubmitting the form
            exit();

    }         // if ( $_SERVER['REQUEST_METHOD'] === "POST" ) ...

    if (empty($_SESSION["category"])) {

        $_SESSION["category"] = "Wszystkie"; // "normal" entry from main-page (index.php) ;
    }

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

                        <?= "<h3>".$_SESSION["category"]; ?>

                        <?= isset($_SESSION["subcategory"]) ? " / " . $_SESSION["subcategory"] . "</h3>" : ""; ?>

                        <h3>
                            <label for="sortBy">Sortowanie</label>
                        </h3>

                        <select id="sortBy">
                            <option data-sort="price" data-order="asc">ceny rosnąco</option>
                            <option data-sort="price" data-order="desc">ceny malejąco</option>
                            <option data-sort="title" data-order="asc">nazwy A-Z</option>
                            <option data-sort="title" data-order="desc">nazwy Z-A</option>
                            <option data-sort="year" data-order="asc">Najstarszych</option>
                            <option data-sort="year" data-order="desc">Najnowszych</option>
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
                                        <input type="number" id="min-price" step="1" min="5">
                                </label>
                            <label>
                                <span>
                                    Max
                                </span>
                                    <input type="number" id="max-price" step="1" max="150">
                            </label>

                            <div id="price-slider"></div> <!-- jQuery NoUISlider --> <!-- noUiSlider -->
                        </div>

                        <div id="input-search-nav-div">

                            <label for="input-search-nav">
                                <h3>Tytyuł</h3>
                            </label>

                            <form method="post"> <!-- action="index.php" -->
                                    <!-- (szukaj tytułu w tej kategorii) -->
                                    <input type="search" name="input-search-nav" id="input-search-nav" placeholder="tytuł książki">
                                <!--<input type="submit" value="">-->

                                <button type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </form>

                        </div>

                        <h3>
                            <label for="all-authors">Autorzy</label>
                        </h3>

                        <ul id="ul-authors">
                            <?php
                                query("SELECT DISTINCT imie, nazwisko, id_autora FROM author ORDER BY imie", "getAuthors", "");
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

                <div id="content">

                    <div id="content-books">

                        <?php

                            /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                            echo "GET ->"; print_r($_GET); echo "<hr><br>";
                            echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/

                            // nie ma sensu sprawdzać czy kategoria jest ustawiona, ponieważ zawsze jest (w zmiennej $_SESSION['kategoria']);
                                // (z wyjątkiem gdy wprowadzono tytuł w input-search-nav);

                            //   $_GET['kategoria'] --> $_SESSION["kategoria"] --> "Horror"    (zapis do ZS)
                            // ! $_GET['kategoria'] --> $_SESSION["kategoria"] --> "Wszystkie" (domyślnie)
                            // ✓ Kategoria jest ustawiona zawsze;

                            if (isset($_SESSION["input-search"])) {

                                // PRG -> jeśli jest ustawiona Z.S. input-search, to tutaj kategoria zawsze będzie wynosić "Wszyskie"
                                // ponieważ input-search szuka książek we wszystkich kategoriach ;

                                $search_value = $_SESSION["input-search"];
                                    unset($_SESSION["input-search"]);

                                    /*query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating,
                                                             kt.nazwa, sb.id_kategorii,
                                                                au.imie, au.nazwisko
                                                             FROM ksiazki AS ks, autor AS au, kategorie AS kt, subkategorie AS sb
                                                             WHERE ks.id_autora = au.id_autora AND sb.id_kategorii = kt.id_kategorii AND ks.id_subkategorii = sb.id_subkategorii
                                                             AND ks.tytul LIKE '%%%s%%'", "get_books", $search_value);*/ // kategorie => nazwa, id_kategorii;

                                // dodanie statusu - "dostępna / niedostępna" -->

                                query("SELECT ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                              kt.nazwa, sb.id_kategorii, 
                                              au.imie, au.nazwisko,
                                              SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                                        FROM 
                                              books AS ks
                                        JOIN 
                                              author AS au ON ks.id_autora = au.id_autora
                                        JOIN 
                                              subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                        JOIN 
                                              categories AS kt ON sb.id_kategorii = kt.id_kategorii
                                        LEFT JOIN 
                                              warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                                        WHERE ks.tytul LIKE '%%%s%%' 
                                        GROUP BY ks.id_ksiazki", "getBooks", $search_value); // input-search => tytuł książki;

                            }

                            elseif (isset($_SESSION["input-search-nav"])) { //  && ! empty($_SESSION["input-search-nav"])
                                                                              // wystarczy sprawdzić czy istnieje, bo sprawdzenie czy jest puste odbywa się wcześniej ;

                                // ✓ tutaj zmienna sesyjna "kategoria" przyjmuje wartość "Wszystkie" lub dowolną inną kategorią z istniejących - ponieważ wsześniej zostaje ustawiona;

                                $search_value = $_SESSION["input-search-nav"];
                                    unset($_SESSION["input-search-nav"]);

                                $values = [$search_value]; // VALUES USED AS ARGUMENTS

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

                                // dodanie statusu - "dostępna / niedostępna" -->

                                $query = "SELECT
                                            ks.id_ksiazki, ks.image_url, ks.tytul, ks.cena, ks.rok_wydania, ks.rating, 
                                            kt.nazwa, sb.id_kategorii, sb.nazwa,
                                            au.imie, au.nazwisko,
                                            SUM(warehouse_books.ilosc_dostepnych_egzemplarzy) AS ilosc_egzemplarzy
                                        FROM 
                                            books AS ks
                                        JOIN 
                                            author AS au ON ks.id_autora = au.id_autora
                                        JOIN 
                                            subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                        JOIN 
                                            categories AS kt ON sb.id_kategorii = kt.id_kategorii
                                        LEFT JOIN 
                                            warehouse_books ON warehouse_books.id_ksiazki = ks.id_ksiazki
                                        WHERE ks.tytul LIKE '%%%s%%'";

                                if ($_SESSION["category"] !== "Wszystkie") {
                                    // kategoria zawsze jest ustawiona wsześniej, przyjmuje wartość "Wszystkie" lub dowolną inną z istniejących;
                                        // jeśli kategoria to np. "Informatyka", "Horror", "Fantastyka";

                                    $where = []; // WHERE CONDITION
                                        // $where[] = " AND ks.kategoria LIKE '%%%s%%'"; //%%%s%%
                                    $where[] = " AND kt.nazwa LIKE '%%%s%%'"; //%%%s%% // "Informatyka", "Horror", "Fantastyka";
                                    $values[] = $_SESSION["category"]; // dodanie do tablicy argumentów zmiennej kategoria - do użycia w funkcji query(); // od teraz values = ["input-search-nav" (tytul), "kategoria"];

                                    if (isset($_SESSION["subcategory"])) { // jeśli jest ustawiona pod-kateoria;
                                        $where[] = " AND sb.nazwa LIKE '%%%s%%'"; // szukaj w także w tej podkategorii;
                                        $values[] = $_SESSION['subcategory'];
                                    }
                                }

                                if (!empty($where)) { // dodanie do zapytania warunku  w którym kategoria to ->  "Informatyka", "Horror", "Fantastyka";

                                    $query .= implode("", $where);  // combine the conditions into a single WHERE clause
                                }

                                $query .= " GROUP BY ks.id_ksiazki";

                                /*echo "<br><hr><br> query --> <br><br>";
                                echo $query . "<br><br><hr><br>";*/

                                query($query, "getBooks", $values);
                            }

                            // wyszukiwanie zaawansowane - advanced search result (POST);

                            elseif (isset($_SESSION["adv-search-query"])) {

                                // execute the query - advanced-search;
                                query($_SESSION["adv-search-query"], "getBooks", $_SESSION["adv-search-values"]);

                                unset($_SESSION["adv-search-query"], $_SESSION["adv-search-values"], $_SESSION["adv-search-title"], $_SESSION["adv-search-category"], $_SESSION["adv-search-author"], $_SESSION["year-min"], $_SESSION["year-max"]);
                            }
                            else {
                                // domyślnie - strona główna - LUB - POST kategoria;

                                    /*sanityzacja danych wprowadzonych od użytkownika; html entities = encje html'a; <script>alert("hahaha");</script>;
                                    $kategoria = htmlentities($_GET['kategoria'], ENT_QUOTES, "UTF-8"); // do usunięcia;
                                    $kategoria = strip_tags($kategoria); // do usunięcia
                                    $_SESSION['kategoria'] = $kategoria; // do usunięcia
                                    ~ (?) wstawienie kategorii do zmiennej sesyjnej -> (koszyk_dodaj.php - walidacja danych - czy jest to liczba ?); // (?);*/

                                    if (isset($_SESSION["no-results"]) && !empty($_SESSION["no-results"])) {
                                        echo '<span class="main-page-search-result-error">' . $_SESSION["no-results"] . '</span>';
                                        unset($_SESSION["no-results"]);
                                    }
                                    else {
                                        if (isset($_SESSION["subcategory"])) {
                                            displayBooksWithSubcategory($_SESSION["category"], $_SESSION["subcategory"]);
                                        } else {
                                            displayBooks($_SESSION["category"]);
                                        }
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

                    </div>
                </div>
            </main>
        </div> <!-- #container -->

        <?php require "../view/___footer.php"; ?>

    </div> <!-- #main-container -->

    <?php require "../view/app-error-window.php"; ?>

<script>
    // save selected sorting option IN LOCAL STORAGE - after page reload;
    /* var selectElement = document.getElementById("sortBy");
    selectElement.addEventListener("change", function() {
        var selectedValue = selectElement.value;
        localStorage.setItem("selectedValue", selectedValue); // "1" / "2" / "3" / ... / "6";
    });
    window.addEventListener("load", function() {
        var selectedValue = localStorage.getItem("selectedValue");
        if (selectedValue && selectElement) {
            selectElement.value = selectedValue;
            sortBooks(); // execute sorting function;
            //filterAuthors();
        }
    }); */
</script>

    <script src="../scripts/filter-book-status.js"></script>  <!-- filtrowanie - status -> "dostępna" / "niedostępna" -->

<script>

    function showCategories() { // dla widoku mobilnego ;
            // pokazanie / ukrycie list kategorii, pod-kateorii;
        let list = document.getElementById("categories-list"); // lista <ul> - Kategorie;
        let sublist = document.getElementById("subcategories-list");  // lista <ul> - pod-kategorie;
       if(list.style.display === "block") {
                //list.removeAttribute("style");
           list.style.display = "none";
                //sublist.removeAttribute("style");
           //sublist.style.visibility = "hidden";
           sublist.style.display = "none";
        } else {
            list.style.display = "block";
            //sublist.style.visibility = "visible";
            sublist.style.display = "block";
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // kliknięcie na "Kategorie" wyświetla listę kategorii - click on "Kategorie" in top nav -> hiding/displaying <ul> list;
    let categoryButton = document.getElementById("a-categories-top-nav");
    //console.log("\ncategoryButton -> ", categoryButton); // "Kategorie";
    function isMobileDevice() {
        return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    if (isMobileDevice()) {
        //console.log("This website is being accessed from a mobile device.");
        categoryButton.addEventListener("click", showCategories);
    }
</script>

<script>
    /*let bookData = '<?php //query("SELECT sb.id_subkategorii, sb.nazwa, kt.nazwa FROM subkategorie AS sb, kategorie AS kt WHERE sb.id_kategorii = kt.id_kategorii", "getSubcategories", ""); ?>';*/
</script>

<script>
    /*let styleSheet = document.styleSheets[0];
    console.log("\n\n styleSheet --> ", styleSheet);
    // Pobierz regułę CSS z arkusza stylów
    //var cssRule = null;
    for (let i = 0; i < styleSheet.cssRules.length; i++) {
        let rule = styleSheet.cssRules[i];
        if (rule.selectorText === "#n-top-nav-content ol li ul") {
                //cssRule = rule;
                //break;
            rule.style.visibility = "unset";
        } else if (rule.selectorText === "#n-top-nav ol > li:hover > ul") {
            rule.style.visibility = "unset";
        }
    }*/
    // Jeśli znaleziono regułę, usuń właściwość visibility
    /*if (cssRule) {
        cssRule.style.visibility = "visible"; // Zmień na "visible", aby wyłączyć właściwość
    }*/
    if(isMobileDevice()) {
        let styleSheet = document.styleSheets[0];
        //console.log("\n\n styleSheet --> ", styleSheet);
        // Pobierz regułę CSS z arkusza stylów
        //var cssRule = null;
        for (let i = 0; i < styleSheet.cssRules.length; i++) {
            let rule = styleSheet.cssRules[i];
            if (rule.selectorText === "#n-top-nav-content ol li ul") {
                //cssRule = rule;
                //break;
                rule.style.visibility = "unset";
                rule.style.display = "none";
            } else if (rule.selectorText === "#n-top-nav ol > li:hover > ul") {
                rule.style.visibility = "visible";
            }
        }``
    }
</script>

</body>
</html>