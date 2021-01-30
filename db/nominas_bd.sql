DROP DATABASE  IF EXISTS nominas_bd;
CREATE DATABASE IF NOT EXISTS nominas_bd;
USE nominas_bd;

CREATE TABLE empleados(
id_empleado int(11) auto_increment,
nombre varchar(50),
apellido varchar(50),
cedula varchar(10),
telefono varchar(10),

estado boolean,
fecha_crea date,
fecha_modifacion date,
PRIMARY KEY (id_empleado));


CREATE TABLE roles(
    id_rol int(11) auto_increment,
    nombre varchar(50),
    descripcion varchar(50),
    estado boolean,
    fecha_crea date,
    fecha_modifacion date,
    PRIMARY KEY(id_rol))
);