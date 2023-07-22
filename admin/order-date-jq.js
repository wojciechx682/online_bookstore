
// admin/order-details.php ;

// .success(), .error(), complete() - przestarzałe, zamiast nich, użyć -->
//                                                                .done(), .fail(), .always()

// https://api.jquery.com/jquery.ajax/

//   " ... Deprecation Notice: The jqXHR.success(), jqXHR.error(), and jqXHR.complete() callbacks are removed as of jQuery 3.0. You can use jqXHR.done(), jqXHR.fail(), and jqXHR.always() instead. ... "

// metody -> .done(), .fial(), always(), - nie będą wewnątrz funkcji $.ajax() - lecz doklejane ZA NIĄ (poza nią);

// $.ajax({
//   method: "POST",
//   url: "some.php",
//   data: { name: "John", location: "Boston" }
// })
//   .done(function( msg ) {
//     alert( "Data Saved: " + msg );
//   });

//$("form#update-order-date").on("submit", function(e) { // funkcja anonimowa ; // e - obiekt zdarzenia ;

document.querySelector('form#update-order-date').addEventListener("submit", function(e) {

    // use DOMPurify for date sanitization here ?

    e.preventDefault(); // e - obiekt zdarzenia;

    let data = $(this); // obiekt jQuery zawierający formularz - <form>;



    const todayDate = new Date(); // utworzenie obiektu klasy Date w calu walidacji daty;

    let hours = todayDate.getHours();
    let minutes = todayDate.getMinutes();
    let seconds = todayDate.getSeconds();
    /*if(seconds !== 0) {
        seconds -= 1;
    }*/

    let list = document.getElementById("status-list");       // <select> list;
    const selectedOption = list.options[list.selectedIndex]; // aktualnie wybrany element listy;

    // walidacja daty - kontrola błędów, czy data jest poprawna i znajduje się w odpowiednim przedziale (js);

    let expDeliveryDate = new Date(data[0][0].value); // termin_dostawy
    let sentDate = new Date(data[0][1].value);        // data_wysłania
    let dateDelivered = new Date(data[0][2].value);   // data_dostarczenia

    if(seconds < 60) {
        seconds += 1;
    }

    expDeliveryDate.setHours(hours, minutes, seconds);
    sentDate.setHours(hours, minutes, seconds);
    dateDelivered.setHours(hours, minutes, seconds);

    console.log("\n\n todayDate -> ", todayDate);
    console.log("\n\n hours -> ", hours);
    console.log("\n\n minutes -> ", minutes);
    console.log("\n\n seconds -> ", seconds);
    console.log("\n\n expDeliveryDate -> ", expDeliveryDate);
    console.log("\n\n sentDate -> ", sentDate);
    console.log("\n\n dateDelivered -> ", dateDelivered);

    console.log("\n\n isNaN(expDeliveryDate.getTime() -> ", isNaN(expDeliveryDate.getTime()));
    console.log("\n\n expDeliveryDate < todayDate -> ", expDeliveryDate < todayDate );

    if ( selectedOption.innerHTML === "W trakcie realizacji" && (isNaN(expDeliveryDate.getTime()) || expDeliveryDate < todayDate) ) {
            // przeszła data, lub pusta
        error(12);

    } else if ( selectedOption.innerHTML === "Wysłano" && (isNaN(expDeliveryDate.getTime()) || isNaN(sentDate.getTime()) || expDeliveryDate < todayDate || sentDate < todayDate || expDeliveryDate < sentDate) ) {
            // przeszła data, pusta, lub data_wysłania późniejsza niż termin_dostawy
        error(40);

    } else if ( selectedOption.innerHTML === "Dostarczono" && (isNaN(dateDelivered.getTime()) || dateDelivered < todayDate) ) {
            // przeszła data, lub pusta
        error(12);
    }
    else {
                /*$.ajax({
                    type: "POST",                    // GET or POST;    type of HTTP method;
                    url: "update-order-date.php",    // Path to file (that process the <form> data); // "Strona, do której kierowane jest żądanie";
                    data: dataSerialized,                  // serialized <form> data; // "dane wysłane do serwera wraz z żądaniem";
                    timeout: 2000,                   // Waiting time; - liczba mili-sekund - zanim nastąpi zdarzenie oznaczające niepowodzenie;

                    beforeSend: function() {         // Before ajax - function called before sending the request;

                        // funkcja (anonimowa / nazwana) - uruchamiana PRZED wykonaniem żądania Ajax;
                            // np. wyświetlenie ikony wczytywania danych - (kręcące się kółko) ;
                        // $content.append('<div id="load"> Wczytywanie </div>');
                        $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                    },
                        complete: function() {          // once finished - function called ALWAYS after sending request;
                            // funkcja uruchamiana PO WYKONANIU (zakończeniu) żądania - niezależnie od jego STANU (sukces / niepowodzenie) ;
                                // np. usunięcie ikony wczytywania danych - (kręcące się kółko) ;
                            // .always();   // .always( function() { // ... { )
                            $("img#loading-icon").toggleClass("not-visible");
                        },
                        success: function(formData) {   // show content;    - wyświetlenie zawartości ;
                            // funkcja uruchamiana, gdy wykonanie żądania Ajax zakończy się POWODZENIEM ;
                                // .done();     // .done( function(data) { // ... } )
                            // $content.html( $(data).find('#container') ) . hide().fadeIn(500);
                            finishUpdate();             // dataSerialized - dane otrzymane z serwera (response - odpowiedź);
                                $("div.delivery-date").append(formData);
                                // $content . html ( $(dataSerialized).find('#container') ) .hide().fadeIn(400);
                        },
                        error: function(formData) {     // show error msg;
                            // funkcja uruchamiana, gdy wykonanie żądania Ajax zakończy się NIEPOWODZENIEM ;
                                // .fail();     // .fail( function() { // ... } )
                            // wyświetlenie komunikatu o błędzie ;
                            finishUpdate();
                                $("div.delivery-date").append(formData);
                        }
                });*/

                // zamiana na użycie metod .done(), .fail(), always() - ponieważ    success, error, complete    - są przestarzałe (deprecated);

                let dataSerialized = $(this).serialize(); // serializacja danych formularza;  pobranie danych z formularza;  // dane w postaci tekstowej (string);

                    console.log("\n\n dataSerialized --> \n\n", dataSerialized);

                $.ajax({
                    type: "POST",
                    url: "update-order-date.php",
                    data: dataSerialized,
                    timeout: 2000,
                    beforeSend: function() {                              // before ajax - function called before sending the request;
                        $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                    }
                }).done(function(data) {
                    // success handler; // handle the response data;
                    finishUpdate(); // data - dane otrzymane z serwera (response - odpowiedź);
                        $("div.delivery-date").append(data);
                }).fail(function(data) {
                    finishUpdate();
                        $("div.delivery-date").append(data);
                }).always(function() {
                        $("img#loading-icon").toggleClass("not-visible");
                });
            }
});

function error(px) {
    $('.date-error').css({
        'display': 'block',
        'margin-top': px+'px'
    });
}

/* $("#update-order-date").on("submit", function(e) {
    e.preventDefault();
    let details = $(this).serialize();
    console.log("\ndetails => ", details);
    console.log("\ntypeof details => ", typeof(details));
    // Send the data to the server using AJAX
    $.ajax({
        type: "POST",
        url: "update-order-date.php",
        data: details,
        success: function(response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + textStatus + ' ' + errorThrown);
        }
    });
}); */
