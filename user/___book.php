<?php

    session_start();
    include_once "../functions.php";

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/___header-container.php"; ?>

        <div id="container">

            <main>

                <!-- <aside> <div id="nav"></div> </aside> -->

                <div id="content">

                    <?php

                        /*echo "<br>"; echo "POST ->"; print_r($_POST); echo "<hr><br>";
                        echo "GET ->"; print_r($_GET); echo "<hr><br>";
                        echo "SESSION ->"; print_r($_SESSION); echo "<hr>";*/

                        echo '<a href="___index2.php?kategoria=' . $_SESSION['kategoria'] . '">&larr; Wróć </a>'; // tymczasowe ;

                        /*echo 'Informatyka \ '*/

                        // PD -> zakomentowane - problemy implementacyjne

                        //query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.image_url, ks.rating,
                        //km.id_klienta, km.tresc,
                        //rt.ocena, rt.id_klienta,
                        //au.imie, au.nazwisko,
                        //ks.id_wydawcy, wd.nazwa_wydawcy,
                        //mg.ilosc_dostepnych_egzemplarzy
                        //FROM ksiazki AS ks, autor AS au, komentarze AS km, ratings AS rt, magazyn_ksiazki AS mg, wydawcy AS wd
                        //WHERE ks.id_autora = au.id_autora AND  ks.id_ksiazki = km.id_ksiazki AND ks.id_ksiazki = rt.id_ksiazki AND ks.id_wydawcy wd.id_wydawcy AND ks.id_ksiazki = mg.id_ksiazki AND ks.id_ksiazki = '%s'", "get_book", $_GET["book"]);

                    $book = filter_var(filter_input(INPUT_GET, 'book', FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT);

                    // validate book's id
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

                        // "The issue with your query is that you are using LEFT JOIN to join the ksiazki table with the komentarze and ratings tables. This means that for each row in the ksiazki table, all matching rows in the komentarze and ratings tables are returned. If there are multiple comments or ratings for a single book, each row for that book in the ksiazki table will be duplicated for each comment or rating. To fix this, you can use subqueries to count the number of comments and ratings for each book instead of joining the tables. Here's an example query that should give you the correct results"

                        // Solution below - This query uses subqueries to count the number of comments and ratings for each book by filtering the komentarze and ratings tables based on the book's id_ksiazki. This ensures that each book is only counted once, regardless of the number of comments or ratings it has.
                        // This query uses subqueries to count the number of comments and ratings for each book by filtering the komentarze and ratings tables based on the book's id_ksiazki. This ensures that each book is only counted once, regardless of the number of comments or ratings it has.

                        /*if (isset($_SESSION["rate-error"])) {
                            $book[] = $_SESSION["rate-error"];
                            unset($_SESSION["rate-error"]);
                        } else if (isset($_SESSION["rate-success"])) {
                            $book[] = $_SESSION["rate-success"];
                            unset($_SESSION["rate-success"]);
                        }*/

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

                        /*query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,
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

                    query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.id_autora, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,   
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
                                WHERE ks.id_ksiazki = '%s'", "get_book", $book);  // It is used to retrieve detailed information about a specific book (based on $_GET["book-id"])

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
                    query("SELECT ocena, COUNT(ocena) AS liczba_ocen FROM ratings
                                    WHERE id_ksiazki = '%s'
                                    GROUP BY ocena
                                    ORDER BY ocena DESC
                                    ", "get_ratings", $book); // ✓ potrzebne w widoku w sekcji "Recenzje" ;
                                         // $_SESSION['ratings'] -> key => ocena, value => ilosc_ocen;
                                         // $_SESSION["ratings"] -> [5] => 2 [4] => 1 ;

                    $_SESSION["raings_array"] = json_encode($_SESSION["ratings"]);
                        // funstions -> get_ratings() -> to pass that array (PHP) to JS

                    //       { "5" : "2", "4" : "1" }           <-- type "string" - zwraca JSON'a !
                    // The json_encode() function is used to encode a PHP value into a JSON string;

                    ?>

                </div> <!-- #content -->

            </main>

            <script>


                window.onload = function() {   // SD - (!) problem implementacyjny - ustawienie pozycji diva z szarymi gwiazdkami - rozwiązanie - poczekanie aż wszystkie zasoby strony (w tym CSS) się załadują) - Patrz chat gpt !

                    // dobra chuja nie ma tego w chat gpt - weź przedstaw mu ten problem jeszcze raz tak jakby nie był rozwiązany - i opisz w PD (problemy implementacyjne) ;

                    //const rating = 4.25;
                    const rating = document.getElementById("book-rate").textContent; // "4.5" - type "string";
                    const totalRate = 5;
                                            // 4.5 / 5 * 100 => "90" - (!) Ocena wyrażona w procentach ;
                    const percentageRate = (rating / totalRate) * 100; // "number" -> "93.33399999999999"
                    const percentageRateRounded = `${Math.round(percentageRate / 10) * 10}%`;
                    // "String" -> "90%"    // Zaokrąglona wartość oceny książki
                    const percentageRateBase = `${100 - Math.round(percentageRate / 10) * 10}%`;
                    // "String" -> "10%" // to będzie szerokość diva z Szarymi gwiazdkami ;

                        console.log("\npercentageRate -> ", percentageRate);
                        console.log("\npercentageRateRounded -> ", percentageRateRounded);
                        console.log("\npercentageRateBase -> ", percentageRateBase);

                    // const percentageRateRounded = `${(percentageRate / 10) * 10}%`;
                    document.querySelector('.rate-inner').style.width = percentageRateRounded;
                        // ✓ szerokość diva z Żółtymi gwiazdkami ;
                    document.querySelector('.rate-inner-base').style.width = percentageRateBase;
                        // ✓ szerokość diva z Szarymi gwiazdkami ;

                    const rateOuter = document.querySelector('.rate-outer');
                        // ✓ pojemnik na divy z żółtymi i Szarymi gwiazdkami ;
                    const rateOuterWidth = rateOuter.offsetWidth;
                        // ✓ szerokość tego pojemnika (CSS -> "width");
                        // "105" - type "number" - szerokosć (px) diva na Żółte i Szare gwiazdki ;
                            console.log("\n 193 rateOuterWidth ->", rateOuterWidth);
                            console.log("\n 193 rateOuterWidth ->", typeof rateOuterWidth);

                    document.querySelector('.rate-inner-base').style.position = "relative";
                    document.querySelector('.rate-inner-base').style.left = `${rateOuterWidth *  (Math.round(percentageRate / 10) * 10) / 100}px`; // -> 100 * (0,7) --> 70 (px) ;
                    // tutał był problem (ponieważ po Ctrl+F5 - szerokość rateOuterWidth była źle kalkulowana" - problemy implementacyjne - SD " ;

                    document.querySelector('.rating-num').innerHTML = rating ; // zaokrąglenie --> pomnożyć przez 10, zaokrąglić, podzielić przez 10 ;

                }

                    // ---------------------------------------------------------------------------------------------------------
                    // circle average rating -->

                    // rating ;

                   /* const ratingCircle = document.getElementById("book-rate").textContent; // "4.5" - type "string";
                    const totalRateCircle = 5; // total rating possible
                    const percentageRateCircle = (ratingCircle / totalRateCircle) * 100; // "80"
                    // calculate percentage of rating --> "70" ;
                    const percentageRateRoundedCircle = `${Math.round(percentageRateCircle)}%`; // "80%"
                    // round the percentage rating --> "70%" ;
                    const percentageRateBaseCircle = `${100 - Math.round(percentageRateCircle)}%`; // "20%";
                    // --> "30%";
                    document.querySelector('.rating-circle').style.background = `conic-gradient(gold ${percentageRateRoundedCircle}, gray ${percentageRateBaseCircle})`;*/

                        //document.querySelector('.rating-num-circle').innerHTML = ratingCircle.toFixed(2); // display the rating with 2 decimal places

                    // ---------------------------------------------------------------------------------------------------------
                    // circle average rating ;

                    //const ratingCircle = document.getElementById("rating-circle");
                            // type = "Object"
                            // - <circle id="rating-circle" ... >
                            // - circle SVG element to Draw Circle ;

                                //console.log("\n 260 ratingCircle -> ", ratingCircle);
                                //console.log("\n 260 typeof ratingCircle -> ", typeof ratingCircle); // Object

                    //ratingCircle.classList.add("filled");

                    for(let i = 5, j = 0; i > 0; i--, j++) {
                        console.log("\n i = ", i, "; j = ", j , "\n");
                    }

                    /*for(let j = 0; j < 5; j++) {
                        console.log("\n j = ", j, "\n");
                    }*/


                    // ---------------------------------------------------------------------------------------------------------
                    // ---------------------------------------------------------------------------------------------------------

                    const bookRatingDetails = document.querySelectorAll(".book-rating-details"); // Kolekcja divów z żółtymi paskami ;

                    // ratings from DB - JS -->
                    // kolekcja divów -> <div class="book-rating-details" ...>
                    // "Object" - 5  4  3  2  1

                    console.log("\n 288 bookRatingDetails -> ", bookRatingDetails); // Kolekcja typu NodeList ;
                    console.log("\n 288 bookRatingDetails.length -> ", bookRatingDetails.length); // 5 elementów (tyle ile jest pasków z ocenami) ;
                    console.log("\n 288 typeof bookRatingDetails -> ", typeof bookRatingDetails);

                    $ratings = <?= $_SESSION["raings_array"] ?>;                 // tablica z ocenami (key - ocena,     value - ilosc ocen);

                                                                                 // [5] => 2 [4] => 1 ;     "Object" (!!!)  ;

                    $no_ratings =  <?= json_encode($_SESSION["liczba_ocen"]) ?>; // liczba wszystkich ocen --> "4" - "String" ;

                    console.log("\n 298 $ratings -> ", $ratings);               // [5] => 2 [4] => 1 ;
                    console.log("\n 298 typeof $ratings -> ", typeof $ratings); // "Object"

                        console.log("\n 298 $no_ratings -> ", $no_ratings);     // "4" ;
                        console.log("\n 298 btypeof $no_ratings -> ", typeof $no_ratings); // String ;

                    //$ratings = array_reverse($ratings, true);

                    //      bookRatingDetails.length == 5           (tyle ile jest divów - pasków poziomych z ocenami) ;
                    for (let i = bookRatingDetails.length, j = 0; i > 0 ; i--, j++) {  // ✓ Pętla po Kolekcji NodeList ;

                        //   i   j  |
                        //  ---------
                        //   5   0  |
                        //   4   1  |
                        //   3   2  |
                        //   2   3  |
                        //   1   4  |


                        let line = bookRatingDetails[j].querySelector(".line"); // i-ty element kolekcji -> div o klasie "line"
                        // POJEMNIK NA ŻÓŁTY I SZARY PASEK ;
                        // <div class="book-rating-details"> --> (wewnątrz każdego diva jest) --> .line -->
                                                                                                         // .rated   - żółty pasek ;
                                                                                                         // .unrated - cały pasek ;

                        // console.log("i -> ", i);
                        // console.log("line -> ", line);

                        // Do something with each element ;

                        let rated = line.querySelector(".rated");                      // ✓ żółty pasek ;
                        let norates = bookRatingDetails[j].querySelector(".no-rates"); // ✓ pojemnik na ilość_ocen ;

                        console.log("\n321 norates -> ", norates);

                        //console.log("rated -> ", rated);   // złoty pasek wypełnienia - długość zgodna z ilością ocen
                        //console.log("norates -> ", norates);
                        //console.log("no_ratings -> ", $no_ratings);   // złoty pasek wypełnienia - długość zgodna z ilością ocen
                        //console.log("rated -> ",  );   // złoty pasek wypełnienia - długość zgodna z ilością ocen

                        let style = getComputedStyle(rated); // (read only) pobierz szerokość (właściwość CSS) żółteo paska ✓ ;
                        // POBIERZ szerokość żółtego paska (read-only) ;

                        console.log("\n\n 342 style -> ", style.width); // 125 px;

                        let width = parseInt(style.width), newWidth, numer_of_rates;
                        // "125" - (px) - "number" ;

                        // width - szerokość żółtego paska (125px);

                        console.log("\n351 -- width --> ", width); // 125 - type "number ";      - szerokość żółteo paska ✓
                        console.log("\n351 width --> ", typeof width);
                            console.log("$ratings --> ", $ratings); // "object" - tablica z ocenami i ilością tych ocen dla danej książki;

                        //          5
                        if($ratings[i] === undefined) { // ✓ jeśli dana ocena nie wystąpiła ani razu ;
                            newWidth = 100;     // szerokość paska ;
                            numer_of_rates = 0; // ilość_ocen ;
                            rated.style.visibility = "hidden"; // ukrycie żółtego paska ;
                        } else {
                            // ustaw odpowiednią szerokość żółtego paska, zależnie od ilości ocen ;

                            // newWidth    - ✓ szerokość żółtego paska ;
                            // $no_ratings - ✓ liczba wszystkich ocen książki ;
                            // $ratings[i] - ✓ilość wysąpień konkretnej oceny (np "5" - wysąpiło 2 razy)
                            newWidth = ( width / $no_ratings ) * $ratings[i]; // ✓
                            numer_of_rates = $ratings[i];
                        }

                        //console.log("newWidth --> ", newWidth);

                        rated.style.width = newWidth + "px"; // ustaw szerokość żółtego paska (jeśli nie było ocen - będzie on niewidoczny ) ;
                        norates.innerHTML = "("+numer_of_rates+")"; // ilość ocen (np 2 razy wystąpiła ocena "5");
                    }


                    // ---------------------------------------------------------------------------------------------------------
                    //  ̶a̶d̶d̶ ̶n̶e̶w̶ ̶r̶a̶t̶i̶n̶g̶ ̶(̶5̶ ̶s̶t̶a̶r̶s̶,̶ ̶h̶o̶v̶e̶r̶ ̶e̶f̶f̶e̶c̶t̶)̶ ̶-̶ ̶J̶S̶ ̶;̶

                    // Gwiazdki - przy dodawaniu nowej opinii - Interakcje przy najechaniu kursorem ;

                    const stars = document.querySelectorAll('.star'); // # add-rate -> # add-rate-outer -> .star ;
                    // Kolekcja typu NodeList ;

                    console.log("\n stars -> ", stars); // Kolekcja NodeList
                    console.log("\n typeof stars -> ", typeof stars); // "object"

                    //let goldStars = 0;

                    let keepStars; // ?

function updateStars(event, clear, keep) {

    const currentStar = event.currentTarget; // <span> z gwiazdką ;
                                             // ten, który zostal kliknięty (!);
        // e.target - element, który wywołał zdarzenie (element docelowy dla zdarzenia);
    const currentStarId = currentStar.id; // #star-1, ... #star-5
    const starNumber = Number(currentStarId.split('-')[1]); // 1, ... 5 ;
        //console.log("currentStar --> ", currentStar);
        //console.log("currentStarId --> ", currentStarId);
        //console.log("starNumber --> ", starNumber);

    let eventType = event.type; // typ wywołanego zdarzenia ; - "click", "mouseenter", ...

    if(eventType === "mouseenter") {
        for (let i = 0; i < stars.length; i++) { // przejście przez kolekcje spanów z gwiazdkami ;
            const star = stars[i]; // <span>
            const starId = star.id; // "1"
            const number = Number(starId.split('-')[1]); // 1, 2, ..

            //console.log("number --> ", number);

            // ✓ jeśli i-ty element (span z gw.) jest mniejszy niz ten klikniety (event) ;
            if (number <= starNumber) {
                // number - id i-tej gwiazki,
                // starNumber - id kliknietej gwiazdki ;
                star.classList.add('gold');
                //goldStars++;
            } else {
                star.classList.remove('gold');
                //goldStars--;
            }
        }
        keepStars = false; // ?

    }

    // to poniżej - zmienić lub usunac --->
    else if (eventType === "mouseout") { // (!)
        if(!keepStars) {
            for (let i = 0; i < stars.length; i++) {
                const star = stars[i];
                star.classList.remove('gold');

                let input = star.querySelector('input[type="hidden"]');

                if (input.hasAttribute('name')) { // gdzie ten atrybut jest ustawiany ??
                    input.removeAttribute('name');
                }
            }
        }
    }
    // <--- ;

    else {
        // click
        for (let i = 0; i < stars.length; i++) {
            const star = stars[i]; // <span class="star ... >
                const starId = star.id; // star-1, star-2 ... star-5
            const number = Number(starId.split('-')[1]); // 1, 2, ... 5

            //console.log("713 star --> ", star);
            //console.log("starId --> ", starId);
            //console.log("number --> ", number);
            //console.log("stars length; --> ", stars.length);
            //console.log("i --> ", i);

            if (number <= starNumber) {
                star.classList.add('gold');

                if(number === starNumber) {
                    //console.log("to była ostatnia gwiazdka");

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
        keepStars = !keepStars;
    }
}

                    for (let i = 0; i < stars.length; i++) {

                        const star = stars[i]; // <span ... class="star">
                        // current star element (span);

                        // Add event listener for each "star" element ;
                        star.addEventListener('mouseenter', function (event) {
                            // event - element, który wywołał zdarzenie (span z gwiazdką)
                            updateStars(event, true, true);
                        });
                        /*star.addEventListener('mouseout', function (event) { // zakomentowanie tych linii -> ROZWIĄZANIE problemu implementacyjnego
                            updateStars(event, false, false);
                        });*/
                        star.addEventListener('click', function (event) {
                            updateStars(event, true, true);
                        });
                    }

                    // ---------------------------------------------------------------------------------------------------------

                    // Komentarze poniżej ;
                        // ustawianie szerokości gwiazdek przy każdym komentarzu ;

                    // set the "name" attribute for input type hidden, that was selected

                    let commentRate = document.querySelector(".comment-rate").textContent.trim(); // 1, 2, ..., 5
                        //console.log("commentRate -> ", commentRate);
                    let commentRateInner = document.querySelector(".comment-rate-inner");
                        // <div class="comment-rate-inner">
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

                    /* el = document.getElementById("tab-2");

                    el.addEventListener("click", setSpanWidthv2);*/

                    ////////////////////////////////////////////////////////////////////////////////////////////////////

                    // Karty - zapis ostatnio wybranej w localStorage ;

                    let ul = document.querySelector('ul.tab-list');
                    // <ul clsas="tab-list">
                    let divs = document.querySelectorAll('div.tab-panel');
                        // <div clsas="tab-panel"> - ✓ pojemniki na karty
                    // Kolekcja NodeList - elementów (kart) które można przełączać
                        //console.log("divs -->", divs) ;

                    let liEls = ul.querySelectorAll('li');
                        // Kolekcja NoideList(3) --> li, li, li.active

                    //console.log("<li> elements --> ", liEls);

                    //let liIndex; // 0, 1, 2

                    let liIndex = getCurrentIndex(); // initialize liIndex with the CURRENT ACTIVE TAB INDEX; // 0, 1, 2

                    // Add click event listener to each <li> element ;

                    // ZAPISZ INDEKS AKTYWNEJ KARTY (OSTATNIO KLIKNIĘTEJ) W LS -
                    liEls.forEach( (liEl, index) => {
                        liEl.addEventListener('click', function(event) {
                            // dla każdego elementu listy - <li> ; - PO KLIKNIĘCIU ;

                            // Check if the class attribute has changed

                            // jeśli kliknięty <li> element nie ma klasy "active", trzeba mu ją nadać (bo został kliknięty, i powinien ją mieć) - ale tutaj - ZAPISUJE TYLKO indeks TEJ KARTY w Local Storage ! ;

                            if ( ! this.classList.contains('active') ) { // <li>
                                //console.log('Class attribute has changed');
                                // Do something here
                                liIndex = index; // ✓✓✓ zmienna liIndex - przechowuje Index KLIKNIĘTEJ KARTY !

                                //console.log('Current li index:', liIndex);

                                if(window.localStorage) {
                                    localStorage.setItem("liIndex", liIndex); // ✓ zapisz indeks klikniętej karty w LS
                                }
                            }
                            // getCurrentIndex(); // pobierz indeks aktualnie aktywnej karty
                        });
                    });

                    function getCurrentIndex() {
                        // return index of currently selected tab ;
                        for (let i = 0; i < liEls.length; i++) {
                            if (liEls[i].classList.contains('active')) {
                                return i;
                            }
                        }
                    }

                    if(window.localStorage) {

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
                        liIndex = localStorage.getItem("liIndex"); // "0", "1", "2"


                        liEls[liIndex].classList.add('active'); // dodanie klasy "active" do elementu listy zgodnie z tym jaki był zapisany w LS (ostatnio kliknięty)
                        divs[liIndex].classList.add('active'); // to samo dla karty z zawartością - <div class="tab-panel" ... > ;
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

</body>
</html>