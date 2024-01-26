
const searchArrow = document.getElementById("search-arrow"); x
const advancedSearchDiv = document.getElementById("advanced-search");

searchArrow.addEventListener("click", () => {
    advancedSearchDiv.classList.toggle("advanced-search-invisible");
    advancedSearchDiv.classList.toggle("advanced-search-visible");
});


