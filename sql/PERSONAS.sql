CREATE TABLE persona
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cedula VARCHAR(30) NOT NULL,
    nombre VARCHAR(30) NOT NULL,
    apellido VARCHAR(30) NOT NULL,
    fijo VARCHAR(30),
    celular VARCHAR(30) NOT NULL,
    direccion VARCHAR(30) NOT NULL,
    municipio VARCHAR(30) NOT NULL,
    barrio VARCHAR(30) NOT NULL,
    fechanac DATE NOT NULL,
    estcivil VARCHAR(30) NOT NULL,
    email VARCHAR(30),
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);