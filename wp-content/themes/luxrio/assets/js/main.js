(function ($) {
  "use strict";
  /*=================================
      JS Index Here
  ==================================*/
  /*
    01. On Load Function
    02. Preloader
    03. Mobile Menu Active
    04. Sticky fix
    05. Scroll To Top
    06. Set Background Image
    07. Hero Slider Active 
    08. Global Slider
    09. Ajax Contact Form
    10. Popup Sidemenu   
    11. Magnific Popup
    12. Section Position
    13. Filter
    14. One Page Nav
    15. WOW.js Animation
  */
  /*=================================
      JS Index End
  ==================================*/
  /*

  /*---------- 01. On Load Function ----------*/
  $(window).on("load", function () {
    $(".preloader").fadeOut(); // Fade out preloader
    $(".vs-hero").addClass("animate-elements"); // Add animation class

    // Check if preloader exists and handle close event
    $(".preloader").length &&
      $(".preloaderCls").on("click", function (e) {
        e.preventDefault(); // Prevent default action
        $(".preloader").hide(); // Hide preloader
      });
  });

  /*---------- 03. Mobile Menu Active ----------*/
  $.fn.vsmobilemenu = function (options) {
    var opt = $.extend(
      {
        menuToggleBtn: ".vs-menu-toggle",
        bodyToggleClass: "vs-body-visible",
        subMenuClass: "vs-submenu",
        subMenuParent: "vs-item-has-children",
        subMenuParentToggle: "vs-active",
        meanExpandClass: "vs-mean-expand",
        appendElement: '<span class="vs-mean-expand"></span>',
        subMenuToggleClass: "vs-open",
        toggleSpeed: 400,
      },
      options
    );

    return this.each(function () {
      var menu = $(this); // Select menu

      // Menu Show & Hide
      function menuToggle() {
        menu.toggleClass(opt.bodyToggleClass);

        // collapse submenu on menu hide or show
        var subMenu = "." + opt.subMenuClass;
        $(subMenu).each(function () {
          if ($(this).hasClass(opt.subMenuToggleClass)) {
            $(this).removeClass(opt.subMenuToggleClass);
            $(this).css("display", "none");
            $(this).parent().removeClass(opt.subMenuParentToggle);
          }
        });
      }

      // Class Set Up for every submenu
      menu.find("li").each(function () {
        var submenu = $(this).find("ul");
        submenu.addClass(opt.subMenuClass);
        submenu.css("display", "none");
        submenu.parent().addClass(opt.subMenuParent);
        submenu.prev("a").append(opt.appendElement);
        submenu.next("a").append(opt.appendElement);
      });

      // Toggle Submenu
      function toggleDropDown($element) {
        if ($($element).next("ul").length > 0) {
          $($element).parent().toggleClass(opt.subMenuParentToggle);
          $($element).next("ul").slideToggle(opt.toggleSpeed);
          $($element).next("ul").toggleClass(opt.subMenuToggleClass);
        } else if ($($element).prev("ul").length > 0) {
          $($element).parent().toggleClass(opt.subMenuParentToggle);
          $($element).prev("ul").slideToggle(opt.toggleSpeed);
          $($element).prev("ul").toggleClass(opt.subMenuToggleClass);
        }
      }

      // Submenu toggle Button
      var expandToggler = "." + opt.meanExpandClass;
      $(expandToggler).each(function () {
        $(this).on("click", function (e) {
          e.preventDefault();
          toggleDropDown($(this).parent());
        });
      });

      // Menu Show & Hide On Toggle Btn click
      $(opt.menuToggleBtn).each(function () {
        $(this).on("click", function () {
          menuToggle();
        });
      });

      // Hide Menu On out side click
      menu.on("click", function (e) {
        e.stopPropagation();
        menuToggle();
      });

      // Stop Hide full menu on menu click
      menu.find("div").on("click", function (e) {
        e.stopPropagation();
      });
    });
  };

  $(".vs-menu-wrapper").vsmobilemenu();


  
  var scrollToTopBtn = ".scrollToTop";

  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 500) {
      $(scrollToTopBtn).addClass("show");
    } else {
      $(scrollToTopBtn).removeClass("show");
    }
  });
  
  /*---------- 05. Scroll To Top ----------*/
  $(scrollToTopBtn).each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      $("html, body").animate(
        {
          scrollTop: 0,
        },
        1000
      );
      return false;
    });
  });

  /*---------- 06.Set Background Image ----------*/
  if ($("[data-bg-src]").length > 0) {
    $("[data-bg-src]").each(function () {
      var src = $(this).attr("data-bg-src");
      $(this).css("background-image", "url(" + src + ")");
      $(this).removeAttr("data-bg-src").addClass("background-image");
    });
  }


  /*---------- 10. Popup Sidemenu ----------*/
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

  /*---------- Woocommerce Popup Sidemenu ----------*/
  function popupSideMenu2($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
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
  popupSideMenu2(
    ".sidemenu2-wrapper",
    ".sideMenu2Toggler",
    ".sideMenu2Cls",
    "show"
  );

    /*---------- 08. Search Box Popup ----------*/
    function popupSarchBox($searchBox, $searchOpen, $searchCls, $toggleCls) {
      $($searchOpen).on('click', function (e) {
          e.preventDefault();
          $($searchBox).addClass($toggleCls);
      });
      $($searchBox).on('click', function (e) {
          e.stopPropagation();
          $($searchBox).removeClass($toggleCls);
      });
      $($searchBox).find('form').on('click', function (e) {
          e.stopPropagation();
          $($searchBox).addClass($toggleCls);
      });
      $($searchCls).on('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          $($searchBox).removeClass($toggleCls);
      });
  };
  popupSarchBox('.popup-search-box', '.searchBoxTggler', '.searchClose', 'show');


  /*----------- 11. Magnific Popup ----------*/
  /* magnificPopup img view */
  $(".popup-image").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  /* magnificPopup video view */
  $(".popup-video").magnificPopup({
    type: "iframe",
  });


  /*----------- 13. Filter ----------*/
  $(".filter-active, .filter-active2").imagesLoaded(function () {
    var $filter = ".filter-active",
      $filter2 = ".filter-active2",
      $filterItem = ".filter-item",
      $filterMenu = ".filter-menu-active";

    if ($($filter).length > 0) {
      var $grid = $($filter).isotope({
        itemSelector: $filterItem,
        filter: "*",
        masonry: {
          // use outer width of grid-sizer for columnWidth
          columnWidth: 1,
        },
      });
    }

    if ($($filter2).length > 0) {
      var $grid = $($filter2).isotope({
        itemSelector: $filterItem,
        filter: "*",
        masonry: {
          // use outer width of grid-sizer for columnWidth
          columnWidth: $filterItem,
        },
      });
    }

    // Menu Active Class
    $($filterMenu).on("click", "button", function (event) {
      event.preventDefault();
      var filterValue = $(this).attr("data-filter");
      $grid.isotope({
        filter: filterValue,
      });
      $(this).addClass("active");
      $(this).siblings(".active").removeClass("active");
    });
  });

  /**************************************
   ***** 00. Countdown JS *****
   **************************************/
   $.fn.countdown = function () {
    this.each(function () {
      var $this = $(this),
        offerDate = new Date($this.data("offer-date")).getTime();

      function findElement(selector) {
        return $this.find(selector);
      }

      var interval = setInterval(function () {
        var now = new Date().getTime(),
          timeDiff = offerDate - now,
          days = Math.floor(timeDiff / 864e5),
          hours = Math.floor((timeDiff % 864e5) / 36e5),
          minutes = Math.floor((timeDiff % 36e5) / 6e4),
          seconds = Math.floor((timeDiff % 6e4) / 1e3);

        days < 10 && (days = "0" + days),
          hours < 10 && (hours = "0" + hours),
          minutes < 10 && (minutes = "0" + minutes),
          seconds < 10 && (seconds = "0" + seconds);

        if (timeDiff < 0) {
          clearInterval(interval);
          $this.addClass("expired");
          findElement(".message").css("display", "block");
        } else {
          findElement(".day").html(days);
          findElement(".hour").html(hours);
          findElement(".minute").html(minutes);
          findElement(".seconds").html(seconds);
        }
      }, 1000);
    });
  };
  $(".offer-counter").length && $(".offer-counter").countdown();

  /*----------- 15. WOW.js Animation ----------*/
  var wow = new WOW({
    boxClass: "wow", // animated element css class (default is wow)
    animateClass: "wow-animated", // animation css class (default is animated)
    offset: 0, // distance to the element when triggering the animation (default is 0)
    mobile: false, // trigger animations on mobile devices (default is true)
    live: true, // act on asynchronously loaded content (default is true)
    scrollContainer: null, // optional scroll container selector, otherwise use window,
    resetAnimation: false, // reset animation on end (default is true)
  });
  wow.init();

    /*----------- 20. Quantity Adder ----------*/
    $(document).on('click', '.quantity-plus,.quantity-minus', function(e) {
      e.preventDefault();
        // Get current quantity values
        var qty = $(this).closest('.product-quantity').find('.qty');
        var val = parseFloat(qty.val());
        var max = parseFloat(qty.attr('max'));
        var min = parseFloat(qty.attr('min'));
        var step = parseFloat(qty.attr('step'));

      // Change the value if plus or minus
      if ($(this).is('.quantity-plus')) {
          if (max && (max <= val)) {
              qty.val(max);
          } else {
              qty.val(val + step);
          }
      } else {
          if (min && (min >= val)) {
              qty.val(min);
          } else if (val > 0) {
              qty.val(val - step);
          }
      }
      $('.cart_table button[name="update_cart"]').prop('disabled', false);
    });

    $('.related-product.vs-carousel').slick({
      dots: false,
      infinite: true,
      arrows: false,
      prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
      autoplay: true,
      autoplaySpeed: 6000,
      fade: false,
      speed: 1000,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [{
        breakpoint: 1200,
        settings: {
            slidesToShow: 3,
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
  /**************************************
     ***** Custom Ecommerce Category Menu *****
    **************************************/
    document.addEventListener("DOMContentLoaded", () => {
      // Select all menu wrappers
      const menuWrappers = document.querySelectorAll(".menu-wrapper");

      // Loop through each menu wrapper
      menuWrappers.forEach((wrapper) => {
        const menuToggle = wrapper.querySelector(".menu-toggle");
        const menuList = wrapper.querySelector(".menu-list");
        const menuItems = wrapper.querySelectorAll(".menu-item");

        // GSAP timeline for each menu
        const tl = gsap.timeline({ paused: true, reversed: true }); // Start in reversed state

        // Animate the menu list (fade-in and slide up)
        tl.to(menuList, {
          opacity: 1,
          visibility: "visible",
          y: "0%", // Move up to original position
          duration: 0.5,
          ease: "power2.out",
        }).to(
          menuItems,
          {
            opacity: 1,
            y: 0, // Move to original position
            duration: 0.5,
            ease: "power2.out",
            stagger: 0.1, // Slight delay between each item
          },
          "<" // Start items animation at the same time as the menu list animation
        );

        // Toggle dropdown menu on click
        menuToggle.addEventListener("click", (e) => {
          e.stopPropagation(); // Prevent the event from bubbling up to the document
          menuToggle.classList.toggle("active"); // Toggle active state
          if (tl.reversed()) {
            tl.play(); // Play animation for opening
            tl.reversed(false); // Mark timeline as not reversed
          } else {
            tl.reverse(); // Reverse animation for closing
            tl.reversed(true); // Mark timeline as reversed
          }
        });

        // Close menu when clicking outside the menu-wrapper
        document.addEventListener("click", (e) => {
          if (!wrapper.contains(e.target)) {
            if (!tl.reversed()) {
              // Only reverse if menu is open
              tl.reverse(); // Close menu
              tl.reversed(true); // Mark timeline as reversed
              menuToggle.classList.remove("active"); // Remove active class
            }
          }
        });
      });
    });



  // Register GSAP plugins
  gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

  const lenis = new Lenis({
    duration: 1.3,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smooth: true,
  });
  function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
  }
  requestAnimationFrame(raf);

    /**************************************
     *****  Data Navbar Stick *****
    **************************************/
  // Check if the element #navbars exists
  if (!document.querySelector("#navbars")) {
    return; // Exit if the element doesn't exist
  }

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: "#navbars",
      start: "top+=600", // Trigger animation when scrolled 600px down
      end: "+=1",
      toggleActions: "play none none none",
      scrub: 1,
      duration: 0.2, // Duration of the animation
    },
  });

  // Initially hide the element
  gsap.set("#navbars", { opacity: 0, visibility: "hidden", y: -82 });

  // Animate to make it visible and slide down smoothly
  tl.to("#navbars", {
    opacity: 1,
    visibility: "visible",
    y: 0, // Slide down to its original position
    duration: 0.2, // Duration of the animation
    ease: "power2.out", // Smooth easing effect
  });
    
  // end
})(jQuery);
