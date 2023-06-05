
$(document).ready(function() { // after page load/reload - send <form>;

    $("form#change-magazine-form").submit(); // submit the <form>
});

$("select#change-magazine").on("change", function(e) { // after changing <option> element in <select> list;

    //console.log("<option> element of <select> list has been changed");

    $("form#change-magazine-form").submit(); // submit the <form>
});

$("form#change-magazine-form").on("submit", function(e) { // after submitting form;

    e.preventDefault();

    //console.log("form submited !");

    //let form = $(this); // obiekt zawierający dane formularza;
    let data = $(this).serialize(); // dane formularza do przesłania metodą post;
    let postData = parseInt($(this).serialize().slice(16).trim()); // "change-magazine=1" => "1" (id_maazynu);

    console.log("\ndata => ", data); // Object
    console.log("\npost data (id_magazynu) =>", postData); // atrybut value elementu <option> (jest to id_magazynu);
    console.log("\ntypeof(post data) (id_magazynu) =>", typeof(postData)); // atrybut value elementu <option> (jest to id_magazynu);
    //console.log("\ntypeof form => ", typeof(form)); // Object;

    if((data !== '') && (typeof(postData) === 'number') && (!isNaN(postData))) {
        // console.log("25");
        $.post("change-magazine.php", data, function(data) {
            // AJAX request to PHP script ...;

            let booksHeader = document.querySelector('.admin-books');

            if(booksHeader.style.display === 'none') {
                booksHeader.style.display = "block";
            }

            $("#books-content").html(data);
        });
    } else {
        // błąd z id-magazynu (!) ;

        $("div.admin-books").css('display', 'none');

        $("div#books-content").html('<span class="admin-books-error" style="display: block;">Wystąpił błąd. Serwer nie zwrócił poprawnych danych. Spróbuj ponownie później</span>');

    }



    //let warehouse =

    // send <form> after changing selected <option> element in <select> list;
    /*let selectList = document.getElementById("change-magazine");
    let formasd = document.getElementById("change-magazine-form");

    form.submit();*/

    // plik JS wysyłający formularz z wykorzystaniem AJAX;
    // plik "remove-order.php" obsługuje żądanie, odbiera dane i wykonuje zapytanie do BD.

    //e.preventDefault(); // uniemożliwienie wysłania formularza;

    //let data = $("form.remove-order").serialize();
    /* let data = $(this); // obiekt zawierający dane formularza;
     let form = $(this);

     let postData = $(this).serialize();

     console.log("\n  data => ", data);
     console.log("\npostData => ", postData);
     console.log("\ntypeof data => ", typeof(data)); // Object;*/

    /*let orderId = data[0][0].value;        // id-zamówienia (string);
    console.log("\norderId => ", orderId);

    let comment = data[0][1].value;        // komentarz (powód) archiwizowania (String);
    console.log("\ncomment => ", comment);

    //let textarea = data[0][1]; // <textarea>;
    let textarea = data.find('textarea[name="comment"]'); // <textarea>;
    let confirmButton = data.find('button[type="submit"]'); // <button type="submit">;

    let deliveryDateDiv = form.closest(".delivery-date"); // przodek formularza, <div class="delivery-date">;
    console.log("\ndeliveryDateDiv => ", deliveryDateDiv);

    //let cancelButton = deliveryDateDiv.find('button[class="cancel-order"]'); // przycisk "Anuluj";
    let cancelButton = deliveryDateDiv.find(".cancel-order");
    console.log("\ncancelButton => ", cancelButton);*/

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Sanityzacja danych wejściowych - Wyczyszczenie niebezpiecznych zapisów - Komentarz

    /*const sanitizedComment = DOMPurify.sanitize(comment);*/ // it works, but How ?
    //console.log("sanitizedComment -> ", sanitizedComment);

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Walidacja wprowadzonych danych (niebezpieczne znaki, długość) ->

    /*if( (comment !== sanitizedComment) || (sanitizedComment.length < 10) || (sanitizedComment.length > 255) ) {
        // niebezpieczne znaki - lub - niepoprawna długość;
        //$('.remove-order-error').css('display', 'block');
        $('.remove-order-error').css('display', 'block');
        //$('div.delivery-date button').css('margin-top', '50px');
        //return;
    } else {
        $('.remove-order-error').css('display', 'none');

        // wysłanie zapytania do do PHP -->
        /!*let data = "order-id="+orderId+"&comment="+comment;*!/

        $.post("remove-order.php", postData, function(data) {

            //finishUpdate(); // wywołanie funkcji po powrocie ze skryptu PHP;
            //$("div.delivery-date").append("<span class='update-success'>Udało się zmienić status zamówienia</span>");
            //$("div.delivery-date").html(data); // data - dane zwrócone z serwera;
            //$("div.delivery-date").append(data);
            //$("div.order-status > span");

            let div = 'div.order-status'+orderId;
            $(div).html("Zarchiwizowane"); // <table> -> div.order-status;

            //$("div.delivery-date").append(data); // data - dane zwrócone z serwera.
            //$("div.delivery-date").html(data);
            //textarea.hide(); // dide <textarea> element;

            confirmButton.hide();
            cancelButton.hide();

            $("div.delivery-date").append(data); // data - dane zwrócone z serwera.

            //$(".delivery-date button:last-of-type").after(data);

            finishArchive();
        });

    }*/

    // console.log("\ndata serialized (string) => ", data);

    /*let dateValue = data.slice(11,21); // "2023-01-01" - TERMIN DOSTAWY (!)
    let dispDate = data.slice(36,46); // "2023-01-01"
    let delDate = data.slice(42); // "2023-01-01" - data dostarczenia;*/

    /*console.log("\ndateValue => ", dateValue); // String;
    console.log("\ndispDate => ", dispDate);
    console.log("\ndelDate => ", delDate); */

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    // To validate and sanitize a text string in JavaScript to prevent SQL injection and XSS attacks, you can use a combination of techniques. Here's an example of how you can accomplish this ->

    // 1. Validating the Text -> You can perform basic validation checks on the text string, such as ensuring it meets length requirements or specific character restrictions. You can use regular expressions or built-in JavaScript string methods to check for any unwanted patterns or characters.

    // 2. Sanitizing the Text ->
    // To prevent SQL injection, you should use parameterized queries or prepared statements when interacting with your database. This ensures that user input is treated as data and not executable code.
    // To prevent XSS attacks, you should sanitize the text before outputting it into HTML. There are libraries available like DOMPurify that can help with HTML sanitization.
    // You can also use built-in JavaScript methods to escape or encode special characters, such as innerText or textContent, which will automatically escape HTML entities.

    /////////////////////////////////////////////////////////////////////////////////////////////

    // Basic validation (example: minimum length of 5 characters)
    /*if (comment.length >= 5) {
        // Sanitizing the text for HTML output
        const sanitizedComment = DOMPurify.sanitize(comment);
        // Using the sanitized comment
        // Example: Outputting the sanitized comment into an HTML element
        const commentElement = document.getElementById("comment");
        commentElement.innerText = sanitizedComment;
    } else {
        // Handle validation error
        console.log("Comment is too short (!)");
    } */
    /*const date = new Date();
        const year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();
        if(month < 10) {
            month = "0" + month;
        } if(day < 10) {
            day = "0" + day;
        }
    let todayDate = [year, month, day].join('-');
        console.log("\ntodayDate => ", todayDate);*/

    /*let list = document.getElementById("status-list");
    const selectedOption = list.options[list.selectedIndex];

                if(
                    (selectedOption.innerHTML === "W trakcie realizacji") &&

                    (dateValue < todayDate) || dateValue === undefined || dateValue == null) {
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
                    error();
                    return;
                }
                else {

                }*/
    // Można zamienić ten String na Obiekt (Object) / lub Tablicę;
    // można to zrobić za pomocą metod -> $.parseParams() , lub - $.deparam() ;
    // jeśli dane są w postaci obiektu, możemy uzyskac do nich dostęp za pomocą notacji key-value;
    //let dataObject = $.deparam(details);
    //let dateValue = dataObject.name;
    //let object = JSON.parse(details);
    /*console.log("\ndateValue => ", dateValue);*/
    //console.log("\nobject => ", object);

    // AJAX request;
    /*$.post("remove-order.php", data, function(data) {

    });*/
})

/* function validateDate(date) {
    const dateRegex = /^(\d{4})-(\d{2})-(\d{2})$/;
    if (!dateRegex.test(date)) {
        return null;
    } else {
        return date;
    }
}

function error() {
    $('.date-error').css('display', 'block');
    $('div.delivery-date button').css('margin-top', '50px');
} */

// ---------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------



/* function validateDate(date) {
    const dateRegex = /^(\d{4})-(\d{2})-(\d{2})$/;
    if (!dateRegex.test(date)) {
        return null;
    } else {
        return date;
    }
}

function error() {
    $('.date-error').css('display', 'block');
    $('div.delivery-date button').css('margin-top', '50px');
} */

