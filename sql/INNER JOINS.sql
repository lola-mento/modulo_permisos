//INNER JOINS

SELECT vehiculo.placa, cupo.identificador,destino.destino
FROM vehiculo 
INNER JOIN cupo ON vehiculo.cupo_id = cupo.id
INNER JOIN destino ON destino.id = cupo.destino_id
WHERE destino.destino = "COOTRANESA"

//MUESTRA LOS VEHICULOS DE NOMINA DE CADA CONDUCTOR

SELECT conductor.nombre, vehiculo.placa,cupo.identificador
FROM conductor
INNER JOIN conductorVehiculo ON conductor.id = conductorVehiculo.conductor_id
INNER JOIN vehiculo ON vehiculo.id = conductorVehiculo.vehiculo_id
INNER JOIN cupo ON cupo.id = vehiculo.cupo_id

//MUESTRA LOS VEHICULOS DE CADA PROPIETARIO

SELECT propietario.nombre, propietario.apellido, vehiculo.placa,cupo.identificador
FROM propietario
INNER JOIN cupopropietario ON propietario.id = cupopropietario.propietario_id
INNER JOIN cupo ON cupo.id = cupopropietario.cupo_id
INNER JOIN vehiculo ON vehiculo.cupo_id = cupo.id
INNER JOIN vehiculo ON vehiculo.cupo_id = cupo.id