$("form#update-order-date").on("submit", function(e) {

    e.preventDefault(); // uniemożliwienie wysłania formularza ;

    let formData = $("form#update-order-date").serialize(); // serializacja danych formularza;  pobranie danych z formularza;
                                                                                    // dane w postaci tekstowej (String);
    // let details = $(this).serialize();
        // let details = $(this); // obiekt zawierający dane formularza;

    // console.log("\ndata serialized (string) => ", data);

                                                          // można zamienić ten String na Obiekt (Object) / lub Tablicę;
                                              // można to zrobić za pomocą metod -> $.parseParams() , lub - $.deparam();
                            // jeśli dane są w postaci obiektu, możemy uzyskac do nich dostęp za pomocą notacji key-value;
                            // let dataObject = $.deparam(details); // (nie działa...)
                            // let dateValue = dataObject.name;
                            // let object = JSON.parse(details);

    let dateValue = formData.slice(11,21); // "2023-01-01" - termin dostawy;
    let dispDate = formData.slice(36,46); // "2023-01-01" - data wysłania;
    let delDate = formData.slice(42); // "2023-01-01" - data dostarczenia;

    console.log("\ndata (string) => ", formData); // String;
    console.log("\ndateValue => ", dateValue); // String;
    console.log("\ndispDate => ", dispDate);
    console.log("\ndelDate => ", delDate);

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

    //console.log("\n45 selectedOption -> ", selectedOption);

            // kontrola błędów (js);
            if(
                (selectedOption.innerHTML === "W trakcie realizacji") &&
                (dateValue < todayDate) || (dateValue === undefined) || (dateValue == null) ) // przeszła data, lub pusta ->
            {
                error();
                return;

            } else if (
                (selectedOption.innerHTML === "Wysłano") &&
                ((dispDate < todayDate) || (dateValue < todayDate)) )
            {
                error();
                return;
            } else if (
                (selectedOption.innerHTML === "Dostarczono") &&
                (delDate < todayDate) )
            {
                error();
                return;
            }
            else {
                /* dateValue = validateDate(dateValue); // walidacja daty - czy jest w dobrym formacie;
                if(dateValue === null) {
                    error(); // coś nie tak z tą datą - nie przeszła walidacji; // (nie działa ten kod);
                    return;
                }
                if(dispDate.length > 0 && (selectedOption.innerHTML === "Wysłano")) {
                    dateValue = validateDate(dispDate); // walidacja daty;
                    console.log("\n dateValue (69) -> ", dateValue);
                    if(dateValue === null) {
                        console.log("\n dateValue (73) -> ", dateValue);
                        error();
                        return;
                    }
                } */
            }

// AJAX request;
    /*$.post("update-order-date.php", data, function(data) {
            // funkcja wywołana w momencie zwrócenia dannych / otrzymania odpowiedzi z serwera;
                        // $("#update-order-date").html(data);
                        // $("#update-order-date").hide();
                        // $("button.cancel-order").hide();
                        // toggleBox();
            // data serialized (string) =>  order-date=2023-05-17&dispatch-date=2023-05-18;
        //finishUpdate(); // wywołanie funkcji po powrocie ze skryptu PHP;
            //$("div.delivery-date").append("<span class='update-success'>Udało się zmienić status zamówienia</span>");
            //$("div.delivery-date").html(data); // data - dane zwrócone z serwera.
        /!*$("div.delivery-date").append(data);*!/
            //$("div.order-status > span")
    });*/
        //let dateValue = details[0][0].value; // "2023-01-01";  type = String;
        //console.log("\ndateValue => ", dateValue); // wartość (value) pola Daty
        //console.log("\ndateValue => ", typeof(dateValue)); // wartość (value) pola Daty



    $.ajax({
        type: "POST",                    // GET or POST;
        url: "update-order-date.php",    // Path to file (that process the <form> data);
        data: formData,                      // serialized <form> data;
        timeout: 2000,                   // Waiting time;
        beforeSend: function() {         // Before Ajax - function called before sending the request;
            //$content.append('<div id="load">Loading</div>');      // Load message
            $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
        },
        complete: function(formData) {           // Once finished - function called always after sending request;
            //$('#load').remove();                                  // Clear message
            $("img#loading-icon").toggleClass("not-visible");

            /*finishUpdate();
            $("div.delivery-date").append(formData);*/
        },
        success: function(formData) {                               // Show content
            //$content.html( $(data).find('#container') ).hide().fadeIn(400);
            finishUpdate();
            $("div.delivery-date").append(formData);

        },
        error: function(formData) {                                     // Show error msg
            //$content.html('<div id="container">Please try again soon.</div>');
            finishUpdate();
            $("div.delivery-date").append(formData);
        }
    });






})

function validateDate(date) { // "2023-01-01"

    const dateRegex = /^(\d{4})-(\d{2})-(\d{2})$/; // Define a regular expression to match the date format (YYYY-MM-DD)

    if (!dateRegex.test(date)) { // Check if the date (String) matches the date format
        return null;             // Return null if the date (string) is not a valid date format
    } else {
        return date;
    }
}

function error() {
    $('.date-error').css('display', 'block');
    //$('div.delivery-date button').css('margin-top', '50px');
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
