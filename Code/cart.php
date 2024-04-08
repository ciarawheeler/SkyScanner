<?php
include 'functions.php';
session_start();

function removeFromCart($index) {
    array_splice($_SESSION['cart'], $index, 1);
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['index'])) {
    removeFromCart($_GET['index']);
    header('Location: cart.php'); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="Css/cart.css">
</head>
<body>
<div class="container">
    <h1>Your Shopping Cart</h1>
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-items">
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <div class="cart-item">
                    <div class="item-info">
                        <p>Flight from <?= htmlspecialchars($item['departureAirport']) ?> to <?= htmlspecialchars($item['arrivalAirport']) ?> on <?= htmlspecialchars($item['departureDate']) ?></p>
                        <p>Seat Type: <?= htmlspecialchars($item['seatType']) ?>, Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                        <p>Cost: $<?= htmlspecialchars($item['cost']) ?></p>
                    </div>
                    <div class="item-actions">
                        <a href="?action=remove&index=<?= $index ?>" class="btn remove-btn">Remove</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="cart-actions">
            <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>
</body>
</html>
