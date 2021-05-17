<?php

function is_url_comment_valid(int $id_post, string $name_comm) : bool {
    $post = $GLOBALS['posts']->get_by_id($id_post);

    // Post exists
    if (!isset($post)) {
        return false;
    }

    $comm = $post->community();
    
    // Post belongs to $comm
    if ($comm->get_name() != $name_comm) {
        return false;
    }

    return true;
}

function add_comment(?array $match) {

    if (!is_url_comment_valid((int) $match['id'], $match['comm'])) {
        header("Location: " . Config::URL_SUBDIR(false) . '/feed');
        return;
    }

    $post = $GLOBALS['posts']->get_by_id($match['id']);

    if (!empty(trim($_POST['commentaire']))){
        //Sanitize is done inside
        $c=$GLOBALS['comments']->add_comment(User::current(), $post, $_POST['commentaire']);
        $GLOBALS['notifications']->send_notif("commentaire", $post->publisher(),$post->community(),0,$c);

        if (User::current()->id() != $post->publisher()->id()) {
            /*give xp*/
            User::current()->add_points_in_community($post->community(), 3);
        }
        if($c!=null){
            $commentaireToLoad=$GLOBALS['comments']->get_by_id($c);
            load_comment($commentaireToLoad);
            //var_dump($n=$commentaireToLoad->author()->nickname());
        }
    }
}

function load_comment($c,$deleted=false){
    
    $n=$c->author()->nickname();
    $canManage=$c->author()==User::current();
    
    if($c->post()->community()->user_in(User::current())){
        $isAdminCommu=User::current()->perm($c->post()->community())->is(P::ADMIN);
    }else{
        $isAdminCommu=False;
    }
    $postID=$c->id();
    ?>
    <div class="commentaireAlone" id="com-<?=$postID?>">
        
        <a href="<?=Routes::url_for("/user/$n")?>">
            <img class="comment-img" src="<?= $c->author()->profile_pic() ?>" alt="profil">
        </a>
        <p class="comment">
            <span class="comment-pseudo"><?= $c->author()->nickname()?></span>
            <?= $c->text() ?>
        <br>
        <span class="comment-like" >
            <a class="cursor" onclick="like(<?= $c->id() ?>)"><img id="like_comment_<?=$c->id()?>" src="<?= $c->hasUserLiked(User::current()) ? Routes::url_for("/img/svg/heart-full.svg") : Routes::url_for("/img/svg/heart-empty.svg"); ?>"></a>
            <span id="nb_likes_comment_<?= $c->id(); ?>"><?= $c->nb_likes() ?></span>
            <i>
            <?php 
                $datetime1=date_create($c->date());
                $datetime2=date_create(date("Y-m-d H:i:s"));
                $interval = date_diff($datetime1, $datetime2);
                //années
                if ($interval->y>0){
                    //pluriel
                    if($interval->y>1){
                        echo($interval->format("%y ans"));
                    }
                    //singulier
                    else{
                        echo($interval->format("%y an"));
                    }
                }
                //mois
                elseif($interval->m>0){
                    echo($interval->format("%m mois"));
                }
                //jours
                elseif($interval->d>0){
                    //pluriel
                    if($interval->d>1){
                        echo($interval->format("%d jours"));
                    }
                    //singulier
                    else{
                        echo("hier");
                    }
                }
                //heures
                elseif($interval->h>0){
                    //pluriel
                    if($interval->h>1){
                        echo($interval->format("%h heures"));
                    }
                    //singulier
                    else{
                        echo($interval->format("%h heure"));
                    }
                }
                //minutes
                elseif($interval->i>0){
                    //pluriel
                    if($interval->i>1){
                        echo($interval->format("%i minutes"));
                    }
                    //singulier
                    else{
                        echo($interval->format("%i minute"));
                    }
                }
                //seconde
                elseif($interval->s>0){
                    echo($interval->format("%s secondes"));
                }
                
            ?>
            </i>
        </span>
        </p>
        <!-- ... for commentaire -->
        <?php if($canManage or $isAdminCommu): ?>
            <img onclick="toogleSettingsOfComm(<?=$postID?>);" class="cursor three-dots-comment" src="<?= Routes::url_for('/img/svg/three-dots.svg')?>">
            <ul id="Settings-<?=$postID?>" class="menuSettings menuSettingsCommentaire hidden">
                <?php if($deleted){ ?>
                     <li class="cursor" onclick="restore_comment(<?= $c->id() ?>)">Restaurer</li>
                <?php }else{ ?>
                    <li class="cursor" onclick="del_comment(<?= $c->id() ?>)">Supprimer</li>
                <?php } ?>
                
            </ul>
        <?php endif ?>
    </div>
    <?php 
}



