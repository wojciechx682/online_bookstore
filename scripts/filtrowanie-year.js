
let yearMin = document.getElementById("year-min");
let yearMax = document.getElementById("year-max");

let yearSlider = document.getElementById('adv-search-year-slider');

noUiSlider.create(yearSlider, {
    start: [1995, 2018],
    connect: true,
    margin: 5,
    padding: 1,
    step: 1,
    range: {
        'min': 1989,
        'max': 2024
    }
});

yearSlider.noUiSlider.on("update", function (values, handle) {

    // values: Current slider values (array);
    // handle: Handle that caused the event (number);
    // unencoded: Slider values without formatting (array);
    // tap: Event was caused by the user tapping the slider (boolean);
    // positions: Left offset of the handles (array);
    // noUiSlider: slider public Api (noUiSlider);

    let value = values[handle];

    if (handle === 0) {

        yearMin.value = Math.round(value);

    } else if (handle === 1) {

        yearMax.value = Math.round(value);
    }

});


yearMin.addEventListener("change", function () {
    yearSlider.noUiSlider.set([this.value, null]);
});

yearMax.addEventListener("change", function () {
    yearSlider.noUiSlider.set([null, this.value]);
});

let yearValues = yearSlider.noUiSlider.get();
yearMin.value = Math.round(yearValues[0]);
yearMax.value = Math.round(yearValues[1]);