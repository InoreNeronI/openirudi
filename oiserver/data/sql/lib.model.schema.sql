
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- catalogue
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `catalogue`;


CREATE TABLE `catalogue`
(
	`cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) default '' NOT NULL,
	`source_lang` VARCHAR(100) default '',
	`target_lang` VARCHAR(100) default '',
	`date_created` DATETIME,
	`date_modified` DATETIME,
	`author` VARCHAR(255) default '',
	PRIMARY KEY (`cat_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- trans_unit
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `trans_unit`;


CREATE TABLE `trans_unit`
(
	`msg_id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`cat_id` INTEGER(11) default 1 NOT NULL,
	`id` VARCHAR(255),
	`source` TEXT  NOT NULL,
	`target` TEXT,
	`comments` TEXT,
	`date_added` DATETIME,
	`date_modified` DATETIME,
	`author` VARCHAR(255) default '',
	`translated` TINYINT default 0,
	PRIMARY KEY (`msg_id`),
	INDEX `trans_unit_FI_1` (`cat_id`),
	CONSTRAINT `trans_unit_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `type`;


CREATE TABLE `type`
(
	`id` SMALLINT  NOT NULL AUTO_INCREMENT,
	`type` VARCHAR(10)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- driver
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `driver`;


CREATE TABLE `driver`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`type_id` SMALLINT  NOT NULL,
	`vendor_id` VARCHAR(4)  NOT NULL,
	`device_id` VARCHAR(4)  NOT NULL,
	`class_type` VARCHAR(100),
	`name` TEXT,
	`date` DATE,
	`string` VARCHAR(255)  NOT NULL,
	`url` VARCHAR(255),
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `u_driver` (`string`),
	INDEX `driver_FI_1` (`type_id`),
	CONSTRAINT `driver_FK_1`
		FOREIGN KEY (`type_id`)
		REFERENCES `type` (`id`)
		ON DELETE CASCADE,
	INDEX `driver_FI_2` (`vendor_id`),
	CONSTRAINT `driver_FK_2`
		FOREIGN KEY (`vendor_id`)
		REFERENCES `vendor` (`code`)
		ON DELETE CASCADE,
	INDEX `driver_FI_3` (`device_id`),
	CONSTRAINT `driver_FK_3`
		FOREIGN KEY (`device_id`)
		REFERENCES `device` (`code`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- vendor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `vendor`;


CREATE TABLE `vendor`
(
	`code` VARCHAR(4)  NOT NULL,
	`type_id` SMALLINT  NOT NULL,
	`name` VARCHAR(255),
	PRIMARY KEY (`code`,`type_id`),
	INDEX `vendor_FI_1` (`type_id`),
	CONSTRAINT `vendor_FK_1`
		FOREIGN KEY (`type_id`)
		REFERENCES `type` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- device
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `device`;


CREATE TABLE `device`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`code` VARCHAR(4)  NOT NULL,
	`vendor_id` VARCHAR(4)  NOT NULL,
	`type_id` SMALLINT  NOT NULL,
	`name` TEXT,
	PRIMARY KEY (`id`),
	INDEX `I_referenced_driver_FK_3_1` (`code`),
	INDEX `device_FI_1` (`vendor_id`),
	CONSTRAINT `device_FK_1`
		FOREIGN KEY (`vendor_id`)
		REFERENCES `vendor` (`code`)
		ON DELETE CASCADE,
	INDEX `device_FI_2` (`type_id`),
	CONSTRAINT `device_FK_2`
		FOREIGN KEY (`type_id`)
		REFERENCES `type` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- subsys
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subsys`;


CREATE TABLE `subsys`
(
	`code` VARCHAR(8)  NOT NULL,
	`device_id` INTEGER  NOT NULL,
	`revision` VARCHAR(2) default '00' NOT NULL,
	`name` TEXT,
	PRIMARY KEY (`code`,`device_id`,`revision`),
	INDEX `subsys_FI_1` (`device_id`),
	CONSTRAINT `subsys_FK_1`
		FOREIGN KEY (`device_id`)
		REFERENCES `device` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- system
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `system`;


CREATE TABLE `system`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`driver_id` INTEGER  NOT NULL,
	`name` TEXT,
	PRIMARY KEY (`id`),
	INDEX `system_FI_1` (`driver_id`),
	CONSTRAINT `system_FK_1`
		FOREIGN KEY (`driver_id`)
		REFERENCES `driver` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- path
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `path`;


CREATE TABLE `path`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`driver_id` INTEGER  NOT NULL,
	`path` TEXT,
	PRIMARY KEY (`id`),
	INDEX `path_FI_1` (`driver_id`),
	CONSTRAINT `path_FK_1`
		FOREIGN KEY (`driver_id`)
		REFERENCES `driver` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- pack
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pack`;


CREATE TABLE `pack`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`path_id` INTEGER  NOT NULL,
	`name` TEXT,
	`version` VARCHAR(10),
	`release_date` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `pack_FI_1` (`path_id`),
	CONSTRAINT `pack_FK_1`
		FOREIGN KEY (`path_id`)
		REFERENCES `path` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- oiimages
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `oiimages`;


CREATE TABLE `oiimages`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ref` VARCHAR(50),
	`name` VARCHAR(50),
	`description` TEXT,
	`os` VARCHAR(50),
	`uuid` VARCHAR(50),
	`created_at` DATETIME,
	`partition_size` INTEGER(11),
	`partition_type` TINYINT(4)  NOT NULL,
	`filesystem_size` INTEGER(11),
	`filesystem_type` VARCHAR(50)  NOT NULL,
	`path` VARCHAR(250),
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- pc
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pc`;


CREATE TABLE `pc`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mac` VARCHAR(255),
	`hddid` VARCHAR(255),
	`name` VARCHAR(255)  NOT NULL,
	`ip` VARCHAR(20),
	`netmask` VARCHAR(20),
	`gateway` VARCHAR(20),
	`dns` VARCHAR(255),
	`pcgroup_id` INTEGER,
	`partitions` TEXT,
	PRIMARY KEY (`id`),
	INDEX `pc_FI_1` (`pcgroup_id`),
	CONSTRAINT `pc_FK_1`
		FOREIGN KEY (`pcgroup_id`)
		REFERENCES `pcgroup` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- pcgroup
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pcgroup`;


CREATE TABLE `pcgroup`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- my_task
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `my_task`;


CREATE TABLE `my_task`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`day` DATE,
	`hour` TIME,
	`associate` TINYINT default 0,
	`oiimages_id` INTEGER,
	`partition` VARCHAR(20),
	`pc_id` INTEGER,
	`is_imageset` TINYINT default 0,
	`imageset_id` INTEGER,
	`is_boot` TINYINT default 0,
	`disk` VARCHAR(20),
	PRIMARY KEY (`id`),
	INDEX `my_task_FI_1` (`oiimages_id`),
	CONSTRAINT `my_task_FK_1`
		FOREIGN KEY (`oiimages_id`)
		REFERENCES `oiimages` (`id`),
	INDEX `my_task_FI_2` (`pc_id`),
	CONSTRAINT `my_task_FK_2`
		FOREIGN KEY (`pc_id`)
		REFERENCES `pc` (`id`),
	INDEX `my_task_FI_3` (`imageset_id`),
	CONSTRAINT `my_task_FK_3`
		FOREIGN KEY (`imageset_id`)
		REFERENCES `imageset` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- imageset
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `imageset`;


CREATE TABLE `imageset`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- asign_imageset
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `asign_imageset`;


CREATE TABLE `asign_imageset`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`imageset_id` INTEGER,
	`oiimages_id` INTEGER,
	`size` FLOAT(11),
	`position` INTEGER(11),
	`color` VARCHAR(10),
	PRIMARY KEY (`id`),
	INDEX `asign_imageset_FI_1` (`imageset_id`),
	CONSTRAINT `asign_imageset_FK_1`
		FOREIGN KEY (`imageset_id`)
		REFERENCES `imageset` (`id`),
	INDEX `asign_imageset_FI_2` (`oiimages_id`),
	CONSTRAINT `asign_imageset_FK_2`
		FOREIGN KEY (`oiimages_id`)
		REFERENCES `oiimages` (`id`)
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
