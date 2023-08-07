
// \user\index.php - top-nav - get subcategories after hover on category name in categories list;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// najechanie na kategorię wyświetla listę podkategorii -->
// AJAX



let bookData = '<?php query("SELECT sb.nazwa, kt.nazwa FROM subkategorie AS sb, kategorie AS kt WHERE sb.id_kategorii = kt.id_kategorii", "getSubcategories", [$bookId, $_SESSION["warehouseId"]]); ?>';
// $_POST value is retrieved from admin\books.php -> "Edytuj" button (input type="submit");

//     nazwa sb	       nazwa kt
//  Programowanie	 Informatyka
//  Web development	 Informatyka
//  Dla dzieci	     Dla dzieci
//  Fantastyka	     Fantastyka
//  Horror	         Horror
//  Komiks	         Komiks
//  Kryminał	     Kryminał
//  Poezja	         Poezja

// 1 | Symfonia C++ wydanie V | 1 | 2009 | 10 | 2 | Lorem ipsum dolor sit amet, consectetur adipiscing... | twarda | 585	| 411 x 382 x 178 | 1 | 4

bookData = JSON.parse(bookData);
console.log("\nbookData -> ", bookData);






let listItems = document.querySelectorAll("#n-top-nav-content ol li ul#categories-list li"); // <li> items
console.log("\nlistItems -> ", listItems);


//document.querySelectorAll('form#update-order-date').addEventListener("submit", function(e) {



/*document.querySelectorAll('#n-top-nav-content ol li ul#categories-list li').addEventListener("mouseover", function(e) {

});*/

listItems.forEach((item) => {

    //console.log("\n item --> ", item, "\n");

    item.addEventListener("mouseenter", function() {  // po najechaniu na niego kursorem !
        //console.log("\n item --> ", item, "\n");

        //let data = item.querySelector('form > input[type="hidden"]').value;
        let data = DOMPurify.sanitize(item.querySelector('form > input[type="hidden"]').value);

        console.log("\n data --> ", data, "\n"); // nazwa kategorii (string);

        //////////////////////////////////////////////////////////////////////////////////
        // get sub-categories based on category name -->

        /*$.ajax({
            type: "POST",                    // GET or POST;
            url: "get-subcategories.php",      // Path to file (that process the <form> data);
            data: data,                      // category-name (string);
            timeout: 2000,                   // Waiting time;
            beforeSend: function () { // Before Ajax - function called before sending the request;
                //$("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) {
            // Success handler; // Handle the response data;

            /!*let booksHeader = document.querySelector('.admin-books'); // table header;
            if(booksHeader.style.display === 'none') {                // show table header (if was not-visible)
                booksHeader.style.display = "block";
            }
            $("#books-content").html(data); // show content (data returned from server) - books;*!/

            console.log("\n\n 52 - data (server) --> \n\n", data);

        }).fail(function(data) { // (xhr, status, error)
            /!*!// Error handler // Handle the error condition;
            $("#books-content").html(data); // data returned from server*!/

            console.log("\n\n 52 - data (server) --> \n\n", data);

        }).always(function() {
            //$("img#loading-icon").toggleClass("not-visible");
        });*/





    })

});


