<?php

include "secret.php";

$DB = mysqli(Secret::DB_HOST, Secret::DB_USER, Secret::DB_PASSWORD, Secret::DB_NAME);

$DB->query("
CREATE TABLE IF NOT EXISTS `document` (
  `id_document` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('link','image','pdf') NOT NULL,
  `path` varchar(200) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
);

unset(Secret);
