let people = [
    {
        name: "Adam",
        age: 31
    },
    {
        name: "Joe",
        age: 30
    },
    {
        name: "Steve",
        age: 32
    },
    {
        name: "Michael",
        age: 19
    },
    {
        name: "John",
        age: 9
    },
    {
        name: "Kevin",
        age: 75
    },
    {
        name: "Mike",
        age: 77
    },
    {
        name: "Paul",
        age: 89
    },
    {
        name: "Lenny",
        age: 57
    }
];

console.log("people ->", people);

// Wyświetlanie tablicy -->
function display(object) { // object - tablica obiektów
    for(let i=0; i<object.length; i++) {
        console.log(object[i].name + " " + object[i].age + " ");
    }
}

//display(people);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filtrowanie (za pomocą metod tablicy!) -->

function filter(object) {

    /*
        // Pierwsza wersja funkcji filtrującej - przyjmuje tablice obiektów, zwraca tablicę obiektów po przefiltrowaniu wg. wewnątrznego kryterium (np wiek >30, imie == "john" itp...)
        // object - tablica obiektów !
        // zakładamy że każdy obiekt ma te same właściwości (tzn moga miec rozne wartosci, ale kazdy obiekt reprezentuje "to samo" - np tablica osob - kazda wartosc tablicy jest obiektem, ale jest to inna osoba) !
        // tablica wynikowa, zawierające nowe, przefiltrowane dane
        // nazwy właściwości obiektu (zakładamy że każdy obiekt ma te same nazwy!)
     */

    let result = [];
    const key = Object.getOwnPropertyNames(object[0]);
    for(let i=0; i<object.length; i++) { // po długości tablicy ...
        propName = key[1]; // nazwa właściwości obiektu (wybbieramy ktora, zaleznie wg ktorej wlasciwosci chcemy filtrowac ...)
        if(object[i][propName] > 30) {
            result.push(object[i]);
        }
    }
    return result;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function filtertwo(object) {

    /*
        // druga wersja funkcji filtrującej - wykorzystuje .forEach(...)
        // object - tablica obiektów !
        // tablica wynikowa, zawierające nowe, przefiltrowane dane
     */

    let result = [];
    const key = Object.getOwnPropertyNames(object[0]);
    object.forEach(function(object){ // dla każdego obiektu ...
        if(object[key[1]] > 30){
            result.push(object);
        }
    });
    return result;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

let result = filter(people);
//console.log("results -->", result);

result = filtertwo(people);
//console.log("results -->", result);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// z użyciem funkcji .filter() -->
function filterthree(object) { // funkcja działa w charakterze filtru ...

    return (object["age"] > 30); // zwróć wartość true dla wskazaneog zakresu

}

result = (people.filter(filterthree)); // filtrowanie tablicy people, dopasowane osoby (obiekty) są umieszczane w tablicy result
//console.log("results -->", result);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Filtrowanie dynamiczne

    // filtrowanie zawartości strony (HTML),    przygotowanie kodu HTML zawartości, wyświetlenie go.

    // Korzystanie z filtrów przez użytkownika

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    var rows = [],                        // rows array
        $min = $('#value-min'),           // Minimum text input
        $max = $('#value-max'),           // Maximum text input
        $table = $('#rates');             // The table that shows results

    function makeRows() {                 // Create table rows and the array
        people.forEach(function(person) {   // For each person object in people
            var $row = $('<tr></tr>');        // Create a row for them
            $row.append( $('<td></td>').text(person.name) ); // Add their name
            $row.append( $('<td></td>').text(person.age) ); // Add their rate
            rows.push({ // Create rows array which links people objects to table rows
                person: person,                 // Reference to the person object
                $element: $row                  // Reference to row as jQuery selection
            });
        });

        //console.log(rows);
    }

    function appendRows() {               // Adds rows to the table
        var $tbody = $('<tbody></tbody>');  // Create <tbody> element
        rows.forEach(function(row) {        // For each object in the rows array
            $tbody.append(row.$element);      // Add the HTML for the row
        });
        $table.append($tbody);              // Add the rows to the table
    }

    function update(min, max) {           // Update the table content
        rows.forEach(function(row) {        // For each row in the rows array
            if (row.person.age >= min && row.person.age <= max) { // If in range
                row.$element.show();            // Show the row
            } else {                          // Otherwise
                row.$element.hide();            // Hide the row
            }
        });


    }

    function initFun() {                     // Tasks when script first runs
        $('#slider').noUiSlider({           // Set up the slide control
            range: [0, 150], start: [65, 90], handles: 2, margin: 20, connect: true,
            serialization: {to: [$min, $max],resolution: 1}
        }).change(function() { update($min.val(), $max.val()); });
        makeRows();                           // Create table rows and rows array
        appendRows();                         // Add the rows to the table
        update($min.val(), $max.val());     // Update table to show matches
    }

   $(initFun);                              // Call init() when DOM is ready

//$("#value-min").change(init);
//const el = document.getElementById("value-min");
// const el = $("#value-min");
// console.log("el-->", el.val());
// el.addEventListener("change", function() {
//                          // Add the rows to the table
//     update($min.val(), $max.val());
// });

$("#value-min, #value-max").change(function() {
    update($min.val(), $max.val());
})



