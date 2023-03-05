let $imgs = $("#gallery img"); // KOLEKCJA wszystkich obrazów
let $buttons = $("#buttons"); // kontener na przyciski - <div id="buttons">
let tagged = {};

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Utworzenie obiektu "tagged" - na podst. atrybutów data-tags elementów <img>

(function() {
    $imgs.each(function() {
        let img = this; // <img src="img/p2.jpg" data-tags="Photographers, Filmmakers" alt="Sea">
        let tags = $(this).data("tags"); // "Animators, Illustrators"
        if(tags) {
            tags.split(',').forEach(function(tagName) { // tags.split(',') <-- (tablica)
                if(tagged[tagName] == null) {
                    tagged[tagName] = [];
                }
                tagged[tagName].push(img);
            });
            console.log(" -> ", tags.split(','));
            //console.log("typeof tags.split(',')  -> ", typeof(tags.split(',')));
        }
    });
    // Miejsce na przyciski, procedury obsługi zdarzeń i filtry ...
    // ...
}());

console.log(" tagged -> ", tagged); //  Filmmakers" : Array(3)   --> : img 1: img 2: img ...
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filtrowanie galerii -> Przyciski filtrowania, Ukrycie/Wyświetlenie obrazów dla danego tagu -->

(function() {

    // Utworzenie PRZYCISKU do WYŚWIETLANIA obrazów -->
    // (drugim parametrem jest LITERAŁ OBIEKTU ustawiający jego WŁAŚCIWOŚCI ->
    $("<button/>", {
        text: "Wyświetl wszystko", // dodawanie ATRYBUTÓW do przycisku <button>
        class: "active",
        click: function() { // procedura obsługi zdarzania "click"
            $(this)
                .addClass("active")
                .siblings()                // elementy równorzędne -->  <button>
                .removeClass("active"); // usunięcie z nich klasy "active" (!)
            $imgs.show(); // wywoływana dla wszystkich obrazów
        }
    }).appendTo($buttons); // dołączenie przycisku <button> do kontenera na przycisku --> <div id="buttons">

    // Tworzenie POZOSTAŁYCH przycisków FILTROWANIA -->

    $.each(tagged, function(tagName) { // iteracja przez zawartość obiektu "taged"

        /*
            tagged = {
                "Animators": [img, img] <-- (odniesienia od obrazów!)
                ...
            }
         */

        // tagName - właściwość obiektu "tagged" !
        $("<button/>", {   // utworzenie PUSTEGO PRZYCISKU
            text: tagName + ' (' + tagged[tagName].length + ')', // tagged[tagName].length - ILOŚĆ obrazów posiadających ten TAG !
            click: function() { // po kliknięciu (nowo utworzonego) przycisku
                $(this) // kliknięty przycisk --> <button>
                    .addClass("active")
                    .siblings() // pozostałę przycisku równorzędne
                    .removeClass("active"); // Usunięcie z nich klasy "active"
                $imgs
                    .hide() // Ukrycie obrazów
                    .filter(tagged[tagName]) // wyszukwanie obrazów wraz z danych tagiem
                    .show(); // wyświetlenie dopasowanych obrazów
            }
        }).appendTo($buttons); // Dodanie przycisku do istniejących

    });
}());



