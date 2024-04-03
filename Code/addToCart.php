<?php
session_start();

// Initialize cart if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add flight to cart
if (isset($_POST['flightId'])) {
    array_push($_SESSION['cart'], $_POST['flightId']);
    header("Location: results.php"); // Redirect back to results page or to a cart page
} else {
    echo "No flight selected.";
}
?>