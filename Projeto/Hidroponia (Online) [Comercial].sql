-- MySQL Script generated by MySQL Workbench
-- 01/25/17 18:48:29
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema hidroponia_online
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `hidroponia_online` ;

-- -----------------------------------------------------
-- Schema hidroponia_online
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `hidroponia_online` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs ;
USE `hidroponia_online` ;

-- -----------------------------------------------------
-- Table `hidroponia_online`.`empresas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`empresas` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`empresas` (
  `id` INT NOT NULL AUTO_INCREMENT,
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
-- Table `hidroponia_online`.`compradores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`compradores` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`compradores` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `primeiro_nome` VARCHAR(30) NOT NULL,
  `sobrenome` VARCHAR(70) NOT NULL,
  `email` VARCHAR(100) NULL,
  `telefones` VARCHAR(100) NULL,
  `nome_empresa` VARCHAR(100) NULL,
  `em_uso` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  INDEX `fk_compradores_empresas1_idx` (`empresas_id` ASC),
  CONSTRAINT `fk_compradores_empresas1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia_online`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`contas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`contas` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`contas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `senha` CHAR(32) NOT NULL,
  `tipo` ENUM('Administrador', 'Comprador', 'Operário') NOT NULL,
  `compradores_id` INT NULL,
  `primeiro_nome` VARCHAR(45) NOT NULL,
  `sobrenome` VARCHAR(70) NOT NULL,
  `email` VARCHAR(100) NULL,
  `telefones` VARCHAR(100) NULL,
  `em_uso` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  UNIQUE INDEX `usuário_UNIQUE` (`usuario` ASC),
  INDEX `fk_contas_Empresa1_idx` (`empresas_id` ASC),
  INDEX `fk_contas_compradores1_idx` (`compradores_id` ASC),
  CONSTRAINT `fk_contas_Empresa1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia_online`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_compradores1`
    FOREIGN KEY (`compradores_id`)
    REFERENCES `hidroponia_online`.`compradores` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`planos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`planos` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`planos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `estatisticas` INT UNSIGNED NOT NULL,
  `controles` INT UNSIGNED NOT NULL,
  `maquinas` INT UNSIGNED NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `tipo` ENUM('Anual', 'Mensal') NOT NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  INDEX `fk_Plano_Empresa1_idx` (`empresas_id` ASC),
  UNIQUE INDEX `empresas_id_UNIQUE` (`empresas_id` ASC),
  CONSTRAINT `fk_Plano_Empresa1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia_online`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`maquinas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`maquinas` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`maquinas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `descricao` VARCHAR(70) NOT NULL,
  `MAC` CHAR(17) NOT NULL,
  `servidor_conexao` VARCHAR(256) NOT NULL,
  `servidor_usuario` VARCHAR(100) NOT NULL,
  `servidor_senha` CHAR(32) NOT NULL,
  `em_uso` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  UNIQUE INDEX `MAC_UNIQUE` (`MAC` ASC),
  INDEX `fk_máquinas_empresas1_idx` (`empresas_id` ASC),
  CONSTRAINT `fk_máquinas_empresas1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia_online`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`produtos` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`produtos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `empresas_id` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `unidade_medida` VARCHAR(10) NOT NULL,
  `preco_unitario_padrao` DECIMAL(10,2) NOT NULL,
  `estoque` DECIMAL(10,2) UNSIGNED NOT NULL,
  `em_uso` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `empresas_id`),
  INDEX `fk_produtos_empresas1_idx` (`empresas_id` ASC),
  CONSTRAINT `fk_produtos_empresas1`
    FOREIGN KEY (`empresas_id`)
    REFERENCES `hidroponia_online`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`vendas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`vendas` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`vendas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `compradores_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `data` DATE NOT NULL,
  `total_de_produtos` DECIMAL(10,2) UNSIGNED NOT NULL,
  `total_de_perdas` DECIMAL(10,2) UNSIGNED NOT NULL,
  `receita` DECIMAL(10,2) NOT NULL,
  `pago` TINYINT(1) NOT NULL,
  `pagamento_data` DATE NULL,
  PRIMARY KEY (`id`, `compradores_id`, `empresas_id`),
  INDEX `fk_vendas_compradores1_idx` (`compradores_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_vendas_compradores1`
    FOREIGN KEY (`compradores_id` , `empresas_id`)
    REFERENCES `hidroponia_online`.`compradores` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`vendas_detalhes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`vendas_detalhes` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`vendas_detalhes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vendas_id` INT NOT NULL,
  `produtos_id` INT NOT NULL,
  `vendidos` DECIMAL(10,2) UNSIGNED NOT NULL,
  `perdidos` DECIMAL(10,2) UNSIGNED NOT NULL,
  `receita` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`, `vendas_id`, `produtos_id`),
  INDEX `fk_vendas_has_produtos_produtos1_idx` (`produtos_id` ASC),
  INDEX `fk_vendas_has_produtos_vendas1_idx` (`vendas_id` ASC),
  CONSTRAINT `fk_vendas_has_produtos_vendas1`
    FOREIGN KEY (`vendas_id`)
    REFERENCES `hidroponia_online`.`vendas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vendas_has_produtos_produtos1`
    FOREIGN KEY (`produtos_id`)
    REFERENCES `hidroponia_online`.`produtos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`pedidos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`pedidos` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `compradores_id` INT NOT NULL,
  `empresas_id` INT NOT NULL,
  `data` DATE NOT NULL,
  `total_de_produtos` DECIMAL(10,2) UNSIGNED NOT NULL,
  `receita` DECIMAL(10,2) NOT NULL,
  `aprovado` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`, `compradores_id`, `empresas_id`),
  INDEX `fk_pedidos_compradores1_idx` (`compradores_id` ASC, `empresas_id` ASC),
  CONSTRAINT `fk_pedidos_compradores1`
    FOREIGN KEY (`compradores_id` , `empresas_id`)
    REFERENCES `hidroponia_online`.`compradores` (`id` , `empresas_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`pedidos_detalhes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`pedidos_detalhes` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`pedidos_detalhes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pedidos_id` INT NOT NULL,
  `produtos_id` INT NOT NULL,
  `quantidade` DECIMAL(10,2) UNSIGNED NOT NULL,
  `receita` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`, `pedidos_id`, `produtos_id`),
  INDEX `fk_pedidos_has_produtos_produtos1_idx` (`produtos_id` ASC),
  INDEX `fk_pedidos_has_produtos_pedidos1_idx` (`pedidos_id` ASC),
  CONSTRAINT `fk_pedidos_has_produtos_pedidos1`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `hidroponia_online`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_has_produtos_produtos1`
    FOREIGN KEY (`produtos_id`)
    REFERENCES `hidroponia_online`.`produtos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hidroponia_online`.`leituras`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hidroponia_online`.`leituras` ;

CREATE TABLE IF NOT EXISTS `hidroponia_online`.`leituras` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(200) NOT NULL,
  `expressao` VARCHAR(450) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

USE `hidroponia_online`;

DELIMITER $$

USE `hidroponia_online`$$
DROP TRIGGER IF EXISTS `hidroponia_online`.`empresas_AFTER_INSERT` $$
USE `hidroponia_online`$$
CREATE DEFINER = CURRENT_USER TRIGGER `hidroponia_online`.`empresas_AFTER_INSERT` AFTER INSERT ON `empresas` FOR EACH ROW
BEGIN
	SET @usuario = "Admin";
	SELECT COUNT(*) INTO @count FROM `contas` WHERE `usuario` LIKE "Admin%";
    IF (@count > 0) THEN
		SET @usuario = CONCAT("Admin", @count + 1);
    END IF;
    
	INSERT INTO `hidroponia_online`.`contas`(`empresas_id`, `usuario`, `senha`, `tipo`, `primeiro_nome`, `sobrenome`, `em_uso`) VALUES (NEW.`id`, @usuario, MD5("admin1234"), "Administrador", "Administrador", "", TRUE);
END$$


USE `hidroponia_online`$$
DROP TRIGGER IF EXISTS `hidroponia_online`.`pedidos_AFTER_UPDATE` $$
USE `hidroponia_online`$$
CREATE DEFINER = CURRENT_USER TRIGGER `hidroponia_online`.`pedidos_AFTER_UPDATE` AFTER UPDATE ON `pedidos` FOR EACH ROW
BEGIN
	IF (NEW.`aprovado` AND !OLD.`aprovado`) THEN
		SET @venda_id = -1;
        INSERT INTO `vendas`(`compradores_id`, `empresas_id`, `data`, `total_de_produtos`, `total_de_perdas`, `receita`, `pago`) VALUES (NEW.`compradores_id`, NEW.`empresas_id`, NEW.`data`, NEW.`total_de_produtos`, 0, NEW.`receita`, FALSE);
        SELECT `id` INTO @venda_id FROM `vendas` WHERE `compradores_id` = NEW.`compradores_id` AND `receita` = NEW.`receita` ORDER BY `id` DESC LIMIT 1;
        
        IF (@venda_id != -1) THEN
			INSERT INTO `vendas_detalhes` (`vendas_id`, `produtos_id`, `vendidos`, `perdidos`, `receita`) SELECT @venda_id, `produtos_id`, `quantidade`, 0, `receita` FROM `pedidos_detalhes` WHERE `pedidos_id` = NEW.`id`;
        END IF;
    END IF;
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;