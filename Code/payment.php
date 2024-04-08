<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Information</title>
    <link rel="stylesheet" href="Css/payment.css"> 
</head>
<body>
<div class="container">
    <h2>Payment Information</h2>
    <form action="processPayment.php" method="post">
        <div class="form-group">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="cardName">Cardholder Name:</label>
            <input type="text" id="cardName" name="cardName" required>
        </div>
        <div class="form-group">
            <label for="cardNumber">Card Number:</label>
            <input type="text" id="cardNumber" name="cardNumber" maxlength="16" pattern="\d{16}" required>
        </div>
        <div class="form-group">
            <label for="cardExp">Expiration Date:</label>
            <input type="text" id="cardExp" name="cardExp" placeholder="MM/YY" pattern="\d{2}/\d{2}" required>
        </div>
        <div class="form-group">
            <label for="cardCVV">CVV:</label>
            <input type="text" id="cardCVV" name="cardCVV" maxlength="3" pattern="\d{3}" required>
        </div>        <div class="form-group">
            <button type="submit" class="btn submit-btn">Submit Payment</button>
        </div>
    </form>
</div>
</body>
</html>
