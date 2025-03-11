<?php
$sql = array();

$sql[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."pocztapolskaen_order_set` (
            `id_order_set` int(11) unsigned NOT NULL auto_increment,
              `name` varchar(255) DEFAULT NULL,
              `active` tinyint(1) DEFAULT '0',
              `id_post_office` int(11) unsigned DEFAULT NULL,
              `post_date` date DEFAULT NULL,
              `id_en` int(11) NOT NULL,
              `id_envelope` int(11) DEFAULT NULL,
              `envelope_status` varchar(255) DEFAULT NULL,
              `date_add` datetime DEFAULT NULL,
              `date_upd` datetime DEFAULT NULL,
              PRIMARY KEY (`id_order_set`),
              INDEX `idx_id_en` (`id_en`),
              INDEX `idx_id_post_office` (`id_post_office`)
              
            ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";

$sql[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."pocztapolskaen_post_office` (
            `id_post_office` int(11) unsigned NOT NULL auto_increment,
              `id_en` int(11) DEFAULT NULL,
              `name` varchar(255) DEFAULT NULL,
              `description` text,
              `date_add` datetime DEFAULT NULL,
              `date_upd` datetime DEFAULT NULL,
              PRIMARY KEY (`id_post_office`)
            ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";

$sql[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."pocztapolskaen_order` (
                `id_pp_order` int(11) unsigned NOT NULL auto_increment,
                `id_order` int(11) unsigned DEFAULT NULL,
                `id_cart` int(11) unsigned DEFAULT NULL,
                `id_shipment` varchar(255) DEFAULT NULL,
                `shipment_number` varchar(255) DEFAULT NULL,
                `shipment_type` varchar(255) DEFAULT NULL,
                `point` varchar(255) DEFAULT NULL,
                `pni` int(11) unsigned DEFAULT NULL,
                `cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
                `id_buffor` int(11) DEFAULT NULL,
                `post_date` date DEFAULT NULL,
                `send_date` datetime DEFAULT NULL,
                `date_add` datetime DEFAULT NULL,
                `date_upd` datetime DEFAULT NULL,
                `id_carrier` int(11) unsigned DEFAULT NULL,
                `attributes` TEXT NULL DEFAULT NULL,
              PRIMARY KEY (`id_pp_order`),
              INDEX `idx_id_order` (`id_order`),
              INDEX `idx_id_bufor` (`id_buffor`)
           ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";

$sql[] = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."pocztapolskaen_profile_address` (
              `id_profile_address` int(11) unsigned NOT NULL auto_increment,
              `id_en` int(11) DEFAULT NULL,
              `name` varchar(255) DEFAULT NULL,
              `friendly_name` varchar(255) DEFAULT NULL,
              `street` varchar(255) DEFAULT NULL,
              `house_number` varchar(128) DEFAULT NULL,
              `premises_number` varchar(128) DEFAULT NULL,
              `city` varchar(255) DEFAULT NULL,
              `postal_code` varchar(8) DEFAULT NULL,
              `date_add` datetime DEFAULT NULL,
              `date_upd` datetime DEFAULT NULL,
              PRIMARY KEY (`id_profile_address`)
            ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8";


foreach ($sql as $query)
    if (Db::getInstance()->execute($query) == false)
        return false;
