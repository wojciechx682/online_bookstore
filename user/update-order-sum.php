<?php
session_start();

// Sprawdzenie, czy istnieje sesja z zamówieniem, jeśli nie to ustalamy domyślne wartości
if (!isset($_SESSION['suma_zamowienia'])) {
    $_SESSION['suma_zamowienia'] = 0;
}

if (!isset($_SESSION['delivery-price'])) {
    $_SESSION['delivery-price'] = 0;
}

if (!isset($_SESSION['payment-price'])) {
    $_SESSION['payment-price'] = 0;
}

// Obsługa zmiany ceny dostawy
if (isset($_POST['delivery-price'])) {
    $newDeliveryPrice = floatval($_POST['delivery-price']);

    // Odejmujemy starą cenę dostawy od sumy zamówienia
    $_SESSION['suma_zamowienia'] -= $_SESSION['delivery-price'];

    // Ustawiamy nową cenę dostawy
    $_SESSION['delivery-price'] = $newDeliveryPrice;

    // Dodajemy nową cenę dostawy do sumy zamówienia
    $_SESSION['suma_zamowienia'] += $newDeliveryPrice;
}

// Obsługa zmiany ceny płatności
if (isset($_POST['payment-price'])) {
    $newPaymentPrice = floatval($_POST['payment-price']);

    // Odejmujemy starą cenę płatności od sumy zamówienia
    $_SESSION['suma_zamowienia'] -= $_SESSION['payment-price'];

    // Ustawiamy nową cenę płatności
    $_SESSION['payment-price'] = $newPaymentPrice;

    // Dodajemy nową cenę płatności do sumy zamówienia
    $_SESSION['suma_zamowienia'] += $newPaymentPrice;
}

// Zwracamy aktualną sumę zamówienia w formacie JSON
echo json_encode(['suma_zamowienia' => $_SESSION['suma_zamowienia']]);
?>
