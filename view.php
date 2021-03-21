<?php
$ROUTES->bound_get('/document', 'page/upload_document.php')
       ->bound_get('/', 'page/accueil.php')
       ->bound_get('/login', 'page/login.php')
       ->bound_get('/post', 'page/upload.php')
       ->bound_get('/createCommunity', 'page/createCommunity.php')
       ->bound_get('/feed', 'page/feed.php')
       ->bound_get('/top', 'page/top.php')
       ->bound_get('/search', 'page/search.php')
       ->bound_get('/community', 'page/community.php')
       ->bound_get('/confirmation', 'page/mailconfirmation.php')
       ->bound_get('/c/(\w+)/post/(\w+)', 'page/publication.php')
;
