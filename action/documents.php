<?php

function upload_document(?array $match) {
    $GLOBALS['docs']->add_document($_FILES["file"]);
    $root = Config::URL_SUBDIR();
    $root = empty($root) ? '/' : $root;
    header('Location: ' . $root . "feed");
}

function delete_document(?array $match) {
    $GLOBALS['docs']->del_document($_POST["id"]);
    $root = Config::URL_SUBDIR();
    $root = empty($root) ? '/' : $root;
    header('Location: ' . $root);
}

