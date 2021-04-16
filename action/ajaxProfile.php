<?php
function load_user(User $user) {
    include "page/user_standalone.php";
}


function searchProfil(?array $match){
    $allusers=$GLOBALS["users"]->search_user_by_nickname_or_display_name($_POST["tosearch"]);
    foreach ($allusers as $key => $user) {
        load_user($user); 
    }
}
