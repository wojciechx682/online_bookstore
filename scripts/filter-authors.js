let button = document.getElementById("filter-authors");
let firstCheckbox = document.getElementById("all-authors");
let items = document.querySelectorAll('#ul-authors input[type="checkbox"]:not(#all-authors)');

console.log("items --> ", items);

const updateAll = () => {
    items.forEach(item => {
        item.checked = firstCheckbox.checked;
    });
    filterAuthors(); // Dodajemy, aby natychmiast zastosować filtrację po zaznaczeniu/odznaczeniu "Wszyscy"
}

window.addEventListener("load", function() {

});

window.addEventListener("load", function() {
    if (window.sessionStorage) {
        let authors = JSON.parse(sessionStorage.getItem("authors"));
        console.log("Authors from sessionStorage --> ", authors); // Debugowanie
        if (authors) {
            authors.forEach(author => {
                items.forEach(item => {
                    if (item.value === author) {
                        item.checked = true;
                        console.log("Checked item: ", item); // Debugowanie zaznaczonego checkboxa
                    }
                });
            });
            filterAuthors();
        }
    }
});

const filterAuthors = () => {
    console.log("items --> ", items);

    const checkedAuthors = Array.from(
        document.querySelectorAll('#ul-authors input[type="checkbox"]:checked:not(#all-authors)')
    ).map(item => item.value.trim());

    console.log("checkedAuthors --> ", checkedAuthors);

    let books = document.querySelectorAll("#content-books > .outer-book");

    console.log("books --> ", books);

    let minValue = parseInt(document.getElementById("min-price").value);
    let maxValue = parseInt(document.getElementById("max-price").value);

    books.forEach(book => {
        const bookAuthor = book.querySelector(".book-author").innerHTML.trim();
        const bookPrice = parseFloat(DOMPurify.sanitize(book.querySelector(".book .book-price").innerHTML.trim()));

        if (checkedAuthors.includes(bookAuthor) && (bookPrice >= minValue) && (bookPrice <= maxValue)) {
            book.classList.remove("hidden-author");
        } else {
            book.classList.add("hidden-author");
        }
    });

    if (window.sessionStorage) {
        sessionStorage.setItem("authors", JSON.stringify(checkedAuthors));
        console.log("Saved authors to sessionStorage: ", JSON.stringify(checkedAuthors)); // Debugowanie zapisu
    }
}

button.addEventListener("click", filterAuthors);
firstCheckbox.addEventListener("change", updateAll);
