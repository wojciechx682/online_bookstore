<?php
/*session_start();
include_once "../functions.php";*/

require_once "../start-session.php";

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

    <?php require "../view/header-container.php"; ?>

    <div id="container">

        <main>

            <aside>
                <div id="nav"></div>
            </aside>

            <div id="content">

                <hr>

                <?php
                    // echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">&larr; Wróć </a>';
                    //$id = filter_var($_SESSION['id'], FILTER_SANITIZE_STRING);
                    //query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id); // książki które zamówił klient o danym ID;
                    //query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id);
                ?>

                <?php
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

                // zmiana kwerendy po dodaniu subkategorii ->

                query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.id_autora, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,   
                            kt.nazwa, sb.id_kategorii,                                
                                (SELECT COUNT(*) FROM comments WHERE id_ksiazki = ks.id_ksiazki AND tresc IS NOT NULL) AS liczba_komentarzy,
                                (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki AND ocena IS NOT NULL) AS liczba_ocen,
                                (SELECT SUM(ilosc_dostepnych_egzemplarzy) FROM warehouse_books WHERE id_ksiazki = ks.id_ksiazki AND ilosc_dostepnych_egzemplarzy IS NOT NULL) AS liczba_egzemplarzy,
                                au.imie, au.nazwisko, au.id_autora,
                                ks.id_wydawcy, wd.nazwa_wydawcy
                            FROM books AS ks
                            JOIN subcategories AS sb ON ks.id_subkategorii = sb.id_subkategorii
                            JOIN categories AS kt ON sb.id_kategorii = kt.id_kategorii
                            LEFT JOIN author AS au ON ks.id_autora = au.id_autora                                    
                            LEFT JOIN publishers AS wd ON ks.id_wydawcy = wd.id_wydawcy
                            WHERE ks.id_ksiazki = '%s'

                                ", "get_book", $book);

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
                                    // liczba_ocen: The number of ratings on the book.
                                // imie: The first name of the book's author.
                                // nazwisko: The last name of the book's author.
                                // id_wydawcy: The ID of the book's publisher.
                                // nazwa_wydawcy: The name of the book's publisher.
                                // ilosc_dostepnych_egzemplarzy: The number of available copies of the book in the warehouse.

                    // pobranie ilości każdej oceny (5 - ilość 3, 4 - ilość 2, itd .... ->

                    query("SELECT ocena, COUNT(ocena) AS liczba_ocen FROM ratings
                                WHERE id_ksiazki = '%s'
                                GROUP BY ocena
                                ORDER BY ocena DESC
                                ", "get_ratings", $book);
                    // $_SESSION['ratings'] -> key => ocena, value => ilosc_ocen

                    $_SESSION["raings_array"] = json_encode($_SESSION["ratings"]); // to pass that array to JS

                echo "<hr><br> $ _ SESSION --> <br><br>";
                    print_r($_SESSION);
                echo "<hr><br>";

                /*echo "<hr><br> $ _ POST --> <br><br>";
                    print_r($_POST);
                echo "<hr><br>";*/
                ?>

            </div>

        </main>

        <script>
            //const rating = 4.25;
            const rating = document.getElementById("book-rate").textContent;
            const totalRate = 5;
            const percentageRate = (rating / totalRate) * 100;
            const percentageRateRounded = `${Math.round(percentageRate / 10) * 10}%`;
            const percentageRateBase = `${100 - Math.round(percentageRate / 10) * 10}%`;
            //const percentageRateRounded = `${(percentageRate / 10) * 10}%`;
            document.querySelector('.rate-inner').style.width = percentageRateRounded;
            document.querySelector('.rate-inner-base').style.width = percentageRateBase;

            const rateOuter = document.querySelector('.rate-outer');
            const rateOuterWidth = rateOuter.offsetWidth;
            console.log(rateOuterWidth);  // 108px; szerokosć diva w którym siedzą gwiazdki (cała szerokość - zarówno te niewidoczne)

                document.querySelector('.rate-inner-base').style.position = "relative";
                //document.querySelector('.rate-inner-base').style.left = `${rateOuterWidth}px`;
                document.querySelector('.rate-inner-base').style.left = `${rateOuterWidth *  (Math.round(percentageRate / 10) * 10)/100}px`;

            document.querySelector('.rating-num').innerHTML = rating;

            console.log("percentageRateRounded -> ", percentageRateRounded);
            console.log("percentageRateBase -> ", percentageRateBase);
            console.log("res  -> ", `${rateOuterWidth *  (Math.round(percentageRate / 10) * 10)/100}px`);

          /*  const rateInner = document.querySelector('.rate-inner');
            const beforeElementWidth = window.getComputedStyle(rateInner, '::before').getPropertyValue('width');
            console.log(beforeElementWidth);*/

                       /* const rateInner = document.querySelector('.rate-inner');
                        const beforeElementWidth = window.getComputedStyle(rateInner, '::before').getPropertyValue('width');
                        const widthNumber = parseInt(beforeElementWidth);
                        console.log(widthNumber);*/
            // -------------------------------------------------------------------------------------------------------------
            // circle average rating -->

            /*const ratingCircle = parseFloat(document.getElementById("book-rate").textContent); // average rating
            const totalRateCircle = 5; // total rating possible
            const percentageRateCircle = (ratingCircle / totalRateCircle) * 100; // calculate percentage of rating
            const percentageRateRoundedCircle = `${Math.round(percentageRateCircle)}%`; // round the percentage
            const percentageRateBaseCircle = `${100 - Math.round(percentageRateCircle)}%`;

            document.querySelector('.rating-circle').style.background = `conic-gradient(gold ${percentageRateRoundedCircle}, gray ${percentageRateBaseCircle})`;

            document.querySelector('.rating-num-circle').innerHTML = ratingCircle.toFixed(2); // display the rating with 2 decimal places*/

            // -------------------------------------------------------------------------------------------------------------
            // circle average rating -->

            const ratingCircle = document.getElementById("rating-circle");
            ratingCircle.classList.add("filled");

            // -------------------------------------------------------------------------------------------------------------
            // ratings from DB - JS -->

            const bookRatingDetails = document.querySelectorAll(".book-rating-details"); // 5  4  3  2  1

                console.log("bookRatingDetails -> ", bookRatingDetails);

            $ratings = <?= $_SESSION["raings_array"] ?>;    // tablica z ocenami (key - ocena, value - ilosc ocen)
            $no_ratings =  <?= json_encode($_SESSION["liczba_ocen"]) ?>; // liczba wszystkich ocen --> "4"

            //$ratings = array_reverse($ratings, true);
            for (let i = bookRatingDetails.length, j = 0; i > 0 ; i--, j++) {
                let line = bookRatingDetails[j].querySelector(".line"); // .rated, .unrated

                console.log("i -> ", i);
                console.log("line -> ", line);

                // Do something with each element

                let rated = line.querySelector(".rated");
                let norates = bookRatingDetails[j].querySelector(".book-rating-details .no-rates");

                console.log("rated -> ", rated);   // złoty pasek wypełnienia - długość zgodna z ilością ocen
                console.log("norates -> ", norates);
                console.log("no_ratings -> ", $no_ratings);   // złoty pasek wypełnienia - długość zgodna z ilością ocen
                //console.log("rated -> ",  );   // złoty pasek wypełnienia - długość zgodna z ilością ocen

                let style = getComputedStyle(rated);
                let width = parseInt(style.width); // "125" (px)

                console.log("width --> ", width);
                console.log("$ratings --> ", $ratings);
                console.log("$ratings --> ", $ratings[i]);

                if($ratings[i] === undefined) {
                    newWidth = 100;
                    numer_of_rates = 0;
                    rated.style.visibility = "hidden";
                } else {
                        newWidth = (width/$no_ratings)*$ratings[i];
                        numer_of_rates = $ratings[i];
                }

                 console.log("newWidth --> ", newWidth);

                rated.style.width = newWidth + "px";
                norates.innerHTML = numer_of_rates;
            }


            // -------------------------------------------------------------------------------------------------------------
            // add new rating (5 stars, hover effect) - JS -->

            const stars = document.querySelectorAll('.star');

            console.log("stars -> ", stars);

            //let goldStars = 0;

            let keepStars;

            function updateStars(event, clear, keep) {

                        const currentStar = event.currentTarget;
                        const currentStarId = currentStar.id; // #star-1, ... #star-5
                        const starNumber = Number(currentStarId.split('-')[1]); // 1, ... 5
                        console.log("currentStar --> ", currentStar);
                        console.log("currentStarId --> ", currentStarId);
                        console.log("starNumber --> ", starNumber);

                eventType = event.type;

                if(eventType === "mouseenter") {
                    for (let i = 0; i < stars.length; i++) {
                        const star = stars[i];
                        const starId = star.id;
                        const number = Number(starId.split('-')[1]); // 1, 2, ...

                        console.log("number --> ", number);

                        if (number <= starNumber) {
                            star.classList.add('gold');
                            //goldStars++;
                        } else {
                            star.classList.remove('gold');
                            //goldStars--;
                        }
                    }
                    keepStars = false;
                } else if (eventType === "mouseout") {
                    if(!keepStars) {
                        for (let i = 0; i < stars.length; i++) {
                            const star = stars[i];
                            star.classList.remove('gold');

                            let input = star.querySelector('input[type="hidden"]');

                            if (input.hasAttribute('name')) {
                                input.removeAttribute('name');
                            }
                        }
                    }
                } else {
                    // click
                    for (let i = 0; i < stars.length; i++) {
                        const star = stars[i]; // <span class="star ... >
                        const starId = star.id; // star-1, star-2 ... star-5
                        const number = Number(starId.split('-')[1]); // 1, 2, ... 5

                        console.log("713 star --> ", star);
                        console.log("starId --> ", starId);
                        console.log("number --> ", number);
                        console.log("stars length; --> ", stars.length);
                        console.log("i --> ", i);

                        if (number <= starNumber) {
                            star.classList.add('gold');

                            if(number === starNumber) {
                                console.log("to była ostatnia gwiazdka");

                                // add name attribute for input type hidden -->

                                let input = star.querySelector('input[type="hidden"]');
                                console.log("MY INPUT -----> ", input);

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
                const star = stars[i];

                star.addEventListener('mouseenter', function (event) {
                    updateStars(event, true, true);
                });
                star.addEventListener('mouseout', function (event) {
                    updateStars(event, false, false);
                });
                star.addEventListener('click', function (event) {
                    updateStars(event, true, true);
                });
            }

            // -------------------------------------------------------------------------------------------------------------
            // set the "name" attribute for input type hidden, that was selected

            let commentRate = document.querySelector(".comment-rate").textContent.trim(); // 1, 2, ..., 5
            console.log("commentRate -> ", commentRate);
            let commentRateInner = document.querySelector(".comment-rate-inner"); // <div class="comment-rate-inner">
            commentRateInner.style.width = (commentRate / 5) * 100 + "%";

            let commentRates = document.querySelectorAll(".comment-rate") // 1, 2, ..., 5
            console.log("commentRate -> ", commentRates);

            for (let i = 0; i < commentRates.length; i++) {
                let rate = commentRates[i].textContent.trim(); // <div class="comment-rate-inner">
                commentRates[i].querySelector(".comment-rate-inner").style.width = ((rate / 5) * 100) + "%";
            }

            //let commentRateInner = document.querySelector(".comment-rate-inner"); // <div class="comment-rate-inner">
            //commentRateInner.style.width = (commentRate / 5) * 100 + "%";

            // book-page-tabs -->

            /* el = document.getElementById("tab-2");

            el.addEventListener("click", setSpanWidthv2);*/

            let ul = document.querySelector('ul.tab-list'); // <ul clsas="tab-list">
            let divs = document.querySelectorAll('div.tab-panel'); // <div clsas="tab-panel">
            console.log("divs -->", divs);

            let liEls = ul.querySelectorAll('li'); // NoideList(3) --> li, li, li.active

            console.log("<li> elements --> ", liEls);

            //let liIndex; // 0, 1, 2

            let liIndex = getCurrentIndex(); // initialize liIndex with the current active index; // 0, 1, 2

            // Add click event listener to each li element
            liEls.forEach((liEl, index) => {
                liEl.addEventListener('click', function(event) {
                    // Check if the class attribute has changed
                    if (!this.classList.contains('active')) { // <li>
                        console.log('Class attribute has changed');
                        // Do something here
                        liIndex = index;
                        console.log('Current li index:', liIndex);

                        if(window.localStorage) {
                            localStorage.setItem("liIndex", liIndex);
                        }
                    }
                    getCurrentIndex();
                });
            });

            function getCurrentIndex() {
                for (let i = 0; i < liEls.length; i++) {
                    if (liEls[i].classList.contains('active')) {
                        return i;
                    }
                }
            }

            if(window.localStorage) {
                // change active <li> tab based on localStorage value

                for (let i = 0; i < liEls.length; i++) {
                    if (liEls[i].classList.contains('active')) {
                        liEls[i].classList.remove('active');
                    }
                    if (divs[i].classList.contains('active')) {
                        divs[i].classList.remove('active');
                    }
                }

                liIndex = localStorage.getItem("liIndex");

                liEls[liIndex].classList.add('active');
                divs[liIndex].classList.add('active');
            }

        </script>

    </div>

    <?php require "../view/footer.php"; ?>

    <!--<script src="../scripts/...js"></script>-->

</body>
</html>