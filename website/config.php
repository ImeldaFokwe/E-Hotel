<?php
// config.php: Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'e_hotels';
$user = 'root';
$pass = ''; // Ajustez si nécessaire

try {
    // Création d'une instance PDO avec le charset UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Définir le mode d'erreur sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // En cas d'erreur, arrêter le script et afficher le message
    die("Connection failed: " . $e->getMessage());
}
?>
