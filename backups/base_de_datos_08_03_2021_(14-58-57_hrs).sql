SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE  IF EXISTS nominas_bd;
CREATE DATABASE IF NOT EXISTS nominas_bd;

USE nominas_bd;



CREATE TABLE `contractos` (
  `id_contracto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_contracto` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_contracto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO contractos VALUES("1","Contrato indefinido","Es todo contrato que concierta la prestación de servicios por un tiempo ilimitado.","1","2021-03-08 14:56:18","2021-03-08 14:56:18");
INSERT INTO contractos VALUES("2","Contrato indefinido de fijos-discontinuos","Es el que se realiza para trabajos que son fijos\npero no se repiten en determinadas fechas, produciendo discontinuidad en el tiempo.","1","2021-03-08 14:56:18","2021-03-08 14:56:18");
INSERT INTO contractos VALUES("3","Contratos en prácticas","Sirven para facilitar las prácticas profesionales \na los trabajadores con título universitario o formación profesional,","1","2021-03-08 14:56:18","2021-03-08 14:56:18");
INSERT INTO contractos VALUES("4","Contrato Para La Formación","Este contrato tiene como finalidad la adquisición de formación teórico-práctica \nnecesaria para la realización adecuada de un trabajo que requiera algún tipo de cualificación o acreditación.,","1","2021-03-08 14:56:18","2021-03-08 14:56:18");
INSERT INTO contractos VALUES("5","Contrato De Obra O Servicio Determinado","Es aquel que se firma para la realización de\nuna obra o servicio, con autonomía y cuya duración sea incierta.,","1","2021-03-08 14:56:18","2021-03-08 14:56:18");
INSERT INTO contractos VALUES("6","Contratos De Inserción","Para participar en programas públicos de realización de obras y servicios de interés general y social. El objetivo que se persigue es por un lado,\nla adquisición de experiencia laboral, y por otro, facilitar la mejora de la ocupación al desempleado.","1","2021-03-08 14:56:18","2021-03-08 14:56:18");





CREATE TABLE `detalle_nomina` (
  `id_detalle_nomina` int(11) NOT NULL,
  `id_nomina` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_nomina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `telefono` varchar(14) DEFAULT NULL,
  `sueldo` float DEFAULT NULL,
  `id_puesto` int(11) DEFAULT NULL,
  `id_contracto` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_empleado`),
  KEY `fk_contracto` (`id_contracto`),
  KEY `fk_puesto` (`id_puesto`),
  CONSTRAINT `fk_contracto` FOREIGN KEY (`id_contracto`) REFERENCES `contractos` (`id_contracto`),
  CONSTRAINT `fk_puesto` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id_puesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO modulos VALUES("1","Dashboard","modulo de dashboard","1","2021-03-08 14:56:18","2021-03-08 14:56:18");
INSERT INTO modulos VALUES("2","Usuarios","modulo de usuarios","1","2021-03-08 14:56:19","2021-03-08 14:56:19");
INSERT INTO modulos VALUES("3","Roles","modulo de roles","1","2021-03-08 14:56:19","2021-03-08 14:56:19");
INSERT INTO modulos VALUES("4","Respaldo","modulo de respaldo","1","2021-03-08 14:56:19","2021-03-08 14:56:19");
INSERT INTO modulos VALUES("5","Empleados","modulo de empleados","1","2021-03-08 14:56:19","2021-03-08 14:56:19");
INSERT INTO modulos VALUES("6","Contractos","modulo de contractos","1","2021-03-08 14:56:19","2021-03-08 14:56:19");
INSERT INTO modulos VALUES("7","Puestos","modulo de contractos","1","2021-03-08 14:56:19","2021-03-08 14:56:19");





CREATE TABLE `nominas` (
  `id_nomina` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_nomina` varchar(50) DEFAULT NULL,
  `periodo_inicio` date DEFAULT NULL,
  `periodo_fin` date DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `forma_pago` varchar(50) DEFAULT NULL,
  `estado_nominado` varchar(20) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_nomina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulo` int(11) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `r` int(11) DEFAULT NULL,
  `w` int(11) DEFAULT NULL,
  `u` int(11) DEFAULT NULL,
  `d` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `fk_modulo` (`id_modulo`),
  KEY `fk_rol` (`id_rol`),
  CONSTRAINT `fk_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`),
  CONSTRAINT `fk_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO permisos VALUES("1","1","1","1","1","1","1");
INSERT INTO permisos VALUES("2","2","1","1","1","1","1");
INSERT INTO permisos VALUES("3","3","1","1","1","1","1");
INSERT INTO permisos VALUES("4","4","1","1","1","1","1");
INSERT INTO permisos VALUES("5","5","1","1","1","1","1");
INSERT INTO permisos VALUES("6","6","1","1","1","1","1");
INSERT INTO permisos VALUES("7","7","1","1","1","1","1");





CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_puesto` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_puesto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO puestos VALUES("1","pruebas","pruebaxde","1","2021-03-08 14:58:51","2021-03-08 14:58:51");





CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO roles VALUES("1","Administrador","permisos de acceso a todo el sistema","1","2021-03-08 14:56:19","2021-03-08 14:56:19");





CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `foto` varchar(1000) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_usuario`),
  KEY `fk_roles` (`id_rol`),
  CONSTRAINT `fk_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios VALUES("1","joel josue","huacon lopez","user-default.png","josu3","jjhuacon@est.itsgg.edu.ec","1","$2y$10$nLtnKbUrAQnMMfWi9bqsEuQ53U5k1pKCRsKYWEw0x/R5hgKNcHiYK","1","2021-03-08 14:56:20","2021-03-08 14:56:20");



SET FOREIGN_KEY_CHECKS=1;