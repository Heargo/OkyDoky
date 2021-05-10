<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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

    if (shouldBeRestored === "true" && community === current_community) {
        var offset, posts;
        [offset, posts] = retrievePosts();
        OFFSET = offset;

        clearPosts(); // Clear posts of former use

        var posts_section = document.querySelector("section#verticalScrollContainer");
        for (id in posts) {
            IDS.push(id);
            addPostToContainer(posts[id], posts_section, id); // Adding post in page also save them
        }

        localStorage.setItem('shouldBeRestored', "false");
        //document.cookie = "shouldBeRestored=0;SameSite=Lax;path=<?= Config::URL_SUBDIR(true) ?>";

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
        //document.cookie = "shouldBeRestored=0;SameSite=Lax;path=<?= Config::URL_SUBDIR(true) ?>";
    }
    
} catch(e) {
    localStorage.setItem('shouldBeRestored', "false");
    localStorage.setItem('community', current_community);
    clearPosts();
}
</script>

<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/post.js')?>"></script>
</html>
