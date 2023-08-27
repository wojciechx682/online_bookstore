
    <footer>
        <div id="footer">
                <!--<script src="../scripts/set-theme.js"></script>-->
                <!-- <button id="white" onclick="setWhiteTheme()">white</button><button id="black" onclick="setBlackTheme()">black</button>© 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us-->
                <!-- <button id="white" onclick="setWhiteTheme()">white</button>  <button id="black" onclick="setBlackTheme()">black</button> -->
            <pre>
                © 2023 Online Bookstore. All rights reserved. | Privacy Policy | Terms of Us
            </pre>
        </div>
    </footer>


<!-- jquery - NoUISlider ; -->

<!--<script src="../scripts/jquery.nouislider.js"></script>-->

    <script src="../node_modules/nouislider/dist/nouislider.js"></script>

    <!--<script src="../scripts/display-slider.js"></script>-->
    <script src="../scripts/filtrowanie-year.js"></script> <!-- advanced search -->
    <!--<script src="../scripts/set-span-width.js"></script>
    <script src="../scripts/set-span-width-v2.js"></script>-->
    <script src="../scripts/advanced-search.js"></script> <!-- advanced search div - toggle visibility -->


<script src="../scripts/filter-authors.js"></script> <!-- // filtering - <ul> author's list ; -->

    <script>
        /*let booksTest = document.querySelectorAll(".outer-book");
        console.log("\n\n\n (footer) - test - sprawdzenie stanu książek, \n\n books --> \n\n", booksTest, "\n\n")*/
    </script>




    <script src="../scripts/filtrowanie.js"></script> <!-- // filtering - CENA - price range ; -->

            <script src="../scripts/book-page-tabs.js"></script>

    <script src="../scripts/change-quantity.js"></script> <!-- koszyk.php -->

    <script>
       /* const tab2 = document.getElementById("tab-2-li");
        tab2.addEventListener("click", setSpanWidthv2);*/
    </script>

    <script src="../scripts/get-subcategories.js"></script> <!-- ajax - top-nav - get-subcategories -->

    <script>
        // set height of the <ul> (categories) list based on how many categories are there

        /*let liItems = document.querySelectorAll('#categories-list li');
        console.log("\n\n\n liczb kategori --> ", liItems.length);

        let categoryList = document.getElementById("categories-list")
        let height = liItems[0];
        let a = height
        //categoryList.style.setProperty("--ul-list-height", "yellow");
        console.log("\n\n height --> ", height)*/

        let liItems = document.querySelectorAll('#categories-list li');
        //console.log("\n\n Number of list items: ", liItems.length); // "9" - kategorii;

        let firstListItem = liItems[0];
        let height = firstListItem.offsetHeight; // 36
        //console.log("\n\n Height of the first list item: ", height, "px"); // "36 px";

        let ulListHeight = height * liItems.length; // 36 * 9 =  324    // "324"

        let categoryList = document.getElementById("categories-list");
        categoryList.style.setProperty("--ul-list-height", ulListHeight + "px");

        let secondList = document.getElementById("subcategories-list");
        secondList.style.top = "-"+ulListHeight+"px";
        secondList.style.minHeight = ulListHeight+"px";

        /*let books = document.querySelectorAll("#content-books .book:not(.hidden-author)"); // kolekcja elementów DOM (NodeList) - divy z książkami;
        console.log("\n 1046 books -> ", books);
        console.log("\n 1046 typeof books -> ", typeof books);
        console.log("\n 1046 books instanceof NodeList -> ", books instanceof NodeList); // true*/

        // -------------------------------------------------------------------------------------------------------------

        //window.addEventListener("load", () => {

            let content = document.querySelectorAll("#content-books .outer-book");

            if(content.length === 0) {

                let span = document.createElement("span");
                span.innerHTML = "Brak wyników";
                span.classList.add("main-page-search-result-error");

                document.getElementById("content-books").appendChild(span);

            }

        //});
    </script>





<script src="../scripts/sortowanie_v3_2.js"></script> <!-- books - sortowanie -->
