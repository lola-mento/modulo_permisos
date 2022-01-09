CREATE TABLE sistemaOp
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sistema VARCHAR(30) NOT NULL,
    arquitectura VARCHAR(30) NOT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
CREATE TABLE equipo
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30) NOT NULL,
    tipo VARCHAR(30) NOT NULL,
    marca VARCHAR(30) NOT NULL,
    referencia VARCHAR(30) NOT NULL,
    serialx VARCHAR(30) NOT NULL,
    procesador VARCHAR(30) NOT NULL,
    ram VARCHAR(30) NOT NULL,
    discoDuro VARCHAR(30) NOT NULL,
    dominio VARCHAR(30) NOT NULL,
    antivirus VARCHAR(30) NOT NULL,
    observaciones VARCHAR(30) NOT NULL,
    sistema_id INT NOT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (sistema_id) REFERENCES sistemaOp(id)
);
CREATE TABLE asignacion
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    empleado_id INT NOT NULL,
    area_id INT NOT NULL,
    sede_id INT NOT NULL,
    fecha DATE,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (empleado_id) REFERENCES empleado(id),
    FOREIGN KEY (area_id) REFERENCES area(id),
    FOREIGN KEY (sede_id) REFERENCES sede(id)
);
CREATE TABLE detalleAsignacion
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    asignacion_id INT NOT NULL,
    equipo_id INT NOT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (asignacion_id) REFERENCES asignacion(id),
    FOREIGN KEY (equipo_id) REFERENCES equipo(id)
);
