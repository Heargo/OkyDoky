    <div class="postImg" id="<?=$post->id()?>">
		<!-- user -->
		<div class="postEnTete">
			<?php $n=$publisher->nickname();
			$url=Routes::url_for("/user/$n");
			?>
			<div class="cliquable cursor" onclick="location.href='<?=$url?>'">
				<p><?php echo "<img src='$profile_pic' alt='profil'>"; ?></p>
				<p><?= $pName ?></p>
			</div>
			<?php if($isComment): ?>
	                <img onclick="location.href='<?= Routes::url_for('/feed')?>'" class="cursor crossForPost" src="<?= Routes::url_for('/img/svg/cross.svg')?>">
	        <?php endif ?>
			
		</div>
		<!-- content -->
		<div class="content">
            <?php if($isComment): ?>
            <h4 class="postTitre"><?=$titrePost?></h4>
            <?php endif ?>

            <img src='<?=$urlIMG?>' alt='content'>

            
		</div>
		<!-- reactions -->
		<div class="postReactions">
			<div class="left">
            <?php if(!$isComment): ?>
            <!-- commentaire -->
            <a href="<?=$urlComment?>"><img src="<?= Routes::url_for('/img/svg/comment.svg')?>"></a>
            <?php endif ?>

				<?php  
				if ($voted==1){
					?>
                    <img id="upVoteIcon-<?=$post->id()?>" class="upVote cursor" onclick="vote(<?=$post->id()?>,1);" src="<?= Routes::url_for('/img/svg/arrow-up-green.svg')?>">
					<?php 
				}else{
					?>
                    <img id="upVoteIcon-<?=$post->id()?>" class="upVote cursor" onclick="vote(<?=$post->id()?>,1);" src="<?= Routes::url_for('/img/svg/arrow-up.svg')?>">
					<?php 
				} 
				if ($voted==-1){
					?>
                    <img id="downVoteIcon-<?=$post->id()?>" class="downVote cursor" onclick="vote(<?=$post->id()?>,-1);" src="<?= Routes::url_for('/img/svg/arrow-down-orange.svg')?>">
					<?php 
				}else{
					?>
                    <img id="downVoteIcon-<?=$post->id()?>" class="downVote cursor" onclick="vote(<?=$post->id()?>,-1);" src="<?= Routes::url_for('/img/svg/arrow-down.svg')?>">
					<?php 
				}
					if ($prct>50) {
						?><p id="prctQualityText-<?=$post->id()?>" class="prctQuality green"><?php 	
					}else{
						?><p id="prctQualityText-<?=$post->id()?>" class="prctQuality red"><?php 
					}
					echo $prct != null ? $prct."%" : $prct;?>
					</p>

				<!-- <a href="#"><img src="./img/svg/like.svg"></a>
				<p>12</p> -->
			</div>
			<div class="right">
                <a href="#"><img src="<?= Routes::url_for('/img/svg/share.svg')?>"></a>
                <a href="#"><img src="<?= Routes::url_for('/img/svg/bookmark.svg')?>"></a>
			</div>
			
		</div>
		<!-- descritpion -->
		<?php if($isComment): ?>
		<p class="postdescritp"><?=$description?></p>
		<?php endif ?>
	</div>
