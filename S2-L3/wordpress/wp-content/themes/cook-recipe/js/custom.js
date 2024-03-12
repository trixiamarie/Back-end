jQuery(document).ready(function($) {

    var slider_auto, slider_loop, rtl;

    if (cook_recipe_data.auto == '1') {
        slider_auto = true;
    } else {
        slider_auto = false;
    }

    if (cook_recipe_data.loop == '1') {
        slider_loop = true;
    } else {
        slider_loop = false;
    }

    if (cook_recipe_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }

    //slider four
    $('.banner-slider.style-four .item-wrapper').owlCarousel({
        items: 1,
        autoplay: slider_auto,
        loop: slider_loop,
        nav: false,
        dots: true,
        rewind: false,
        autoplaySpeed: 800,
        rtl: rtl,
        autoplayTimeout: cook_recipe_data.speed,
    });

});