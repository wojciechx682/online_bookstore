
// return sum of the widths of all elements of the collection

function getTotalWidth(elements) {

    let totalWidth = 0;
    for (let i = 0; i < elements.length; i++) {
        totalWidth += elements[i].offsetWidth;
    }
    return totalWidth;
}

function setSpanWidth() {

    let elements = document.querySelectorAll("#book0 .title, #book0 .price, #book0 .year");

    let bookDivs = document.querySelectorAll('[id^="book"]'); // collection of divs --> "book0", "book1", ...

    max_width = 0;

    bookDivs.forEach(function(bookDiv) {   // loop through each bookDiv --> "book0", "book1", ...
        let divs = bookDiv.querySelectorAll('div'); // get all child divs of the current bookDiv --> ".title", ".price", ".year"
        let result = getTotalWidth(divs);
        console.log("res", result);

        if(result>max_width) {
            max_width = result;
        }

        //console.log(result);
        // divs.forEach(function(div) { // --> ".title", ".price", ".year"
        //     // do something with each child div here
        //     console.log(div);
        // });
    });

    console.log("bookDivs -> ", bookDivs);
    console.log("max_width -> ", max_width);

    // Call function for each div
    // for (let i = 0; i < bookDivs.length; i++) {
    //     doSomething(bookDivs[i]);
    // }

    // let max_width = 0;
    // tab = [];
    // for( let i=0; i<spans.length; i++){
    //     tab.push(spans.item(i).offsetWidth);
    // }
    // console.log(tab);
    // max_width = Math.max(...tab);
    // console.log("max ->", max_width);
    // for( let i=0; i<spans.length; i++){
    //     spans.item(i).style.width = max_width + "px";
    // }
    // console.log(spans);

    let span = document.querySelectorAll(".book-details");
    console.log("span -> ", span);

    span.forEach(function(span) {   // loop through each bookDiv --> "book0", "book1", ...
        span.style.width = max_width + 28 + "px";
        console.log("hi");
    });
}
setSpanWidth();
