// order.php - usunięcie / zarchwizowanie / zamknięcie zamówienia

// admin podaje powód (notatkę) - którą potem może wyświetlić klient;

function removeOrder(order_id) { // po kliknięciu przycisku "Archiwizuj"

    console.log("\n order_id --> ", order_id);

    // let removeBox = document.getElementById("update-status"); // pojawienie się okenka po kliknięciu "Usuń";
    let removeBox = document.querySelector(".update-status"+order_id); // pojawienie się okenka po kliknięciu "Zarchiwizuj";

    // console.log("\n order_id --> ", removeBox); // <div class="update-status1035 hidden"> - OKIENKO PO KLIKNIĘCIU "ARCHIWIZUJ";

    removeBox.classList.toggle("hidden");
    /*removeBox.style.filter = "inherit";*/
    //removeBox.classList.toggle('normal');

        let allContainer = document.getElementById("all-container");
        allContainer.classList.toggle("bright");

    let icon = document.querySelector(".icon-cancel" + order_id);
    let cancelBtn = document.querySelector(".cancel-order"+order_id);         // przycisk "Anuluj"

    // zamknięcie okna po kliknięciu "✘";
    icon.addEventListener("click", function() {
        //toggleRemoveBox(removeBox, allContainer);
        let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
        resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
        removeOrder(order_id); // rekurencja -> toggle - tym razem zamknięcie okienka;

    });

    cancelBtn.addEventListener("click", function() {

        let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
        resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
        removeOrder(order_id); // przycisk "Anuluj"
    });

    $('.delivery-date').css("display", "block"); // wyświetlenie formularza (domyślnie był ukryty
    /*let div = document.querySelector(".delivery-date");
    div.classList.toggle("hidden");*/
}

/* function toggleRemoveBox(removeBox, allContainer) {
    removeBox.classList.toggle("hidden");
    //resetBox();
}*/
