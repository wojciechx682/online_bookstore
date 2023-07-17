// order.php - usunięcie / zarchwizowanie / zamknięcie zamówienia

// admin podaje powód (notatkę) - którą potem może wyświetlić klient;

function removeOrder(order_id) { // po kliknięciu przycisku "Archiwizuj"

                // Refactor - zamiana na tylko jedno okno Archiwizowania zamówienia ;

                console.log("\n 7 order_id --> ", order_id);

                        // let removeBox = document.getElementById("update-status"); // pojawienie się okenka po kliknięciu "Usuń";
                //let removeBox = document.querySelector(".update-status"+order_id);
                let removeBox = document.querySelector(".update-status");
                    // pojawienie się okenka po kliknięciu "Zarchiwizuj";

                // console.log("\n order_id --> ", removeBox); // <div class="update-status1035 hidden"> - OKIENKO PO KLIKNIĘCIU "ARCHIWIZUJ";

                console.log("\nremoveBox (okno archiwizowania zamówienia) --> ", removeBox);

// dodanie atrybutu "id" (order-id) do pól formularza (input type="hidden") -->

    let input = removeBox.querySelector('form.remove-order > input[type="hidden"]'); // input type="hidden"
        console.log('\n\n input --> ', input);
    input.value = order_id;

        // removeBox.querySelector('form.remove-order button[type="submit"]');

                /*if(removeBox.classList.contains("hidden")) {
                    removeBox.classList.toggle("hidden");
                }*/

                removeBox.classList.toggle("hidden");

                            //removeBox.classList.toggle("hidden");
                            /*removeBox.style.filter = "inherit";*/
                            //removeBox.classList.toggle('normal');

                let allContainer = document.getElementById("main-container");

                /*if( ! allContainer.classList.contains("bright")) {
                    allContainer.classList.toggle("bright");
                }*/

                allContainer.classList.toggle("bright");
            allContainer.style.pointerEvents = "none";
            allContainer.style.userSelect = "none";


                //allContainer.classList.toggle("bright");

                        //let icon = document.querySelector(".icon-cancel" + order_id);
                let icon = document.querySelector(".icon-cancel");
                // ikona "✖"
                        //let cancelBtn = document.querySelector(".cancel-order"+order_id);
                let cancelBtn = document.querySelector(".cancel-order");
                // przycisk "Anuluj"

                    console.log("\nicon --> ", icon);
                    console.log("\ncancelBtn --> ", cancelBtn);

                // zamknięcie okna po kliknięciu "✖";

                icon.onclick = function() {

                    allContainer.removeAttribute("style");

                    //toggleRemoveBox(removeBox, allContainer);
                    let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
                    resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
                    //removeOrder(order_id); // rekurencja -> toggle - tym razem zamknięcie okienka;

                    console.log("\n 42 order_id --> ", order_id);

                        /*if( ! removeBox.classList.contains("hidden")) {
                            removeBox.classList.toggle("hidden");
                        }*/

                    removeBox.classList.toggle("hidden");

                        /*if(allContainer.classList.contains("bright")) {
                            allContainer.classList.toggle("bright");
                        }*/

                    allContainer.classList.toggle("bright");

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
                    //allContainer.classList.toggle("bright");
                }

                /* icon.addEventListener("click", function() {

                });*/

                cancelBtn.onclick = function() {

                    allContainer.removeAttribute("style");

                    let textarea = removeBox.querySelector("textarea"); // <textarea> w tym okienku (removeBox);
                    resetError(textarea); // usuwa komunikat o błędzie jeśli jest on widoczny;
                    //removeOrder(order_id); // przycisk "Anuluj"

                    console.log("\n 63 order_id --> ", order_id);

                           /* if(!removeBox.classList.contains("hidden")) {
                                removeBox.classList.toggle("hidden");
                            }*/

                    removeBox.classList.toggle("hidden");

                    /*if(allContainer.classList.contains("bright")) {
                        allContainer.classList.toggle("bright");
                    }*/

                    allContainer.classList.toggle("bright");

                    let successMsg = removeBox.querySelector("span.archive-success");
                    console.log("successMsg -> ", successMsg)

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
                }

                /*cancelBtn.addEventListener("click", function() {

                });*/

                $('.delivery-date').css("display", "block"); // wyświetlenie formularza (domyślnie był ukryty
                            /*let div = document.querySelector(".delivery-date");
                            div.classList.toggle("hidden");*/
}
