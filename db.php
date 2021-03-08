<?php

require_once("config.php");

$DB = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);

$document = Config::TABLE_DOCUMENT;
$user = Config::TABLE_USER;
$community = Config::TABLE_COMMUNITY;
$resource = Config::TABLE_RESOURCE;
$post = Config::TABLE_POST;

$DB->query("SET FOREIGN_KEY_CHECKS = 0;");

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
    `email_token` varchar(255) NULL,
    `new_email` varchar(255) NULL,
    
    PRIMARY KEY (`id_$user`),
    UNIQUE KEY `nickname` (`nickname`),
    UNIQUE KEY `email` (`email`)
);"
);

$DB->query("
CREATE TABLE IF NOT EXISTS `$document` (
    `id_$document` int unsigned NOT NULL AUTO_INCREMENT,
    `post` int unsigned NULL,
    `type` enum('link','image','pdf') NOT NULL,
    `url` varchar(200) NULL,
    `path` varchar(200) NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `visible` tinyint(1) NOT NULL DEFAULT 0,

    PRIMARY KEY (`id_$document`),
    FOREIGN KEY (`post`) REFERENCES `$post`(`id_$post`)
);"
);

$DB->query("
CREATE TABLE IF NOT EXISTS `$post` (
    `id_$post` int unsigned NOT NULL AUTO_INCREMENT,
    `publisher` int unsigned NULL,
    `community` int unsigned NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `title` varchar(100) NOT NULL,
    `description` tinytext NULL,
    `visible` tinyint(1) NOT NULL DEFAULT 0,

    PRIMARY KEY (`id_$post`),
    FOREIGN KEY (`publisher`) REFERENCES `$user`(`id_$user`),
    FOREIGN KEY (`community`) REFERENCES `$community`(`id_$community`)
);"
);

$DB->query("
CREATE TABLE IF NOT EXISTS `$resource` (
    `id_$resource` int unsigned NOT NULL AUTO_INCREMENT,
    `url` varchar(200) NULL,
    `path` varchar(200) NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id_$resource`)
);"
);

$DB->query("
CREATE TABLE IF NOT EXISTS `$community` (
    `id_$community` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(40) NOT NULL,
    `display_name` varchar(100) NULL,
    `cover` int unsigned NULL,
    `description` tinytext NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `highlight_post` int unsigned NULL,
    `is_private` tinyint(1) NOT NULL DEFAULT 0,

    PRIMARY KEY (`id_$community`),
    FOREIGN KEY (`cover`) REFERENCES `$resource`(`id_$resource`),
    FOREIGN KEY (`highlight_post`) REFERENCES `$post`(`id_$post`),
    UNIQUE KEY `name` (`name`)
);"
);

$DB->query("SET FOREIGN_KEY_CHECKS = 1;");

unset($document, $user, $community, $resource, $post);

