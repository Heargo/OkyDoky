<?php

function upload_document() {
    if (isset($_POST["action"]) && $_POST["action"] == "upload_document") {
        global $DOCS;
        $DOCS->add_document($_FILES["file"]);
        header("Location: .");
    }
}
upload_document();

function delete_document() {
    if (isset($_POST["action"]) && $_POST["action"] == "delete_document") {
        global $DOCS;
        $DOCS->del_document($_POST["id"]);
        header("Location: .");
    }
}
delete_document();

