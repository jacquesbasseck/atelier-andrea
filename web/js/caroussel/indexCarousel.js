$(document).ready(function () {
    jQuery('#camera_wrap').camera({
        loader: false,
        pagination: true,
        thumbnails: false,
        height: '42.79569892473118%',
        caption: false,
        navigation: false,
        fx: 'mosaic'
    });

});

$(window).load(
    function () {
        $('.carousel1').carouFredSel({
            auto: false, prev: '.prev', next: '.next', width: 220, items: {
                visible: {
                    min: 1,
                    max: 3
                },
                height: 'auto',
                width: 220,

            }, responsive: true,

            scroll: 1,

            mousewheel: false,

            swipe: {onMouse: true, onTouch: true}
        });

    });
