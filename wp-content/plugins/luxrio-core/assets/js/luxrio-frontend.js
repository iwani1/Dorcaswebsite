; (function ($) {
    'use strict';

    /*=================================
     JS Index Here
    ==================================*/
    /*
      00. Popup Sidemenu
      01. Service Slider
      02. FAQ 
    */
    /*=================================
        JS Index End
    ==================================*/

    $(window).on('elementor/frontend/init', function () {


        /*----------  Global Js ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope, $) {
            /*---------- Set Background Image ----------*/
            $("[data-bg-src]").each(function () {
                var src = $(this).attr("data-bg-src");
                $(this).css("background-image", "url(" + src + ")");
                $(this).removeAttr("data-bg-src").addClass("background-image");
            });

             // Function For Custom Arrow Btn
             $("[data-slick-next]").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    $($(this).data("slick-next")).slick("slickNext");
                });
            });

            $("[data-slick-prev]").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    $($(this).data("slick-prev")).slick("slickPrev");
                });
            });
        });



        elementorFrontend.hooks.addAction('frontend/element_ready/luxriooffcanvas.default', function ($scope) {
            function popupSideMenu($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
                // Sidebar Popup
                $($sideMunuOpen).on("click", function (e) {
                    e.preventDefault();
                    $($sideMenu).addClass($toggleCls);
                });
                $($sideMenu).on("click", function (e) {
                    e.stopPropagation();
                    $($sideMenu).removeClass($toggleCls);
                });
                var sideMenuChild = $sideMenu + " > div";
                $(sideMenuChild).on("click", function (e) {
                    e.stopPropagation();
                    $($sideMenu).addClass($toggleCls);
                });
                $($sideMenuCls).on("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $($sideMenu).removeClass($toggleCls);
                });
            }
            popupSideMenu(
                ".sidemenu-wrapper",
                ".sideMenuToggler",
                ".sideMenuCls",
                "show"
            );
        });

        /*---------- MagnificPopup video view  ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxriovideobox.default', function ($scope) {
            $(".popup-video").magnificPopup({
                type: "iframe",
            });
        });



        /*---------- Hero One  ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioheroone.default', function ($scope) {
           

            let $heroslide = $scope.find('.hero-carousel');
            $heroslide.not('.slick-initialized').slick({
                loop: true,
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $heroslide.data('slick-autoplay'),
                autoplaySpeed: 7000,
                fade: true,
                slidesToShow: 1,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });
        });

        /*---------- Hero Two  ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioherotwo.default', function ($scope) {
            // Function For Custom Arrow Btn

            let $heroslide = $scope.find('.hero-vs-carousel');

            $heroslide.not('.slick-initialized').slick({
                loop: true,
                dots: $heroslide.data('slick-dots'),
                infinite: false,
                arrows: false,
                autoplay: $heroslide.data('slick-autoplay'),
                fade: true,
                slidesToShow: 1,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        dots:false,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        dots:false,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                        dots:false,
                    }
                }
                ]
            });

        });

        /*---------- Hero Three  ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioherothree.default', function ($scope) {

            let $heroslide = $scope.find('.hero-carousel3');
            $heroslide.not('.slick-initialized').slick({
                loop: true,
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $heroslide.data('slick-autoplay'),
                fade: true,
                slidesToShow: 1,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });



             // Status Update Element
             var $status = $(".slick-status");

             // Update the slide status
             $heroslide.on("afterChange", function (event, slick, currentSlide) {
             var totalSlides = slick.slideCount;
             var currentIndex = currentSlide + 1;
             $(".slick-status__active").text(
                 currentIndex < 10 ? "0" + currentIndex : currentIndex
             );
             $(".slick-status span:last").text(
                 totalSlides < 10 ? "0" + totalSlides : totalSlides
             );
             });
 
             // Initialize with first slide (if required)
             $heroslide.on("init", function () {
             var totalSlides = asSlide.slick("getSlick").slideCount;
             $(".slick-status__active").text("01"); // Default to first slide
             $(".slick-status span:last").text(
                 totalSlides < 10 ? "0" + totalSlides : totalSlides
             );
             });
        });
        /*---------- Hero Four  ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioherofour.default', function ($scope) {
            // Function For Custom Arrow Btn

            let $heroslide = $scope.find('.hero-vs-carousel4');

            $heroslide.not('.slick-initialized').slick({
                loop: true,
                dots: $heroslide.data('slick-dots'),
                infinite: false,
                arrows: false,
                autoplay: $heroslide.data('slick-autoplay'),
                fade: true,
                slidesToShow: 1,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                        dots:false,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        dots:false,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                        dots:false,
                    }
                }
                ]
            });

        });
        /*---------- Logo   ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxriobrandlogoliders.default', function ($scope) {
            // Function For Custom Arrow Btn
            $("[data-slick-next]").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    $($(this).data("slick-next")).slick("slickNext");
                });
            });

            $("[data-slick-prev]").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    $($(this).data("slick-prev")).slick("slickPrev");
                });
            });

            let $brnadslider = $scope.find('.brand-carousel');
            $brnadslider.not('.slick-initialized').slick({
                loop: true,
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $brnadslider.data('slick-autoplay'),
                fade: false,
                slidesToShow: $brnadslider.data('slide-to-show'),
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: $brnadslider.data('slide-to-show'),
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });
        });
        /*---------- Instagram Slider   ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioinstagramslider.default', function ($scope) {
            
            let $brnadslider = $scope.find('.instagram-carousel');
            $brnadslider.not('.slick-initialized').slick({
                loop: true,
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $brnadslider.data('slick-autoplay'),
                fade: false,
                slidesToShow: $brnadslider.data('slide-to-show'),
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: $brnadslider.data('slide-to-show'),
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });
        });


        /*----------- Blog Slider ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioblogpost.default', function ($scope) {

            let $blogcarousel = $scope.find('.blog-carousel');
            $blogcarousel.not('.slick-initialized').slick({
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $blogcarousel.data('slick-autoplay'),
                autoplaySpeed: 6000,
                fade: false,
                speed: 1000,
                slidesToShow: $blogcarousel.data('slide-to-show'),
                slidesToScroll: 3,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: $blogcarousel.data('slide-to-show'),
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });

        });

        /*---------- Testimonial   ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxriotestimonialsliders.default', function ($scope) {
            let $testimonial = $scope.find('.testi-carousel');

            $testimonial.not('.slick-initialized').slick({
                loop: true,
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: true,
                fade: true,
                slidesToShow: 1,
                autoplaySpeed: 6000,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });
        });
        /*---------- Testimonial Two   ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxriotestimonialsliderstwo.default', function ($scope) {
            let $testimonial = $scope.find('.testi-carousel2');

            $testimonial.not('.slick-initialized').slick({
                loop: true,
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: true,
                fade: false,
                slidesToShow: 1,
                autoplaySpeed: 6000,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });
        });

        /*---------- product slider   ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioproductslider.default', function ($scope) {
            let $slickcarousels = $scope.find('.product-slider');
            $slickcarousels.not('.slick-initialized').slick({
                dots: false,
                infinite: true,
                arrows: $slickcarousels.data('slick-arrows'),
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
                autoplay: $slickcarousels.data('slick-autoplay'),
                autoplaySpeed: 6000,
                fade: false,
                speed: 1000,
                slidesToShow: $slickcarousels.data('slide-to-show'),
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        arrows: false,
                    }
                },{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                    }
                }
                ]
            });

        });

        /*----------- Product Category Slider ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioproductcategory.default', function ($scope) {

            let $blogcarousel = $scope.find('.category-slider');
            $blogcarousel.not('.slick-initialized').slick({
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $blogcarousel.data('slick-autoplay'),
                autoplaySpeed: 6000,
                fade: false,
                speed: 1000,
                slidesToShow: $blogcarousel.data('slide-to-show'),
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1300,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });

        });
        /*----------- Product Category Slider ----------*/
        elementorFrontend.hooks.addAction('frontend/element_ready/luxrioproductcategoryslider.default', function ($scope) {

            let $blogcarousel = $scope.find('.category-slider2');
            $blogcarousel.not('.slick-initialized').slick({
                dots: false,
                infinite: true,
                arrows: false,
                autoplay: $blogcarousel.data('slick-autoplay'),
                autoplaySpeed: 6000,
                fade: false,
                speed: 1000,
                slidesToShow: $blogcarousel.data('slide-to-show'),
                slidesToScroll: 1,
                responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: $blogcarousel.data('slide-to-show'),
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 470,
                    settings: {
                        slidesToShow: 1,
                    }
                }
                ]
            });

            // Tabe
            $(".nav-link").on("shown.bs.tab", function (e) {
                $blogcarousel.slick("setPosition");
            });


        });

    });











}(jQuery));