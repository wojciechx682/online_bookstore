
// order.php - usunięcie / zarchwizowanie / zamknięcie zamówienia
    // admin podaje powód (notatkę) - którą potem może wyświetlić klient;

function removeOrder(orderId) { // po kliknięciu przycisku "Archiwizuj";  orderId -> "1130";

// ✓ refactor - zamiana na tylko jedno okno Archiwizowania zamówienia ;

        // let removeBox = document.getElementById("update-status");
        // let removeBox = document.querySelector(".update-status"+orderId);
    let removeBox = document.querySelector(".update-status");
        // pojawienie się okienka po kliknięciu "Zarchiwizuj";
        console.log("\nremoveBox (okno archiwizowania zamówienia) --> ", removeBox); // <div class="update-status"></div>

    // dodanie atrybutu "id" (order-id) do pól formularza (input type="hidden") -->
    let input = removeBox.querySelector('form.remove-order > input[type="hidden"]'); // input type="hidden";
    input.value = orderId;

        /*if(removeBox.classList.contains("hidden")) {
            removeBox.classList.toggle("hidden");
        }*/

    removeBox.classList.toggle("hidden"); // pojawienie się okenka po kliknięciu "Zarchiwizuj";

    let mainContainer = document.getElementById("main-container");

        /*if( ! mainContainer.classList.contains("bright")) {
            mainContainer.classList.toggle("bright");
        }*/

    mainContainer.classList.toggle("bright"); // ✓ zmiana tła strony na ciemne (#main-container)
    /*mainContainer.style.pointerEvents = "none";
    mainContainer.style.userSelect = "none";*/
    mainContainer.classList.toggle("unreachable"); // ✓ wyłączenie możliwości kliknięcia czegokolwiek (w tle) poza okieniem archiwizowania;


        //let icon = document.querySelector(".icon-cancel" + orderId);
    let icon = document.querySelector(".icon-cancel");  // ikona "✖"
        //let cancelBtn = document.querySelector(".cancel-order"+orderId);
    let cancelBtn = document.querySelector(".cancel-order"); // przycisk "Anuluj"

        console.log("\nicon --> ", icon);
        console.log("\ncancelBtn --> ", cancelBtn);

        // zamknięcie okna po kliknięciu "✖";
        /*icon.addEventListener("click", function() {
            closeRemoveBox();
        });
        // zamknięcie okna po kliknięciu "Anuluj";
        cancelBtn.addEventListener("click", function() {
            closeRemoveBox();
        });*/

    buttons = [icon, cancelBtn];

    buttons.forEach(function(button) {
        button.addEventListener("click", closeRemoveBox);
    });

    function closeRemoveBox() {

        //mainContainer.removeAttribute("style");

        mainContainer.classList.toggle("unreachable", false); // remove "unreachable" class from #main-container ;
        let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
        resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
        //textarea.value = "";

        // removeBox.classList.toggle("hidden");

        /*if(!removeBox.classList.contains("hidden")) { // jeśli okno jest widoczne;
            removeBox.classList.toggle("hidden");
        }*/

        removeBox.classList.toggle("hidden", true); // ukrycie okna - dodanie klasy "hidden" ;  true - oznacza że klasa zostanie tylko dodana;


        // mainContainer.classList.toggle("bright");

        /*if(mainContainer.classList.contains("bright")) { // jeśli tło jest ciemne
            mainContainer.classList.toggle("bright");
        }*/

        mainContainer.classList.toggle("bright", false); // usunięcie ciemnego tła ; false - oznacza, że klasa zostanie tylko usunięta;


        removeMessagesAndResetButtons(removeBox);
    }


    function removeMessagesAndResetButtons(removeBox) {

            /*const successMsg = removeBox.querySelector("span.archive-success");
            const errorMsg = removeBox.querySelector("span.update-failed");*/
            const spanMsgs = removeBox.querySelectorAll("span.archive-success, span.update-failed");
        const confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
        const cancelButton = removeBox.querySelector('button.cancel-order');

            /*if (successMsg) {
                successMsg.remove();
                confirmButton.style.display = "initial";
            }
            if (errorMsg) {
                errorMsg.remove();
                confirmButton.style.display = "initial";
            }*/

        // better -> iterates over the collected spanMsgs NodeList using a for loop and removes each span individually if it exists.

        for(let i = 0; i < spanMsgs.length; i++) {
                let resultMsg = spanMsgs[i];
            if(resultMsg) {
                resultMsg.remove();
                confirmButton.style.display = "initial";
            }
        }

        cancelButton.style.display = "initial";
    }

    //$('.delivery-date').css("display", "block"); // wyświetlenie formularza (domyślnie był ukryty
                                                 // let div = document.querySelector(".delivery-date");
                                                 // div.classList.toggle("hidden");
    let deliveryDate = document.querySelector(".delivery-date");
    deliveryDate.classList.toggle("hidden", false);

}
