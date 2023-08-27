
// Kod JavaScript umożliwia użytkownikowi filtrowanie książek na podstawie autorów za pomocą checkboxów.
// Jeśli użytkownik zaznaczy niektóre checkboxy i kliknie "Zastosuj", tylko książki tych autorów będą widoczne.
// Checkbox "Wszyscy" pozwala na zaznaczenie lub odznaczenie wszystkich checkboxów.

let button = document.getElementById("filter-authors");
let firstCheckbox = document.getElementById("all-authors");
let items = document.querySelectorAll('#ul-authors input[type="checkbox"]:not(#all-authors)');

/*console.log("\n\n(filter-authors.js) - button --> ", button);
console.log("\n\n(filter-authors.js) - firstCheckbox --> ", firstCheckbox);
console.log("\n\n(filter-authors.js) - items --> \n", items);*/

const updateAll = () => {
    /*for (let i = 0; i < items.length; i++) {
        items[i].checked = firstCheckbox.checked;
    }*/
    items.forEach(item => {
        item.checked = firstCheckbox.checked;
    });
}

window.addEventListener("load", function() {

    if(window.sessionStorage) {

        let authors = JSON.parse(sessionStorage.getItem("authors")); // pobierz listę autorów z sessionStorage;

        if (authors) {
                /*console.log("149 ls authors -> ", authors);
                console.log("150 ls authors.length -> ", authors.length);
                console.log("151 ls typeof(authors) -> ", typeof(authors));
                console.log("149 li -> ", li);*/
                //filterAuthors();

            for (let i = 0; i < authors.length; i++) {
                for (let j = 0; j < items.length; j++) {
                    if (items[j].value === authors[i]) {
                        items[j].checked = true;
                    }
                }
            }
            filterAuthors();
        }
    }
});

const filterAuthors = () => {

    /*const checked = document.querySelectorAll('#ul-authors input[type="checkbox"]:checked:not(#all-authors)'); // NodeList - of <input> checkbox - CHECKED
    const items = Array.from(checked); // Array - <input> type="checkbox" - checked
    const authors = items.map(items => items.value.trim());*/

    //console.log("\n authors ->", authors);   // tablica (stringów) z listą autorów (imie, nazwisko); - (ZAZNACZONE CHECKBOXY !)
    //console.log("\n typeof authors ->", typeof authors);   // tablica (stringów) z listą autorów (imie, nazwisko); - (ZAZNACZONE CHECKBOXY !)
                                                           // authors -> ['Jerzy Grębosz', 'Adam Nowak'];

    /*$min = $('#value-min');
    $max = $('#value-max');

    console.log("\n min --> ", $min.val());
    console.log("\n max --> ", $max.val());

    filterBooks($min, $max, false);*/


    const checkedAuthors = Array.from(
        document.querySelectorAll('#ul-authors input[type="checkbox"]:checked:not(#all-authors)')
    ).map(item => item.value.trim());

    //console.log("\n authors ->", checkedAuthors);

        // pokazanie tylko książek z dopasowanymi autorami ->
        //let books = document.querySelectorAll("#content-books .book");  // NodeList - kolekcja - divy z książkami ;
    let books = document.querySelectorAll("#content-books > .outer-book:not(.hidden)");  // NodeList - kolekcja - divy z książkami ;

/*console.log("\n\n (filter-authors.js) - books -> \n", books);
console.log("\n(filter-authors.js) - typeof books => ", typeof books); // object;*/

/*  for (let i = 0; i < books.length; i++) {
        //let bookAuthor = books[i].querySelector(".book-author").innerHTML;
        books[i].classList.add('hidden-author');
    }

    for(let i = 0; i < checkedAuthors.length; i++) {  // tylko zaznaczeni autorzy (!) --> ['Jerzy Grębosz', 'Adam Nowak'];

        for(let j = 0 ; j < books.length; j++) {
            //console.log("\n\n 111 \n\n", books[j]);

            if(books[j].querySelector(".book-author").innerHTML === checkedAuthors[i]) {
                books[j].classList.remove('hidden-author');
            }
        }
    } */

    let minValue = parseInt(document.getElementById("min-price").value);
    let maxValue = parseInt(document.getElementById("max-price").value);

    books.forEach(book => {

        const bookAuthor = book.querySelector(".book-author").innerHTML;
        const bookPrice = parseFloat(DOMPurify.sanitize(book.querySelector(".book .book-price").innerHTML));

        if ( checkedAuthors.includes(bookAuthor) &&
             (bookPrice >= minValue) && (bookPrice <= maxValue) ) {

            book.classList.remove("hidden-author");

            /*console.log("\n\n\n bookPrice --> ", bookPrice);
            console.log("\n\n min-value --> ", minValue);
            console.log("\n\n max-value --> ", maxValue);*/

        } else {

            book.classList.add("hidden-author");
        }
    });

    console.log("\n\n(filter-authors.js) - books -> \n", books);

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

    // zapisz listę autorów do sessionStorage;
    if(window.sessionStorage) {
        sessionStorage.setItem("authors", JSON.stringify(checkedAuthors));
    }

}

button.addEventListener("click", filterAuthors);

firstCheckbox.addEventListener("change", updateAll);

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
