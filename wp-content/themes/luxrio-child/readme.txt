=== Queen Dor's Child ===
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.0
Stable tag: 1.8.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Parent theme: luxrio

A child theme for Queen Dor's Fashion House. Everything below is code, not
content: it works the moment the theme is active, without touching Elementor.

== What is in this build =====================================================

Design
  assets/css/brand-tokens.css       the palette, sampled from the logo, as tokens
  assets/css/brand-components.css   buttons, links, fields, cards, nav, states
  assets/css/brand-light.css        light header, top bar, page ground, mobile menu
  assets/css/queendor.css           layout fixes for the parent theme
  assets/css/wholesale.css          the trade band, trade line and application form

Behaviour
  inc/brand-colours.php   loads the three colour stylesheets last, so they win
                          over the theme's own option colours; adds qd-light
  inc/demo-links.php      rewrites vendor URLs, the -2 page slugs, the Instagram
                          URL and GHC -> the cedi sign, on the front end only
  inc/wholesale.php       trade pricing at 50%, MOQ 6, application form, approval
  inc/wholesale-cta.php   the home band, the product-page trade line, the
                          wholesale page copy and form
  inc/rebrand.php         Luxrio -> Queen Dor's in the front end
  inc/ring-size.php       the ring size chart
  inc/symbol-guide.php    the Adinkra symbol reference
  inc/product-blocks.php  the product page symbol and care blocks

== Turning things off =======================================================

  add_filter( 'queendor_light_storefront', '__return_false' );   light shell off
  add_filter( 'queendor_wholesale_show_band', '__return_false' ); home band off

== What this theme does not do ==============================================

Section backgrounds. The page is built in Elementor and each section carries its
own background and text colours. Changing those is a page edit, not a theme
change — see LIGHT-MODE.md in the client pack. A stylesheet that forced them
would put white text on white cards.

Product photography and page copy. Also content.

== Changelog ================================================================

= 1.8.2 =
* Elementor's own global palette is replaced in the head: the kit still held
  the demo's orange, so every page built from it would have painted orange.
* Home page hierarchy: three display sizes instead of five, one content width,
  one vertical rhythm, the 111.129% width hack removed.
* The last demo colours on the home page: the promo pair's blue-black title,
  grey price and pure-black stars.

= 1.8.1 =
* Home page backgrounds and text: four dark sections become linen, the hero
  becomes teal, five white titles become teal, eyebrows become antique gold.

= 1.8.0 =
* Light storefront shell: white header, linen top bar, ink menu, white sticky
  and mobile menu, white page ground.
* index.php added — WordPress refuses to install a theme without one.

= 1.7.1 =
* index.php. Fixes "The theme is missing the index.php template."

= 1.7.0 =
* The colour system: tokens, components, dark mode, WooCommerce bridge.

= 1.6.0 =
* Palette sampled from the logo. Teal #0B4B4C, gold #C8AC77.

= 1.5.0 =
* Demo link repair, self-retiring: vendor URLs, -2 slugs, Instagram, cedi sign.

= 1.4.0 =
* Wholesale band, product-page trade line, wholesale page copy and form.

= 1.3.1 =
* Wholesale order flagging and the Trade admin column.

= 1.3.0 =
* Trade pricing, MOQ, application and approval.
