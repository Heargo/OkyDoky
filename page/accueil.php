<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/style.css')?>">
	<!-- style animation -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>

<nav>
	<a href="." class="top-left-name">OkyDoky</a>
	<a href="./login" class="l-sButton">Sign-up/Login</a>
</nav>
<svg class="bg-element-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#4bc0c8" d="M0,128L80,122.7C160,117,320,107,480,133.3C640,160,800,224,960,229.3C1120,235,1280,181,1360,154.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>	
</svg>

<div class="container">
	<h1 class="homeTitle">OkyDoky</h1>
	<h2 class="homeSlogan tracking-in-expand">Une nouvelle manière de <label class="multicolortext">partager</label></h2>
	<div class="box next">
		<div onclick="location.href='#us';" class="circle pointer"></div>
	<p onclick="location.href='#us';">Discover</p>
	</div>

</div>

<section id="us" class="container-infos">
	<div class="point-container">
		<div data-aos="fade-right" data-aos-delay="200" class="img" style="background-image:url('./img/community.png')"></div>
		<div data-aos="fade-up" data-aos-delay="200" class="img-desc">
			<h3>Créez votre communauté !</h3>
			<p>Etudiant, Fans de cuisine ou de science ? Créez la communauté qui vous resemble.</p>
			<svg class="bubble" xmlns="http://www.w3.org/2000/svg">
			<path fill="#42db75" d="M58.1,2.2C58.1,18.3,29,36.5,7.2,36.5C-14.5,36.5,-29.1,18.3,-29.1,2.2C-29.1,
			-13.8,-14.5,-27.5,7.2,-27.5C29,-27.5,58.1,-13.8,58.1,2.2Z" transform="translate(100,155) scale(3.2)"/>
			</svg>
		</div>	
		
	</div>
	<div class="reverse point-container ">
		<div data-aos="fade-left" data-aos-delay="400" class="img" style="background-image:url('./img/share.png')"></div>
		<div data-aos="fade-up" data-aos-delay="400" class="img-desc">
			<h3>Partagez vos documents !</h3>
			<p>Utilisez votre communauté pour partagez vos documents importants.</p>
			<svg class="bubble" xmlns="http://www.w3.org/2000/svg">
				<path fill="#4BC0C8" d="M32.6,-22.6C46.8,-8.2,66,5.6,64.4,15.7C62.9,25.7,40.6,31.9,19.8,42.4C-1,52.9,-20.3,67.6,-36.3,64.2C-52.2,60.8,-64.7,39.2,-67.8,17.8C-70.8,-3.7,-64.4,-24.9,-51.5,-39.1C-38.6,-53.2,-19.3,-60.1,-5.1,-56.1C9.2,-52.1,18.4,-37,32.6,-22.6Z" transform="translate(160 170) scale(2)" />
			</svg>
		</div>
	</div>

	<div class="point-container">
		<div data-aos="fade-right" data-aos-delay="200" class="img" style="background-image:url('./img/speak.png')"></div>
		<div data-aos="fade-up" data-aos-delay="200" class="img-desc">
			<h3>Echangez avec les autres membres !</h3>
			<p>Réagissez et posez des questions aux autres membres !</p>
			<svg class="bubble" xmlns="http://www.w3.org/2000/svg">
			  <path fill="#FEAC5E" d="M65.9,-22.5C72.2,-2.3,54.8,24.6,31.3,41.1C7.9,57.7,-21.6,64,-39.4,51.7C-57.3,39.4,-63.4,8.4,-54.9,-15C-46.4,-38.3,-23.2,-54.1,3.3,-55.1C29.9,-56.2,59.7,-42.7,65.9,-22.5Z" transform="translate(140 165) scale(2)" />
			</svg>
		</div>
	</div>
	
</section>
<div data-aos="zoom-in" data-aos-delay="400" class="container-join">
	<div class="box">
		<div onclick="location.href='./login';" class="circle pointer"></div>
		<p onclick="location.href='./login';">JOIN</p>
	</div>
</div>

</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</html>	
<!-- Uicons by <a href="https://www.flaticon.com/uicons" title="Flaticon">Flaticon</a> -->
<!-- Illustration by Freepik Storyset -->