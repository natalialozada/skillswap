CREATE DATABASE IF NOT EXISTS skillswap_db;
USE skillswap_db;


/*Tabla de usuarios*/

CREATE TABLE usuarios(
    id_usu INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contra VARCHAR(255) NOT NULL,
    bio TEXT,
    tel VARCHAR(20),
    fecha_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*Tabla de habilidades que el usuario sabe*/
CREATE TABLE habilidades (
    id_hab INT AUTO_INCREMENT PRIMARY KEY,
    id_usu INT NOT NULL,
    habilidad VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_usu) REFERENCES usuarios(id_usu) ON DELETE CASCADE
);

/*Tabla de habilidades que el usuario quiere aprender*/
CREATE TABLE intereses (
    id_inte INT AUTO_INCREMENT PRIMARY KEY,
    id_usu INT NOT NULL,
    interes VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_usu) REFERENCES usuarios(id_usu) ON DELETE CASCADE
);

/*Tabla de mensajes entre usuarios*/
CREATE TABLE mensajes (
    id_msj INT AUTO_INCREMENT PRIMARY KEY,
    usu_envia INT NOT NULL,
    usu_recibe INT NOT NULL,
    mensaje TEXT NOT NULL,
    estado ENUM('pendiente', 'aceptado', 'rechazado') DEFAULT 'pendiente',
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usu_envia) REFERENCES usuarios(id_usu) ON DELETE CASCADE,
    FOREIGN KEY (usu_recibe) REFERENCES usuarios(id_usu) ON DELETE CASCADE
);
