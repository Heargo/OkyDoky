<?php 
$n=$user->nickname();
$url=Routes::url_for("/user/$n");
?>
<div class="profilPreviewSearch cursor" onclick="location.href='<?=$url?>'">
	<img class="pictprofilPreviewSearch" src="<?=$user->profile_pic()?>" alt="<?=$user->display_name()?>">
	<div>
		<h4 class="nameSearchPreview"><?=$user->display_name()?></h4>
		<h4 class="nicknameSearchPreview">@<?=$user->nickname()?></h4>
	</div>
</div>