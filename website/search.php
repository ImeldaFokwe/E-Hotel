<?php
session_start();
include 'header.php';
include 'config.php';

// Traitement des critères de recherche transmis via GET
$where = [];
$params = [];

// Utilise la colonne hotelcity pour l'area
if (isset($_GET['area']) && $_GET['area'] != '') {
    $where[] = "h.hotelcity = ?";
    $params[] = $_GET['area'];
}
if (isset($_GET['capacity']) && $_GET['capacity'] != '') {
    $where[] = "r.roomcapacity = ?";
    $params[] = $_GET['capacity'];
}
if (isset($_GET['hotel_chain']) && $_GET['hotel_chain'] != '') {
    $where[] = "hc.chainid = ?";
    $params[] = $_GET['hotel_chain'];
}
// La colonne "category" n'existe pas dans le schéma actuel, donc on la retire.
// if (isset($_GET['category']) && $_GET['category'] != '') {
//     $where[] = "h.category = ?";
//     $params[] = $_GET['category'];
// }
if (isset($_GET['max_price']) && $_GET['max_price'] != '') {
    $where[] = "r.roomprice <= ?";
    $params[] = $_GET['max_price'];
}

$whereSQL = count($where) ? "WHERE " . implode(" AND ", $where) : "";

// Requête mise à jour avec les noms de tables et de colonnes du nouveau schéma
$sql = "SELECT r.roomid AS room_id, h.hoteladdress AS address, h.hotelcity AS area, r.roomprice AS price, r.roomcapacity AS capacity, hc.chainid AS chain_id
        FROM HOTELROOM r
        JOIN HOTEL h ON r.hotelid = h.hotelid
        JOIN HOTELCHAIN hc ON h.chainid = hc.chainid
        $whereSQL";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();
?>

<!-- Vidéo en arrière-plan -->
<video class="video-background" autoplay muted loop>
    <source src="assets/search_hotel_video.mp4" type="video/mp4">
    Votre navigateur ne supporte pas la balise vidéo.
</video>

<div class="container2">
    <h2>Search Available Rooms</h2>
    <form method="get" action="">
        <label for="area">Area:</label>
        <input type="text" id="area" name="area" value="<?php echo htmlspecialchars($_GET['area'] ?? ''); ?>"><br><br>
        
        <label for="capacity">Room Capacity:</label>
        <select id="capacity" name="capacity">
            <option value="">Any</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select><br><br>
        
        <label for="hotel_chain">Hotel Chain ID:</label>
        <input type="text" id="hotel_chain" name="hotel_chain" value="<?php echo htmlspecialchars($_GET['hotel_chain'] ?? ''); ?>"><br><br>
        
        <!-- Champ "Hotel Category" supprimé car la colonne n'existe pas -->
        
        <label for="max_price">Maximum Price:</label>
        <input type="number" id="max_price" name="max_price" step="0.01" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>"><br><br>
        
        <input type="submit" value="Search">
    </form>
</div>

<h3>Search Results:</h3>
<table border="1">
    <tr>
        <th>Room ID</th>
        <th>Address</th>
        <th>Area</th>
        <th>Price</th>
        <th>Capacity</th>
        <th>Hotel Chain</th>
        <th>Action</th>
    </tr>
    <?php foreach($results as $room): ?>
    <tr>
        <td><?php echo htmlspecialchars($room['room_id']); ?></td>
        <td><?php echo htmlspecialchars($room['address']); ?></td>
        <td><?php echo htmlspecialchars($room['area']); ?></td>
        <td><?php echo htmlspecialchars($room['price']); ?></td>
        <td><?php echo htmlspecialchars($room['capacity']); ?></td>
        <td><?php echo htmlspecialchars($room['chain_id']); ?></td>
        <td><a href="book.php?room_id=<?php echo htmlspecialchars($room['room_id']); ?>">Book Now</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
