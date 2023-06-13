
// admin/edit-books.php;

function getSubcategories(categorySelect) {

    //let categoryId = document.getElementById('edit-book-category').value;
    let categoryId = categorySelect.value; // "2" - string;

    let xhr = new XMLHttpRequest(); // send an AJAX request to fetch the subcategories based on the selected category;
    xhr.onreadystatechange = function() {           // xhr.onload = function()
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {              // after response from server

                let subcategories = JSON.parse(xhr.responseText); // (!)
                //  object

                // Update the subcategories select list
                let subcategorySelect = document.getElementById('edit-book-subcategory');
                subcategorySelect.innerHTML = ''; // Clear previous options

                for (let i = 0; i < subcategories.length; i++) {
                    let option = document.createElement('option');
                    option.value = subcategories[i].id; // object
                    option.textContent = subcategories[i].name;
                    subcategorySelect.appendChild(option); // .html() ? - nie bo dodajemy elementy <option> do listy <select> !
                }
            } else {
                console.error('Error:', xhr.status);
            }
        }
    };

    xhr.open('GET', 'get_subcategories.php?category_id=' + categoryId, true);
    xhr.send();
}

$("form.edit-book-data").on("submit", function(e) {

    e.preventDefault(); // prevent default <form> action which is submitted;

    let data = $(this); // object that holds <form> data;
        //let postData = $(this).serialize(); // serialized <form> data;
    let formData = new FormData(this); // Create a new FormData object
    // need to use the FormData object to send the form data, including the image file.
    let result = document.querySelector('div.result');

    console.log("\n46 data -> ", data);
    console.log("\n46 typeof data -> ", typeof data);
    console.log("\n46 formData -> ", formData);
    console.log("\n46 typeof formData -> ", typeof formData);

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
console.log("\nbookSubcat -> ", bookSubcat); // <script>alert()</script>
console.log("\nbookId -> ", bookId);

    if (
        bookTitle !== data[0][0].value ||   // check, if values were correct (if passed validation);
        bookAuthor !== data[0][1].value ||
        bookYear !== data[0][2].value ||
        bookPrice !== data[0][3].value ||
        publisher !== data[0][4].value ||
        bookImage !== data[0][5].value ||
        bookDesc !== data[0][6].value ||
        bookCover !== data[0][7].value ||
        bookPages !== data[0][8].value ||
        bookDims !== data[0][9].value ||
        bookDims.length > 15 ||
        bookCat !== data[0][10].value ||
        bookSubcat !== data[0][11].value ||
        bookId !== data[0][12].value

    ) {
        result.innerHTML = "Wystąpił problem. Podaj poprawne dane"; // data didn't pass validation;

    } else {

        $.ajax({                             // Handle AJAX request;
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
            error: function(data) { /*postData*/                      // Show error msg;
                $('div.result').html(data); // tutaj należy zastąpić tą linię danymi zwróconymi z serwera - to serwer udziela odpiwedzi czy udało się zaktualizować dane !;
                        //$content.html('<div id="container">Please try again soon.</div>');
                    //confirmButton.hide(); // "Potwierdź";
                    //cancelButton.hide();  // "Anuluj";
                    //$("div.delivery-date").append(data).fadeIn(1000); // data - dane zwrócone z serwera;
            }
        });
    }

    /*edit-book-title*/

    /*function validateInput() {
        const inputField = document.getElementById('edit-book-title');
        const inputValue = inputField.value;

        if (inputValue.trim() === '') {
            alert('Please enter a value for the book title.');
        } else {
            // Validation passed, do something with the input value
            console.log('Input value:', inputValue);
        }
    }*/
});




































        /*$(document).ready(function() {               // after page load/reload - send <form>;

            $("form#change-magazine-form").submit(); // submit the <form>;
        });*/

/*$("select#edit-book-category").on("change", function(e) { // after changing <option> element in <select> list;

    //$("form#change-magazine-form").submit(); // submit the <form>;

    console.log($(this));
});*/

        /*$("form#change-magazine-form").on("submit", function(e) { // after submitting form;
            e.preventDefault();
            let data = $(this).serialize(); // dane formularza do przesłania metodą post; // let data = $(this);
            let postData = parseInt($(this).serialize().slice(16).trim()); // "change-magazine=1" => "1" (id_maazynu);
            console.log("\ndata => ", data); // String;
            console.log("\npost_data (id_magazynu) =>", postData); // atrybut value elementu <option> (jest to id_magazynu);
            console.log("\ntypeof(post data) (id_magazynu) =>", typeof(postData)); // atrybut value elementu <option> (jest to id_magazynu);
            console.log("\ntypeof form => ", typeof(form)); // Object;
            if((data !== '') && (typeof(postData) === 'number') && (!isNaN(postData))) { // nie pusta, liczba, nie jest to "NaN";
                $.ajax({
                    type: "POST",                    // GET or POST;
                    url: "change-magazine.php",      // Path to file (that process the <form> data);
                    data: data,                      // serialized <form> data;
                    timeout: 2000,                   // Waiting time;
                    beforeSend: function() {         // Before Ajax - function called before sending the request;
                        $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                    },
                    complete: function() {           // Once finished - function called always after sending request;
                        $("img#loading-icon").toggleClass("not-visible");
                    },
                    success: function(data) {        // Show content;
                        let booksHeader = document.querySelector('.admin-books');
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
                });
            } else {  // błąd z id-magazynu (!) ;
                $("div.admin-books").css('display', 'none');
                $("div#books-content").html('<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>');
            }


        });*/


