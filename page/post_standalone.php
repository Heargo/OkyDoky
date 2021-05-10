<?php 
$typeDocument = $post->get_documents()[0]->type();
?>
    <div class="postContainer" id="<?=$post->id()?>">

		<!-- user -->
		<div class="postEnTete">
			<?php $n=$publisher->nickname();
			$url=Routes::url_for("/user/$n");
			$comm = $post->community();
			$isAdminCommu=User::current()->perm($comm)->is(P::ADMIN);
			$canManage=$publisher==User::current() || $isAdminCommu;
			$postID=$post->id();

			//level src
			$badges = array("1-bleu",
						"1-rouge",
						"1-violet",
						"2-bleu",
						"2-rouge",
						"2-violet",
						"3-bleu",
						"3-rouge",
						"3-violet",
						"4-bleu",
						"4-rouge",
						"4-violet",
						"5-bleu",
						"5-rouge",
						"5-violet",
						"final");
			$level = $publisher->level_in_community($comm)[0];
			if ($level>32){
				$urlbadge = Routes::url_for("/img/svg/medals/final.svg");
			}else{
				$i =round($level/2)-1;
				$urlbadge = Routes::url_for("/img/svg/medals/".$badges[$i].".svg");
			}
			
			?>
			<div class="cliquable cursor" onclick="location.href='<?=$url?>'">
				<p><?php echo "<img src='$profile_pic' alt='profil'>"; ?></p>
				<div class="postEnTete2">
					<?php if($publisher->is_certified($comm)): ?>
						<img class="certifiedImgPost"src="https://img.icons8.com/nolan/64/approval.png">
					<?php endif ?>
					<div class="badgeformat fix">
						<img src="<?=$urlbadge?>" id="badgeIcon">
						<p id="badgeText" class="fix"><?=$level?></p>
					</div>
				</div>
				<p class="namePublisher"><?= $pName ?></p>
				
			</div>
			<!-- 3 points pour le post -->
			<?php if($canManage && !$isComment): ?>
	                <img onclick="toogleSettingsOfPost(<?=$postID?>);" class="cursor dotsForPost" src="<?= Routes::url_for('/img/svg/three-dots.svg')?>">
	                <ul id="Settings-<?=$postID?>" class="menuSettings hidden">
	                	<?php if($isAdminCommu): ?>
	                	<li class="cursor" onclick="set_highlight_post(<?=$postID?>)" >Mettre en avant</li>
	                	<?php endif ?>
	                	<li class="cursor" onclick="delete_post(<?=$postID?>)">Supprimer</li>
	                </ul>
	        <?php endif ?>
			<?php if($isComment): ?>
                    <img onclick="enableRestore();location.href='<?= Routes::url_for('/feed')?>'" class="cursor crossForPost" src="<?= Routes::url_for('/img/svg/cross.svg')?>">
	        <?php endif ?>
		</div>
		<!-- content -->
		<div class="content">
            <h4 class="postTitre"><?=$titrePost?></h4>

            <?php if($typeDocument == "image"): ?>
            	<img class="postimage" src='<?=$urlIMG?>' alt='content'>
            <?php elseif($typeDocument == "pdf"): ?>
				<div class="pdfDownloadButton">
					<img src="<?= Routes::url_for('/img/svg/pdf.svg')?>" alt="pdf">
					<?php 
					$url = $post->get_documents()[0]->url();
					$filename = $post->get_documents()[0]->filename();
					?>
					<a href="<?=$url?>" target="_blank"><?=$filename?></a>
					<a class="dlArrowA" href="<?=$url?>" download><img class="dlArrow" src="<?= Routes::url_for('/img/svg/arrow-download.svg')?>" alt="donwload pdf"></a>
					
				</div>
				<?php if(!$isComment): ?>
					<p class="descriptionInPreview"><?=$post->description()?></p>
				<?php endif ?>
			<?php elseif($typeDocument == "code"): ?>
				<?php 
				$url = $post->get_documents()[0]->url();
				$filename = $post->get_documents()[0]->filename();
				?>
				<pre style="width: 100%;max-height: 300px;" data-src="<?= Routes::url_for('/data/document/'.$filename)?>"></pre>
				<a class="dlbuttonForCode cursor" href="<?=$url?>" download>Download</a>
			<?php elseif($typeDocument == "autre"): ?>
				<div class="autreDownloadButton">
					<img src="<?= Routes::url_for('/img/svg/document-outline.svg')?>" alt="pdf">
					<?php 
					//nom du fichier
					$name = $filename = $post->get_documents()[0]->filename();
					//url du pdf 
					$url = $post->get_documents()[0]->url();
					?>
					<p><?=$name?></p>
					<a class="dlArrowA" href="<?=$url?>" download><img class="dlArrow" src="<?= Routes::url_for('/img/svg/arrow-download.svg')?>" alt="donwload pdf"></a>
					
				</div>
				<?php if(!$isComment): ?>
					<p class="descriptionInPreview"><?=$post->description()?></p>
				<?php endif ?>
            <?php endif ?>

		</div>
		<!-- reactions -->
		<div class="postReactions">
			<div class="left">
            <?php if(!$isComment): ?>
            <!-- commentaire -->
            <a href="<?=$urlComment?>" onclick="localStorage.setItem('restoreAnchor', <?=$post->id()?>);">
                <img src="<?= Routes::url_for('/img/svg/comment.svg')?>">
            </a>
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
				<?php if(!$isComment and $publisher!=User::current()): ?>
				<a href="<?=$urlComment?>" onclick="document.cookie='restoreAnchor=<?=$post->id()?>;SameSite=Lax;path=<?= Config::URL_SUBDIR(true) ?>'">
					<img class="soutenirButton cursor" src="<?= Routes::url_for('/img/svg/coin.svg')?>">
				</a>
				<?php endif ?>
                <button class="copy-to-clipboard cursor" data-clipboard-text="<?=Config::URL_ROOT(false) . $urlComment?>">
                    <img src="<?= Routes::url_for('/img/svg/share.svg')?>">
                    <img class="hidden" src="<?= Routes::url_for('/img/svg/check.svg')?>">
                </button>
                <a href="#"><img src="<?= Routes::url_for('/img/svg/bookmark.svg')?>"></a>
			</div>
			
		</div>
		<!-- form pour soutenir -->
		<?php if($isComment && $publisher!=User::current()): ?>
			<form class="donateForm" enctype="multipart/form-data" action="<?=Routes::url_for('/donatejetons')?>" method="post">
				<?php 
				$nbjetons = User::current()->coins_in_community($comm);
				?>
				<div>
					<input id="nbjetonstogive" type="number" name="number" class="numberinput" min="0" max="<?=$nbjetons?>">
					<input type="hidden" name="to" value="<?= $post->publisher()->id() ?>" />
					<input type="hidden" name="urlRedirect" value="/c/<?= $comm->get_name() ?>/post/<?= $post->id() ?>" />
					<input type="hidden" name="in" value="<?= $comm->id() ?>" />
					<img class="soutenirButton" src="<?=Routes::url_for('/img/svg/coin.svg')?>">
				</div>
				<label for="donate">Soutenir !</label>
				<input id="donate" type="submit" name="donate" value="donate" hidden>
				
			</form>
		<?php endif ?>
		<!-- descritpion -->
		<?php if($isComment): ?>
		<p class="postdescritp"><?=$description?></p>
		<?php endif ?>
	</div>



	
