
// admin/edit-category.php;

// DOMContentLoaded
// load


$("form#edit-category").on("submit", function(e) {

    e.preventDefault(); // prevent default <form> action which is submitted;

    let data = $(this); // jQ object that holds <form> data;
        // let postData = $(this).serialize(); // serialized <form> data;
    //let formData = new FormData(this); // https://developer.mozilla.org/en-US/docs/Web/API/FormData
    // Create a new FormData object
    // need to use the FormData object to send the form data, including the image file.
let result = document.querySelector('div.result');

    console.log("\n46 data -> ", data);
    console.log("\n46 typeof data -> ", typeof data);
   /* console.log("\n46 formData -> ", formData);
    console.log("\n46 typeof formData -> ", typeof formData);*/



    // front-end validation;

    let categoryName = DOMPurify.sanitize(data[0][0].value);
    let categoryId = DOMPurify.sanitize(parseInt(data[0][1].value));


        console.log("\ncategoryName -> ", categoryName);
        console.log("\ntypeof categoryName -> ", typeof categoryName);
        console.log("\ndata[0][0].value -> ", data[0][0].value);
        console.log("\ntypeof data[0][0].value -> ",typeof data[0][0].value);
        console.log("\ncategoryId -> ", categoryId);
        console.log("\ntypeof categoryId -> ", typeof categoryId);
        console.log("\ndata[0][1].value -> ", data[0][1].value);
        console.log("\ntypeof data[0][1].value -> ", typeof data[0][1].value);


    //return;
    //return;

    if (
        (categoryName !== data[0][0].value) || categoryName.length > 100 ||   // check, if values were correct (if passed validation);
        (categoryId !== data[0][1].value) || isNaN(categoryId)
    ) {
        // data didn't pass validation;
        result.innerHTML = "<span class='update-failed'>50 Wystąpił problem. Podaj poprawne dane</span>";
    } else {
            /*$.ajax({                             // Handle AJAX request;
                type: "POST",                    // GET or POST;
                url: "edit-book-data.php",       // Path to file (that process the <form> data);
                data: formData,                  //  ̶s̶e̶r̶i̶a̶l̶i̶z̶e̶d̶ ̶<̶f̶o̶r̶m̶>̶ ̶d̶a̶t̶a̶;̶ // Use the FormData object instead of serialized data;
                    processData: false,              // (?) Prevent jQ from processing the data;
                    contentType: false,              // (?) Let the browser set the content type automatically;
                timeout: 2000,                   // Waiting time;
                beforeSend: function() {         // Before Ajax - function called before sending the request;
                    $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
                },
                complete: function() {           // Once finished - function called always after sending request;
                    $("img#loading-icon").toggleClass("not-visible");
                },
                success: function(data) {        // Show content; // data - dane zwrócone z serwera !;
                    $('div.result').html(data); // ✓ tutaj należy zastąpić tą linię danymi zwróconymi z serwera - to serwer udziela odpiwedzi czy udało się zaktualizować dane !;
                        //confirmButton.hide();                  // "Potwierdź";
                        //cancelButton.hide();                   // "Anuluj";
                        //$("div.delivery-date").append(data);   // data - dane zwrócone z serwera;
                            // finishArchive();
                },
                error: function(data) { /!*postData*!/                      // Show error msg;
                    $('div.result').html(data); // tutaj należy zastąpić tą linię danymi zwróconymi z serwera - to serwer udziela odpiwedzi czy udało się zaktualizować dane !;
                            //$content.html('<div id="container">Please try again soon.</div>');
                        //confirmButton.hide(); // "Potwierdź";
                        //cancelButton.hide();  // "Anuluj";
                        //$("div.delivery-date").append(data).fadeIn(1000); // data - dane zwrócone z serwera;
                }
            });*/

        $.ajax({                             // Handle AJAX request;
            //type: "POST",                    // GET or POST;
            method: "POST",
            url: "edit-category-data.php",       // Path to file (that process the <form> data);
            data: data.serialize(),                  //  ̶s̶e̶r̶i̶a̶l̶i̶z̶e̶d̶ ̶<̶f̶o̶r̶m̶>̶ ̶d̶a̶t̶a̶;̶ // Use the FormData object instead of serialized data;
               /* processData: false,              // (?) Prevent jQ from processing the data;
                contentType: false,              // (?) Let the browser set the content type automatically;*/
            timeout: 2000,                   // Waiting time;
            beforeSend: function() {         // Before Ajax - function called before sending the request;
                $("img#loading-icon").toggleClass("not-visible"); // show loading animation;
            }
        }).done(function(data) { // methods of the jqXHR object -> .done(), .fail(), .always()
            $('div.result').html(data); // data - dane zwrócone z serwera;
        }).fail(function(data) {
            $('div.result').html(data); // data - dane zwrócone z serwera;
        }).always(function() {
            $("img#loading-icon").toggleClass("not-visible"); // Once finished - function called always after sending request;
        });
    }
});
