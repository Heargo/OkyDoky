<!DOCTYPE html>
<html>
<head>
	<title>OkyDoky</title>
    <link rel="shortcut icon" href="<?= Routes::url_for('/img/favicon.ico')?>" type="image/x-icon" />
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' >
	<link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/styleApp.css')?>">
  <!-- prism -->
  <link rel="stylesheet" type="text/css" href="<?= Routes::url_for('/styles/prism.css')?>">


</head>
<body>

<?php include 'topnav.php'; ?>
<section id="verticalScrollContainer">

<?php // Posts are loaded on client side using moreposts ?>

</section>


<?php include 'bottomnav.php'; ?>
<?php include 'backgroundItems.php'; ?>
</body>

<script type="text/javascript">
    var current_community = "<?= $_SESSION['current_community'] ?>";
    var page = "feed";
    var user = -1;
    var comm = -1;
    var route = "<?=Config::URL_SUBDIR(false)?>";
</script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<script src="<?= Routes::url_for('/js/theCross.js')?>"></script>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script type="text/javascript">restore();</script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/post.js')?>"></script>
</html>
