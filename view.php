<?php
$ROUTES->bound_get('/document', 'page/upload_document.php')
       ->bound_get('/', 'page/accueil.php')
       ->bound_get('/login', 'page/login.php')
       ->bound_get('/post', 'page/upload.php')
       ->bound_get('/feed', 'page/feed.php')
;
