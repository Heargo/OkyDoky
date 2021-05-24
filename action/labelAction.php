<?php

function add_label(?array $match){
	if($_SESSION['current_community']>0){
		$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_POST['idcommu']))->is(Permission::ADMIN);
	}else{
		$isAdmin=false;
	}
	if($isAdmin){
	    $user = $GLOBALS['users']->get_by_nickname($match['user']);
	    $currentComm = $GLOBALS['communities']->get_by_id($_POST['idcommu']);
	    $r = $currentComm->set_label($user,$_POST['label_text'],$_POST['color']);
	}
	$root = Config::URL_SUBDIR(false);
	$nicknameUser = $user->nickname();
    header("Location: $root/user/$nicknameUser");
}

function remove_label(?array $match){
    $user = $GLOBALS['users']->get_by_nickname($_POST['user']);
    $currentComm = $GLOBALS['communities']->get_by_id($_POST['community']);
    $r = $currentComm->delete_label($_POST["idlabel"]);
    $root = Config::URL_SUBDIR(false);
    $nicknameUser = $user->nickname();
    header("Location: $root/user/$nicknameUser");
}

function get_label(?array $match){
    $user = $GLOBALS['users']->get_by_nickname($_POST['user']);
    if($GLOBALS["communities"]->get_by_id($_POST['community'])!=null){
    	$labels=$GLOBALS["communities"]->get_by_id($_POST['community'])->get_label($user);
	    $myprofil=User::current()->equals($user);
		$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_POST['community']))->is(Permission::ADMIN);;
		foreach ($labels as $key => $label) {
			?>
			<li id="label-<?=$label["id_label"]?>" style="background-color: <?=$label["color"]?> ;"><?=$label["label_name"]?> 
				<?php if($isAdmin || $myprofil ){ ?>
				<img onclick="deleteLabel(<?=$label["id_label"]?>,'<?=$user->nickname()?>',<?=$_POST['community']?>)" class="cursor" src="<?=Routes::url_for('/img/svg/cross.svg')?>">
				<?php } ?>
			</li>
			<?php 
		}
		/*<!-- addbutton -->*/
		if($isAdmin){
			?>
			<li onclick="toogleformlabel();" class="exceptionRoleProfil">
				<img src="<?=Routes::url_for('/img/svg/add-circle.svg')?>">
			</li>
			<?php 
		}
    }
    
}