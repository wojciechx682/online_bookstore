// po refaktoryzacji ->

/*
	1. Użycie "const" / "let" zamiast var,

	2. Użycie tablicy obiektów (zamiast oddzielnych tablic dla tytułów, cen i lat) - do przechowywania informacji o książce.	Ułatwi to dostęp do danych i manipulowanie nimi

	3. Użycie bardziej opisowych nazw zmiennych, aby kod był łatwiejszy do odczytania i zrozumienia.

	4. Połączenie przypadków "nazwy A-Z" i "nazwy Z-A" oraz "ceny rosnąco" i "ceny malejąco"

	5. użycie instrukcji switch zamiast if - linia 115


 */



$('#sortuj_wg').on('change', function() {
	sortuj();
});



const sortSelect = document.getElementById('sortuj_wg');
const booksContainer = document.getElementById('content_books');

let books = [];

sortSelect.addEventListener('change', sortuj);

function sortuj() {
	const selectedValue = sortSelect.value;

	books = Array.from(booksContainer.children).map(book => ({
		element: book,
		title: book.querySelector('.title').textContent,
		price: parseFloat(book.querySelector('.price').textContent),
		year: parseInt(book.querySelector('.year').textContent),
	}));

	switch(selectedValue) {
		case 'nazwy A-Z':
		case 'nazwy Z-A':
			books.sort((a, b) => a.title.localeCompare(b.title));
			if (selectedValue === 'nazwy Z-A') books.reverse();
			break;

		case 'ceny rosnąco':
		case 'ceny malejąco':
			books.sort((a, b) => a.price - b.price);
			if (selectedValue === 'ceny malejąco') books.reverse();
			break;

		case 'Najstarszych':
		case 'Najnowszych':
			books.sort((a, b) => a.year - b.year);
			if (selectedValue === 'Najnowszych') books.reverse();
			break;
	}

	for (let i = 0; i < books.length; i++) {
		booksContainer.appendChild(books[i].element);
	}
}

