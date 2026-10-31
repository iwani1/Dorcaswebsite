<?php
/**
 * Fallback template.
 *
 * This file is required, not decorative. WordPress validates a theme's
 * structure before it will install or activate it, and a theme without
 * index.php is rejected with:
 *
 *   "The package could not be installed. The theme is missing the index.php
 *    template."
 *
 * A child theme needs one even though every real template — single, archive,
 * page, 404 — lives in the parent. This is the last resort WordPress falls
 * back to when nothing more specific matches.
 *
 * Rather than ship a bare loop, it hands over to the parent's index.php, so the
 * blog and archive layouts keep the design, the header, the footer and the
 * parent's hooks. Overriding them with a simplified loop here would quietly
 * replace the theme's design on every archive page.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

require get_template_directory() . '/index.php';
