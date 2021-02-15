<?php

include "action/documents.php";

$ROUTES->bound_post("/document/new", 'upload_document', 'upload_document')
       ->bound_post("/document/del", 'delete_document', 'delete_document')
;
