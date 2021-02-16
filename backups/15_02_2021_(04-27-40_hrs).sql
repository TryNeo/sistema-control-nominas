SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS nominas_bd;

USE nominas_bd;

DROP TABLE IF EXISTS empleados;

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` date DEFAULT NULL,
  `fecha_modifacion` date DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS modulos;

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO modulos VALUES("1","Dashboard","modulo de dashboard","1","2021-02-11 11:07:12","");
INSERT INTO modulos VALUES("2","Usuarios","modulo de usuarios","1","2021-02-11 12:24:13","");
INSERT INTO modulos VALUES("3","Roles","modulo de roles","1","2021-02-11 12:24:13","");
INSERT INTO modulos VALUES("4","Respaldo","modulo de respaldo","1","2021-02-13 00:06:47","");



DROP TABLE IF EXISTS permisos;

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
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8mb4;

INSERT INTO permisos VALUES("207","1","2","1","1","1","1");
INSERT INTO permisos VALUES("208","2","2","1","0","0","0");
INSERT INTO permisos VALUES("209","3","2","1","1","1","1");
INSERT INTO permisos VALUES("210","4","2","0","0","0","0");
INSERT INTO permisos VALUES("215","1","1","1","1","0","1");
INSERT INTO permisos VALUES("216","2","1","1","0","0","0");
INSERT INTO permisos VALUES("217","3","1","1","1","1","1");
INSERT INTO permisos VALUES("218","4","1","1","1","0","0");



DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO roles VALUES("1","Administrador","acceso a todo el sistemaa","1","2021-02-11 11:09:19","2021-02-11 11:48:20");
INSERT INTO roles VALUES("2","Supervisor","acceso a los supervisores","0","2021-02-11 13:41:40","2021-02-12 21:39:02");
INSERT INTO roles VALUES("3","Moderador","asies","1","2021-02-11 16:29:29","");
INSERT INTO roles VALUES("4","Bodeguero","permisos","0","2021-02-12 21:39:16","2021-02-12 22:24:37");
INSERT INTO roles VALUES("5","DjangoAdmin","asies","1","2021-02-12 22:25:43","");



DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuario` (`id_rol`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios VALUES("1","josue","lopez","tryneo","tryneo@gmail.com","1","03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4","1","2021-02-11 11:11:07","");
INSERT INTO usuarios VALUES("2","Rossy Johnana","Lopez Panchana","rossyqkioii","rossiioqqy@gmail.com","3","d8327ef259ffa3785d31a676d8101277afcc92ad9f7d3eef8e938190c26a38f2","1","2021-02-11 16:59:12","2021-02-12 21:52:35");
INSERT INTO usuarios VALUES("3","Jose Vicente","Huacon Lopez","jose12938239ye823eu238eu28983e8923","joseue29389238e33@gmail.com","3","03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4","1","2021-02-12 20:58:34","2021-02-12 21:56:38");
INSERT INTO usuarios VALUES("4","Leon","Michi","pruebassagna9u90wqu0dqw","we23923wewewewe@gmail.com","5","5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5","1","2021-02-12 21:46:54","2021-02-14 13:38:53");
INSERT INTO usuarios VALUES("5","Elizabeth","Clavellina","Ely1d","joseeweue33@gmail.com","5","cd372fb85148700fa88095e3492d3f9f5beb43e555e5ff26d95f5a6adc36f8e6","1","2021-02-12 21:44:03","2021-02-12 21:47:59");
INSERT INTO usuarios VALUES("6","Jqdjqwidioqwodqwdjjqwd","Qdqwidjqwidjqwodjwid","f9eowiejfiowjefwjfjowefewfwf","oefuewfjefjwueqg@gmail.com","5","$2y$10$SZhNHex.Anhvui7ylJsUfOYnwhgO3nyDVLw1YRlkHMw.u4Rc9Y0Nq","1","2021-02-12 21:47:26","");
INSERT INTO usuarios VALUES("7","Swq0dqwdqw8d8qw","00qd0q9wdu0qw","dwu09dq09wd09quw9du90sdcisdo","cschaschascq@gmai.com","3","cd30b6d9bae5906458f49cd3b65f9c2fbac6ea86b2686b5e9c67a1bbb4de1487","1","2021-02-13 18:28:49","2021-02-14 13:40:18");
INSERT INTO usuarios VALUES("8","Joel Lopez","Huacon Pepito","9qwud9qw0dj","joasi8a@gmail.com","3","ff4bc73e60aac61c58f0945a79df61809032b1ea338425b703bf0c071e28ecc5","1","2021-02-13 23:56:26","2021-02-14 13:31:34");



SET FOREIGN_KEY_CHECKS=1;