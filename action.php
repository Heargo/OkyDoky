<?php

$ROUTES->bound_post('/signin', 'signin', ['login', 'password'])
       ->bound_post('/signup', 'signup', ['nickname', 'email', 'password'])
       ->bound_post('/createCommunity','create_community',['name','description'])
       ->bound_post('/addLabel/(?<user>[\w|-]+)','add_label',['label_text','color'])
       ->bound_post('/delLabel','remove_label')
       ->bound_post('/getLabel','get_label')
       ->bound_post("/post/new", 'upload_post')
       ->bound_post("/post/delMA",'remove_PMA')
       ->bound_post("/voteU", 'voteU')
       ->bound_post("/voteD", 'voteD')
       ->bound_post("/ajax/community/current", 'set_community', ['id'])
       ->bound_post("/ajax/search/commu", 'searchCommu', ['tosearch'])
       ->bound_post("/ajax/search/post", 'searchPost', ['tosearch'])
       ->bound_post("/ajax/search/profil", 'searchProfil', ['tosearch'])
       ->bound_post("/ajax/JoinOrLeave", 'JoinOrLeaveCommu', ['idCommu'])
       ->bound_post("/ajax/moreposts", 'more_posts', ['offset'])
       ->bound_post('/ajax/hp','send_highlight_post')
       ->bound_post('/ajax/hpset','set_highlight_post')
       ->bound_post('/ajax/ac','send_admin_container')
       ->bound_post('/ajax/delpost','del_post')
       ->bound_post('/ajax/certify','certify_ajax')
       ->bound_post('/ajax/uncertify','uncertify_ajax')
       ->bound_post('/ajax/promote','promote_ajax')
       ->bound_post('/ajax/unpromote','unpromote_ajax')
       ->bound_post("/modify-user-profil", 'modify_profil')
       ->bound_post("/modify-user-email", 'modify_email')
       ->bound_post("/modify-user-password", 'modify_password')
       ->bound_post("/modify-community", 'modify_commu')
       ->bound_post('/c/(?<comm>[\w|-]+)/post/(?<id>\w+)/new', 'add_comment', ['commentaire'])
       ->bound_post('/c/(?<comm>[\w|-]+)/post/(?<id>\w+)/like', 'like', ['id_comment'])
       ->bound_post('/c/(?<comm>[\w|-]+)/post/(?<id>\w+)/delcomment','delete_comment',['id'])
;
