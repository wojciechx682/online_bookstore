
// admin/books.php;

$(document).ready(function() {               // after page load/reload - send <form>;

    //$("form#change-magazine-form").submit(); // submit the <form>;
    $("form#change-magazine-form").submit(); // submit the <form>;
});

$("select#change-magazine").on("change", function(e) { // after changing <option> element in <select> list;

    $("form#change-magazine-form").submit(); // submit the <form>;
});

$("form#change-magazine-form").on("submit", function(e) { // after submitting form;

    e.preventDefault(); // prevent form submission (default behaviour)

        //let data = $(this).serialize(); // dane formularza do przesłania metodą post; // let data = $(this);
        //let postData = parseInt($(this).serialize().slice(16).trim()); // "change-magazine=1" => "1" (id_maazynu);

    let data = $(this); // obiekt jQ - <form>;
    const selectElement = data.find('select#change-magazine'); // find <select> list inside the <form>;
    const warehouseId = parseInt(selectElement.val()); // get value attribute of <select> list - this is warehouse-id (id-magazynu);

    console.log("\ndata => ", data); // jQ object;
console.log("\ndata val => ", data[0][0].value); // jQ object;
    console.log("\ntypeof(data) =>", typeof(data));
    console.log("\nselectElement => ", selectElement); // object jq - <select>;
    console.log("\ntypeof selectElement => ", typeof selectElement); // object jq - <select>;
    console.log("\nwarehouseId => ", warehouseId); // object jq - warehouseId;
    console.log("\n typeof warehouseId => ", typeof warehouseId); // object jq - warehouseId;


    //console.log("\npost_data (id_magazynu) =>", postData); // atrybut value elementu <option> (jest to id_magazynu);
    //console.log("\ntypeof(post data) (id_magazynu) =>", typeof(postData)); // number;

    //if((data !== '') && (typeof(postData) === 'number') && (!isNaN(postData))) { // nie pusta, liczba, nie jest to "NaN";

    // !isNaN(warehouseId) && Number.isInteger(parseFloat(warehouseId)) && parseInt(warehouseId) > 0\

    console.log("\n\n warehouseId > 0 --> ", warehouseId > 0);
    console.log("\n\n Number.isInteger(warehouseId) --> ", Number.isInteger(warehouseId));
    console.log("\n\n !isNaN(warehouseId) --> ", !isNaN(warehouseId));

    // walidacja czy przesłano poprawne id-magazynu -->

    if((warehouseId > 0) && Number.isInteger(warehouseId) && !isNaN(warehouseId)) {  // nie pusta (>0), liczba (int), nie jest to "NaN";

        let dataSerialized = data.serialize(); // serializacja danych formularza (id-magazynu);

        console.log("\n\n\ndataSerialized --> \n\n\n", dataSerialized, "\n\n\n");

        //$('div#admin-search-books-div > form#admin-search-books-form input[type="hidden"][name="change-magazine"]').val(warehouseId);

        $('div#admin-search-books-div > form#admin-search-books-form input[type="hidden"][name="change-magazine"]').val(warehouseId); // set warehouseId for input type hidden in admin-search-book form in \admin.books.php


        /*$.ajax({
            type: "POST",                    // GET or POST;
            url: "change-magazine.php",      // Path to file (that process the <form> data);
            data: dataSerialized,                      // serialized <form> data;
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {         // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            },
            complete: function() {           // Once finished - function called always after sending request;
                $("img#loading-icon").toggleClass("not-visible");
            },
            success: function(data) {        // Show content;
                let booksHeader = document.querySelector('.admin-books'); // table header;
                if(booksHeader.style.display === 'none') {
                    booksHeader.style.display = "block";
                }
                $("#books-content").html(data); // Show content (data returned from server);
            },
            error: function(data) {          // Show error msg
                    // cal$content.html('<div id="container">Please try again soon.</div>');
                // (!) Error - obsługa błędów;
                $("#books-content").html(data);
            }
        });*/

        // zamiana na użycie metod .done(), .fail(), always() - ponieważ success, error, complete - są przestarzałe (deprecated) -->

        $.ajax({
            type: "POST",                    // GET or POST;
            url: "change-magazine.php",      // Path to file (that process the <form> data);
            data: dataSerialized,                      // serialized <form> data;
            timeout: 2000,                   // Waiting time;
            beforeSend: function () {         // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) {
            // Success handler; // Handle the response data;

            let booksHeader = document.querySelector('.admin-books'); // table header;
            if(booksHeader.style.display === 'none') {                // show table header (if was not-visible)
                booksHeader.style.display = "block";
            }
            $("#books-content").html(data); // show content (data returned from server) - books;

            // --------------------------------------------------------------------------------

            //window.addEventListener("load", () => {

                let isAscending = true;

                let orderRows = Array.from(document.querySelectorAll(".admin-books-content")); // wiersze z zamówieniami (rows)

                let headers = Array.from(document.querySelectorAll('[data-sort]'));

                headers.forEach(header => {
                    header.addEventListener("click", function() {
                        let sortOrder = this.dataset.sort;

                        orderRows.sort((a, b) => {
                            let valueA = $(a).find(`.${header.classList[0]}`).text().trim();
                            let valueB = $(b).find(`.${header.classList[0]}`).text().trim();

                            switch(sortOrder) {
                                case "string":
                                    valueA = valueA.toLowerCase();
                                    valueB = valueB.toLowerCase();
                                    return isAscending ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
                                case "number":
                                    return isAscending ? valueA - valueB : valueB - valueA;
                                case "date":
                                    return isAscending ? new Date(valueA) - new Date(valueB) : new Date(valueB) - new Date(valueA);
                                case "currency":
                                    valueA = parseFloat(valueA.replace(' PLN', ''));
                                    valueB = parseFloat(valueB.replace(' PLN', ''));
                                    return isAscending ? valueA - valueB : valueB - valueA;
                                default:
                                    return 0;
                            }
                        });

                        isAscending = !isAscending;

                        $('.admin-books-content').remove();
                        $(orderRows).insertAfter($('.admin-books').last());
                    });
                });
            //});


            // --------------------------------------------------------------------------------

        }).fail(function(data) { // (xhr, status, error)
            // Error handler // Handle the error condition;
            $("#books-content").html(data); // data returned from server

        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible");
        });

    } else {  // błąd z id-magazynu;

        $("div.admin-books").css('display', 'none');
        $("div#books-content").html('<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>');
    }
});
