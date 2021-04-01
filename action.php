<?php

$ROUTES->bound_post('/signin', 'signin', ['login', 'password'])
       ->bound_post('/signup', 'signup', ['nickname', 'email', 'password'])
       ->bound_post('/createCommunity','create_community',['name','description'])
       ->bound_post("/post/new", 'upload_post')
       ->bound_post("/voteU", 'voteU')
       ->bound_post("/voteD", 'voteD')
       ->bound_post("/ajax/community/current", 'set_community', ['id'])
       ->bound_post("/ajax/search", 'search', ['tosearch'])
       ->bound_post("/ajax/JoinOrLeave", 'JoinOrLeaveCommu', ['idCommu'])
       ->bound_post("/ajax/moreposts", 'more_posts', ['offset'])
;
