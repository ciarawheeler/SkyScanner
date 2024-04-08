<?php
include 'functions.php';
session_start();

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flightId = $_POST['flightId'] ?? '';
    $seatType = $_POST['seatType'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;

    if (!empty($flightId) && !empty($seatType) && !empty($quantity)) {
        try {
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("SELECT id, departure_airport, arrival_airport, departure_date, departure_time, arrival_time, cost, first_class_seats, business_seats, main_cabin_seats FROM flights WHERE id = :flightId");
            $stmt->execute([':flightId' => $flightId]);
            $flight = $stmt->fetch();

            if ($flight) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                $cost = $flight['cost']; 

                $cartItem = [
                    'flightId' => $flight['id'],
                    'departureAirport' => $flight['departure_airport'],
                    'arrivalAirport' => $flight['arrival_airport'],
                    'departureDate' => $flight['departure_date'],
                    'departureTime' => $flight['departure_time'],
                    'arrivalTime' => $flight['arrival_time'],
                    'seatType' => $seatType,
                    'quantity' => $quantity,
                    'cost' => $cost
                ];

                $_SESSION['cart'][] = $cartItem;

                 header('Location: cart.php');
            } else {
                echo 'Selected flight not found.';
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        echo 'Invalid flight selection.';
    }
} else {
         header('Location: index.php');
}
?>
