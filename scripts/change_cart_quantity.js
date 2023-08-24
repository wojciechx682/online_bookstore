
$("input.book-amount").on("change", function(e) { // input type="text"
    let form = $(this).closest("form");
        // perform actions with the form element
    form.submit();
});

$("form.change_quantity_form").on("submit", function(e) { // po wysłaniu formularza;

    // "plik wie, który formularz został wysłany - jest to tylko jeden - odpowiedni - a nie wszystie formularze - tj. te które istnieją w kodzie i jest ich tyle ile jest zamówień";
    // plik JS wysyłający formularz z wykorzystaniem AJAX;
    // plik "change_cart_quantity.php" - obsługuje żądanie, odbiera dane i wykonuje zapytanie do BD.

    e.preventDefault();

    // form data --> "book-id"   - "2"
    //               "book-amount" - "6"

    let data = $(this); // obiekt jQzawierający dane formularza;
        console.log("\n data  => ", data);

    let bookId = data[0][0].dataset.bookId;
        console.log("\n bookId - id_ksiazki => ", bookId);

    let bookAmount = data[0][1].value;        // koszyk_ilosc;
        console.log("\nbookAmount => ", bookAmount);



    // const sanitizedComment = DOMPurify.sanitize(comment);
    // Walidacja wprowadzonych danych (niebezpieczne znaki, długość);

    /*if((comment !== sanitizedComment) || (sanitizedComment.length < 10) || (sanitizedComment.length > 255) ) { // niebezpieczne znaki - lub - niepoprawna długość;

        $('.remove-order-error').css('display', 'block'); // komunikat z błędem;

    } else {

        $('.remove-order-error').css('display', 'none');
    }*/

    $.ajax({
        type: "POST",                    // GET or POST;
        url: "change_cart_quantity.php", // Path to file (that process the <form> data);
        data: {                          // serialized <form> data;
            "book-id": bookId,
            "book-amount": bookAmount
        },
        timeout: 2000,                   // Waiting time;
        beforeSend: function() {         // Before Ajax - function called before sending the request;
        },
        complete: function() {           // Once finished - function called always after sending request;

        },
        success: function(data) {        // data - dane zwrócone z serwera (JSON);

            let orderSum = data.suma_zamowienia;
            let bookAmount = data.koszyk_ilosc_ksiazek;

            let header = document.getElementById("order-sum");
            header.lastChild.textContent = orderSum + " PLN";

            let cartButtons = document.querySelectorAll('#btn-parent a:nth-child(3) .btn.from-center, .btn-cart-main');

            cartButtons.forEach(button => {
                button.innerHTML = "Koszyk ("+bookAmount+")"
            });

        },
        error: function(formData) {  // Show error msg;

        }
    });
})