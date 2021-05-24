<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="<?= Routes::url_for('/img/favicon.ico')?>" type="image/x-icon" />
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
    <link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/style.css')?>">
</head>
<body>

<nav>
    <a href="<?=Routes::url_for('/');?>" class="top-left-name">OkyDoky</a>
</nav>
<svg class="bg-element-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#4bc0c8" d="M0,128L80,122.7C160,117,320,107,480,133.3C640,160,800,224,960,229.3C1120,235,1280,181,1360,154.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
</svg>

<div class="containerCGU">

	<h1>Politique de confidentialité et cookies</h1>
    <div>
    	<h2>À propos de OkyDoky</h2>
        <p>OkyDoky est un projet pédagogique créé dans le cadre d'un cours d'informatique à l'<a href="https://www.univ-smb.fr/">Université Savoie Mont-Blanc</a>.</p>
        <p>
        Ce projet est porté par les personnes suivantes :
            <ul class="team">
                <li><img src="<?=Routes::url_for('/img/devs/hugo.jpg');?>" alt="Hugo"><p>Hugo REY</p></li>
                <li><img src="<?=Routes::url_for('/img/devs/simon.jpg');?>" alt="Simon"><p>Simon LEONARD</p></li>
                <li><img src="<?=Routes::url_for('/img/devs/evan.jpg');?>" alt="Evan"><p>Evan L'HUISSIER</p></li>
                <li><img src="<?=Routes::url_for('/img/devs/romain.jpg');?>" alt="Romain"><p>Romain NEGRO</p></li>
                <li><img src="<?=Routes::url_for('/img/devs/juliette.jpg');?>" alt="Juliette"><p>Juliette NEYRAT</p></li>
            </ul>
        </p>
        <p>Le site web est hébergé et géré par Simon LEONARD, que vous pouvez contacter à l'adresse <a href='mailto:okydoky@sinux.sh'>okydoky@sinux.sh</a>.</p>

        <h2>Collecte des données</h2>
        <p>OkyDoky collecte des données personnelles :
            <ul class="ls">
                <li>lorsque vous créez un compte</li>
                <li>lorsque vous postez des documents, envoyez des messages à une communauté ou effectuez toute autre forme de participation sur le site.</li>
            </ul>
        </p>

        <h2>Où sont stockées vos données ?</h2>
        <p>
            Toutes les données d'OkyDoky sont stockées chez OVH, en France.
        </p>

        <h2>Comment puis-je suppimer mes données ?</h2>
        <p>
            Étant un projet universitaire sur quelques mois, il se peut que nous n'ayons pas pensé à toutes les réglementations.
            Si vous souhaitez voir, télécharger ou supprimer vos données, envoyez un mail à <a href='mailto:okydoky@sinux.sh'>okydoky@sinux.sh</a>.
        </p>

        <h2>Gestion des cookies</h2>
        <p>Touts les cookies utilisés par OkyDoky sont purement de l'ordre technique.
        Ils identifient de manière unique votre navigateur lorsque vous parcourez le site,
        et permettent d'identifier l'auteur (tel que vous vous êtes enregistré) lorsque vous intéragissez avec le site.</p>
        <p>Par conséquant, le seul cookie utilisé est PHPSESSID, un cookie propre à PHP.</p>
        <p>
        OkyDoky utilise aussi le <i>local storage</i> afin d'accélérer le chargement du site à travers un méchanisme de cache.
        Voici la liste des clés utilisées :
        <ul class="ls">
            <li>community</li>
            <li>offset</li>
            <li>posts</li>
            <li>restoreAnchor</li>
            <li>shouldBeRestored</li>
        </ul>
        </p>
    </div>
</div>


</body>
</html>
<!-- Uicons by <a href="https://www.flaticon.com/uicons" title="Flaticon">Flaticon</a> -->
<!-- Illustration by Freepik Storyset -->
