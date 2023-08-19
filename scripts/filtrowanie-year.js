
// advanced-search ;

// year range - noUISlider (jQ) ;  // książka jQuery - strona 544 - 549;

//(function() {

    //$year_min = $('#year-min'); // input type number - input#year-min - minimum year value input;
    //$year_max = $('#year-max'); // input type number - input#year-max - maximum year value input;

    let yearMin = document.getElementById('year-min');
    let yearMax = document.getElementById('year-max');

    function updateYear(min, max) {
        // for(let i=0; i<books.length; i++) {
        //
        //     let price = books[i].querySelector(".book-price").innerHTML;
        //
        //     min = parseInt(min);
        //     max = parseInt(max);
        //     price = parseFloat(price);
        //
        //     if((price >= min) && (price <= max)) {
        //         books[i].classList.remove('hidden');
        //     } else {
        //         books[i].classList.add('hidden');
        //     }
        // }

    /*console.log("min year -> ", min);
    console.log("max year -> ", max);*/
    }

    /*function initFun() {                             // Tasks when script first runs
        $('#adv-search-year-slider').noUiSlider({    // Set up the slide control
            range: [1990, 2023], start: [1992, 2018], handles: 2, margin: 1, connect: true,
            serialization: { to: [$year_min, $year_max], resolution: 1 }
        }).change(function () {
            updateYear($year_min.val(), $year_max.val()); // update every time after slider values change;
        });
        //makeRows();                                 // Create table rows and rows array
        //appendRows();                               // Add the rows to the table
        updateYear($year_min.val(), $year_max.val()); // Update slider on first load;
    }

    $(initFun);                                     // Call init() when DOM is ready


    $("#year-min, #year-max").change(function () {  // update slider values after changing input type number values;
        updateYear($year_min.val(), $year_max.val());
    });*/

let yearSlider = document.getElementById('adv-search-year-slider');

noUiSlider.create(yearSlider, {
    start: [1994, 2018],
    connect: true,
    /*margin: 15,
    padding: 0,
    step: 1,*/
    padding: 1,
    step: 1,
    range: {
        'min': 1990,
        'max': 2023
    }
});

yearSlider.noUiSlider.on('update', function (values, handle) {

    // values: Current slider values (array);
    // handle: Handle that caused the event (number);
    // unencoded: Slider values without formatting (array);
    // tap: Event was caused by the user tapping the slider (boolean);
    // positions: Left offset of the handles (array);
    // noUiSlider: slider public Api (noUiSlider);

    let value = values[handle];

    if (handle === 0) { // Pierwszy uchwyt odpowiada za wartość minimalną

        yearMin.value = Math.round(value);

    } else if (handle === 1) {  // Drugi uchwyt odpowiada za wartość maksymalną

        yearMax.value = Math.round(value);
    }

    //update(values[0], values[1]);

});






yearMin.addEventListener('change', function () {
    yearSlider.noUiSlider.set([this.value, null]);
});

yearMax.addEventListener('change', function () {
    yearSlider.noUiSlider.set([null, this.value]);
});

let yearValues = yearSlider.noUiSlider.get();  // set init values for inputs
yearMin.value = Math.round(yearValues[0]);
yearMax.value = Math.round(yearValues[1]);


//}());
