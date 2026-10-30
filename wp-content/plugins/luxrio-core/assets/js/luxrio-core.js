/*

[Main Script]

Project: Luxrio
Version: 1.0
Author : vecurosoft.com

*/
; (function ($) {
    "use strict";

    jQuery(window).on('elementor/frontend/init', function () {
        // console.log( elementorFrontend);
        if (typeof elementor != "undefined" && typeof elementor.settings.page != "undefined") {

            elementor.settings.page.addChangeCallback('luxrio_header_style', function (newValue) {
                if (newValue == 'prebuilt') {
                    elementor.saver.update({
                        onSuccess: function () {
                            elementor.reloadPreview();
                            elementor.once('preview:loaded', function () {
                                elementor.getPanelView().setPage('page_settings').activateTab('settings');
                            });
                        }
                    });
                }
            });


            elementor.settings.page.addChangeCallback('luxrio_header_builder_option', function (newValue) {
                elementor.saver.update({
                    onSuccess: function () {
                        elementor.reloadPreview();
                        elementor.once('preview:loaded', function () {
                            elementor.getPanelView().setPage('page_settings').activateTab('settings');
                        });
                    }
                });
            });

            elementor.settings.page.addChangeCallback('luxrio_footer_style', luxrioFooterStyle);
            function luxrioFooterStyle(newValue) {
                elementor.saver.update({
                    onSuccess: function () {
                        elementor.reloadPreview();
                        elementor.once('preview:loaded', function () {
                            elementor.getPanelView().setPage('page_settings').activateTab('settings');
                        });
                    }
                });
            }
            elementor.settings.page.addChangeCallback('luxrio_footer_choice', luxrioFooterChoice);
            function luxrioFooterChoice(newValue) {
                elementor.saver.update({
                    onSuccess: function () {
                        elementor.reloadPreview();
                        elementor.once('preview:loaded', function () {
                            elementor.getPanelView().setPage('page_settings').activateTab('settings');
                        });
                    }
                });
            }

        }
    });

})(jQuery);