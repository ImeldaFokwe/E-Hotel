USE e_hotels;

-- Vue 1: Nombre de chambres disponibles par ville
CREATE VIEW available_rooms_per_city AS
SELECT h.hotelcity, COUNT(r.roomid) AS available_rooms
FROM HOTEL h
JOIN HOTELROOM r ON h.hotelid = r.hotelid
LEFT JOIN BOOKING b 
    ON r.roomid = b.room_id
    AND CURDATE() BETWEEN b.start_date AND b.end_date
WHERE b.ID IS NULL
GROUP BY h.hotelcity;

-- Vue 2: Capacité agrégée de toutes les chambres par hôtel
CREATE VIEW hotel_capacity AS
SELECT h.hotelname, SUM(r.roomcapacity) AS total_capacity
FROM HOTEL h
JOIN HOTELROOM r ON h.hotelid = r.hotelid
GROUP BY h.hotelid, h.hotelname;
