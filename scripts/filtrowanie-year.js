
// advanced-search ;

// year range - noUISlider (jQ) ;  // książka jQuery - strona 544 - 549;

(function() {

    $year_min = $('#year-min'); // input type number - input#year-min - minimum year value input;
    $year_max = $('#year-max'); // input type number - input#year-max - maximum year value input;

    function updateYear(min, max) {  // update content-books
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

    function initFun() {                             // Tasks when script first runs
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
    });

}());
