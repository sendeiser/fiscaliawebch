-- Script para implementar el sistema de control de intentos de inicio de sesión

-- Modificar la tabla de usuarios para agregar campos de control de intentos
ALTER TABLE `usuarios` 
ADD COLUMN `intentos_fallidos` INT DEFAULT 0,
ADD COLUMN `bloqueado` TINYINT(1) DEFAULT 0,
ADD COLUMN `fecha_bloqueo` DATETIME DEFAULT NULL,
ADD COLUMN `rol` ENUM('usuario', 'administrador') DEFAULT 'usuario';

-- Crear tabla para registrar historial de intentos de acceso
CREATE TABLE IF NOT EXISTS `historial_accesos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `fecha_hora` DATETIME NOT NULL,
  `ip` VARCHAR(45) NOT NULL,
  `exitoso` TINYINT(1) NOT NULL,
  `detalles` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_historial_usuario_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_historial_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuarios` (`idusuarios`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- Crear tabla de auditoría si no existe
CREATE TABLE IF NOT EXISTS `auditoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tabla_afectada` VARCHAR(50) NOT NULL,
  `operacion` VARCHAR(50) NOT NULL,
  `fecha` DATE NOT NULL,
  `hora` TIME NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `num_expediente` INT NULL,
  `detalles` TEXT NULL,
  PRIMARY KEY (`id`)
);

-- Actualizar usuarios existentes para asignar rol de administrador al primer usuario
UPDATE `usuarios` SET `rol` = 'administrador' WHERE `idusuarios` = 38;