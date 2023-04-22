
// display advanced-search div after clicking arrow near input-search

// advanced-search <div>
// search-arrow <img>

const searchArrow = document.getElementById("search-arrow"); // <img> arrow
const advancedSearchDiv = document.getElementById("advanced-search"); // advanced-search <div>

searchArrow.addEventListener("click", () => {

    advancedSearchDiv.classList.toggle("advanced-search-invisible");
    advancedSearchDiv.classList.toggle("advanced-search-visible");

    /*if (advancedSearchDiv.classList.contains("advanced-search-visible")) {
        setSpanWidthv2();
    }*/
});


function displaySearchError() {

    // el = document.getElementById("advanced-search-error");
    // el.innerHTML = "Podaj poprawne dane";
    //
    // advancedSearchDiv.classList.toggle("advanced-search-visible");
    // if(advancedSearchDiv.classList.contains("advanced-search-visible")) {
    //     setSpanWidthv2();
    // }

}

