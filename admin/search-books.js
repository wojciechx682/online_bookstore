
// admin/books.php; - input search (books);

$("form#admin-search-books-form").on("submit", function(e) { // after submitting form;

    e.preventDefault(); // prevent form submission (default behaviour);

    let data = $(this); // obiekt jQ - <form>;
    const bookTitle = DOMPurify.sanitize(data[0][0].value) // bookTitle - input type search;
    const warehouseId = parseInt(data[0][1].value); // get value attribute of <select> list - this is warehouse-id (id-magazynu);

        console.log("\ndata => ", data); // jQ object;
        console.log("\nbookTitle => ", bookTitle);
        console.log("\nwarehouseId => ", warehouseId); // object jq - warehouseId;
        console.log("\n typeof warehouseId => ", typeof warehouseId); // object jq - warehouseId;

    // walidacja czy przesłano poprawne id-magazynu i bookTitle -->

    if((warehouseId > 0) && Number.isInteger(warehouseId) && !isNaN(warehouseId) && bookTitle === data[0][0].value) {  // nie pusta (>0), liczba (int), nie jest to "NaN";

        let dataSerialized = data.serialize(); // serializacja danych formularza (id-magazynu);

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

        }).fail(function(data) { // (xhr, status, error)
            // Error handler // Handle the error condition;
            $("#books-content").html(data); // data returned from server

        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible");
        });

    } else {  // błąd z id-magazynu / bookTitle - nie przeszło walidacji;

        $("div.admin-books").css('display', 'none');
        $("div#books-content").html('<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>');
    }
});
