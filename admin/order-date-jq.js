$("form#update-order-date").on("submit", function(e) {

    e.preventDefault(); // uniemożliwienie wysłania formularza ;

    let data = $("form#update-order-date").serialize();
    // Serializacja danych formularza;  Pobranie danych z formularza;
    // -> dane w postaci tekstowej (String) ;

            // let details = $(this).serialize(); // wszystkie dane z formularza; zmienna "details" jest typu String ;

                    /* let details = $(this); */ // obiekt zawierający dane formularza;
                        // console.log("\ndetails => ", details);
                        // console.log("\ntypeof details => ", typeof(details)); // String;

    // console.log("\ndata serialized (string) => ", data);

    let dateValue = data.slice(11,21); // "2023-01-01" - TERMIN DOSTAWY (!)
    let dispDate = data.slice(36,46); // "2023-01-01"
    let delDate = data.slice(42); // "2023-01-01" - data dostarczenia;

    console.log("\ndateValue => ", dateValue); // String;
    console.log("\ndispDate => ", dispDate);
    console.log("\ndelDate => ", delDate);

            const date = new Date(); // Walidacja daty; // obiekt Date

                const year = date.getFullYear();  // 2023
                let month = date.getMonth() + 1;  // 05
                let day = date.getDate();         // 11

                if(month < 10) {
                    month = "0" + month;
                } if(day < 10) {
                    day = "0" + day;
                }

            let todayDate = [year, month, day].join('-');
                console.log("\ntodayDate => ", todayDate); // 👉️ "2023-1-4"
                // console.log("\ntodayDate => ", typeof(todayDate)); // 👉️ "2023-1-4"

let list = document.getElementById("status-list");
const selectedOption = list.options[list.selectedIndex];

    //console.log("\n45 selectedOption -> ", selectedOption);

            if(
                (selectedOption.innerHTML === "W trakcie realizacji") &&

                (dateValue < todayDate) || dateValue === undefined || dateValue == null) {
                // przeszła data, lub pusta ;
                error();
                return;

            } else if (
                (selectedOption.innerHTML === "Wysłano") &&
                ((dispDate < todayDate) || (dateValue < todayDate))
            )  {
                console.log("\n56");
                error();
                return;
            } else if (
                (selectedOption.innerHTML === "Dostarczono") &&
                (delDate < todayDate)
            )  {

                //console.log("\n56");
                error();
                return;
            }
            else {
                /*    //console.log("\n54");
                dateValue = validateDate(dateValue); // walidacja daty - czy jest w dobrym formacie;
                if(dateValue === null) {
                    error(); // coś nie tak z tą datą - nie przeszła walidacji;
                    return;
                }
                if(dispDate.length > 0 && (selectedOption.innerHTML === "Wysłano")) {
                    console.log("\n65");
                    dateValue = validateDate(dispDate); // walidacja daty;
                    console.log("\n dateValue (69) -> ", dateValue);
                    if(dateValue === null) {
                        console.log("\n dateValue (73) -> ", dateValue);
                        error();
                        return;
                    }
                }*/

            }
                            // Można zamienić ten String na Obiekt (Object) / lub Tablicę;
                                // można to zrobić za pomocą metod -> $.parseParams() , lub - $.deparam() ;
                            // jeśli dane są w postaci obiektu, możemy uzyskac do nich dostęp za pomocą notacji key-value;
                            //let dataObject = $.deparam(details);
                            //let dateValue = dataObject.name;
                            //let object = JSON.parse(details);
                            /*console.log("\ndateValue => ", dateValue);*/
                            //console.log("\nobject => ", object);

// AJAX request;
    $.post("update-order-date.php", data, function(data) {

            // funkcja wywołana w momencie zwrócenia dannych / otrzymania odpowiedzi z serwera;

                        // $("#update-order-date").html(data);
                        // $("#update-order-date").hide();
                        // $("button.cancel-order").hide();
                        // toggleBox();

        // data serialized (string) =>  order-date=2023-05-17&dispatch-date=2023-05-18

        finishUpdate(); // wywołanie funkcji po powrocie ze skryptu PHP;



        //$("div.delivery-date").append("<span class='update-success'>Udało się zmienić status zamówienia</span>");

        //$("div.delivery-date").html(data); // data - dane zwrócone z serwera.
        $("div.delivery-date").append(data);

        //$("div.order-status > span")
    });

    //let dateValue = details[0][0].value; // "2023-01-01";  type = String;
    //console.log("\ndateValue => ", dateValue); // wartość (value) pola Daty
    //console.log("\ndateValue => ", typeof(dateValue)); // wartość (value) pola Daty
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
    $('div.delivery-date button').css('margin-top', '50px');
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
