// Wyszukiwanie - wyświetlanie wyników DOPASOWANYCH do WYRAŻENIA.
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// technika Livesearch -->

// (!) wyszukiwanie NA PODSTAWIE atrybutu alt w elemencie <img>

// indexOf() - metoda obiektu String - (sprawdzenie pod kątem szukanego wyrażenia)
    // zwraca -1 jeśli nie znaleziono,
    // ROZRÓŻNIA WIELKOŚĆ LITER ! - dlatego trzeba skonwertować tekst ... NA ZAPISANY MAŁYMI LITERAMI !

//////////////////////////////////////////////////////////

(function() {
    let $imgs = $("#gallery img");     // kolekcja wszystkich obrazów
    let $search = $("#filter-search"); // element <input> o id ="filter-search"
    let cache = []; // tablica na podst. której odbywa się wyszukiwanie

    $imgs.each(function() {
        cache.push({      // dodanie obiektu do tablicy cache
            element: this,  // <img ...>
            text: this.alt.trim().toLowerCase() // text atrybutu alt -> małe litery + usunięcie zbędnych znaków
        });
    });

    /*
        cache = [
            {
              element: img,
              text: "rabbit"
            },
            { element: img, text: "sea" },
            ...
            ...
        ];
     */
    function filter() {
        let query = this.value.trim().toLowerCase(); // pobranie danych z <input>

        cache.forEach(function(img) { // dla każdego obiektu w tablicy cache -->
            // img - elementy tablicy cache (obiekt)
            let index = 0;

            if(query) {  // jeśli zapytanie (z <input>) ma wartość / istnieje
                index = img.text.indexOf(query); // img - to obiekt pojedynczy obiekt w tablicy cache, text - to właściwość tego obiektu
                // indexOf() - Sprawdzenie, czy tekst zmiennej query ZNAJDUJE SIĘ W TYM OBIEKCIE !
            }

            // index - przechowuje indeks obrazu (obiektu w tablicy cache), który zawiera szukany tekst !

            img.element.style.display = index === -1 ? "none" : ""; // wyświetlenie lub ukrycie obrazu (w tablicy cache -> zmiana stylu obrazu, który siedzi we właściwości "element" obiektu)

        });
    }

    if("oninput" in $search[0]) {
        // jeśli przeglądarka obsługjuje zdarzenie "input" !
        $search.on("input", filter); // wywołanie funkcji filter() po wprowadzeniu tekstu do <input> !
    } else {
        $search.on("keyup", filter);
    }
}());
