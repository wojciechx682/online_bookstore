
let updateBtn = document.querySelector("button.update-order-status");  // button - "Aktualizuj" zmianę statusu

let statusBox = document.getElementById("update-status");    // okiento zmiany statusu; div #update-status .hidden;
let mainContainer = document.getElementById("main-container");
let icon = document.querySelector(".icon-cancel");           // <i class="icon-cancel">
let cancelBtn = document.querySelector(".cancel-order");     // przycisk "Anuluj"; button.cancel-order;

console.log("\nstatusBox #update-status --> ", statusBox);
console.log("\nmainContainer --> ", mainContainer);
console.log("\nicon --> ", icon);
console.log("\ncancelBtn --> ", cancelBtn);

/* /!* v1 --> *!/ updateBtn.addEventListener("click", function() {
    toggleBox(); // pojawienie się okienka po kliknięciu przycisku "Aktualizuj";  <div id="update-status">;
                 // toggle class="hidden"; + resetBox();
});
icon.addEventListener("click", function() {
    toggleBox(); // zamknięcie okna po kliknięciu "x";
});
cancelBtn.addEventListener("click", function() {
    toggleBox(); // przycisk "Anuluj";
});*/

/* /!* v2 --> *!/ updateBtn.addEventListener("click", toggleBox);
icon.addEventListener("click", toggleBox);
cancelBtn.addEventListener("click", toggleBox);*/

let buttons = [updateBtn, icon, cancelBtn];
//             Aktualizuj  "X"   "Anuluj"

/*for(let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", toggleBox);
}*/

buttons.forEach(function(button) {
    button.addEventListener("click", toggleBox);
});

function toggleBox() {
    // after clicking the button --> "Aktualizuj"; "X"; "Anuluj"
    statusBox.classList.toggle("hidden");
    // przełączenie widoczności okna;
    mainContainer.classList.toggle("bright");
    mainContainer.classList.toggle("unreachable");
    resetBox(); // po pomyślnej zmianie statusu - "Udało się zmienić ..."
}

// po kliknięciu dowolnego przycisku z tablicy `buttons` (zakładając, że tablica została poprawnie wypełniona elementami przycisków), zostanie wywołana funkcja `toggleBox`. Ta funkcja przełącza widoczność elementu `statusBox`, zmienia wygląd `mainContainer` i potencjalnie wykonuje dodatkowe działania, jeśli `resetBox` jest zdefiniowane i wywołane w ramach funkcji.

/* function resetUrl() {
     // Get the current URL without the query parameters
     // let urlWithoutParams = window.location.href.split('?')[0];
     // Replace the current URL without query parameters in the browser's history
     // window.history.replaceState({}, document.title, urlWithoutParams);

     // Get the current URL
     var url = new URL(window.location.href);
     //var url = JSON.parse(window.location.href);
     // Create a URLSearchParams object from the URL's search parameters
     var searchParams = new URLSearchParams(url.search);
     // Remove the specific parameter
     searchParams.delete('status');
     // Replace the current URL's search parameters with the updated ones
     url.search = searchParams.toString();
     // Get the modified URL without the specified parameter
     var modifiedURL = url.toString();
     console.log("\n modifiedURL -> ", modifiedURL);
     //window.location.href = modifiedURL; // ta linia zmienia URL na taki, aby nie wyskakiwało okno zmiany statusu po odświeżeniu;
                                           // można to przenieść (?) gdzie indziej, np po kliknięciu (zamknięciu) okna zmiany statusu - tak aby po odświeżeniu storny nie pojawiało się ono ponownie;
 }
*/
function resetBox() {
    // after clicking the button --> Aktualizuj  "X"   "Anuluj"
    // when changing status was succesfull - "Udało się zmienić ..."
    let form = document.getElementById("update-order-date");
    // zresetowanie zawartości okna - po jego zamknięciu;

    /*if(form.style.display === "none") {
        form.style.display = "block";
    }*/
    form.classList.toggle("hidden", false);

    let cancelBtn = document.querySelector('.cancel-order'); // "Anuluj";
    /*if(cancelBtn.style.display === "none") {
        cancelBtn.style.display = "block";
    }*/
    cancelBtn.classList.toggle("hidden", false);

    $('.update-success').remove(); // "Udało się zmienić status zamówienia";
    $("span.date-error").hide(); // "Podaj poprawną datę"
    $("span.update-failed").remove(); // "Wystąpił problem. Nie udało się zmienić statusu zamówienia"

    resetDateInputs();

    let list = document.getElementById("status-list");
    list.selectedIndex = 0;

    let div = document.querySelector(".delivery-date");
    div.classList.toggle("hidden", true);
}

function resetDateInputs() {
    let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"], form#update-order-date input[type="time"]');
    dateInputs.forEach(function(dateInput) { // zmiana elementu listy wyboru resetuje zawartość inputów typu date;
        dateInput.value = "";
    });
}

// -----------------------------------------------------------------------------------------------------------------
// kliknięcie na datę usuwa kom. o błędzie;

let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"], form#update-order-date input[type="time"]'); // querySelectorAll() is a method of the Document object that allows you to select multiple elements in the document based on a CSS selector;

dateInputs.forEach(function(dateInput) { // loop through each input element;
    dateInput.addEventListener("focus", function() { // add the event listener to each input element;
        $("span.date-error").hide(); // perform your desired actions when the input is focused;
        //$("div.delivery-date button").css('margin-top', '70px'); // (?)
    });
});

// -----------------------------------------------------------------------------------------------------------------

let list = document.getElementById("status-list"); // lista <select> - zmiana opcji wyboru;

list.addEventListener("change", function() {

    $("span.date-error").hide();
    $("span.update-success").remove();

    resetDateInputs();

    //resetBox();

    const selectedOption = this.options[this.selectedIndex]; // <option> ELEMENT that was selected - after "change" event;
    const deliveryDate = document.querySelector(".delivery-date"); // div class="delivery-date" --> form id="update-order-date";
    const form = document.querySelector("form#update-order-date"); // div class="delivery-date" --> form id="update-order-date";
    const cancelBtn = document.querySelector(".cancel-order");

    const expDeliveryDate = document.querySelector("form#update-order-date label:nth-of-type(1)"); // <label> - input - termin_dostawy;
    const sentDate = document.querySelector("form#update-order-date label:nth-of-type(2)"); // <label> - input - data_wysłania_zamówienia;
    const sentTime = document.querySelector("form#update-order-date label:nth-of-type(3)"); // <label> - input - data_dostarczenia;
    const dateDelivered = document.querySelector("form#update-order-date label:nth-of-type(4)"); // <label> - input - data_dostarczenia;
    // const div = document.querySelector("div.delivery-date"); // div > form
    // const btns = document.querySelectorAll("div.delivery-date button");
    const dateError = document.querySelector('span.date-error');
    form.classList.toggle("hidden", false);
    cancelBtn.classList.toggle("hidden", false);

    console.log("\nsentTime --> \n", sentTime);

    //deliveryDate.style.display = "block"; // <div class="delivery-date">
    deliveryDate.classList.toggle("hidden", false);

    if(selectedOption.innerHTML === "W trakcie realizacji") {

        //form.style.display = "block"; // <div class="delivery-date">

        dateError.style.marginTop = "-2px";

        /*if(expDeliveryDate.style.display === "none") { // termin_dostawy
            expDeliveryDate.style.display = "block";
        }*/
        if(expDeliveryDate.classList.contains("hidden")) { // termin_dostawy
            expDeliveryDate.classList.remove("hidden");
        }
        /*if(sentDate.style.display === "block") { // data_wysłania_zamowienia
            sentDate.style.display = "none";
        }*/
        if(!sentDate.classList.contains("hidden")) { // data_wysłania_zamowienia
            sentDate.classList.add("hidden");
        }
        /*if(sentTime.style.display === "block") {
            sentTime.style.display = "none";
        }*/
        if(!sentTime.classList.contains("hidden")) {
            sentTime.classList.add("hidden");
        }
        /*if(dateDelivered.style.display === "block") { // data_dostarczenia
            dateDelivered.style.display = "none";
        }*/
        if(!dateDelivered.classList.contains("hidden")) { // data_dostarczenia
            dateDelivered.classList.add("hidden");
        }
        /*if(deliveryDate.style.paddingTop !== "20px") { // (?)
            deliveryDate.style.paddingTop = "20px";
        }*/
        if(deliveryDate.style.paddingTop !== "20px") {
            deliveryDate.style.paddingTop = "20px";
        }

        $('div#update-status .update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj", (!)
            $(element).css('margin-top', '90px');
        });

    } else if (selectedOption.innerHTML === "Wysłano") {

        dateError.style.marginTop = "20px";

        // form.style.display = "block"; // termin dostawy
        // console.log("\ndeliveryDate => ", deliveryDate);

        /*sentDate.style.display = "block"; // data_wysłania*/
        sentDate.classList.remove("hidden");

        sentDate.style.marginBottom = "20px"; // (!)

        deliveryDate.style.paddingTop = "20px"; // div.delivery-date --> form

        /*if(dateDelivered.style.display === "block") { // data_dostarczenia
            dateDelivered.style.display = "none";
        }*/
        if(!dateDelivered.classList.contains("hidden")) { // data_dostarczenia
            dateDelivered.classList.add("hidden")
        }

        /*if(expDeliveryDate.style.display === "none") { // termin dostawy;  <input type="date" ...>
            expDeliveryDate.style.display = "block";
        }*/
        if(expDeliveryDate.classList.contains("hidden")) { // termin dostawy;  <input type="date" ...>
            expDeliveryDate.classList.remove("hidden")
        }
        /*sentTime.style.display = "block";*/

        sentTime.classList.remove("hidden");


        /*for(let i=0; i<btns.length; i++) {
        updateBtn[i].style.marginTop = "50px";
        }*/
        /*$('.update-order-status').each(function(element) {
        $(element).css('margin-top', '50px'); // Set margin-top for each element
        console.log("183");
        });*/

        $('div#update-status .update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj", (!) X "Aktualizuj";
            $(element).css('margin-top', '60px');
        });

        /* $(document).ready(function() {
        $('.my-class').each(function(index, element) {
        $(element).css('margin-top', index * 10); // Set margin-top for each element
        });
        }); */
//updateBtn.style.marginTop = "50px";
        /* deliveryDate.setAttribute('type', 'date');
        deliveryDate.setAttribute('name', 'delivery-date'); */
// newInput.setAttribute('', 'Enter your new input here');
// form.appendChild(deliveryDate);

    } else if (selectedOption.innerHTML === "Dostarczono") {

        dateError.style.marginTop = "-2px";

        // form.style.display = "block";

        /*expDeliveryDate.style.display = "none"; // termin_dostawy*/
        expDeliveryDate.classList.add("hidden");

        /*if(sentDate.style.display === "block") { // data_wysłania;
            sentDate.style.display = "none";
        }*/
        if(!sentDate.classList.contains("hidden")) { // data_wysłania;
            sentDate.classList.add("hidden");
        }
        /*if(sentTime.style.display === "block") { // data_wysłania;
            sentTime.style.display = "none";
        }*/
        if(!sentTime.classList.contains("hidden")) { // data_wysłania;
            sentTime.classList.add("hidden");
        }

        //dateDelivered.style.display = "block"; // data_dostarczenia;
        dateDelivered.classList.remove("hidden"); // data_dostarczenia;

        if(deliveryDate.style.paddingTop !== "20px") { // (?)
            deliveryDate.style.paddingTop = "20px";
        }

        $('div#update-status .update-order-status').each(function(index, element) { // <button> --> "Potwierdź", "Anuluj", (!) "Aktualizuj";
            $(element).css('margin-top', '95px');
        });

    } else {
        //deliveryDate.style.display = "none";
        deliveryDate.classList.toggle("hidden", true);
        //sentDate.style.display = "none";
        sentDate.classList.add("hidden");
    }
});

function finishUpdate() {
    // ukrycie formularza + buttona "Anuluj" - po pomyślnym zrealizowaniu zapytania typu update (.done(), .fail());
    const form = document.getElementById("update-order-date"); // ukrycie formularza (zawiera przycisk "Potwierdź") - <form #update-order-date>
    const btn = document.querySelector(".cancel-order");       // ukrycie przycisku "Anuluj"
    /*form.style.display = "none";
    btn.style.display = "none";*/

    form.classList.add("hidden");
    btn.classList.add("hidden");

    let list = document.getElementById("status-list");  // <select> list;
    let option = list.options[list.selectedIndex];      // currently selected <option> element;
    //$("span.order-status-name").text(option.innerHTML); // zmiana wyświetlanego statusu po jego zmianie;
}

// kliknięcie "Esc" zamyka okno zmiany statusu;

document.addEventListener("keydown", function(event) {
    let statusBox = document.getElementById("update-status"); // całe okieno zmiany statusu; <div id="update-status">
    if(!statusBox.classList.contains("hidden")) { // jeśli element jest widoczny;
        if (event.key === "Escape") {
            //console.log('Esc key pressed'); // add code here to perform an action when Esc key is pressed
            toggleBox(); // zamknięcie okna;
        }
    }
});
