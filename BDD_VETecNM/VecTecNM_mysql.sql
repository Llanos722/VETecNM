-- ==========================================
-- BASE DE DATOS: vetecnm (Para MySQL / Laragon)
-- SCRIPT COMPLETO DE TABLAS Y DATOS (DDL + DML)
-- Host: 127.0.0.1 | Puerto: 3306
-- ==========================================

CREATE DATABASE IF NOT EXISTS `vetecnm` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `vetecnm`;

SET FOREIGN_KEY_CHECKS = 0;

-- Borrar tablas de la aplicación si existen
DROP TABLE IF EXISTS citas;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS mascotas;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS sessions;

-- 1. TABLA DE USUARIOS (Maneja Clientes y Administradores)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) CHECK (rol IN ('cliente', 'admin')) DEFAULT 'cliente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. TABLA DE MASCOTAS (Un usuario puede tener muchas mascotas)
CREATE TABLE mascotas (
    id_mascota INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raza VARCHAR(50),
    peso DECIMAL(5,2),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TABLA DE CATEGORÍAS (Para organizar el catálogo)
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. TABLA DE PRODUCTOS (Pertenece a una categoría)
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    imagen_url VARCHAR(255),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. TABLA DE CITAS (Vinculada a una mascota específica)
CREATE TABLE citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_mascota INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    estado VARCHAR(20) CHECK (estado IN ('Pendiente', 'Confirmada', 'Finalizada', 'Cancelada')) DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_mascota) REFERENCES mascotas(id_mascota) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. TABLA DE SESIONES (Requerida por Laravel para SESSION_DRIVER=database)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================
-- INSERTAR DATOS DE PRUEBA
-- ==========================================

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador Vet', 'admin@vetecnm.com', 'admin123', 'admin'),
('Carlos Mendoza', 'carlos.m@correo.com', 'cliente123', 'cliente');

INSERT INTO mascotas (id_usuario, nombre, especie, raza, peso) VALUES
(2, 'Max', 'Perro', 'Golden Retriever', 25.50),
(2, 'Luna', 'Gato', 'Siamés', 4.20);

INSERT INTO categorias (nombre, descripcion) VALUES
('Alimentos', 'Croquetas, alimento húmedo y premios'),
('Accesorios', 'Correas, collares, camas y juguetes'),
('Higiene', 'Champús, cepillos y productos de limpieza');

INSERT INTO productos (id_categoria, nombre, descripcion, precio, stock) VALUES
(1, 'Croquetas Dog Chow 10kg', 'Alimento completo para perro adulto', 550.00, 15),
(1, 'Whiskas Pescado 1.5kg', 'Alimento seco para gato adulto', 120.00, 20),
(2, 'Correa reforzada 2m', 'Correa de nylon de alta resistencia', 150.00, 10),
(3, 'Champú antipulgas', 'Champú para perros y gatos 500ml', 90.00, 25);

INSERT INTO citas (id_mascota, fecha, hora, motivo, estado) VALUES
(1, '2026-10-15', '10:00:00', 'Vacunación anual y desparasitación', 'Confirmada'),
(2, '2026-10-18', '16:30:00', 'Revisión general por malestar estomacal', 'Pendiente');

SET FOREIGN_KEY_CHECKS = 1;
