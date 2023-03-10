
// return sum of the widths of all elements of the collection; // koszyk.php

function getTotalWidth(elements) {
    let totalWidth = 0;
    for (let i = 0; i < elements.length; i++) {
        totalWidth += elements[i].offsetWidth;
    }
    return totalWidth;
}

function setSpanWidth() {

    // let elements = document.querySelectorAll("#book0 .title, #book0 .price, #book0 .year");
    let bookDivs = document.querySelectorAll('[id^="book"]'); // collection of divs --> "book0", "book1", ...

    max_width = 0;

    bookDivs.forEach(function(bookDiv) {   // loop through each bookDiv --> "book0", "book1", ...
        let divs = bookDiv.querySelectorAll('div');  // get all child divs of the current bookDiv --> ".title", ".price", ".year"
        let result = getTotalWidth(divs);
        if(result>max_width) {
            max_width = result;
        }
    });

    let span = document.querySelectorAll(".book-details");

    span.forEach(function(span) {   // loop through each bookDiv --> "book0", "book1", ...
        span.style.width = max_width + 28 + "px";
    });
}

setSpanWidth();