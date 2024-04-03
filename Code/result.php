
<?php
session_start();

$servername = "127.0.0.1";
$username = "Flight_Team";
$password = "Flight";
$dbname = "Flight_Scanner";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$departure = $_POST['departure'];
$arrival = $_POST['arrival'];
$date = $_POST['date'];


$sql = "SELECT * FROM routes WHERE departure_airport=? AND arrival_airport=? AND date=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $departure, $arrival, $date);
$stmt->execute();
$result = $stmt->get_result();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Results</title>
    <link rel="stylesheet" href="CSS/result.css">
</head>4
<body>

<div class="container">
    <a href="index.php" class="back-btn">Back to Home</a>
    <h2>Available Flights</h2>
    <?php if ($result->num_rows > 0): ?>
        <div class="flights-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="flight-card">
                <div class="flight-info">
                    <span><strong>Departure:</strong> <?= htmlspecialchars($row["departure_airport"]) ?></span>
                    <span><strong>Arrival:</strong> <?= htmlspecialchars($row["arrival_airport"]) ?></span>
                    <span><strong>Date:</strong> <?= htmlspecialchars($row["date"]) ?></span>
                    <span><strong>Time:</strong> <?= htmlspecialchars($row["time"]) ?></span>
                    <span class="price"><strong>Price:</strong> $<?= htmlspecialchars($row["cost"]) ?></span>
                </div>
                <form action="addToCart.php" method="post" class="cart-form">
                    <input type="hidden" name="flightId" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn add-to-cart">Add to Cart</button>
                </form>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="no-flights">No flights found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>