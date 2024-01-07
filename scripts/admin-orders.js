function removeOrder(orderId) {

    let removeBox = document.querySelector(".update-status");
    let input = removeBox.querySelector('form.remove-order > input[type="hidden"][name="order-id"]');
    input.value = orderId;
    removeBox.classList.toggle("hidden");
    let mainContainer = document.getElementById("main-container");
    mainContainer.classList.toggle("bright");
    mainContainer.classList.toggle("unreachable");
    let icon = document.querySelector(".icon-cancel");
    let cancelBtn = document.querySelector(".cancel-order");

    buttons = [icon, cancelBtn]; // "✖", "Anuluj";
    buttons.forEach(function(button) {
        button.addEventListener("click", closeRemoveBox);
    });

    function closeRemoveBox() {
        mainContainer.classList.toggle("unreachable", false);
        let textarea = removeBox.querySelector("textarea");
        resetError(textarea);
        removeBox.classList.toggle("hidden", true);
        mainContainer.classList.toggle("bright", false);
        removeMessagesAndResetButtons(removeBox);
    }
    function removeMessagesAndResetButtons(removeBox) {
        const spanMsgs = removeBox.querySelectorAll("span.archive-success, span.update-failed");
        const cancelButton = removeBox.querySelector('button.cancel-order');
        const form = removeBox.querySelector('.remove-order');
        for(let i = 0; i < spanMsgs.length; i++) {
            let resultMsg = spanMsgs[i];
            if(resultMsg) {
                resultMsg.remove();
            }
        }
        cancelButton.classList.toggle("hidden", false);
        form.classList.toggle("hidden", false);
    }
    let deliveryDate = document.querySelector(".delivery-date");
    deliveryDate.classList.toggle("hidden", false);
}
function resetError(textarea) {
    let spanError = textarea.nextElementSibling;
    spanError.classList.toggle("hidden", true);
    textarea.value = "";
}
document.addEventListener("keydown", function(event) {

    let removeBox = document.querySelector("div.update-status");
    let mainContainer = document.getElementById("main-container");

    if (!removeBox.classList.contains("hidden")) {

        if (event.key === "Escape") {

            removeBox.classList.toggle("hidden");
            mainContainer.classList.toggle("bright");
            mainContainer.classList.toggle("unreachable");
            let textArea = removeBox.querySelector("textarea");

            resetError(textArea);

            let successMsg = removeBox.querySelector("span.archive-success");
            let errorMsg = removeBox.querySelector("span.update-failed");

            if (successMsg) {
                successMsg.remove();
            }
            if (errorMsg) {
                errorMsg.remove();
            }
            let cancelButton = removeBox.querySelector('button.cancel-order'); // "Anuluj"*
            let form = removeBox.querySelector('.remove-order');
            let textarea = removeBox.querySelector('textarea[name="comment"]'); // <textarea>
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