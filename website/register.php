<?php
include 'header.php';
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ssn = $_POST['ssn'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $id_type = $_POST['id_type'];
    $registration_date = date("Y-m-d");

    // Insertion dans la table CUSTOMER
    $stmt = $pdo->prepare("INSERT INTO CUSTOMER (SSN, full_name, address, id_type, registration_date) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$ssn, $full_name, $address, $id_type, $registration_date])){
        echo "<p>Registration successful!</p>";
    } else {
        echo "<p>Error during registration.</p>";
    }
}
?>
<img src="assets/register_image.jpg" class="image-register" alt="Registration Image" />
<div class="container3">
    <h2>Customer Registration</h2>
    <form method="post" action="">
        <label for="ssn">SSN/NAS:</label>
        <input type="text" id="ssn" name="ssn" required><br><br>
        
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address"><br><br>
        
        <label for="id_type">ID Type:</label>
        <select id="id_type" name="id_type" required>
            <option value="SSN">SSN</option>
            <option value="SIN">SIN</option>
            <option value="Driving License">Driving License</option>
        </select><br><br>
        
        <input type="submit" value="Register">
    </form>
</div>

<?php
include 'footer.php';
?>
