<?php
session_start();
include 'header.php';
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ssn = $_POST['ssn'];
    $user_type = $_POST['user_type']; // 'customer' or 'employee'
    
    if ($user_type == "customer") {
        $stmt = $pdo->prepare("SELECT * FROM CUSTOMER WHERE SSN = ?");
        $stmt->execute([$ssn]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['user'] = $user;
            $_SESSION['user_type'] = 'customer';
            header("Location: search.php");
            exit();
        } else {
            $error = "Customer not found.";
        }
    } else if ($user_type == "employee") {
        $stmt = $pdo->prepare("SELECT * FROM EMPLOYEE WHERE SSN = ?");
        $stmt->execute([$ssn]);
        $user = $stmt->fetch();
        if ($user) {
            $_SESSION['user'] = $user;
            $_SESSION['user_type'] = 'employee';
            header("Location: admin.php");
            exit();
        } else {
            $error = "Employee not found.";
        }
    }
}
?>

<img src="assets/login_image.jpg" class="image-register" alt="Login Image" />
<div class="container3">
    <h2>Login</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="">
        <label for="ssn">SSN/NAS:</label>
        <input type="text" id="ssn" name="ssn" required><br><br>
        
        <label for="user_type">I am a:</label>
        <select id="user_type" name="user_type" required>
            <option value="customer">Customer</option>
            <option value="employee">Employee</option>
        </select><br><br>
        
        <input type="submit" value="Login">
    </form>
</div>

<?php include 'footer.php'; ?>
