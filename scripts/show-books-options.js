
function showBooksOptions(id) { // admin/orders.php

    // po kliknięciu "Zarządzaj" - w danym pole - ukrycie pozostałych list opcji, jeśłi były widoczne;

    let bookActionOptions = document.querySelectorAll('div.book-action'); // kolekcja pojemników z przyciskiem "Zarządzaj";

    for(let i = 1; i < bookActionOptions.length; i++) {    // dla każdego <div>'a   -->   <div class="order-action">

        let bookActionButton = bookActionOptions[i].querySelector('.book-action-button'); // przycisk "Zarządzaj" - </div> ;
        // <div class="book-action-button" ...> "Zarządzaj" . </div>

        // console.log("\n\n bookActionButton -> ",  bookActionButton);

        // ukrycie wszystkich pozostałych listy opcji, jeśli były widoczne (tzn. poza tym, który został aktualnie kliknięty !) ;

        if(bookActionButton.id !== id) {

            let icon = bookActionOptions[i].querySelector('i'); // ikona strzałki
            let options = bookActionOptions[i].querySelector('.book-action-options'); // lista opcji w danym wierszu - "Przelądaj", "Zmień status", "Archiwizuj"

            //console.log(i+1 + "-ty element - icon ",  icon);

            if(icon.classList.contains('icon-up-open')) { // jeśli opcje były widoczne -> (ikona w górę)
                icon.classList.replace('icon-up-open', 'icon-down-open'); // zmień ikonę (w dół)
            }

            /*if(options.style.display === "block") { // jeśli opcje były widoczne (lista opcji)
                options.style.display = "none"; // ukryj listę opcji
            }*/

            options.classList.toggle("hidden", true); // add "hidden" class

        }
    }

    const button = document.querySelector(`#${id}`);
    const options = button.nextElementSibling.querySelector('.book-action-options');
    const icon = button.querySelector('i');

    // console.log("i -> ", icon)

    /*if(options.style.display === "block") {
        options.style.display = "none";
        icon.classList.remove('icon-up-open');
        icon.classList.add('icon-down-open');
    } else {
        options.style.display = "block";
        icon.classList.remove('icon-down-open');
        icon.classList.add('icon-up-open');
    }
*/
    if(!options.classList.contains("hidden")) {    // jeśli lista opcji była widoczna;
        //options.style.display = "none";
        options.classList.add("hidden");           // ukrycie listy opcji
        //icon.classList.remove('icon-up-open');
        //icon.classList.add('icon-down-open');    // zmiana ikony na przeciwną
        icon.classList.replace('icon-up-open', 'icon-down-open');
    } else {
        //options.style.display = "block";         // wyświetlenie listy opcji
        options.classList.remove("hidden");         // wyświetlenie listy opcji
        //icon.classList.remove('icon-down-open');
        //icon.classList.add('icon-up-open');      // zmiana ikony na przeciwną
        icon.classList.replace('icon-down-open', 'icon-up-open');
    }

}
