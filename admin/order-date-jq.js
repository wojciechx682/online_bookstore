
// admin/order-details.php ;

// $.ajax({
//   method: "POST",
//   url: "some.php",
//   data: { name: "John", location: "Boston" }
// })
//   .done(function( msg ) {
//     alert( "Data Saved: " + msg );
//   });

//$("form#update-order-date").on("submit", function(e) {

document.querySelector("form#update-order-date").addEventListener("submit", function(event) {

    event.preventDefault(); // event - obiekt zdarzenia;
    let form = this; // element który wywołał zdarzenie (form) - obiekt DOM;
    const todayDate = new Date(); // utworzenie obiektu klasy Date --> w calu walidacji daty; // bieżąda Data i Czas;
    let hours = todayDate.getHours();
    let minutes = todayDate.getMinutes();
    let seconds = todayDate.getSeconds();
    let milliseconds = todayDate.getMilliseconds();
        let list = document.getElementById("status-list");       // <select> list;
        const selectedOption = list.options[list.selectedIndex]; // aktualnie wybrany element listy;
    let expDeliveryDate = new Date(form.elements["order-date"].value); // termin_dostawy
    let sentDate = new Date(form.elements["dispatch-date"].value);     // data_wysłania
        let sentTime = form.elements["dispatch-time"].value;           // godzina wysłania
        let [sentHour, sentMinute, sentSecond] = sentTime.split(":").map(Number);
        sentTime = new Date();
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

    // isNaN(expDeliveryDate.getTime()) - true/false - służy do sprawdzenia, czy udało się poprawnie utworzyć datę poprzez użycie konstruktora (linia 48);
    // walidacja daty - kontrola błędów, czy data jest poprawna i znajduje się w odpowiednim przedziale (JS);

    if (selectedOption.value === "inProgress" && (isNaN(expDeliveryDate.getTime()) || expDeliveryDate <= todayDate)) {

        // przeszła data, lub pusta/niepoprawna (NaN);
        error(5);

    } else if (selectedOption.value === "shipped" && (isNaN(expDeliveryDate.getTime()) || isNaN(sentDate.getTime()) || isNaN(sentTime.getTime()) || expDeliveryDate < todayDate || sentDate < todayDate || expDeliveryDate < sentDate)) {

            // przeszła data, pusta (NaN), lub data_wysłania późniejsza niż termin_dostawy, ✔ godzina_wysłania (w dacie wysłania) wcześniejsza niż dzisiejsza data;
        error(20);

    } else if ( selectedOption.value === "delivered" && (isNaN(dateDelivered.getTime()) || dateDelivered <= todayDate)) {
            // przeszła data, lub pusta (NaN);
        error(5);
    }
    else {

        // zamiana na użycie metod .done(), .fail(), always() - ponieważ  success, error, complete    - są przestarzałe (deprecated);
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
        }).done(function(data) {
            // data - dane otrzymane z serwera (response - odpowiedź); // success handler; // handle the response data;
                finishUpdate(); // hide <form> and Cancel <button>, set list <option> element to first one;
                let list = document.getElementById("status-list");
                const option = list.options[list.selectedIndex];
                let orderStatus = document.querySelector("#order-status #order-details-status");

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
