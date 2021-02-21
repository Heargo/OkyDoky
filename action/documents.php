<?php

function upload_document(?array $match) {
    $GLOBALS['docs']->add_document($_FILES["file"]);
    header('Location: /');
}

function delete_document(?array $match) {
    $GLOBALS['docs']->del_document($_POST["id"]);
    header('Location: /');
}

