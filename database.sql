CREATE DATABASE IF NOT EXISTS dental_db;

USE dental_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price INT
);

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    date DATE,
    time TIME
);

INSERT INTO services (name, description, price) VALUES
('Fogtömés', 'Fog javítása', 10000),
('Fogkő eltávolítás', 'Tisztítás', 8000),
('Gyökérkezelés', 'Fájdalmas fog kezelése', 20000);