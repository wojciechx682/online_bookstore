
// okienko archiwizowania zamówienia - admin/orders.php -> <form>
//                                                          -> name="order-id" (1125),  <- input type="hidden"
//                                                             name="comment" (abcde);  <- textarea

//$("form.remove-order").on("submit", function(e) { // po wysłaniu formularza;

document.querySelector('form.remove-order').addEventListener("submit", function(e) { // po wysłaniu formularza

    // ̶"̶p̶l̶i̶k̶ ̶w̶i̶e̶,̶ ̶k̶t̶ó̶r̶y̶ ̶f̶o̶r̶m̶u̶l̶a̶r̶z̶ ̶z̶o̶s̶t̶a̶ł̶ ̶w̶y̶s̶ł̶a̶n̶y̶ ̶-̶ ̶j̶e̶s̶t̶ ̶t̶o̶ ̶t̶y̶l̶k̶o̶ ̶j̶e̶d̶e̶n̶ ̶-̶ ̶o̶d̶p̶o̶w̶i̶e̶d̶n̶i̶ ̶-̶ ̶a̶ ̶n̶i̶e̶ ̶w̶s̶z̶y̶s̶t̶i̶e̶ ̶f̶o̶r̶m̶u̶l̶a̶r̶z̶e̶ ̶-̶ ̶t̶j̶.̶ ̶t̶e̶ ̶k̶t̶ó̶r̶e̶ ̶i̶s̶t̶n̶i̶e̶j̶ą̶ ̶w̶ ̶k̶o̶d̶z̶i̶e̶ ̶i̶ ̶j̶e̶s̶t̶ ̶i̶c̶h̶ ̶t̶y̶l̶e̶ ̶i̶l̶e̶ ̶j̶e̶s̶t̶ ̶z̶a̶m̶ó̶w̶i̶e̶ń̶"̶;̶

    // plik JS -> wysyłający formularz z wykorzystaniem AJAX;

    // plik "remove-order.php" -> obsługuje żądanie, odbiera dane i wykonuje zapytanie do BD.

    e.preventDefault(); // prevent form submission (default behaviour)

    // pobranie danych z formularza;
    let data = $(this); // obiekt jQuery zawierający formularz - <form>;

        //console.log("\n\n data --> \n\n", data);
        //console.log("\n\n typeof data --> \n\n", typeof data);

    let orderId = data[0][0].value;        // id-zamówienia (✓ string);
        console.log("\norderId => ", orderId);
        console.log("\norderId => ", typeof orderId);

    let comment = data[0][1].value;        // komentarz (powód) archiwizowania (✓ string);
        console.log("\ncomment => ", comment);
        console.log("\ncomment => ", typeof comment);

    //let textarea = data.find('textarea[name="comment"]'); // <textarea>;
    let confirmButton = data.find('button[type="submit"]'); // <button type="submit">;
    let deliveryDateDiv = data.closest(".delivery-date"); // przodek formularza, <div class="delivery-date">;
    let cancelButton = deliveryDateDiv.find(".cancel-order");

    // Sanityzacja danych wejściowych - Wyczyszczenie niebezpiecznych zapisów - Komentarz;

    const sanitizedComment = DOMPurify.sanitize(comment); // it works, but How ?
    //const sanitizedComment = DOMPurify.sanitize(comment, { USE_PROFILES: { html: true } });

    const sanitizedOrderId = DOMPurify.sanitize(orderId);

    /*console.log('\n\n comment --> \n\n', comment);
    console.log('\n\n sanitizedComment --> \n\n', sanitizedComment);*/

    // Walidacja wprowadzonych danych (niebezpieczne znaki, długość);

    if(comment !== sanitizedComment ||
       sanitizedComment.length < 10 ||
       sanitizedComment.length > 255 ||
       orderId !== sanitizedOrderId ) {

            // niebezpieczne znaki - lub - niepoprawna długość;
        $('.remove-order-error').css('display', 'block'); // pokaż komunikat z błędem;

    } else {

        $('.remove-order-error').css('display', 'none'); // usuń komunikat z błędem

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

        let dataSerialized = $(this).serialize(); // serializacja danych formularza (text);

        console.log("\n\n dataSerialized --> ", dataSerialized);

        $.ajax({
            type: "POST",
            url: "remove-order.php",
            data: dataSerialized,
            timeout: 2000,

            beforeSend: function() { // before ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }

        }).done(function(data) {
            // Success handler; // Handle the response data;

            let div = 'div.order-status'+orderId;  // Pole ze statutem zamówienia w tabeli
            $(div).html("Zarchiwizowane");         // <table> -> div.order-status;
                confirmButton.hide();              // "Potwierdź";
                cancelButton.hide();               // "Anuluj";
            $("div.delivery-date").append(data);   // data - dane zwrócone z serwera;


        }).fail(function(data) { // (xhr, status, error)
            // Error handler // Handle the error condition;

            // echo "<span class='update-failed'>Wystąpił problem. Nie udało się zmienić zarchiwizować zamówienia</span>";

            //$content.html('<div id="container">Please try again soon.</div>');
                confirmButton.hide();  // "Potwierdź";
                cancelButton.hide();   // "Anuluj";
            $("div.delivery-date").append(data); // data - dane zwrócone z serwera;
        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible");
        });


    }

});