<?php

function get_user_from_link_profil(?array $match){
    if(!empty($match['user'])){
        $GLOBALS['page']['userOfUrl'] = $GLOBALS['users']->get_by_nickname($match['user']);
    }
    if(!isset($GLOBALS['page']['userOfUrl'])){
        $root = Config::URL_SUBDIR(false);
        header("Location: $root/404");
    }
}