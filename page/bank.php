<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
  <link rel="stylesheet" href="<?=Routes::url_for('/styles/styleApp.css')?>">
</head>
<body>

<?php include 'topnav.php'; ?>



<?php
//on vérifie si on a des commu 
$user = User::current();
$communities = $user->get_communities();
if (!sizeof($communities)>0){
	?>
	<p>Aucune communauté rejointe ! rejoignez un communauté pour avoir accès a vos jetons</p>
	<?php
}else{
?>
	<?php 
	$can_collect =$user->can_collect_daily_coins_at_least_one();
	?>

	<!-- bouton pour recup ses jetons -->
	<?php if($can_collect): ?>
		<form class="collectForm" enctype="multipart/form-data" action="<?=Routes::url_for('/dailies/collect_all')?>" method="post">
			<label for="collect" class="collectJeton animate2 cursor">Collect<img src="<?=Routes::url_for('/img/svg/coin.svg')?>"></label>
			<input id="collect" type="submit" name="collect" hidden>
		</form>
	<?php endif; ?>	

	<div class="bankIntro">
		<img class="vaultImg" src="<?=Routes::url_for('/img/svg/bank.svg')?>">
	</div>

	<?php if($can_collect): ?>
		<p class="jetondescription">Les jetons vous permettent d'apporter plus de soutient à un utilisateur que via des likes. Vous obtenez 5 jetons par jour lorsque vous connectez sur cette page. Les jetons sont liés a la communauté. Vous pouvez aussi échanger des jeton pour de l'expérience !</p>
	<?php else: ?>
		<section id="verticalScrollContainer" class="inbank">
			<!-- nombre de jetons -->
			<div class="numberJetonsContainer">
				<p id="numberOfJeton">0</p>
				<img class="coinIcon noselect" src="<?=Routes::url_for("/img/svg/coin.svg")?>" alt="bank">
			</div>

			<form enctype="multipart/form-data" action="<?= Routes::url_for("/dailies/convert_coins")?>" method="post">
			
			<!-- selection de la communauté -->
			<select id="communitySelected" class="inbank" name="community">
				<?php 
				foreach($communities as $comm){
					$currentXpPoint = $user->level_in_community($comm)[1];
					$xpToNextLevel = User::hmptlvlup($user->level_in_community($comm)[0]);
					$prctCurrentXp= $currentXpPoint / $xpToNextLevel *100;
					$nbjetons = $user->coins_in_community($comm);
					if ($comm->id()==$_SESSION["current_community"]) {
						?>
						<option value='{"id":<?=$comm->id()?>,"nbjetons":<?=$nbjetons?>,"currentXpPoint":<?=$currentXpPoint?>,"xpToNextLevel":<?=$xpToNextLevel?>,"prctCurrentXp":<?=$prctCurrentXp?>}' selected><?=$comm->get_display_name()?></option>
						<?php
					}else{
						?>
						<option value='{"id":<?=$comm->id()?>,"nbjetons":<?=$nbjetons?>,"currentXpPoint":<?=$currentXpPoint?>,"xpToNextLevel":<?=$xpToNextLevel?>,"prctCurrentXp":<?=$prctCurrentXp?>}'><?=$comm->get_display_name()?></option>
						<?php
					}
					
				}
				?>
			</select>
			<!-- input jetons -->
			<div class="numberJetonsInputContainer">
				<input class="numberinput" id="number" name="nb_coins" type="number" min="0" max="<?=$nbjetons?>" step="1" value="0">
				<img class="coinIcon inbank noselect" src="<?=Routes::url_for("/img/svg/coin.svg")?>" alt="bank">
			</div>
			
			<!-- visualisation barre d'exp -->
			<div class="barreXP-T">
				<span id="infosXpNumber">
				</span>
				<div id="prctXp" class="XpFilled-T" style=""></div>
			</div>

			<!-- sumbit -->
			<input id ="submit" class="inbank" type="submit" value="Convertir en expérience"/>
		</form>
		</section>
		
	<?php endif; ?>

<?php
}
?>

<?php include 'bottomnav.php'; ?>
<?php include 'backgroundItems.php'; ?>
</body>
<script src="<?= Routes::url_for('/js/bank.js')?>"></script>
</html>
