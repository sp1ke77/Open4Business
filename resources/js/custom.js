try {
    window.Dropzone = require('dropzone');
    require('lightbox2');
    window.Cookies = require('js-cookie');
} catch (e) {
}

$(document).ready(function () {
    $("#sidebar-menu, #close-menu").on("click", function () {
        $("body").toggleClass("sidebar-toggle");
    });

    $("#cookie-alert--close").on("click", function () {
        $("#cookie-alert").slideUp();
        Cookies.set('cookie_alert', true);
    });

    if (Cookies.get('cookie_alert') == undefined) {
        $("#cookie-alert").slideDown();
    }

    $(document).on("click", '.slide-link', function () {
        var href = $(this).data('href');

        if (href !== "") {
            location.href = href;
        }
    });
});
