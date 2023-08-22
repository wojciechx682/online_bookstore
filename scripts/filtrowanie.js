
let inputMin = document.getElementById('min-price');
let inputMax = document.getElementById('max-price');
let slider = document.getElementById('price-slider');

const filterBooks = (min, max, flag) => { // funkcja filtrująca książki na podstawie przedziału cenowego.
                                    // Arrow Function Expression

    let books = document.querySelectorAll("#content-books .outer-book:not(.hidden-author)"); // NodeList;

        console.log("\n books -> ", books);
        console.log("\n typeof books -> ", typeof books);
        console.log("\n books instanceof NodeList -> ", books instanceof NodeList);

    min = parseInt(min); // convert values to Int;
    max = parseInt(max);

        console.log("\n min -> ", min);
        console.log("\n max -> ", max);

    for (let i = 0; i < books.length; i++) {

        let price = parseFloat(DOMPurify.sanitize(books[i].querySelector(".book .book-price span").innerHTML));
        // sanitize values,
        // convert values to Float;

        if(price >= min && price <= max) {

            books[i].classList.remove('hidden');

        } else {

            books[i].classList.add('hidden');
        }
    }

    filterAuthors(); // wzajemna integracja filtrów - rozwiązanie;
}

noUiSlider.create(slider, { // create new slider using NoUISlider library
    start: [17, 136],
    connect: true,
    margin: 15,
    padding: [0, 3],
    step: 1,
    range: {
        'min': 5,
        'max': 148
    }
});

slider.noUiSlider.on('change', function (values, handle) {

    // execute function after changing price range on slider

    // values: Current slider values (array);
    // handle: Handle that caused the event (number);
    // unencoded: Slider values without formatting (array);
    // tap: Event was caused by the user tapping the slider (boolean);
    // positions: Left offset of the handles (array);
    // noUiSlider: slider public Api (noUiSlider);

    if (handle) {

        inputMax.value = Math.round(values[handle]);

    } else {

        inputMin.value = Math.round(values[handle]);
    }

    filterBooks(values[0], values[1]);

});



inputMin.addEventListener('change', function () {
    slider.noUiSlider.set([this.value, null]);
        let currentValues = slider.noUiSlider.get();
        filterBooks(currentValues[0], currentValues[1]);
});

inputMax.addEventListener('change', function () {
    slider.noUiSlider.set([null, this.value]);
        let currentValues = slider.noUiSlider.get();
        filterBooks(currentValues[0], currentValues[1]);

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



















