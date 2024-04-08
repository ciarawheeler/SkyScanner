<?php
include 'functions.php'; 
session_start();
$_SESSION['last_search_url'] = $_SERVER['REQUEST_URI'];
$departure = $_GET['departureAirport'] ?? '';
$arrival = $_GET['arrivalAirport'] ?? '';
$date = $_GET['departureDate'] ?? '';

try {
    $pdo = getDatabaseConnection(); 

    $stmt = $pdo->prepare("SELECT * FROM flights WHERE departure_airport = :departure AND arrival_airport = :arrival AND DATE(departure_date) = :date");
    $stmt->execute([':departure' => $departure, ':arrival' => $arrival, ':date' => $date]);
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Results</title>
    <link rel="stylesheet" href="Css/results.css"> 
</head>
<body>
<div class="container">
    <header class="page-header">
        <a href="index.php" class="btn back-btn">Back to Home</a>
        <a href="cart.php" class="btn cart-btn">Cart (<?= count($_SESSION['cart'] ?? []) ?>)</a>
    </header>
    <h2>Flight Results</h2>
    <?php if (!empty($results)): ?>
        <div class="flights-container">
            <?php foreach ($results as $flight): ?>
                <div class="flight-card">
                    <div class="flight-info">
                        <div class="flight-header">
                            <span><?= htmlspecialchars($flight->departure_airport) ?> → <?= htmlspecialchars($flight->arrival_airport) ?></span>
                            <span class="flight-date"><?= htmlspecialchars($flight->departure_date) ?></span>
                        </div>
                        <div class="flight-body">
                            <div class="flight-times">
                                <span>Depart: <?= htmlspecialchars($flight->departure_time) ?></span>
                                <span>Arrive: <?= htmlspecialchars($flight->arrival_time) ?></span>
                            </div>
                            <div class="flight-seats">
                                <span>Seats: First Class - <?= $flight->first_class_seats ?>, Business - <?= $flight->business_seats ?>, Main Cabin - <?= $flight->main_cabin_seats ?></span>
                            </div>
                            <div class="flight-cost">Cost: $<?= htmlspecialchars($flight->cost) ?></div>
                        </div>
                    </div>
                    <form action="addToCart.php" method="post" class="seat-selection-form">
                        <input type="hidden" name="flightId" value="<?= $flight->id ?>">
                        <select name="seatType" class="seat-type-dropdown">
                            <option value="firstClass">First Class</option>
                            <option value="business">Business</option>
                            <option value="mainCabin">Main Cabin</option>
                        </select>
                        <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                        <button type="submit" class="btn add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No flights found matching your search criteria.</p>
    <?php endif; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                alert('Item added to cart');
                var cartCount = parseInt($('.cart-btn').text().match(/\d+/)) || 0;
                $('.cart-btn').text('Cart (' + (cartCount + parseInt(form.find('.quantity-input').val())) + ')');
            }
        });
    });
});
</script>
</body>
</html>
