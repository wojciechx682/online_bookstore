
// \user\index.php - top-nav - get subcategories after hover on category name in categories list;
// najechanie na kategorię wyświetla listę podkategorii
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//  get list of all subcategories (object);

let subcategories;

    $.ajax({
        type: "GET",                    // GET or POST;
        url: "get-subcategories.php",   // Path to file (that process the <form> data);
        //data: data,                      // category-name (string);
        timeout: 2000,                   // Waiting time;
        beforeSend: function () { // Before Ajax - function called before sending the request;
            //$("img#loading-icon").toggleClass("not-visible"); // show loading animation;
        }
    }).done(function(data) {
        // Success handler; // Handle the response data;
        /*let booksHeader = document.querySelector('.admin-books'); // table header;
        if(booksHeader.style.display === 'none') {                // show table header (if was not-visible)
            booksHeader.style.display = "block";
        }
        $("#books-content").html(data); // show content (data returned from server) - books;*/
        console.log("\n\n 52 - data (sub-categories) -> \n", data);
        subcategories = data;
        //console.log("\n\n 52 - subcategories  --> \n\n", subcategories);
    }).fail(function(data) { // (xhr, status, error)
            /*!// Error handler // Handle the error condition;
            $("#books-content").html(data); // data returned from server*/
            //console.log("\n\n 52 - data (server) --> \n\n", data);
    }).always(function() {
            //$("img#loading-icon").toggleClass("not-visible");
    });

    console.log("\n subcategories ->  \n", subcategories);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// get all list elements (list items);

let listItems = document.querySelectorAll("#n-top-nav-content ol li ul#categories-list li"); // <li> items
console.log("\nlistItems -> ", listItems);

//document.querySelectorAll('form#update-order-date').addEventListener("submit", function(e) {
/*document.querySelectorAll('#n-top-nav-content ol li ul#categories-list li').addEventListener("mouseover", function(e) {
});*/

let firstLi = document.querySelector('ul#categories-list > li');
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);
console.log("\nfirstLi -> ", firstLi);


listItems.forEach((item) => { // for every listItem;    // usunąć kategorię "Wszystkie"

    //console.log("\n item --> ", item, "\n");

    item.addEventListener("mouseenter", function() {  // after hover on that listItem;  // po najechaniu na niego kursorem !
        //console.log("\n item --> ", item, "\n");
        //let data = item.querySelector('form > input[type="hidden"]').value;

        let subcategoryItems = document.querySelectorAll('ul#categories-list span.subcategory-item');
        subcategoryItems.forEach((item) => {
            item.remove();
        });


        let data = DOMPurify.sanitize(item.querySelector('form > input[type="hidden"]').value); // get name of the category (string) rom listItem;
            console.log("\n data --> ", data, "\n"); // nazwa kategorii (string);

        let result = []; // docelowe podkategorie należące do kategorii po najechaniu myszą;

        subcategories.forEach((subcategory) => { // for every subcategory (object)
            console.log("\n subcategory -> ", subcategory[1]);

            if(subcategory[2] === data) {  // if subcategory-name belongs to that category (data)

                //result.push(subcategory[1]); // add subcategory to new array;

                let span = document.createElement('span');
                    span.classList.add("subcategory-item");
                span.textContent = subcategory[1];

                let row = document.createElement('div');
                //row.classList.add("break-row");

                item.after(span);

                // echo '<span style="float: left;">abc</span>';
                // echo '<div style="clear: both;"></div>';



                result.push(span); // add element to the result array
            }
        })

        console.log("\n result -> ", result);
        //console.log("\n result -> ", result);

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

        for(let i = 0; i < result.length; i++) {
            console.log("\n result[", i, "] = ", result[i]);
        }

    })

});


for(let i = 0; i < result.length; i++) {
    console.log("\n result[", i, "] = ", result[i]);
}