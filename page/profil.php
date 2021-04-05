  <meta charset="UTF-8">
  <link rel="stylesheet" href="<?= Routes::url_for('/styles/styleProfil.css')?>">
  <link rel="stylesheet" href="<?= Routes::url_for('/styles/styleApp.css')?>">
  <link rel="stylesheet" href="<?= Routes::url_for('/styles/style.css')?>">


<!-- FONCTIONS POUR AFFICHAGE DES PARAMETRES -->
<script type="text/javascript">
			function afficheparameter(){
				document.getElementById('pageparametres').style.display = 'block';
				document.getElementById('page').style.opacity = '0.2';

				//document.getElementById(pageparametres).style.displat = none;
			}

			function closeparametre(){
				document.getElementById('pageparametres').style.display = 'none';
				document.getElementById('page').style.opacity = '1';

			}
		</script>

<body>

<div class="topBar">
	<!-- MODIFIER URL POUR RETOUR ???? -->
		<a href="../">	<img src="https://img.icons8.com/fluent-systems-filled/48/000000/left.png" class="flecheretour"/>
		</a>
	<!-- AFFICHAGE DES FAVORIS -->
		<a href=""><img src="https://img.icons8.com/ios/50/000000/bookmark-ribbon--v2.png" name="favorilogo" class="logofavori"/></a>

	<!-- AFFICHAGE DES PARAMETRES -->
		<a href=javascript:void(0); onclick="afficheparameter()">
		<img src="https://img.icons8.com/ios/50/000000/settings--v1.png" class="logoparametre"/> </a>
		
		<div id="pageparametres" class="cadre">
			<a href=javascript:void(0); onclick="closeparametre()">
				<img src="https://img.icons8.com/windows/64/000000/macos-close.png"/>
			</a>

	<!-- DANS LES PARAMETRES ...  -->
			<div class="cadre">
				<a href=""> Changer mon mot de passe </a>
			</div>
			<div class="cadre">
				<a href=""> Déconnexion  </a>
			</div>
			<div class="cadre">
				<a href=""> Supprimer mon compte </a>
			</div>
		</div>

		
</div>
<div id="page">

<section id="verticalScrollContainer">
	<div class='hautprofil'>
		<div class="containerimgnom">
			<div class="imgprofiletmod">
				<div>
					<!-- IMG PROFIL -->
					<img class="pictprofil" src="<?= User::is_connected() ? User::current()->profile_pic() : "anonyme" ?>" alt="communauté">

				</div>
				<div>
					<!-- PARTIE MODIF A RETRAVAILLER  -->
					<p class="modiferprofil"> Modifier <img src="https://img.icons8.com/fluent/48/000000/pencil-tip.png"  style="width:15px;"/> </p>
				</div>

			</div>
			<div class="nomprofil">
				<div>
					<!-- VERIF SI LA PERS EST CERTIFIEE -->
					<!-- jointure avec table ?? -->
					<img class="logocertifier" src="https://img.icons8.com/nolan/64/approval.png"/>
				</div>


				<!--  NOM PROFIL -->
				<div>				
					<h2 class="nameprofil"><?= User::is_connected() ? User::current()->nickname() : "anonyme" ?></h2>
				</div> 
				
				<!-- RECUPERER LE ROLE  -->
				<div class="roleprofil">
					<p>Original</p>
				</div>
			</div>
		</div>

		<!-- RECUPERER LE NB DE POST ET DE PERS QUI LE SUIVENT -->
		<div class="cpts">
			<div class="cpt">
				<img src="https://img.icons8.com/windows/32/000000/person-male.png" class="logocptperso"/>
			</div>
			<div class="cpt">
				<p class="cptpers">cptpers</p>
			</div>
	
			<div class="cpt">
				<img src="https://img.icons8.com/pastel-glyph/64/000000/check-document--v1.png" class="logocptpost"/>	
			</div>
			<div class="cpt">		
				<p class="cptpost">cptposts</p>
			</div>
		</div>
		
		<!--  LA DESCRIPTION -->
		<div class='descrip'>
			<div class="cadre">
				<p> <?= User::is_connected() ? User::current()->description() : "anonyme" ?> </p>
			</div>
		</div>


<!-- RECUPERER LES COMMUNAUTES  -->
<div class="cadre">
	<div class="communitySelectorProfil">
    <div class="horizontal-scroll">
        <div onclick="switchFilter(1);console.log('filtre appliqué-1');">
            <img id="community-1" class="communityPreview-profil" src="../img/img3.jpg">
            <p id="label-1" label class="communityPreviewLabel-profil">Community 1</p>
            <img id="check-1" class="checkfilter hidden" src="../img/svg/checkwhite.svg">
        </div>
        <div onclick="switchFilter(2);console.log('filtre appliqué-2');">
            <img id="community-2" class="communityPreview-profil" src="../img/img2.jpg">
            <p id="label-2" class="communityPreviewLabel-profil">Community 2</p>
            <img id="check-2" class="checkfilter hidden" src="../img/svg/checkwhite.svg">
        </div>
        <div onclick="switchFilter(3);console.log('filtre appliqué-3');">
            <img id="community-3" class="communityPreview-profil" src="../img/pates.jpg">
            <p id="label-3" class="communityPreviewLabel-profil">Community 3</p>
            <img id="check-3" class="checkfilter hidden" src="../img/svg/checkwhite.svg">
        </div>
        <div onclick="switchFilter(4);console.log('filtre appliqué-3');">
            <img id="community-3" class="communityPreview-profil" src="../img/sport.jpg">
            <p id="label-3" class="communityPreviewLabel-profil">Community 4</p>
            <img id="check-3" class="checkfilter hidden" src="../img/svg/checkwhite.svg">
        </div>
    </div>

</div>

<script type="text/javascript">
	function switchFilter(n){
    //on toogle la visibilité du nom et du check
    var label = document.getElementById("label-"+n);
    label.classList.toggle("hide");
    var check = document.getElementById("check-"+n);
    check.classList.toggle("hidden");
    //l'opacité et le scroll du fond
    var toBlurry = document.getElementById("community-"+n);
    toBlurry.classList.toggle("blurryOverlayProfilFilter"); 
}</script>
</div>
	
	<div class="postprofil">
	<!-- POUR UNE PUBLICATION -->
	<?php include 'publication.php'; ?>

	<!-- 
		<div class="postImg">
			
			<div class="postEnTete">
				<a href="#"><img src="../img/img1.jpg" alt="profil"></a>
				<a href="#">Pseudo</a>
			</div>
			
			<div class="content">
				<img src="../img/img1.jpg" alt="content">
			</div>
			
			<div class="postReactions">
				<div class="left">
					<a href="#"><img src="../img/comment.svg"></a>
					<a href="#"><img src="../img/like.svg"></a>
					<p>12</p>
				</div>
				<div class="right">
					<a href="#"><img src="../img/share.svg"></a>
					<a href="#"><img src="../img/bookmark.svg"></a>
				</div>
				
			</div>
		</div> -->
	</div>
		
	</section>
</div>
</body>
