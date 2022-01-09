CREATE TABLE cargo
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cargo VARCHAR(30),
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
CREATE TABLE area
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    area VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
CREATE TABLE empleado
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    salario DOUBLE(10,1) NOT NULL,
    fechaingreso DATE NOT NULL,
    lider VARCHAR(2) NOT NULL,
    area_id INT NOT NULL,
    cargo_id INT NOT NULL,
    persona_id INT NOT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    FOREIGN KEY (area_id) REFERENCES area(id),
    FOREIGN KEY (cargo_id) REFERENCES cargo(id),
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

