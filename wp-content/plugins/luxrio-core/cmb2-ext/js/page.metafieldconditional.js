(function ($) {
    "use strict";

    let $luxrio_page_breadcrumb_area = $("#_luxrio_page_breadcrumb_area");
    let $luxrio_page_settings = $("#_luxrio_page_breadcrumb_settings");
    let $luxrio_page_breadcrumb_image = $("#_luxrio_breadcumb_image");
    let $luxrio_page_title = $("#_luxrio_page_title");
    let $luxrio_page_title_settings = $("#_luxrio_page_title_settings");

    if ($luxrio_page_breadcrumb_area.val() == '1') {
        $(".cmb2-id--luxrio-page-breadcrumb-settings").show();
        if ($luxrio_page_settings.val() == 'global') {
            $(".cmb2-id--luxrio-breadcumb-image").hide();
            $(".cmb2-id--luxrio-page-title").hide();
            $(".cmb2-id--luxrio-page-title-settings").hide();
            $(".cmb2-id--luxrio-custom-page-title").hide();
            $(".cmb2-id--luxrio-page-breadcrumb-trigger").hide();
        } else {
            $(".cmb2-id--luxrio-breadcumb-image").show();
            $(".cmb2-id--luxrio-page-title").show();
            $(".cmb2-id--luxrio-page-breadcrumb-trigger").show();

            if ($luxrio_page_title.val() == '1') {
                $(".cmb2-id--luxrio-page-title-settings").show();
                if ($luxrio_page_title_settings.val() == 'default') {
                    $(".cmb2-id--luxrio-custom-page-title").hide();
                } else {
                    $(".cmb2-id--luxrio-custom-page-title").show();
                }
            } else {
                $(".cmb2-id--luxrio-page-title-settings").hide();
                $(".cmb2-id--luxrio-custom-page-title").hide();

            }
        }
    } else {
        $luxrio_page_breadcrumb_area.parents('.cmb2-id--luxrio-page-breadcrumb-area').siblings().hide();
    }


    // breadcrumb area
    $luxrio_page_breadcrumb_area.on("change", function () {
        if ($(this).val() == '1') {
            $(".cmb2-id--luxrio-page-breadcrumb-settings").show();
            if ($luxrio_page_settings.val() == 'global') {
                $(".cmb2-id--luxrio-breadcumb-image").hide();
                $(".cmb2-id--luxrio-page-title").hide();
                $(".cmb2-id--luxrio-page-title-settings").hide();
                $(".cmb2-id--luxrio-custom-page-title").hide();
                $(".cmb2-id--luxrio-page-breadcrumb-trigger").hide();
            } else {
                $(".cmb2-id--luxrio-breadcumb-image").show();
                $(".cmb2-id--luxrio-page-title").show();
                $(".cmb2-id--luxrio-page-breadcrumb-trigger").show();

                if ($luxrio_page_title.val() == '1') {
                    $(".cmb2-id--luxrio-page-title-settings").show();
                    if ($luxrio_page_title_settings.val() == 'default') {
                        $(".cmb2-id--luxrio-custom-page-title").hide();
                    } else {
                        $(".cmb2-id--luxrio-custom-page-title").show();
                    }
                } else {
                    $(".cmb2-id--luxrio-page-title-settings").hide();
                    $(".cmb2-id--luxrio-custom-page-title").hide();

                }
            }
        } else {
            $(this).parents('.cmb2-id--luxrio-page-breadcrumb-area').siblings().hide();
        }
    });

    // page title
    $luxrio_page_title.on("change", function () {
        if ($(this).val() == '1') {
            $(".cmb2-id--luxrio-page-title-settings").show();
            if ($luxrio_page_title_settings.val() == 'default') {
                $(".cmb2-id--luxrio-custom-page-title").hide();
            } else {
                $(".cmb2-id--luxrio-custom-page-title").show();
            }
        } else {
            $(".cmb2-id--luxrio-page-title-settings").hide();
            $(".cmb2-id--luxrio-custom-page-title").hide();

        }
    });

    //page settings
    $luxrio_page_settings.on("change", function () {
        if ($(this).val() == 'global') {
            $(".cmb2-id--luxrio-breadcumb-image").hide();
            $(".cmb2-id--luxrio-page-title").hide();
            $(".cmb2-id--luxrio-page-title-settings").hide();
            $(".cmb2-id--luxrio-custom-page-title").hide();
            $(".cmb2-id--luxrio-page-breadcrumb-trigger").hide();
        } else {
            $(".cmb2-id--luxrio-breadcumb-image").show();
            $(".cmb2-id--luxrio-page-title").show();
            $(".cmb2-id--luxrio-page-breadcrumb-trigger").show();

            if ($luxrio_page_title.val() == '1') {
                $(".cmb2-id--luxrio-page-title-settings").show();
                if ($luxrio_page_title_settings.val() == 'default') {
                    $(".cmb2-id--luxrio-custom-page-title").hide();
                } else {
                    $(".cmb2-id--luxrio-custom-page-title").show();
                }
            } else {
                $(".cmb2-id--luxrio-page-title-settings").hide();
                $(".cmb2-id--luxrio-custom-page-title").hide();

            }
        }
    });

    // page title settings
    $luxrio_page_title_settings.on("change", function () {
        if ($(this).val() == 'default') {
            $(".cmb2-id--luxrio-custom-page-title").hide();
        } else {
            $(".cmb2-id--luxrio-custom-page-title").show();
        }
    });

})(jQuery);