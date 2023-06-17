
$min = $('#value-min');                          // minimum text input
$max = $('#value-max');                          // minimum text input

let books = document.querySelectorAll("#content-books .book");

console.log("\n fl books -> ", books);

function update(min, max) {                     // update content-books
    for(let i=0; i<books.length; i++) {

        let price = books[i].querySelector(".book-price").innerHTML;

        min = parseInt(min);
        max = parseInt(max);
        price = parseFloat(price);

        if((price >= min) && (price <= max)) {
            books[i].classList.remove('hidden');
        } else {
            books[i].classList.add('hidden');
        }
    }
}

function initFun() {                            // Tasks when script first runs
    $('#slider').noUiSlider({                   // Set up the slide control
        range: [5, 150], start: [15, 130], handles: 2, margin: 1, connect: true,
        serialization: {to: [$min, $max], resolution: 1}
    }).change(function() {
        update($min.val(), $max.val());
    });
    //makeRows();                               // Create table rows and rows array
    //appendRows();                             // Add the rows to the table
    update($min.val(), $max.val());             // Update content-books to show matches
}

$(initFun);                                     // Call init() when DOM is ready


$("#value-min, #value-max").change(function() {
    update($min.val(), $max.val());
});