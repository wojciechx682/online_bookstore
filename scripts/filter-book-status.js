
let updateStatusBtn = document.getElementById("filter-book-status");
updateStatusBtn.addEventListener("click", filterBookStatus);

let liStatus = document.querySelectorAll('#ul-book-status-list input[type="checkbox"]');

function filterBookStatus()  {

    const liChecked = document.querySelectorAll('#ul-book-status-list input[type="checkbox"]:checked');

    let items = Array.from(liChecked);
    const bookStatus = items.map(items => items.value.trim());
    let books = document.querySelectorAll("#content-books .book");

    for(let i = 0; i < books.length; i++) {
        books[i].classList.add('hidden');
    }
    for(let i = 0; i < bookStatus.length; i++) {
        for(let j = 0 ; j < books.length; j++) {
            if(books[j].querySelector(".book-status").innerHTML === bookStatus[i]) {
                books[j].classList.remove('hidden');
            }
        }
    }
}