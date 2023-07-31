
// \admin\add-book.php - add new book;

$("form.add-book-data").on("submit", function(e) {

    e.preventDefault(); // prevent default <form> action which is submitted;

    let data = $(this); // jQ object that holds <form> data;
        // let postData = $(this).serialize(); // serialized <form> data;
    let formData = new FormData(this); // Create a new FormData object
    // need to use the FormData object to send the form data, including the image file.
    let result = document.querySelector('div.result');

    console.log("\n46 data -> ", data);
    console.log("\n15 data value -> ", data[0][0].value);
    console.log("\n46 typeof data -> ", typeof data);
    console.log("\n46 formData -> ", formData);
    console.log("\n46 typeof formData -> ", typeof formData);

    //return;

    // front-end validation;
    let bookTitle = DOMPurify.sanitize(data[0][0].value); // book-title
    let bookAuthor = DOMPurify.sanitize(data[0][1].value); // id_autora / number / select#add-book-author;
    let bookYear = DOMPurify.sanitize(data[0][2].value); // rok_wyd / number / select#add-book-release-year;
    let bookPrice = DOMPurify.sanitize(data[0][3].value); // cena / number / input#add-book-price;
    let publisher = DOMPurify.sanitize(data[0][4].value); // id_wydawcy / number / select#add-book-publisher;
    let bookImage = DOMPurify.sanitize(data[0][5].value); // image_url / file / input#add-book-image;
    let bookDesc = DOMPurify.sanitize(data[0][6].value); // opis / text / textarea#add-book-desc;
    let bookCover = DOMPurify.sanitize(data[0][7].value); // oprawa / text / select#add-book-cover;
    let bookPages = DOMPurify.sanitize(data[0][8].value); // ilosc_stron / number / input#add-book-pages;
    let bookDims = DOMPurify.sanitize(data[0][9].value); // wymiary / text / input#add-book-dims;
    let bookCat = DOMPurify.sanitize(data[0][10].value); // kategoria / number / select#add-book-category;
    let bookSubcat = DOMPurify.sanitize(data[0][11].value); // podkategoria / number / select#add-book-subcategory;
    let bookMagazine = DOMPurify.sanitize(data[0][12].value); // id_magazynu / number / select#add-book-select-magazine;
    let bookQuantity = DOMPurify.sanitize(data[0][13].value); // ilość_egzemplarzy / number / input#add-book-quantity;
        //let bookId = DOMPurify.sanitize(data[0][12].value); // NULL - (AI)

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
    console.log("\nbookMagazine -> ", bookMagazine);
    console.log("\nbookQuantity -> ", bookQuantity);
    //console.log("\nbookId -> ", bookId); // <script>alert()</script>

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
        bookMagazine !== data[0][12].value ||
        bookQuantity !== data[0][13].value
    ) {
        result.innerHTML = "Wystąpił problem. Podaj poprawne dane"; // data didn't pass validation;

    } else {

        $.ajax({                             // Handle AJAX request;
            type: "POST",                    // GET or POST;
            url: "add-book-data.php",       // Path to file (that process the <form> data);
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
});