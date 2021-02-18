<?php

function upload_document(?string $match) {
    $GLOBALS['docs']->add_document($_FILES["file"]);
}

function delete_document(?string $match) {
    $GLOBALS['docs']->del_document($_POST["id"]);
}

