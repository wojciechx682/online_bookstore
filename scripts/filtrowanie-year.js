
$year_min = $('#year-min');                          // minimum text input
$year_max = $('#year-max');                          // minimum text input

//let books = document.querySelectorAll("#content-books .book");

function updateYear(min, max) {                     // update content-books
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

    console.log("min year -> ", min);
    console.log("max year -> ", max);
}

function initFun() {                            // Tasks when script first runs
    $('#adv-search-year-slider').noUiSlider({                   // Set up the slide control
        range: [1990, 2023], start: [1995, 2018], handles: 2, margin: 1, connect: true,
        serialization: {to: [$year_min, $year_max], resolution: 1}
    }).change(function() {
        updateYear($year_min.val(), $year_max.val());
    });
    //makeRows();                               // Create table rows and rows array
    //appendRows();                             // Add the rows to the table
    updateYear($year_min.val(), $year_max.val());             // Update content-books to show matches


}

$(initFun);                                     // Call init() when DOM is ready


$("#year-min, #year-max").change(function() {
    updateYear($year_min.val(), $year_max.val());
});

