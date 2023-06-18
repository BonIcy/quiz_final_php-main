-- SQLBook: Code
CREATE DATABASE alquilartemis;
USE alquilartemis;

CREATE TABLE empleados (
    id_empleado INT(50) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    salario_mensual INT(30) NOT NULL,
    sexo VARCHAR(18) NOT NULL
);

CREATE TABLE constructoras (
    id_constructora INT(50) NOT NULL PRIMARY KEY,
    nombre VARCHAR(35) NOT NULL,
    direccion VARCHAR(40)
);

CREATE TABLE cotizaciones (
    id_cotizacion INT(50) NOT NULL PRIMARY KEY,
    id_empleado INT(50) NOT NULL,
    id_constructora INT(50) NOT NULL,
    fecha DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    FOREIGN KEY (id_constructora) REFERENCES constructoras(id_constructora)
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio_dia DECIMAL(10, 2) NOT NULL,
    imagen BLOB
);

CREATE TABLE detalle_cotizacion (
    id_detalle INT(50) NOT NULL PRIMARY KEY,
    id_cotizacion INT(50) NOT NULL,
    id_producto INT(50) NOT NULL,
    fecha_alquiler DATE NOT NULL,
    duracion_alquiler INT(10) NOT NULL,
    FOREIGN KEY (id_cotizacion) REFERENCES cotizaciones(id_cotizacion),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE salida (
    salida_id INT(50) NOT NULL PRIMARY KEY,
    id_constructora INT(50) NOT NULL,
    fecha_salida DATE,
    hora_salida TIME,
    subtotalPeso DECIMAL(10, 2),
    id_empleado INT(50),
    placatransporte VARCHAR(10),
    observaciones VARCHAR(100),
    FOREIGN KEY (id_constructora) REFERENCES constructoras(id_constructora),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

CREATE TABLE salida_detalle (
    salida_id INT(50) NOT NULL,
    producto_id INT(50) NOT NULL,
    obra_id INT(50),
    cantidad_salida INT(10),
    cantidad_propia INT(10),
    cantidad_subalquilada INT(10),
    valorUnidad DECIMAL(10, 2),
    fecha_standBye DATE,
    estado VARCHAR(20),
    valorTotal DECIMAL(10, 2),
    id_empleado INT(50),
    PRIMARY KEY (salida_id, producto_id),
    FOREIGN KEY (salida_id) REFERENCES salida(salida_id),
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
);

CREATE TABLE entrada (
    salida_id INT(50),
    entrada_id INT(50) NOT NULL,
    id_empleado INT(50) NOT NULL,
    id_constructora INT(50) NOT NULL,
    fecha_entrada DATE,
    hora_entrada TIME,
    observaciones VARCHAR(100),
    PRIMARY KEY (salida_id, entrada_id),
    FOREIGN KEY (salida_id) REFERENCES salida(salida_id),
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado),
    FOREIGN KEY (id_constructora) REFERENCES constructoras(id_constructora)
);

CREATE TABLE entrada_detalle (
    entrada_id INT(50) NOT NULL,
    producto_id INT(50) NOT NULL,
    obra_id INT(50) NOT NULL,
    entrada_cantidad INT(10) NOT NULL,
    entrada_cantidad_propia INT(10) NOT NULL,
    FOREIGN KEY (entrada_id) REFERENCES entrada(salida_id),
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto),
    FOREIGN KEY (obra_id) REFERENCES clientes(id_cliente)
);
