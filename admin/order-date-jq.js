
// This file is fucked up; I could do it better;

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

$("form#update-order-date").on("submit", function(e) {

    // use DOMPurify for date sanitization here ?

    e.preventDefault();
    //                this
    let formData = $("form#update-order-date").serialize(); // serializacja danych formularza;  pobranie danych z formularza;
    let data = $(this);                                                                 // dane w postaci tekstowej (String);

    let expDeliveryDate = data[0][0].value; // "2023-01-01" - termin dostawy;
    let sentDate = data[0][1].value; // "2023-01-01" - data wysłania;
    let dateDelivered = data[0][2].value; // "2023-01-01" - data dostarczenia;

    /*console.log("\nformData (String) => ", formData);
    console.log("\ndata (Object) => ", data);
    console.log("\ndateValue => ", expDeliveryDate);
    console.log("\ndispDate => ", sentDate);
    console.log("\ndelDate => ", dateDelivered);*/

    const date = new Date(); // walidacja daty; // obiekt Date;

        const year = date.getFullYear();  // 2023;
        let month = date.getMonth() + 1;  // 05;
        let day = date.getDate();         // 11;

        if(month < 10) {
            month = "0" + month;
        } if(day < 10) {
            day = "0" + day;
        }

    let todayDate = [year, month, day].join('-'); // 👉️ "2023-1-4";

    let list = document.getElementById("status-list"); // <select>
    const selectedOption = list.options[list.selectedIndex]; // aktualnie wybrany element listy;

            if( // walidacja daty - kontrola błędów (js);
                (selectedOption.innerHTML === "W trakcie realizacji") &&
                (expDeliveryDate < todayDate) || (expDeliveryDate === undefined) || (expDeliveryDate == null) ) // przeszła data, lub pusta ->
            {
                error(12);
            } else if (
                (selectedOption.innerHTML === "Wysłano") &&
                ((sentDate < todayDate) || (expDeliveryDate < todayDate) || (expDeliveryDate < sentDate)) )
            {
                error(37);
            } else if (
                (selectedOption.innerHTML === "Dostarczono") &&
                (dateDelivered < todayDate) )
            {
                error(12);
            }
            else {
                $.ajax({
                    type: "POST",                    // GET or POST;    type of HTTP method;
                    url: "update-order-date.php",    // Path to file (that process the <form> data);    // "Strona, do której kierowane jest żądanie";
                    data: formData,                  // serialized <form> data; // "dane wysłane do serwera wraz z żądaniem";
                    timeout: 2000,                   // Waiting time; - liczba sekund zanim nastąpi niepowodzenie;

                    beforeSend: function() {         // Bbfore ajax - function called before sending the request;

                        // funkcja (anonimowa / nazwana) - uruchamiana PRZED wykonaniem żądania Ajax;
                            // np. wyświetlenie ikony wczytywania danych - (kręcące się kółko) ;

                        // $content.append('<div id="load"> Wczytywanie </div>');

                        $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                    },
                    complete: function() {          // once finished - function called ALWAYS after sending request;

                        // funkcja uruchamiana PO WYKONANIU żądania - niezależnie od jego STANU (sukces / niepowodzenie) ;

                            // np. usunięcie ikony wczytywania danych - (kręcące się kółko) ;

                        // .always();   // .always( function() { // ... { )

                        $("img#loading-icon").toggleClass("not-visible");
                    },
                    success: function(formData) {   // show content;    - wyświetlenie zawartości ;

                        // funkcja uruchamiana, gdy wykonanie żądania Ajax zakończy się POWODZENIEM ;

                            // .done();     // .done( function(data) { // ... } )

                        // $content.html( $(data).find('#container') ) . hide().fadeIn(500);

                        finishUpdate();             // formData - dane otrzymane z serwera (response - odpowiedź);
                            $("div.delivery-date").append(formData);
                    },
                    error: function(formData) {     // show error msg;

                        // funkcja uruchamiana, gdy wykonanie żądania Ajax zakończy się NIEPOWODZENIEM ;

                            // .fail();     // .fail( function() { // ... } )

                        // wyświetlenie komunikatu o błędzie ;

                        finishUpdate();
                            $("div.delivery-date").append(formData);
                    }
                });
            }
});

/* function validateDate(date) { // "2023-01-01"
    const dateRegex = /^(\d{4})-(\d{2})-(\d{2})$/; // Define a regular expression to match the date format (YYYY-MM-DD);
    if (!dateRegex.test(date)) { // Check if the date (String) matches the date format
        return null;             // Return null if the date (string) is not a valid date format
    } else {
        return date;
    }
} */

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
