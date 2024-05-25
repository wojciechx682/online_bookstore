
let inputMin = document.getElementById('min-price');
let inputMax = document.getElementById('max-price');
let slider = document.getElementById('price-slider');

const filterBooks = (min, max) => {

    let books = document.querySelectorAll("#content-books .outer-book:not(.hidden-author)");

    min = parseInt(min);
    max = parseInt(max);

    for (let i = 0; i < books.length; i++) {

        let price = parseFloat(DOMPurify.sanitize(books[i].querySelector(".book .book-price").innerHTML));

        if(price >= min && price <= max) {

            books[i].classList.remove('hidden');

        } else {

            books[i].classList.add('hidden');
        }
    }

    if(window.sessionStorage) {
        sessionStorage.setItem("sliderMinValue", min);
        sessionStorage.setItem("sliderMaxValue", max);
    }

    filterAuthors(); // wzajemna integracja filtrów - rozwiązanie;
}

noUiSlider.create(slider, {
    start: [5, 145],
    connect: true,
    margin: 15,
    padding: [0, 3],
    step: 1,
    range: {
        'min': 5,
        'max': 148
    }
});

slider.noUiSlider.on("change", function (values, handle) {

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


if(window.sessionStorage) {
    let sliderMinValue = sessionStorage.getItem("sliderMinValue");
    let sliderMaxValue = sessionStorage.getItem("sliderMaxValue");

    if (sliderMinValue !== null && sliderMaxValue !== null) {
        slider.noUiSlider.set([sliderMinValue, sliderMaxValue]);
    }
}

let initialValues = slider.noUiSlider.get();
inputMin.value = Math.round(initialValues[0]);
inputMax.value = Math.round(initialValues[1]);
