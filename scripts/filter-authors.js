
let btn = document.getElementById("filter-authors");
    // <button id="filter-authors"> Zastosuj </button>
btn.addEventListener("click", filterAuthors);

let all = document.querySelector('#ul-authors > li input[type="checkbox"][id="all-authors"]');
// <input type="checkbox" ... id="all-authors">

let li = document.querySelectorAll('#ul-authors > li input[type="checkbox"]:not(#all-authors)');
// NodeList of    ALL    <input checkbox> (authors);    // wszystkie checkboxy;

all.addEventListener("change", updateAll);

function updateAll() {
    for(let i=0; i<li.length; i++) { // tyle razy ile jest checkboxów z autorami
        li[i].checked = all.checked; // uaktualnienie właściwości checked
    }
}

function filterAuthors()  {

    const liCheckboxs = document.querySelectorAll('#ul-authors > li input[type="checkbox"]:checked:not(#all-authors)');
    // NodeList of <input checkbox CHECKED>

    // create array for author (name + surname) ->
    let items = Array.from(liCheckboxs); // CHECKED checkbox
    const authors = items.map(items => items.value.trim());
    console.log("authors ->", authors); // tablica z listą autorów (imie, nazwisko)

    console.log("items -> ",items);

   /* for (let i = 0; i < authors.length; i++) {
        console.log("author ->", authors[i]);
    }
*/
    // pokazanie tylko książek z dopasowanymi autorami ->
    let books = document.querySelectorAll("#content-books .book");

    for(let i=0; i<books.length; i++) {

        let bookAuthor = books[i].querySelector(".book-author").innerHTML;
        books[i].classList.add('hidden');
    }

    // pokaż tylko książki z tymi autorami, których wybrano w filtrach -->
    for(let i =0; i<authors.length; i++) {
        for(j=0; j<books.length; j++) {
            if(books[j].querySelector(".book-author").innerHTML === authors[i]) {
                books[j].classList.remove('hidden');
                break;
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

    console.log("liCheckboxs ->", liCheckboxs);
    //localStorage.setItem('selectedCheckboxes', JSON.stringify(liCheckboxs));

    /*// Add a change event listener to each checkbox
    liCheckboxs.forEach(function(checkbox) {
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

    function saveChx() {
        console.log(authors);
        console.log("typeof authors -> ", typeof(authors));
        //return localStorage.setItem('authors', authors);
        return localStorage.setItem("authors", JSON.stringify(authors));
    }
    saveChx();
}

/*let all = document.querySelector('#ul-authors > li input[type="checkbox"][id="all-authors"]'); // <input type="checkbox" ... id="all-authors">
all.addEventListener("change", filterAuthors);*/ // odkomentuj jeśli chcesz filtrować zaraz po klikięciu checkboxa
//let storedAuthors = JSON.parse(localStorage.getItem("authors"));

window.addEventListener("load", function()
{
    let authors = JSON.parse(localStorage.getItem("authors"));

    if (authors) {
        console.log("ls authors -> ", authors);
        console.log("ls authors.length -> ", authors.length);
        console.log("ls typeof(authors) -> ", typeof(authors));

        //filterAuthors();

        for(let i = 0; i<authors.length; i++) {
            for(j=0; j<li.length; j++) {
                if(li[j].value === authors[i]) {
                    li[j].checked = true;
                }
            }
        }

        filterAuthors();
    }
});
