
// order.php - usunięcie / zarchwizowanie / zamknięcie zamówienia
    // admin podaje powód (notatkę) - którą potem może wyświetlić klient;

function removeOrder(orderId) { // po kliknięciu przycisku "Archiwizuj"

                // Refactor - zamiana na tylko jedno okno Archiwizowania zamówienia ;

                console.log("\n orderId --> ", orderId); // "1130" ;

                        // let removeBox = document.getElementById("update-status"); // pojawienie się okenka po kliknięciu "Usuń";
                //let removeBox = document.querySelector(".update-status"+orderId);
                let removeBox = document.querySelector(".update-status");
                    // pojawienie się okenka po kliknięciu "Zarchiwizuj";

                // console.log("\n orderId --> ", removeBox); // <div class="update-status1035 hidden"> - OKIENKO PO KLIKNIĘCIU "ARCHIWIZUJ";

                console.log("\nremoveBox (okno archiwizowania zamówienia) --> ", removeBox);

// dodanie atrybutu "id" (order-id) do pól formularza (input type="hidden") -->

    let input = removeBox.querySelector('form.remove-order > input[type="hidden"]'); // input type="hidden"
        console.log('\n\n input --> ', input);
    input.value = orderId;

        // removeBox.querySelector('form.remove-order button[type="submit"]');

                /*if(removeBox.classList.contains("hidden")) {
                    removeBox.classList.toggle("hidden");
                }*/

                removeBox.classList.toggle("hidden");

                            //removeBox.classList.toggle("hidden");
                            /*removeBox.style.filter = "inherit";*/
                            //removeBox.classList.toggle('normal');

                let mainContainer = document.getElementById("main-container");

                /*if( ! mainContainer.classList.contains("bright")) {
                    mainContainer.classList.toggle("bright");
                }*/

                mainContainer.classList.toggle("bright");
            mainContainer.style.pointerEvents = "none";
            mainContainer.style.userSelect = "none";


                //mainContainer.classList.toggle("bright");

                        //let icon = document.querySelector(".icon-cancel" + orderId);
                let icon = document.querySelector(".icon-cancel");  // ikona "✖"

                        //let cancelBtn = document.querySelector(".cancel-order"+orderId);
                let cancelBtn = document.querySelector(".cancel-order"); // przycisk "Anuluj"


                    console.log("\nicon --> ", icon);
                    console.log("\ncancelBtn --> ", cancelBtn);

                // zamknięcie okna po kliknięciu "✖";

                icon.addEventListener("click", function() {
                    closeRemoveBox();
                });

                cancelBtn.addEventListener("click", function() {
                    closeRemoveBox();
                });


                /*icon.onclick = function() {

                    mainContainer.removeAttribute("style");

                        //toggleRemoveBox(removeBox, mainContainer);
                        let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
                        resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
                        //removeOrder(orderId); // rekurencja -> toggle - tym razem zamknięcie okienka;

                        console.log("\n 42 orderId --> ", orderId);

                        /!*if( ! removeBox.classList.contains("hidden")) {
                            removeBox.classList.toggle("hidden");
                        }*!/

                        removeBox.classList.toggle("hidden");

                        /!*if(mainContainer.classList.contains("bright")) {
                            mainContainer.classList.toggle("bright");
                        }*!/

                        mainContainer.classList.toggle("bright");

                        let successMsg = removeBox.querySelector("span.archive-success"); // komunikat potwierdzający Zarchiwizowanie zamówienia ;
                    let errorMsg = removeBox.querySelector("span.update-failed"); // komunikat opisujący błąd po nieudanej próbie wykonania żądania;


                    console.log("successMsg -> ", successMsg);

                    if(successMsg) {            // jeśli element istnieje w kodzie HTML (jeśli "istnieje");
                        successMsg.remove();

                            //let confirmButton = $('form.remove-order button[type="submit"]');
                            let confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
                            //let cancelButton = $('button.cancel-order');
                            let cancelButton = removeBox.querySelector('button.cancel-order');
                            //let textarea = $('textarea[name="comment"]');
                            //let textarea = removeBox.querySelector('textarea[name="comment"]');
                            console.log("confirmButton -> ", confirmButton);
                            console.log("cancelButton -> ", cancelButton);
                            //confirmButton.css("display", "block");
                            confirmButton.style.display = "initial";
                            //cancelButton.css("display", "block");
                            cancelButton.style.display = "initial";
                            //textarea.val("");
                    }

                    if(errorMsg) {            // jeśli element istnieje w kodzie HTML (jeśli "istnieje");
                        errorMsg.remove();
                        //let confirmButton = $('form.remove-order button[type="submit"]');
                        let confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
                        //let cancelButton = $('button.cancel-order');
                        let cancelButton = removeBox.querySelector('button.cancel-order');
                        //let textarea = $('textarea[name="comment"]');
                        //let textarea = removeBox.querySelector('textarea[name="comment"]');
                        console.log("confirmButton -> ", confirmButton);
                        console.log("cancelButton -> ", cancelButton);
                        //confirmButton.css("display", "block");
                        confirmButton.style.display = "initial";
                        //cancelButton.css("display", "block");
                        cancelButton.style.display = "initial";
                        //textarea.val("");

                    }


                    textarea.value = "";

                    //removeBox.classList.toggle("hidden");
                    //mainContainer.classList.toggle("bright");
                }*/

                /* icon.addEventListener("click", function() {

                });*/

                /*cancelBtn.onclick = function() {

                        mainContainer.removeAttribute("style");

                        let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
                        resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
                        //removeOrder(orderId); // przycisk "Anuluj"

                        console.log("\n 63 orderId --> ", orderId);

                        /!*if(!removeBox.classList.contains("hidden")) {
                            removeBox.classList.toggle("hidden");
                        }*!/

                        removeBox.classList.toggle("hidden");

                        /!*if(mainContainer.classList.contains("bright")) {
                            mainContainer.classList.toggle("bright");
                        }*!/

                        mainContainer.classList.toggle("bright");

                        let successMsg = removeBox.querySelector("span.archive-success");
                        console.log("successMsg -> ", successMsg);
                        let errorMsg = removeBox.querySelector("span.update-failed"); // komunikat opisujący błąd po nieudanej próbie wykonania żądania;


                        if(successMsg) {            // jeśli element istnieje w kodzie HTML (jeśli "istnieje");
                            successMsg.remove();
                            //let confirmButton = $('form.remove-order button[type="submit"]');
                            let confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
                            //let cancelButton = $('button.cancel-order');
                            let cancelButton = removeBox.querySelector('button.cancel-order');
                            //let textarea = $('textarea[name="comment"]');
                            //let textarea = removeBox.querySelector('textarea[name="comment"]');
                            console.log("confirmButton -> ", confirmButton);
                            console.log("cancelButton -> ", cancelButton);
                            //confirmButton.css("display", "block");
                            confirmButton.style.display = "initial";
                            //cancelButton.css("display", "block");
                            cancelButton.style.display = "initial";
                            //textarea.val("");
                         }

                    if(errorMsg) {            // jeśli element istnieje w kodzie HTML (jeśli "istnieje");
                        errorMsg.remove();
                        //let confirmButton = $('form.remove-order button[type="submit"]');
                        let confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
                        //let cancelButton = $('button.cancel-order');
                        let cancelButton = removeBox.querySelector('button.cancel-order');
                        //let textarea = $('textarea[name="comment"]');
                        //let textarea = removeBox.querySelector('textarea[name="comment"]');
                        console.log("confirmButton -> ", confirmButton);
                        console.log("cancelButton -> ", cancelButton);
                        //confirmButton.css("display", "block");
                        confirmButton.style.display = "initial";
                        //cancelButton.css("display", "block");
                        cancelButton.style.display = "initial";
                        //textarea.val("");
                    }


                    textarea.value = "";
                }*/

                /*cancelBtn.addEventListener("click", function() {

                });*/

                function closeRemoveBox() {

                    mainContainer.removeAttribute("style");
                    // toggleRemoveBox(removeBox, mainContainer);
                    let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
                    resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
                    textarea.value = "";
                    // removeOrder(orderId); // rekurencja -> toggle - tym razem zamknięcie okienka;
                    // console.log("\n 42 orderId --> ", orderId);

                    if(!removeBox.classList.contains("hidden")) { // jeśli okno jest widoczne
                        removeBox.classList.toggle("hidden");
                    }
                        //removeBox.classList.toggle("hidden");


                    if(mainContainer.classList.contains("bright")) { // jeśli tło jest ciemne
                        mainContainer.classList.toggle("bright");
                    }
                        //mainContainer.classList.toggle("bright");

                    removeMessagesAndResetButtons(removeBox);


                    //removeBox.classList.toggle("hidden");
                    //mainContainer.classList.toggle("bright");
                }


    function removeMessagesAndResetButtons(removeBox) {

        const successMsg = removeBox.querySelector("span.archive-success");
        const errorMsg = removeBox.querySelector("span.update-failed");
        const confirmButton = removeBox.querySelector('form.remove-order button[type="submit"]');
        const cancelButton = removeBox.querySelector('button.cancel-order');

        if (successMsg) {
            successMsg.remove();
            confirmButton.style.display = "initial";
        }
        if (errorMsg) {
            errorMsg.remove();
            confirmButton.style.display = "initial";
        }
        cancelButton.style.display = "initial";
    }

    $('.delivery-date').css("display", "block"); // wyświetlenie formularza (domyślnie był ukryty
                                                /*let div = document.querySelector(".delivery-date");
                                                div.classList.toggle("hidden");*/




}
