
// admin/books.php;

$(document).ready(function() {
    $("form#change-magazine-form").submit();
});
$("select#change-magazine").on("change", function(e) {
    $("form#change-magazine-form").submit();
});

$("form#change-magazine-form").on("submit", function(event) {

    event.preventDefault();
    let data = $(this);
    const selectElement = data.find("select#change-magazine");
    const warehouseId = parseInt(selectElement.val());

    if((warehouseId > 0) && Number.isInteger(warehouseId) && !isNaN(warehouseId)) {

        let dataSerialized = data.serialize();

        $('div#admin-search-books-div > form#admin-search-books-form input[type="hidden"][name="change-magazine"]').val(warehouseId);

        // zamiana na użycie metod .done(), .fail(), always() - ponieważ success, error, complete - są przestarzałe (deprecated)

        $.ajax({
            type: "POST",                    // GET or POST;
            url: "change-magazine.php",      // Path to file (that process the <form> data);
            data: dataSerialized,                      // serialized <form> data;
            timeout: 2000,                   // Waiting time;
            beforeSend: function () {         // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) {      // Success handler; // Handle the response data;

            let booksHeader = document.querySelector('.admin-books'); // table header;

            if(booksHeader.style.display === 'none') {                // show table header (if was not-visible)
                booksHeader.style.display = "block";
            }

            $("#books-content").html(data); // show content (data returned from server) - books;

        }).fail(function(data) { // (xhr, status, error) // Error handler // Handle the error condition;

            $("#books-content").html(data); // data returned from server

        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible");
        });

    } else {  // błąd z id-magazynu;

        $("div.admin-books").css('display', 'none');
        $("div#books-content").html('<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>');
    }
});
