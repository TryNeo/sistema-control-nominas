DROP DATABASE  IF EXISTS nominas_bd;
CREATE DATABASE IF NOT EXISTS nominas_bd;
USE nominas_bd;
DROP TABLE IF EXISTS empleados;


CREATE TABLE contractos(
id_contracto int(11) auto_increment,
nombre_contracto varchar(50),
descripcion varchar(120),
estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
PRIMARY KEY (id_contracto));


CREATE TABLE empleados(
id_empleado int(11) auto_increment,
nombre varchar(50),
apellido varchar(50),
cedula varchar(10),
email varchar(100),
id_contracto int(11),
telefono varchar(10),
estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
PRIMARY KEY (id_empleado));

DROP TABLE IF EXISTS roles;
CREATE TABLE roles(
    id_rol int(11) auto_increment,
    nombre_rol varchar(50),
    descripcion varchar(120),
    estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_rol)
);  
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios(
    id_usuario INT(11) auto_increment,
    nombre  varchar(50),
    apellido  varchar(50),
    foto varchar(1000),
    usuario  varchar(50),
    email  varchar(100),
    id_rol int(11),
    password text,
    estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_usuario)
);
DROP TABLE IF EXISTS modulos;
CREATE TABLE modulos(
    id_modulo INT(11) auto_increment,
    nombre varchar(50),
    descripcion text,
    estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
    PRIMARY KEY(id_modulo)
);
DROP TABLE IF EXISTS permisos;
CREATE TABLE permisos(
    id_permiso int(11)  auto_increment,
    id_modulo int(11),
    id_rol  int(11),
    r int(11),
    w int(11),
    u int(11),
    d int(11),
    PRIMARY KEY(id_permiso)
);



ALTER TABLE empleados ADD CONSTRAINT fk_contracto FOREIGN KEY (id_contracto) REFERENCES contractos(id_contracto);
ALTER TABLE usuarios ADD CONSTRAINT fk_usuario FOREIGN KEY (id_rol)  REFERENCES roles(id_rol);
ALTER TABLE permisos ADD CONSTRAINT fk_modulo FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo);
ALTER TABLE permisos ADD CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol);


INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Dashboard','modulo de dashboard',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Usuarios','modulo de usuarios',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Roles','modulo de roles',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Respaldo','modulo de respaldo',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Empleados','modulo de empleados',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Contractos','modulo de contractos',1,now());

INSERT INTO roles (nombre_rol,descripcion,estado,fecha_crea) values ("Administrador","permisos de acceso a todo el sistema",1,now());

INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (1,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (2,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (3,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (4,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (5,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (6,1,1,1,1,1);

INSERT INTO usuarios (nombre,apellido,foto,usuario,email,id_rol,password,estado,fecha_crea) VALUES ("joel josue","huacon lopez","user-default.png","josu3","jjhuacon@est.itsgg.edu.ec",1,sha2("josue",256),1,now())