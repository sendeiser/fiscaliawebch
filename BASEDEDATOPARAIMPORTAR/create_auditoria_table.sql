-- Tabla de auditoría para la base de datos fiscaliach
CREATE TABLE `auditoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tabla_afectada` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de la tabla que fue modificada',
  `operacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de operación: INSERT, UPDATE, DELETE',
  `fecha` date NOT NULL COMMENT 'Fecha de la operación',
  `hora` time NOT NULL COMMENT 'Hora de la operación',
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Usuario que realizó la operación',
  `num_expediente` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de expediente relacionado (si aplica)',
  `dni` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'DNI de la persona relacionada (si aplica)',
  `valores_anteriores` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Valores antes del cambio (para UPDATE y DELETE)',
  `valores_nuevos` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Valores después del cambio (para INSERT y UPDATE)',
  `ip_usuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Dirección IP del usuario',
  `timestamp_operacion` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp automático de la operación',
  PRIMARY KEY (`id`),
  INDEX `idx_tabla_afectada` (`tabla_afectada`),
  INDEX `idx_fecha` (`fecha`),
  INDEX `idx_usuario` (`usuario`),
  INDEX `idx_num_expediente` (`num_expediente`),
  INDEX `idx_dni` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de auditoría para registrar cambios en el sistema';