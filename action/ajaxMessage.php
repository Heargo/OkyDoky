<?php 


function affichemsg($msg){

	
	$sender=$msg->sender();
	$text=htmlspecialchars_decode($msg->msg());
	$date=$msg->send_date();
	$id=$msg->id();
	if ($sender->id()==User::current()->id()) {
		$class="left";
	}else{
		$class="";
	}

	?>
	<div id="<?=$id?>" class="msg <?=$class?>" data-date="<?=$date?>">
				<p><?=$text?></p>
	</div>
	<?php 
}



function sendMsgAjax(?array $match){
	if (!empty(trim($_POST["msg"]))) {
		$msg = htmlspecialchars($_POST["msg"]);
		$id=$GLOBALS['messages']->sendMsg($msg);
		$msgobj=$GLOBALS['messages']->get_by_id($id);
		affichemsg($msgobj);
	}
	
}
function checkMsgAjax(?array $match){
	$date=date("Y-m-d H:i:s", strtotime($_POST["lastMessage"]));
	//var_dump($date);
	$allmsgs=$GLOBALS['messages']->load_last_since($date);
	foreach ($allmsgs as $key => $msg) {
		affichemsg($msg);
	}
}