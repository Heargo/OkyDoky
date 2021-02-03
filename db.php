<?php

require_once("config.php");

$DB = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);

$document = Config::TABLE_DOCUMENT;

$DB->query("
CREATE TABLE IF NOT EXISTS `$document` (
    `id_$document` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `type` enum('link','image','pdf') NOT NULL,
    `url` varchar(200),
    `path` varchar(200),
    `visible` tinyint(1) NOT NULL,
    PRIMARY KEY (`id_$document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
);

unset($document);
