<?php
session_start();

if (!isset($_SESSION['order_details']) || !isset($_SESSION['total_cost'])) {
    header('Location: index.php');
    exit();
}

$orderDetails = $_SESSION['order_details'];
$totalCost = $_SESSION['total_cost'];

unset($_SESSION['order_details'], $_SESSION['total_cost']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="Css/confirm.css"> 
</head>
<body>
<div class="container">
    <h1>Thank You for Your Purchase!</h1>
    <h2>Your Order Details</h2>
    <div class="order-details">
        <?= nl2br(htmlspecialchars($orderDetails)); ?>
    </div>
    <p><strong>Total Cost: </strong>$<?= htmlspecialchars($totalCost); ?></p>
    <a href="index.php" class="btn">Return Home</a>
</div>
</body>
</html>
