-- MySQL Script generated by MySQL Workbench
-- 03/09/17 15:29:01
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema hidroponia
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `hidroponia` ;

-- -----------------------------------------------------
-- Schema hidroponia
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `hidroponia` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs ;
USE `hidroponia` ;

-- -----------------------------------------------------
-- Table `hidroponia`.`empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`empresas` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`empresas` (
  `id` INT NOT NULL,
  `razao_social` VARCHAR(150) NULL,
  `nome` VARCHAR(100) NOT NULL,
  `cnpj` CHAR(18) NOT NULL,
  `inscricao_estadual` VARCHAR(21) NOT NULL,
  `endereco` VARCHAR(200) NOT NULL,
  `bairro` VARCHAR(60) NOT NULL,
  `cidade` VARCHAR(60) NOT NULL,
  `estado` VARCHAR(60) NOT NULL,
  `cep` VARCHAR(60) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `telefones` VARCHAR(100) NOT NULL,
  `responsavel` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `cnpj_UNIQUE` (`cnpj` ASC),
  UNIQUE INDEX `inscricao_estadual_UNIQUE` (`inscricao_estadual` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`reles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`reles` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`reles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `rele_pin` INT UNSIGNED NOT NULL,
  `rele_nome` VARCHAR(100) NOT NULL,
  `em_uso` TINYINT(1) NOT NULL,
  `estado` TINYINT(1) NOT NULL,
  `ultima_atualizacao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `empresas_id`),
  UNIQUE INDEX `relé_nome_UNIQUE` (`rele_nome` ASC),
  INDEX `fk_relés_Empresa1_idx` (`empresas_id` ASC),
  CONSTRAINT `fk_relés_Empresa1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`reles_registros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`reles_registros` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`reles_registros` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reles_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `reles_id`, `empresas_id`),
  INDEX `fk_relés_registros_relés1_idx` (`reles_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_relés_registros_relés1`
    FOREIGN KEY (`reles_id` , `empresas_id`)
    REFERENCES `hidroponia`.`reles` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`contas` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`contas` (
  `id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `primeiro_nome` VARCHAR(30) NOT NULL,
  `sobrenome` VARCHAR(70) NOT NULL,
  `tipo` ENUM('Administrador', 'Comprador', 'Operário') NOT NULL,
  `email` VARCHAR(100) NULL,
  `telefones` VARCHAR(100) NULL,
  `em_uso` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  UNIQUE INDEX `usuário_UNIQUE` (`usuario` ASC),
  INDEX `fk_contas_Empresa1_idx` (`empresas_id` ASC),
  CONSTRAINT `fk_contas_Empresa1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`ordens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`ordens` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`ordens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contas_id` INT NOT NULL,
  `reles_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `ordem` TINYINT(1) NOT NULL,
  `cumprida` TINYINT(1) NOT NULL DEFAULT 0,
  `envio` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `executada` TIMESTAMP NULL DEFAULT NULL,
  `processada` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`, `contas_id`, `reles_id`, `empresas_id`),
  INDEX `fk_ordens_contas1_idx` (`contas_id` ASC),
  INDEX `fk_ordens_relés1_idx` (`reles_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_ordens_contas1`
    FOREIGN KEY (`contas_id`)
    REFERENCES `hidroponia`.`contas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordens_relés1`
    FOREIGN KEY (`reles_id` , `empresas_id`)
    REFERENCES `hidroponia`.`reles` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`estatisticas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`estatisticas` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`estatisticas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `valor_padrao_min` DECIMAL(10,4) NOT NULL,
  `valor_padrao_max` DECIMAL(10,4) NOT NULL,
  `unidade_de_medida` VARCHAR(30) NOT NULL,
  `em_uso` TINYINT(1) NOT NULL,
  `pin` INT UNSIGNED NOT NULL,
  `variacao` DECIMAL(10,4) UNSIGNED NOT NULL,
  `leitura_codigo` VARCHAR(45) NOT NULL,
  `leitura_expressao` VARCHAR(450) NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  INDEX `fk_estatísticas_Empresa1_idx` (`empresas_id` ASC),
  CONSTRAINT `fk_estatísticas_Empresa1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`estatisticas_registros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`estatisticas_registros` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`estatisticas_registros` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `estatisticas_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` DECIMAL(10,4) NOT NULL,
  PRIMARY KEY (`id`, `estatisticas_id`, `empresas_id`),
  INDEX `fk_estatísticas_registros_estatísticas1_idx` (`estatisticas_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_estatísticas_registros_estatísticas1`
    FOREIGN KEY (`estatisticas_id` , `empresas_id`)
    REFERENCES `hidroponia`.`estatisticas` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`alternadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`alternadores` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`alternadores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reles_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `onTime` INT NOT NULL,
  `offTime` INT NOT NULL,
  PRIMARY KEY (`id`, `reles_id`, `empresas_id`),
  INDEX `fk_alternadores_relés1_idx` (`reles_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_alternadores_relés1`
    FOREIGN KEY (`reles_id` , `empresas_id`)
    REFERENCES `hidroponia`.`reles` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`temporizadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`temporizadores` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`temporizadores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reles_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `onTimePoints` VARCHAR(500) NOT NULL,
  `offTimePoints` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id`, `reles_id`, `empresas_id`),
  INDEX `fk_temporizadores_relés1_idx` (`reles_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_temporizadores_relés1`
    FOREIGN KEY (`reles_id` , `empresas_id`)
    REFERENCES `hidroponia`.`reles` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia`.`aplication_triggers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia`.`aplication_triggers` ;

CREATE TABLE IF NOT EXISTS `hidroponia`.`aplication_triggers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `trigger` VARCHAR(45) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `trigger_UNIQUE` (`trigger` ASC))
ENGINE = InnoDB;

USE `hidroponia` ;

-- -----------------------------------------------------
-- Placeholder table for view `hidroponia`.`ordens_pendentes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hidroponia`.`ordens_pendentes` (`id` INT, `empresas_id` INT, `contas_id` INT, `reles_id` INT, `rele_pin` INT, `rele_nome` INT, `ordem` INT, `cumprida` INT, `envio` INT, `executada` INT);

-- -----------------------------------------------------
-- View `hidroponia`.`ordens_pendentes`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `hidroponia`.`ordens_pendentes` ;
DROP TABLE IF EXISTS `hidroponia`.`ordens_pendentes`;
USE `hidroponia`;
CREATE  OR REPLACE VIEW `ordens_pendentes` AS
SELECT O.id, O.empresas_id, O.contas_id, O.reles_id, R.rele_pin, R.rele_nome, O.ordem, O.cumprida, O.envio, O.executada FROM `ordens` O
INNER JOIN `reles` R ON O.reles_id = R.id
WHERE !O.cumprida
ORDER BY O.envio ASC;
USE `hidroponia`;

DELIMITER $$

USE `hidroponia`$$
DROP TRIGGER IF EXISTS `hidroponia`.`reles_AFTER_INSERT` $$
USE `hidroponia`$$
CREATE DEFINER = CURRENT_USER TRIGGER `hidroponia`.`reles_AFTER_INSERT` AFTER INSERT ON `reles` FOR EACH ROW
BEGIN
	INSERT INTO `hidroponia`.`reles_registros`(`reles_id`, `empresas_id`, `estado`) VALUES (NEW.`id`, NEW.`empresas_id`, NEW.`estado`);
END$$


USE `hidroponia`$$
DROP TRIGGER IF EXISTS `hidroponia`.`reles_BEFORE_UPDATE` $$
USE `hidroponia`$$
CREATE DEFINER = CURRENT_USER TRIGGER `hidroponia`.`reles_BEFORE_UPDATE` BEFORE UPDATE ON `reles` FOR EACH ROW
BEGIN
	IF (NEW.`em_uso` = OLD.`em_uso`) THEN
		SET NEW.`ultima_atualizacao` = CURRENT_TIMESTAMP;
	END IF;
END$$


USE `hidroponia`$$
DROP TRIGGER IF EXISTS `hidroponia`.`reles_AFTER_UPDATE` $$
USE `hidroponia`$$
CREATE DEFINER = CURRENT_USER TRIGGER `hidroponia`.`reles_AFTER_UPDATE` AFTER UPDATE ON `reles` FOR EACH ROW
BEGIN
	IF (NEW.`estado` != OLD.`estado`) THEN
		INSERT INTO `hidroponia`.`reles_registros`(`reles_id`, `empresas_id`, `estado`) VALUES (NEW.`id`, NEW.`empresas_id`, NEW.`estado`);
	END IF;
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `hidroponia`.`aplication_triggers`
-- -----------------------------------------------------
START TRANSACTION;
USE `hidroponia`;
INSERT INTO `hidroponia`.`aplication_triggers` (`id`, `trigger`, `active`) VALUES (DEFAULT, 'enviar_estatisticas', DEFAULT);
INSERT INTO `hidroponia`.`aplication_triggers` (`id`, `trigger`, `active`) VALUES (DEFAULT, 'enviar_reles', DEFAULT);
INSERT INTO `hidroponia`.`aplication_triggers` (`id`, `trigger`, `active`) VALUES (DEFAULT, 'reiniciar', DEFAULT);

COMMIT;

