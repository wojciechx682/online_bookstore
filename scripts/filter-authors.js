
// filtering - <ul> author's list ;

/*(function() {*/

    let button = document.getElementById("filter-authors"); // <button id="filter-authors"> Zastosuj </button>
    let firstCheckbox = document.getElementById('all-authors'); // input type="checkbox" - "Wszyscy";
    // NodeList of    ALL    <input checkbox> (authors);    // wszystkie checkboxy;
    let items = document.querySelectorAll('#ul-authors input[type="checkbox"]:not(#all-authors)'); // input type="checkbox"

    button.addEventListener("click", filterAuthors);
    firstCheckbox.addEventListener("change", updateAll);

    function updateAll() { // wywołanie po kliknięciu inputa "Wszyscy"
        for(let i=0; i < items.length; i++) { // tyle razy ile jest checkboxów z autorami (poza inputem "Wszyscy")
            items[i].checked = firstCheckbox.checked;   // uaktualnienie właściwości checked zgodnie z tym jaką ma input "Wszyscy"
        }
    }

/*window.addEventListener("load", function() {
    if(window.localStorage) {
        let authors = JSON.parse(localStorage.getItem("authors"));
        if (authors) {
            /!*console.log("149 ls authors -> ", authors);
            console.log("150 ls authors.length -> ", authors.length);
            console.log("151 ls typeof(authors) -> ", typeof(authors));
            console.log("149 li -> ", li);*!/
            //filterAuthors();
            for(let i = 0; i < authors.length; i++) {
                for(let j = 0; j < li.length; j++) {
                    if(li[j].value === authors[i]) {
                        li[j].checked = true;
                    }
                }
            }
            filterAuthors();
        }
    }
});*/

function filterAuthors()  {

    const itemsChecked = document.querySelectorAll('#ul-authors input[type="checkbox"]:checked:not(#all-authors)');
    // NodeList of <input checkbox CHECKED ! >

    let items = Array.from(itemsChecked); // input type="checkbox" checked (!);
    /*console.log("\n43 items (all-inputs checked) => ", items);
    console.log("\n43 items[0] (all-inputs checked) => ", items[0]);
    console.log("\n43 typeof items[0] (all-inputs checked) => ", typeof items[0]);*/
                //console.log("\n43 typeof items (all-inputs checked) => ", typeof items);
    const authors = items.map(items => items.value.trim());
    console.log("\n 48 authors ->", authors);   // tablica (stringów) z listą autorów (imie, nazwisko); - (ZAZNACZONE CHECKBOXY !)
    console.log("\n 48 authors[0] ->", authors[0]);
    console.log("\n 48 typeof authors[0] ->", typeof authors[0]);
                                                // authors -> ['Jerzy Grębosz', 'Adam Nowak'];
            //console.log("\n 48 typeof authors ->", typeof authors);

            /*for (let i = 0; i < authors.length; i++) {
                console.log("author ->", authors[i]);
            }
            */

    // pokazanie tylko książek z dopasowanymi autorami ->
    //let books = document.querySelectorAll("#content-books .book");  // NodeList - kolekcja - divy z książkami ;
    let books = document.querySelectorAll("#content-books > .outer-book:not(.hidden)");  // NodeList - kolekcja - divy z książkami ;
    console.log("\n58 books => ", books);
    console.log("\n58 typeof books => ", typeof books); // object;

    //document.querySelectorAll("#content-books > .outer-book:not(.hidden)")

// (!) Ukrycie WSZYSTKICH książek -> dodanie klasy "hidden"
for(let i = 0; i< books.length; i++) {
    //let bookAuthor = books[i].querySelector(".book-author").innerHTML;
    books[i].classList.add('hidden-author');
}
    //console.log("\n 68 authors ->", authors);   // tablica z listą autorów (imie, nazwisko); - (ZAZNACZONE CHECKBOXY !)
    //console.log("\n 68 typeof authors ->", typeof authors);

    // pokaż tylko książki z tymi autorami, których wybrano w filtrach -->

    for(let i = 0; i < authors.length; i++) {  // tylko zaznaczeni autorzy (!) --> ['Jerzy Grębosz', 'Adam Nowak'];

        for(let j = 0 ; j < books.length; j++) {
            //console.log("\n\n 111 \n\n", books[j]);

            if(books[j].querySelector(".book-author").innerHTML === authors[i]) {
                books[j].classList.remove('hidden-author');
            }
        }
    }

            // Konwersja NodeList na tablicę -->
            /*let items = Array.from(li);
            const authors = items.map(items => items.textContent.trim());
            console.log(authors);
            console.log(authors[0]);
            console.log(typeof(authors));*/

            // zapisz wybranych autorów do LocalStorage -->

            //console.log("liChecked ->", liChecked);
            //localStorage.setItem('selectedCheckboxes', JSON.stringify(liChecked));

            /*// Add a change event listener to each checkbox
            liChecked.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {

                // Save the state of the checkboxes in localStorage
                let selectedCheckboxes = [];

                checkboxes.forEach(function(checkbox) {
                    //if (checkbox.checked) {
                        selectedCheckboxes.push(checkbox.value);
                    //}
                });

                localStorage.setItem('selectedCheckboxes', JSON.stringify(selectedCheckboxes));

                });
            });*/

            /*var main = document.forms[0];

            !(function(m) {
                var values = JSON.parse(localStorage.getItem('chx')) || [];
                values.forEach(function(val, idx) {
                    if (val === 1) {
                        m.elements[idx].setAttribute('checked', true);
                    }
                });
            })(main);*/

            //main.addEventListener('change', saveChx);

            /*function saveChx() {
                        //console.log(authors);
                        //console.log("typeof authors -> ", typeof(authors));
                        //return localStorage.setItem('authors', authors);
                return localStorage.setItem("authors", JSON.stringify(authors));
            }
            saveChx();*/

if(window.localStorage) {
    localStorage.setItem("authors", JSON.stringify(authors));
}

    /*$min = $('#value-min');
    $max = $('#value-max');

    console.log("\n min --> ", $min.val());
    console.log("\n max --> ", $max.val());*/

    //update($min, $max, true);
}




/*let all = document.querySelector('#ul-authors > li input[type="checkbox"][id="all-authors"]'); // <input type="checkbox" ... id="all-authors">
all.addEventListener("change", filterAuthors);*/ // odkomentuj jeśli chcesz filtrować zaraz po klikięciu checkboxa
//let storedAuthors = JSON.parse(localStorage.getItem("authors"));


/*window.addEventListener("load", function() {

    if(window.localStorage) {

        let authors = JSON.parse(localStorage.getItem("authors"));

        if (authors) {
            console.log("149 ls authors -> ", authors);
            console.log("150 ls authors.length -> ", authors.length);
            console.log("151 ls typeof(authors) -> ", typeof(authors));


            console.log("149 li -> ", li);


            //filterAuthors();

            for(let i = 0; i < authors.length; i++) {

                for(let j = 0; j < li.length; j++) {

                    if(li[j].value === authors[i]) {

                        li[j].checked = true;
                    }
                }
            }

            //

            filterAuthors();
        }
    }

    // filterAuthors();
});*/




/*if(window.localStorage) {

    let authors = JSON.parse(localStorage.getItem("authors"));

    if (authors) {
        console.log("149 ls authors -> ", authors);
        console.log("150 ls authors.length -> ", authors.length);
        console.log("151 ls typeof(authors) -> ", typeof(authors));


        console.log("149 li -> ", li);


        //filterAuthors();

        for(let i = 0; i < authors.length; i++) {

            for(let j = 0; j < li.length; j++) {

                if(li[j].value === authors[i]) {

                    li[j].checked = true;
                }
            }
        }


    }
}*/


/*
}());*/
