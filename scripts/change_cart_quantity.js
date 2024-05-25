
$("input.book-amount").on("change", function(e) {
    let form = $(this).closest("form");
    form.submit();
});

$("form.change_quantity_form").on("submit", function(e) {

    e.preventDefault();
    let data = $(this);
    let bookId = data[0][0].dataset.bookId;
    let bookAmount = data[0][1].value;

    $.ajax({
        type: "POST",
        url: "change_cart_quantity.php",
        data: {
            "book-id": bookId,
            "book-amount": bookAmount
        },
        timeout: 2000,
        beforeSend: function() {
        },
        complete: function() {

        },
        success: function(data) {

            let orderSum = data.suma_zamowienia;
            let bookAmount = data.koszyk_ilosc_ksiazek;

            let header = document.getElementById("order-sum");
            header.lastChild.textContent = orderSum + " PLN";

            let cartButtons = document.querySelectorAll('#btn-parent a:nth-child(3) .btn.from-center, .btn-cart-main');

            cartButtons.forEach(button => {
                button.innerHTML = "Koszyk ("+bookAmount+")"
            });

        },
        error: function(formData) {

        }
    });
})