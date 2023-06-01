jQuery('body').on('click', '.media-selector', function (event) {
    event.preventDefault();

    const multiple = 'true' === event.target.dataset.multiple;
    const media = wp.media({multiple: multiple}).open().on('select', () => {
        document.querySelector(event.target.dataset.inputSelector).value = multiple ?
            JSON.stringify(media.state().get('selection').map(attachment => attachment.id)) :
            media.state().get('selection').first().toJSON().id;
    });
});
