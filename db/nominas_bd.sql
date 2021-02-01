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
    fecha_crea DATETIME,
    fecha_modifica DATETIME,
    PRIMARY KEY(id_rol)
);  

CREATE TABLE usuarios(
    id_usuario INT(11) auto_increment,
    nombre  varchar(50),
    apellido  varchar(50),
    id_rol int(11),
    usuario  varchar(50),
    email  varchar(100),
    password text,
    estado boolean,
    fecha_crea DATETIME,
    fecha_modifica DATETIME,
    PRIMARY KEY(id_usuario)
);

ALTER TABLE usuarios ADD CONSTRAINT fk_usuario FOREIGN KEY id_rol REFERENCES roles(id_rol);