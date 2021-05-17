<?php 


function affichemsg($msg){

	
	$sender=$msg->sender();
	$text=htmlspecialchars_decode($msg->msg());
	$date=$msg->send_date();
	$id=$msg->id();
	$imgprofil = $sender->profile_pic();
	$n=$sender->nickname();
	$url=Routes::url_for("/user/$n");
	$me=($sender->id()==User::current()->id());
	$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
	$isOwner=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::OWNER);
	$candelete =$isAdmin || $isOwner|| $me;
	if ($me) {
		$class="left";
	}else{
		$class="";
	}
	if ($text=="Message supprimé") {
		$class2="delMSG";
	}else{
		$class2="";
	}

	?>
	<div id="<?=$id?>" class="msg <?=$class?>" data-date="<?=$date?>">
		<?php 
		if ($sender->id()!=User::current()->id()) {
			?><a href="<?=$url?>"><img src="<?=$imgprofil?>"></a><?php
		}
		?>
		<div class="msgContainerUnique">
			<?php 
			if ($sender->id()!=User::current()->id()) {
				?><label><?=$sender->display_name()?></label><?php
			}
			?>
			<p class="<?=$class2?>"><?=$text?></p>
			<label class="timeForMsg"><?=affichedate($date)?></label>
		</div>
		<?php if($candelete && $text!="Message supprimé"){?>
		<img onclick="delmsg(<?=$id?>)" class="crossForMessage" src="<?=Routes::url_for('/img/svg/cross.svg')?>">
		<?php } ?>
	</div>
	<?php 

}
function affichedate($date){
	$datetime1=date_create($date);
	$datetime2=date_create(date("Y-m-d H:i:s"));
	$interval = date_diff($datetime1, $datetime2);
	//années
    if ($interval->y>0){
        //pluriel
        if($interval->y>1){
            echo($interval->format("il y a %y ans"));
        }
        //singulier
        else{
            echo($interval->format("il y a %y an"));
        }
    }
    //mois
    elseif($interval->m>0){
        echo($interval->format("il y a %m mois"));
    }
    //jours
    elseif($interval->d>0){
        //pluriel
        if($interval->d>1){
            echo($interval->format("il y a %d jours"));
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
            echo($interval->format("il y a %h heures"));
        }
        //singulier
        else{
            echo($interval->format("il y a %h heure"));
        }
    }
    //minutes
    elseif($interval->i>0){
        //pluriel
        if($interval->i>5){
            echo($interval->format("il y a %i minutes"));
        }
    }
}

function sendMsgAjax(?array $match){
	if (!empty(trim($_POST["msg"]))) {
		$msg = htmlspecialchars($_POST["msg"]);
		$id=$GLOBALS['messages']->sendMsg($msg);
		$msgobj=$GLOBALS['messages']->get_by_id($id);
		affichemsg($msgobj);
	}
	
}

function delMsgAjax(?array $match){
	$msgobj=$GLOBALS['messages']->get_by_id($_POST["id"]);
	$sender=$msgobj->sender();
	$me=($sender->id()==User::current()->id());
	$isAdmin=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::ADMIN);
	$isOwner=User::current()->perm($GLOBALS['communities']->get_by_id($_SESSION['current_community']))->is(Permission::OWNER);
	$candelete =$isAdmin || $isOwner|| $me;
	if ($candelete){
		$bool = $GLOBALS['messages']->del_msg($msgobj);
		echo $bool;
	}
	
}

function checkMsgAjax(?array $match){
	$date=date("Y-m-d H:i:s", strtotime($_POST["lastMessage"]));
	//var_dump($date);	
	$allmsgs=$GLOBALS['messages']->load_last_since($date);
	$daydiff=gmdate("Y-m-d H:i:s", strtotime('yesterday'));
	foreach ($allmsgs as $key => $msg) {
		affichemsg($msg);
	}
}
function checkMsgModifAjax(?array $match){
	$msg=$GLOBALS['messages']->get_by_id($_POST["id"]);
	$text=htmlspecialchars_decode($msg->msg());
	$bool=($text=="Message supprimé");
	$res = array($bool,$text);
	$json = json_encode($res);
	echo $json;
}
