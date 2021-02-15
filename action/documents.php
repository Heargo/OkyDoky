<?php

function upload_document() {
    $GLOBALS['docs']->add_document($_FILES["file"]);
}

function delete_document() {
    $GLOBALS['docs']->del_document($_POST["id"]);
}

