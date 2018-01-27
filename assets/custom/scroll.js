$(document).ready(function ($) {
    'use strict';
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 270) {
            $(".navbar-custom").addClass('fixed-top');

        } else {
            $(".navbar-custom").removeClass('fixed-top');
            $(".navbar-custom").addClass('was-fixed');
        }
    });

    // anchor links
    // $('a[href*="#"]')
    //     .not('[href="#"]')
    //     .not('[href="#0"]')
    //     .click(function (e) {
    //         if (
    //             location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
    //             location.hostname == this.hostname
    //         ) {
    //             var target = $(this.hash);
    //             target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    //             if (target.length) {
    //                 e.preventDefault();
    //                 $('html, body').animate({
    //                     scrollTop: target.offset().top - 100
    //                 }, 1000);
    //             }
    //         }
    //     });
});