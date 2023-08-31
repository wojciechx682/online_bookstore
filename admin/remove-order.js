
// okienko archiwizowania zamówienia - admin/orders.php -> <form>
//                                                          -> name="order-id" (1125),  <- input type="hidden"
//                                                             name="comment" (abcde);  <- textarea

//$("form.remove-order").on("submit", function(e) { // po wysłaniu formularza;

document.querySelector("form.remove-order").addEventListener("submit", function(event) { // po wysłaniu formularza;
    // plik JS -> wysyłający formularz z wykorzystaniem AJAX (jQuery);
        // plik "remove-order.php" -> obsługuje żądanie, odbiera dane i wykonuje zapytanie do BD; zwraca komunikat błędu lub sukcesu;
    event.preventDefault(); // prevent form submission (default behaviour);
    let form = this; // element który wywołał zdarzenie (form) - obiekt DOM;
        console.log("\nform -->\n", form);
        console.log("\ntypeof form -->\n", typeof form);
    // pobranie danych z formularza;
        //let data = $(this); // obiekt jQuery zawierający formularz - <form>;
        //let orderId = data[0][0].value; // ✓ id-zamówienia (string);
        //let orderId = this.querySelector('input[type="hidden"][name="order-id"]').value; // ✓ id-zamówienia (string);
    let orderId = this.elements["order-id"].value; // ✓ id-zamówienia (string); this.elements["order-id"].value;
        console.log("\norderId => ", orderId);
        console.log("\norderId => ", typeof orderId);
    //let comment = data[0][1].value; // ✓ komentarz (powód) archiwizowania (string);
    //let comment = this.querySelector('textarea[name="comment"][id="comment"]').value; // ✓ komentarz (powód) archiwizowania (string);
    let comment = this.elements["comment"].value; // ✓ komentarz (powód) archiwizowania (string); this.elements.comment.value;
        console.log("\ncomment => ", comment);
        console.log("\ncomment => ", typeof comment);
    console.log("\n form => ", this);
    console.log("\nform elements => ", this.elements);
    let confirmButton = this.querySelector('button[type="submit"]'); // "Potwierdź" - <button type="submit">;
    let deliveryDateDiv = this.closest(".delivery-date"); // przodek formularza, <div class="delivery-date">;
    let cancelButton = deliveryDateDiv.querySelector(".cancel-order"); // "Anuluj"

    // Sanityzacja danych wejściowych - Wyczyszczenie niebezpiecznych zapisów - Komentarz;
    const sanitizedComment = DOMPurify.sanitize(comment); // it works, but How ?
    //const sanitizedComment = DOMPurify.sanitize(comment, { USE_PROFILES: { html: true } });
    const sanitizedOrderId = DOMPurify.sanitize(orderId);
        console.log('\n\n comment --> \n\n', comment);
        console.log('\n\n sanitizedComment --> \n\n', sanitizedComment);
    // Walidacja wprowadzonych danych (niebezpieczne znaki, długość);

    if (comment !== sanitizedComment ||
       sanitizedComment.length < 10 ||
       sanitizedComment.length > 255 ||
       orderId !== sanitizedOrderId ) {
        // niebezpieczne znaki - lub - niepoprawna długość;
            //$('.remove-order-error').css('display', 'block'); // pokaż komunikat z błędem;
            //$(".remove-order-error").removeClass("hidden"); // pokaż komunikat z błędem;
        document.querySelector(".remove-order-error").classList.remove("hidden"); // pokaż komunikat z błędem;

    } else {

        //$('.remove-order-error').css('display', 'none'); // usuń komunikat z błędem
        //$(".remove-order-error").addClass("hidden");
        document.querySelector(".remove-order-error").classList.add("hidden"); // pokaż komunikat z błędem;

        /*$.ajax({
            type: "POST",                    // GET or POST;
            url: "remove-order.php",         // Path to file (that process the <form> data);
            data: dataSerialized,                  // serialized <form> data; -   dane formularza;
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {         // Before Ajax - function called before sending the request;
                // (?)
            },
            complete: function() {           // Once finished - function called always after sending request;

            },
            success: function(data) {        // Show content;
                    let div = 'div.order-status'+orderId;
                    $(div).html("Zarchiwizowane");     // <table> -> div.order-status;
                confirmButton.hide();                  // "Potwierdź";
                cancelButton.hide();                   // "Anuluj";
                $("div.delivery-date").append(data);   // data - (!) dane zwrócone z serwera;
                // finishArchive();
            },
            error: function(formData) {                                     // Show error msg
                    //$content.html('<div id="container">Please try again soon.</div>');
                confirmButton.hide(); // "Potwierdź";
                cancelButton.hide();  // "Anuluj";
                $("div.delivery-date").append(data).fadeIn(1000); // data - dane zwrócone z serwera;
            }
        });*/

        // zamiana na użycie metod .done(), .fail(), always() - ponieważ success, error, complete - są przestarzałe (deprecated) -->

        /*$.ajax({
            type: "POST",                    // GET or POST;
            url: "remove-order.php",         // Path to file (that process the <form> data);
            data: dataSerialized,                  // serialized <form> data; -   dane formularza;
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {         // Before Ajax - function called before sending the request;
                // (?)
            },
            complete: function() {           // Once finished - function called always after sending request;

            },
            success: function(data) {        // Show content;
                let div = 'div.order-status'+orderId;
                $(div).html("Zarchiwizowane");     // <table> -> div.order-status;
                confirmButton.hide();                  // "Potwierdź";
                cancelButton.hide();                   // "Anuluj";
                $("div.delivery-date").append(data);   // data - (!) dane zwrócone z serwera;
                // finishArchive();
            },
            error: function(formData) {                                     // Show error msg
                //$content.html('<div id="container">Please try again soon.</div>');
                confirmButton.hide(); // "Potwierdź";
                cancelButton.hide();  // "Anuluj";
                $("div.delivery-date").append(data).fadeIn(1000); // data - dane zwrócone z serwera;
            }
        });*/

        // zamiana na użycie metod .done(), .fail(), always() - ponieważ success, error, complete - są przestarzałe (deprecated) -->

        //let dataSerialized = $(this).serialize(); // serializacja danych formularza (text);
        //console.log("\n\n dataSerialized --> ", dataSerialized);

        // order-id=1273&comment=asdasdasdasdasdasdasdasd

        //return;

        $.ajax({
            type: "POST",
            url: "remove-order.php",
            /*data: dataSerialized,*/
            data: {
                "order-id": sanitizedOrderId,
                "comment": sanitizedComment
            },
            timeout: 2000,
            beforeSend: function() { // before ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) { // (data, textStatus, jqXHR) // Success handler; // Handle the response data;

            /*$("div.order-status"+sanitizedOrderId).html("Zarchiwizowane"); // Pole ze statutem zamówienia w tabeli // div.order-status;
                form.classList.add("hidden"); // "Potwierdź";
                cancelButton.classList.add("hidden"); // "Anuluj";*!/
            $("div.delivery-date").append(data);   // data - dane zwrócone z serwera;*/

            //if(data.status === "success") {
            if(data.success === true) {
                $("div.order-status" + sanitizedOrderId).html("Zarchiwizowane");
                // ... inne akcje w przypadku sukcesu
                form.classList.add("hidden"); // "Potwierdź";
                cancelButton.classList.add("hidden"); // "Anuluj";
                $("div.delivery-date").append("<span class='archive-success'>" + data.message + "</span>");

            } else {
                form.classList.add("hidden");
                cancelButton.classList.add("hidden");
                $("div.delivery-date").append("<span class='update-failed'>" + data.message + "</span>");
            }

        }).fail(function(jqXHR, textStatus, errorThrown) { // (jqXHR, textStatus, errorThrown); // Error handler // Handle the error condition;

           /*   orm.classList.add("hidden");
                cancelButton.classList.add("hidden");
            $("div.delivery-date").append("<span class='update-failed'>Wystąpił problem. Nie udało się zarchiwizować zamówienia</span>"); // data - dane zwrócone z serwera;
            //$("div.delivery-date").append("<span class='update-failed'>Odpowiedź z serwera: " + jqXHR.responseText + "</span>");
            //$("div.delivery-date").append("<span class='update-failed'>Status: " + textStatus + "</span>"); // to samo co jqXHR.statusText
            $("div.delivery-date").append("<span class='update-failed'>Status: " + jqXHR.statusText + "</span>");
           //$("div.delivery-date").append("<span class='update-failed'>Błąd: " + errorThrown + "</span>");
            console.log("Odpowiedź z serwera:", jqXHR);
            console.log("Odpowiedź z serwera:", jqXHR.responseText);
            console.log("Status:", textStatus);
            //console.log("Błąd:", errorThrown);*/


/*form.classList.add("hidden");
cancelButton.classList.add("hidden");
$("div.delivery-date").append("<span class='update-failed'>Wystąpił problem. Nie udało się zarchiwizować zamówienia</span>");
$("div.delivery-date").append("<span class='update-failed'>Status: " + jqXHR.statusText + "</span>");
//$("div.delivery-date").append("<span class='update-failed'>Status: " + textStatus + "</span>");
    console.log("jqXHR:", jqXHR);
    console.log("jqXHR:", jqXHR.status); // Kod statusu HTTP (np. 404 dla "Not Found" lub 200 dla "OK").
    console.log("jqXHR:", jqXHR.statusText); // Tekst opisujący kod statusu HTTP (np. "Not Found" lub "OK").
    console.log("jqXHR:", jqXHR.responseText); // Surowa odpowiedź zwrócona przez serwer.
    //console.log("jqXHR:", jqXHR.responseJSON); // Jeżeli serwer zwraca odpowiedź w formacie JSON, jQuery automatycznie sparsuje ją i zapisze tutaj.
    console.log("Status:", textStatus); // "timeout", "error", "abourt", "parseerror"
    console.log("Error:", errorThrown);*/


            form.classList.add("hidden");
            cancelButton.classList.add("hidden");
            /*let errorMsg = "Wystąpił problem. Nie udało się zarchiwizować zamówienia";
                if (jqXHR.status === 404) {
                    errorMsg = "Nie znaleziono serwera.";
                } /!*else if (jqXHR.status === 500) {
                    errorMsg = "Błąd serwera. Proszę spróbować później.";
                } *!/ else if (textStatus === 'timeout') {
                    errorMsg = "Przekroczony czas żądania.";
                } else if (textStatus === 'abort') {
                    errorMsg = "Żądanie zostało przerwane.";
                } else if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    errorMsg = jqXHR.responseJSON.message;
                }*/
            $("div.delivery-date").append("<span class='update-failed'>Wystąpił problem. Nie udało się zarchiwizować zamówienia</span>");
            $("div.delivery-date").append("<span class='update-failed'>" + textStatus + " " + jqXHR.status + " " + jqXHR.statusText + "</span>");
            //$("div.delivery-date").append("<span class='update-failed'> errorMessage - " + errorMsg + "</span>");

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