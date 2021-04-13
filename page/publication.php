<!DOCTYPE html>
<html>
<head>
	<title>Post</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>


<section class="uniquePost">
<?php load_post($GLOBALS['page']['post'],true); ?>

<?php 
$r = Routes::url_for('/c/'. $GLOBALS['page']['post']->id_community()->get_name().'/post/'.$GLOBALS['page']['post']->id().'/new');
?>



<div class="commentaires">
	<div>
	<a href="#">
		<img class="comment-img" src="<?= User::current()->profile_pic() ?>" alt="profil">
	</a>
    <p class="comment">
        <form class="commentaire-form" enctype="multipart/form-data" action="<?=$r?>" method="post"> 
			<textarea class="commentaire-form-textarea" type="text" name="commentaire" placeholder="Ecrivez un commentaire"></textarea>
			<label class="submit-comm-label" for="submit-comment">
				<img src="<?=Routes::url_for('/img/svg/send.svg')?>">
			</label>
			<input class="hidden" type="submit" id="submit-comment" name="submit">
		</form>	
</div>

    <?php foreach($GLOBALS['page']['post']->comments() as $c){ ?>
	<div>
		<a href="#">
			<img class="comment-img" src="<?= $c->author()->profile_pic() ?>" alt="profil">
		</a>
        <p class="comment">
            <span class="comment-pseudo"><?= $c->author()->nickname()?></span>
            <?= $c->text() ?>
		<br>
		<span class="comment-like" >
            <img src="<?= Routes::url_for('/img/svg/like.svg') //handle red heart ?>">
            <?= $c->nb_likes() ?>
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
		
	</div>
    <?php } ?>
</div>
</section>


</body>
<script type="text/javascript">
	var route="<?=Config::URL_SUBDIR(false)?>";
</script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>

</html>
