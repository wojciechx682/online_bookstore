
function showOptions(id) {   // admin/orders.php - kliknięcie "Zarządzaj";   -->  ✓ wyświetlenie / ukrycie listy opcji ;

    // po kliknięciu "Zarządzaj" - w danym polu - ukrycie pozostałych list opcji, jeśłi były widoczne;

    let orderActionOptions = document.querySelectorAll('div.order-action'); // kolekcja pojemników z przyciskiem "Zarządzaj";

    for(let i = 1; i < orderActionOptions.length; i++) {    // dla każdego <div>'a   -->   <div class="order-action">

        let orderActionButton = orderActionOptions[i].querySelector('.order-action-button'); // przycisk "Zarządzaj" - </div> ;
        // <div class="order-action-button" id="order-action-button1121" onclick="showOptions(this.id)"> "Zarządzaj" . </div>

        // ukrycie wszystkich pozostałych listy opcji, jeśli były widoczne (tzn. poza tym, który został aktualnie kliknięty !) ;

        if(orderActionButton.id !== id) {

            let icon = orderActionOptions[i].querySelector('i'); // ikona strzałki
            let options = orderActionOptions[i].querySelector('.order-action-options'); // lista opcji w danym wierszu - "Przelądaj", "Zmień status", "Archiwizuj"

            if(icon.classList.contains('icon-up-open')) { // jeśli opcje były WIDOCZNE -> (ikona w górę)
                icon.classList.replace('icon-up-open', 'icon-down-open'); // zmień ikonę (w dół)
            }

            options.classList.toggle("hidden", true); // add "hidden" class;
        }
    }

    console.log(`\n\nid klikniętego elementu --> #${id}\n\n`); // id-elementu - który został kliknięty --> "#order-action-button1121"

    const button = document.querySelector(`#${id}`);    // template literal - <div> "Zarządzaj" </div> ;
    // <div class="order-action-button"
    //      id="order-action-button1121"
    //      onclick="showOptions(this.id)">

    const options = button.nextElementSibling.querySelector('.order-action-options');
        // menu z opcjami (klikniętego elementu "Zarządzaj" !) - <div> - "przeglądaj", "zmień status", "archiwizuj";
    const icon = button.querySelector('i');
        // ikona do wysuwania menu (klikniętego elementu "Zarządzaj" !) - <div class="order-action-options" ... >

    console.log("\nbutton -> ", button);
    console.log("\noptions -> ", options);
    console.log("\nicon -> ", icon);

    /*console.log("8 i -> ", icon)*/

    /*if(options.style.display === "block") {      // jeśli lista opcji była widoczna;
        options.style.display = "none";          // ukrycie listy opcji
        icon.classList.remove('icon-up-open');
        icon.classList.add('icon-down-open');    // zmiana ikony na przeciwną
    } else {
        options.style.display = "block";         // wyświetlenie listy opcji
        icon.classList.remove('icon-down-open');
        icon.classList.add('icon-up-open');      // zmiana ikony na przeciwną
    }*/

    if(!options.classList.contains("hidden")) {    // jeśli lista opcji była widoczna;
        //options.style.display = "none";          // ukrycie listy opcji
        options.classList.add("hidden");           // ukrycie listy opcji
        //icon.classList.remove('icon-up-open');
        //icon.classList.add('icon-down-open');    // zmiana ikony na przeciwną
        icon.classList.replace('icon-up-open', 'icon-down-open'); // zmień ikonę na przeciwną (w dół)
    } else {
        //options.style.display = "block";         // wyświetlenie listy opcji
        options.classList.remove("hidden");        // wyświetlenie listy opcji
        //icon.classList.remove('icon-down-open');
        //icon.classList.add('icon-up-open');      // zmiana ikony na przeciwną
        icon.classList.replace('icon-down-open', 'icon-up-open');
    }

}
