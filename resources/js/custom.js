try {
    window.Dropzone = require('dropzone');
    require('lightbox2');
} catch (e) {}

$(document).ready(function () {
    $("#sidebar-menu, #close-menu").on("click", function () {
        $("body").toggleClass("sidebar-toggle");
    });

    $("#cookie-alert--close").on("click", function() {
        $("#cookie-alert").slideUp();
    });

    $(document).on("click", '.slide-link', function () {
        var href = $(this).data('href');

        if (href !== "") {
            location.href = href;
        }
    });
});
