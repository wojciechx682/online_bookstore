
let updateBtn = document.querySelector("button.update-order-status");
let statusBox = document.getElementById("update-status");
let mainContainer = document.getElementById("main-container");
let icon = document.querySelector(".icon-cancel");
let cancelBtn = document.querySelector(".cancel-order");
let buttons = [updateBtn, icon, cancelBtn];

buttons.forEach(function(button) {
    button.addEventListener("click", toggleBox);
});

function toggleBox() {
    statusBox.classList.toggle("hidden");
    mainContainer.classList.toggle("bright");
    mainContainer.classList.toggle("unreachable");
    resetBox();
}

function resetBox() {
    let form = document.getElementById("update-order-date");1
    form.classList.toggle("hidden", false);
    let cancelBtn = document.querySelector('.cancel-order');
    cancelBtn.classList.toggle("hidden", false);
    $('.update-success').remove();
    $("span.date-error").hide();
    $("span.update-failed").remove();
    resetDateInputs();
    let list = document.getElementById("status-list");
    list.selectedIndex = 0;
    let div = document.querySelector(".delivery-date");
    div.classList.toggle("hidden", true);
}

function resetDateInputs() {
    let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"], form#update-order-date input[type="time"]');
    dateInputs.forEach(function(dateInput) {
        dateInput.value = "";
    });
}

let dateInputs = document.querySelectorAll('form#update-order-date input[type="date"], form#update-order-date input[type="time"]');

dateInputs.forEach(function(dateInput) {
    dateInput.addEventListener("focus", function() {
        $("span.date-error").hide();
    });
});

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
