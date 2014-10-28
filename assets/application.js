$(document).ready(function() {
    $('input.content_search').keyup(function() {
        if ($(this).val().length > 0) {
            $('p.entry:not(:contains(' + $(this).val() + '))').hide();
            $('p.entry:contains(' + $(this).val() + ')').show();
        } else {
            $('p.entry').show();
        }
    });
});