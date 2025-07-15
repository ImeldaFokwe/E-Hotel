<?php
session_start();
include 'header.php';
include 'config.php';

// Autorise uniquement les employés
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 'employee') {
    header("Location: login.php");
    exit();
}

$employee_ssn = $_SESSION['user']['SSN'];

// La requête récupère le rôle de l'employé depuis EMP_ROLE et EMPLOYEE_ROLE.
$stmt = $pdo->prepare("
    SELECT er.role_id, erl.role_name 
    FROM EMP_ROLE er 
    JOIN EMPLOYEE_ROLE erl ON er.role_id = erl.ID 
    WHERE er.employee_ssn = ?
");
$stmt->execute([$employee_ssn]);
$role = $stmt->fetch();

// Vérifie que l'employé a bien le rôle 'manager'
if ($role['role_name'] != 'manager') {
    echo "<p>Access denied. Only managers can access this page.</p>";
    include 'footer.php';
    exit();
}
?>

<main>
    <h2>Manager Administration Panel</h2>
    <p>Here you can manage hotels, rooms, employees, and customer payments.</p>
    <!-- Par exemple, des liens pour insérer/modifier/supprimer des enregistrements -->
    <p><a href="view_available_rooms.php">View Available Rooms by Area (View 1)</a></p>
    <p><a href="view_aggregated_capacity.php">View Aggregated Room Capacity per Hotel (View 2)</a></p>
</main>

<?php include 'footer.php'; ?>
