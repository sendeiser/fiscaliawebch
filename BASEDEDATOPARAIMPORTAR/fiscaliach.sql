/*
Navicat MySQL Data Transfer

Source Server         : LocalFiscaliaTesis
Source Server Version : 80021
Source Host           : localhost:3306
Source Database       : fiscaliach

Target Server Type    : MYSQL
Target Server Version : 80021
File Encoding         : 65001

Date: 2022-02-18 20:26:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for comisarias
-- ----------------------------
DROP TABLE IF EXISTS `comisarias`;
CREATE TABLE `comisarias` (
  `codigocomisaria` double(25,0) NOT NULL,
  `nrodetelefono` double(25,0) DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`codigocomisaria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of comisarias
-- ----------------------------
INSERT INTO `comisarias` VALUES ('1', '3826423456', 'Comisaria Primera Chamical');
INSERT INTO `comisarias` VALUES ('2', '3826760231', 'Comisaria Segunda Chamical');
INSERT INTO `comisarias` VALUES ('3', '3826405516', 'Comisaria de la Mujer Chamical');
INSERT INTO `comisarias` VALUES ('4', '3826423313', 'Comisaria de Olta');
INSERT INTO `comisarias` VALUES ('5', '3826453211', 'Comisaria de Chañar');
INSERT INTO `comisarias` VALUES ('6', '3826412231', 'Comisaria de Milagro');
INSERT INTO `comisarias` VALUES ('7', '3826456767', 'Comisaria de Catuna');

-- ----------------------------
-- Table structure for expedientes
-- ----------------------------
DROP TABLE IF EXISTS `expedientes`;
CREATE TABLE `expedientes` (
  `idexpediente` int NOT NULL AUTO_INCREMENT,
  `dnidenunciante` int NOT NULL,
  `denunciado` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `causa` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `medida` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fojas` decimal(2,0) DEFAULT NULL,
  `librodeactas` double(25,0) DEFAULT NULL,
  `codigocomisaria` double(25,0) NOT NULL,
  `numerodeexpediente` double(10,0) NOT NULL,
  `numexpinstru` int DEFAULT NULL,
  `fechadeentrada` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechadesalida` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idexpediente`),
  KEY `dnidenunciante` (`dnidenunciante`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of expedientes
-- ----------------------------
INSERT INTO `expedientes` VALUES ('47', '55555', 'SALA', 'Locs', 'Bosas', '4', '1', '2', '5322', null, '2021-06-14', '2021-06-17');
INSERT INTO `expedientes` VALUES ('49', '5962291', 'Caperucita Rojaqw', 'Agresión ', 'carcel', '1', '2', '2', '6413', null, '2021-06-15', '2021-06-24');
INSERT INTO `expedientes` VALUES ('50', '8542787', 'carlitos kaka ferreyra', 'Agresión ', 'carcel', '1', '2', '2', '6413', null, '2021-06-15', '2021-06-29');
INSERT INTO `expedientes` VALUES ('51', '356841', 'El PEPE', 'robo ', 'precaucion', '4', '2', '2', '888444', null, '2021-06-15', '2021-06-28');
INSERT INTO `expedientes` VALUES ('52', '81321', 'Mauricio del Rojo del Valle', 'asesinato', 'carcel', '4', '2', '2', '888444', null, '2021-06-15', '2021-05-06');
INSERT INTO `expedientes` VALUES ('53', '6541234', 'Pedro Asnar Gutierrez', 'Disturbio Social', 'Prision', '1', '2', '5', '541321', null, '2021-06-15', '2021-06-19');
INSERT INTO `expedientes` VALUES ('55', '35963158', 'Kity exequiel villada', 'Agresión ', 'carcel', '1', '2', '2', '888444', null, '2021-06-15', '2021-06-18');
INSERT INTO `expedientes` VALUES ('56', '65173246', 'Nano Ñoñola', 'robo ', 'perpetua', '2', '3', '2', '42343', null, '2021-06-15', '2021-06-27');
INSERT INTO `expedientes` VALUES ('59', '35658789', 'nieva franco rodrigo', 'violencia', 'prohibición ', '5', '1', '3', '163258', null, '19999-06-29', '1999-06-30');
INSERT INTO `expedientes` VALUES ('60', '35658789', 'nieva franco rodrigo', 'violencia', 'prohibición ', '5', '1', '3', '163258', null, '19999-06-29', '1999-06-30');

-- ----------------------------
-- Table structure for noticias
-- ----------------------------
DROP TABLE IF EXISTS `noticias`;
CREATE TABLE `noticias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `noticia` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `imagen` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `titulo` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of noticias
-- ----------------------------
INSERT INTO `noticias` VALUES ('1', 'en el dia de hoy no estara abierto debido a desindeccion para mas informacion preguntar por las redes sociales', 'images/4.jpg', 'Feriado por Desinfeccion');
INSERT INTO `noticias` VALUES ('2', 'Por supuesto, con fetch podemos acceder a los servicios web y recuperar datos que nos ofrece un API REST. El mecanismo es muy similar a lo que hemos aprendido en este artículo hasta el momento, con la única diferencia que tendremos que comprobar la respuesta de nuestro API para saber si la satisfactoria.', 'images/2.jpg', 'Acceso a un API REST');
INSERT INTO `noticias` VALUES ('3', 'Lorem ipsum dolor sit amet, consectet asdasd asfgh 43rey24we werwe we weg wegwe ', 'images/3.jpg', 'Prueba Tercera');
INSERT INTO `noticias` VALUES ('4', 'Lorem ipsum dolor sit amet, consectet asdasd asfgh 43rey24we werwe we weg wegwe ', 'images/3.jpg', 'Prueba Tercera');
INSERT INTO `noticias` VALUES ('5', 'Por supuesto, con fetch podemos acceder a los servicios web y recuperar datos que nos ofrece un API REST. El mecanismo es muy similar a lo que hemos aprendido en este artículo hasta el momento, con la única diferencia que tendremos que comprobar la respuesta de nuestro API para saber si la satisfactoria.', 'images/2.jpg', 'Acceso a un API REST');
INSERT INTO `noticias` VALUES ('6', 'en el dia de hoy no estara abierto debido a desindeccion para mas informacion preguntar por las redes sociales', 'images/4.jpg', 'Feriado por Desinfeccion');

-- ----------------------------
-- Table structure for personas1
-- ----------------------------
DROP TABLE IF EXISTS `personas1`;
CREATE TABLE `personas1` (
  `dnidenunciante` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `genero` varchar(18) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombreabogado` varchar(75) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`dnidenunciante`),
  CONSTRAINT `personas1_ibfk_1` FOREIGN KEY (`dnidenunciante`) REFERENCES `expedientes` (`dnidenunciante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of personas1
-- ----------------------------
INSERT INTO `personas1` VALUES ('81321', 'Mirta Dorio', 'Moreno', null, null);
INSERT INTO `personas1` VALUES ('356841', 'Jorgelina Romina', 'Romerro', null, null);
INSERT INTO `personas1` VALUES ('5962291', 'Paletilla Lomeo', 'gutierrez', null, null);
INSERT INTO `personas1` VALUES ('6541234', 'Ian Kalil', 'Romero', null, null);
INSERT INTO `personas1` VALUES ('8542787', 'Lolo tito', 'Santos', null, null);
INSERT INTO `personas1` VALUES ('35658789', 'Adrian ', 'gonzalez', null, null);
INSERT INTO `personas1` VALUES ('35963158', 'Ana Laura TTT', 'Gonzalez', null, null);
INSERT INTO `personas1` VALUES ('65173246', 'Elber Miguel', 'Luna', null, null);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Apellido` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Celular` decimal(45,0) NOT NULL,
  `Correo` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('38', 'Martin Gustavo', 'Gonzalez', '3826432180', 'martingt010@gmail.com', 'sendeiser', '14537188656');
INSERT INTO `usuarios` VALUES ('39', 'Martin Gustavo21', 'Gonzalez1', '3826432180', 'martingt0120@gmail.com', 'sendeiser23', '14537188656');
INSERT INTO `usuarios` VALUES ('40', 'rodrigo ', 'nieva', '3826540500', 'rodrigonieva84@outlook.com', 'rodrigo84', 'riopinto');
INSERT INTO `usuarios` VALUES ('41', 'Diego', 'Candelero', '3826471088', 'diegocandelero35@gmail.com', 'Diego', 'diego2021');

-- ----------------------------
-- View structure for vista_comisarias
-- ----------------------------
DROP VIEW IF EXISTS `vista_comisarias`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_comisarias` AS select `comisarias`.`codigocomisaria` AS `codigocomisaria`,`comisarias`.`nrodetelefono` AS `nrodetelefono`,`comisarias`.`descripcion` AS `descripcion` from `comisarias` ;

-- ----------------------------
-- View structure for vista_expedientes
-- ----------------------------
DROP VIEW IF EXISTS `vista_expedientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_expedientes` AS select `expedientes`.`idexpediente` AS `idexpediente`,`expedientes`.`dnidenunciante` AS `dnidenunciante`,`expedientes`.`denunciado` AS `denunciado`,`expedientes`.`causa` AS `causa`,`expedientes`.`medida` AS `medida`,`expedientes`.`fojas` AS `fojas`,`expedientes`.`librodeactas` AS `librodeactas`,`expedientes`.`codigocomisaria` AS `codigocomisaria`,`expedientes`.`numerodeexpediente` AS `numerodeexpediente`,`expedientes`.`numexpinstru` AS `numexpinstru`,`expedientes`.`fechadeentrada` AS `fechadeentrada`,`expedientes`.`fechadesalida` AS `fechadesalida` from `expedientes` ;

-- ----------------------------
-- View structure for vista_personas
-- ----------------------------
DROP VIEW IF EXISTS `vista_personas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_personas` AS select `personas1`.`dnidenunciante` AS `dnidenunciante`,`personas1`.`nombre` AS `nombre`,`personas1`.`apellido` AS `apellido`,`personas1`.`genero` AS `genero`,`personas1`.`nombreabogado` AS `nombreabogado` from `personas1` ;
