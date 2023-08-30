
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// order.php - usunięcie / zarchwizowanie / zamknięcie zamówienia
// admin podaje powód (notatkę) - którą potem może wyświetlić klient;

function removeOrder(orderId) { // po kliknięciu przycisku "Archiwizuj";  orderId -> "1130";
    console.log("\n 7 - admin-orders.js - removeOrder function executed ! \n");
    // pojawienie się okienka po kliknięciu "Zarchiwizuj";
    // ✓ refactor - zamiana na tylko jedno okno Archiwizowania zamówienia ;
        // let removeBox = document.getElementById("update-status");
        // let removeBox = document.querySelector(".update-status"+orderId);
    let removeBox = document.querySelector(".update-status"); // okienko Archiwizowania zamówienia;
        //console.log("\nremoveBox (okno archiwizowania zamówienia) --> ", removeBox); // <div class="update-status"></div>
    // dodanie atrybutu "id" (order-id) do pól formularza (input type="hidden") -->
    let input = removeBox.querySelector('form.remove-order > input[type="hidden"][name="order-id"]'); // input type="hidden";
    input.value = orderId;
    removeBox.classList.toggle("hidden"); // pojawienie się okenka po kliknięciu "Zarchiwizuj";
    let mainContainer = document.getElementById("main-container");
        //if( ! mainContainer.classList.contains("bright")) {
        //    mainContainer.classList.toggle("bright");
        //}
    mainContainer.classList.toggle("bright"); // ✓ zmiana tła strony na ciemne (#main-container)
    mainContainer.classList.toggle("unreachable"); // ✓ wyłączenie możliwości kliknięcia czegokolwiek (w tle) poza okieniem archiwizowania;
        //let icon = document.querySelector(".icon-cancel" + orderId);
    let icon = document.querySelector(".icon-cancel");  // ikona "✖"
        //let cancelBtn = document.querySelector(".cancel-order"+orderId);
    let cancelBtn = document.querySelector(".cancel-order"); // przycisk "Anuluj"
        console.log("\nicon --> ", icon);
        console.log("\ncancelBtn --> ", cancelBtn);
    // zamknięcie okna po kliknięciu "✖";
    //icon.addEventListener("click", function() {
    //    closeRemoveBox();
    //});
    // zamknięcie okna po kliknięciu "Anuluj";
    //cancelBtn.addEventListener("click", function() {
    //    closeRemoveBox();
    //});
    buttons = [icon, cancelBtn]; // "✖", "Anuluj";
    buttons.forEach(function(button) {
        button.addEventListener("click", closeRemoveBox);
    });
    function closeRemoveBox() {
        console.log("\n 57 - admin-orders.js - closeRemoveBox function executed ! \n");
            //mainContainer.removeAttribute("style");
        mainContainer.classList.toggle("unreachable", false); // remove "unreachable" class from #main-container ;
        let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
        resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny, usuwa zawartość <textarea>;
            //textarea.value = "";
            // removeBox.classList.toggle("hidden");
            //if(!removeBox.classList.contains("hidden")) { // jeśli okno jest widoczne;
            //    removeBox.classList.toggle("hidden");
            //}
        removeBox.classList.toggle("hidden", true); // ukrycie okna - dodanie klasy "hidden" ;  true - oznacza że klasa zostanie tylko dodana;
            // mainContainer.classList.toggle("bright");
            //if(mainContainer.classList.contains("bright")) { // jeśli tło jest ciemne
            //    mainContainer.classList.toggle("bright");
            //}
        mainContainer.classList.toggle("bright", false); // usunięcie ciemnego tła ; false - oznacza, że klasa zostanie tylko usunięta;
        removeMessagesAndResetButtons(removeBox);
    }

    function removeMessagesAndResetButtons(removeBox) {
            console.log("\n 90 - admin-orders.js - removeMessagesAndResetButtons function executed ! \n");
            //const successMsg = removeBox.querySelector("span.archive-success");
            //const errorMsg = removeBox.querySelector("span.update-failed");
        const spanMsgs = removeBox.querySelectorAll("span.archive-success, span.update-failed");
        //const confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
        const cancelButton = removeBox.querySelector('button.cancel-order');
        const form = removeBox.querySelector('.remove-order');
            //if (successMsg) {
            //    successMsg.remove();
            //    confirmButton.style.display = "initial";
            //}
            //if (errorMsg) {
            //    errorMsg.remove();
            //    confirmButton.style.display = "initial";
            //}
        // better -> iterates over the collected spanMsgs NodeList using a for loop and removes each span individually if it exists.
        for(let i = 0; i < spanMsgs.length; i++) {
            let resultMsg = spanMsgs[i];
            if(resultMsg) {
                resultMsg.remove();
                    //confirmButton.style.display = "initial";
                //confirmButton.classList.toggle("hidden", false);
            }
        }
            /*confirmButton.style.display = "initial";
            cancelButton.style.display = "initial";*/
        /*confirmButton.classList.toggle("hidden", false); // remove "hidden" class;*/
        cancelButton.classList.toggle("hidden", false);
        form.classList.toggle("hidden", false);
    }
        //$('.delivery-date').css("display", "block"); // wyświetlenie formularza (domyślnie był ukryty
        // let div = document.querySelector(".delivery-date");
        // div.classList.toggle("hidden");
    let deliveryDate = document.querySelector(".delivery-date");
    deliveryDate.classList.toggle("hidden", false);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function resetError(textarea) { // funkcja wywołana po zdarzeniu "focus" na elemencie <textarea> - przy archiwizowaniu zamówienia;
        console.log("\n134 orders.php -> resetError - function executed\n");
    // archiwizowanie zamówienia - kliknięcie (focus) na <textarea> usuwa komunikat o błędzie (jeśli był on widoczny);
    let spanError = textarea.nextElementSibling; // <span> z komunikatem o błędzie; <span class="remove-order-error">
                                                 // "Opinia powinna zawierać od 10 do 255 znaków ..."
    /*if(spanError.style.display === "block") {    // jeśli komunikat jest widoczny
        spanError.style.display = "none";        // usuń komunikat
    }*/
    /*if (!spanError.classList.contains("hidden")) {
        spanError.classList.add("hidden");
    } */
    /*else {
        spanError.classList.add("hidden");
    }*/
    spanError.classList.toggle("hidden", true); // hide error message (add "hidden" class)
    textarea.value = ""; // usuwa zawartość tekstową która znajdowałą się w <textarea>
}
//function finishArchive(textarea) {
//    // (?)
//}
document.addEventListener("keydown", function(event) {
    // Po kliknięciu dowolnego przycisku --> ESC --> Przywróć stan okna Archiwizowania do stanu początkowego;
    console.log("\n160 orders.php -> KEY was pressed\n");
        // kliknięcie "Esc" zamyka okno Archiwizowania;
        // ~ ̶/̶/̶ ̶~̶ ̶m̶o̶ż̶n̶a̶ ̶b̶y̶ ̶t̶o̶ ̶z̶r̶o̶b̶i̶ć̶ ̶l̶e̶p̶i̶e̶j̶,̶ ̶t̶a̶k̶ ̶a̶b̶y̶ ̶p̶ę̶t̶l̶a̶ ̶n̶i̶e̶ ̶i̶t̶e̶r̶o̶w̶a̶ł̶a̶ ̶p̶r̶z̶e̶z̶ ̶w̶s̶z̶y̶s̶t̶i̶e̶ ̶e̶l̶e̶m̶e̶n̶t̶y̶ ̶(̶w̶s̶z̶y̶s̶t̶k̶i̶e̶ ̶z̶a̶m̶ó̶w̶i̶e̶n̶i̶a̶)̶;̶
        //let removeBoxes = document.querySelectorAll('div.update-status');
    let removeBox = document.querySelector("div.update-status"); // okienko Archiwizowania zamówienia;
    let mainContainer = document.getElementById("main-container");
    //console.log("\n removeBox --> ", removeBox);
    if (!removeBox.classList.contains("hidden")) { // jeśli okno Archiwizowania jest widoczne (nie zawiera klasy hidden);
        if (event.key === "Escape") {
            console.log("\n170 orders.php -> Esc - KEY was pressed\n");
                //resetRemoveBox();
            removeBox.classList.toggle("hidden"); // zamknięcie okna - okno staje się niewidzone (dodanie klasy "hidden");
            mainContainer.classList.toggle("bright"); // usunięcie klasy "birght" z diva #main-container (staje się on jasny);
            mainContainer.classList.toggle("unreachable"); // div #main-container - ponownie zyskuje możliwośc klikania elementów;
            let textArea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
            resetError(textArea); // usunięcie zawartości <textarea> oraz komunikatu z błędem;
                //let successMsg = document.querySelector(".archive-success");
                //let successMsg = $("span.archive-success");
            let successMsg = removeBox.querySelector("span.archive-success"); // serwer zwraca te dane (remove-order.php); --> "Udało się zarchiwizować zamówienie";
            let errorMsg = removeBox.querySelector("span.update-failed"); // (remove-order.php); --> "Wystąpił problem. Nie udało się zarchiwizować zamówienia";
            if (successMsg) {     // jeśli element istnieje w kodzie HTML / DOM (jeśli "istnieje");
                successMsg.remove();
            }
            if (errorMsg) {     // jeśli element istnieje w kodzie HTML / DOM (jeśli "istnieje");
                errorMsg.remove();
            }
            //let confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]'); // "Potwierdź"
            let cancelButton = removeBox.querySelector('button.cancel-order'); // "Anuluj"*
            let form = removeBox.querySelector('.remove-order');
            let textarea = removeBox.querySelector('textarea[name="comment"]'); // <textarea>
                /*confirmButton.style.display = "initial"; //
                cancelButton.style.display = "initial";*/
            //confirmButton.classList.toggle("hidden", false); // remove "hidden" class;
            cancelButton.classList.toggle("hidden", false);
            form.classList.toggle("hidden", false);
        }
    }
});

window.addEventListener("load", () => {
    let orders = document.querySelector(".order");
    if (!orders) {
        document.getElementById("content").append("Brak przypisanych zamówień");
    }
});