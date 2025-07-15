-- triggers_mysql.sql
USE e_hotels;
DELIMITER $$

-- Trigger: Empêcher la suppression d'un manager qui gère un hôtel
DROP TRIGGER IF EXISTS prevent_manager_deletion_trigger$$
CREATE TRIGGER prevent_manager_deletion_trigger
BEFORE DELETE ON EMPLOYEE
FOR EACH ROW
BEGIN
    IF EXISTS (SELECT 1 FROM HOTEL WHERE managerssn = OLD.SSN) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete manager who is managing a hotel';
    END IF;
END$$

-- Trigger: Définir automatiquement booking_date avant insertion dans BOOKING
DROP TRIGGER IF EXISTS set_bookingdate_trigger$$
CREATE TRIGGER set_bookingdate_trigger
BEFORE INSERT ON BOOKING
FOR EACH ROW
BEGIN
    SET NEW.booking_date = NOW();
END$$

-- Trigger: Définir automatiquement registration_date lors de l'insertion dans CUSTOMER
DROP TRIGGER IF EXISTS set_clientsignupdate_trigger$$
CREATE TRIGGER set_clientsignupdate_trigger
BEFORE INSERT ON CUSTOMER
FOR EACH ROW
BEGIN
    SET NEW.registration_date = NOW();
END$$

DELIMITER ;
