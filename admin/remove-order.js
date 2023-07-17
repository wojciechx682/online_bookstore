
// okienko archiwizowania zamówienia - admin/orders.php

$("form.remove-order").on("submit", function(e) { // po wysłaniu formularza;

    // "plik wie, który formularz został wysłany - jest to tylko jeden - odpowiedni - a nie wszystie formularze - tj. te które istnieją w kodzie i jest ich tyle ile jest zamówień";
    // plik JS wysyłający formularz z wykorzystaniem AJAX;
    // plik "remove-order.php" obsługuje żądanie, odbiera dane i wykonuje zapytanie do BD.

    e.preventDefault();

    // pobranie danych z formularza;
    let data = $(this); // obiekt zawierający dane formularza;
    let postData = $(this).serialize(); // serializacja (text);

    let orderId = data[0][0].value;        // id-zamówienia (string);
        console.log("\norderId => ", orderId);

    let comment = data[0][1].value;        // komentarz (powód) archiwizowania (String);
        console.log("\ncomment => ", comment);

    //let textarea = data.find('textarea[name="comment"]'); // <textarea>;
    let confirmButton = data.find('button[type="submit"]'); // <button type="submit">;
    let deliveryDateDiv = data.closest(".delivery-date"); // przodek formularza, <div class="delivery-date">;
    let cancelButton = deliveryDateDiv.find(".cancel-order");

    // Sanityzacja danych wejściowych - Wyczyszczenie niebezpiecznych zapisów - Komentarz;

    const sanitizedComment = DOMPurify.sanitize(comment); // it works, but How ?
    //const sanitizedComment = DOMPurify.sanitize(comment, { USE_PROFILES: { html: true } });

    // Walidacja wprowadzonych danych (niebezpieczne znaki, długość);

    if((comment !== sanitizedComment) || (sanitizedComment.length < 10) || (sanitizedComment.length > 255) ) { // niebezpieczne znaki - lub - niepoprawna długość;

        $('.remove-order-error').css('display', 'block'); // komunikat z błędem;

    } else {

        $('.remove-order-error').css('display', 'none');

        /*$.ajax({
            type: "POST",                    // GET or POST;
            url: "remove-order.php",         // Path to file (that process the <form> data);
            data: postData,                  // serialized <form> data; -   dane formularza;
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
            data: postData,                  // serialized <form> data; -   dane formularza;
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

        $.ajax({
            type: "POST",
            url: "remove-order.php",
            data: postData,
            timeout: 2000
        }).done(function(data) {
            // Success handler; // Handle the response data;

            let div = 'div.order-status'+orderId;  // Pole ze statutem zamówienia w tabeli
            $(div).html("Zarchiwizowane");         // <table> -> div.order-status;
                confirmButton.hide();              // "Potwierdź";
                cancelButton.hide();               // "Anuluj";
            $("div.delivery-date").append(data);   // data - (!) dane zwrócone z serwera;
            // finishArchive();

        }).fail(function(data) { // (xhr, status, error)
            // Error handler // Handle the error condition;

            // echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić zarchiwizować zamówienia</span>";

            //$content.html('<div id="container">Please try again soon.</div>');
                confirmButton.hide();  // "Potwierdź";
                cancelButton.hide();   // "Anuluj";
            $("div.delivery-date").append(data); // data - dane zwrócone z serwera;
        });

    }
})