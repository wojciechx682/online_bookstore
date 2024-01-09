
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

document.querySelector("form#update-order-date").addEventListener("submit", function(event) {

    // use DOMPurify for date sanitization here

    event.preventDefault(); // event - obiekt zdarzenia;
        //let date = $(this); // obiekt jQuery zawierający formularz - <form>;
    let form = this; // element który wywołał zdarzenie (form) - obiekt DOM;
        console.log("\n form =>\n", form);
        console.log("\n form.elements =>\n", form.elements);

    const todayDate = new Date(); // utworzenie obiektu klasy Date --> w calu walidacji daty; // bieżąda Data i Czas;
        console.log("\ntodayDate =>\n", todayDate);
    let hours = todayDate.getHours();
    let minutes = todayDate.getMinutes();
    let seconds = todayDate.getSeconds();
    let milliseconds = todayDate.getMilliseconds();
        let list = document.getElementById("status-list");       // <select> list;
        const selectedOption = list.options[list.selectedIndex]; // aktualnie wybrany element listy;

    /*let expDeliveryDate = new Date(date[0][0].value); // termin_dostawy
    let sentDate = new Date(date[0][1].value);        // data_wysłania
    let sentTime = new Date(date[0][2].value);        // date[0][2] - godzina wysłania
    let dateDelivered = new Date(date[0][3].value);   // data_dostarczenia*/

    let expDeliveryDate = new Date(form.elements["order-date"].value); // termin_dostawy
    let sentDate = new Date(form.elements["dispatch-date"].value);     // data_wysłania
        let sentTime = form.elements["dispatch-time"].value;           // godzina wysłania
        let [sentHour, sentMinute, sentSecond] = sentTime.split(":").map(Number);
        sentTime = new Date();
        /*sentTime.setHours(sentHour);
        sentTime.setMinutes(sentMinute);*/
            //sentTime.setSeconds(seconds);
    //let sentTime = new Date(form.elements["dispatch-time"].value);     // godzina wysłania
    let dateDelivered = new Date(form.elements["delivered-date"].value); // data_dostarczenia

    console.log("\n expDeliveryDate =>\n", expDeliveryDate);
    console.log("\n sentDate =>\n", sentDate);
    console.log("\n sentTime =>\n", sentTime);
    console.log("\n dateDelivered =>\n", dateDelivered);

    expDeliveryDate.setHours(hours, minutes, seconds, milliseconds); // termin_dostawy
    sentDate.setHours(hours, minutes, seconds, milliseconds);        // data_wysłania
    dateDelivered.setHours(hours, minutes, seconds, milliseconds);   // data_dostarczenia
    sentTime.setHours(sentHour, sentMinute, sentMinute, milliseconds);  // data_dostarczenia

    console.log("\n expDeliveryDate =>\n", expDeliveryDate);
    console.log("\n sentDate =>\n", sentDate);
    console.log("\n sentTime =>\n", sentTime);
    console.log("\n dateDelivered =>\n", dateDelivered);

    //return;

    /*console.log("\n\n todayDate -> ", todayDate);
    console.log("\n\n hours -> ", hours);
    console.log("\n\n minutes -> ", minutes);
    console.log("\n\n seconds -> ", seconds);
    console.log("\n\n expDeliveryDate -> ", expDeliveryDate);
    console.log("\n\n sentDate -> ", sentDate);
    console.log("\n\n sentTime -> ", sentDate);
    console.log("\n\n dateDelivered -> ", dateDelivered);

    console.log("\n\n expDeliveryDate.getTime() -> ", expDeliveryDate.getTime());
    console.log("\n\n todayDate.getTime() -> ", todayDate.getTime());
    console.log("\n\n expDeliveryDate < todayDate -> ", expDeliveryDate.getTime() < todayDate.getTime() );

    console.log("\n\n\n\n dateDelivered < todayDate -> ", dateDelivered.getTime() < todayDate.getTime() );
    console.log("\n\n\n\n isNaN(dateDelivered.getTime() -> ", isNaN(dateDelivered.getTime()) );*/

    // isNaN(expDeliveryDate.getTime()) - true/false - służy do sprawdzenia, czy udało się poprawnie utworzyć datę poprzez użycie konstruktora (linia 48);
    // walidacja daty - kontrola błędów, czy data jest poprawna i znajduje się w odpowiednim przedziale (JS);

    if (selectedOption.value === "inProgress" && (isNaN(expDeliveryDate.getTime()) || expDeliveryDate <= todayDate)) {

        // przeszła data, lub pusta/niepoprawna (NaN)
            /*console.log("\n 87 expDeliveryDate.getTime() -> ", expDeliveryDate.getTime());
            console.log("\n 88 todayDate.getTime() -> ", todayDate.getTime());*/
        error(5);

    } else if (selectedOption.value === "shipped" && (isNaN(expDeliveryDate.getTime()) || isNaN(sentDate.getTime()) || isNaN(sentTime.getTime()) || expDeliveryDate < todayDate || sentDate < todayDate || expDeliveryDate < sentDate)) {

            // przeszła data, pusta (NaN), lub data_wysłania późniejsza niż termin_dostawy, ✔ godzina_wysłania (w dacie wysłania) wcześniejsza niż dzisiejsza data
        /*console.log("\n 87 expDeliveryDate.getTime() -> ", expDeliveryDate.getTime());
        console.log("\n 87 sentDate.getTime() -> ", sentDate.getTime());
        console.log("\n 88 todayDate.getTime() -> ", todayDate.getTime());
        console.log("\n 88 sentTime.getTime() -> ", sentTime.getTime());*/
        error(20);

    } else if ( selectedOption.value === "delivered" && (isNaN(dateDelivered.getTime()) || dateDelivered <= todayDate)) {
            // przeszła data, lub pusta (NaN)
        error(5);
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

                // serializacja danych formularza;  pobranie danych z formularza;  // dane w postaci tekstowej (string);
                let dataSerialized = $(this).serialize();
                console.log("\n\n dataSerialized --> \n\n", dataSerialized);

                $.ajax({
                    type: "POST",
                    url: "update-order-date.php",
                    data: dataSerialized,
                    timeout: 2000,
                    beforeSend: function() {                              // before ajax - function called before sending the request;
                        $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                    }
                }).done(function(data) { // data - dane otrzymane z serwera (response - odpowiedź); // success handler; // handle the response data;

                        finishUpdate(); // hide <form> and Cancel <button>, set list <option> element to first one;
                    /*$("div.delivery-date").append("<span class='update-success'>" + data.message + "</span>"); // append data returned from server;*/
                        let list = document.getElementById("status-list");
                        const option = list.options[list.selectedIndex];
                    let orderStatus = document.querySelector("#order-status #order-details-status");

                    // <span className='update-failed'>30 Wystąpił błąd. Nie udało się zmienić statusu zamówienia</span>

                    if(data.success === true) {

                        $("div.delivery-date").append("<span class='update-success'>" + data.message + "</span>"); // append data returned from server;
                        $("span.order-status-name").text(option.innerHTML); // zmiana wyświetlanego statusu po jego zmianie;

                        switch (option.value) {
                            case "inProgress":
                                orderStatus.innerHTML = '<div>Termin dostawy: <span>' + form.elements["order-date"].value + '</span></div>';
                                break;
                            case "shipped":
                                orderStatus.innerHTML = '<div>Termin dostawy: <span>' + form.elements["order-date"].value + "</span></div>" +
                                    '<div>Data wysłania: <span>' + form.elements["dispatch-date"].value + " " + form.elements["dispatch-time"].value + '</span></div>';
                                break;
                            case "delivered":
                                orderStatus.innerHTML = '<div>Data dostarczenia: <span>' + form.elements["delivered-date"].value + '</span></div>';
                                break;
                        }

                    } else {

                        $("div.delivery-date").append("<span class='update-failed'>" + data.message + "</span>");

                    }


                }).fail(function(jqXHR, textStatus, errorThrown) {
                    finishUpdate(); // hide <form> and Cancel <button>, set list <option> element to first one;
                    $("div.delivery-date").append("<span class='update-failed'>Wystąpił problem. Nie udało się zarchiwizować zamówienia</span>");
                    $("div.delivery-date").append("<span class='update-failed'>" + textStatus + " " + jqXHR.status + " " + jqXHR.statusText + "</span>");
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
