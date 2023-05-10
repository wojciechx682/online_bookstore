$("#update-order-date").on("submit", function(e) {
    e.preventDefault(); // uniemożliwienie wysłania formularza;

            let details = $("#update-order-date").serialize(); // Serializacja danych formularza; Pobranie danych z formularza
            //let details = $(this).serialize(); // wszystkie dane z formularza; zmienna "details" jest typu String

            /*let details = $(this);*/ // obiekt zawierający dane formularza;

   /* console.log("\ndetails => ", details);
    console.log("\ntypeof details => ", typeof(details)); // String
    let dateValue = details.slice(11);
    console.log("\ndateValue => ", dateValue);
    console.log("\ntypeof dateValue => ", typeof(dateValue)); // String*/

            // Można zamienić ten String na Obiekt (Object) / lub Tablicę;
                // można to zrobić za pomocą metod -> $.parseParams() , lub - $.deparam() ;
            // jeśli dane są w postaci obiektu, możemy uzyskac do nich dostęp za pomocą notacji key-value;
            //let dataObject = $.deparam(details);
            //let dateValue = dataObject.name;
            //let object = JSON.parse(details);
            /*console.log("\ndateValue => ", dateValue);*/
            //console.log("\nobject => ", object);

    //let dateValue = details[0][0].value; // "2023-01-01";  type = String;

    //console.log("\ndateValue => ", dateValue); // wartość (value) pola Daty
    //console.log("\ndateValue => ", typeof(dateValue)); // wartość (value) pola Daty

    $.post("update-order-date.php", details, function(data) {
                    //$("#update-order-date").html(data);
        //$("#update-order-date").hide();
        //$("button.cancel-order").hide();
        toggleBox();
    })
})


/*
$("#update-order-date").on("submit", function(e) {
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
});*/
