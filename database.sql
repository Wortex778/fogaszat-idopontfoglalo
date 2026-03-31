CREATE DATABASE dental_db;

USE dental_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price INT
);

INSERT INTO services (name, description, price) VALUES
('Fogtömés', 'Fog javítása', 10000),
('Fogkő eltávolítás', 'Tisztítás', 8000),
('Gyökérkezelés', 'Fájdalmas fog kezelése', 20000);