let liItems = document.querySelectorAll('#categories-list li');
let firstListItem = liItems[0];
let height = firstListItem.offsetHeight;
let ulListHeight = height * liItems.length;
let categoryList = document.getElementById("categories-list");
categoryList.style.setProperty("--ul-list-height", ulListHeight + "px");
let secondList = document.getElementById("subcategories-list");
secondList.style.top = "-"+ulListHeight+"px";
secondList.style.minHeight = ulListHeight+"px";
let content = document.querySelectorAll("#content-books .outer-book");
if(content.length === 0) {
    let span = document.createElement("span");
    span.innerHTML = "Brak wyników";
    span.classList.add("main-page-search-result-error");
    document.getElementById("content-books").appendChild(span);
}