
// price range - noUISlider (jQ) ;  // książka jQuery - strona 544 - 549;

//(function() {

    $min = $('#value-min'); // input type number - input#value-min - minimum price value input;
    $max = $('#value-max'); // input type number - input#value-max - maximum price value input;

        /*console.log("\n#value-min --> ", $min);
        console.log("\n#value-max --> ", $max);*/

    //let books = document.querySelectorAll("#content-books .book:not(.hidden)");

    //let books = document.querySelectorAll("#content-books .outer-book"); // kolekcja elementów DOM (NodeList) - divy z książkami;



    function update(min, max) { // update content-books

        let books = document.querySelectorAll("#content-books .outer-book:not(.hidden-author)"); // kolekcja elementów DOM (NodeList) - divy z książkami;

        //let books = document.querySelectorAll("#content-books .book:not(.hidden-author)"); // kolekcja elementów DOM (NodeList) - divy z książkami;

        console.log("\n 17 books -> ", books);
        console.log("\n 17 typeof books -> ", typeof books);
        console.log("\n 17 books instanceof NodeList -> ", books instanceof NodeList); // true

        for(let i=0; i < books.length; i++) { // for every book <div>;

            let price = parseFloat(DOMPurify.sanitize(books[i].querySelector(".book .book-price").innerHTML)); // get the price of that book;

            min = parseInt(min); // min input-value from slider (number)
            max = parseInt(max); // max input-value from slider (number)
            //price = parseInt(price);

            /*console.log("\n price -> ", price);
            console.log("\n typeof price -> ", typeof price);*/

            if((price >= min) && (price <= max)) {   // add or remove "hidden" clsas;
                books[i].classList.remove('hidden');
            } else {
                books[i].classList.add('hidden');
            }
        }

        filterAuthors(); // wzajemna integracja filtrów - rozwiązanie;
    }

    function initFun() {                            // Tasks when script first runs
        $('#slider').noUiSlider({                   // Set up the slide control
            range: [5, 150], start: [10, 135], handles: 2, margin: 1, connect: true,
            serialization: { to: [$min, $max], resolution: 1 }
        }).change(function() {
            update($min.val(), $max.val());         // Update content-books every time after slider values change
        });
        //makeRows();                               // Create table rows and rows array
        //appendRows();                             // Add the rows to the table
        update($min.val(), $max.val());             // Update content-books at first load
    }

    $(initFun);                                     // Call init() when DOM is ready

    $("#value-min, #value-max").change(function() { // update content-book after input value will change
        update($min.val(), $max.val());
    });

//}());

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*(function() {
    // ... Twój istniejący kod do filtrowania według ceny ...

    // ... Twój istniejący kod do filtrowania według autorów ...

    // Wspólna funkcja do aktualizacji wyników filtrowania
    function updateResults() {
        let visibleBooks = document.querySelectorAll("#content-books .book:not(.hidden):not(.hidden-author)");
        for (let i = 0; i < visibleBooks.length; i++) {
            let bookAuthor = visibleBooks[i].querySelector(".book-author").textContent.trim();
            let bookPrice = parseFloat(visibleBooks[i].querySelector(".book-price").textContent);
            let authorVisible = false;
            let priceVisible = false;

            for (let j = 0; j < liChecked.length; j++) {
                if (bookAuthor === liChecked[j].value) {
                    authorVisible = true;
                    break;
                }
            }

            if (bookPrice >= min && bookPrice <= max) {
                priceVisible = true;
            }

            if (authorVisible && priceVisible) {
                visibleBooks[i].classList.remove('hidden');
            } else {
                visibleBooks[i].classList.add('hidden');
            }
        }
    }

    $('#value-min, #value-max, #ul-authors input[type="checkbox"]').change(function() {
        updateResults();
    });

    // Wczytaj stan z local storage po załadowaniu strony
    window.addEventListener("load", function() {
        if (window.localStorage) {
            let authors = JSON.parse(localStorage.getItem("authors"));
            let minPrice = parseFloat(localStorage.getItem("minPrice"));
            let maxPrice = parseFloat(localStorage.getItem("maxPrice"));

            if (authors) {
                for (let i = 0; i < li.length; i++) {
                    li[i].checked = authors.includes(li[i].value);
                }
                filterAuthors();
            }

            if (!isNaN(minPrice) && !isNaN(maxPrice)) {
                $('#slider').val([minPrice, maxPrice]);
                update($min.val(), $max.val());
            }
        }
    });

    // Zapisz stan do local storage po zmianach
    function saveState() {
        if (window.localStorage) {
            let authors = [];
            for (let i = 0; i < li.length; i++) {
                if (li[i].checked) {
                    authors.push(li[i].value);
                }
            }
            localStorage.setItem("authors", JSON.stringify(authors));
            localStorage.setItem("minPrice", min);
            localStorage.setItem("maxPrice", max);
        }
    }

    $('#slider').on('set', function() {
        saveState();
    });

    $('#filter-authors').on('click', function() {
        filterAuthors();
        saveState();
        updateResults();
    });
})();*/
