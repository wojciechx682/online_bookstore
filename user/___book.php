<?php

    require_once "../start-session.php";

    // Implementacja wzorca PRG (Post-Redirect-Get);

    if ($_SERVER['REQUEST_METHOD'] === "POST") { // isset($_POST)  ̶&̶&̶ ̶!̶ ̶e̶m̶p̶t̶y̶(̶$̶_̶P̶O̶S̶T̶)̶

        if (isset($_POST["book-id"]) && !empty($_POST["book-id"])) { // "35" ; // check if POST value (id_ksiazki) exists and is not empty;

            // Process the form data and perform necessary validations ;

            $bookId = validateBookId($_POST["book-id"]); // "35" or FALSE; <-- validate book-id - is it valid ID (integer) and is there a book with that ID ?

            if (empty($bookId)) {
                // ✓ id-książki nie przeszło walidacji, LUB ✓ nie istnieje książka o takim id;
                $_SESSION["application-error"] = true; // \view\app-error-window.php <-- "Wystąpił błąd";

                unset($_POST, $bookId);
                    header('Location: index.php', true, 303);
                        exit();

            } else {
                // input OK - book-id passed validation,    there is a book with that ID;
                     //               Valid book-id           and           book-exists

                $_SESSION["book-id"] = $bookId; // wartość po walidacji;

                // --> keep $_SESSION["book-id"];
                // Redirect to prevent form resubmission // to prevent resubmitting the form
                unset($_POST, $bookId);
                    header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
                        exit();
            }


/*// sanitize input - book-id ;
$book = filter_var($_POST["book-id"], FILTER_SANITIZE_NUMBER_INT); // "35" or FALSE;
unset($_SESSION["max-book-id"]);
query("SELECT MAX(id_ksiazki) AS id_ksiazki FROM ksiazki", "getBookId", ""); // get highest book-id from database ;
// $_SESSION["max-book-id"] = "35"
// - set variable to be applied in book-id filter below;
// (if book-id is higher than maximum id number in db - manage the error - redirect to index.php);
// validate book-id - ✓ valid integer in specific range ;
$_SESSION["book-id"] = filter_var($book, FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 1,                       // Minimum allowed book-id value
            'max_range' => $_SESSION["max-book-id"] // Maximum allowed book-id value (highest book-id in database) ; functions() -> "getBookId()"
        ]
    ]
); // It ensures that the value is an integer within the specified range;
// check if there is really a book with that id ;
unset($_SESSION["book_exists"]);
query("SELECT id_ksiazki FROM ksiazki WHERE id_ksiazki = '%s'", "verifyBookExists", $_SESSION["book-id"]);
    // sprawdzenie, czy ta książka istnieje w bd ; check if there is any book with given POST id; jeśli num_rows > 0;
// $_SESSION["book_exists"] --> true - zależnie od tego czy książka o takim ID istnieje ; NULL otherwise (!)*/

        /*if ( $book === false || $_SESSION["book-id"] === false || empty($_SESSION["book_exists"]) || empty($_SESSION["max-book-id"]) || ($_SESSION["book-id"] != $_POST["book-id"])) {

            // ✓ id-książki nie przeszło walidacji, LUB ✓ nie istnieje książka o takim id;

            unset($_POST, $book, $_SESSION["book-id"], $_SESSION["max-book-id"], $_SESSION["book_exists"]);

            header('Location: index.php', true, 303); exit();

        } else { // input OK - book-id passed validation,    there is a book with that ID;
                 //               Valid book-id           and           book-exists
            // Execute code (such as database updates) here;
            // Perform any required actions with the form data (e.g., database update);

                unset($_POST, $_SESSION["max-book-id"], $book, $_SESSION["book_exists"]); // keep $_SESSION["book-id"];

            // Redirect to prevent form resubmission // to prevent resubmitting the form
            header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); exit();
        }*/

        } else {
            // zmienna POST nie istnieje,   nastąpiło wejście pod /user/___book.php bez podania wartości w POST[] ;
            //echo "<br> POST value (book-id) doesnt exist <br>" ;
            $_SESSION["application-error"] = true;
            header('Location: index.php', true, 303); exit();
        }

    } elseif ($_SERVER['REQUEST_METHOD'] === "GET" && (empty($_SESSION["book-id"])) ) {
        // wejście pod adres \user\book.php - (GET) - poprzez URL - zmienna $_SESSION["book-id"] nie istnieje;
        $_SESSION["application-error"] = true;
        header('Location: index.php', true, 303); exit();

    } elseif ($_SERVER['REQUEST_METHOD'] === "GET" && (!empty($_SESSION["book-id"])) && (!empty($_SESSION["rating"])) )  {

        // pobierz liczbę ocen książki, jeśli wynosi zero, zapisz ten stan do zmiennej -->
        query("SELECT ks.id_ksiazki, ks.tytul, ks.rating, (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki) AS liczba_ocen
               FROM books AS ks
               WHERE ks.id_ksiazki = '%s'", "updateBookRates", $_SESSION["book-id"]); // <-- UPDATE

        unset($_SESSION["rating"]);
        // Redirect to prevent form resubmission // to prevent resubmitting the form
        header('Location: ' . $_SERVER['REQUEST_URI'], true, 303); exit();
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

                <div id="content">

                    <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_SESSION["book-id"]) ) : ?>

                        <!--query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.id_autora, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan, kt.nazwa, sb.id_kategorii, (SELECT COUNT(*) FROM komentarze WHERE id_ksiazki = ks.id_ksiazki AND tresc IS NOT NULL) AS liczba_komentarzy, (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki AND ocena IS NOT NULL) AS liczba_ocen, (SELECT SUM(ilosc_dostepnych_egzemplarzy) FROM magazyn_ksiazki WHERE id_ksiazki = ks.id_ksiazki AND ilosc_dostepnych_egzemplarzy IS NOT NULL) AS liczba_egzemplarzy, au.imie, au.nazwisko, au.id_autora, ks.id_wydawcy, wd.nazwa_wydawcy FROM ksiazki AS ks JOIN subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii JOIN kategorie AS kt ON sb.id_kategorii = kt.id_kategorii LEFT JOIN autor AS au ON ks.id_autora = au.id_autora LEFT JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy WHERE ks.id_ksiazki = '%s'", "get_book", $_SESSION["book-id"]);-->

                        <?php

                           /* echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                            echo "GET ->"; print_r($_GET); echo "<hr><br>";
                            echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";*/

                            echo '<div id="aaa"><a href="index.php" id="get-back-a"><i class="icon-down-open" id="book-page-get-back"></i>Wróć </a></div>';
                            /*echo '<a href="index.php">&larr; Wróć </a>'; // tymczasowe (!) ;*/

                            if(isset($_SESSION["avg_rating"])) {
                                unset($_SESSION["avg_rating"]); // $row["rating"];
                            }

                            query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.id_autora, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan, ks.opis, kt.nazwa AS kategoria, sb.id_kategorii, sb.nazwa AS podkategoria,
       
                                             (SELECT COUNT(*) FROM comments WHERE id_ksiazki = ks.id_ksiazki) AS liczba_komentarzy, 
                                             (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki) AS liczba_ocen, 
                                             (SELECT SUM(ilosc_dostepnych_egzemplarzy) FROM warehouse_books WHERE id_ksiazki = ks.id_ksiazki) AS liczba_egzemplarzy, 
                                             
                                             au.imie, au.nazwisko, au.id_autora, ks.id_wydawcy, wd.nazwa_wydawcy 
                                         FROM books AS ks 
                                             JOIN subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii 
                                             JOIN categories AS kt ON sb.id_kategorii = kt.id_kategorii 
                                             JOIN author AS au ON ks.id_autora = au.id_autora 
                                             JOIN publishers AS wd ON ks.id_wydawcy = wd.id_wydawcy 
                                         WHERE ks.id_ksiazki = '%s'", "getBook", $_SESSION["book-id"]); // \template\book-page.php ;

                       /* echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr><br>";*/

                            $_SESSION["ratings"] = [];

                            query("SELECT ocena, COUNT(ocena) AS liczba_ocen FROM ratings WHERE id_ksiazki = '%s' GROUP BY ocena ORDER BY ocena DESC", "getRatings", $_SESSION["book-id"]); // $_SESSION["ratings"] <--

                            /*if(empty($_SESSION["ratings"])) {
                                $_SESSION["ratings"] = [];
                            }*/

                                // ✓ potrzebne w widoku w sekcji "Recenzje" ; poziome paski z ocenami (żółte/szare) ;

                                // $_SESSION['ratings'] -> key => ocena,  value => ilosc_ocen;

                                // ocena  liczba_ocen
                                //   5	      1
                                //   4	      1
                                                             // $_SESSION["ratings"] -> [5] => 2
                                                             //                         [4] => 1 ;

                            $_SESSION["raings_array"] = json_encode($_SESSION["ratings"]); // JSON string;

                                // funstions -> get_ratings() -> to pass that array (PHP) to JS
                                //       { "5" : "2", "4" : "1" }           <-- type "string" - zwraca JSON'a !
                                // The json_encode() function is used to encode a PHP value into a JSON string;

                            /*echo "<hr><br>";*/
                        /*echo "<b>".'$_SESSION["comments"] - comments  (PHP) -->'."</b><br><br>";
                        print_r($_SESSION["comments"]); echo "<br><br>";
                        var_dump($_SESSION["comments"]);
                                echo "<b>".'$_SESSION["ratings"] - ratings array (PHP) -->'."</b><br><br>";
                                print_r($_SESSION["ratings"]); echo "<br><br>";
                                var_dump($_SESSION["ratings"]);
                                echo "<br><br><b>".'$_SESSION["raings_array"] - ratings array (JS) -->'."</b><br><br>";
                                print_r($_SESSION["raings_array"] );
                                echo "<br><br><b>".'$_SESSION["liczba_ocen"] - liczba_ocen --> '."</b><br><br>";
                                print_r($_SESSION["liczba_ocen"] ); echo "<br><br>";
                                var_dump($_SESSION["liczba_ocen"] );
                            echo "<hr><br><br>";*/
                            /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                            echo "GET ->"; print_r($_GET); echo "<hr><br>";
                            echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/
                        ?>

                    <?php endif; ?>

                    <?php //exit(); ?>

                    <?php

                    // -------------------------------------------------------------------------------------------------
                    // Problemy implementacyjne ->

                    // 1. Po kliknięciu gwiazdki przy dodawaniu opinii, -- zostały one resetowane po najechaniu na inną gwiazdkę.
                    //    - Od teraz, po kiknięciu, gwiazdki zostają zapisane. (najechanie na inną gwiazdkę nie zmienia ich stanu - jedynie dopiero kliknięcie)

                    // 2. Podczas dodawania opinii, przy kliknięciu dwóch gwiazdek w następującej po sobie kolejności, wystąpił błąd polegający na dodaniu niewłaściwej oceny w skali 5/5 (Np. jeśli użytkownik kliknął "3", a potem "2" - ocena została zapisana jako "3")
                    // - rozwiązaniem było dodanie funkcji usuwającej atrybuty "name" ze wszystkich gwiazdek - po kliknięciu na dowolną gwiazdkę;
                    // (atrybut "name" posiada tylko ten input, dla którego gwiazdka została kliknięta)

                    // 3. Podczas odświeżania strony z książką poprzeż użycie klawiszy Ctrl + F5 - pojawiał się błąd polegający na nieodopowiednim umiejscowieniu szarych gwiazdek proporcjonalnie względem żółtych gwizdek (w sekcji #book-page-details - przy zdjęciu książki).

                    // ✖ rozwiązaniem było dodanie linii window.onload - "która czeka" na wczytanie wszystkich zasobów strony (w tym stylów CSS) - tak aby ostatecznie zachować poprawne umiejscowienie żółtych i szarych gwizdek względem siebie ;

                    // ✓ rozwiązaniem było zastosowanie wartości procentowych (relatywnych) zamiast wartości wyrażonych w px - do ustalenia stylów tych elementów !

                    // 4. Animacja wypełniania okręgu na żółto (proporcjonalnie do średniej oceny) - OPISAĆ - jak zostało zrobione to, że wypełnienie zaczyna się od początku okręgu;

                    // -------------------------------------------------------------------------------------------------



                    //query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.image_url, ks.rating,
                    //km.id_klienta, km.tresc,
                    //rt.ocena, rt.id_klienta,
                    //au.imie, au.nazwisko,
                    //ks.id_wydawcy, wd.nazwa_wydawcy,
                    //mg.ilosc_dostepnych_egzemplarzy
                    //FROM ksiazki AS ks, autor AS au, komentarze AS km, ratings AS rt, magazyn_ksiazki AS mg, wydawcy AS wd
                    //WHERE ks.id_autora = au.id_autora AND  ks.id_ksiazki = km.id_ksiazki AND ks.id_ksiazki = rt.id_ksiazki AND ks.id_wydawcy wd.id_wydawcy AND ks.id_ksiazki = mg.id_ksiazki AND ks.id_ksiazki = '%s'", "get_book", $_GET["book"]);

                    //$book = filter_var(filter_input(INPUT_GET, 'book', FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);
                    //$book = filter_var(filter_input(INPUT_POST, 'book', FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);

                    // validate book's id ;

                    /*query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating,
                                 COUNT(km.id_ksiazki) AS liczba_komentarzy,
                                 COUNT(rt.ocena) AS liczba_ocen,
                                 au.imie, au.nazwisko,
                                 ks.id_wydawcy, wd.nazwa_wydawcy,
                                 mg.ilosc_dostepnych_egzemplarzy
                                 FROM ksiazki AS ks
                                     LEFT JOIN autor AS au ON ks.id_autora = au.id_autora
                                     LEFT JOIN komentarze AS km ON ks.id_ksiazki = km.id_ksiazki
                                     LEFT JOIN ratings AS rt ON ks.id_ksiazki = rt.id_ksiazki
                                     LEFT JOIN magazyn_ksiazki AS mg ON ks.id_ksiazki = mg.id_ksiazki
                                     LEFT JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy
                                 WHERE ks.id_ksiazki = '%s'", "get_book", $_GET["book"]);*/  // ERROR - nie zwraca poprawnej ilości ocen i komentarzy !
                    // The issue with your query is that you are using LEFT JOIN to join the ksiazki table with the komentarze and ratings tables. This means that for each row in the ksiazki table, all matching rows in the komentarze and ratings tables are returned. If there are multiple comments or ratings for a single book, each row for that book in the ksiazki table will be duplicated for each comment or rating. To fix this, you can use subqueries to count the number of comments and ratings for each book instead of joining the tables. Here's an example query that should give you the correct results

                    /* Solution below - This query uses subqueries to count the number of comments and ratings for each book by filtering the komentarze and ratings tables based on the book's id_ksiazki. This ensures that each book is only counted once, regardless of the number of comments or ratings it has.
                    This query uses subqueries to count the number of comments and ratings for each book by filtering the komentarze and ratings tables based on the book's id_ksiazki. This ensures that each book is only counted once, regardless of the number of comments or ratings it has.*/

                    /*query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,
                                (SELECT COUNT(*) FROM komentarze WHERE id_ksiazki = ks.id_ksiazki AND tresc IS NOT NULL) AS liczba_komentarzy,
                                (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki AND ocena IS NOT NULL) AS liczba_ocen,
                                    au.imie, au.nazwisko,
                                    ks.id_wydawcy, wd.nazwa_wydawcy,
                                    mg.ilosc_dostepnych_egzemplarzy
                                FROM ksiazki AS ks
                                    LEFT JOIN autor AS au ON ks.id_autora = au.id_autora
                                    LEFT JOIN magazyn_ksiazki AS mg ON ks.id_ksiazki = mg.id_ksiazki
                                    LEFT JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy
                                WHERE ks.id_ksiazki = '%s';
                                ", "get_book", $book);*/ // foregins key => id_autora, id_ksiazki, id_wydawcy

                    // wynik zapytania -->
                    // 35	Java - Techniki zaawansowane Wydanie V	44.5	2018	2 (id_subkategori)	twarda	325	Java_techniki_zaawansowane.png	4.5	370 x 337 x 76	nowa	2 (liczba_kom) 	2   (liczba_ocen)	Cezary	Sokołowski	1	Helion	126 (ilosc dost. egzemplarzy)

                    /* query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,
                                    (SELECT COUNT(*) FROM komentarze WHERE id_ksiazki = ks.id_ksiazki AND tresc IS NOT NULL) AS liczba_komentarzy,
                                    (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki AND ocena IS NOT NULL) AS liczba_ocen,

                                    (SELECT SUM(ilosc_dostepnych_egzemplarzy) FROM magazyn_ksiazki WHERE id_ksiazki = ks.id_ksiazki AND ilosc_dostepnych_egzemplarzy IS NOT NULL) AS liczba_egzemplarzy,

                                        au.imie, au.nazwisko,
                                        ks.id_wydawcy, wd.nazwa_wydawcy

                                    FROM ksiazki AS ks
                                        LEFT JOIN autor AS au ON ks.id_autora = au.id_autora
                                        LEFT JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy
                                    WHERE ks.id_ksiazki = '%s';
                                    ", "get_book", $book);*/

                    // wynik zapytania (taki sam jak poprzednio) -->
                    // 35	Java - Techniki zaawansowane Wydanie V	44.5	2018	2	twarda	325	Java_techniki_zaawansowane.png	4.5	370 x 337 x 76	nowa	2	2	126	Cezary	Sokołowski	1	Helion

                    // ✓ zmiana kwerendy po dodaniu subkategorii ->

                    /*query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.id_autora, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,
                                    kt.nazwa, sb.id_kategorii,
                                        (SELECT COUNT(*) FROM komentarze WHERE id_ksiazki = ks.id_ksiazki AND tresc IS NOT NULL) AS liczba_komentarzy,
                                        (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki AND ocena IS NOT NULL) AS liczba_ocen,
                                        (SELECT SUM(ilosc_dostepnych_egzemplarzy) FROM magazyn_ksiazki WHERE id_ksiazki = ks.id_ksiazki AND ilosc_dostepnych_egzemplarzy IS NOT NULL) AS liczba_egzemplarzy,
                                        au.imie, au.nazwisko, au.id_autora,
                                        ks.id_wydawcy, wd.nazwa_wydawcy
                                    FROM ksiazki AS ks
                                    JOIN subkategorie AS sb ON ks.id_subkategorii = sb.id_subkategorii
                                    JOIN kategorie AS kt ON sb.id_kategorii = kt.id_kategorii
                                    LEFT JOIN autor AS au ON ks.id_autora = au.id_autora
                                    LEFT JOIN wydawcy AS wd ON ks.id_wydawcy = wd.id_wydawcy
                                    WHERE ks.id_ksiazki = '%s'", "get_book", $_SESSION["book-id"]); */ // It is used to retrieve detailed information about a specific book (based on $_GET["book-id"])

                    // $_SESSION["book-id"]
                    // $book

                    /*
                        The given query retrieves data from multiple tables using various JOIN clauses and calculates additional fields using subqueries. Let's break it down step by step:

                        1. The SELECT statement specifies the columns to be retrieved from the tables.

                        2. The main table being queried is `ksiazki`, aliased as `ks`. Other tables are joined using the JOIN and LEFT JOIN clauses.

                        3. The JOIN clause connects the `ksiazki` table with the `subkategorie` table on the condition that the `id_subkategorii` values match.

                        4. Another JOIN clause connects the `subkategorie` table with the `kategorie` table on the condition that the `id_kategorii` values match.

                        5. The LEFT JOIN clauses connect the `ksiazki` table with the `autor` and `wydawcy` tables based on the respective IDs. LEFT JOIN is used to include records from the `ksiazki` table even if there is no matching record in the joined tables.

                        6. The WHERE clause filters the results based on the condition `ks.id_ksiazki = '%s'`. The `%s` placeholder suggests that the query is likely prepared or parameterized, and the actual value for `id_ksiazki` would be provided during runtime.

                        7. Within the SELECT statement, there are subqueries used to calculate additional fields:
                        - `(SELECT COUNT(*) FROM komentarze WHERE id_ksiazki = ks.id_ksiazki AND tresc IS NOT NULL) AS liczba_komentarzy` calculates the count of non-null comments for the given book.
                        - `(SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki AND ocena IS NOT NULL) AS liczba_ocen` calculates the count of non-null ratings for the given book.
                        - `(SELECT SUM(ilosc_dostepnych_egzemplarzy) FROM magazyn_ksiazki WHERE id_ksiazki = ks.id_ksiazki AND ilosc_dostepnych_egzemplarzy IS NOT NULL) AS liczba_egzemplarzy` calculates the sum of available copies for the given book.

                        In summary, this query fetches data from multiple tables, joins them based on specific conditions, and includes calculated fields using subqueries. It is used to retrieve detailed information about a specific book (`ks.id_ksiazki`) along with associated category, author, publisher, comment count, rating count, and available copies.
                     */

                    // wynik_zapytania -->

                    // 35	Java - Techniki zaawansowane Wydanie V	44.5	2018	32	twarda	325	Java_techniki_zaawansowane.png	4.5	370 x 337 x 76	nowa	Informatyka	4	2	2	126	Cezary	Sokołowski	32	1	Helion

                    // retrieves column =>
                    // id_ksiazki: The ID of the book.
                    // tytul: The title of the book.
                    // cena: The price of the book.
                    // rok_wydania: The year the book was published.
                    // kategoria: The category of the book.
                    // oprawa: The binding type of the book.
                    // ilosc_stron: The number of pages in the book.
                    // image_url: The URL of the book's cover image.
                    // rating: The average rating of the book.
                    // liczba_komentarzy: The number of comments on the book.
                    // liczba_ocen: The number of ratings for that specific book (!);

                    // imie: The first name of the book's author.
                    // nazwisko: The last name of the book's author.
                    // id_wydawcy: The ID of the book's publisher.
                    // nazwa_wydawcy: The name of the book's publisher.
                    // ilosc_dostepnych_egzemplarzy: The number of available copies of the book in the warehouse.

                    // pobranie ilości każdej oceny (5 - ilość 3, 4 - ilość 2, itd .... ->
                    // SD -> problem implementacyjny ;

                    // Oceny + Ich ilości dla tej książki ;
                    /*query("SELECT ocena, COUNT(ocena) AS liczba_ocen FROM ratings
                                        WHERE id_ksiazki = '%s'
                                        GROUP BY ocena
                                        ORDER BY ocena DESC
                                        ", "get_ratings", $book); */// ✓ potrzebne w widoku w sekcji "Recenzje" ; poziome paski z ocenami (żółte/szare) ;

                                    // $_SESSION['ratings'] -> key => ocena, value => ilosc_ocen;
                                    // $_SESSION["ratings"] -> [5] => 2 [4] => 1 ;

                    //$_SESSION["raings_array"] = json_encode($_SESSION["ratings"]);
                        // funstions -> get_ratings() -> to pass that array (PHP) to JS

                        //       { "5" : "2", "4" : "1" }           <-- type "string" - zwraca JSON'a !
                        // The json_encode() function is used to encode a PHP value into a JSON string;

                                                        //unset($_SESSION["book-id"]);
                    ?>

                </div> <!-- #content -->

            </main>

            <script>

                const rating = document.getElementById("book-rate").textContent;
                    // <span id="book-rate" style="display: none;"> %s </span> <!-- $row["rating"] - "4" -->
                    // "4.5" - type "string";    type "hidden" - "4.5",   ̶l̶u̶b̶ ̶ ̶n̶u̶l̶l̶ ̶ lub "0" ;

                    console.log("\n\n 471 rating -->", rating);
                    console.log("\n\n typeof rating -->", typeof rating);


                /*let circleTest = document.getElementById("rating-circle"); // <circle id="rating-circle" ...>
                let circumferenceTest = parseFloat(circleTest.getAttribute('r')) * 2 * Math.PI; // obwód koła;
                    console.log("\n250 circumferenceTest -> ", circumferenceTest); // "62.83185307179586" - type = "number";
                    console.log("\n250 typeof circumferenceTest -> ", typeof circumferenceTest);
                    //console.log("\n250 circumferenceTest -> ", circumferenceTest);
                    //circleTest.style.strokeDasharray = `circumferenceTest`;
                    //circleTest.style.strokeDashoffset = `circumferenceTest`;
                circleTest.style.strokeDasharray = circumferenceTest;
                circleTest.style.strokeDashoffset  = circumferenceTest;*/


                // (!) właściwość stroke-dasharray - definiuje długość złotej linii (ob - obwodu koła), oraz długości odstępów (przerw),  ̶,̶ ̶a̶ ̶w̶i̶ę̶c̶ ̶a̶b̶y̶ ̶p̶o̶c̶z̶ą̶t̶k̶o̶w̶o̶ ̶u̶k̶r̶y̶ć̶ ̶z̶ł̶o̶t̶y̶ ̶o̶k̶r̶ą̶g̶,̶ ̶n̶a̶l̶e̶ż̶y̶ ̶u̶s̶t̶a̶w̶i̶ć̶ ̶ ̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶=̶"̶ ̶"̶ ̶n̶a̶ ̶w̶a̶r̶t̶o̶ś̶ć̶ ̶r̶ó̶w̶n̶ą̶ ̶O̶B̶W̶O̶D̶O̶W̶I̶ ̶K̶O̶Ł̶A̶ ̶-̶ ̶d̶z̶i̶ę̶k̶i̶ ̶c̶z̶e̶m̶u̶ ̶p̶r̶z̶e̶r̶w̶a̶ ̶p̶o̶m̶i̶ę̶d̶z̶y̶ ̶w̶z̶o̶r̶e̶m̶ ̶w̶y̶n̶i̶e̶s̶i̶e̶ ̶d̶o̶k̶ł̶a̶d̶n̶i̶e̶ ̶t̶y̶l̶e̶ ̶c̶o̶ ̶o̶b̶w̶ó̶d̶ ̶k̶o̶ł̶a̶,̶ ̶c̶z̶y̶l̶i̶ ̶z̶ł̶o̶t̶y̶ ̶o̶k̶r̶ą̶g̶ ̶b̶ę̶d̶z̶i̶e̶ ̶n̶i̶e̶w̶i̶d̶o̶c̶z̶n̶y̶ ̶;̶

                //  ̶"̶ ̶i̶t̶ ̶c̶r̶e̶a̶t̶e̶s̶ ̶a̶ ̶d̶a̶s̶h̶ ̶p̶a̶t̶t̶e̶r̶n̶ ̶w̶i̶t̶h̶ ̶a̶ ̶d̶a̶s̶h̶ ̶l̶e̶n̶g̶t̶h̶ ̶e̶q̶u̶a̶l̶ ̶t̶o̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶"̶;̶

                //  ̶p̶o̶n̶i̶ż̶e̶j̶ ̶t̶r̶o̶c̶h̶e̶ ̶o̶ ̶w̶ł̶a̶ś̶c̶i̶w̶o̶ś̶c̶i̶a̶c̶h̶ ̶s̶t̶r̶o̶n̶k̶e̶-̶d̶a̶s̶h̶a̶r̶r̶a̶y̶ ̶i̶ ̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶e̶s̶t̶,̶ ̶o̶r̶a̶z̶ ̶d̶l̶a̶c̶z̶e̶g̶o̶ ̶u̶s̶t̶a̶w̶i̶e̶n̶i̶e̶ ̶o̶b̶u̶ ̶t̶y̶c̶h̶ ̶w̶a̶r̶t̶o̶ś̶c̶i̶ ̶n̶a̶ ̶w̶a̶r̶t̶o̶ś̶ć̶ ̶r̶ó̶w̶n̶ą̶ ̶o̶b̶w̶o̶d̶o̶w̶i̶ ̶k̶o̶ł̶a̶ ̶-̶ ̶u̶k̶r̶y̶w̶a̶ ̶p̶o̶c̶z̶ą̶t̶k̶o̶w̶o̶ ̶z̶ł̶o̶t̶y̶ ̶o̶k̶r̶ą̶g̶ ̶;̶

                //  ̶"̶S̶e̶t̶t̶i̶n̶g̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶a̶r̶r̶a̶y̶`̶ ̶v̶a̶l̶u̶e̶ ̶t̶o̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶ ̶e̶f̶f̶e̶c̶t̶i̶v̶e̶l̶y̶ ̶h̶i̶d̶e̶s̶ ̶t̶h̶e̶ ̶y̶e̶l̶l̶o̶w̶ ̶c̶i̶r̶c̶l̶e̶ ̶(̶m̶a̶k̶e̶s̶ ̶i̶t̶ ̶i̶n̶v̶i̶s̶i̶b̶l̶e̶)̶ ̶b̶e̶c̶a̶u̶s̶e̶ ̶i̶t̶ ̶c̶r̶e̶a̶t̶e̶s̶ ̶a̶ ̶d̶a̶s̶h̶ ̶p̶a̶t̶t̶e̶r̶n̶ ̶w̶i̶t̶h̶ ̶a̶ ̶d̶a̶s̶h̶ ̶l̶e̶n̶g̶t̶h̶ ̶e̶q̶u̶a̶l̶ ̶t̶o̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶,̶ ̶a̶n̶d̶ ̶n̶o̶ ̶g̶a̶p̶s̶ ̶i̶n̶ ̶b̶e̶t̶w̶e̶e̶n̶.̶
                //
                // Here's why this works:
                //
                //  ̶1̶.̶ ̶W̶h̶e̶n̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶a̶r̶r̶a̶y̶`̶ ̶i̶s̶ ̶s̶e̶t̶ ̶t̶o̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶,̶ ̶e̶a̶c̶h̶ ̶d̶a̶s̶h̶ ̶i̶n̶ ̶t̶h̶e̶ ̶d̶a̶s̶h̶ ̶p̶a̶t̶t̶e̶r̶n̶ ̶h̶a̶s̶ ̶t̶h̶e̶ ̶s̶a̶m̶e̶ ̶l̶e̶n̶g̶t̶h̶ ̶a̶s̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶.̶ ̶S̶i̶n̶c̶e̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶i̶s̶ ̶t̶h̶e̶ ̶t̶o̶t̶a̶l̶ ̶l̶e̶n̶g̶t̶h̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶'̶s̶ ̶p̶e̶r̶i̶m̶e̶t̶e̶r̶,̶ ̶s̶e̶t̶t̶i̶n̶g̶ ̶t̶h̶e̶ ̶d̶a̶s̶h̶ ̶l̶e̶n̶g̶t̶h̶ ̶t̶o̶ ̶t̶h̶i̶s̶ ̶v̶a̶l̶u̶e̶ ̶m̶e̶a̶n̶s̶ ̶t̶h̶a̶t̶ ̶e̶a̶c̶h̶ ̶d̶a̶s̶h̶ ̶w̶i̶l̶l̶ ̶c̶o̶v̶e̶r̶ ̶t̶h̶e̶ ̶e̶n̶t̶i̶r̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶.̶
                //
                //  ̶2̶.̶ ̶B̶y̶ ̶n̶o̶t̶ ̶s̶p̶e̶c̶i̶f̶y̶i̶n̶g̶ ̶a̶n̶y̶ ̶g̶a̶p̶s̶ ̶b̶e̶t̶w̶e̶e̶n̶ ̶t̶h̶e̶ ̶d̶a̶s̶h̶e̶s̶ ̶(̶i̶.̶e̶.̶,̶ ̶n̶o̶t̶ ̶p̶r̶o̶v̶i̶d̶i̶n̶g̶ ̶a̶ ̶s̶e̶c̶o̶n̶d̶ ̶v̶a̶l̶u̶e̶ ̶i̶n̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶a̶r̶r̶a̶y̶`̶ ̶p̶r̶o̶p̶e̶r̶t̶y̶)̶,̶ ̶t̶h̶e̶ ̶d̶a̶s̶h̶e̶s̶ ̶w̶i̶l̶l̶ ̶b̶e̶ ̶p̶l̶a̶c̶e̶d̶ ̶e̶n̶d̶-̶t̶o̶-̶e̶n̶d̶ ̶w̶i̶t̶h̶o̶u̶t̶ ̶a̶n̶y̶ ̶g̶a̶p̶s̶.̶ ̶T̶h̶i̶s̶ ̶e̶f̶f̶e̶c̶t̶i̶v̶e̶l̶y̶ ̶f̶i̶l̶l̶s̶ ̶t̶h̶e̶ ̶e̶n̶t̶i̶r̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶ ̶w̶i̶t̶h̶ ̶d̶a̶s̶h̶e̶s̶.̶
                //
                //  ̶3̶.̶ ̶S̶i̶n̶c̶e̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶`̶ ̶i̶s̶ ̶i̶n̶i̶t̶i̶a̶l̶l̶y̶ ̶s̶e̶t̶ ̶t̶o̶ ̶t̶h̶e̶ ̶s̶a̶m̶e̶ ̶v̶a̶l̶u̶e̶ ̶a̶s̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶a̶r̶r̶a̶y̶`̶ ̶(̶i̶n̶ ̶t̶h̶i̶s̶ ̶c̶a̶s̶e̶,̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶)̶,̶ ̶t̶h̶e̶ ̶e̶n̶t̶i̶r̶e̶ ̶y̶e̶l̶l̶o̶w̶ ̶c̶i̶r̶c̶l̶e̶ ̶i̶s̶ ̶i̶n̶i̶t̶i̶a̶l̶l̶y̶ ̶h̶i̶d̶d̶e̶n̶ ̶b̶y̶ ̶t̶h̶e̶ ̶d̶a̶s̶h̶ ̶p̶a̶t̶t̶e̶r̶n̶.̶ ̶T̶h̶e̶ ̶d̶a̶s̶h̶e̶s̶ ̶c̶o̶v̶e̶r̶ ̶t̶h̶e̶ ̶e̶n̶t̶i̶r̶e̶ ̶p̶e̶r̶i̶m̶e̶t̶e̶r̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶,̶ ̶m̶a̶k̶i̶n̶g̶ ̶i̶t̶ ̶a̶p̶p̶e̶a̶r̶ ̶a̶s̶ ̶i̶f̶ ̶i̶t̶'̶s̶ ̶n̶o̶t̶ ̶f̶i̶l̶l̶e̶d̶.̶
                //
                //  ̶T̶o̶ ̶m̶a̶k̶e̶ ̶t̶h̶e̶ ̶y̶e̶l̶l̶o̶w̶ ̶c̶i̶r̶c̶l̶e̶ ̶v̶i̶s̶i̶b̶l̶e̶ ̶a̶n̶d̶ ̶s̶h̶o̶w̶ ̶t̶h̶e̶ ̶f̶i̶l̶l̶i̶n̶g̶ ̶e̶f̶f̶e̶c̶t̶,̶ ̶y̶o̶u̶ ̶u̶p̶d̶a̶t̶e̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶`̶ ̶v̶a̶l̶u̶e̶ ̶t̶o̶ ̶a̶ ̶s̶m̶a̶l̶l̶e̶r̶ ̶v̶a̶l̶u̶e̶ ̶b̶a̶s̶e̶d̶ ̶o̶n̶ ̶t̶h̶e̶ ̶d̶e̶s̶i̶r̶e̶d̶ ̶f̶i̶l̶l̶ ̶a̶m̶o̶u̶n̶t̶.̶ ̶A̶s̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶`̶ ̶d̶e̶c̶r̶e̶a̶s̶e̶s̶,̶ ̶t̶h̶e̶ ̶d̶a̶s̶h̶ ̶p̶a̶t̶t̶e̶r̶n̶ ̶s̶h̶i̶f̶t̶s̶ ̶a̶l̶o̶n̶g̶ ̶t̶h̶e̶ ̶p̶a̶t̶h̶,̶ ̶r̶e̶v̶e̶a̶l̶i̶n̶g̶ ̶t̶h̶e̶ ̶y̶e̶l̶l̶o̶w̶ ̶p̶o̶r̶t̶i̶o̶n̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶.̶ ̶B̶y̶ ̶a̶d̶j̶u̶s̶t̶i̶n̶g̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶`̶ ̶f̶r̶o̶m̶ ̶t̶h̶e̶ ̶i̶n̶i̶t̶i̶a̶l̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶t̶o̶ ̶a̶ ̶s̶m̶a̶l̶l̶e̶r̶ ̶v̶a̶l̶u̶e̶,̶ ̶y̶o̶u̶ ̶c̶o̶n̶t̶r̶o̶l̶ ̶t̶h̶e̶ ̶e̶x̶t̶e̶n̶t̶ ̶o̶f̶ ̶t̶h̶e̶ ̶f̶i̶l̶l̶ ̶a̶n̶d̶ ̶a̶n̶i̶m̶a̶t̶e̶ ̶t̶h̶e̶ ̶f̶i̶l̶l̶i̶n̶g̶ ̶e̶f̶f̶e̶c̶t̶.̶
                //
                //  ̶I̶n̶ ̶s̶u̶m̶m̶a̶r̶y̶,̶ ̶s̶e̶t̶t̶i̶n̶g̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶a̶r̶r̶a̶y̶`̶ ̶t̶o̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶a̶n̶d̶ ̶i̶n̶i̶t̶i̶a̶l̶l̶y̶ ̶s̶e̶t̶t̶i̶n̶g̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶`̶ ̶t̶o̶ ̶t̶h̶e̶ ̶s̶a̶m̶e̶ ̶v̶a̶l̶u̶e̶ ̶e̶f̶f̶e̶c̶t̶i̶v̶e̶l̶y̶ ̶h̶i̶d̶e̶s̶ ̶t̶h̶e̶ ̶y̶e̶l̶l̶o̶w̶ ̶c̶i̶r̶c̶l̶e̶ ̶b̶y̶ ̶c̶o̶v̶e̶r̶i̶n̶g̶ ̶i̶t̶ ̶w̶i̶t̶h̶ ̶d̶a̶s̶h̶e̶s̶.̶ ̶A̶d̶j̶u̶s̶t̶i̶n̶g̶ ̶t̶h̶e̶ ̶`̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶`̶ ̶v̶a̶l̶u̶e̶ ̶s̶u̶b̶s̶e̶q̶u̶e̶n̶t̶l̶y̶ ̶r̶e̶v̶e̶a̶l̶s̶ ̶t̶h̶e̶ ̶y̶e̶l̶l̶o̶w̶ ̶p̶o̶r̶t̶i̶o̶n̶ ̶a̶n̶d̶ ̶c̶r̶e̶a̶t̶e̶s̶ ̶t̶h̶e̶ ̶f̶i̶l̶l̶i̶n̶g̶ ̶e̶f̶f̶e̶c̶t̶.̶

                window.addEventListener("load", function() {

                    // Strona została w pełni załadowana; // Kod do wykonania po pełnym załadowaniu strony (i wszystkich zasobów) ;

                    // SD - problem implementacyjny - ustawienie pozycji diva z szarymi gwiazdkami (w sekcji #book-page-details - przy zdjęciu książki) - rozwiązanie - poczekanie aż wszystkie zasoby strony (w tym CSS) się załadują

                    // przedstaw ten problem jeszcze raz tak jakby nie był rozwiązany - i opisz w PD (problemy implementacyjne) ;

                    const totalRate = 5;

                    const percentageRate = (rating / totalRate) * 100; // (4.5 / 5) * 100 => "90"
                    // "90" <- "number" // Ocena wyrażona w procentach;

                    const percentageRateRounded = `${Math.round(percentageRate / 10) * 10}%`;
                    // "90%"  <- "string"
                        // Zaokrąglona wartość średniej oceny (do najbliższej dziesiątki);

                    const percentageRateBase = `${100 - Math.round(percentageRate / 10) * 10}%`;
                    // "10%" <- "String"
                        // to będzie szerokość diva z Szarymi gwiazdkami;

                        /*console.log("\n525 percentageRate -> ", percentageRate);
                        console.log("\npercentageRateRounded -> ", percentageRateRounded);
                        console.log("\npercentageRateBase -> ", percentageRateBase);*/

                    document.querySelector('.rate-inner').style.width = percentageRateRounded; // width: 70%;
                    // ✓ szerokość diva z Żółtymi gwiazdkami ;
                    document.querySelector('.rate-inner-base').style.width = percentageRateBase; // width: 30%;
                    // ✓ szerokość diva z Szarymi gwiazdkami ;

                    /*const rateOuter = document.querySelector('.rate-outer'); // ✓ pojemnik na divy z żółtymi i Szarymi gwiazdkami ;
                    const rateOuterWidth = rateOuter.offsetWidth;*/ // ✓ szerokość tego pojemnika (CSS -> "width");
                    // "105" <- "number"                            <- szerokosć (px) diva na Żółte i Szare gwiazdki ;

                        /*console.log("\n 193 rateOuterWidth ->", rateOuterWidth);
                        console.log("\n 193 rateOuterWidth ->", typeof rateOuterWidth);*/

                    document.querySelector('.rate-inner-base').style.position = "relative";
                    //document.querySelector('.rate-inner-base').style.left = `${rateOuterWidth *  (Math.round(percentageRate / 10) * 10) / 100}px`; // -> 100 * (0,7) --> 70 (px) ;
                    document.querySelector('.rate-inner-base').style.left = percentageRateRounded;
                    // -> 100 * (0,7) --> 70 (px) ;

                    // ✓✓✓ ROZWIĄZANIE PROBLEMU IMPLEMENTACYJNEGO - zamiana position left z px na wartość % (!) - podczas resizowania nastąpiło błędne kalkulowanie tej pozycji, od teraz przy ZMIANIE ROZMIARU pozycja szarych gwiazdek względem złotych jest OK (!)

                    // tutał był problem (ponieważ po Ctrl+F5 - szerokość rateOuterWidth była źle kalkulowana" - problemy implementacyjne - SD " ;


                    if(rating !== "") {
                        document.querySelector('.rating-num').innerHTML = Math.round(rating*100)/100 ;
                        // zaokrąglenie --> pomnożyć przez 10, zaokrąglić, podzielić przez 10 ;
                    } else {
                        document.querySelector('.rating-num').innerHTML = "" ;
                    }

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    // Proporcjonalne wypełnienie okręgu ;

                        //  ̶T̶o̶ ̶f̶i̶l̶l̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶ ̶p̶r̶o̶p̶o̶r̶t̶i̶o̶n̶a̶l̶l̶y̶ ̶b̶a̶s̶e̶d̶ ̶o̶n̶ ̶t̶h̶e̶ ̶a̶v̶e̶r̶a̶g̶e̶ ̶r̶a̶t̶i̶n̶g̶ ̶u̶s̶i̶n̶g̶ ̶J̶a̶v̶a̶S̶c̶r̶i̶p̶t̶,̶ ̶y̶o̶u̶ ̶c̶a̶n̶ ̶d̶y̶n̶a̶m̶i̶c̶a̶l̶l̶y̶ ̶c̶a̶l̶c̶u̶l̶a̶t̶e̶ ̶t̶h̶e̶ ̶s̶t̶r̶o̶k̶e̶-̶d̶a̶s̶h̶o̶f̶f̶s̶e̶t̶ ̶v̶a̶l̶u̶e̶ ̶b̶a̶s̶e̶d̶ ̶o̶n̶ ̶t̶h̶e̶ ̶r̶a̶t̶i̶n̶g̶.̶ ̶H̶e̶r̶e̶'̶s̶ ̶a̶n̶ ̶e̶x̶a̶m̶p̶l̶e̶ ̶o̶f̶ ̶h̶o̶w̶ ̶y̶o̶u̶ ̶c̶a̶n̶ ̶a̶c̶h̶i̶e̶v̶e̶ ̶t̶h̶i̶s̶:̶
                        //  ̶A̶s̶s̶u̶m̶i̶n̶g̶ ̶y̶o̶u̶ ̶h̶a̶v̶e̶ ̶a̶ ̶v̶a̶r̶i̶a̶b̶l̶e̶ ̶n̶a̶m̶e̶d̶ ̶'̶r̶a̶t̶i̶n̶g̶'̶ ̶t̶h̶a̶t̶ ̶h̶o̶l̶d̶s̶ ̶t̶h̶e̶ ̶a̶v̶e̶r̶a̶g̶e̶ ̶r̶a̶t̶i̶n̶g̶ ̶v̶a̶l̶u̶e̶̶;̶
                        //  ̶I̶n̶ ̶t̶h̶i̶s̶ ̶c̶o̶d̶e̶,̶ ̶w̶e̶ ̶c̶a̶l̶c̶u̶l̶a̶t̶e̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶ ̶u̶s̶i̶n̶g̶ ̶t̶h̶e̶ ̶f̶o̶r̶m̶u̶l̶a̶ ̶2̶ ̶*̶ ̶π̶ ̶*̶ ̶r̶,̶ ̶w̶h̶e̶r̶e̶ ̶r̶ ̶i̶s̶ ̶t̶h̶e̶ ̶r̶a̶d̶i̶u̶s̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶ ̶(̶i̶n̶ ̶y̶o̶u̶r̶ ̶c̶a̶s̶e̶,̶ ̶i̶t̶'̶s̶ ̶1̶0̶)̶.̶ ̶T̶h̶e̶n̶ ̶w̶e̶ ̶c̶a̶l̶c̶u̶l̶a̶t̶e̶ ̶t̶h̶e̶ ̶d̶e̶s̶i̶r̶e̶d̶ ̶o̶f̶f̶s̶e̶t̶ ̶b̶y̶ ̶s̶u̶b̶t̶r̶a̶c̶t̶i̶n̶g̶ ̶t̶h̶e̶ ̶p̶r̶o̶p̶o̶r̶t̶i̶o̶n̶a̶l̶ ̶v̶a̶l̶u̶e̶ ̶f̶r̶o̶m̶ ̶t̶h̶e̶ ̶t̶o̶t̶a̶l̶ ̶c̶i̶r̶c̶u̶m̶f̶e̶r̶e̶n̶c̶e̶.̶ ̶T̶h̶e̶ ̶p̶r̶o̶p̶o̶r̶t̶i̶o̶n̶a̶l̶ ̶v̶a̶l̶u̶e̶ ̶i̶s̶ ̶o̶b̶t̶a̶i̶n̶e̶d̶ ̶b̶y̶ ̶d̶i̶v̶i̶d̶i̶n̶g̶ ̶t̶h̶e̶ ̶r̶a̶t̶i̶n̶g̶ ̶b̶y̶ ̶t̶h̶e̶ ̶m̶a̶x̶i̶m̶u̶m̶ ̶r̶a̶t̶i̶n̶g̶ ̶(̶i̶n̶ ̶t̶h̶i̶s̶ ̶e̶x̶a̶m̶p̶l̶e̶,̶ ̶w̶e̶ ̶a̶s̶s̶u̶m̶e̶ ̶i̶t̶'̶s̶ ̶5̶)̶.̶ ̶F̶i̶n̶a̶l̶l̶y̶,̶ ̶w̶e̶ ̶u̶p̶d̶a̶t̶e̶ ̶t̶h̶e̶ ̶s̶t̶r̶o̶k̶e̶D̶a̶s̶h̶a̶r̶r̶a̶y̶ ̶a̶n̶d̶ ̶s̶t̶r̶o̶k̶e̶D̶a̶s̶h̶o̶f̶f̶s̶e̶t̶ ̶s̶t̶y̶l̶e̶s̶ ̶o̶f̶ ̶t̶h̶e̶ ̶c̶i̶r̶c̶l̶e̶ ̶e̶l̶e̶m̶e̶n̶t̶ ̶t̶o̶ ̶a̶c̶h̶i̶e̶v̶e̶ ̶t̶h̶e̶ ̶d̶e̶s̶i̶r̶e̶d̶ ̶f̶i̶l̶l̶i̶n̶g̶ ̶e̶f̶f̶e̶c̶t̶ ̶;̶
                        //  ̶M̶a̶k̶e̶ ̶s̶u̶r̶e̶ ̶t̶o̶ ̶e̶x̶e̶c̶u̶t̶e̶ ̶t̶h̶i̶s̶ ̶c̶o̶d̶e̶ ̶a̶f̶t̶e̶r̶ ̶t̶h̶e̶ ̶p̶a̶g̶e̶ ̶h̶a̶s̶ ̶l̶o̶a̶d̶e̶d̶,̶ ̶e̶i̶t̶h̶e̶r̶ ̶b̶y̶ ̶p̶l̶a̶c̶i̶n̶g̶ ̶i̶t̶ ̶w̶i̶t̶h̶i̶n̶ ̶a̶ ̶D̶O̶M̶C̶o̶n̶t̶e̶n̶t̶L̶o̶a̶d̶e̶d̶ ̶e̶v̶e̶n̶t̶ ̶l̶i̶s̶t̶e̶n̶e̶r̶ ̶o̶r̶ ̶a̶t̶ ̶t̶h̶e̶ ̶e̶n̶d̶ ̶o̶f̶ ̶t̶h̶e̶ ̶b̶o̶d̶y̶ ̶t̶a̶g̶.̶

                    const circle = document.getElementById("rating-circle"); // żółte kółko ;
                        //console.log("\ncircle --> ", circle);

                    const circumference = parseFloat(circle.getAttribute('r')) * 2 * Math.PI; // obwód koła; // circumference of the circle
                    // "62.83185307179586" <- number;

                        //console.log("\n\n 584 circumference (obwód) koła)->", circumference, "\n\n\n");

                                // const offset = circumference * (1 - (rating / 5));
                                // zmienna określająca stopień wypełnienia koła ;
                                // "31,4159" (dla średniej_oceny 2.5) ;

                        /*const offset = circumference * (1 - (rating / 5)); // Calculate the stroke dash offset ; "Przesunięcie kreski obrysu " ;
                        console.log("\n circumference -> ", circumference);
                        console.log("\n offset -> ", offset);
                        circle.style.strokeDashoffset = `${offset}`;*/

                    circle.style.strokeDasharray = `${rating*(circumference/5)}, ${circumference}`;

                });

                // -----------------------------------------------------------------------------------------------------

                const bookRatingDetails = document.querySelectorAll(".book-rating-details"); // Kolekcja NodeList divów z żółtymi paskami ;

                $ratings = <?= $_SESSION["raings_array"] ?>; // JSON -> obiekt JS -> (tablica z ocenami, key - ocena, value - ilosc ocen);

                // {                                         // { "5" : "2", "4" : "1" }
                //    "5": "1",
                //    "4": "1"
                //    ...  ...
                // }

                $no_ratings =  <?= json_encode($_SESSION["liczba_ocen"]) ?>;      // "4" <- "String" - LICZBA wszystkich OCEN;

                    /*console.log("\n 298 $ratings -> ", $ratings);                     // [5] => 2 [4] => 1 ; --> { "5" : "2", "4" : "1" }
                    console.log("\n 298 $ratings[0] -> ", $ratings[5]);                     // [5] => 2 [4] => 1 ; --> { "5" : "2", "4" : "1" }
                    console.log("\n 298 typeof $ratings -> ", typeof $ratings);       // "Object"

                    console.log("\n 298 $no_ratings -> ", $no_ratings);               // "12" lub np "0" ;    // liczba_ocen
                    console.log("\n 298 typeof $no_ratings -> ", typeof $no_ratings); // String ;

                console.log("\n\n przed pętlą --> \n\n");
                console.log("----------------------------------------------------------------------------------------");*/

                //      bookRatingDetails.length == 5           (tyle ile jest divów - pasków poziomych z ocenami) ;


                window.onload = function() { // <!-- zamienić na event listener !!!!!!

                    for (let i = bookRatingDetails.length, j = 0; i > 0 ; i--, j++) {

                        // ✓ Pętla po Kolekcji NodeList - dla każdego pojemnika na paski - class="book-rating-details" ;

                        //   i  |  j  |
                        //  -----------
                        //   5  |  0  |
                        //   4  |  1  |
                        //   3  |  2  |
                        //   2  |  3  |
                        //   1  |  4  |

                        let line = bookRatingDetails[j].querySelector(".line"); // i-ty element kolekcji -> div o klasie "line" ;
                                                                                // ✓ POJEMNIK NA ŻÓŁTY I SZARY PASEK ;
                        // ✓ <div class="book-rating-details"> --> (wewnątrz każdego diva jest) --> <
                        //      div .line> -->
                        //          .rated   - żółty pasek (div) ;
                        //          .unrated - cały pasek (div) ;

                        /*console.log("\n\n line -> ", line, "\n");*/

                        // Do something with each element ;

                        let rated = line.querySelector(".rated");                      // ✓ żółty pasek ;
                        let norates = bookRatingDetails[j].querySelector(".no-rates"); // ✓ pojemnik na ilość_ocen ;

                        /*console.log("\n\n321 norates -> ", norates); // <div class="no-rates">*/

                        //console.log("rated -> ", rated);   // złoty pasek wypełnienia - długość zgodna z ilością ocen
                        //console.log("norates -> ", norates);
                        //console.log("no_ratings -> ", $no_ratings);   // złoty pasek wypełnienia - długość zgodna z ilością ocen
                        //console.log("rated -> ",  );   // złoty pasek wypełnienia - długość zgodna z ilością ocen

                        //let style = getComputedStyle(rated); // "125px" <- (read only) - szerokość (właściwość CSS) żółteo paska ✓ ;
                        let style = getComputedStyle(line); // "125px" <- (read only) - szerokość (właściwość CSS) żółteo paska ✓ ;
                            /*console.log("\n\n 342 .rated - style.width -> ", style.width);*/ // 125 px;

                        let width = parseInt(style.width)-10, newWidth, numberOfRates; // width - szerokość żółtego paska (125px);
                        // "125" - (px) <- "number" ;

                            /*console.log("\n351 -- width --> ", width); // 125 - type "number "; - szerokość żółteo paska ✓
                            console.log("\n351 width --> ", typeof width);
                            console.log("\n $ratings --> ", $ratings); // "object" - tablica z ocenami i ilością tych ocen dla danej książki;*/

                        //          5
                        if($ratings[i] === undefined) { // ✓ jeśli dana ocena nie wystąpiła ani razu ;
                            //newWidth = 100;     // szerokość paska ;
                            numberOfRates = 0;    // ilość_ocen ;

                            //rated.style.visibility = "hidden"; // ukrycie (i-tego) żółtego paska ;
                            rated.classList.add("hidden-rate");  // visibility: hidden;
                        } else {
                            // ✓ ustaw odpowiednią (proporcjonalną !) szerokość żółtego paska, zależnie od ilości ocen (!) ;

                            // newWidth    - ✓ szerokość żółtego paska ;
                            // $no_ratings - ✓ liczba wszystkich ocen książki ;
                            // $ratings[i] - ✓ ilość wysąpień konkretnej oceny (np "5" - wysąpiło 2 razy)
                            newWidth = ( width / $no_ratings ) * $ratings[i]; // ✓
                            numberOfRates = $ratings[i];

                            rated.style.width = newWidth + "px"; // ustaw szerokość żółtego paska (jeśli nie było ocen - będzie on niewidoczny ) ;
                        }

                        //console.log("newWidth --> ", newWidth);

                        norates.innerHTML = "("+numberOfRates+")"; // ilość ocen (np 2 razy wystąpiła ocena "5");
                    }

                }

                // -----------------------------------------------------------------------------------------------------

                /*console.log("----------------------------------------------------------------------------------------");*/

                // -----------------------------------------------------------------------------------------------------
                //  ̶a̶d̶d̶ ̶n̶e̶w̶ ̶r̶a̶t̶i̶n̶g̶ ̶(̶5̶ ̶s̶t̶a̶r̶s̶,̶ ̶h̶o̶v̶e̶r̶ ̶e̶f̶f̶e̶c̶t̶)̶ ̶-̶ ̶J̶S̶ ̶;̶

                // Gwiazdki - przy dodawaniu nowej opinii - Interakcje przy najechaniu kursorem ;

                const stars = document.querySelectorAll('.star'); // # add-rate -> # add-rate-outer -> .star ;
                // Kolekcja typu NodeList ; // ✓ Kolekcja spanów z gwiazdkami ;

                    /*console.log("\n stars -> ", stars); // Kolekcja NodeList // ✓ Kolekcja spanów z gwiazdkami ;
                    console.log("\n typeof stars -> ", typeof stars); // "object"*/

                // let goldStars = 0;

                let keepStars = false; // == true po kliknięciu ("click") na gwiazdkę

                function updateStars(event) {

                        /*console.log("\n 392 - keepStars -> ", keepStars) ;*/

                    const currentStar = event.currentTarget; // <span> z gwiazdką; // który zostal kliknięty;
                        // <span class="star" id="star-1">
                        //      1 <input type="hidden" value="1">
                        // </span>
                            const currentStarId = currentStar.id; // id klikniętej gwiazdki; // "star-1", "star-4", ... // #star-1, ... #star-5;
                    const starNumber = Number(currentStarId.split('-')[1]); // "1", ... "5" ; <- "number"
                    // id klikniętej gwiazdki ;

                        /*console.log("\n\n 593 currentStar --> ", currentStar);     // przykładowo --> <span class="star" id="star-1">
                        console.log("\n\n 593 currentStarId --> ", currentStarId);
                        console.log("\n\n 593 starNumber --> ", starNumber);       // id klikniętej gwiazdki ;*/

                    let eventType = event.type; // typ wywołanego zdarzenia ; - "click", "mouseenter", "mouseout" ...

                    if (eventType === "mouseenter" && keepStars === false) {

                        // dodanie klasy "gold" do elementu <span> po najechaniu na niego myszą ;

                        for (let i = 0; i < stars.length; i++) {

                            // przejście przez kolekcje spanów z gwiazdkami ;

                            const star = stars[i];
                                //      <span class="star" id="star-1">
                                //           1 <input type="hidden" value="1">
                                //      </span>
                                const starId = star.id; // // "star-1", "star-4", ... // #star-1, ... #star-5
                            const number = Number(starId.split('-')[1]); // "1", "2", ..., "5"
                            // id-tej gwiazdki --> "1" / "2" / ... / "5"

                            /*console.log("number --> ", number);*/

                            if (number <= starNumber) { // ✓ jeśli i-ty element (<span> z gw.) jest mniejszy niz ten klikniety (event) ;
                                // number - id i-tej gwiazki,
                                // starNumber - id kliknietej gwiazdki ;
                                star.classList.add('gold');
                            } /*else {
                                star.classList.remove('gold');
                                //goldStars--;
                            }*/
                        }
                        // keepStars = false; // ?
                    }

                    else if (eventType === "mouseout" && keepStars === false) {

                        for (let i = 0; i < stars.length; i++) {

                            const star = stars[i];
                                //      <span class="star" id="star-1">
                                //           1 <input type="hidden" value="1">
                                //      </span>

                            if(star.classList.contains("gold")) { // i-ty element (<span> z gw.);
                                star.classList.remove('gold');
                            }

                            let input = star.querySelector('input[type="hidden"]');

                            //console.log("\n\n 644 input --> \n\n", input);

                            if (input.hasAttribute('name')) {
                                //alert();
                                input.removeAttribute('name');
                            }
                        }
                    }
                    // <--- ;

                    else if (eventType === "click") {

                        // usuń atrybut "name" z pozostałych inputów - (input type="hidden"), jeśli on się tam znajdował ;
                        removeNameAttribute(stars); // remove name attribute for every input[type="hidden"] element

                        for (let i = 0; i < stars.length; i++) {

                            const star = stars[i];
                                //      <span class="star" id="star-1">
                                //           1 <input type="hidden" value="1">
                                //      </span>
                                const starId = star.id; // star-1, star-2 ... star-5
                            const number = Number(starId.split('-')[1]); // 1, 2, ... 5 <--  // id-tej gwiazdki - "1" / "2" / ... / "5"

                            if (number <= starNumber) {

                                // number - id i-tej gwiazdki (span),
                                // starNumber - id Klikniętej gwiazdki ;

                                star.classList.add('gold');

                                if(number === starNumber) {

                                    // dodanie atrubutu name="{id-gwiazdki}" do gwiazdki, która została kliknięta  ;

                                    // add name attribute for input type hidden -->

                                    let input = star.querySelector('input[type="hidden"]');
                                    //console.log("MY INPUT -----> ", input);

                                    input.setAttribute('name', 'star');
                                }
                                //goldStars++;
                            } else {
                                star.classList.remove('gold');
                                //goldStars--;
                            }
                        }
                        //console.log("725 star --> ", star);
                        //keepStars = ! keepStars;
                        keepStars = true; // SD - rozwiązanie problemu implementacyjnego ;
                    }

                    //console.log("\n 486 keepStars -> ", keepStars);
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*function hasGoldStars(stars) {  // stars - NodeList collection (spany z gwiazdkami)

        // CHECK, IF THERE IS ANY GOLD STAR ;

        // ̶ ̶S̶D̶ ̶-̶ ̶p̶r̶o̶b̶l̶e̶m̶ ̶i̶m̶p̶l̶e̶m̶e̶n̶t̶a̶y̶j̶n̶y̶ ̶-̶ ̶r̶o̶z̶w̶i̶ą̶z̶a̶n̶i̶e̶ ̶;̶

        for (let i = 0; i < stars.length; i++) { // NodeList Collection ;

            if(stars[i].classList.contains("gold")) {
                return true;
            }
        }
        return false;
    } */

                function removeNameAttribute(stars) {
                        // remove "name" attribute In every <input typ hidden> in star <span> collection
                        // ✓ SD - problem implementayjny - rozwiązanie ;
                    for (let i = 0; i < stars.length; i++) { // NodeList Collection ;

                        let input = stars[i].querySelector('input[type="hidden"]'); // i-ty (!) input wewnątrz spana z gwiazdką ;

                        if(input.hasAttribute("name")) {
                            input.removeAttribute("name");
                        }
                    }
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                for (let i = 0; i < stars.length; i++) { // dla każdego elementu <span> z gwiazdką ;

                    const star = stars[i]; // <span ... class="star">
                    // current star element (<span>);

                    //console.log("\n\n\n 733 stars[i] = \n\n\n", stars[i]);

                    // Add event listener for each "star" element ;
                    star.addEventListener('mouseenter', function(event) {
                        // event - element, który wywołał zdarzenie (<span> z gwiazdką)
                        // event --> zdarzenie + element;
                        updateStars(event);
                    });

                    star.addEventListener('mouseout', function(event) {
                        updateStars(event);
                    });

                    star.addEventListener('click', function(event) {
                        updateStars(event);
                    });
                }

                // ---------------------------------------------------------------------------------------------------------

                // Komentarze - Sekcja komentarzy - poniżej ;
                    // ustawianie szerokości gwiazdek przy każdym komentarzu ;

                // (naprawiony) error - pojawia się jeśli nie ma żadnych komentarzy ! - "commentRate" - nie istnieje !

                let commentRates = document.querySelectorAll(".comment-rate"); // \template\book-comment.php;

                commentRates.forEach(function(commentsRate) {
                    let rating = commentsRate.textContent.trim(); // "4"
                    commentsRate.querySelector(".comment-rate-inner").style.width = ((rating / 5) * 100) + "%";
                    commentsRate.querySelector(".comment-rate-inner-base").style.width = (100-((rating / 5) * 100)) + "%";
                    commentsRate.querySelector(".comment-rate-inner-base").style.position = "relative";
                    commentsRate.querySelector(".comment-rate-inner-base").style.left = ((rating / 5) * 100) + "%";
                });

                /*if(commentRate) {
                        console.log("\n\n 1002 commentRate -> ", commentRate);
                    commentRate = commentRate.textContent.trim(); //$row["ocena"] - "1", "2", ..., "4", "5"
                        console.log("\n\n 986 commentRate -> ", commentRate);
                    let commentRateInner = document.querySelector(".comment-rate-inner"); // <div class="comment-rate-inner">
                    commentRateInner.style.width = (commentRate / 5) * 100 + "%"; // ustawienie szerokości pojemnika na gwiazdki - zależnie od ilości gwiazdek ;
                    let commentRates = document.querySelectorAll(".comment-rate") // kolekcja NodeList - pojemników (całych !) na wszystkie gwiazdki *przy komentarzach) ;
                    // console.log("commentRate -> ", commentRates);
                    for (let i = 0; i < commentRates.length; i++) { // dla każdego pojemnika na gwiazdki (przy komentarzach) ;
                        let rate = commentRates[i].textContent.trim(); // "4"
                        commentRates[i].querySelector(".comment-rate-inner").style.width = ((rate / 5) * 100) + "%";
                    }
                    //let commentRateInner = document.querySelector(".comment-rate-inner"); // <div class="comment-rate-inner">
                    //commentRateInner.style.width = (commentRate / 5) * 100 + "%";
                    // book-page-tabs -->
                    /!* el = document.getElementById("tab-2");
                    el.addEventListener("click", setSpanWidthv2);*!/
                } else {
                }*/

                ////////////////////////////////////////////////////////////////////////////////////////////////////////

                // Karty - zapis ostatnio wybranej w localStorage ;

                let ul = document.querySelector('ul.tab-list'); // <ul clsas="tab-list">
                    console.log("\nul -> ", ul);

                let divs = document.querySelectorAll('div.tab-panel');
                    console.log("\ndivs -> ", divs);
                        // <div clsas="tab-panel"> - ✓ pojemniki na karty
                        // Kolekcja NodeList - elementów (kart) które można przełączać
                        //console.log("divs -->", divs) ;

                let liEls = ul.querySelectorAll('li');
                    console.log("\nliEls -> ", liEls);
                // Kolekcja NoideList(3) --> li, li, li.active

                //console.log("<li> elements --> ", liEls);

                //let liIndex; // 0, 1, 2

                let liIndex = getCurrentIndex(); // initialize liIndex with the CURRENT ACTIVE TAB INDEX; // 0, 1, 2

                // Add click event listener to each <li> element ;

                // (po kliknięciu) - ZAPISZ INDEKS AKTYWNEJ KARTY (OSTATNIO KLIKNIĘTEJ) W LS -
                liEls.forEach( (liEl, index) => {

                    liEl.addEventListener('click', function() { // dla każdego elementu listy - <li> ; - PO KLIKNIĘCIU ;

                                // Check if the class attribute has changed

                                // jeśli kliknięty <li> element nie ma klasy "active", trzeba mu ją nadać (bo został kliknięty, i powinien ją mieć) - ale tutaj - ZAPISUJE TYLKO indeks TEJ KARTY w Local Storage ! ;

                        if ( ! this.classList.contains('active') ) { // <li>
                            //console.log('Class attribute has changed');
                            // Do something here
                            liIndex = index; // ✓✓✓ zmienna liIndex - przechowuje Index KLIKNIĘTEJ KARTY !

                            //console.log('Current li index:', liIndex);

                            if(window.sessionStorage) {
                                sessionStorage.setItem("liIndex", liIndex); // ✓ zapisz indeks klikniętej karty w LS
                            }
                        }
                    });
                });



                function getCurrentIndex() {
                    // return index of currently selected tab ;
                    for (let i = 0; i < liEls.length; i++) {
                        if (liEls[i].classList.contains('active')) {
                            console.log("\n\n liEls class List contains index --> ", i);
                            return i;
                        }
                    }
                    //return 0;
                }

                if(window.sessionStorage) {

                    // Check if the value for key "liIndex" exists in local storage
                    if (sessionStorage.getItem("liIndex") !== null) {
                        // Value exists
                        console.log("Value exists for key 'liIndex'");

                        // change active <li> tab based on localStorage value ;
                        // remove class "active" from all <li> elements, and <div>'s with class "tab-panel" (tzn. wyświetlane poniżej karty z zawartością) ;
                        // "usunięcie klasy active wszędzie gdzie tylko się da" ;
                        for (let i = 0; i < liEls.length; i++) {
                            if (liEls[i].classList.contains('active')) {
                                liEls[i].classList.remove('active');
                            }
                            if (divs[i].classList.contains('active')) {
                                // ponieważ on też zmienia klasę "active";
                                divs[i].classList.remove('active');
                            }
                        }

                        // pobierz indeks aktywnej karty (tej która jako ostatnia została kliknięta);
                        liIndex = sessionStorage.getItem("liIndex"); // "0", "1", "2"

                        liEls[liIndex].classList.add('active'); // dodanie klasy "active" do elementu listy zgodnie z tym jaki był zapisany w LS (ostatnio kliknięty)
                        divs[liIndex].classList.add('active'); // to samo dla karty z zawartością - <div class="tab-panel" ... > ;

                    } else {
                        // Value does not exist
                        console.log("Value does not exist for key 'liIndex'");
                    }
                }

                // ---------------------------------------------------------------------------------------------------------

                content = document.getElementById("content"); // ustawienie wid div#content na 100%
                //console.log("content -> ", content);
                content.style.width = "100%";

            </script>

        </div> <!-- #container -->

        <?php require "../view/___footer.php"; ?>

    </div> <!-- #main-container -->

<script>
    content = document.getElementById("content"); // ustawienie wid div#content na 100%
    //console.log("content -> ", content);
    content.style.width = "100%";

    // get the window width -->

    //let width = window.innerWidth;

    /*imgContainer = document.getElementById("book-page-image");
    imgContainer.style.marginRight = width;*/

    /*console.log(width);
    console.log(typeof(width));*/

    /*window.addEventListener('resize', function() {

        if(window.innerWidth <= "845" && window.innerWidth >= "825") {

            let imgContainer = document.getElementById("book-page-image");
            let marginRightValue = ((Math.pow(window.innerWidth-824, 2))/85)

            if(marginRightValue < 0) {
                marginRightValue = 0;
            }
            imgContainer.style.marginRight = marginRightValue.toString() + "%";

        } else if(window.innerWidth > "845") {
            let imgContainer = document.getElementById("book-page-image");
            imgContainer.style.marginRight = "42px";

            let content = document.getElementById("content");
            content.style.paddingLeft = "15px";
        }
        if(window.innerWidth < "845" && window.innerWidth > "800") {

            let content = document.getElementById("content");
            let paddingLeftValue = ((Math.pow(window.innerWidth-800, 2))/1000)

            if(paddingLeftValue < 0) {
                paddingLeftValue = 0;
            }
            content.style.paddingLeft = paddingLeftValue.toString() + "%";
        }
    });

window.addEventListener('load', function() {

    if(window.innerWidth <= "845" && window.innerWidth >= "820") {

        let imgContainer = document.getElementById("book-page-image");
        let marginRightValue = ((Math.pow(window.innerWidth-824, 2))/85)

        if(marginRightValue < 0) {
            marginRightValue = 0;
        }
        imgContainer.style.marginRight = marginRightValue.toString() + "%";

    } else if(window.innerWidth > "845") {
        let imgContainer = document.getElementById("book-page-image");
        imgContainer.style.marginRight = "42px";

        let content = document.getElementById("content");
        content.style.paddingLeft = "15px";
    }
    if(window.innerWidth < "845" && window.innerWidth > "800") {

        let content = document.getElementById("content");
        let paddingLeftValue = ((Math.pow(window.innerWidth-800, 2))/1000)

        if(paddingLeftValue < 0) {
            paddingLeftValue = 0;
        }
        content.style.paddingLeft = paddingLeftValue.toString() + "%";
    }
    if(window.innerWidth <= "820") {

        let imgContainer = document.getElementById("book-page-image");
        imgContainer.style.marginRight = "0";

        let content = document.getElementById("content");
        content.style.paddingLeft = "0";
    }
});*/

</script>

<!--<script src="../scripts/...js"></script>-->

    <?php require "../view/app-error-window.php"; ?>

</body>
</html>

<?php /*endif*/ ?>