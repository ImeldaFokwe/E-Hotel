USE e_hotels;

-- Query 1: Liste de toutes les réservations avec le nom du client et le prix de la chambre
SELECT 
    b.ID AS BookingID, 
    c.full_name, 
    hr.roomprice AS price, 
    b.start_date, 
    b.end_date
FROM BOOKING b
JOIN CUSTOMER c ON b.customer_ssn = c.SSN
JOIN HOTELROOM hr ON b.room_id = hr.roomid;

-- Query 2: Prix moyen des chambres par chaîne hôtelière
SELECT 
    hc.chainid AS ChainID, 
    AVG(hr.roomprice) AS AveragePrice
FROM HOTELCHAIN hc
JOIN HOTEL h ON hc.chainid = h.chainid
JOIN HOTELROOM hr ON h.hotelid = hr.hotelid
GROUP BY hc.chainid;

-- Query 3: Sous-requête - Trouver les hôtels possédant au moins une chambre en dessous du prix moyen général
SELECT 
    h.hotelid, 
    h.hoteladdress, 
    h.hotelcity
FROM HOTEL h
WHERE EXISTS (
    SELECT 1
    FROM HOTELROOM hr
    WHERE hr.hotelid = h.hotelid
      AND hr.roomprice < (SELECT AVG(roomprice) FROM HOTELROOM)
);

-- Query 4: Recherche complexe – Trouver les chambres disponibles à Manhattan, de capacité "double" et dans une plage de prix spécifique
-- Ici, nous supposons que "double" correspond à une capacité numérique de 2.
SELECT 
    hr.roomid, 
    h.hoteladdress, 
    h.hotelcity, 
    hr.roomprice, 
    hr.roomcapacity
FROM HOTELROOM hr
JOIN HOTEL h ON hr.hotelid = h.hotelid
WHERE h.hotelcity = 'Manhattan'
  AND hr.roomcapacity = 2
  AND hr.roomprice BETWEEN 150 AND 250;
