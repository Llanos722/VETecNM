-- ==========================================
-- BASE DE DATOS: VETecNM
-- SCRIPT DE DATOS INICIALES (SEEDS)
-- ==========================================

-- 1. Insertar Usuarios (1 Admin, 1 Cliente)
-- Nota: Las contraseñas en un entorno real irían encriptadas (ej. con bcrypt)
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador Vet', 'admin@vetecnm.com', 'admin123', 'admin'),
('Carlos Mendoza', 'carlos.m@correo.com', 'cliente123', 'cliente');

-- 2. Insertar Mascotas (Asociadas al cliente Carlos, cuyo id_usuario es 2)
INSERT INTO mascotas (id_usuario, nombre, especie, raza, peso) VALUES
(2, 'Max', 'Perro', 'Golden Retriever', 25.50),
(2, 'Luna', 'Gato', 'Siamés', 4.20);

-- 3. Insertar Categorías para la Tienda
INSERT INTO categorias (nombre, descripcion) VALUES
('Alimentos', 'Croquetas, alimento húmedo y premios'),
('Accesorios', 'Correas, collares, camas y juguetes'),
('Higiene', 'Champús, cepillos y productos de limpieza');

-- 4. Insertar Productos en el Catálogo
INSERT INTO productos (id_categoria, nombre, descripcion, precio, stock) VALUES
(1, 'Croquetas Dog Chow 10kg', 'Alimento completo para perro adulto', 550.00, 15),
(1, 'Whiskas Pescado 1.5kg', 'Alimento seco para gato adulto', 120.00, 20),
(2, 'Correa reforzada 2m', 'Correa de nylon de alta resistencia', 150.00, 10),
(3, 'Champú antipulgas', 'Champú para perros y gatos 500ml', 90.00, 25);

-- 5. Insertar Citas de Prueba
INSERT INTO citas (id_mascota, fecha, hora, motivo, estado) VALUES
(1, '2026-10-15', '10:00:00', 'Vacunación anual y desparasitación', 'Confirmada'),
(2, '2026-10-18', '16:30:00', 'Revisión general por malestar estomacal', 'Pendiente');