
// admin/edit-books.php;

function getSubcategories(categorySelect) {      // categorySelect --> <select> element (kategoria);

        // returns subcategories for given category (category-id);

        // <select id="edit-book-category"
        //             name="edit-book-category"
        //  ! ---> onchange="getSubcategories(this)">
                // <option value={id-kategorii} > "28"
                // <option value={id-kategorii} > "34"
                // <option value={id-kategorii} > "26"

    // <select id="add-book-category" name="add-book-category"
    //
    // 		onchange="getSubcategories(this)">
    //
    // 	        <option value="1">Dla dzieci</option>
    // 	        <option value="2">Fantastyka</option>
    // 	        <option value="3">Horror</option>
    // 	        <option value="4">Informatyka</option>
    // 	        <option value="5">Komiks</option>
    // 	        <option value="6">Kryminał</option>
    // 	        <option value="7">Poezja</option>
    // </select>

        //let categoryId = document.getElementById('edit-book-category').value;
    let categoryId = categorySelect.value;
    // "2" - string; - (!) id_kategorii;

    // create XMLHttpRequest Object ; --> wysyłanie żądań AJAX  +  obsługa odpowiedzi ;
    // meotdy -->   .open()
    //              .send()

    console.log("\n\n categoryId --> ", categoryId);
    console.log("\n\n typeof categoryId --> ", typeof categoryId);

    //return;

    // send an AJAX request to fetch the subcategories based on the selected category;

    let xhr = new XMLHttpRequest(); // create XMLHttpRequest object, store it in "xhr" variable;

    xhr.onreadystatechange = function() {           // xhr.onload = function(); - otrzymanie i wczytanie odpowiedzi z serwera;
                                                    //              wywołanie funkcji anonimowej;

    // po zmianie właściwośći "readyState" obiektu XMLHttpRequest ;

        // "xhr.onreadystatechange" - This event handler is triggered whenever the "readyState" property of the XMLHttpRequest object changes.
        // The "readyState" property represents the current state of the request

            // "readyState" - (property) - possible values :
                // 0: UNSENT - The request has not been initialized.
                // 1: OPENED - The request has been set up (the open() method has been called).
                // 2: HEADERS_RECEIVED - The request has been sent, and the headers and status are available.
                // 3: LOADING - The response is being received (usually some data is being transferred).
                // 4: DONE - The operation is complete.

        if (xhr.readyState === XMLHttpRequest.DONE) { // "DONE" == 4 - Complete (request)

            if (xhr.status === 200) {              // after response from server, if response is correct;

                // sprawdzenie właściwości "status" obiektu xhr - w celu sprawdzenia, czy odpowiedź otrzymana z serwera jest prawidłowa - 200 OK) ;

                // Poniżej kod odpowiedzialny za Przetworzenie odpowiedzi - udzielonej przez serwer ;

                let subcategories = JSON.parse(xhr.responseText); // object

                    console.log("\nxhr.responseText -> \n", xhr.responseText, "\n");
                    console.log("\nsubcategories -> \n", subcategories, "\n");

                // update the subcategories select list;

                    //let subcategorySelect = document.getElementById('edit-book-subcategory');
                let subcategorySelect = document.getElementById('book-subcategory'); // <select> list (POD-kategorie)
                subcategorySelect.innerHTML = ''; // clear previous options

                for (let i = 0; i < subcategories.length; i++) { // for every sub-category (every element in object);
                    let option = document.createElement('option');
                    option.value = subcategories[i].id; // object - id pod-kategorii;
                    option.textContent = subcategories[i].name; // nazwa pod-kategorii;
                    subcategorySelect.appendChild(option);
                }
            } else {
                console.error('Error: ', xhr.status);
            }
        }
    };

    xhr.open('GET', 'get-subcategories.php?category_id=' + categoryId, true);
        // przygotowanie Żądania (Ajax);
        //           adres strony Obsługującej żądanie;                async ? (true/false)
        //    nazwa metody HTTP
    xhr.send();
        // wysłanie do serwera przygotowanego wcześniej Żądania; (informacje dodatkowe w nawiasach);
}

$("form.edit-book-data").on("submit", function(e) {

    e.preventDefault(); // prevent default <form> action which is submitted;

    let data = $(this); // jQ object that holds <form> data;
        // let postData = $(this).serialize(); // serialized <form> data;
    let formData = new FormData(this); // Create a new FormData object
    // need to use the FormData object to send the form data, including the image file.
    let result = document.querySelector('div.result');

    /*console.log("\n46 data -> ", data);
    console.log("\n46 typeof data -> ", typeof data);
    console.log("\n46 formData -> ", formData);
    console.log("\n46 typeof formData -> ", typeof formData);*/

    // front-end validation;

    let bookTitle = DOMPurify.sanitize(data[0][0].value);
    let bookAuthor = DOMPurify.sanitize(data[0][1].value); // id_autora / number / input#edit-book-title;
    let bookYear = DOMPurify.sanitize(data[0][2].value); // rok_wyd / number / input#edit-book-release-year;
    let bookPrice = DOMPurify.sanitize(data[0][3].value); // cena / number / input#edit-book-price;
    let publisher = DOMPurify.sanitize(data[0][4].value); // cena / number / input#edit-book-price;
    let bookImage = DOMPurify.sanitize(data[0][5].value); // image_url / file / input#edit-book-image;
    let bookDesc = DOMPurify.sanitize(data[0][6].value); // opis / text / input#edit-book-desc;
    let bookCover = DOMPurify.sanitize(data[0][7].value); // oprawa / text / select#edit-book-cover;
    let bookPages = DOMPurify.sanitize(data[0][8].value); // ilosc_stron / number / input#edit-book-pages;
    let bookDims = DOMPurify.sanitize(data[0][9].value); // cena / number / inputedit-book-dims;
    let bookCat = DOMPurify.sanitize(data[0][10].value); // kategoria / number / select#edit-book-category;
    let bookSubcat = DOMPurify.sanitize(data[0][11].value); // podkategoria / number / select#edit-book-subcategory;
    let bookId = DOMPurify.sanitize(data[0][12].value); // id_ksiazki / number / input#edit-book-id

        console.log("\nbookTitle -> ", bookTitle);
        console.log("\nbookAuthor -> ", bookAuthor);
        console.log("\nbookYear -> ", bookYear);
        console.log("\nbookPrice -> ", bookPrice);
        console.log("\npublisher -> ", publisher);
        console.log("\nbookImage -> ", bookImage);
        console.log("\nbookDesc -> ", bookDesc);
        console.log("\nbookCover -> ", bookCover);
        console.log("\nbookPages -> ", bookPages);
        console.log("\nbookDims -> ", bookDims);
        console.log("\nbookCat -> ", bookCat);
        console.log("\nbookSubcat -> ", bookSubcat);
        console.log("\nbookId -> ", bookId); // <script>alert()</script>

    if (
        bookTitle !== data[0][0].value || bookTitle.length > 255 ||   // check, if values were correct (if passed validation);
        bookAuthor !== data[0][1].value || isNaN(bookAuthor) ||
        bookYear !== data[0][2].value || isNaN(bookYear) || bookYear < 1900 || bookYear > 2023 ||
        bookPrice !== data[0][3].value || isNaN(bookPrice) || bookPrice > 1000 ||
        publisher !== data[0][4].value || isNaN(publisher) ||
        bookImage !== data[0][5].value ||
        bookDesc !== data[0][6].value || bookDesc.length < 10 || bookDesc.length > 1000 ||
        bookCover !== data[0][7].value ||
        bookPages !== data[0][8].value || isNaN(bookPages) || bookPages > 1500 ||
        bookDims !== data[0][9].value || bookDims.length > 15 ||
        bookCat !== data[0][10].value || isNaN(bookCat) ||
        bookSubcat !== data[0][11].value || isNaN(bookSubcat) ||
        bookId !== data[0][12].value || isNaN(bookId)
    ) {
            //result.innerHTML = "Wystąpił problem. Podaj poprawne dane"; // data didn't pass validation;
        result.innerHTML = "<span class='update-failed'>Wystąpił problem. Podaj poprawne dane</span>";

    } else {

        /*$.ajax({                             // Handle AJAX request;
            type: "POST",                    // GET or POST;
            url: "edit-book-data.php",       // Path to file (that process the <form> data);
            data: formData,                  //  ̶s̶e̶r̶i̶a̶l̶i̶z̶e̶d̶ ̶<̶f̶o̶r̶m̶>̶ ̶d̶a̶t̶a̶;̶ // Use the FormData object instead of serialized data;
                processData: false,              // (?) Prevent jQ from processing the data;
                contentType: false,              // (?) Let the browser set the content type automatically;
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {         // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            },
            complete: function() {           // Once finished - function called always after sending request;
                $("img#loading-icon").toggleClass("not-visible");
            },
            success: function(data) {        // Show content; // data - dane zwrócone z serwera !;
                $('div.result').html(data); // ✓ tutaj należy zastąpić tą linię danymi zwróconymi z serwera - to serwer udziela odpiwedzi czy udało się zaktualizować dane !;
                    //confirmButton.hide();                  // "Potwierdź";
                    //cancelButton.hide();                   // "Anuluj";
                    //$("div.delivery-date").append(data);   // data - dane zwrócone z serwera;
                        // finishArchive();
            },
            error: function(data) { /!*postData*!/                      // Show error msg;
                $('div.result').html(data); // tutaj należy zastąpić tą linię danymi zwróconymi z serwera - to serwer udziela odpiwedzi czy udało się zaktualizować dane !;
                        //$content.html('<div id="container">Please try again soon.</div>');
                    //confirmButton.hide(); // "Potwierdź";
                    //cancelButton.hide();  // "Anuluj";
                    //$("div.delivery-date").append(data).fadeIn(1000); // data - dane zwrócone z serwera;
            }
        });*/

        $.ajax({                             // Handle AJAX request;
            type: "POST",                    // GET or POST;
            url: "edit-book-data.php",       // Path to file (that process the <form> data);
            data: formData,                  //  ̶s̶e̶r̶i̶a̶l̶i̶z̶e̶d̶ ̶<̶f̶o̶r̶m̶>̶ ̶d̶a̶t̶a̶;̶ // Use the FormData object instead of serialized data;
                processData: false,              // (?) Prevent jQ from processing the data;
                contentType: false,              // (?) Let the browser set the content type automatically;
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {         // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) {
            $('div.result').html(data); // data - dane zwrócone z serwera;
        }).fail(function(data) {
            $('div.result').html(data); // data - dane zwrócone z serwera;
        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible"); // Once finished - function called always after sending request;
        });
    }
});
