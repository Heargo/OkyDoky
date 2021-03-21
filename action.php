<?php

$ROUTES->bound_post("/document/new", 'upload_document')
       ->bound_post("/document/del", 'delete_document')
       ->bound_post('/signin', 'signin', ['login', 'password'])
       ->bound_post('/signup', 'signup', ['nickname', 'email', 'password'])
       ->bound_post('/createCommunity','create_community',['name','description'])

       ->bound_post("/ajax/community/current", 'set_community', ['id'])
;
