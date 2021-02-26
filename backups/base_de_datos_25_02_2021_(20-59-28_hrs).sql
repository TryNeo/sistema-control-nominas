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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO contractos VALUES("1","Contrato Indefinidos","Es todo contrato que concierta la prestación de servicios por un tiempo ilimitado.","1","2021-02-25 16:58:32","2021-02-25 20:57:09");
INSERT INTO contractos VALUES("2","q0wduqwd","u0e9d09we90ud0e","1","2021-02-25 20:59:17","2021-02-25 20:59:17");





CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_contracto` int(11) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_empleado`),
  KEY `fk_contracto` (`id_contracto`),
  CONSTRAINT `fk_contracto` FOREIGN KEY (`id_contracto`) REFERENCES `contractos` (`id_contracto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO modulos VALUES("1","Dashboard","modulo de dashboard","1","2021-02-25 16:57:50","2021-02-25 16:57:50");
INSERT INTO modulos VALUES("2","Usuarios","modulo de usuarios","1","2021-02-25 16:57:50","2021-02-25 16:57:50");
INSERT INTO modulos VALUES("3","Roles","modulo de roles","1","2021-02-25 16:57:51","2021-02-25 16:57:51");
INSERT INTO modulos VALUES("4","Respaldo","modulo de respaldo","1","2021-02-25 16:57:51","2021-02-25 16:57:51");
INSERT INTO modulos VALUES("5","Empleados","modulo de empleados","1","2021-02-25 16:57:51","2021-02-25 16:57:51");
INSERT INTO modulos VALUES("6","Contractos","modulo de contractos","1","2021-02-25 16:57:51","2021-02-25 16:57:51");





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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO permisos VALUES("1","1","1","1","1","1","1");
INSERT INTO permisos VALUES("2","2","1","1","1","1","1");
INSERT INTO permisos VALUES("3","3","1","1","1","1","1");
INSERT INTO permisos VALUES("4","4","1","1","1","1","1");
INSERT INTO permisos VALUES("5","5","1","1","1","1","1");
INSERT INTO permisos VALUES("6","6","1","1","1","1","1");





CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO roles VALUES("1","Administradores","permisos de acceso a todo el sistema","1","2021-02-25 16:57:51","2021-02-25 20:42:23");
INSERT INTO roles VALUES("2","Moderador","moderaciones","1","2021-02-25 20:58:53","2021-02-25 20:58:53");
INSERT INTO roles VALUES("3","qwqwduqdwuw","udw09eduq","1","2021-02-25 20:59:01","2021-02-25 20:59:01");





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

INSERT INTO usuarios VALUES("1","joel josue","huacon lopez","user-default.png","josu3","jjhuacon@est.itsgg.edu.ec","1","aac09534114879f13117bfd3e5a85bd0443ec7f776e737258de48f449788c4f1","1","2021-02-25 16:57:51","2021-02-25 16:57:51");



SET FOREIGN_KEY_CHECKS=1;