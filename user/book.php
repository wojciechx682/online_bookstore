<?php
session_start();
include_once "../functions.php";
/*if(!(isset($_SESSION['zalogowany']))) {
    header("Location: index.php?login-error");
    exit();
}*/
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<!--<body onload="displayNav()">-->

<?php require "../view/header-container.php"; ?>

<style>
    #book-page {
        border: 1px dashed black;
        /*padding: 20px;*/
    }

    #book-page-image {
        border: 1px dashed black;

        float: left;
        width: 25%;
        padding: 15px;
    }

    #book-page-image img {
        width: 100%;
    }

    #book-page-details {
        border: 1px dashed black;

        float:left;
        width: 50%;
    }

    #book-page-title, #book-page-author, #book-page-year, #book-page-rate, #book-page-publ, #book-page-nopg {
        border: 1px dashed black;
    }


    #book-page-rate {
        height: 200px;
    }

    /* --------------------------------------------------------- */

    .rate-inner {
        overflow: hidden;
        width: 100%;

        position: absolute;
        top: 0;
        left: 0;
    }

    /*..rate-inner::before {
        content: "\f005 \f005 \f005 \f005 \f005";
        font-family: FontAwesome;
        font-size: 120%;
        color: rgba(248, 209, 11, 0.96);
    }*/

    .rate-inner-base {

        overflow: hidden;

       /* background: linear-gradient(90deg, #f8d10b, #c3c3c3);*/
       /* background-size: 500% 100%;*/
        transition: background-position 0.4s ease-out;

        /*position: fixed;*/

        max-width: 100%;

        text-align: right;
        opacity: .3;
        /*transform: rotate(180deg);*/
        transform: scaleX(-1);
    }

    .rate-inner-base::before {

        content: "\f005 \f005 \f005 \f005 \f005";
        font-family: FontAwesome;
        font-size: 120%;
        color: silver; /* set the color of the stars to silver/gray */
        -webkit-background-clip: text;

        /*background-size: 500% 100%;*/
    }



    .rate-inner::before {
        content: "\f005 \f005 \f005 \f005 \f005";
        font-family: FontAwesome;
        font-size: 120%;
        color: rgba(248, 209, 11, 0.96);
    }




    .rating-num {
        display: block;
        float: left;

        padding-right: 12px;
    }

    #rate-container {
        float: left;
        position: relative;
    }

    /* circle rates --> --------------------------------------------------------- */


    #book-page-rate-circle {
        height: 200px;
        width: 200px;
        position: relative;
        margin: auto;
    }

    .rating-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        position: absolute;
        top: 0;
        left: 0;
        background: linear-gradient(to right, gold 50%, gray 50%);
        transform: rotate(-90deg);
        transform-origin: center;
    }

    .rating-circle::before {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        position: absolute;
        top: 0;
        left: 0;
        background: linear-gradient(to right, gray 50%, transparent 50%);
        transform: rotate(30deg);
        transform-origin: center;
    }
    /* circle rates --> --------------------------------------------------------- */
    #rating-circle {
        stroke-dasharray: 62.8; /* circumference of the circle */
        stroke-dashoffset: 0;
        transition: stroke-dashoffset 1s ease;

        width: 50px;
        height: 50px;
        position: relative;
        overflow: auto;
    }

    #rating-circle.filled {
        stroke-dashoffset: calc(62.8 - (62.8 * <?= $_SESSION["avg_rating"] ?> / 5));
    }

    #circle-plot svg {
        width: 750px;
        height: 750px;
        position: relative;
    }

    #circle-plot {
        border: 1px dashed black;
        overflow: hidden;

        width: 225px;
        height: 225px;

        float: left;
    }

    #book-rating-details {
        border: 1px dashed black;

        float: left;
        height: 225px;
        width: 225px;


    }

    .book-rating-details {
        border: 1px dashed black;

        float: left;

        width: 225px;

        height: 45px;

        text-align: center;

        line-height: 45px;


    }

    .rate {
        border: 1px dashed black;
        float: left;
        width: 25px;
    }

    .line {
        border: 1px dashed black;

        float: left;
        width: 150px;

        height: 45px;
    }

    .no-rates {
        border: 1px dashed #ff0000;
        float: left;
        width: 25px;
    }

    .rated, .unrated {
        float: left;
        border: 1px solid red;


        border-radius: 10px;

        width: 125px;
        position: relative;
        top: 10px;
        height: 5px;

        height: 10px;
        background-color: #FFD700FF;


    }

    .rated {
        z-index: 10;
    }

    .unrated {
        /*height: 10px;*/
        background-color: #bebebe;
        position: relative;
        top: 0px;

        z-index: 1;

    }

    /*.book-rating-line {
        border: 1px dashed black;

        float: left;

        width: 55px;

        height: 25px;

        text-align: center;

        line-height: 45px;
    }*/

    /* dodawanie recenzji --> ------------------------------------ */

    #add-review {
        /*width: 100%;*/
        margin: 15px;
        border: 1px solid black;
        border-radius: 15px;
        padding: 0 15px 0 15px;
    }

    #textarea-comment {
        width: 425px;
        height: 145px;
        resize: none;
        margin: 10px 0 10px 0;
    }



    #add-rate {

        border: 1px dashed black;
        height: 250px;


    }

    .add-rate-outer {
        border: 1px dashed black;

    }

    .add-rate-inner {
        border: 1px dashed black;


    }

    span.star {
        border: 1px dashed black;

        display: block;
        float: left;

        text-align: center;
        width: 45px;
    }



    span.star::before {

        content: "\f005";
        font-family: FontAwesome;
        /*font-size: 120%;*/
        color: silver; /* set the color of the stars to silver/gray */
        -webkit-background-clip: text;

        /*background-size: 500% 100%;*/
    }

    /*span.star:hover::before {

        content: "\f005";
        font-family: FontAwesome;
        !*font-size: 120%;*!
        !*color: silver; !* set the color of the stars to silver/gray *!*!
        -webkit-background-clip: text;

        color: rgba(248, 209, 11, 0.96);
    }*/

    span.star.gold::before {

        content: "\f005";
        font-family: FontAwesome;
        /*font-size: 120%;*/
        /*color: silver; !* set the color of the stars to silver/gray *!*/
        -webkit-background-clip: text;

        color: rgba(248, 209, 11, 0.96);
    }





/*    .rate-inner::before {
        content: "\f005 \f005 \f005 \f005 \f005";
        font-family: FontAwesome;
        font-size: 120%;
        color: rgba(248, 209, 11, 0.96);
    }*/











                                      .stars {
        display: inline-block;
    }

    .stars input[type="radio"] {
        display: none;
    }

    .stars label {
        /*font-size: 50px;*/
        color: grey;
        cursor: pointer;
    }

    .stars label:before {
        content: "\2605";
    }

    .stars input[type="radio"]:checked + label {
        color: #FFD700FF;
    }


</style>

<script></script>

<div id="container">

    <main>

        <aside>
            <div id="nav"></div>
        </aside>

        <div id="content">

            <hr>

            <?php
            /*            // echo '<a href="index.php?kategoria='.$_SESSION['kategoria'].'">&larr; Wróć </a>';

                        $id = filter_var($_SESSION['id'], FILTER_SANITIZE_STRING);

                        query("SELECT kl.id_klienta, ko.id_ksiazki, ko.ilosc, ks.tytul, ks.cena, ks.rok_wydania FROM klienci AS kl, koszyk AS ko, ksiazki AS ks WHERE kl.id_klienta = ko.id_klienta AND ko.id_ksiazki = ks.id_ksiazki AND kl.id_klienta='%s'", "get_product_from_cart", $id); // książki które zamówił klient o danym ID;

                        query("SELECT SUM(ilosc) AS suma FROM koszyk WHERE id_klienta='%s'", "count_cart_quantity", $id);
                        */?>

            <?php /*query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.image_url, ks.rating,
                         km.id_klienta, km.tresc,
                         rt.ocena, rt.id_klienta,

                         au.imie, au.nazwisko,

                         ks.id_wydawcy, wd.nazwa_wydawcy,
                         mg.ilosc_dostepnych_egzemplarzy

                         FROM ksiazki AS ks, autor AS au, komentarze AS km, ratings AS rt, magazyn_ksiazki AS mg, wydawcy AS wd
                         WHERE ks.id_autora = au.id_autora AND  ks.id_ksiazki = km.id_ksiazki AND ks.id_ksiazki = rt.id_ksiazki AND ks.id_wydawcy = wd.id_wydawcy AND ks.id_ksiazki = mg.id_ksiazki AND ks.id_ksiazki = '%s'", "get_book", $_GET["book"]); */




            $book = filter_var(filter_input(INPUT_GET, 'book', FILTER_SANITIZE_NUMBER_INT), FILTER_VALIDATE_INT); // validate book's id
            echo "<br> book -> $book <br>";

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

            query("SELECT ks.id_ksiazki, ks.tytul, ks.cena, ks.rok_wydania, ks.kategoria, ks.oprawa, ks.ilosc_stron, ks.image_url, ks.rating, ks.wymiary, ks.stan,   
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
                        ", "get_book", $book); // foregins key => id_autora, id_ksiazki, id_wydawcy

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
                        ", "get_ratings", $book); // $_SESSION['ratings'] -> key => ocena, value => ilosc_ocen

            echo "<hr>";

            $_SESSION["raings_array"] = json_encode($_SESSION["ratings"]); // to pass that array to JS
           /* $_SESSION["asdasd"] = json_encode($_SESSION["liczba_ocen"]);*/ // to pass that array to JS

            print_r($_SESSION);


            echo "<br> ratings array -> ";

            print_r($_SESSION["raings_array"]);

            echo "<hr>";

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

                //"200px";

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
                    }
                }
            } else {
                // click



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



    </script>

</div>

<?php require "../view/footer.php"; ?>

<!--    <script src="../scripts/set-span-width.js"></script>-->

</body>
</html>