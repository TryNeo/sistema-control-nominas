DROP DATABASE  IF EXISTS nominas_bd;
CREATE DATABASE IF NOT EXISTS nominas_bd;
USE nominas_bd;

DROP TABLE IF EXISTS contratos;
CREATE TABLE contratos(
id_contrato int(11) auto_increment,
nombre_contrato varchar(50),
descripcion text,
estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
PRIMARY KEY (id_contrato));

DROP TABLE IF EXISTS puestos;
CREATE TABLE puestos(
id_puesto int(11) auto_increment,
nombre_puesto varchar(50),
descripcion text,
estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
PRIMARY KEY (id_puesto));

DROP TABLE IF EXISTS nominas;
CREATE TABLE nominas(
id_nomina int(11) auto_increment,
nombre_nomina varchar(50),
periodo_inicio varchar(50),
periodo_fin varchar(50),
total float DEFAULT 0.00,
estado_nomina int(11),
estado boolean,
fecha_crea DATETIME,
fecha_modifica DATETIME default now(),
PRIMARY KEY (id_nomina));


DROP TABLE IF EXISTS empleados;
CREATE TABLE empleados(
id_empleado int(11) auto_increment,
nombre varchar(50),
apellido varchar(50),
cedula varchar(10),
telefono varchar(14),
sueldo float,
id_puesto int(11),
fecha_crea DATETIME,
id_contrato int(11),
estado boolean,
fecha_modifica DATETIME default now(),
PRIMARY KEY (id_empleado));


DROP TABLE IF EXISTS detalle_nomina;
CREATE TABLE detalle_nomina(
id_detalle_nomina int (11) auto_increment,
id_nomina int(11),
id_empleado int(11),
meses int(11) default 0,
valor_total float DEFAULT 0.00,
PRIMARY KEY (id_detalle_nomina));



DROP TABLE IF EXISTS roles;
CREATE TABLE roles(
    id_rol int(11) auto_increment,
    nombre_rol varchar(50),
    descripcion text,
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



ALTER TABLE empleados ADD CONSTRAINT fk_contrato FOREIGN KEY (id_contrato) REFERENCES contratos(id_contrato);
ALTER TABLE empleados ADD CONSTRAINT fk_puesto FOREIGN KEY (id_puesto) REFERENCES puestos(id_puesto);
ALTER TABLE usuarios ADD CONSTRAINT fk_roles FOREIGN KEY (id_rol)  REFERENCES roles(id_rol);
ALTER TABLE permisos ADD CONSTRAINT fk_modulo FOREIGN KEY (id_modulo) REFERENCES modulos(id_modulo);
ALTER TABLE permisos ADD CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol);
ALTER TABLE detalle_nomina ADD CONSTRAINT fk_detalle_nomina FOREIGN KEY (id_nomina) REFERENCES nominas(id_nomina);
ALTER TABLE detalle_nomina ADD CONSTRAINT fk_detalle_empleado FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado);

INSERT INTO contratos (nombre_contrato,descripcion,estado,fecha_crea) values('Contrato indefinido','Es todo contrato que concierta la prestación de servicios por un tiempo ilimitado.',1,now());
INSERT INTO contratos (nombre_contrato,descripcion,estado,fecha_crea) values('Contrato indefinido de fijos-discontinuos','Es el que se realiza para trabajos que son fijos
pero no se repiten en determinadas fechas, produciendo discontinuidad en el tiempo.',1,now());
INSERT INTO contratos (nombre_contrato,descripcion,estado,fecha_crea) values('Contratos en prácticas','Sirven para facilitar las prácticas profesionales 
a los trabajadores con título universitario o formación profesional,',1,now());

INSERT INTO contratos (nombre_contrato,descripcion,estado,fecha_crea) values('Contrato Para La Formación','Este contrato tiene como finalidad la adquisición de formación teórico-práctica 
necesaria para la realización adecuada de un trabajo que requiera algún tipo de cualificación o acreditación.,',1,now());


INSERT INTO contratos (nombre_contrato,descripcion,estado,fecha_crea) values('Contrato De Obra O Servicio Determinado','Es aquel que se firma para la realización de
una obra o servicio, con autonomía y cuya duración sea incierta.,',1,now());


INSERT INTO contratos (nombre_contrato,descripcion,estado,fecha_crea) values('Contratos De Inserción','Para participar en programas públicos de realización de obras y servicios de interés general y social. El objetivo que se persigue es por un lado,
la adquisición de experiencia laboral, y por otro, facilitar la mejora de la ocupación al desempleado.',1,now());

INSERT INTO puestos(nombre_puesto,descripcion,estado,fecha_crea) values("Gerente general","dueño",1,now());

INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Dashboard','modulo de dashboard',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Usuarios','modulo de usuarios',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Roles','modulo de roles',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Respaldo','modulo de respaldo',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Empleados','modulo de empleados',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Contractos','modulo de contractos',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Puestos','modulo de puestos',1,now());
INSERT INTO modulos (nombre,descripcion,estado,fecha_crea) values('Nominas','modulo de nominas',1,now());

INSERT INTO roles (nombre_rol,descripcion,estado,fecha_crea) values ("Administrador","permisos de acceso a todo el sistema",1,now());

INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (1,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (2,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (3,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (4,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (5,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (6,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (7,1,1,1,1,1);
INSERT INTO permisos (id_modulo,id_rol,r,w,u,d) VALUES (8,1,1,1,1,1);


INSERT INTO usuarios (nombre,apellido,foto,usuario,email,id_rol,password,estado,fecha_crea) VALUES ("joel josue","huacon lopez","user-default.png","josu3","jjhuacon@est.itsgg.edu.ec",1,"$2y$10$nLtnKbUrAQnMMfWi9bqsEuQ53U5k1pKCRsKYWEw0x/R5hgKNcHiYK",1,now())