/*
* CJT Database Version 1.2 structure.
*
* Owner: css-javascript-toolbox.com
* Author: Ahmed Said
* Date: 
* Description: 
*/

/* 
* CJT Backups Header Table Structure.
* Since: 2.0
*/
CREATE TABLE IF NOT EXISTS `#__cjtoolbox_backups` 
(
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'blocks',
  `owner` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

/*
* Blocks Table Structure!
* Since: 2.0
*/
CREATE TABLE IF NOT EXISTS `#__cjtoolbox_blocks` 
(
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `owner` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `lastModified` datetime NOT NULL,
  `pinPoint` int(4) NOT NULL DEFAULT '0',
  `state` enum('active','inactive') DEFAULT 'inactive',
  `location` enum('header','footer') DEFAULT 'header',
  `links` text,
  `expressions` text,
  `type` enum('block','revision','metabox') DEFAULT 'block',
  `backupId` int(11) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `flag` int(4) NOT NULL DEFAULT '0',
  `masterFile` INT(4) NOT NULL DEFAULT '1',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`backupId`),
  KEY `pinPoint` (`pinPoint`,`state`,`location`,`type`,`parent`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

/*
* Blocks Table Structure!
* Since: 1.5
*/
CREATE TABLE IF NOT EXISTS `#__cjtoolbox_block_files` 
(
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`blockId` INT(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL,
	`type` ENUM('css','javascript','php','html') NULL DEFAULT NULL,
	`description` VARCHAR(400) NULL DEFAULT NULL,
	`code` LONGTEXT NULL,
	`order` SMALLINT(6) NULL DEFAULT '0',
	`tag` TEXT NULL,
	PRIMARY KEY (`id`, `blockId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;


/*
* Blocks Pins table Structure!
* Since: 2.0
*/
CREATE TABLE IF NOT EXISTS `#__cjtoolbox_block_pins` 
(
  `blockId` int(11) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `value` int(11) NOT NULL,
  `attributes` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blockId`,`pin`,`value`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

/* DB Version 1.3 */
/* <Shortcode Parameters Tables> */
CREATE TABLE IF NOT EXISTS `#__cjtoolbox_forms` 
(
  `blockId` int(11) NOT NULL COMMENT 'block to be associated with the form',
  `name` varchar(100) NOT NULL COMMENT 'Form name/title',
  `groupType` varchar(20) NOT NULL COMMENT 'parameters gooup type (tab, accordion, etc...)',
  PRIMARY KEY (`blockId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cjtoolbox_form_groups` 
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formId` int(11) NOT NULL COMMENT 'block to be associated with the form',
  `name` varchar(100) NOT NULL COMMENT 'group name/title',
  `description` text NULL COMMENT 'Parameters group description',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 3` (`formId`,`name`),
  KEY `formId` (`formId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cjtoolbox_form_group_parameters` 
(
  `groupId` int(11) NOT NULL AUTO_INCREMENT,
  `parameterId` int(11) NOT NULL COMMENT 'block to be associated with the form',
  `renderer` varchar(30) DEFAULT NULL,
  `description` text NULL,
  `helpText` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`parameterId`),
  KEY `Index 2` (`groupId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cjtoolbox_parameters` 
(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'paramter unique identifier',
  `blockId` int(11) unsigned NOT NULL,
  `parent` int(11) unsigned DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `type` varchar(20) NOT NULL,
  `defaultValue` text,
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`contentParam` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name` (`name`, `parent`, `blockId`),
  KEY `parent` (`parent`),
  KEY `blockId` (`blockId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cjtoolbox_parameter_typedef` 
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parameterId` int(11) NOT NULL,
  `text` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parameterId` (`parameterId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__cjtoolbox_parameter_typeparams` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`parameterId` INT(11) NOT NULL,
	`name` TEXT NOT NULL,
	`value` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `parameterId` (`parameterId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;

/* 1.4 */
CREATE TABLE IF NOT EXISTS `#__cjtoolbox_form_group_xfields` (
	`groupId` INT(11) NOT NULL,
	`text` TEXT NULL,
	UNIQUE INDEX `groupId` (`groupId`)
) CHARACTER SET = utf8, COLLATE=utf8_general_ci;