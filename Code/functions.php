<?php


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'Flight_Scanner');
define('DB_USER', 'Flight_Team');
define('DB_PASS', 'Flight');


 
function getDatabaseConnection() {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("Could not connect to the database: " . $e->getMessage());
    }
}

function findFlights($departure, $arrival, $date) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM flights WHERE departureAirport = :departure AND arrivalAirport = :arrival AND departureDate = :date");
    $stmt->execute([':departure' => $departure, ':arrival' => $arrival, ':date' => $date]);
    return $stmt->fetchAll(PDO::FETCH_OBJ); 
}

function findFlightById($id) {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->prepare("SELECT * FROM flights WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result ? $result : null;

}
