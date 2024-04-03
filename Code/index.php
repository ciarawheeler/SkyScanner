<!DOCTYPE html>
<html>
<head>
    <title>Flight Scanner</title>
    <link rel="stylesheet" href="CSS/HomePage.css">
    
</head>
<body>
<body>
    <div class="container">
        <h1>Search for Flights</h1>
        <form action="result.php" method="POST">
            <label for="departure">Departure Airport:</label>
            <input type="text" id="departure" name="departure">
            
            <label for="arrival">Arrival Airport:</label>
            <input type="text" id="arrival" name="arrival">
            
            <label for="date">Departure Date:</label>
            <input type="date" id="date" name="date">
            
            <input type="submit" value="Find Flights">
        </form>
    </div>
    <footer>
        <p>Flight Finder &copy; 2024</p>
    </footer>
</body>

</body>
</html>
