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

<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script>
var current_community = "<?= $_SESSION['current_community'] ?>";
try {
    const shouldBeRestored = localStorage.getItem('shouldBeRestored');
    const community = localStorage.getItem('community');

    // localStorage only allow strings, not booleans
    if (shouldBeRestored === "true" && community === current_community) {
        var offset, posts;
        [offset, posts] = retrievePosts();
        OFFSET = offset; // that is because it's declared in feedAjax.js

        clearPosts(); // Clear posts of former use

        var posts_section = document.querySelector("section#verticalScrollContainer");
        posts.forEach( (row, index, array) => {
            var id = row[0];
            var html = row[1];
            IDS.push(id) // IDS is also declared in feedAjax.js
            addPostToContainer(html, posts_section, id); // Adding post in page also save them in cache
        });

        localStorage.setItem('shouldBeRestored', "false");

        // get back where we were
        const anchor = localStorage.getItem('restoreAnchor');
        try {
            document.getElementById(anchor).scrollIntoView();
        } catch {
            //ignore
        }
        console.log("Posts restored!");
    } else {
        // Just to be sure
        localStorage.setItem('shouldBeRestored', "false");
        localStorage.setItem('community', current_community);
        clearPosts();
    }
    
} catch(e) {
    localStorage.setItem('shouldBeRestored', "false");
    localStorage.setItem('community', current_community);
    clearPosts();
}
</script>
<script type="text/javascript">
    var page = "feed";
    var user = -1;
    var comm = -1;
    var route = "<?=Config::URL_SUBDIR(false)?>";
</script>
<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/favoris.js')?>"></script>
<script src="<?= Routes::url_for('/js/post.js')?>"></script>
</html>
