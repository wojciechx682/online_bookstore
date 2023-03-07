// search dynamically

const inputSearch = document.querySelector('#input-search'); // <input type="search">
const books = document.querySelectorAll('.book');            // <div id="book1" class="book">, <div id="book2" class="book">, ...

inputSearch.addEventListener('input', function() {
    const searchTerm = inputSearch.value.toLowerCase();

    books.forEach(book => {
        const title = book.querySelector('.title').textContent.toLowerCase();

        if (title.includes(searchTerm)) {
            book.style.display = 'block';
        } else {
            book.style.display = 'none';
        }
    });
});
