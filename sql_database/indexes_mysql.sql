-- indexes_mysql.sql
USE e_hotels;

CREATE INDEX idx_booking_start_end ON BOOKING (start_date, end_date);
CREATE INDEX idx_hotel_city ON HOTEL (hotelcity);
CREATE INDEX idx_room_capacity ON HOTELROOM (roomcapacity);
