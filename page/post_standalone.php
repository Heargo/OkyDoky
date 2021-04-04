    <div class="postImg" id="<?=$post->id()?>">
		<!-- user -->
		<div class="postEnTete">
			<a href="#"><?php echo "<img src='$profile_pic' alt='profil'>"; ?></a>
			<a href="#"><?= $pName ?></a>
		</div>
		<!-- <div class="postTitre">
			<p>
				<?= $titrePost ?>
			</p>
		</div> -->
		<!-- content -->
		<div class="content">
			<?php 
			echo "<img src='$urlIMG' alt='content'>";
			?>
			
		</div>
		<!-- reactions -->
		<div class="postReactions">
			<div class="left">
				<a href="#"><img src="./img/svg/comment.svg"></a>

				<?php  
				if ($voted==1){
					?>
					<img id="upVoteIcon-<?=$post->id()?>" class="upVote cursor" onclick="vote(<?=$post->id()?>,1);" src="./img/svg/arrow-up-green.svg">
					<?php 
				}else{
					?>
					<img id="upVoteIcon-<?=$post->id()?>" class="upVote cursor" onclick="vote(<?=$post->id()?>,1);" src="./img/svg/arrow-up.svg">
					<?php 
				} 
				if ($voted==-1){
					?>
					<img id="downVoteIcon-<?=$post->id()?>" class="downVote cursor" onclick="vote(<?=$post->id()?>,-1);" src="./img/svg/arrow-down-orange.svg">
					<?php 
				}else{
					?>
					<img id="downVoteIcon-<?=$post->id()?>" class="downVote cursor" onclick="vote(<?=$post->id()?>,-1);" src="./img/svg/arrow-down.svg">
					<?php 
				}
					if ($prct>50) {
						?><p id="prctQualityText-<?=$post->id()?>" class="prctQuality green"><?php 	
					}else{
						?><p id="prctQualityText-<?=$post->id()?>" class="prctQuality red"><?php 
					}
					$prct ?>
					</p>

				<!-- <a href="#"><img src="./img/svg/like.svg"></a>
				<p>12</p> -->
			</div>
			<div class="right">
				<a href="#"><img src="./img/svg/share.svg"></a>
				<a href="#"><img src="./img/svg/bookmark.svg"></a>
			</div>
			
		</div>
	</div>
