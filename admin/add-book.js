
// \admin\add-book.php - add new book;

$("form.add-book-data").on("submit", function(e) {

    e.preventDefault();

    let data = $(this);
    let formData = new FormData(this);
    let result = document.querySelector('div.result');

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

    if ( // check, if values were correct (if passed validation);
        bookTitle !== data[0][0].value || bookTitle.length > 255 ||
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
        bookMagazine !== data[0][12].value || isNaN(bookMagazine) ||
        bookQuantity !== data[0][13].value || isNaN(bookQuantity)
    ) {
        result.innerHTML = "<span class='update-failed'>Wystąpił problem. Podaj poprawne dane</span>";
    } else {
        $.ajax({                             // Handle AJAX request;
            type: "POST",                    // GET or POST;
            url: "add-book-data.php",        // Path to file (that process the <form> data);
            data: formData,                  // Use the FormData object instead of serialized data;
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