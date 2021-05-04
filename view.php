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
       ->bound_get('/profil', 'page/profil.php')
       ->bound_get('/profil-edit', 'page/modify.php')
       ->bound_get("/disconnect", 'page/disconnect.php')
       ->bound_get('/c/(?<comm>[\w|-]+)/post/(?<id>\w+)', 'page/publication.php', 'format_publication')
       ->bound_get('/user/(?<user>[\w|-]+)','page/profil.php','get_user_from_link_profil')
       ->bound_get('/verify/(?<user>[\w|-]+)/(?<token>\w+)', 'page/verify.php', 'verify_user_email')
       ->bound_get('/confirmation', 'page/mailconfirmation.php')
       ->bound_get('/modify-community', 'page/modifyCommunity.php')
       ->bound_get('/panel-admin', 'page/panelAdmin.php')
       ->bound_get('/404', 'page/404.php')
       ->bound_get('/bank', 'page/bank.php')
       ->bound_get('/friends', 'page/friends.php')
       ->bound_get('/notifications', 'page/notification.php')
;
