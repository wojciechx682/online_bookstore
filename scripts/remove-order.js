// order.php - usunięcie / zarchwizowanie / zamknięcie zamówienia

// admin podaje powód (notatkę) - którą potem może wyświetlić klient.


function removeOrder() { // po kliknięciu przycisku "Usuń"
    // console.log("yeey");

    let removeBox = document.getElementById("update-status"); // pojawienie się okenka po kliknięciu "Usuń";
    removeBox.classList.toggle("hidden");

        let allContainer = document.getElementById("all-container");
        allContainer.classList.toggle("bright");

    icon = document.querySelector('.icon-cancel');
        cancelBtn = document.querySelector('.cancel-order');         // przycisk "Anuluj"

    // zamknięcie okna po kliknięciu "x";
    icon.addEventListener("click", function() {
        //toggleRemoveBox(removeBox, allContainer);
        removeOrder(); // rekurencja -> toggle - tym razem zamknięcie okienka;
    });

    cancelBtn.addEventListener("click", function() {
        removeOrder(); // przycisk "Anuluj"
    });

    $('.delivery-date').css("display", "block"); // wyświetlenie formularza (domyślnie był ukryty
    /*let div = document.querySelector(".delivery-date");
    div.classList.toggle("hidden");*/


}

/* function toggleRemoveBox(removeBox, allContainer) {
    removeBox.classList.toggle("hidden");
    //resetBox();
}*/
