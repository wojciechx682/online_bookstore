
// return sum of the widths of all elements of the collection; // koszyk.php

// window.onload = function() {

    function getTotalWidth(elements) {
        let totalWidth = 0;
        for (let i = 0; i < elements.length; i++) {
            totalWidth += elements[i].offsetWidth;
        }
        return totalWidth;
    }

    function setSpanWidthv2() {
        // ten skrypt pobiera maksymalną szerokość spana na stronie, i ustawia szerokość każdego spana na tą wartość

        //let spans = document.getElementsByTagName("span"); // you can change it to querySelectorAll

        let spans = document.querySelectorAll("span.adv-search, span.book-details-tab"); // spany w wyszukiwaniu zaawansowanym
        console.log("spans ->", spans);




        // for( let i=0; i<spans.length; i++){
        //     console.log("span item -> ", spans.item(i).offsetWidth)
        //
        // }

        for (let i = 0; i < spans.length; i++) {
            const width = spans[i].offsetWidth;
            console.log(`Width of span ${i+1}: ${width}px`);
        }

        // sprawdzenie czy każdy span ma taką samą dlugość, jeśli tak, to nie zmieniamy ich wymiarów - ponieważ zadanie tego sałego skryptu jest spełnione !

        const firstSpanWidth = spans[0].offsetWidth;

        var theSameWidth = true;

        for (let i = 0; i < spans.length; i++) {
            const width = spans[i].offsetWidth;
            console.log(`Width of span ${i+1}: ${width}px`);

            if (width !== firstSpanWidth) {
                console.log("Spans do not have the same width");
                theSameWidth = false;
                break;
            }
        }

        //return;

        if(theSameWidth === false) {
            let max_width = 0;

            tab = [];
            for( let i=0; i<spans.length; i++){
                console.log("span item -> ", spans.item(i))
                tab.push(spans.item(i).offsetWidth);
            }
            console.log("tab -->", tab);
            //return;
            max_width = Math.max(...tab);
            console.log("max ->", max_width);
            for( let i=0; i<spans.length; i++) {
                spans.item(i).style.width = max_width + 10 + "px";
                spans.item(i).style.display = "block";
                spans.item(i).style.float = "left";
            }
        }



        //console.log(spans);
    }

    //setSpanWidth();

// }

// function clear_result() {
//     let result = document.getElementById("result");
//     result.innerHTML = "";
// }
/*function abcde() {
let result = document.getElementById("result");
if(result.innerHTML) {
clear_result();
}
}
/*(function test() {
let result = document.getElementById("result").innerHTML;
if(result != "") {
console.log(result); // display WITHOUT WHITESPACE;
result = "";
document.getElementById("result").innerHTML = result;
console.log(result);
}
}*/
