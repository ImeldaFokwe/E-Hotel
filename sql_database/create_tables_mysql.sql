DROP DATABASE IF EXISTS e_hotels;
CREATE DATABASE e_hotels CHARACTER SET utf8 COLLATE utf8_general_ci;
USE e_hotels;

/* 1. Table: HOTELCHAIN (anciennement "hotelchain") */
CREATE TABLE HOTELCHAIN (
    chainid INT AUTO_INCREMENT PRIMARY KEY,
    chainnumhotels INT,
    bureauaddress VARCHAR(255),
    bureaucity VARCHAR(255),
    bureaupostalcode VARCHAR(255),
    chainphonenum VARCHAR(255),  -- valeurs séparées par des virgules
    chainemail VARCHAR(255),     -- idem
    chainname VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 2. Table: HOTEL (anciennement "hotel")
   On retire AUTO_INCREMENT pour pouvoir insérer explicitement l'identifiant */
CREATE TABLE HOTEL (
    hotelid INT PRIMARY KEY,
    chainid INT,
    hotelrating DECIMAL(2,1),
    hotelnumrooms INT,
    hoteladdress VARCHAR(255),
    hotelcity VARCHAR(255),
    hotelpostalcode VARCHAR(255),
    hotelphonenum VARCHAR(255),
    hotelemail VARCHAR(255),
    managerssn VARCHAR(50) NOT NULL,
    hotelname VARCHAR(255),
    CHECK (hotelrating >= 0 AND hotelrating <= 5),
    FOREIGN KEY (chainid) REFERENCES HOTELCHAIN(chainid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 3. Table: HOTEL_CHAIN_CONTACT */
CREATE TABLE HOTEL_CHAIN_CONTACT (
    chain_id INT,
    contact_type ENUM('email','telephone') NOT NULL,
    contact VARCHAR(100) NOT NULL,
    PRIMARY KEY (chain_id, contact_type, contact),
    FOREIGN KEY (chain_id) REFERENCES HOTELCHAIN(chainid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 4. Table: HOTEL_CONTACT */
CREATE TABLE HOTEL_CONTACT (
    hotel_id INT,
    contact_type ENUM('email','telephone') NOT NULL,
    contact VARCHAR(100) NOT NULL,
    PRIMARY KEY (hotel_id, contact_type, contact),
    FOREIGN KEY (hotel_id) REFERENCES HOTEL(hotelid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 5. Table: HOTELROOM (anciennement "hotelroom") */
CREATE TABLE HOTELROOM (
    roomid INT AUTO_INCREMENT PRIMARY KEY,
    roomprice DECIMAL(10,2),
    roomcapacity INT,
    roomviewtype ENUM('sea','mountain','city','garden','pool','street'),
    roomexpandable BOOLEAN,
    roomcommodities VARCHAR(255),  -- chaîne de caractères avec valeurs séparées par des virgules
    roomproblems TEXT,
    hotelid INT,
    FOREIGN KEY (hotelid) REFERENCES HOTEL(hotelid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 6. Table: CUSTOMER (anciennement "client") */
CREATE TABLE CUSTOMER (
    SSN VARCHAR(50) PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    id_type VARCHAR(50) NOT NULL,
    registration_date DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 7. Table: EMPLOYEE (anciennement "employee") */
CREATE TABLE EMPLOYEE (
    SSN VARCHAR(50) PRIMARY KEY,
    hotel_id INT,
    full_name VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    FOREIGN KEY (hotel_id) REFERENCES HOTEL(hotelid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 8. Table: BOOKING */
CREATE TABLE BOOKING (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    customer_ssn VARCHAR(50),
    room_id INT,
    booking_date DATE,
    start_date DATE,
    end_date DATE,
    FOREIGN KEY (customer_ssn) REFERENCES CUSTOMER(SSN) ON DELETE SET NULL,
    FOREIGN KEY (room_id) REFERENCES HOTELROOM(roomid) ON DELETE SET NULL,
    CHECK (start_date < end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 9. Table: OCCUPANCY (anciennement "occupancy") */
CREATE TABLE OCCUPANCY (
    occupid INT AUTO_INCREMENT PRIMARY KEY,
    occstartdate DATE,
    occenddate DATE,
    clientssn VARCHAR(255),
    employeessn VARCHAR(255),
    paymentmethod ENUM('debit','credit','cash','paypal','voucher'),
    bookingid INT,
    FOREIGN KEY (bookingid) REFERENCES BOOKING(ID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 10. Table: WORKROLE (anciennement "workrole") */
CREATE TABLE WORKROLE (
    employeessn VARCHAR(255) NOT NULL,
    roleid INT NOT NULL,
    PRIMARY KEY (employeessn, roleid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 11. Table: EMPLOYEE_ROLE (anciennement "employeerole") */
CREATE TABLE EMPLOYEE_ROLE (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 12. Table: EMP_ROLE (association entre employé et rôle) */
CREATE TABLE EMP_ROLE (
    employee_ssn VARCHAR(50),
    role_id INT,
    PRIMARY KEY (employee_ssn, role_id),
    FOREIGN KEY (employee_ssn) REFERENCES EMPLOYEE(SSN) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES EMPLOYEE_ROLE(ID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 13. Table: RENTING */
CREATE TABLE RENTING (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    customer_ssn VARCHAR(50),
    room_id INT,
    employee_ssn VARCHAR(50),
    booking_id INT DEFAULT NULL,
    checkin_date DATE,
    checkout_date DATE,
    FOREIGN KEY (customer_ssn) REFERENCES CUSTOMER(SSN) ON DELETE SET NULL,
    FOREIGN KEY (room_id) REFERENCES HOTELROOM(roomid) ON DELETE SET NULL,
    FOREIGN KEY (employee_ssn) REFERENCES EMPLOYEE(SSN) ON DELETE SET NULL,
    FOREIGN KEY (booking_id) REFERENCES BOOKING(ID) ON DELETE SET NULL,
    CHECK (checkin_date < checkout_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 14. Table: PAYMENT */
CREATE TABLE PAYMENT (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    customer_ssn VARCHAR(50),
    amount DECIMAL(8,2) CHECK (amount > 0),
    payment_date DATE,
    FOREIGN KEY (customer_ssn) REFERENCES CUSTOMER(SSN) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
