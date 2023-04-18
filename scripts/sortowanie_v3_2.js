
$('#sortuj_wg').on('change', () => {
	sortBooks();
});

// Define a function to sort books
const sortBooks = () => {
	// Get the select element, selected option value, and book content element
	const selectElement = document.getElementById("sortuj_wg"); // <select>
	const selectedValue = selectElement.options[selectElement.selectedIndex].text;
	const contentBooks = document.getElementById("content-books");

	//const books = [...contentBooks.children]; // Get an array of book elements

			//let books = Array.from(document.querySelectorAll('#content-books .book:not([class*="hidden"])')); // all books, that don't have style="display: none;"
	//let books = Array.from(document.querySelectorAll('#content-books .book:not(".hidden")')); // books that don't have class "hidden" - sorting only visible elements

	/*let books = Array.from($('#content-books .book:not(.hidden)'));*/
	let books = Array.from($('#content-books > .outer-book'));

	//let books = Array.from(document.querySelectorAll('#content-books .book:not(.hidden)'));

	console.log("books ->", books);
	// console.log("books2 ->", books2);
	// console.log("books3 ->", books3);

	console.log("books -> ", books);
	console.log("books.length -> ", books.length);
	console.log("typeof(books) -> ", typeof(books));
	// 4

	if(books.length < 2) { // If there is only one book, don't sort and return
		return;
	}

	// Define sorting functions
	const sortByTitleAscending = (a, b) => a.querySelector(".book-title").textContent.localeCompare(b.querySelector(".book-title").textContent);
	const sortByTitleDescending = (a, b) =>	b.querySelector(".book-title").textContent.localeCompare(a.querySelector(".book-title").textContent);
	const sortByPriceAscending = (a, b) => Number(a.querySelector(".book-price").textContent) - Number(b.querySelector(".book-price").textContent);
	const sortByPriceDescending = (a, b) => Number(b.querySelector(".book-price").textContent) - Number(a.querySelector(".book-price").textContent);
	const sortByYearAscending = (a, b) => Number(a.querySelector(".book-year").textContent) - Number(b.querySelector(".book-year").textContent);
	const sortByYearDescending = (a, b) => Number(b.querySelector(".book-year").textContent) - Number(a.querySelector(".book-year").textContent);

	// Sort the books array based on the selected option
	switch (selectedValue) {
		case "nazwy A-Z":
			books.sort(sortByTitleAscending);
			break;
		case "nazwy Z-A":
			books.sort(sortByTitleDescending);
			break;
		case "ceny rosnąco":
			books.sort(sortByPriceAscending);
			break;
		case "ceny malejąco":
			books.sort(sortByPriceDescending);
			break;
		case "Najstarszych":
			books.sort(sortByYearAscending);
			break;
		case "Najnowszych":
			books.sort(sortByYearDescending);
			break;
		default:
			return;
	}

	// Append the sorted book elements to the book content element
	books.forEach((book) => contentBooks.appendChild(book));
};

document.getElementById("sortuj_wg").addEventListener("load", sortBooks);

/*
The refactored version of your code:

uses modern JavaScript syntax features, such as const, let, arrow functions, spread operator (...), and querySelector method to simplify the code and make it more readable.
removes the unnecessary array declarations, as they're not needed.
uses a switch statement with functions to sort the books based on the selected option, instead of having a long list of if...else statements.
avoids the console.log() call inside the for loop to prevent slowing down the script.
removes the unnecessary variables to make the code cleaner and more efficient.
uses the forEach() method to iterate over the sorted books and append them to the content_books container.
 */