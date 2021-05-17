<?php
function addFavori(?array $match) {
    $GLOBALS["favoris"]->createFavoris($GLOBALS["posts"]->get_by_id($_POST['idpost']));
}

function removeFavori(?array $match) {
    $GLOBALS["favoris"]->delete_fav($GLOBALS["favoris"]->get_by_post($GLOBALS["posts"]->get_by_id($_POST['idpost'])));
}