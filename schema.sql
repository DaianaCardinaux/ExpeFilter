-- =============================
-- BORRAR TABLAS EXISTENTES
-- =============================
DROP TABLE IF EXISTS expedientes;
DROP TABLE IF EXISTS tipos_expediente;
DROP TABLE IF EXISTS estados;
DROP TABLE IF EXISTS sectores;
DROP TABLE IF EXISTS usuarios;

-- =============================
-- TABLAS
-- =============================
CREATE TABLE usuarios(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  rol ENUM('admin','usuario') NOT NULL DEFAULT 'usuario',
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sectores(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE
);

CREATE TABLE estados(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE
);

CREATE TABLE tipos_expediente(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE
);

CREATE TABLE expedientes(
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero INT NOT NULL,
  anio INT NOT NULL,
  asunto VARCHAR(200) NOT NULL,
  sector_id INT,
  estado_id INT,
  tipo_id INT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_num_anio(numero, anio),
  INDEX idx_sector(sector_id),
  INDEX idx_estado(estado_id),
  INDEX idx_tipo(tipo_id),
  FOREIGN KEY (sector_id) REFERENCES sectores(id),
  FOREIGN KEY (estado_id) REFERENCES estados(id),
  FOREIGN KEY (tipo_id) REFERENCES tipos_expediente(id)
);

-- =============================
-- USUARIOS (los mismos que tenías)
-- =============================
INSERT INTO usuarios (nombre,email,password_hash,rol,activo) VALUES
('Admin','admin@demo.local','$2b$10$GcXDsBSojezNJFuPrIsWzeO/.DO5qBWL6gEbxT3LENFlx2QN880NG','admin',1),
('Usuario Demo','usuario@demo.local','$2b$10$rbLxeqqDELpCG/gUs873zO0FXI9LIpDZjP0LIIHURVa.lW7Dr.62.','usuario',1);

-- =============================
-- DATOS DE REFERENCIA
-- =============================
INSERT INTO sectores (nombre) VALUES 
('Mesa de Entradas'),
('Comercio'),
('Obras Públicas'),
('Legales'),
('Hacienda');

INSERT INTO estados (nombre) VALUES 
('En trámite'),
('Finalizado'),
('Pendiente'),
('Archivado');

INSERT INTO tipos_expediente (nombre) VALUES 
('Licencia'),
('Reclamo'),
('Obra'),
('Permiso'),
('Otro');

-- =============================
-- EXPEDIENTES REALISTAS
-- =============================
INSERT INTO expedientes (numero, anio, asunto, sector_id, estado_id, tipo_id) VALUES
(63001, 2025, 'Solicitud de licencia por maternidad - María Pérez', 1, 1, 1),
(63002, 2025, 'Reclamo por facturación errónea de tasas municipales', 2, 3, 2),
(63003, 2025, 'Pedido de habilitación comercial - Almacén Don José', 2, 1, 4),
(63004, 2024, 'Solicitud de obra de pavimentación en calle Mitre', 3, 1, 3),
(63005, 2024, 'Pedido de inspección por construcción irregular', 3, 2, 3),
(63006, 2023, 'Trámite de permiso para evento público en Plaza Central', 4, 4, 4),
(63007, 2023, 'Reclamo por ruidos molestos de local nocturno', 4, 1, 2),
(63008, 2022, 'Expediente contable: cierre anual 2022', 5, 2, 5),
(63009, 2022, 'Solicitud de renovación de licencia de conducir', 1, 1, 1),
(63010, 2025, 'Gestión de pago atrasado a proveedor municipal', 5, 1, 5),
(63011, 2024, 'Pedido de actualización catastral de terreno', 3, 3, 3),
(63012, 2025, 'Licencia médica prolongada - empleado municipal', 1, 1, 1),
(63013, 2024, 'Solicitud de autorización para feria artesanal', 2, 2, 4),
(63014, 2023, 'Revisión de contrato con empresa constructora', 4, 1, 5),
(63015, 2025, 'Reclamo por corte de suministro eléctrico en zona centro', 2, 1, 2);
