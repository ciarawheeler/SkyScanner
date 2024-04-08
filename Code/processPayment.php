<?php
session_start();
include 'functions.php';

function updateFlightSeats($flightId, $seatType, $quantity) {
    $pdo = getDatabaseConnection();
    $sql = "UPDATE flights SET {$seatType}Seats = {$seatType}Seats - :quantity WHERE id = :flightId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':quantity' => $quantity, ':flightId' => $flightId]);
}

function processPayment($fullName, $email, $cardName, $cardNumber, $cardExp, $cardCVV) {
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $cardName = filter_input(INPUT_POST, 'cardName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cardNumber = $_POST['cardNumber'];
    $cardExp = $_POST['cardExp'];
    $cardCVV = $_POST['cardCVV'];

    $paymentSuccess = processPayment($fullName, $email, $cardName, $cardNumber, $cardExp, $cardCVV);

    if ($paymentSuccess) {
        $_SESSION['payment_success'] = true;
        $orderDetails = '';
        $totalCost = 0;

        foreach ($_SESSION['cart'] as $item) {
            updateFlightSeats($item['flightId'], $item['seatType'], $item['quantity']);
            
            $flightDetails = findFlightById($item['flightId']); 
            $itemTotalCost = $item['cost'] * $item['quantity'];
            $totalCost += $itemTotalCost;
            $orderDetails .= "Flight: From {$flightDetails['departure_airport']} to {$flightDetails['arrival_airport']}, ";
            $orderDetails .= "Seat: {$item['seatType']}, Quantity: {$item['quantity']}, ";
            $orderDetails .= "Total Cost: \$$itemTotalCost\n";
        }

        $_SESSION['order_details'] = $orderDetails;
        $_SESSION['total_cost'] = $totalCost;
        unset($_SESSION['cart']);
        header('Location: confirmation.php');
        exit;
    } 
}

?>