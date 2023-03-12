
// reset_password.php

function setSpanWidth() {
    // ten skrypt pobiera maksymalną szerokość spana na stronie, i ustawia szerokość każdego spana na tą wartość
    let spans = document.getElementsByTagName("span"); // you can change it to querySelectorAll
    console.log(spans);
    let max_width = 0;
    tab = [];
    for( let i=0; i<spans.length; i++){
        tab.push(spans.item(i).offsetWidth);
    }
    console.log(tab);
    max_width = Math.max(...tab);
    console.log("max ->", max_width);
    for( let i=0; i<spans.length; i++) {
        spans.item(i).style.width = max_width + "px";
        spans.item(i).style.display = "block";
        spans.item(i).style.float = "left";
    }
    //console.log(spans);
}
setSpanWidth();

function clear_result() {
    let result = document.getElementById("result");
    result.innerHTML = "";
}
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
