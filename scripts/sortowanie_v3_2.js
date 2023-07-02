
// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/sort

/*$('#sortuj_wg').on('change', function() {
	sortBooks();
});*/

$('#sortuj_wg').on('change', () => {	// arrow function ;
	sortBooks();
});

// define a function to sort books ;
const sortBooks = () => { // function is defined using arrow function syntax ;
						  	 // let myFunction = (a, b) => a * b;
	// inside function / function body ;

	// set the <select> element, selected option value, and book content element ;
	const selectElement = document.getElementById("sortuj_wg"); // <select> list ;
	const selectedValue = selectElement.options[selectElement.selectedIndex].text; // "Nazwy A-Z";
	const contentBooks = document.getElementById("content-books");

	console.log("\n selectElement (select) -> ", selectElement);
	console.log("\n typeof selectElement (select) -> ", typeof selectElement);
	console.log("\n selectedValue (text)-> ", selectedValue);
	console.log("\n typeof selectedValue (text)-> ", typeof selectedValue);
	console.log("\n contentBooks (div) -> ", contentBooks);
	console.log("\n typeof contentBooks (div) -> ", typeof contentBooks);

	// const books = [...contentBooks.children]; // get an array of book elements ;

			//let books = Array.from(document.querySelectorAll('#content-books .book:not([class*="hidden"])')); // all books, that don't have style="display: none;"
	//let books = Array.from(document.querySelectorAll('#content-books .book:not(".hidden")')); // books that don't have class "hidden" - sorting only visible elements

	/*let books = Array.from($('#content-books .book:not(.hidden)'));*/

	//let books = Array.from($('#content-books > .outer-book')); // create array that contains every book ;

	let books = Array.from($('#content-books > .outer-book:not(:has(.book.hidden))'));
	// wybierz tylko te elementy, które nie są ukryte (nie zawierają klasy "book hidden") - aby sortować tylko widoczne elementy

	console.log("books ->", books);
	console.log("typeof books ->", typeof books); // object;
	// console.log("books2 ->", books2);
	// console.log("books3 ->", books3);

	console.log("books -> ", books);
	console.log("books.length -> ", books.length);
	console.log("typeof(books) -> ", typeof(books));
	// 4

	if(books.length < 2) { // If there is only one book, don't sort and return
		return;
	}

	// define sorting functions			   // a, b - elementy tablicy (array elements) - ✓ divy z książkami ;
		//	funkcje porównujące ;          // return -1, 0 lub 1 ;
	const sortByTitleAscending = (a, b) => a.querySelector(".book-title").textContent.localeCompare(b.querySelector(".book-title").textContent);
	const sortByTitleDescending = (a, b) =>	b.querySelector(".book-title").textContent.localeCompare(a.querySelector(".book-title").textContent);
	const sortByPriceAscending = (a, b) => Number(a.querySelector(".book-price").textContent) - Number(b.querySelector(".book-price").textContent);
	const sortByPriceDescending = (a, b) => Number(b.querySelector(".book-price").textContent) - Number(a.querySelector(".book-price").textContent);
	const sortByYearAscending = (a, b) => Number(a.querySelector(".book-year").textContent) - Number(b.querySelector(".book-year").textContent);
	const sortByYearDescending = (a, b) => Number(b.querySelector(".book-year").textContent) - Number(a.querySelector(".book-year").textContent);
	// function compareFn(a, b) {
	// 	if (a is less than b by some ordering criterion) {
	// 		return -1;
	// 	}
	// 	if (a is greater than b by the ordering criterion) {
	// 		return 1;
	// 	}
	//
	// 	return 0; // a must be equal to b
	// }




	// Sort the books array based on the selected option
	switch (selectedValue) {
		case "nazwy A-Z":
			books.sort(sortByTitleAscending); // sortByTitleAscending - ✓ funkcja definiująca porządek sortowania (porównująca) - zwraca wartość będącą liczbą (-1, 0, 1)
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