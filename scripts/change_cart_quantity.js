
// AJAX - zmiana lixby egzemplarzy koszyka;

/*$("input.koszyk_ilosc").on("change", function(e) { // after changing <option> element in <select> list;

    // $("form#change-magazine-form").submit(); // submit the <form>;
});*/

$("input.koszyk_ilosc").on("change", function(e) {
    let form = $(this).closest("form");
    // Perform actions with the form element
    form.submit();
});



$("form.change_quantity_form").on("submit", function(e) { // po wysłaniu formularza;

    // "plik wie, który formularz został wysłany - jest to tylko jeden - odpowiedni - a nie wszystie formularze - tj. te które istnieją w kodzie i jest ich tyle ile jest zamówień";
    // plik JS wysyłający formularz z wykorzystaniem AJAX;
    // plik "remove-order.php" obsługuje żądanie, odbiera dane i wykonuje zapytanie do BD.

    e.preventDefault();

    // form data --> "id_ksiazki"   - "2"
    //               "koszyk_ilosc" - "6"

    let data = $(this); // obiekt zawierający dane formularza;
    let postData = $(this).serialize();

    let bookId = data[0][0].value;              // book-id (string);
    console.log("\nid_ksiazki => ", bookId);

    let bookQuantity = data[0][1].value;        // koszyk_ilosc;
    console.log("\nkoszyk_ilosc => ", bookQuantity);



        // let textarea = data.find('textarea[name="comment"]'); // <textarea>;
    // let confirmButton = data.find('button[type="submit"]'); // <button type="submit">;
    // let deliveryDateDiv = data.closest(".delivery-date"); // przodek formularza, <div class="delivery-date">;
    // let cancelButton = deliveryDateDiv.find(".cancel-order");

    // Sanityzacja danych wejściowych - Wyczyszczenie niebezpiecznych zapisów - Komentarz;
    // const sanitizedComment = DOMPurify.sanitize(comment, { USE_PROFILES: { html: true } });

// const sanitizedComment = DOMPurify.sanitize(comment); // it works, but How ?


    // Walidacja wprowadzonych danych (niebezpieczne znaki, długość);

    /*if((comment !== sanitizedComment) || (sanitizedComment.length < 10) || (sanitizedComment.length > 255) ) { // niebezpieczne znaki - lub - niepoprawna długość;

        $('.remove-order-error').css('display', 'block'); // komunikat z błędem;

    } else {

        $('.remove-order-error').css('display', 'none');


    }*/

    $.ajax({
        type: "POST",                    // GET or POST;
        url: "change_cart_quantity.php", // Path to file (that process the <form> data);
        data: postData,                  // serialized <form> data;
        timeout: 2000,                   // Waiting time;
        beforeSend: function() {         // Before Ajax - function called before sending the request;
            // (?)
        },
        complete: function() {           // Once finished - function called always after sending request;

        },
        success: function(data) {        // Show content;
            /*let div = 'div.order-status'+orderId;
            $(div).html("Zarchiwizowane");     // <table> -> div.order-status;
            confirmButton.hide();                  // "Potwierdź";
            cancelButton.hide();                   // "Anuluj";
            $("div.delivery-date").append(data); */  // data - dane zwrócone z serwera;
                // finishArchive();

            let sumaZamowienia = 0;
            let koszykIloscKsiazek = 0;

            let books = document.querySelectorAll(".cart-book");

            for(let i = 0; i < books.length; i++) {

                let book = books[i];
                let price = parseFloat(book.querySelector('.price').textContent);
                let bookQuantity = parseInt(book.querySelector('.koszyk_ilosc').value);
                sumaZamowienia += (price * bookQuantity);
                    console.log("\nbook -> ", book);
                    console.log("\nprice -> ", price);
                    console.log("\nbookQuantity -> ", bookQuantity);
                    console.log("\nsumaZamowienia -> ", sumaZamowienia);
                    console.log("\ntypeof sumaZamowienia -> ", typeof sumaZamowienia);

                koszykIloscKsiazek += bookQuantity;
            }
            //$(".order-sum-cart").html(sumaZamowienia.toFixed(2));

           // $(".order-sum-cart").after(sumaZamowienia.toFixed(2) + " PLN");

            if (Number.isInteger(sumaZamowienia)) {
                sumaZamowienia = sumaZamowienia.toFixed(0);
            } else {
                sumaZamowienia = sumaZamowienia.toFixed(2);
            }

            if(!isNaN(sumaZamowienia)) {
                $("h3#order-sum").html('<span class="order-sum order-sum-cart">suma</span>' + sumaZamowienia + " PLN");
                //$('.btn-cart-main').html("Koszyk ("+koszykIloscKsiazek+")");
                $('#btn-parent a:nth-child(3) .btn.from-center, .btn-cart-main').html("Koszyk ("+koszykIloscKsiazek+")");
            }
        },
        error: function(formData) {                                     // Show error msg
                //$content.html('<div id="container">Please try again soon.</div>');
            /*confirmButton.hide(); // "Potwierdź";
            cancelButton.hide();  // "Anuluj";
            $("div.delivery-date").append(data).fadeIn(1000); // data - dane zwrócone z serwera;*/
        }
    });
})