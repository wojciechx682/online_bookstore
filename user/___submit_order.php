<?php
    // check if user is logged-in, and user-type is "client" - if not, redirect to login page ;
    require_once "../authenticate-user.php";

    if ( !isset($_SESSION["koszyk_ilosc_ksiazek"]) || $_SESSION['koszyk_ilosc_ksiazek'] === 0) {

        $_SESSION["order-error"] = "Aby złożyć zamówienie, dodaj książki do koszyka";
        header('Location: ___koszyk.php', true, 303); exit();
    }

    unset($_SESSION["delivery-price"], $_SESSION["payment-price"]);
?>

<!DOCTYPE HTML>
<html lang="pl">

<?php require "../view/___head.php"; ?>

<body>

    <div id="main-container">

        <?php require "../view/___header-container.php"; ?>

        <div id="container">

            <main>

                <div id="content" class="shopping-cart">

                    <h3 id="cart-header">Koszyk</h3>

                    <?php

                        query("SELECT kl.id_klienta, 
                                      ko.id_ksiazki, ko.ilosc, 
                                      ks.tytul, ks.cena, ks.rok_wydania, ks.image_url, 
                                      au.imie, au.nazwisko 
                               FROM klienci AS kl, 
                                    koszyk AS ko, 
                                    ksiazki AS ks, 
                                    autor AS au 
                               WHERE kl.id_klienta = ko.id_klienta AND 
                                     ko.id_ksiazki = ks.id_ksiazki AND 
                                     ks.id_autora = au.id_autora AND 
                                     kl.id_klienta='%s'", "getProductsFromCart", $_SESSION["id"]);

                        query("SELECT fd.id_formy_dostawy AS id, fd.nazwa, fd.cena FROM formy_dostawy AS fd", "getDeliveryTypes", "");

                        query("SELECT mp.id_metody_platnosci AS id, mp.nazwa, mp.oplata FROM metody_platnosci AS mp", "getPaymentMethods", "");

                    ?>

                    <form action="___order.php" method="post" id="submit-order">

                        <p>
                            <strong>
                                Wybierz formę dostawy
                            </strong>
                        </p>

                        <div id="delivery-type">

                            <?php
                                foreach ($_SESSION["delivery-types"] as $name => $values) {

                                    $deliveryOption = file_get_contents("../template/delivery-option.php");

                                    echo sprintf($deliveryOption, $name, strtolower(str_replace([" ", "/"], ["_", ""], $name)), $name, $name, $name, $values["cena"]);
                                }
                            ?>

                        </div>

                        <p>
                            <strong>
                                Wybierz metodę płatności
                            </strong>
                        </p>

                        <div id="payment-method">

                        <?php

                            foreach ($_SESSION["payment-methods"] as $name => $values) {

                                $paymentMethod = file_get_contents("../template/payment-method.php");

                                echo sprintf($paymentMethod, $name, strtolower(str_replace([" ", "/"], ["_", ""], $name)), $name, $name, $name, $values["oplata"]);
                            }
                        ?>

                        </div>

                        <h3 id="cart-header" class="address-data">Dane adresowe</h3>

                            <div class="order-address-data">
                                <?= $_SESSION["imie"] . " " . $_SESSION["nazwisko"]; ?>
                            </div>
                            <div class="order-address-data">
                                <?= $_SESSION["miejscowosc"] . ", "; ?>
                                <?= !empty($_SESSION["ulica"]) ? (" ul. " . $_SESSION["ulica"] . " ") : " "; ?>
                                <?= $_SESSION["numer_domu"] . " "; ?>



                            </div>
                            <div class="order-address-data">
                                <?= $_SESSION["kod_pocztowy"] . " " . $_SESSION["kod_miejscowosc"]; ?>
                            </div>

                        <!--<button id="edit-user-data">Edytuj</button>-->

                        <hr id="submit-order">

                        <h3 id="order-sum">
                            <span class="order-sum order-sum-cart">suma</span><?= $_SESSION["suma_zamowienia"]; ?> PLN
                        </h3>



                        <button type="submit" class="btn-link btn-link-static">
                            Zamawiam
                        </button>

                    </form>

                    <p>
                        <strong id="order-error">
                            <?php
                                if (isset($_SESSION["order-error"])) {
                                    echo $_SESSION["order-error"];
                                    unset($_SESSION["order-error"]);
                                }
                            ?>
                        </strong>
                    </p>

                </div>

            </main>

        </div>

        <?php require "../view/___footer.php"; ?>

        <script>

            let form = document.getElementById("submit-order");

            form.addEventListener("submit", (event) => {

                let deliveryType = Array.from(form.querySelectorAll('input[name="delivery-type"]'));
                let paymentMethod = Array.from(form.querySelectorAll('input[name="payment-method"]'));

                let deliveryTypeChecked = deliveryType.filter(input => input.checked);
                let paymentMethodChecked = paymentMethod.filter(input => input.checked);

                let errorMessage = document.getElementById("order-error");

                if(deliveryTypeChecked.length <= 0) {

                    errorMessage.innerHTML = "Aby złożyć zamówienie, wybierz formę dostawy";

                } else if (paymentMethodChecked.length <= 0) {

                    errorMessage.innerHTML = "Aby złożyć zamówienie, wybierz metodę płatności";

                } else {
                    form.submit();
                }

                event.preventDefault();

            });

            document.addEventListener('DOMContentLoaded', function() {

                let deliveryTypes = document.querySelectorAll("input[type='radio'][name='delivery-type']");
                let paymentmethods = document.querySelectorAll("input[type='radio'][name='payment-method']");

                deliveryTypes.forEach(function(deliveryType) {

                    deliveryType.addEventListener('change', function() {

                        let price = parseFloat(this.closest('.option').querySelector('.delivery-price').textContent);

                        $.ajax({
                            type: "POST",
                            url: "update-order-sum.php",
                            data: {
                                "delivery-price": price
                            },
                            timeout: 2000,
                            success: function(data) {

                                let orderSum = data.suma_zamowienia.toFixed(2);

                                let header = document.getElementById("order-sum");
                                header.lastChild.textContent = orderSum + " PLN";

                            }
                        });
                    });
                });

                paymentmethods.forEach(function(paymentMethod) {

                    paymentMethod.addEventListener('change', function() {

                        let selectedPaymentMethod = this.value;

                        let price = parseFloat(this.closest('.option').querySelector('.payment-price').textContent);

                        $.ajax({
                            type: "POST",
                            url: "update-order-sum.php",
                            data: {
                                "payment-price": price
                            },
                            timeout: 2000,
                            success: function(data) {

                                let orderSum = Number(data.suma_zamowienia).toFixed(2);

                                let header = document.getElementById("order-sum");
                                header.lastChild.textContent = orderSum + " PLN";
                            }
                        });
                    });
                });

            });

        </script>

    </div> <!-- #main-container -->

    <script src="../scripts/change_cart_quantity.js"></script> <!-- Ajax - zmiany ilości książek w koszyku -->

</body>
</html>