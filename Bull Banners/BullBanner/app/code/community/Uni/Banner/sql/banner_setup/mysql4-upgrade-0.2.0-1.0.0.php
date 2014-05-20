<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Banner
 * @copyright  Copyright (c) 2010-2011 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

$installer = $this;
$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('uni_banner')};

DROP TABLE IF EXISTS {$this->getTable('uni_effectgroup')};
CREATE TABLE {$this->getTable('uni_effectgroup')} (
	effect_id SMALLINT(10) NOT NULL AUTO_INCREMENT,
	effect_name VARCHAR(60) NOT NULL,
	animate_number_active TEXT NULL,
	animate_number_out TEXT NULL,
	animate_number_over TEXT NULL,
	animation VARCHAR(50) NULL,
	auto_play VARCHAR(15) NULL,
	controls VARCHAR(15) NULL,
	controls_position VARCHAR(30) NULL,
	dots VARCHAR(15) NULL,	
	easing_default TEXT NULL,
	enable_navigation_keys VARCHAR(15) NULL,
	focus VARCHAR(15) NULL,
	focus_position VARCHAR(30) NULL,
	fullscreen VARCHAR(15) NULL,
	hide_tools VARCHAR(15) NULL,
	image_switched TEXT NULL,
	intervalo SMALLINT(10) NULL, 
	label VARCHAR(15) NULL,
	label_animation VARCHAR(30) NULL,
	mouse_out_button TEXT NULL,
	mouse_over_button TEXT NULL,
	navigation VARCHAR(15) NULL,
	numbers VARCHAR(15) NULL,
	numbers_align VARCHAR(30) NULL,
	on_load TEXT NULL,
	preview VARCHAR(15) NULL,
	progressbar VARCHAR(15) NULL,
	progressbar_css TEXT NULL,
	show_randomly VARCHAR(15) NULL,
	stop_over VARCHAR(15) NULL,
	theme VARCHAR(30) NULL,
	thumbs VARCHAR(15) NULL,
	velocity DECIMAL(5,1) NULL,
	width_label VARCHAR(15) NULL,
	width_animation VARCHAR(30) NULL,
	PRIMARY KEY (effect_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('uni_bannergroup')};
CREATE TABLE {$this->getTable('uni_bannergroup')} (
	group_id SMALLINT(10) NOT NULL AUTO_INCREMENT,
	effectgroup_fk SMALLINT(10) NOT NULL,
	group_name VARCHAR(60) NOT NULL,
	group_code VARCHAR(30) NOT NULL,
	width_container VARCHAR(15) NULL,
	width_banner VARCHAR(15) NULL,
	height_banner VARCHAR(15) NULL,
	background VARCHAR(15) NULL,
	filename VARCHAR(100) NULL,
	background_repeat VARCHAR(30) NULL,
	status SMALLINT(1),
	created_time DATETIME,
	updated_time DATETIME,
	PRIMARY KEY (group_id),
	FOREIGN KEY (effectgroup_fk) REFERENCES {$this->getTable('uni_effectgroup ')} (effect_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('uni_bannerimage')};
CREATE TABLE {$this->getTable('uni_bannerimage')} (
	image_id SMALLINT(10) NOT NULL AUTO_INCREMENT,
	entity_fk VARCHAR(60) NULL,
	group_fk SMALLINT(10) NULL,
	title VARCHAR(60) NOT NULL,
	filename VARCHAR(60) NULL,
	link TEXT NULL,
	link_target VARCHAR(15) NULL,
	sort_order SMALLINT(10) NOT NULL,
	description TEXT NULL,
	status SMALLINT(1) NOT NULL,
	created_time DATETIME,
	updated_time DATETIME,
	PRIMARY KEY (image_id),
	FOREIGN KEY (group_fk) REFERENCES {$this->getTable('uni_bannergroup')} (group_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

echo "<script>alert('Banco Instalado')</script>";
$installer->endSetup();
