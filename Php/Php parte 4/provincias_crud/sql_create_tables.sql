-- SQL to create the provincias table
CREATE TABLE provincias (
  codProv VARCHAR(20) PRIMARY KEY,
  nombreProv VARCHAR(255) NOT NULL,
  region VARCHAR(100),
  fechaAlta DATE,
  poblacion INT DEFAULT 0,
  documentoPdf LONGBLOB
);
