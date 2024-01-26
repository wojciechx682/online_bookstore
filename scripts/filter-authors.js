
let button = document.getElementById("filter-authors");
let firstCheckbox = document.getElementById("all-authors");
let items = document.querySelectorAll('#ul-authors input[type="checkbox"]:not(#all-authors)');

const updateAll = () => {
    items.forEach(item => {
        item.checked = firstCheckbox.checked;
    });
}

window.addEventListener("load", function() {

    if(window.sessionStorage) {

        let authors = JSON.parse(sessionStorage.getItem("authors"));

        if (authors) {
            for (let i = 0; i < authors.length; i++) {
                for (let j = 0; j < items.length; j++) {
                    if (items[j].value === authors[i]) {
                        items[j].checked = true;
                    }
                }
            }
            filterAuthors();
        }
    }
});

const filterAuthors = () => {

    const checkedAuthors = Array.from(
        document.querySelectorAll('#ul-authors input[type="checkbox"]:checked:not(#all-authors)')
    ).map(item => item.value.trim());

    let books = document.querySelectorAll("#content-books > .outer-book:not(.hidden)");

    let minValue = parseInt(document.getElementById("min-price").value);
    let maxValue = parseInt(document.getElementById("max-price").value);

    books.forEach(book => {

        const bookAuthor = book.querySelector(".book-author").innerHTML;
        const bookPrice = parseFloat(DOMPurify.sanitize(book.querySelector(".book .book-price").innerHTML));

        if ( checkedAuthors.includes(bookAuthor) &&
             (bookPrice >= minValue) && (bookPrice <= maxValue) ) {

            book.classList.remove("hidden-author");

        } else {

            book.classList.add("hidden-author");

        }
    });

    if(window.sessionStorage) {
        sessionStorage.setItem("authors", JSON.stringify(checkedAuthors));
    }
}

button.addEventListener("click", filterAuthors);
firstCheckbox.addEventListener("change", updateAll);