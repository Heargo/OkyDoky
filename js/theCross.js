
function savePosts(offset, to_add_array) {
    let posts = JSON.parse(window.localStorage.getItem('posts')) || [];
    posts.push(to_add_array);

    window.localStorage.setItem('posts', JSON.stringify(posts));
    window.localStorage.setItem('offset', offset);
}

function updatePost(id) {
    let newUp   = document.getElementById("upVoteIcon-" + id);
    let newDown = document.getElementById("downVoteIcon-" + id);
    let newPrct = document.getElementById("prctQualityText-" + id);
    let newFav  = document.getElementById("favIcon-" + id);

    let posts = JSON.parse(window.localStorage.getItem('posts'));
    posts.forEach( (row, index, array) => {
        let id_cache = row[0];
        if (id_cache == id) { // the one we're looking for
            //load cached post
            let u_post= document.createElement('div');
            u_post.innerHTML = `${row[1]}`;
            let updated_post = u_post.firstElementChild;

            let up   = updated_post.querySelector("#upVoteIcon-" + id);
            let down = updated_post.querySelector("#downVoteIcon-" + id);
            let prct = updated_post.querySelector("#prctQualityText-" + id);
            let fav  = updated_post.querySelector("#favIcon-" + id);

            //edit cached post
            up.replaceWith(newUp.cloneNode(true));
            down.replaceWith(newDown.cloneNode(true));
            prct.replaceWith(newPrct.cloneNode(true))
            fav.replaceWith(newFav.cloneNode(true))

            array[index][1] = updated_post.outerHTML;
        }
    });
    window.localStorage.setItem('posts', JSON.stringify(posts));
}

function retrievePosts() {
    let posts = JSON.parse(window.localStorage.getItem('posts'));
    let offset = JSON.parse(window.localStorage.getItem('offset'));
    return [parseInt(offset), posts];
}

function deletePostFromStorage(id) {
    // Delete in localstorage
    let offset = retrievePosts()[0];
    let posts = retrievePosts()[1];
    posts.forEach( (row, index, array) => {
        if (row[0] === id) {
            array.splice(index, 1);
        }
    });
    window.localStorage.setItem('posts', JSON.stringify(posts));
    // window.OFFSET = OFFSET - 1; // Not sure
    window.localStorage.setItem('offset', offset - 1);
}

function clearPosts() {
    window.localStorage.removeItem('posts');
    window.localStorage.removeItem('offset');
    console.log('Storage cleared!');
}

function restore() {
    window.OFFSET = 0; // don't really care, it'll be overwritten
    window.IDS = [];
    try {
        console.log("hey")
        const shouldBeRestored = localStorage.getItem('shouldBeRestored');
        const community = localStorage.getItem('community');

        // localStorage only allow strings, not booleans
        // current_community is a var from php, passed through <scrip>
        if (shouldBeRestored === "true" && community === current_community) {
            var offset, posts;
            [offset, posts] = retrievePosts();
            window.OFFSET = offset; 

            clearPosts(); // Clear posts of former use

            var posts_section = document.querySelector("section#verticalScrollContainer");
            posts.forEach( (row, index, array) => {
                var id = row[0];
                var html = row[1];
                window.IDS.push(id) // IDS is also declared in feedAjax.js
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
}
