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
					<label class="upVote cursor" for="upVoteInput-<?=$post->id()?>"><img src="./img/svg/arrow-up-green.svg"></label>
					<?php 
				}else{
					?>
					<label class="upVote cursor" for="upVoteInput-<?=$post->id()?>"><img src="./img/svg/arrow-up.svg"></label>
					<?php 
				}
				?>
				<input id="upVoteInput-<?=$post->id()?>" type="submit" form="upVote-<?=$post->id()?>" class="hidden"></input>


				<?php  
				if ($voted==-1){
					?>
					<label class="downVote cursor" for="downVoteInput-<?=$post->id()?>"><img src="./img/svg/arrow-down-orange.svg"></label>
					<?php 
				}else{
					?>
					<label class="downVote cursor" for="downVoteInput-<?=$post->id()?>"><img src="./img/svg/arrow-down.svg"></label>
					<?php 
				}
				?>
				<input id="downVoteInput-<?=$post->id()?>" type="submit" form="downVote-<?=$post->id()?>" class="hidden"></input>
				<?php 	
					if ($prct>50) {
						?><p class="prctQuality green"><?php 	
					}else{
						?><p class="prctQuality red"><?php 
					}
				 ?>
				<?= $prct ?></p>

				<form id="upVote-<?=$post->id()?>" class="hidden" method="POST" action="<?= Routes::url_for('/voteU')?>">
					<input type="hidden" name="idpost" value="<?=$post->id()?>">
				</form>


				<form id="downVote-<?=$post->id()?>" class="hidden"  method="POST" action="<?= Routes::url_for('/voteD')?>">
					<input type="hidden" name="idpost" value="<?=$post->id()?>">
				</form>
				<!-- <a href="#"><img src="./img/svg/like.svg"></a>
				<p>12</p> -->
			</div>
			<div class="right">
				<a href="#"><img src="./img/svg/share.svg"></a>
				<a href="#"><img src="./img/svg/bookmark.svg"></a>
			</div>
			
		</div>
	</div>
