


document.querySelector("form.remove-order").addEventListener("submit", function(event) {

    event.preventDefault();
    let form = this;

    let orderId = this.elements["order-id"].value;
    let comment = this.elements["comment"].value;

    let confirmButton = this.querySelector('button[type="submit"]');
    let deliveryDateDiv = this.closest(".delivery-date");
    let cancelButton = deliveryDateDiv.querySelector(".cancel-order");

    const sanitizedComment = DOMPurify.sanitize(comment);
    const sanitizedOrderId = DOMPurify.sanitize(orderId);

    if (comment !== sanitizedComment ||
       sanitizedComment.length < 10 ||
       sanitizedComment.length > 255 ||
       orderId !== sanitizedOrderId ) {

        document.querySelector(".remove-order-error").classList.remove("hidden");

    } else {

        document.querySelector(".remove-order-error").classList.add("hidden"); // ukryj komunikat z błędem;

        $.ajax({
            type: "POST",
            url: "remove-order.php",
            /*data: dataSerialized,*/
            data: {
                "order-id": sanitizedOrderId,
                "comment": sanitizedComment
            },
            timeout: 2000,
            beforeSend: function() {
                // before ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) { // (data, textStatus, jqXHR) // Success handler; // Handle the response data;
            if(data.success === true) {
                $("div.order-status" + sanitizedOrderId).html("Zarchiwizowane");
                form.classList.add("hidden");
                cancelButton.classList.add("hidden");
                $("div.delivery-date").append("<span class='archive-success'>" + data.message + "</span>");
            } else {
                form.classList.add("hidden");
                cancelButton.classList.add("hidden");
                $("div.delivery-date").append("<span class='update-failed'>" + data.message + "</span>");
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
           // (jqXHR, textStatus, errorThrown); // Error handler // Handle the error condition;
            form.classList.add("hidden");
            cancelButton.classList.add("hidden");
            $("div.delivery-date").append("<span class='update-failed'>Wystąpił problem. Nie udało się zarchiwizować zamówienia</span>");
            $("div.delivery-date").append("<span class='update-failed'>" + textStatus + " " + jqXHR.status + " " + jqXHR.statusText + "</span>");
                console.log("jqXHR - ", jqXHR);
                console.log("jqXHR.status - ", jqXHR.status); // Kod statusu HTTP (np. 404 dla "Not Found" lub 200 dla "OK").
                console.log("jqXHR.statusText - ", jqXHR.statusText); // Tekst opisujący kod statusu HTTP (np. "Not Found" lub "OK").
                console.log("jqXHR.responseText - ", jqXHR.responseText); // Surowa odpowiedź zwrócona przez serwer.
                //console.log("jqXHR:", jqXHR.responseJSON); // Jeżeli serwer zwraca odpowiedź w formacie JSON, jQuery automatycznie sparsuje ją i zapisze tutaj.
                console.log("textStatus - ", textStatus); // "timeout", "error", "abourt", "parseerror", ... "success", "notmodified",
                console.log("errorThrown - ", errorThrown); // "timeout", "error", "abourt", "parseerror"
        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible");
        });
    }
});