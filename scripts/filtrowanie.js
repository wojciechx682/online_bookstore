
// price-range - noUISlider (jQ) ;  // książka jQuery - strona 544 - 549;

//(function() {

    let inputMin = document.getElementById('value-min'); // input type number - input#value-min - minimum price value input;
    let inputMax = document.getElementById('value-max'); // input type number - input#value-max - maximum price value input;

    function update(min, max) { // update content-books

        let books = document.querySelectorAll("#content-books .outer-book:not(.hidden-author)");
        // kolekcja elementów DOM (NodeList) - divy z książkami;

        console.log("\n 17 books -> ", books);
        console.log("\n 17 typeof books -> ", typeof books);
        console.log("\n 17 books instanceof NodeList -> ", books instanceof NodeList); // true

        for(let i=0; i < books.length; i++) { // for every book <div>;

            let price = parseFloat(DOMPurify.sanitize(books[i].querySelector(".book .book-price span").innerHTML));
            // get the price of that book;

            console.log("\n price --> ", price);

            min = parseInt(min); // min input-value from slider (number)
            max = parseInt(max); // max input-value from slider (number)

            if((price >= min) && (price <= max)) {   // add or remove "hidden" clsas;

                books[i].classList.remove('hidden');
            } else {

                books[i].classList.add('hidden');
            }
        }

        filterAuthors(); // wzajemna integracja filtrów - rozwiązanie;
    }

    let slider = document.getElementById('slider');

    noUiSlider.create(slider, {
        start: [17, 136],
        connect: true,
        margin: 15,
        padding: 0,
        step: 1,
        range: {
            'min': 5,
            'max': 150
        }
    });

    slider.noUiSlider.on('change', function (values, handle) {

        // values: Current slider values (array);
        // handle: Handle that caused the event (number);
        // unencoded: Slider values without formatting (array);
        // tap: Event was caused by the user tapping the slider (boolean);
        // positions: Left offset of the handles (array);
        // noUiSlider: slider public Api (noUiSlider);

        let value = values[handle];

        if (handle === 0) { // Pierwszy uchwyt odpowiada za wartość minimalną

            inputMin.value = Math.round(value);

        } else if (handle === 1) {  // Drugi uchwyt odpowiada za wartość maksymalną

            inputMax.value = Math.round(value);
        }

        update(values[0], values[1]);

    });

    inputMin.addEventListener('change', function () {
        slider.noUiSlider.set([this.value, null]);
    });

    inputMax.addEventListener('change', function () {
        slider.noUiSlider.set([null, this.value]);
    });

    let initialValues = slider.noUiSlider.get();  // set init values for inputs
    inputMin.value = Math.round(initialValues[0]);
    inputMax.value = Math.round(initialValues[1]);








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

// ------------------------------------------------------------------------------------
// events -->

// 'update',
// 'change',
// 'set',
// 'slide',
// 'drag'

// values - slider values



















