function toggle_check_copy(shareButton) {
    var share_img = shareButton.firstElementChild;
    var check_img = share_img.nextElementSibling;
    share_img.classList.toggle('hidden');
    check_img.classList.toggle('hidden');
}
var clipboard = new ClipboardJS('.copy-to-clipboard');

clipboard.on('success', function(e) {
    toggle_check_copy(e.trigger);
    setTimeout(function() {
        toggle_check_copy(e.trigger);
    },2000);

    e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});
