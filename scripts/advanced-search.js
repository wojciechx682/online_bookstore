
const searchArrow = document.getElementById("search-arrow"); 
const advancedSearchDiv = document.getElementById("advanced-search");

searchArrow.addEventListener("click", () => {
    advancedSearchDiv.classList.toggle("advanced-search-invisible");
    advancedSearchDiv.classList.toggle("advanced-search-visible");
});


