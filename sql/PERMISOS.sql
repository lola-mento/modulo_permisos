//ESTA TABLA DEPENDE DE LA TABLA EMPLEADOS (MODULO SITCO)
CREATE TABLE permiso
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(30),
    fecha DATETIME DEFAULT NULL,
    fechai DATE,
    fechaf DATE,
    estado VARCHAR(10),
    motivo VARCHAR(15),
    dias INT NOT NULL, 
    empleado_id INT NOT NULL,
    observaciones VARCHAR(200),
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (empleado_id) REFERENCES empleado(id)
);