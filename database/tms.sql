CREATE DATABASE IF NOT EXISTS tenantManagementSystem;
USE tenantManagementSystem;
CREATE DATABASE IF NOT EXISTS tenant_management_system;
USE tenant_management_system;

DROP TABLE IF EXISTS apartment;
DROP TABLE IF EXISTS tenant;
DROP TABLE IF EXISTS lease;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS fees;
DROP TABLE IF EXISTS invoice;
DROP TABLE IF EXISTS bill;
DROP TABLE IF EXISTS transactionLog;
DROP TABLE IF EXISTS maintenanceStaff;
DROP TABLE IF EXISTS maintenanceRequest;
DROP TABLE IF EXISTS maintenanceTask;
DROP TABLE IF EXISTS maintenanceStaff;
DROP TABLE IF EXISTS maintenanceAssignment;
DROP TABLE IF EXISTS maintenanceRequest;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS bill;
DROP TABLE IF EXISTS invoice;
DROP TABLE IF EXISTS fees;
DROP TABLE IF EXISTS lease;
DROP TABLE IF EXISTS tenant;
DROP TABLE IF EXISTS apartment;

-- Create tables in order to handle foreign key dependencies correctly
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
    deposit decimal(10,2) DEFAULT NULL
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
CREATE TABLE maintenanceStaff (
    staff_ID int AUTO_INCREMENT PRIMARY KEY,
    staffFirstName varchar(255) NOT NULL,
    staffLastName varchar(255) NOT NULL,
    staffPhoneNumber varchar(15) NOT NULL,
    staffEmailAddress varchar(255) NOT NULL,
    availabilityStatus enum('available', 'unavailable') DEFAULT 'available',
    jobTitle varchar(255) NOT NULL
);
CREATE TABLE maintenanceRequest (
    request_ID int AUTO_INCREMENT PRIMARY KEY,
    tenant_ID int,
    requestDate date NOT NULL,
    requestDescription text NOT NULL,
    requestStatus enum('resolved', 'unresolved') DEFAULT 'unresolved',
    resolutionDate date DEFAULT NULL,
    FOREIGN KEY (tenant_ID) REFERENCES tenant (tenant_ID)
);
CREATE TABLE maintenanceTask (
    task_ID int AUTO_INCREMENT PRIMARY KEY,
    request_ID int,
    staff_ID int,
    taskDescription text NOT NULL,
    startDate date NOT NULL,
    taskStatus enum('resolved', 'unresolved') DEFAULT 'unresolved',
    endDate date DEFAULT NULL,
    FOREIGN KEY (request_ID) REFERENCES maintenanceRequest (request_ID),
    FOREIGN KEY (staff_ID) REFERENCES maintenanceStaff (staff_ID)
);
CREATE TABLE maintenanceAssignment (
    assignment_ID int AUTO_INCREMENT PRIMARY KEY,
    request_ID int,
    user_ID int,
    FOREIGN KEY (request_ID) REFERENCES maintenanceRequest (request_ID),
    FOREIGN KEY (user_ID) REFERENCES user (user_ID)
);
-- Insert dummy data
INSERT INTO apartment (apartmentSize, apartmentPrice, apartmentStatus, maxOccupants) VALUES 
('Studio', 1200.00, 'available', 2),
('1 Bedroom', 1500.00, 'unavailable', 3),
('2 Bedroom', 2000.00, 'available', 4),
('3 Bedroom', 2500.00, 'available', 5),
('1 Bedroom', 1600.00, 'available', 3),
('2 Bedroom', 2100.00, 'unavailable', 4),
('Penthouse', 5000.00, 'available', 6);