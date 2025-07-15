<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #333;
            padding: 20px;
            color: white;
            text-align: center;
        }

        footer {
            background-color: #333;
            padding: 10px;
            color: white;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .logout-container {
            max-width: 900px;
            margin: 50px auto 100px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            overflow: hidden;
        }

        .image-overlay-container {
            position: relative;
        }

        .image-overlay-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px 40px;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .logout-text {
            padding: 20px;
        }

        .logout-text a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>e-Hotels</h1>
    </header>

    <main class="logout-container">
        <!-- Image avec texte superposé -->
        <div class="image-overlay-container">
            <img src="assets/log_out.jpg" alt="Logout Image">
            <div class="overlay-text">You have been logged out</div>
        </div>

        <div class="logout-text">
            <p>You’re now logged out. Thanks for visiting <strong>e-Hotels</strong>!</p>
            <p><a href="index.php">Return to Home</a></p>
        </div>
    </main>

    <footer>
        &copy; 2025 e-Hotels. All rights reserved.
    </footer>
</body>
</html>
