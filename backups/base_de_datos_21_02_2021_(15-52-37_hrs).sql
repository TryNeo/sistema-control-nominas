SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE  IF EXISTS nominas_bd;
CREATE DATABASE IF NOT EXISTS nominas_bd;

USE nominas_bd;



CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO modulos VALUES("1","Dashboard","modulo de dashboard","1","2021-02-20 14:25:07","2021-02-20 14:25:07");
INSERT INTO modulos VALUES("2","Usuarios","modulo de usuarios","1","2021-02-20 14:25:07","2021-02-20 14:25:07");
INSERT INTO modulos VALUES("3","Roles","modulo de roles","1","2021-02-20 14:25:07","2021-02-20 14:25:07");
INSERT INTO modulos VALUES("4","Respaldo","modulo de respaldo","1","2021-02-20 14:25:08","2021-02-20 14:25:08");





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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO permisos VALUES("1","1","1","1","1","1","1");
INSERT INTO permisos VALUES("2","2","1","1","1","1","1");
INSERT INTO permisos VALUES("3","3","1","1","1","1","1");
INSERT INTO permisos VALUES("4","4","1","1","1","1","1");





CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

INSERT INTO roles VALUES("1","Administradores","permisos de acceso a todo el sistema","1","2021-02-20 14:25:08","2021-02-20 14:27:05");
INSERT INTO roles VALUES("2","qiwdqwduqw","wuidiwueiud","1","2021-02-20 14:25:34","2021-02-20 14:25:34");
INSERT INTO roles VALUES("3","qwdq9w8d9qw8d","9w8eu9d8w9e8de99d8w98ed","1","2021-02-20 14:25:43","2021-02-20 14:25:43");
INSERT INTO roles VALUES("4","89qwqs8w98squws89u","ewe8dwe89dw89eduwe","1","2021-02-20 14:25:51","2021-02-20 14:25:51");
INSERT INTO roles VALUES("5","98qsu9qwsqws","uwe8dwe8dw8edwe","1","2021-02-20 14:25:58","2021-02-20 14:25:58");
INSERT INTO roles VALUES("6","q9w8uq9w8suqw","989d8w9du9w8eduw9e8dw","1","2021-02-20 14:26:07","2021-02-20 14:26:07");
INSERT INTO roles VALUES("7","8qs9ws98q8sq98ws9qws","sq8qwusu9q9w8sq9ws89qw","1","2021-02-20 14:26:17","2021-02-20 14:26:17");
INSERT INTO roles VALUES("8","98qus98qws8qw8suqw89sq","98qwqw8suqw8usq9ws8qw8s8qw8sqw","1","2021-02-20 14:26:28","2021-02-20 14:26:28");
INSERT INTO roles VALUES("9","q98wsq8q9w89898qw9898w9s89ws9q","qs89qw9s8wqs89q98ws9qw9","1","2021-02-20 14:26:37","2021-02-20 14:26:37");
INSERT INTO roles VALUES("10","axasoixaisxasxjoasxoijo","isoioscisoidocosdcsoid","1","2021-02-20 14:26:45","2021-02-20 14:26:45");
INSERT INTO roles VALUES("11","ijcsdijcosoidcoisdioci","iojdsjicijsdicoisdcsdicioo","1","2021-02-20 14:26:55","2021-02-20 14:26:55");





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
  KEY `fk_usuario` (`id_rol`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios VALUES("1","joel josue","huacon lopez","user-default.png","josu3","jjhuacon@est.itsgg.edu.ec","1","aac09534114879f13117bfd3e5a85bd0443ec7f776e737258de48f449788c4f1","1","2021-02-20 14:25:08","2021-02-20 14:25:08");



SET FOREIGN_KEY_CHECKS=1;