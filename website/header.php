<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>e-Hotels</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style pour indiquer la page active */
        nav a.active {
            font-weight: bold;
            color: yellow;
        }
    </style>
</head>
<body>
    <header>
        <h1>e-Hotels</h1>
        <nav>
            <!-- Lien vers la page d'accueil -->
            <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a> |
            
            <!-- Lien vers la recherche de chambres, sauf sur la page d'accueil -->
            <?php if ($currentPage !== 'index.php') : ?>
                <a href="search.php" class="<?= $currentPage === 'search.php' ? 'active' : '' ?>">Search Rooms</a> |
            <?php endif; ?>
            
            <!-- Lien vers la page d'inscription uniquement sur la page d'accueil et si l'utilisateur n'est pas connecté -->
            <?php if (!isset($_SESSION['user']) && $currentPage === 'index.php') : ?>
                <a href="register.php" class="<?= $currentPage === 'register.php' ? 'active' : '' ?>">Register</a> |
            <?php endif; ?>
            
            <!-- Lien vers la page des hôtels -->
            <a href="hotels.php" class="<?= $currentPage === 'hotels.php' ? 'active' : '' ?>">Hotels</a> |
            
            <!-- Lien vers Login ou Logout selon la session -->
            <?php if (!isset($_SESSION['user'])) : ?>
                <?php if ($currentPage !== 'index.php') : ?>
                    <a href="login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">Login</a> |
                <?php endif; ?>
            <?php else : ?>
                <a href="logout.php">Logout</a> |
            <?php endif; ?>
        </nav>
    </header>
    <main>
