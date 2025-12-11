/*
Navicat MySQL Data Transfer

Source Server         : fiscaliaCH
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : fiscaliach

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2025-12-10 23:33:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for auditoria
-- ----------------------------
DROP TABLE IF EXISTS `auditoria`;
CREATE TABLE `auditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tabla_afectada` varchar(100) NOT NULL COMMENT 'Nombre de la tabla que fue modificada',
  `operacion` varchar(50) NOT NULL COMMENT 'Tipo de operación: INSERT, UPDATE, DELETE',
  `fecha` date NOT NULL COMMENT 'Fecha de la operación',
  `hora` time NOT NULL COMMENT 'Hora de la operación',
  `usuario` varchar(100) NOT NULL COMMENT 'Usuario que realizó la operación',
  `num_expediente` varchar(50) DEFAULT NULL COMMENT 'Número de expediente relacionado (si aplica)',
  `dni` varchar(20) DEFAULT NULL COMMENT 'DNI de la persona relacionada (si aplica)',
  `ip_usuario` varchar(45) DEFAULT NULL COMMENT 'Dirección IP del usuario',
  PRIMARY KEY (`id`),
  KEY `idx_tabla_afectada` (`tabla_afectada`),
  KEY `idx_fecha` (`fecha`),
  KEY `idx_usuario` (`usuario`),
  KEY `idx_num_expediente` (`num_expediente`),
  KEY `idx_dni` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=460 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de auditoría para registrar cambios en el sistema';

-- ----------------------------
-- Records of auditoria
-- ----------------------------
INSERT INTO `auditoria` VALUES ('1', 'Ninguna', 'Inicio de sesion', '2025-08-26', '18:02:01', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('2', 'Ninguna', 'Consulta de estado de denuncia', '2025-08-26', '18:02:21', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('3', 'expedientes', 'Se edito un expediente', '2025-08-26', '18:03:13', 'sendeiser', '5322', null, null);
INSERT INTO `auditoria` VALUES ('4', 'comisarias', 'Se edito una comisaria', '2025-08-26', '18:03:42', 'sendeiser', null, '6', null);
INSERT INTO `auditoria` VALUES ('5', 'Ninguna', 'Se genero un informe', '2025-08-26', '18:03:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('6', 'Ninguna', 'Se genero un informe', '2025-08-26', '18:04:17', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('7', 'Ninguna', 'Se genero un informe', '2025-08-26', '18:04:37', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('8', 'Noticias', 'Se subio una nueva noticia', '2025-08-26', '18:07:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('9', 'personas', 'Se elimino una persona', '2025-08-26', '18:09:15', 'sendeiser', null, '356841', null);
INSERT INTO `auditoria` VALUES ('10', 'Ninguna', 'Inicio de sesion', '2025-08-28', '18:33:50', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('14', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:01:18', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('15', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:01:35', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('16', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:01:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('17', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:15:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('18', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:18:12', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('19', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:20:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('20', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:22:11', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('21', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:29:55', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('22', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:30:19', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('23', 'Ninguna', 'Inicio de sesion', '2025-09-02', '21:30:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('24', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:42:30', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('25', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:44:29', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('26', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:45:38', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('27', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:47:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('28', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:48:36', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('29', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:49:21', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('30', 'Ninguna', 'Inicio de sesion', '2025-09-05', '18:57:27', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('31', 'Ninguna', 'Inicio de sesion', '2025-09-05', '19:07:14', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('32', 'Ninguna', 'Inicio de sesion', '2025-09-05', '19:08:10', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('33', 'Ninguna', 'Inicio de sesion', '2025-09-05', '19:09:45', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('34', 'Ninguna', 'Inicio de sesion', '2025-09-05', '19:10:01', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('35', 'Ninguna', 'Inicio de sesion', '2025-09-05', '19:10:24', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('36', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:22:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('37', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:23:03', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('38', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:25:14', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('39', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:25:32', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('40', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:28:05', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('41', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:33:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('42', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:34:12', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('43', 'Ninguna', 'Inicio de sesion', '2025-09-09', '19:40:48', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('44', 'Ninguna', 'Inicio de sesion', '2025-09-09', '20:24:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('45', 'Ninguna', 'Inicio de sesion', '2025-09-09', '20:27:18', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('46', 'Ninguna', 'Inicio de sesion', '2025-09-09', '20:27:38', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('47', 'Ninguna', 'Inicio de sesion', '2025-09-09', '20:28:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('48', 'Ninguna', 'Inicio de sesion', '2025-09-13', '20:49:06', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('49', 'Ninguna', 'Inicio de sesion', '2025-09-13', '20:51:55', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('50', 'Ninguna', 'Inicio de sesion', '2025-09-13', '21:08:28', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('51', 'Ninguna', 'Inicio de sesion', '2025-09-13', '21:39:11', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('52', 'expedientes', 'Se edito un expediente', '2025-09-13', '21:45:14', 'sendeiser', '6413', null, null);
INSERT INTO `auditoria` VALUES ('53', 'expedientes', 'Se elimino un expediente', '2025-09-13', '21:45:21', 'sendeiser', '888444', null, null);
INSERT INTO `auditoria` VALUES ('54', 'Ninguna', 'Inicio de sesion', '2025-09-13', '22:21:04', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('55', 'Ninguna', 'Inicio de sesion', '2025-09-17', '19:18:57', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('56', 'Ninguna', 'Inicio de sesion', '2025-09-17', '19:29:00', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('57', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:25:27', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('58', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:31:35', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('59', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:34:18', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('60', 'usuarios', 'Desbloqueo', '2025-10-04', '00:37:16', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('61', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:37:22', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('62', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:39:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('63', 'usuarios', 'Desbloqueo', '2025-10-04', '00:43:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('64', 'usuarios', 'Desbloqueo', '2025-10-04', '00:43:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('65', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:50:08', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('66', 'Ninguna', 'Inicio de sesion', '2025-10-03', '19:59:40', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('67', 'Ninguna', 'Inicio de sesion', '2025-10-03', '20:00:46', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('68', 'Ninguna', 'Inicio de sesion', '2025-10-03', '20:17:58', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('69', 'Ninguna', 'Inicio de sesion', '2025-10-03', '20:21:34', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('70', 'Ninguna', 'Inicio de sesion', '2025-10-11', '00:40:35', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('71', 'Ninguna', 'Se genero un informe', '2025-10-11', '00:43:35', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('72', 'Ninguna', 'Se genero un informe', '2025-10-11', '00:43:40', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('73', 'Ninguna', 'Se genero un informe', '2025-10-11', '00:43:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('74', 'Ninguna', 'Se genero un informe', '2025-10-11', '00:43:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('75', 'Ninguna', 'Se genero un informe', '2025-10-11', '00:43:54', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('76', 'Ninguna', 'Inicio de sesion', '2025-11-12', '10:40:16', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('77', 'Ninguna', 'Inicio de sesion', '2025-11-12', '10:41:09', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('78', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:49:22', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('79', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:49:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('80', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:50:04', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('81', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:50:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('82', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:51:28', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('83', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:55:24', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('84', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:55:26', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('85', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:56:55', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('86', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:56:56', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('87', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:56:57', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('88', 'Ninguna', 'Se genero un informe', '2025-11-12', '10:56:58', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('89', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:04:38', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('90', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:04:58', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('91', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:05:14', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('92', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:05:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('93', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:06:04', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('94', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:06:53', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('95', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:21:47', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('96', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:27:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('97', 'expedientes', 'Nuevo Registro de expediente', '2025-11-12', '11:28:08', '', '1258', null, null);
INSERT INTO `auditoria` VALUES ('98', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:30:12', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('99', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:31:05', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('100', 'expedientes', 'Nuevo Registro de expediente', '2025-11-12', '11:32:21', 'Tirofederal', '6897', null, null);
INSERT INTO `auditoria` VALUES ('101', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:32:25', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('102', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:32:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('103', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:35:11', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('104', 'expedientes', 'Se edito un expediente', '2025-11-12', '11:35:29', 'sendeiser', '5322', null, null);
INSERT INTO `auditoria` VALUES ('105', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:38:21', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('106', 'usuarios', 'Desbloqueo', '2025-11-12', '15:39:50', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('107', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:40:21', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('108', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:41:58', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('109', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:42:16', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('110', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:42:43', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('111', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:43:03', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('112', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:44:01', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('113', 'Ninguna', 'Se genero un informe', '2025-11-12', '11:44:20', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('114', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:45:59', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('115', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '11:46:10', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('116', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:47:23', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('117', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:49:22', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('118', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:51:03', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('119', 'Ninguna', 'Inicio de sesion', '2025-11-12', '11:52:32', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('120', 'Ninguna', 'Inicio de sesion', '2025-11-12', '12:03:05', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('121', 'Ninguna', 'Se genero un informe', '2025-11-12', '12:04:21', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('122', 'Ninguna', 'Se genero un informe', '2025-11-12', '12:04:42', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('123', 'Ninguna', 'Inicio de sesion', '2025-11-12', '12:08:48', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('124', 'Ninguna', 'Se genero un informe', '2025-11-12', '12:09:09', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('125', 'Ninguna', 'Se genero un informe', '2025-11-12', '12:10:04', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('126', 'Ninguna', 'Se genero un informe', '2025-11-12', '12:11:13', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('127', 'Ninguna', 'Inicio de sesion', '2025-11-12', '17:57:07', 'sendeiser2025', null, null, null);
INSERT INTO `auditoria` VALUES ('128', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:00:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('129', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:35:59', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('130', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:40:02', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('131', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:40:20', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('132', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:40:48', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('133', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:40:54', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('134', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:44:05', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('135', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:48:16', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('136', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:50:51', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('137', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:51:12', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('138', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:51:15', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('139', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:51:45', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('140', 'Ninguna', 'Se genero un informe', '2025-11-12', '18:51:59', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('141', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:56:03', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('142', 'Ninguna', 'Inicio de sesion', '2025-11-12', '18:57:58', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('143', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:08:52', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('144', 'expedientes', 'Nuevo Registro de expediente', '2025-11-12', '19:09:44', 'bocajuniors', '3512', null, null);
INSERT INTO `auditoria` VALUES ('145', 'comisarias', 'Se edito una comisaria', '2025-11-12', '19:12:24', 'bocajuniors', null, '1', null);
INSERT INTO `auditoria` VALUES ('146', 'personas', 'Se edito una persona', '2025-11-12', '19:12:56', 'bocajuniors', null, '55555', null);
INSERT INTO `auditoria` VALUES ('147', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:17:51', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('148', 'expedientes', 'Se elimino un expediente', '2025-11-12', '19:18:20', 'sendeiser', '5322', null, null);
INSERT INTO `auditoria` VALUES ('149', 'comisarias', 'Se elimino una comisaria', '2025-11-12', '19:18:49', 'sendeiser', null, '7', null);
INSERT INTO `auditoria` VALUES ('150', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:23:06', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('151', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:29:33', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('152', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:31:44', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('153', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:32:05', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('154', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:33:56', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('155', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:37:39', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('156', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:40:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('157', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:43:30', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('158', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:44:04', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('159', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:44:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('160', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:44:37', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('161', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:44:55', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('162', 'expedientes', 'Se elimino un expediente', '2025-11-12', '19:45:42', 'sendeiser', '163258', null, null);
INSERT INTO `auditoria` VALUES ('163', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-12', '19:45:47', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('164', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:51:09', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('165', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:54:44', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('166', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:55:28', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('167', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:56:10', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('168', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:57:06', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('169', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:57:34', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('170', 'Ninguna', 'Inicio de sesion', '2025-11-12', '19:59:27', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('171', 'contactos', 'Nuevo mensaje de contacto', '2025-11-12', '20:18:24', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('172', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:25:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('173', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:29:57', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('174', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:31:02', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('175', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:39:19', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('176', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:49:37', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('177', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:50:20', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('178', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:53:50', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('179', 'Ninguna', 'Inicio de sesion', '2025-11-12', '20:59:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('180', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:29', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('181', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:34', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('182', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:36', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('183', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('184', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:43', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('185', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:51', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('186', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:52', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('187', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:53', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('188', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:53', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('189', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:02:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('190', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:03:16', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('191', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:03:24', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('192', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:03:33', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('193', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:03:35', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('194', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:04:38', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('195', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:09:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('196', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:14:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('197', 'usuarios', 'Cierre de sesion', '2025-11-12', '21:19:10', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('198', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-12', '21:20:04', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('199', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-12', '21:20:44', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('200', 'usuarios', 'Cierre de sesion', '2025-11-12', '21:24:24', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('201', 'Ninguna', 'Inicio de sesion', '2025-11-12', '21:25:54', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('202', 'usuarios', 'Cierre de sesion', '2025-11-12', '21:27:36', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('203', 'Ninguna', 'Inicio de sesion', '2025-11-12', '22:54:32', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('204', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:18:57', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('205', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:36:52', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('206', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:38:14', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('207', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:40:11', 'Tirofederal', null, null, null);
INSERT INTO `auditoria` VALUES ('208', 'contactos', 'Export contactos CSV', '2025-11-13', '19:44:15', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('209', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:45:44', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('210', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:49:06', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('211', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:50:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('212', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:52:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('213', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:52:20', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('214', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:52:54', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('215', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:55:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('216', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:55:57', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('217', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '19:57:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('218', 'Ninguna', 'Inicio de sesion', '2025-11-13', '19:58:30', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('219', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '20:21:48', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('220', 'Ninguna', 'Inicio de sesion', '2025-11-13', '20:22:19', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('221', 'contactos', 'Marcar mensajes como leidos', '2025-11-13', '20:32:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('222', 'contactos', 'Marcar mensajes como no leidos', '2025-11-13', '20:32:50', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('223', 'contactos', 'Eliminacion de mensajes de contacto', '2025-11-13', '20:32:52', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('224', 'contactos', 'Nuevo mensaje de contacto', '2025-11-13', '20:34:56', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('225', 'contactos', 'Marcar mensajes como leidos', '2025-11-13', '20:37:23', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('226', 'contactos', 'Marcar mensajes como no leidos', '2025-11-13', '20:38:24', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('227', 'contactos', 'Marcar mensajes como leidos', '2025-11-13', '20:39:01', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('228', 'contactos', 'Marcar mensajes como no leidos', '2025-11-13', '20:39:08', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('229', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '20:40:14', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('230', 'Ninguna', 'Inicio de sesion', '2025-11-13', '20:40:55', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('231', 'contactos', 'Marcar mensajes como leidos', '2025-11-13', '20:41:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('232', 'contactos', 'Marcar mensajes como no leidos', '2025-11-13', '20:42:03', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('233', 'contactos', 'Marcar mensajes como leidos', '2025-11-13', '20:42:05', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('234', 'contactos', 'Marcar mensajes como no leidos', '2025-11-13', '20:42:43', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('235', 'contactos', 'Marcar mensajes como leidos', '2025-11-13', '20:42:44', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('236', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '20:44:53', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('237', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '20:44:53', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('238', 'Ninguna', 'Inicio de sesion', '2025-11-13', '20:45:01', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('239', 'Ninguna', 'Inicio de sesion', '2025-11-13', '20:45:03', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('240', 'Ninguna', 'Se genero un informe', '2025-11-13', '20:47:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('241', 'Ninguna', 'Se genero un informe', '2025-11-13', '20:47:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('242', 'Ninguna', 'Se genero un informe', '2025-11-13', '20:48:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('243', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '20:48:57', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('244', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '20:49:13', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('245', 'Ninguna', 'Inicio de sesion', '2025-11-13', '20:56:17', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('246', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '20:57:01', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('247', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:00:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('248', 'Ninguna', 'Inicio de sesion', '2025-11-13', '21:01:26', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('249', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '21:03:39', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('250', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '21:03:39', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('251', 'Ninguna', 'Inicio de sesion', '2025-11-13', '21:06:29', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('252', 'expedientes', 'Nuevo Registro de expediente', '2025-11-13', '21:07:39', 'sendeiser', '98321', null, null);
INSERT INTO `auditoria` VALUES ('253', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:09:22', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('254', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:09:53', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('255', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:10:16', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('256', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:11:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('257', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:11:25', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('258', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:11:38', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('259', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:12:27', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('260', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:12:37', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('261', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:14:52', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('262', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:16:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('263', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:19:28', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('264', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:20:22', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('265', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:20:28', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('266', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:21:00', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('267', 'Ninguna', 'Inicio de sesion', '2025-11-13', '21:21:31', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('268', 'Ninguna', 'Consulta de estado de denuncia', '2025-11-13', '21:21:40', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('269', 'usuarios', 'Cierre de sesion', '2025-11-13', '21:23:47', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('270', 'Ninguna', 'Inicio de sesion', '2025-11-13', '21:31:33', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('271', 'Ninguna', 'Inicio de sesion', '2025-11-13', '21:37:38', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('272', 'usuarios', 'Cierre de sesion', '2025-11-13', '21:39:36', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('273', 'seguridad', 'Acceso denegado: contactos:listar', '2025-11-13', '21:43:13', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('274', 'seguridad', 'Acceso denegado: auditoria:estadisticas', '2025-11-13', '21:43:20', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('275', 'Ninguna', 'Inicio de sesion', '2025-11-13', '22:03:47', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('276', 'seguridad', 'Acceso denegado: auditoria:estadisticas', '2025-11-13', '22:03:49', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('277', 'seguridad', 'Acceso denegado: auditoria:listar', '2025-11-13', '22:03:49', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('278', 'seguridad', 'Acceso denegado: contactos:listar', '2025-11-13', '22:04:08', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('279', 'seguridad', 'Acceso denegado: auditoria:estadisticas', '2025-11-13', '22:04:39', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('280', 'seguridad', 'Acceso denegado: auditoria:listar', '2025-11-13', '22:04:39', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('281', 'seguridad', 'Acceso denegado: contactos:listar', '2025-11-13', '22:04:53', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('282', 'expedientes', 'Se edito un expediente', '2025-11-13', '22:05:13', '', '6413', null, null);
INSERT INTO `auditoria` VALUES ('283', 'usuarios', 'Cierre de sesion', '2025-11-13', '22:05:23', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('284', 'Ninguna', 'Inicio de sesion', '2025-11-13', '22:08:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('285', 'usuarios', 'Cierre de sesion', '2025-11-13', '22:08:53', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('286', 'usuarios', 'Cierre de sesion', '2025-11-13', '22:09:30', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('287', 'Ninguna', 'Inicio de sesion', '2025-11-13', '22:09:41', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('288', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:11:02', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('289', 'usuarios', 'Cierre de sesion', '2025-11-13', '22:15:48', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('290', 'Ninguna', 'Inicio de sesion', '2025-11-13', '22:15:55', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('291', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:17:06', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('292', 'Ninguna', 'Inicio de sesion', '2025-11-13', '22:18:07', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('293', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:20:19', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('294', 'expedientes', 'Se edito un expediente', '2025-11-13', '22:34:51', '', '6413', null, null);
INSERT INTO `auditoria` VALUES ('295', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:36:11', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('296', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:43:50', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('297', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:48:12', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('298', 'usuarios', 'Cierre de sesion', '2025-11-13', '22:49:55', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('299', 'Ninguna', 'Inicio de sesion', '2025-11-13', '22:50:03', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('300', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-13', '22:52:08', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('301', 'Ninguna', 'Inicio de sesion', '2025-11-16', '21:49:58', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('302', 'Ninguna', 'Inicio de sesion', '2025-11-16', '21:50:08', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('303', 'usuarios', 'Cierre de sesion', '2025-11-16', '21:51:27', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('304', 'Ninguna', 'Inicio de sesion', '2025-11-16', '21:51:30', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('305', 'Ninguna', 'Inicio de sesion', '2025-11-16', '21:56:16', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('306', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '21:59:17', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('307', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '21:59:17', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('308', 'Ninguna', 'Inicio de sesion', '2025-11-16', '21:59:24', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('309', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:06:59', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('310', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:19:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('311', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:28:35', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('312', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:30:19', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('313', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:30:42', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('314', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:31:53', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('315', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:39:23', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('316', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:40:59', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('317', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:41:28', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('318', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:41:31', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('319', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:42:04', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('320', 'Ninguna', 'Se genero un informe', '2025-11-16', '22:47:03', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('321', 'Ninguna', 'Se genero un informe', '2025-11-16', '22:47:11', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('322', 'Ninguna', 'Se genero un informe', '2025-11-16', '22:47:20', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('323', 'Ninguna', 'Se genero un informe', '2025-11-16', '22:47:41', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('324', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:49:19', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('325', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:49:20', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('326', 'usuarios', 'Cierre de sesion', '2025-11-16', '22:49:29', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('327', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:49:53', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('328', 'usuarios', 'Desbloqueo', '2025-11-17', '02:50:18', 'bocajuniors', null, null, null);
INSERT INTO `auditoria` VALUES ('329', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:50:26', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('330', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:52:57', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('331', 'Ninguna', 'Inicio de sesion', '2025-11-16', '22:53:43', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('332', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:56:03', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('333', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '22:56:03', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('334', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:34:58', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('335', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:35:21', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('336', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:38:34', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('337', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:39:01', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('338', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:39:01', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('339', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:39:09', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('340', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:39:34', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('341', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:40:11', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('342', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:40:11', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('343', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:40:55', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('344', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:41:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('345', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:44:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('346', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:50:10', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('347', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:51:45', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('348', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:52:13', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('349', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:53:31', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('350', 'Ninguna', 'Inicio de sesion', '2025-11-16', '23:56:19', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('351', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-16', '23:57:38', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('352', 'Ninguna', 'Inicio de sesion', '2025-11-17', '00:02:45', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('353', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '00:04:14', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('354', 'Ninguna', 'Inicio de sesion', '2025-11-17', '00:17:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('355', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '00:19:31', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('356', 'Ninguna', 'Inicio de sesion', '2025-11-17', '00:20:54', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('357', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '00:23:14', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('358', 'Ninguna', 'Inicio de sesion', '2025-11-17', '00:29:14', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('359', 'usuarios', 'Cierre de sesion', '2025-11-17', '00:29:50', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('360', 'Ninguna', 'Inicio de sesion', '2025-11-17', '01:08:25', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('361', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '01:11:34', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('362', 'Ninguna', 'Inicio de sesion', '2025-11-17', '01:39:12', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('363', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '01:40:44', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('364', 'Ninguna', 'Inicio de sesion', '2025-11-17', '02:28:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('365', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '02:30:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('366', 'Ninguna', 'Inicio de sesion', '2025-11-17', '02:36:27', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('367', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '02:45:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('368', 'Ninguna', 'Inicio de sesion', '2025-11-17', '02:48:20', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('369', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '02:51:22', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('370', 'Ninguna', 'Inicio de sesion', '2025-11-17', '02:52:12', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('371', 'expedientes', 'Nuevo Registro de expediente', '2025-11-17', '02:54:13', 'sendeiser', '123123123', '1236451', null);
INSERT INTO `auditoria` VALUES ('372', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '02:55:32', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('373', 'Ninguna', 'Inicio de sesion', '2025-11-17', '02:57:49', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('374', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '03:03:09', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('375', 'Ninguna', 'Inicio de sesion', '2025-11-17', '03:06:05', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('376', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '03:07:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('377', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '03:07:15', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('378', 'Ninguna', 'Inicio de sesion', '2025-11-17', '03:08:31', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('379', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '03:14:30', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('380', 'Ninguna', 'Inicio de sesion', '2025-11-17', '03:16:02', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('381', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '03:17:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('382', 'Ninguna', 'Inicio de sesion', '2025-11-17', '16:42:35', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('383', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '16:44:18', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('384', 'contactos', 'Nuevo mensaje de contacto', '2025-11-17', '17:15:19', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('385', 'Ninguna', 'Inicio de sesion', '2025-11-17', '17:15:44', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('386', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '17:17:27', 'sendeiser23', null, null, null);
INSERT INTO `auditoria` VALUES ('387', 'Ninguna', 'Inicio de sesion', '2025-11-17', '17:31:23', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('388', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '17:33:02', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('389', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '17:33:02', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('390', 'contactos', 'Nuevo mensaje de contacto', '2025-11-17', '18:01:24', 'anonimo', null, null, null);
INSERT INTO `auditoria` VALUES ('391', 'Ninguna', 'Inicio de sesion', '2025-11-17', '18:14:37', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('392', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:16:31', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('393', 'Ninguna', 'Inicio de sesion', '2025-11-17', '18:17:18', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('394', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:19:43', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('395', 'Ninguna', 'Inicio de sesion', '2025-11-17', '18:42:46', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('396', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:43:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('397', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:43:59', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('398', 'Ninguna', 'Inicio de sesion', '2025-11-17', '18:44:16', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('399', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:45:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('400', 'Ninguna', 'Inicio de sesion', '2025-11-17', '18:46:05', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('401', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:47:09', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('402', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:47:09', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('403', 'Ninguna', 'Inicio de sesion', '2025-11-17', '18:47:40', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('404', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:49:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('405', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '18:49:41', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('406', 'Ninguna', 'Inicio de sesion', '2025-11-17', '19:04:04', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('407', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '19:05:12', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('408', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-17', '19:05:12', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('409', 'Ninguna', 'Inicio de sesion', '2025-11-18', '11:21:00', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('410', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '11:22:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('411', 'Ninguna', 'Inicio de sesion', '2025-11-18', '17:58:26', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('412', 'Ninguna', 'Inicio de sesion', '2025-11-18', '18:00:08', 'lemoncry', null, null, null);
INSERT INTO `auditoria` VALUES ('413', 'usuarios', 'Cierre de sesion', '2025-11-18', '18:00:40', 'lemoncry', null, null, null);
INSERT INTO `auditoria` VALUES ('414', 'Ninguna', 'Inicio de sesion', '2025-11-18', '18:01:01', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('415', 'Ninguna', 'Inicio de sesion', '2025-11-18', '18:01:57', 'lemoncry', null, null, null);
INSERT INTO `auditoria` VALUES ('416', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '18:02:13', 'lemoncry', null, null, null);
INSERT INTO `auditoria` VALUES ('417', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '18:03:15', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('418', 'Ninguna', 'Inicio de sesion', '2025-11-18', '18:05:04', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('419', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '18:06:42', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('420', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '18:06:42', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('421', 'Ninguna', 'Inicio de sesion', '2025-11-18', '18:15:44', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('422', 'Ninguna', 'Inicio de sesion', '2025-11-18', '18:16:48', 'wally', null, null, null);
INSERT INTO `auditoria` VALUES ('423', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '18:17:57', 'wally', null, null, null);
INSERT INTO `auditoria` VALUES ('424', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-18', '18:19:34', 'sistema', null, null, null);
INSERT INTO `auditoria` VALUES ('425', 'Ninguna', 'Inicio de sesion', '2025-11-30', '22:40:51', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('426', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '22:44:52', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('427', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '22:44:52', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('428', 'Ninguna', 'Inicio de sesion', '2025-11-30', '22:45:18', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('429', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '22:54:56', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('430', 'Ninguna', 'Inicio de sesion', '2025-11-30', '22:55:01', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('431', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '22:58:17', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('432', 'Ninguna', 'Inicio de sesion', '2025-11-30', '22:59:19', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('433', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '23:01:13', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('434', 'Ninguna', 'Inicio de sesion', '2025-11-30', '23:06:57', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('435', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '23:14:23', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('436', 'Ninguna', 'Inicio de sesion', '2025-11-30', '23:17:53', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('437', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '23:23:10', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('438', 'Ninguna', 'Inicio de sesion', '2025-11-30', '23:26:31', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('439', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '23:31:25', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('440', 'Ninguna', 'Inicio de sesion', '2025-11-30', '23:32:21', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('441', 'usuarios', 'Cierre de sesion por inactividad', '2025-11-30', '23:33:48', 'rodrigo84', null, null, null);
INSERT INTO `auditoria` VALUES ('442', 'Ninguna', 'Inicio de sesion', '2025-12-08', '15:24:07', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('443', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-08', '15:26:11', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('444', 'Ninguna', 'Inicio de sesion', '2025-12-08', '15:28:40', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('445', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-08', '15:32:02', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('446', 'Ninguna', 'Inicio de sesion', '2025-12-08', '15:33:05', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('447', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-08', '15:34:41', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('448', 'Ninguna', 'Inicio de sesion', '2025-12-08', '15:35:44', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('449', 'Ninguna', 'Inicio de sesion', '2025-12-10', '23:14:52', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('450', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-10', '23:16:37', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('451', 'Ninguna', 'Inicio de sesion', '2025-12-10', '23:16:52', 'felixhugo', null, null, null);
INSERT INTO `auditoria` VALUES ('452', 'Ninguna', 'Inicio de sesion', '2025-12-10', '23:17:52', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('453', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-10', '23:21:59', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('454', 'Ninguna', 'Inicio de sesion', '2025-12-10', '23:22:06', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('455', 'Ninguna', 'Inicio de sesion', '2025-12-10', '23:23:29', 'elberluna', null, null, null);
INSERT INTO `auditoria` VALUES ('456', 'usuarios', 'Cierre de sesion', '2025-12-10', '23:24:01', 'elberluna', null, null, null);
INSERT INTO `auditoria` VALUES ('457', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-10', '23:30:09', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('458', 'Ninguna', 'Inicio de sesion', '2025-12-10', '23:30:15', 'sendeiser', null, null, null);
INSERT INTO `auditoria` VALUES ('459', 'usuarios', 'Cierre de sesion por inactividad', '2025-12-10', '23:31:44', 'sendeiser', null, null, null);

-- ----------------------------
-- Table structure for comisarias
-- ----------------------------
DROP TABLE IF EXISTS `comisarias`;
CREATE TABLE `comisarias` (
  `codigocomisaria` double(25,0) NOT NULL,
  `nrodetelefono` double(25,0) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`codigocomisaria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of comisarias
-- ----------------------------
INSERT INTO `comisarias` VALUES ('1', '3826423456', 'Comisaria Primera Chamical2');
INSERT INTO `comisarias` VALUES ('2', '3826760231', 'Comisaria Segunda Chamical');
INSERT INTO `comisarias` VALUES ('3', '3826405516', 'Comisaria de la Mujer Chamical');
INSERT INTO `comisarias` VALUES ('4', '3826423313', 'Comisaria de Olta');
INSERT INTO `comisarias` VALUES ('5', '3826453211', 'Comisaria de Chañar');
INSERT INTO `comisarias` VALUES ('6', '3826412231', 'Comisaria de Milag');

-- ----------------------------
-- Table structure for contactos
-- ----------------------------
DROP TABLE IF EXISTS `contactos`;
CREATE TABLE `contactos` (
  `idcontacto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `hora` varchar(255) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_respuesta` varchar(255) DEFAULT NULL,
  `respuesta_contenido` longtext DEFAULT NULL,
  `respuesta_usuario` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idcontacto`),
  KEY `idx_fecha` (`fecha`),
  KEY `idx_estado` (`estado`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_email` (`email`),
  KEY `idx_asunto` (`asunto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of contactos
-- ----------------------------
INSERT INTO `contactos` VALUES ('2', 'boca junior', 'boca@gmail.com', '3826548796', 'informacion', 'quisiera saber ekl estado de la denuncia 1', '2025-11-13', '20:34:56', 'leido', null, null, null);
INSERT INTO `contactos` VALUES ('3', 'martin gonzalez', 'martingt010@gmail.com', '3826432188', 'reclamo', 'asdasdsafsdagdfagdfsg', '2025-11-17', '17:15:19', 'no_leido', null, null, null);
INSERT INTO `contactos` VALUES ('4', 'tato lalo', 'asdas@gmail.com', '(3248) 413-52132', 'informacion', 'asdasdsfsdf', '2025-11-17', '18:01:24', 'no_leido', null, null, null);

-- ----------------------------
-- Table structure for expedientes
-- ----------------------------
DROP TABLE IF EXISTS `expedientes`;
CREATE TABLE `expedientes` (
  `idexpediente` int(11) NOT NULL AUTO_INCREMENT,
  `dnidenunciante` int(11) NOT NULL,
  `denunciado` varchar(255) NOT NULL,
  `causa` varchar(255) NOT NULL,
  `medida` varchar(255) NOT NULL,
  `fojas` decimal(2,0) DEFAULT NULL,
  `librodeactas` double(25,0) DEFAULT NULL,
  `codigocomisaria` double(25,0) NOT NULL,
  `numerodeexpediente` double(10,0) NOT NULL,
  `numexpinstru` int(11) DEFAULT NULL,
  `fechadeentrada` varchar(255) NOT NULL,
  `fechadesalida` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idexpediente`),
  KEY `dnidenunciante` (`dnidenunciante`)
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of expedientes
-- ----------------------------
INSERT INTO `expedientes` VALUES ('228', '20012345', 'Juan Pérez', 'Lesiones', 'Investigación', '34', '1', '1', '932415', '1101', '2024-01-12', null);
INSERT INTO `expedientes` VALUES ('229', '20022346', 'María Gómez', 'Hurto', 'Archivo', '18', '2', '2', '987302', '1102', '2024-02-05', null);
INSERT INTO `expedientes` VALUES ('230', '20032347', 'Carlos Díaz', 'Estafa', 'Investigación', '56', '1', '3', '943781', '1103', '2024-03-19', null);
INSERT INTO `expedientes` VALUES ('231', '20042348', 'Ana López', 'Violencia familiar', 'Restricción', '42', '2', '4', '915679', '1104', '2024-04-07', null);
INSERT INTO `expedientes` VALUES ('232', '20052349', 'Luis Fernández', 'Amenazas', 'Investigación', '25', '1', '5', '968254', '1105', '2024-05-22', null);
INSERT INTO `expedientes` VALUES ('233', '20062350', 'Sofía Herrera', 'Lesiones leves', 'Mediación', '31', '2', '1', '921038', '1106', '2024-06-10', null);
INSERT INTO `expedientes` VALUES ('234', '20072351', 'Diego Romero', 'Daños', 'Investigación', '27', '1', '2', '955621', '1107', '2024-07-03', null);
INSERT INTO `expedientes` VALUES ('235', '20082352', 'Lucía Rivas', 'Hurto simple', 'Archivo', '22', '2', '3', '973406', '1108', '2024-08-14', null);
INSERT INTO `expedientes` VALUES ('236', '20092353', 'Martín Castro', 'Estafa telefónica', 'Investigación', '48', '1', '4', '946813', '1109', '2024-09-09', null);
INSERT INTO `expedientes` VALUES ('237', '20102354', 'Valeria Molina', 'Robo', 'Investigación', '63', '2', '5', '997520', '1110', '2024-10-26', null);
INSERT INTO `expedientes` VALUES ('238', '20112355', 'Pablo Suárez', 'Lesiones', 'Investigación', '39', '1', '1', '934208', '1111', '2024-11-12', null);
INSERT INTO `expedientes` VALUES ('239', '20122356', 'Natalia Vega', 'Amenazas', 'Restricción', '21', '2', '2', '982137', '1112', '2024-12-03', null);
INSERT INTO `expedientes` VALUES ('240', '20132357', 'Hernán Ortiz', 'Estafa', 'Investigación', '52', '1', '3', '916845', '1113', '2025-01-08', null);
INSERT INTO `expedientes` VALUES ('241', '20142358', 'Carolina Méndez', 'Violencia de género', 'Restricción', '44', '2', '4', '961704', '1114', '2025-01-15', null);
INSERT INTO `expedientes` VALUES ('242', '20152359', 'Gonzalo Navarro', 'Hurto', 'Investigación', '29', '1', '5', '978391', '1115', '2025-01-22', null);
INSERT INTO `expedientes` VALUES ('243', '20162360', 'Andrea Silva', 'Lesiones graves', 'Investigación', '67', '2', '1', '923570', '1116', '2025-02-03', null);
INSERT INTO `expedientes` VALUES ('244', '20172361', 'Federico Ibarra', 'Daños', 'Mediación', '33', '1', '2', '949286', '1117', '2025-02-10', null);
INSERT INTO `expedientes` VALUES ('245', '20182362', 'Agustina Ruiz', 'Amenazas', 'Investigación', '19', '2', '3', '965102', '1118', '2025-02-17', null);
INSERT INTO `expedientes` VALUES ('246', '20192363', 'Nicolás Cabrera', 'Robo agravado', 'Investigación', '71', '1', '4', '938417', '1119', '2025-02-24', null);
INSERT INTO `expedientes` VALUES ('247', '20202364', 'Paula Medina', 'Estafa bancaria', 'Investigación', '58', '2', '5', '992064', '1120', '2025-03-03', null);
INSERT INTO `expedientes` VALUES ('248', '20212365', 'Jorge Morales', 'Lesiones', 'Mediación', '36', '1', '1', '931758', '1121', '2025-03-10', null);
INSERT INTO `expedientes` VALUES ('249', '20222366', 'Romina Ponce', 'Amenazas', 'Restricción', '23', '2', '2', '984329', '1122', '2025-03-12', null);
INSERT INTO `expedientes` VALUES ('250', '20232367', 'Matías Bustos', 'Hurto', 'Investigación', '28', '1', '3', '919640', '1123', '2025-03-17', null);
INSERT INTO `expedientes` VALUES ('251', '20242368', 'Yanina Ayala', 'Estafa', 'Archivo', '17', '2', '4', '957812', '1124', '2025-03-20', null);
INSERT INTO `expedientes` VALUES ('252', '20252369', 'Alejandro Paredes', 'Violencia familiar', 'Restricción', '46', '1', '5', '975693', '1125', '2025-03-25', null);
INSERT INTO `expedientes` VALUES ('253', '20262370', 'Camila Godoy', 'Lesiones leves', 'Mediación', '32', '2', '1', '924175', '1126', '2025-03-28', null);
INSERT INTO `expedientes` VALUES ('254', '20272371', 'Ricardo Funes', 'Daños', 'Investigación', '37', '1', '2', '952086', '1127', '2025-04-02', null);
INSERT INTO `expedientes` VALUES ('255', '20282372', 'Julieta Salas', 'Hurto simple', 'Archivo', '20', '2', '3', '969431', '1128', '2025-04-04', null);
INSERT INTO `expedientes` VALUES ('256', '20292373', 'Claudio Aguilar', 'Estafa online', 'Investigación', '55', '1', '4', '941275', '1129', '2025-04-10', null);
INSERT INTO `expedientes` VALUES ('257', '20302374', 'Verónica Sosa', 'Robo', 'Investigación', '64', '2', '5', '995018', '1130', '2025-04-15', null);
INSERT INTO `expedientes` VALUES ('258', '20312375', 'Germán Benítez', 'Lesiones', 'Investigación', '41', '1', '1', '936520', '1131', '2025-04-20', null);
INSERT INTO `expedientes` VALUES ('259', '20322376', 'Noelia Carrizo', 'Amenazas', 'Restricción', '24', '2', '2', '985476', '1132', '2025-04-25', null);
INSERT INTO `expedientes` VALUES ('260', '20332377', 'Tomás Ledesma', 'Estafa', 'Investigación', '53', '1', '3', '918305', '1133', '2025-05-01', null);
INSERT INTO `expedientes` VALUES ('261', '20342378', 'Florencia Varela', 'Violencia de género', 'Restricción', '47', '2', '4', '960742', '1134', '2025-05-04', null);
INSERT INTO `expedientes` VALUES ('262', '20352379', 'Leandro Pardo', 'Hurto', 'Investigación', '26', '1', '5', '976831', '1135', '2025-05-08', null);
INSERT INTO `expedientes` VALUES ('263', '20362380', 'Milagros Soto', 'Lesiones graves', 'Investigación', '68', '2', '1', '922169', '1136', '2025-05-12', null);
INSERT INTO `expedientes` VALUES ('264', '20372381', 'Emiliano Arias', 'Daños', 'Mediación', '35', '1', '2', '948305', '1137', '2025-05-16', null);
INSERT INTO `expedientes` VALUES ('265', '20382382', 'Daniela Palacios', 'Amenazas', 'Investigación', '22', '2', '3', '966214', '1138', '2025-05-20', null);
INSERT INTO `expedientes` VALUES ('266', '20392383', 'Santiago Cuello', 'Robo agravado', 'Investigación', '73', '1', '4', '939580', '1139', '2025-05-24', null);
INSERT INTO `expedientes` VALUES ('267', '20402384', 'Alicia Roldán', 'Estafa bancaria', 'Investigación', '57', '2', '5', '993147', '1140', '2025-05-28', null);
INSERT INTO `expedientes` VALUES ('268', '20412385', 'Héctor Giménez', 'Lesiones', 'Mediación', '38', '1', '1', '930614', '1141', '2025-06-02', null);
INSERT INTO `expedientes` VALUES ('269', '20422386', 'Patricia Bustamante', 'Amenazas', 'Restricción', '24', '2', '2', '983205', '1142', '2025-06-06', null);
INSERT INTO `expedientes` VALUES ('270', '20432387', 'Rodrigo Aybar', 'Hurto', 'Investigación', '30', '1', '3', '917482', '1143', '2025-06-10', null);
INSERT INTO `expedientes` VALUES ('271', '20442388', 'Mónica Castaño', 'Estafa', 'Archivo', '16', '2', '4', '956730', '1144', '2025-06-14', null);
INSERT INTO `expedientes` VALUES ('272', '20452389', 'Iván Aguirre', 'Violencia familiar', 'Restricción', '45', '1', '5', '974862', '1145', '2025-06-18', null);
INSERT INTO `expedientes` VALUES ('273', '20462390', 'Cecilia Pizarro', 'Lesiones leves', 'Mediación', '33', '2', '1', '925093', '1146', '2025-06-22', null);
INSERT INTO `expedientes` VALUES ('274', '20472391', 'Oscar Molina', 'Daños', 'Investigación', '36', '1', '2', '953641', '1147', '2025-06-26', null);
INSERT INTO `expedientes` VALUES ('275', '20482392', 'Elena Figueroa', 'Hurto simple', 'Archivo', '19', '2', '3', '970586', '1148', '2025-06-28', null);
INSERT INTO `expedientes` VALUES ('276', '20492393', 'Mauricio Luján', 'Estafa online', 'Investigación', '54', '1', '4', '942307', '1149', '2025-07-02', null);
INSERT INTO `expedientes` VALUES ('277', '20502394', 'Vanesa Peralta', 'Robo', 'Investigación', '66', '2', '5', '996421', '1150', '2025-07-05', null);
INSERT INTO `expedientes` VALUES ('278', '1236451', 'Nicolas del Mal', 'L. Graves', 'a4', '1', '2', '1', '123123123', null, '2025-11-17', null);

-- ----------------------------
-- Table structure for historial_accesos
-- ----------------------------
DROP TABLE IF EXISTS `historial_accesos`;
CREATE TABLE `historial_accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `ip` varchar(45) NOT NULL,
  `exitoso` tinyint(1) NOT NULL,
  `detalles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historial_usuario_idx` (`id_usuario`),
  CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idusuarios`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of historial_accesos
-- ----------------------------
INSERT INTO `historial_accesos` VALUES ('1', '38', '2025-11-12 21:09:07', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('2', '38', '2025-11-12 21:14:46', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('3', '38', '2025-11-12 21:25:54', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('4', '40', '2025-11-12 22:54:32', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('5', '38', '2025-11-13 19:18:57', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('10', '38', '2025-11-13 19:45:44', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('11', '38', '2025-11-13 19:50:35', '::1', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('12', '38', '2025-11-13 19:50:41', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('13', '38', '2025-11-13 19:52:54', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('14', '38', '2025-11-13 19:55:57', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('15', '38', '2025-11-13 19:58:30', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('16', '38', '2025-11-13 20:22:19', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('17', '38', '2025-11-13 20:40:55', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('18', '38', '2025-11-13 20:45:01', '192.168.0.160', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('19', '38', '2025-11-13 20:45:03', '192.168.0.160', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('20', '38', '2025-11-13 20:56:18', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('21', '38', '2025-11-13 21:01:26', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('22', '38', '2025-11-13 21:06:29', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('23', '38', '2025-11-13 21:21:31', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('24', '38', '2025-11-13 21:31:33', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('25', '38', '2025-11-13 21:37:38', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('26', '38', '2025-11-13 22:03:47', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('27', '38', '2025-11-13 22:08:15', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('28', '39', '2025-11-13 22:09:41', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('29', '39', '2025-11-13 22:15:55', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('30', '39', '2025-11-13 22:18:07', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('31', '39', '2025-11-13 22:50:03', '127.0.0.1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('32', '38', '2025-11-16 21:49:58', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('33', '47', '2025-11-16 21:50:08', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('34', '40', '2025-11-16 21:51:30', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('35', '40', '2025-11-16 21:56:11', '192.168.0.118', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('36', '40', '2025-11-16 21:56:16', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('37', '40', '2025-11-16 21:59:24', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('38', '47', '2025-11-16 22:06:59', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('39', '39', '2025-11-16 22:28:35', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('40', '40', '2025-11-16 22:31:53', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('41', '39', '2025-11-16 22:39:23', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('42', '40', '2025-11-16 22:41:31', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('43', '39', '2025-11-16 22:42:04', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('44', '47', '2025-11-16 22:49:19', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('45', '40', '2025-11-16 22:49:34', '192.168.0.118', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('46', '40', '2025-11-16 22:49:36', '192.168.0.118', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('47', '40', '2025-11-16 22:49:37', '192.168.0.118', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('48', '40', '2025-11-16 22:49:37', '192.168.0.118', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('49', '40', '2025-11-16 22:49:38', '192.168.0.118', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('50', '40', '2025-11-16 22:49:44', '192.168.0.118', '0', 'Intento de acceso a cuenta bloqueada');
INSERT INTO `historial_accesos` VALUES ('51', '47', '2025-11-16 22:49:53', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('52', '40', '2025-11-16 22:50:26', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('53', '38', '2025-11-16 22:52:57', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('54', '40', '2025-11-16 22:53:43', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('55', '39', '2025-11-16 23:34:58', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('56', '38', '2025-11-16 23:35:21', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('57', '40', '2025-11-16 23:39:09', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('58', '38', '2025-11-16 23:39:30', '192.168.0.113', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('59', '38', '2025-11-16 23:39:34', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('60', '38', '2025-11-16 23:41:46', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('61', '38', '2025-11-16 23:50:10', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('62', '38', '2025-11-16 23:52:13', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('63', '38', '2025-11-16 23:56:19', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('64', '38', '2025-11-17 00:02:45', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('65', '38', '2025-11-17 00:17:46', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('66', '38', '2025-11-17 00:20:54', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('67', '39', '2025-11-17 00:29:14', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('68', '40', '2025-11-17 01:08:25', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('69', '40', '2025-11-17 01:39:12', '192.168.0.118', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('70', '38', '2025-11-17 02:28:49', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('71', '38', '2025-11-17 02:36:27', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('72', '38', '2025-11-17 02:48:20', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('73', '38', '2025-11-17 02:52:12', '192.168.0.113', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('74', '38', '2025-11-17 02:57:49', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('75', '38', '2025-11-17 03:06:05', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('76', '38', '2025-11-17 03:08:31', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('77', '38', '2025-11-17 03:16:02', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('78', '38', '2025-11-17 16:42:35', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('79', '39', '2025-11-17 17:15:44', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('80', '38', '2025-11-17 17:31:23', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('81', '38', '2025-11-17 18:14:37', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('82', '38', '2025-11-17 18:17:18', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('83', '38', '2025-11-17 18:42:46', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('84', '38', '2025-11-17 18:44:16', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('85', '40', '2025-11-17 18:46:05', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('86', '38', '2025-11-17 18:47:40', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('87', '38', '2025-11-17 19:04:00', '::1', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('88', '38', '2025-11-17 19:04:04', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('89', '38', '2025-11-18 11:21:00', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('90', '38', '2025-11-18 17:58:26', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('91', '51', '2025-11-18 18:00:08', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('92', '38', '2025-11-18 18:01:01', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('93', '51', '2025-11-18 18:01:57', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('94', '38', '2025-11-18 18:05:04', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('95', '38', '2025-11-18 18:15:44', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('96', '52', '2025-11-18 18:16:48', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('97', '40', '2025-11-30 22:40:45', '::1', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('98', '40', '2025-11-30 22:40:51', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('99', '40', '2025-11-30 22:45:19', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('100', '40', '2025-11-30 22:55:01', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('101', '40', '2025-11-30 22:59:19', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('102', '40', '2025-11-30 23:06:57', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('103', '40', '2025-11-30 23:17:53', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('104', '40', '2025-11-30 23:26:27', '::1', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('105', '40', '2025-11-30 23:26:31', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('106', '40', '2025-11-30 23:32:22', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('107', '38', '2025-12-08 15:24:08', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('108', '38', '2025-12-08 15:28:40', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('109', '38', '2025-12-08 15:33:05', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('110', '38', '2025-12-08 15:35:44', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('111', '38', '2025-12-10 23:14:52', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('112', '53', '2025-12-10 23:16:52', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('113', '38', '2025-12-10 23:17:42', '::1', '0', 'Contraseña incorrecta');
INSERT INTO `historial_accesos` VALUES ('114', '38', '2025-12-10 23:17:52', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('115', '38', '2025-12-10 23:22:06', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('116', '54', '2025-12-10 23:23:29', '::1', '1', 'Inicio de sesión exitoso');
INSERT INTO `historial_accesos` VALUES ('117', '38', '2025-12-10 23:30:15', '::1', '1', 'Inicio de sesión exitoso');

-- ----------------------------
-- Table structure for noticias
-- ----------------------------
DROP TABLE IF EXISTS `noticias`;
CREATE TABLE `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noticia` text DEFAULT NULL,
  `imagen` text DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of noticias
-- ----------------------------
INSERT INTO `noticias` VALUES ('1', 'en el dia de hoy no estara abierto debido a desindeccion para mas informacion preguntar por las redes sociales', 'images/4.jpg', 'Feriado por Desinfeccion');
INSERT INTO `noticias` VALUES ('2', 'Por supuesto, con fetch podemos acceder a los servicios web y recuperar datos que nos ofrece un API REST. El mecanismo es muy similar a lo que hemos aprendido en este artículo hasta el momento, con la única diferencia que tendremos que comprobar la respuesta de nuestro API para saber si la satisfactoria.', 'images/2.jpg', 'Acceso a un API REST');
INSERT INTO `noticias` VALUES ('3', 'Lorem ipsum dolor sit amet, consectet asdasd asfgh 43rey24we werwe we weg wegwe ', 'images/3.jpg', 'Prueba Tercera');
INSERT INTO `noticias` VALUES ('4', 'Lorem ipsum dolor sit amet, consectet asdasd asfgh 43rey24we werwe we weg wegwe ', 'images/3.jpg', 'Prueba Tercera');
INSERT INTO `noticias` VALUES ('5', 'Por supuesto, con fetch podemos acceder a los servicios web y recuperar datos que nos ofrece un API REST. El mecanismo es muy similar a lo que hemos aprendido en este artículo hasta el momento, con la única diferencia que tendremos que comprobar la respuesta de nuestro API para saber si la satisfactoria.', 'images/2.jpg', 'Acceso a un API REST');
INSERT INTO `noticias` VALUES ('6', 'en el dia de hoy no estara abierto debido a desindeccion para mas informacion preguntar por las redes sociales', 'images/4.jpg', 'Feriado por Desinfeccion');
INSERT INTO `noticias` VALUES ('7', 'Chamical, La Rioja — 26 de agosto de 2025 En un curioso giro de innovación rural, la Municipalidad de Chamical ha lanzado un programa piloto en el que llamas entrenadas colaboran con agentes de tránsito para mejorar la circulación en zonas escolares. Las llamas, vestidas con chalecos reflectantes y gorritas oficiales, han sido entrenadas para guiar a los peatones y alertar a los conductores con movimientos específicos de orejas.\n\nEl intendente declaró: “Son más obedientes que algunos conductores. Y además, generan ternura, lo que reduce el estrés vial.”\n\nVecinos reportan que el tránsito ha mejorado notablemente, aunque algunos niños se distraen intentando acariciar a los animales. El proyecto, bautizado “Llama Verde”, podría expandirse a otras localidades si los resultados continúan siendo positivos.', 'images/111.jpg', '???? Insólito: Llamas entrenadas ayudan a dirigir el tránsito en Chamical');

-- ----------------------------
-- Table structure for personas1
-- ----------------------------
DROP TABLE IF EXISTS `personas1`;
CREATE TABLE `personas1` (
  `dnidenunciante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `genero` varchar(18) DEFAULT NULL,
  `nombreabogado` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`dnidenunciante`),
  CONSTRAINT `personas1_ibfk_1` FOREIGN KEY (`dnidenunciante`) REFERENCES `expedientes` (`dnidenunciante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of personas1
-- ----------------------------
INSERT INTO `personas1` VALUES ('1236451', 'Jogre', 'Goyochea', null, null);
INSERT INTO `personas1` VALUES ('20022346', 'Marina', 'Romero', null, null);
INSERT INTO `personas1` VALUES ('20032347', 'Claudio', 'Nieto', null, null);
INSERT INTO `personas1` VALUES ('20042348', 'Daniela', 'Torres', null, null);
INSERT INTO `personas1` VALUES ('20052349', 'Hugo', 'Saldivar', null, null);
INSERT INTO `personas1` VALUES ('20062350', 'Sabrina', 'Fernandez', null, null);
INSERT INTO `personas1` VALUES ('20072351', 'Diego', 'Ramos', null, null);
INSERT INTO `personas1` VALUES ('20082352', 'Lucia', 'Ferrer', null, null);
INSERT INTO `personas1` VALUES ('20092353', 'Martin', 'Acosta', null, null);
INSERT INTO `personas1` VALUES ('20102354', 'Valeria', 'Molina', null, null);
INSERT INTO `personas1` VALUES ('20112355', 'Pablo', 'Suarez', null, null);
INSERT INTO `personas1` VALUES ('20122356', 'Natalia', 'Vega', null, null);
INSERT INTO `personas1` VALUES ('20132357', 'Hernan', 'Ortiz', null, null);
INSERT INTO `personas1` VALUES ('20142358', 'Carolina', 'Mendez', null, null);
INSERT INTO `personas1` VALUES ('20152359', 'Gonzalo', 'Navarro', null, null);
INSERT INTO `personas1` VALUES ('20162360', 'Andrea', 'Silva', null, null);
INSERT INTO `personas1` VALUES ('20172361', 'Federico', 'Ibarra', null, null);
INSERT INTO `personas1` VALUES ('20182362', 'Agustina', 'Ruiz', null, null);
INSERT INTO `personas1` VALUES ('20192363', 'Nicolas', 'Cabrera', null, null);
INSERT INTO `personas1` VALUES ('20202364', 'Paula', 'Medina', null, null);
INSERT INTO `personas1` VALUES ('20212365', 'Jorge', 'Morales', null, null);
INSERT INTO `personas1` VALUES ('20222366', 'Romina', 'Ponce', null, null);
INSERT INTO `personas1` VALUES ('20232367', 'Matias', 'Bustos', null, null);
INSERT INTO `personas1` VALUES ('20242368', 'Yanina', 'Ayala', null, null);
INSERT INTO `personas1` VALUES ('20252369', 'Alejandro', 'Paredes', null, null);
INSERT INTO `personas1` VALUES ('20262370', 'Camila', 'Godoy', null, null);
INSERT INTO `personas1` VALUES ('20272371', 'Ricardo', 'Funes', null, null);
INSERT INTO `personas1` VALUES ('20282372', 'Julieta', 'Salas', null, null);
INSERT INTO `personas1` VALUES ('20292373', 'Claudio', 'Aguilar', null, null);
INSERT INTO `personas1` VALUES ('20302374', 'Veronica', 'Sosa', null, null);
INSERT INTO `personas1` VALUES ('20312375', 'German', 'Benitez', null, null);
INSERT INTO `personas1` VALUES ('20322376', 'Noelia', 'Carrizo', null, null);
INSERT INTO `personas1` VALUES ('20332377', 'Tomas', 'Ledesma', null, null);
INSERT INTO `personas1` VALUES ('20342378', 'Florencia', 'Varela', null, null);
INSERT INTO `personas1` VALUES ('20352379', 'Leandro', 'Pardo', null, null);
INSERT INTO `personas1` VALUES ('20362380', 'Milagros', 'Soto', null, null);
INSERT INTO `personas1` VALUES ('20372381', 'Emiliano', 'Arias', null, null);
INSERT INTO `personas1` VALUES ('20382382', 'Daniela', 'Palacios', null, null);
INSERT INTO `personas1` VALUES ('20392383', 'Santiago', 'Cuello', null, null);
INSERT INTO `personas1` VALUES ('20402384', 'Alicia', 'Roldan', null, null);
INSERT INTO `personas1` VALUES ('20412385', 'Hector', 'Gimenez', null, null);
INSERT INTO `personas1` VALUES ('20422386', 'Patricia', 'Bustamante', null, null);
INSERT INTO `personas1` VALUES ('20432387', 'Rodrigo', 'Aybar', null, null);
INSERT INTO `personas1` VALUES ('20442388', 'Monica', 'Castano', null, null);
INSERT INTO `personas1` VALUES ('20452389', 'Ivan', 'Aguirre', null, null);
INSERT INTO `personas1` VALUES ('20462390', 'Cecilia', 'Pizarro', null, null);
INSERT INTO `personas1` VALUES ('20472391', 'Oscar', 'Molina', null, null);
INSERT INTO `personas1` VALUES ('20482392', 'Elena', 'Figueroa', null, null);
INSERT INTO `personas1` VALUES ('20492393', 'Mauricio', 'Lujan', null, null);
INSERT INTO `personas1` VALUES ('20502394', 'Vanesa', 'Peralta', null, null);

-- ----------------------------
-- Table structure for pwrandom
-- ----------------------------
DROP TABLE IF EXISTS `pwrandom`;
CREATE TABLE `pwrandom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password_plain` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of pwrandom
-- ----------------------------
INSERT INTO `pwrandom` VALUES ('10', '=++mAz3e6H6S', '$2y$10$gQB.tCJIf6R3NjDlFGdlW..Px6uNxAIhUflU0wjpupO.FU8FhNPO6', 'sendeiser', '2025-11-18 18:15:57');
INSERT INTO `pwrandom` VALUES ('11', 'FX-wg8DqT_&w', '$2y$10$PgkUt/UXW/g6mo/p2l1zheu.jG9QVAoKaxRwzAf4R1xyaiDjkfqE.', 'rodrigo84', '2025-11-30 23:12:27');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  `Apellido` varchar(45) NOT NULL,
  `Celular` decimal(45,0) NOT NULL,
  `Correo` varchar(45) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `intentos_fallidos` int(11) DEFAULT 0,
  `bloqueado` tinyint(1) DEFAULT 0,
  `fecha_bloqueo` datetime DEFAULT NULL,
  `rol` enum('usuario','administrador') DEFAULT 'usuario',
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('38', 'Martin Gustavo', 'Gonza', '3826432180', '', 'sendeiser', '14537188656', '0', '0', null, 'administrador', 'images/profiles/user_38_20251112104620.png');
INSERT INTO `usuarios` VALUES ('39', 'Martin Gustavo21', 'Gonzalez1', '3826432180', 'martingt0120@gmail.com', 'sendeiser23', '14537188656', '0', '0', null, 'usuario', null);
INSERT INTO `usuarios` VALUES ('40', 'rodrigo', 'nieva', '3826540500', 'rodrigonieva84@outlook.com', 'rodrigo84', 'riocuarto', '0', '0', null, 'administrador', 'images/profiles/user_40_20251112110005.jpeg');
INSERT INTO `usuarios` VALUES ('47', 'changuito', 'zeballos', '382', '', 'bocajuniors', '123gorra', '0', '0', null, 'usuario', null);
INSERT INTO `usuarios` VALUES ('50', 'Trico', 'Champ', '254', 'trico@gmail.com', 'trico', 'qnF9HY5KT=ZW', '0', '0', null, 'usuario', null);
INSERT INTO `usuarios` VALUES ('51', 'Lemon', 'Champ', '365', 'lemsh@gmail.com', 'lemoncry', 'mapa123', '0', '0', null, 'usuario', null);
INSERT INTO `usuarios` VALUES ('52', 'wally', 'elperro', '381', 'wally@gmail.com', 'wally', 'celular1', '0', '0', null, 'usuario', null);
INSERT INTO `usuarios` VALUES ('53', 'Felix', 'Nieva', '382', 'felix@gmail.com', 'felixhugo', 'dd5196c5571e72173f7419ea47751a15', '0', '0', null, 'usuario', null);
INSERT INTO `usuarios` VALUES ('54', 'Elber', 'Luna', '382', 'elber@gmail.com', 'elberluna', '962217f130c72be04d440686e9a21201', '0', '0', null, 'usuario', null);

-- ----------------------------
-- Table structure for usuarios_verificacion
-- ----------------------------
DROP TABLE IF EXISTS `usuarios_verificacion`;
CREATE TABLE `usuarios_verificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `codigo` varchar(16) NOT NULL,
  `expira` datetime NOT NULL,
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `intentos` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_user_ver` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ----------------------------
-- Records of usuarios_verificacion
-- ----------------------------
INSERT INTO `usuarios_verificacion` VALUES ('1', '48', 'martinchox33@gmail.com', '889301', '2025-11-15 18:26:44', '0', '0', '2025-11-14 18:26:44');
INSERT INTO `usuarios_verificacion` VALUES ('2', '49', 'martinchox33@gmail.com', '670422', '2025-11-15 19:10:23', '0', '1', '2025-11-14 19:10:23');

-- ----------------------------
-- View structure for vista_comisarias
-- ----------------------------
DROP VIEW IF EXISTS `vista_comisarias`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `vista_comisarias` AS select `comisarias`.`codigocomisaria` AS `codigocomisaria`,`comisarias`.`nrodetelefono` AS `nrodetelefono`,`comisarias`.`descripcion` AS `descripcion` from `comisarias` ; ;

-- ----------------------------
-- View structure for vista_expedientes
-- ----------------------------
DROP VIEW IF EXISTS `vista_expedientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `vista_expedientes` AS select `expedientes`.`idexpediente` AS `idexpediente`,`expedientes`.`dnidenunciante` AS `dnidenunciante`,`expedientes`.`denunciado` AS `denunciado`,`expedientes`.`causa` AS `causa`,`expedientes`.`medida` AS `medida`,`expedientes`.`fojas` AS `fojas`,`expedientes`.`librodeactas` AS `librodeactas`,`expedientes`.`codigocomisaria` AS `codigocomisaria`,`expedientes`.`numerodeexpediente` AS `numerodeexpediente`,`expedientes`.`numexpinstru` AS `numexpinstru`,`expedientes`.`fechadeentrada` AS `fechadeentrada`,`expedientes`.`fechadesalida` AS `fechadesalida` from `expedientes` ; ;

-- ----------------------------
-- View structure for vista_personas
-- ----------------------------
DROP VIEW IF EXISTS `vista_personas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `vista_personas` AS select `personas1`.`dnidenunciante` AS `dnidenunciante`,`personas1`.`nombre` AS `nombre`,`personas1`.`apellido` AS `apellido`,`personas1`.`genero` AS `genero`,`personas1`.`nombreabogado` AS `nombreabogado` from `personas1` ;
