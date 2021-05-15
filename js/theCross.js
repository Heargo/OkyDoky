try {
    const shouldBeRestored = localStorage.getItem('shouldBeRestored');
    const community = localStorage.getItem('community');

    // localStorage only allow strings, not booleans
    // current_community is a var from php, passed through <scrip>
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
