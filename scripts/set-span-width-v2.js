
function getTotalWidth(elements) { // koszyk.php
    let totalWidth = 0;
    for (let i = 0; i < elements.length; i++) {
        totalWidth += elements[i].offsetWidth;
    }
    return totalWidth;
}

function setSpanWidthv2() {

    let spans = document.querySelectorAll("span.adv-search, span.book-details-tab");

    for (let i = 0; i < spans.length; i++) {
        const width = spans[i].offsetWidth;
        console.log(`Width of span ${i+1}: ${width}px`);
    }

    const firstSpanWidth = spans[0].offsetWidth;

    var theSameWidth = true;

    for (let i = 0; i < spans.length; i++) {
        const width = spans[i].offsetWidth;

        if (width !== firstSpanWidth) {

            theSameWidth = false;
            break;
        }
    }

    if(theSameWidth === false) {
        let max_width = 0;

        tab = [];
        for( let i=0; i<spans.length; i++){

            tab.push(spans.item(i).offsetWidth);
        }


        max_width = Math.max(...tab);

        for( let i=0; i<spans.length; i++) {
            spans.item(i).style.width = max_width + 10 + "px";
            spans.item(i).style.display = "block";
            spans.item(i).style.float = "left";
        }
    }




}


