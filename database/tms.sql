-- Final database
CREATE DATABASE IF NOT EXISTS tms;
USE tms;

DROP TABLE IF EXISTS apartment;
DROP TABLE IF EXISTS tenant;
DROP TABLE IF EXISTS lease;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS fees;
DROP TABLE IF EXISTS invoice;
DROP TABLE IF EXISTS bill;

CREATE TABLE apartment (
    apartmentNumber int AUTO_INCREMENT PRIMARY KEY,
    apartmentSize varchar(50) NOT NULL,
    apartmentPrice decimal(10,2) NOT NULL,
    apartmentStatus enum('available', 'unavailable') DEFAULT 'available',
    maxOccupants int
);
CREATE TABLE tenant (
    tenant_ID int AUTO_INCREMENT PRIMARY KEY,
    firstName varchar(255) NOT NULL,
    lastName varchar(255) NOT NULL,
    middleName varchar(255) DEFAULT NULL,
    dateOfBirth date NOT NULL,
    phoneNumber varchar(15) NOT NULL,
    emailAddress varchar(50) NOT NULL,
    deposit decimal(10,2) DEFAULT 0
);
CREATE TABLE lease (
    lease_ID int AUTO_INCREMENT PRIMARY KEY,
    tenant_ID int,
    apartmentNumber int,
    startDate date NOT NULL,
    endDate date NOT NULL,
    billingPeriod varchar(50) NOT NULL,
    leaseStatus enum('approved', 'declined', 'pending') DEFAULT 'pending',
    FOREIGN KEY (tenant_ID) REFERENCES tenant (tenant_ID),
    FOREIGN KEY (apartmentNumber) REFERENCES apartment (apartmentNumber)
);
CREATE TABLE user (
    user_ID int AUTO_INCREMENT PRIMARY KEY,
    tenant_ID int DEFAULT NULL,
    username varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    userRole enum('Admin', 'Manager', 'Tenant') NOT NULL,
    FOREIGN KEY (tenant_ID) REFERENCES tenant (tenant_ID)
);
CREATE TABLE fees (
    fee_ID int AUTO_INCREMENT PRIMARY KEY,
    lease_ID int,
    rent decimal(10,2) NOT NULL,
    tax decimal(10,2) NOT NULL,
    maintenance decimal(10,2) NOT NULL,
    totalAmount decimal(10,2) NOT NULL,
    FOREIGN KEY (lease_ID) REFERENCES lease (lease_ID)
);
CREATE TABLE invoice (
    invoice_ID int AUTO_INCREMENT PRIMARY KEY,
    fee_ID int,
    dueDate date NOT NULL,
    FOREIGN KEY (fee_ID) REFERENCES fees (fee_ID)
);
CREATE TABLE bill (
    bill_ID int AUTO_INCREMENT PRIMARY KEY,
    invoice_ID int,
    paymentMethod varchar(50) NOT NULL,
    amountPaid decimal(10,2) NOT NULL,
    overpayment decimal(10,2) DEFAULT 0.00,
    paymentDate date NOT NULL,
    FOREIGN KEY (invoice_ID) REFERENCES invoice (invoice_ID)
);
CREATE TABLE transactionLog (
    transaction_ID int AUTO_INCREMENT PRIMARY KEY,
    bill_ID int,
    user_ID int,
    receivedBy int,
    transactionStatus enum('received', 'pending') DEFAULT 'pending',
    FOREIGN KEY (bill_ID) REFERENCES bill (bill_ID),
    FOREIGN KEY (user_ID) REFERENCES user (user_ID),
    FOREIGN KEY (receivedBy) REFERENCES user (user_ID)
);

-- Add apartment data
INSERT INTO apartment (apartmentSize, apartmentPrice, apartmentStatus, maxOccupants) VALUES 
('Studio', 1200.00, 'unavailable', 2),
('1 Bedroom', 1500.00, 'unavailable', 3),
('2 Bedroom', 2000.00, 'available', 4),
('3 Bedroom', 2500.00, 'available', 5),
('1 Bedroom', 1600.00, 'available', 3),
('2 Bedroom', 2100.00, 'available', 4),
('Penthouse', 5000.00, 'available', 6);

-- Add tenant information
INSERT INTO tenant (firstName, lastName, middleName, dateOfBirth, phoneNumber, emailAddress) VALUES
('John', 'Doe', 'Alpha', '1990-01-01', '1234567890', 'john.doe@example.com'),
('Jane', 'Smith', 'Beta', '1985-05-15', '0987654321', 'jane.smith@example.com'),
('Michael', 'Johnson', 'Charlie', '1975-09-30', '5678901234', 'michael.johnson@example.com'),
('Emily', 'Davis', 'Delta', '2000-12-20', '2345678901', 'emily.davis@example.com'),
('Robert', 'Brown', 'Echo', '1995-07-10', '3456789012', 'robert.brown@example.com');

-- Add admin and manager accounts
INSERT INTO user (tenant_ID, username, password, userRole) VALUES
(NULL, 'admin', 'adminpassword', 'Admin'),
(NULL, 'manager1', 'manager1password', 'Manager'),
(NULL, 'manager2', 'manager2password', 'Manager'),
(NULL, 'manager3', 'manager3password', 'Manager');

-- Add tenant accounts
INSERT INTO user (tenant_ID, username, password, userRole) VALUES
(1, 'john.doe.1', 'password', 'Tenant'),
(2, 'jane.smith.2', 'password', 'Tenant'),
(3, 'michael.johnson.3', 'password', 'Tenant'),
(4, 'emily.davis.4', 'password', 'Tenant'),
(5, 'robert.brown.5', 'password', 'Tenant');

-- Add lease
INSERT INTO lease (tenant_ID, apartmentNumber, startDate, endDate, billingPeriod, leaseStatus) VALUES
(1, 1, '2024-01-01', '2025-01-01', 'monthly', 'approved'),
(2, 1, '2024-01-01', '2025-01-01', 'monthly', 'approved'),
(3, 2, '2024-01-01', '2024-07-01', 'weekly', 'approved'),
(4, 2, '2024-01-01', '2024-07-01', 'weekly', 'approved'),
(5, 2, '2024-01-01', '2024-07-01', 'weekly', 'approved');
