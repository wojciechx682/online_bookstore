////////////////////////////////////////////////////////////////////////

// let a = 1;
// let b = 2;
// console.log(a + ' - ' + b + ' = ' + (b-a));

// SORTOWANIE

/*
    obiekt "Array" -> metoda .sort() - (sortuje leksykograficznie, nie nadaje sie do liczb, do tekstów tak)
    -------------------------------------------------------------------
    Funkcja porównująca - zastosowanie do sortowania LICZB
    - porównuje dwie wartości liczbowe,
    - zwraca LICZBĘ (służy do zmiany kolejności elementów,
                     wskazuje KTÓRY z elementów powinien być PIERWSZY),

                - "czy a ma się pojawić przed b ?"

      < 0 - element "a" ma się pojawić PRZED "b",
        0 - nie zmienia kolejności elementów,
      > 0 - element "a" ma się pojawić PO "b"

      !!! Każdy TYP DANYCH wymaga użycia innej funkcji porównującej ! (można je włożyć jako właściwości obiektu np "compare")
 */

let prices = [3,1,5,4,2];

prices.sort(function(a,b) {
                   // (!) USTALENIE KTÓRA WARTOŚĆ ma być PIERWSZA !
    return a - b; // sortowanie ROSNĄCE
    //return b - a; // sortowanie MALEJĄCE
    //return 0.5 - Math.random(); // kolejność LOSOWA - zwr. wart. losowe --> <-1, 1>
})

console.log("prices -> ", prices);

////////////////////////////////////////////////////////////////////////
// Sortowanie Dat -->

    // konwersja na obiekty Date,   <   >

let holidays = [
    "2014-12-25",
    "2014-01-01",
    "2014-07-04",
    "2014-11-28"
];

holidays.sort(function(a,b) {
    let dateA = new Date(a);
    let dateB = new Date(b);
    return dateA - dateB;
})
console.log("holidays -> ", holidays);

////////////////////////////////////////////////////////////////////////
// Sortowanie TABELI -->

    // każdy wiersz TABELI jest przechowywany W TABLICY !

let compare = {                    // obiekt "compare"
    name: function(a,b) {          // metoda "name"
        a = a.replace(/^the /i, ''); // usunięcie słowa "the" z początku parametru
        b = b.replace(/^the /i, ''); // usunięcie wszystkich wystąpień "the" z początku ciągu; opcja "i" oznacza że wielkosć znaków nie ma znaczenia.s

        if(a<b) {
            return -1;
        } else {
            return a > b ? 1 : 0;
        }
    },

    duration: function(a, b) {
        a = a.split(":");  // podział czasu w miejscu ":" (zwraca tablicę!)
        b = b.split(":");

        a = Number(a[0]) * 60 + Number(a[1]); // konwersja czasu na Sekundy
        b = Number(b[0]) * 60 + Number(b[1]);

        return a - b;
    },

    date: function(a, b) {
        a = new Date(a); // konwersja na obiekt Date
        b = new Date(b);

        return a - b;
    }
}

$(".sortable").each(function() {

    let $table = $(this); // tabela do sortowania
    let $tbody = $table.find("tbody"); // zawartość tabeli
    let $controls = $table.find("th"); // nagłówki tabeli
    let rows = $tbody.find("tr").toArray(); // Tablica przechowująca WIERSZE

    // console.log(" $table -> ", $table);
    // console.log(" $tbody -> ", $tbody);
    // console.log(" $controls -> ", $controls);
    // console.log(" rows -> ", rows);

    $controls.on("click", function() { // po kliknięicu nagłówka tabeli <th>
        let $header = $(this); // nagłówek <th>
        let order = $header.data("sort"); // wartość atrybutu data-sort !
        let column;

        // does header have class like "ascending" or "descending" ?
        if($header.is(".ascending") || $header.is(".descending")) {
            $header.toggleClass("ascending descending"); // zmiana atrybutu class na przeciwna
            $tbody.append(rows.reverse()); // dodanie do ciała tabeli wierszy, w odwróconej kolejności (Odwrócenie kolejności elementów tablicy)
        } else { // w przeciwnym razie, posortowanie tablicy ...
            $header.addClass("ascending");  // dodanie klasy do nagłówka
            $header.siblings().removeClass("ascending descending"); // usunięice klasy z wszystkich pozostałych nagłówków
            if(compare.hasOwnProperty(order)) {
                // jeśli obiekt header ma właściwość (dokładnie METODĘ)o nazwie takiej jak w data-sort
                column = $controls.index(this); // wyszukanie numeru indeksu kolumny

                rows.sort(function(a, b) {
                    a = $(a).find("td").eq(column).text(); // pobranie tekstu kolumny w wierszu a
                    b = $(b).find("td").eq(column).text();
                    return compare[order](a, b); // Wywołanie metody porównującej !
                });
                $tbody.append(rows);
            }
        }
    });
});

// console.log("sortable ->", sortable);

















