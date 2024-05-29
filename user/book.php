<?php

    require_once "../start-session.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        if (isset($_POST["book-id"]) && !empty($_POST["book-id"])) {

            $bookId = validateBookId($_POST["book-id"]);

            if (empty($bookId)) {

                $_SESSION["application-error"] = true;

                unset($_POST, $bookId);
                    header('Location: index.php', true, 303);
                        exit();

            } else {

                $_SESSION["book-id"] = $bookId;

                unset($_POST, $bookId);
                    header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
                        exit();
            }

        } else {
            $_SESSION["application-error"] = true;
                header('Location: index.php', true, 303);
                    exit();
        }

    } elseif ($_SERVER['REQUEST_METHOD'] === "GET" && (empty($_SESSION["book-id"])) ) {
        $_SESSION["application-error"] = true;
            header('Location: index.php', true, 303);
                exit();

    } elseif ($_SERVER['REQUEST_METHOD'] === "GET" && (!empty($_SESSION["book-id"])) && (!empty($_SESSION["rating"])) )  {

        query("SELECT ks.id_ksiazki, ks.tytul, ks.rating, (SELECT COUNT(*) FROM ratings WHERE id_ksiazki = ks.id_ksiazki) AS liczba_ocen
               FROM books AS ks
               WHERE ks.id_ksiazki = '%s'", "updateBookRates", $_SESSION["book-id"]); // <-- UPDATE

        unset($_SESSION["rating"]);
            header('Location: ' . $_SERVER['REQUEST_URI'], true, 303);
                exit();
    }

?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/header-container.php"; ?>

        <div id="container">

            <main>

                <div id="content">

                    <?php if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_SESSION["book-id"]) ) : ?>

                        <?php

                            echo '<div id="aaa"><a href="index.php" id="get-back-a"><i class="icon-down-open" id="book-page-get-back"></i>Wróć </a></div>';

                            if(isset($_SESSION["avg_rating"])) {
                                unset($_SESSION["avg_rating"]);
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



                            $_SESSION["ratings"] = [];

                            query("SELECT ocena, COUNT(ocena) AS liczba_ocen FROM ratings WHERE id_ksiazki = '%s' GROUP BY ocena ORDER BY ocena DESC", "getRatings", $_SESSION["book-id"]);

                            $_SESSION["raings_array"] = json_encode($_SESSION["ratings"]); // JSON string;


                        ?>

                    <?php endif; ?>

                    <?php

                        // -------------------------------------------------------------------------------------------------
                        // Problemy implementacyjne ->

                        // 1. ✓✓✓ Po kliknięciu gwiazdki przy dodawaniu opinii, -- zostały one resetowane po najechaniu na inną gwiazdkę.
                        //    - Od teraz, po kiknięciu, gwiazdki zostają zapisane. (najechanie na inną gwiazdkę nie zmienia ich stanu - jedynie dopiero kliknięcie)

                        // 2. ✓✓✓ Podczas dodawania opinii, przy kliknięciu dwóch gwiazdek w następującej po sobie kolejności, wystąpił błąd polegający na dodaniu niewłaściwej oceny w skali 5/5 (Np. jeśli użytkownik kliknął "3", a potem "2" - ocena została zapisana jako "3")
                        // - rozwiązaniem było dodanie funkcji usuwającej atrybuty "name" ze wszystkich gwiazdek - po kliknięciu na dowolną gwiazdkę;
                        // (atrybut "name" posiada tylko ten input, dla którego gwiazdka została kliknięta)

                            // 3. ✓✓✓ Podczas odświeżania strony z książką poprzeż użycie klawiszy Ctrl + F5 - pojawiał się błąd polegający na nieodopowiednim umiejscowieniu szarych gwiazdek proporcjonalnie względem żółtych gwizdek (w sekcji #book-page-details - przy zdjęciu książki). - podczas resizowania okna przeglądarki

                            // ✓✓✓ rozwiązaniem było dodanie linii window.onload - "która czeka" na wczytanie wszystkich zasobów strony (w tym stylów CSS) - tak aby ostatecznie zachować poprawne umiejscowienie żółtych i szarych gwizdek względem siebie ;
                            // 5. // ✓✓✓ ROZWIĄZANIE PROBLEMU IMPLEMENTACYJNEGO - zamiana position left z px na wartość % (!) - podczas resizowania nastąpiło błędne kalkulowanie tej pozycji, od teraz przy ZMIANIE ROZMIARU pozycja szarych gwiazdek względem złotych jest OK (!)

                            // ✓ rozwiązaniem było zastosowanie wartości procentowych (relatywnych) zamiast wartości wyrażonych w px - do ustalenia stylów tych elementów !

                        // 4. Animacja wypełniania okręgu na żółto (proporcjonalnie do średniej oceny) - OPISAĆ - jak zostało zrobione to, że wypełnienie zaczyna się od początku okręgu;

                        // -------------------------------------------------------------------------------------------------

                    ?>

                </div> <!-- #content -->

            </main>

            <script>

                const rating = document.getElementById("book-rate").textContent;

                window.addEventListener("load", function() {

                    const totalRate = 5;
                    const percentageRate = (rating / totalRate) * 100; // (4.5 / 5) * 100 => "90" <- "number" // Ocena wyrażona w procentach;

                    const percentageRateRounded = `${Math.round(percentageRate / 10) * 10}%`; // "90%"  <- "string"
                    // Zaokrąglona wartość średniej oceny (do najbliższej dziesiątki);

                    const percentageRateBase = `${100 - Math.round(percentageRate / 10) * 10}%`; // "10%" <- "String"
                     // to będzie szerokość diva z Szarymi gwiazdkami;

                    document.querySelector('.rate-inner').style.width = percentageRateRounded; // width: 90%;   // szerokość diva z Żółtymi gwiazdkami;
                    document.querySelector('.rate-inner-base').style.width = percentageRateBase; // width: 10%; // szerokość diva z Szarymi gwiazdkami;
                    document.querySelector('.rate-inner-base').style.position = "relative";
                    document.querySelector('.rate-inner-base').style.left = percentageRateRounded; // -> 100 * (0,9) --> 90 (%) ;

                    if(rating !== "") {
                        document.querySelector('.rating-num').innerHTML = Math.round(rating*100)/100;
                    } else {
                        document.querySelector('.rating-num').innerHTML = "" ;
                    }

                    const circle = document.getElementById("rating-circle"); // żółte kółko;

                    const circumference = parseFloat(circle.getAttribute('r')) * 2 * Math.PI; // obwód koła; // circumference of the circle
                                                                                              // "62.83185307179586" <- number;
                    circle.style.strokeDasharray = `${rating*(circumference/5)}, ${circumference}`;
                });

                // -----------------------------------------------------------------------------------------------------

                // Wyświetlenie ocen książki w postaci graficznych pasków. Każdy pasek reprezentuje ilość ocen dla danej wartości oceny (na przykład, ile razy książka otrzymała 5 gwiazdek, 4 gwiazdki itp.)

                const bookRatingDetails = document.querySelectorAll(".book-rating-details"); // Kolekcja NodeList divów z żółtymi paskami;

                $ratings = <?= $_SESSION["raings_array"] ?>; // JSON -> obiekt JS -> (tablica z ocenami, key - ocena, value - ilosc ocen);

                // {                                         // { "5" : "2", "4" : "1" }
                //    "5": "1",
                //    "4": "1"
                //    ...  ...
                // }

                $no_ratings =  <?= json_encode($_SESSION["liczba_ocen"]) ?>;      // "4" <- "String" - LICZBA wszystkich OCEN;

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


                        let rated = line.querySelector(".rated");                      // ✓ żółty pasek ;
                        let norates = bookRatingDetails[j].querySelector(".no-rates"); // ✓ pojemnik na ilość_ocen;

                        let style = getComputedStyle(line); // "125px" <- (read only) - szerokość (właściwość CSS) żółteo paska ✓ ;

                        let width = parseInt(style.width)-10, newWidth, numberOfRates; // width - szerokość żółtego paska (125px);
                        // "125" - (px) <- "number" ;

                        //          5
                        if($ratings[i] === undefined) { // ✓ jeśli dana ocena nie wystąpiła ani razu ;
                            //newWidth = 100;     // szerokość paska;
                            numberOfRates = 0;    // ilość_ocen;
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

                        norates.innerHTML = "("+numberOfRates+")"; // ilość ocen (np 2 razy wystąpiła ocena "5");
                    }
                }

                // -----------------------------------------------------------------------------------------------------
                // -----------------------------------------------------------------------------------------------------
                //  ̶a̶d̶d̶ ̶n̶e̶w̶ ̶r̶a̶t̶i̶n̶g̶ ̶(̶5̶ ̶s̶t̶a̶r̶s̶,̶ ̶h̶o̶v̶e̶r̶ ̶e̶f̶f̶e̶c̶t̶)̶ ̶-̶ ̶J̶S̶ ̶;̶

                // Gwiazdki - przy dodawaniu nowej opinii - Interakcje przy najechaniu kursorem ;

                const stars = document.querySelectorAll('.star'); // # add-rate -> # add-rate-outer -> .star ;
                // Kolekcja typu NodeList ; // ✓ Kolekcja spanów z gwiazdkami ;

                let keepStars = false; // == true po kliknięciu ("click") na gwiazdkę

                function updateStars(event) {

                    const currentStar = event.currentTarget; // <span> z gwiazdką; // który zostal kliknięty;
                        // <span class="star" id="star-1">
                        //      1 <input type="hidden" value="1">
                        // </span>
                    const currentStarId = currentStar.id; // id klikniętej gwiazdki; // "star-1", "star-4", ... // #star-1, ... #star-5;
                    const starNumber = Number(currentStarId.split('-')[1]); // "1", ... "5" ; <- "number"
                    // id klikniętej gwiazdki ;

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

                            if (number <= starNumber) { // ✓ jeśli i-ty element (<span> z gw.) jest mniejszy niz ten klikniety (event) ;
                                // number - id i-tej gwiazki,
                                // starNumber - id kliknietej gwiazdki ;
                                star.classList.add('gold');
                            }
                        }
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

                            if (input.hasAttribute('name')) {
                                //alert();
                                input.removeAttribute('name');
                            }
                        }
                    }

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
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                function removeNameAttribute(stars) {

                    for (let i = 0; i < stars.length; i++) {

                        let input = stars[i].querySelector('input[type="hidden"]');

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

                content = document.getElementById("content"); // ustawienie width div#content na 100%
                //console.log("content -> ", content);
                content.style.width = "100%";

            </script>

        </div> <!-- #container -->

        <?php require "../view/footer.php"; ?>

    </div> <!-- #main-container -->

<script>
    content = document.getElementById("content"); // ustawienie wid div#content na 100%
    //console.log("content -> ", content);
    content.style.width = "100%";



</script>

<!--<script src="../scripts/...js"></script>-->

    <?php require "../view/app-error-window.php"; ?>

</body>
</html>

<?php /*endif*/ ?>