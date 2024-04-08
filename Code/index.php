<?php include 'functions.php';  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find Cheap Flights</title>
    <link rel="stylesheet" href="Css/index.css">
</head>
<body>
    <div class="container">
        <h1>Search for Flights</h1>
        <form action="results.php" method="GET">
            <div class="form-group">
                <label for="departureAirport">Departure Airport:</label>
                <select id="departureAirport" name="departureAirport">
                    <?php
                    try {
                        $pdo = getDatabaseConnection(); 
                        $query = 'SELECT airport_code, airport_name FROM airports ORDER BY airport_name ASC';
                        $stmt = $pdo->query($query);
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . htmlspecialchars($row['airport_code']) . '">' . htmlspecialchars($row['airport_name']) . "</option>\n";
                        }
                    } catch (PDOException $e) {
                        die("Could not connect to the database:" . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="arrivalAirport">Arrival Airport:</label>
                <select id="arrivalAirport" name="arrivalAirport">
                    <?php
                    $stmt = $pdo->query($query); 
                        
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"" . htmlspecialchars($row['airport_code']) . "\">" . htmlspecialchars($row['airport_name']) . "</option>\n";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="departureDate">Departure Date:</label>
                <input type="date" id="departureDate" name="departureDate" required>
            </div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
    <footer>
        <p>SkyScanner&copy; 2024</p>
    </footer>
</body>
</html>
