
// admin/edit-books.php;

let select = document.querySelector('select[id$="book-category"]');
window.addEventListener("load", getSubcategories(select));

function getSubcategories(categorySelect) {

    let categoryId = categorySelect.value;

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {

        if (xhr.readyState === XMLHttpRequest.DONE) {

            if (xhr.status === 200) {

                let subcategories = JSON.parse(xhr.responseText);

                let subcategorySelect = document.getElementById('book-subcategory');
                subcategorySelect.innerHTML = '';

                for (let i = 0; i < subcategories.length; i++) {
                    let option = document.createElement('option');
                    option.value = subcategories[i][0]; // object - id pod-kategorii;
                    option.textContent = subcategories[i][1]; // nazwa pod-kategorii;
                    subcategorySelect.appendChild(option);
                }
            } else {
                console.error('Error: ', xhr.status);
            }
        }
    };

    xhr.open('GET', 'get-subcategories.php?category_id=' + categoryId, true);
    xhr.send();
}

$("form.edit-book-data").on("submit", function(e) {

    e.preventDefault();
    let data = $(this);
    let formData = new FormData(this);
    let result = document.querySelector('div.result');

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
        let bookMagazine = DOMPurify.sanitize(data[0][13].value); // id-magazynu / (hidden), number / input#edit-book-select-magazine;
        let bookQuantity = DOMPurify.sanitize(data[0][14].value); // ilosc-egzemplarzy / number / select#edit-book-quantity;
    let bookId = DOMPurify.sanitize(data[0][15].value); // id_ksiazki / number / input#edit-book-id

    if (
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
            bookMagazine !== data[0][13].value || isNaN(bookMagazine) ||
            bookQuantity !== data[0][14].value || isNaN(bookQuantity) ||
        bookId !== data[0][15].value || isNaN(bookId)
    ) {
        result.innerHTML = "<span class='update-failed'>Wystąpił problem. Podaj poprawne dane</span>";
    } else {

        $.ajax({                           // Handle AJAX request;
            //type: "POST",                    // GET or POST;
            method: "POST",
            url: "edit-book-data.php",       // Path to file (that process the <form> data);
            data: formData,                  // Use the FormData object instead of serialized data;
                processData: false,              // (?) Prevent jQ from processing the data;
                contentType: false,              // (?) Let the browser set the content type automatically;
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {   // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) {  // methods of the jqXHR object -> .done(), .fail(), .always()
            $('div.result').html(data); // data - dane zwrócone z serwera;
        }).fail(function(data) {
            $('div.result').html(data);
        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible"); // Once finished - function called always after sending request;
        });
    }
});
