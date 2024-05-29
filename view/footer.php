
    <footer>
        <div id="footer">
            <pre>
                © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>
        </div>
    </footer>

    <script src="../node_modules/nouislider/dist/nouislider.js"></script>
    <script src="../scripts/filtrowanie-year.js"></script>
    <script src="../scripts/advanced-search.js"></script>
    <script src="../scripts/filter-authors.js"></script>
    <script src="../scripts/filtrowanie.js"></script>
    <script src="../scripts/book-page-tabs.js"></script>
    <script src="../scripts/change-quantity.js"></script>
    <script src="../scripts/get-subcategories.js"></script>
    <script>
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
    </script>
    <script src="../scripts/sortowanie_v3_2.js"></script> <!-- books - sortowanie -->
