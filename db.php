<?php

require_once("config.php");

$DB = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);

$document = Config::TABLE_DOCUMENT;
$user = Config::TABLE_USER;

$DB->query("
CREATE TABLE IF NOT EXISTS `$document` (
    `id_$document` int unsigned NOT NULL AUTO_INCREMENT,
    `type` enum('link','image','pdf') NOT NULL,
    `url` varchar(200) NULL,
    `path` varchar(200) NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `visible` tinyint(1) NOT NULL DEFAULT 0,

    PRIMARY KEY (`id_$document`)
);"
);

$DB->query("
CREATE TABLE IF NOT EXISTS `$user` (
    `id_$user` int unsigned NOT NULL AUTO_INCREMENT,
    `nickname` varchar(40) NOT NULL,
    `email` varchar(255) NULL,
    `display_name` varchar(100) NULL,
    `profile_picture` varchar(15) NOT NULL DEFAULT 'default.png',
    `description` tinytext NULL,
    `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `pwd_hash` varchar(255) NULL,
    `email_verified` tinyint(1) NOT NULL DEFAULT 0,
    
    PRIMARY KEY (`id_$user`),
    UNIQUE KEY `nickname` (`nickname`),
    UNIQUE KEY `email` (`email`)
);"
);

unset($document, $user);
