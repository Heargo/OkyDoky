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
       ->bound_post('/ajax/hp','send_highlight_post')
       ->bound_post('/ajax/ac','send_admin_container')
       ->bound_post("/modify-user-profil", 'modify_profil')
       ->bound_post('/c/(?<comm>[\w|-]+)/post/(?<id>\w+)/new', 'add_comment', ['commentaire'])
       
;
