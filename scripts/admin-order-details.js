
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

let list = document.getElementById("status-list");

list.addEventListener("change", function() {

    $("span.date-error").hide();
    $("span.update-success").remove();

    resetDateInputs();

    const selectedOption = this.options[this.selectedIndex];
    const deliveryDate = document.querySelector(".delivery-date");
    const form = document.querySelector("form#update-order-date");
    const cancelBtn = document.querySelector(".cancel-order");

    const expDeliveryDate = document.querySelector("form#update-order-date label:nth-of-type(1)");
    const sentDate = document.querySelector("form#update-order-date label:nth-of-type(2)");
    const sentTime = document.querySelector("form#update-order-date label:nth-of-type(3)");
    const dateDelivered = document.querySelector("form#update-order-date label:nth-of-type(4)");

    const dateError = document.querySelector('span.date-error');
    form.classList.toggle("hidden", false);
    cancelBtn.classList.toggle("hidden", false);
    deliveryDate.classList.toggle("hidden", false);

    if(selectedOption.innerHTML === "W trakcie realizacji") {

        dateError.style.marginTop = "-2px";

        if(expDeliveryDate.classList.contains("hidden")) {
            expDeliveryDate.classList.remove("hidden");
        }
        if(!sentDate.classList.contains("hidden")) {
            sentDate.classList.add("hidden");
        }
        if(!sentTime.classList.contains("hidden")) {
            sentTime.classList.add("hidden");
        }
        if(!dateDelivered.classList.contains("hidden")) {
            dateDelivered.classList.add("hidden");
        }
        if(deliveryDate.style.paddingTop !== "20px") {
            deliveryDate.style.paddingTop = "20px";
        }

        $('div#update-status .update-order-status').each(function(index, element) {
            $(element).css('margin-top', '90px');
        });

    } else if (selectedOption.innerHTML === "Wysłano") {

        dateError.style.marginTop = "20px";
        sentDate.classList.remove("hidden");
        sentDate.style.marginBottom = "20px";
        deliveryDate.style.paddingTop = "20px";

        if(!dateDelivered.classList.contains("hidden")) {
            dateDelivered.classList.add("hidden")
        }
        if(expDeliveryDate.classList.contains("hidden")) {
            expDeliveryDate.classList.remove("hidden")
        }
        sentTime.classList.remove("hidden");

        $('div#update-status .update-order-status').each(function(index, element) {
            $(element).css('margin-top', '60px');
        });

    } else if (selectedOption.innerHTML === "Dostarczono") {

        dateError.style.marginTop = "-2px";
        expDeliveryDate.classList.add("hidden");

        if(!sentDate.classList.contains("hidden")) {
            sentDate.classList.add("hidden");
        }
        if(!sentTime.classList.contains("hidden")) {
            sentTime.classList.add("hidden");
        }
        dateDelivered.classList.remove("hidden");

        if(deliveryDate.style.paddingTop !== "20px") {
            deliveryDate.style.paddingTop = "20px";
        }
        $('div#update-status .update-order-status').each(function(index, element) {
            $(element).css('margin-top', '95px');
        });

    } else {
        deliveryDate.classList.toggle("hidden", true);
        sentDate.classList.add("hidden");
    }
});

function finishUpdate() {
    const form = document.getElementById("update-order-date");
    const btn = document.querySelector(".cancel-order");
    form.classList.add("hidden");
    btn.classList.add("hidden");
    let list = document.getElementById("status-list");
    let option = list.options[list.selectedIndex];
}

document.addEventListener("keydown", function(event) {
    let statusBox = document.getElementById("update-status");
    if(!statusBox.classList.contains("hidden")) {
        if (event.key === "Escape") {
            toggleBox();
        }
    }
});
