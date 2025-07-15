<?php
session_start();
include 'header.php';
include 'config.php';

// Seul un client peut accéder à cette page
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'customer') {
    header("Location: login.php");
    exit();
}

// Récupération de l'identifiant de la chambre via GET
$room_id = $_GET['room_id'] ?? null;
if (!$room_id) {
    echo "<p>No room selected.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Définition de la date de réservation à la date actuelle
    $booking_date = date("Y-m-d");
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $customer_ssn = $_SESSION['user']['SSN'];
    
    // Insertion dans la table BOOKING avec les noms de colonnes conformes
    $stmt = $pdo->prepare("INSERT INTO BOOKING (customer_ssn, room_id, booking_date, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$customer_ssn, $room_id, $booking_date, $start_date, $end_date])) {
        echo "<p>Booking successful!</p>";
    } else {
        echo "<p>Error during booking.</p>";
    }
}
?>

<h2>Book Room <?php echo htmlspecialchars($room_id); ?></h2>
<form method="post" action="">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required><br><br>
    
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required><br><br>
    
    <input type="submit" value="Book Room">
</form>

<?php include 'footer.php'; ?>
