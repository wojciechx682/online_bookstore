
function getTotalWidth(elements) { // koszyk.php

    let totalWidth = 0;
    for (let i = 0; i < elements.length; i++) {
        totalWidth += elements[i].offsetWidth;
    }
    return totalWidth;
}

function setSpanWidth() {

    let bookDivs = document.querySelectorAll('[id^="book"]');

    console.log("book divs --> ", bookDivs);

    max_width = 0;

    bookDivs.forEach(function(bookDiv) {
        let divs = bookDiv.querySelectorAll('div');
        let result = getTotalWidth(divs);
        if(result>max_width) {
            max_width = result;
        }
    });

    let span = document.querySelectorAll(".book-details");

    span.forEach(function(span) {
        span.style.width = max_width + 28 + "px";
    });
}