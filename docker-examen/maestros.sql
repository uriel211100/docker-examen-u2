-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS maestros;
USE maestros;

-- Crear tabla maestros
CREATE TABLE IF NOT EXISTS maestros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Insertar datos de ejemplo en la tabla maestros
INSERT INTO maestros (nombre) VALUES 
('Profesor Juan Ruiz'), ('Maestra Marta Ortega'), ('Profesor David Silva'), ('Maestra Elena Morales'), ('Profesor Alejandro Herrera');
