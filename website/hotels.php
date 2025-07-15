<?php
session_start();
include 'header.php';
include 'config.php';

// Requête mise à jour pour utiliser les noms de colonnes du nouveau schéma.
// On sélectionne le numéro de chambre (roomid) de HOTELROOM, l'adresse de l'hôtel (hoteladdress)
// et la ville (hotelcity, que nous utilisons ici comme "area"), le prix (roomprice) et la capacité (roomcapacity).
$stmt = $pdo->prepare("SELECT hr.roomid AS room_id, h.hoteladdress AS address, h.hotelcity AS area, hr.roomprice AS price, hr.roomcapacity AS capacity 
                       FROM HOTELROOM hr
                       JOIN HOTEL h ON hr.hotelid = h.hotelid");
$stmt->execute();
$rooms = $stmt->fetchAll();
?>
<div style="text-align: center; margin-top: 20px;">
    <img src="assets/hotel_list.jpg" alt="Hotel List" style="max-width: 90%; height: auto; border-radius: 10px;">
</div>
<h2>Available Rooms</h2>
<table border="1">
    <tr>
        <th>Room ID</th>
        <th>Hotel Address</th>
        <th>Area</th>
        <th>Price</th>
        <th>Capacity</th>
        <th>Action</th>
    </tr>
    <?php foreach($rooms as $room): ?>
    <tr>
        <td><?php echo htmlspecialchars($room['room_id']); ?></td>
        <td><?php echo htmlspecialchars($room['address']); ?></td>
        <td><?php echo htmlspecialchars($room['area']); ?></td>
        <td><?php echo htmlspecialchars($room['price']); ?></td>
        <td><?php echo htmlspecialchars($room['capacity']); ?></td>
        <td><a href="book.php?room_id=<?php echo htmlspecialchars($room['room_id']); ?>">Book Now</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
