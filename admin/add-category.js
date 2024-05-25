
// admin/edit-category.php;

$("form#add-category").on("submit", function(e) {

    e.preventDefault();

    let data = $(this);
    let result = document.querySelector('div.result');
    let categoryName = DOMPurify.sanitize(data[0][0].value);

    console.log("categoryName --> ", categoryName);

    if (
        (categoryName !== data[0][0].value) || (categoryName.length > 100)    // check, if values were correct (if passed validation);

    ) {
        // data didn't pass validation;
        result.innerHTML = "<span class='update-failed'>50 Wystąpił problem. Podaj poprawne dane</span>";
    } else {
        $.ajax({                             // Handle AJAX request;
            method: "POST",
            url: "add-category-data.php",       // Path to file (that process the <form> data);
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
