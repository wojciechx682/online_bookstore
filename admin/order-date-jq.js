$("#update-order-date").on("submit", function(e) {
    e.preventDefault(); // uniemożliwienie wysłania formularza;
            let details = $("#update-order-date").serialize(); // Serializacja danych formularza; Pobranie danych z formularza; -> dane w postaci tekstowej (String) ;

            // let details = $(this).serialize(); // wszystkie dane z formularza; zmienna "details" jest typu String ;

            /* let details = $(this); */ // obiekt zawierający dane formularza;
                // console.log("\ndetails => ", details);
                // console.log("\ntypeof details => ", typeof(details)); // String

    let dateValue = details.slice(11); // "2023-01-01"
    console.log("\ndateValue => ", dateValue);
    console.log("\ntypeof dateValue => ", typeof(dateValue)); // String

            const date = new Date(); // Walidacja daty; // obiekt Date

            const year = date.getFullYear();  // 2023
            let month = date.getMonth() + 1;  // 05
            let day = date.getDate();         // 11

            if(month < 10) {
                month = "0" + month;
            } if(day < 10) {
                day = "0" + day;
            }
            const todayDate = [year, month, day].join('-');
                //console.log("\ntodayDate => ", todayDate); // 👉️ "2023-1-4"

            if((dateValue < todayDate) || dateValue === undefined || dateValue == null) {
                    //console.log("zła-data"); // window.location.href="admin.php";
                $('.date-error').css('display', 'block');
                $('div.delivery-date button').css('margin-top', '50px');

                return; // (?) - (!) TUTAJ MA "WYJŚĆ" TA FUNKCJA ! - czy na pewno ? ...

            } else {
                dateValue = validateDate(dateValue);
            }
                            // Można zamienić ten String na Obiekt (Object) / lub Tablicę;
                                // można to zrobić za pomocą metod -> $.parseParams() , lub - $.deparam() ;
                            // jeśli dane są w postaci obiektu, możemy uzyskac do nich dostęp za pomocą notacji key-value;
                            //let dataObject = $.deparam(details);
                            //let dateValue = dataObject.name;
                            //let object = JSON.parse(details);
                            /*console.log("\ndateValue => ", dateValue);*/
                            //console.log("\nobject => ", object);

    $.post("update-order-date.php", details, function(data) {
            // $("#update-order-date").html(data);
            // $("#update-order-date").hide();
            // $("button.cancel-order").hide();
            // toggleBox();
        finishUpdate();
        $("div.delivery-date").append("<span class='update-success'>Udało się zmienić status zamówienia</span>");
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
