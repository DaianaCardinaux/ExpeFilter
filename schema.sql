-- DROP TABLE IF EXISTS usuarios;
-- DROP TABLE IF EXISTS sectores;
-- DROP TABLE IF EXISTS estados;
-- DROP TABLE IF EXISTS tipos_expediente;
-- DROP TABLE IF EXISTS expedientes;

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

INSERT INTO usuarios (nombre,email,password_hash,rol,activo) VALUES
('Admin','admin@demo.local','$2b$10$GcXDsBSojezNJFuPrIsWzeO/.DO5qBWL6gEbxT3LENFlx2QN880NG','admin',1),
('Usuario Demo','usuario@demo.local','$2b$10$rbLxeqqDELpCG/gUs873zO0FXI9LIpDZjP0LIIHURVa.lW7Dr.62.','usuario',1);

INSERT INTO sectores (nombre) VALUES ('Mesa de Entradas'),('Comercio'),('Obras Públicas'),('Legales'),('Hacienda');
INSERT INTO estados (nombre) VALUES ('En trámite'),('Finalizado'),('Pendiente'),('Archivado');
INSERT INTO tipos_expediente (nombre) VALUES ('Licencia'),('Reclamo'),('Obra'),('Permiso'),('Otro');

INSERT INTO expedientes (numero, anio, asunto, sector_id, estado_id, tipo_id)
SELECT FLOOR(RAND()*90000)+10000, 2024, CONCAT('Asunto de prueba ', n),
       1 + (n % 5), 1 + (n % 4), 1 + (n % 5)
FROM (SELECT 0 n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
      UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
      UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14
      UNION ALL SELECT 15 UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19
      UNION ALL SELECT 20 UNION ALL SELECT 21 UNION ALL SELECT 22 UNION ALL SELECT 23 UNION ALL SELECT 24
      UNION ALL SELECT 25 UNION ALL SELECT 26 UNION ALL SELECT 27 UNION ALL SELECT 28 UNION ALL SELECT 29) t;
