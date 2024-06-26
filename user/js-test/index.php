
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Filtrowanie, Sortowanie, Wyszukiwanie</title>
    <style>
        body {
            background-color: rgb(134, 134, 134);
            color: white;
            font-family: 'Lato', sans-serif;
            /*border: 1px solid white;*/
            font-weight: unset !important;
        }

        h3 {
            /*border: 1px solid white;*/
            text-align: justify !important;
            padding: 10px 0 10px 0;
            margin-bottom: 0;
        }

        h4 > span {
            color: red;
        }

        h4.red-header, p span {
            color: red;
        }

        p {
            color: #86a8d5;
        }

        table, tr, td {
            border: 1px solid white;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            color: #006cd5;
        }

        tr, td {
            padding: 10px;
            margin: 0;
        }

        circle#gray-circle,
        circle#gold-circle {
            stroke-dasharray: 0;
            stroke-dashoffset: 0;
        }

        /*circle#blue-circle {
            !*transition: stroke-dashoffset 0.4s ease;*!
            transition: stroke-dasharray 1s ease;
        }*/

    </style>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>
<body>

    <!--<h3>Filtrowanie, Wyszukiwanie, Sortowanie</h3><hr>

    <p>
        <p>Filtrowanie - zmniejszenie zbioru danych przez wybór tych wartości, któe spełniają zdefiniowane kryteria</p>
        <p>Wyszukiwanie - wyświetlenie elementów dopasowanych do conajmniej jednego słowa podanego przez użytkownika</p>
        <p>Sortowanie - zmiana kolejności elementó na stronie w oparciu o pewne kryteria (na przykład ułożenie ich w kolejności alfabetycznej)</p>

        <h4>Metody JavaScript służące do pracy z tablicami <span>(Metody tablic)</span></h4>

        <p><span>Metody obiektu Array</span></p>

        <p> .length </p>

        <h4 class="red-header">Metody te wywoływane są na rzecz tablicy !</h4>

        <p>push()</p>
        <p>unshift()</p>
        <p>pop()</p>
        <p>shift()</p>
        <p>forEach() - (!) - Jednokrotnie wyłowuje funkcję dla każdego elementu tablicy<br><br>można wykorzystać ją do filtrowania tablicy - przeprowadza iteracje przez tablicę i wykonuje tę samą funkjce dla każdego elementu tablicy.
        </p>
        <p>some()</p>
        <p>every()</p>
        <p>concat()</p>
        <p>filter() - (!) - Tworzy nową tablicę wraz z elementami, któe przechodzą test wskazany przez funkcję<br><br>metoda filter() - jest przeznaczona tylko do filtrowania danych !
        </p>
        <p>sort() - (!) - Funkcja porównująca - Zmienia kolejność elementów w tablicy za pomocą funkcji (nazywanej funkcją porównującą)</p>
        <p>reverse()</p>
        <p>map()</p>
    </p><hr>

    <p>
        <h4>Metody jQuery przeznaczone do filtrowania i sortowania</h4>

        <p>Kolekcje jQuery - obiekty przypominające tablice, przedstawiające elementy modelu DOM.</p><br>

        <p>.add() - (Dodawanie lub Łączenie elementów) - dodawanie elementów do zbioru dopasowanych elementów</p>
        <p>.not() - (Usuwanie elementów) - usunięcie elementów ze zbioru dopasownych elementóww</p>
        <p>.each() - (Iteracja) - Użycie tej samej funkcji dla każdego elementu w zbiorze dopasowanych elementów</p>
        <p>.filter() - (Filtrowanie) - Zmniejszenie liczby elementów w dopasowanym zbiorze do jedynie tych, które zostały dopasowane do selektora lub przechodzą test wskazany w funkcji</p>
        <p>.toArray() - (Konwersja) - konwersja kolekcji jQuery na Tablicą elementów modelu DOM, co pozwala na użycie metod tablicy</p>

    </p><hr><br>-->

    <table id="result-table"></table>

    <script>

        // Tablica obiektów;

        let people = [
            { name: "Czesław", rate: 60 },
            { name: "Celina", rate: 80 },
            { name: "Grzegorz", rate: 75 },
            { name: "Nikodem", rate: 120 }
        ];

        /*console.log("\n people -> \n\n", people);
        console.log("\n people[0] -> \n\n", people[0]);

        console.log("\n people[0].name -> \n\n", people[0].name);
            console.log('\n people[0]["name"] -> \n\n', people[0]["name"]);

        console.log("\n people[0].rate -> \n\n", people[0].rate);
            console.log('\n people[0]["rate"] -> \n\n', people[0]["rate"]);*/

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Filtrowanie

        let result = []; // tablica;

        for (let i=0; i<people.length; i++) {

            let person = people[i]; // obiekt;

            //console.log("\n people[", i, "] = ", person);

            if(person.rate >= 65 && person.rate <= 90) {
                result.push(person); // wstaw obiekt do tablicy "result";
            }
        }

        //console.log("\n result -> \n\n", result); // tablica

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Filtrowanie - forEach(), filter()

        // wyświetlenie tablicy result[] (zawiera przefiltrowane dane!) -->

        $(function() { // wykonanie funkcji, gdy model DOM jest gotowy do pracy;

            let $tbody = $('<tbody></tbody>'); // ciało tabeli;

            for (let i=0; i < result.length; i++) { // iteracja przez tablicę result;

                let person = result[i]; // obiekt;

                let $row = $('<tr></tr>'); // wiersz tabeli;
                $row.append($('<td></td>').text(person.name));
                $row.append($('<td></td>').text(person.rate));

                $tbody.append($row); // wstawienie wiersza do tabeli (<tbody>);
            }

            //$('table#result-table').append($tbody);

        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Filtrowanie - zastosowanie metody forEach()

        $(function() { // ✓ document ready (DOM);

            let results = []; // tablica zawierająca przefiltrowane dane; - przychowywanie dopasowanych elementów

            people.forEach(function(person) {  // wywołanie funkcji anonimowej dla każdego elementu tablicy - obiektu)

                // person - (obiekt) - pojedynczy element tablicy people !

                if (person.rate >= 65 && person.rate <= 90) {
                    results.push(person); // dodanie obiektu do tablicy (results);
                }
            });

            //console.log("\n results -> \n\n", results); // tablica;
        });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Filtrowanie - zastosowanie metody filter() - ZWRACA TYLKO TRUE/FALSE !;
        // metoda filter() - jest przeznaczona tylko do filtrowania danych !

        $(function() { // ✓ document ready (DOM);

            let results = []; // tablica zawierająca przefiltrowane dane; - przychowywanie dopasowanych elementów - dane dotyczące osób;

            // Funkcja działa w charakterze filtru -->

            function priceRange(person) { // person - pojedynczy element tablicy people (jest to obiekt !);
                return (person.rate >= 65) && (person.rate <= 90); // true/false;
            }

            results = people.filter(priceRange); // funkcja filter() wywołuje priceRange();


            //console.log("\n results -> \n\n", results); // tablica;
        });



    </script>

    <br><hr><br>

    <style>
        svg {
            border: 1px solid black;
        }
    </style>

    <svg height="210" width="210">

        <circle id="gray-circle" cx="105" cy="105" r="100" stroke="#c0c0c0" stroke-width="3" fill="none" />

        <circle id="gold-circle" cx="105" cy="105" r="100" stroke="#ffc400" stroke-width="3" fill="none" />

    </svg>

    <br><hr><br>

    <div>
        <svg width="210" height="210">

            <circle id="blue-circle" cx="105" cy="105" r="100" stroke="#006cd5" stroke-width="2" fill="none"

            >

                <!--stroke-dasharray="100"
                    stroke-dashoffset="528"-->


            </circle>

        </svg>
    </div>



    <br><hr><br>




    <div id="result">

    </div>

    <script>

        let goldCircle = document.getElementById("gold-circle");
            //console.log("\n gold-circle -> ", goldCircle);
        let grayCircle = document.getElementById("gray-circle");
            //console.log("\n gray-circle -> ", grayCircle);

        let yellowCircumference = parseFloat(goldCircle.getAttribute('r')) * 2 * Math.PI; // obwód żółtego koła;
        //console.log("\n yellow Circumference -> ", yellowCircumference);
        //console.log("\n yellow Circumference -> ", typeof yellowCircumference);

        //goldCircle.style.strokeDasharray = "200";

        // ukryj złoty okrąg
        goldCircle.style.strokeDasharray = `${yellowCircumference}, ${yellowCircumference}`;
        goldCircle.style.strokeDashoffset = `${yellowCircumference}`;

        // Teraz, dla zmniejszenia wypełnienia o 100
        let value = 500;
        let newStrokeDashoffset = yellowCircumference - (yellowCircumference-value);
        goldCircle.style.strokeDashoffset = `${newStrokeDashoffset}`;

    </script>

    <script>

        window.onload = function() {
            let blueCircle = document.getElementById("blue-circle");

            let circumference = parseFloat(blueCircle.getAttribute('r')) * 2 * Math.PI; // obód koła;
            console.log("\nobwód koła -->", circumference, "-", typeof circumference);

            /*blueCircle.style.strokeDasharray = `${circumference}`;
            blueCircle.style.strokeDashoffset = `${circumference}`;*/

            // Ustaw koło jako całkowicie wypełnione

            let rating = 3.75;
            //blueCircle.style.strokeDasharray = `${circumference}, ${0}`;
            blueCircle.style.strokeDasharray = `${rating*(circumference/5)}, ${circumference}`;


            //blueCircle.style.strokeDasharray = `${circumference}, ${circumference}`;
            //blueCircle.style.strokeDashoffset = `${circumference}`;
        }


    </script>



</body>
</html>