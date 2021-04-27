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

<script src="<?= Routes::url_for('/js/feedAjax.js')?>"></script>
<script>
try {
    const shouldBeRestored = document.cookie
      .split('; ')
      .find(row => row.startsWith('shouldBeRestored='))
      .split('=')[1];
    if (shouldBeRestored == "1") {
        var offset, posts;
        [offset, posts] = retrievePosts();
        OFFSET = offset;

        var posts_section = document.querySelector("section#verticalScrollContainer");
        for (id in posts) {
            IDS.push(id);
            addPostToContainer(posts[id], posts_section);
        }

        document.cookie = "shouldBeRestored=0";

        const anchor = document.cookie
          .split('; ')
          .find(row => row.startsWith('restoreAnchor='))
          .split('=')[1];
        console.log("anchor="+anchor);
        try {
            document.getElementById(anchor).scrollIntoView();
        } catch {
            //ignore
        }
        console.log("Posts restored !");
    }
} catch {
    //ignore
}

</script>

<script src="<?= Routes::url_for('/js/votesAjax.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script src="<?= Routes::url_for('/js/share.js')?>"></script>
<script src="<?= Routes::url_for('/js/post.js')?>"></script>
<script src="<?= Routes::url_for('/js/prism.js')?>"></script>
</html>
