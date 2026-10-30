# Dorcas Website — Luxrio theme (WordPress / WooCommerce)

Working repository for the **Luxrio** jewellery eCommerce store build.

The parent theme and its companion plugin are vendored here as **tracked source** (not as ZIPs) so that every change is reviewable, diffable and deployable.

---

## Provenance

| | |
|---|---|
| Vendor package | `luxrio_ecommerce_jewellery_wordpress_theme_2026_01_15_10_39_49_u.zip` |
| Package MD5 | `8ea79e0f4a8bb7a92a0df66c810bbe6a` |
| Theme | Luxrio **1.0.1** — Vecurosoft (`vecurosoft.com`) |
| Companion plugin | Luxrio Core **1.0.1** |
| Child theme | Luxrio Child 1.0.0 |
| License | GPLv2-or-later (PHP/HTML); design & images under the ThemeForest item license |
| Full static analysis | [`ANALYSIS.md`](ANALYSIS.md) |

The original ZIP is intentionally **not** committed — keep it as a GitHub release asset or off-repo backup.

---

## Layout

```
wp-content/
├── themes/
│   ├── luxrio/                     # parent theme (vendored, patched — do not edit for design work)
│   │   ├── assets/
│   │   │   ├── css/style.css       # readable source
│   │   │   ├── css/style.min.css   # what is actually enqueued
│   │   │   ├── css/style-editor.css# block editor typography
│   │   │   ├── fonts/              # Font Awesome 6 Free (woff2 only) + OFL licence
│   │   │   └── sass/               # SCSS sources for style.css
│   │   ├── inc/                    # framework: Redux options, CMB2 meta, hooks, demo import
│   │   └── woocommerce/            # 34 template overrides
│   └── luxrio-child/               # put all project customisation here
└── plugins/
    └── luxrio-core/                # companion plugin source (Elementor widgets, header/footer builder)

tools/
└── build-core-plugin-zip.sh        # rebuilds the plugin bundle the theme installer ships
```

> **All customisation belongs in `luxrio-child`.** The parent theme is patched only to stay deployable, so it can be re-diffed against future vendor releases.

---

## Deployment

1. Copy `wp-content/themes/luxrio`, `wp-content/themes/luxrio-child` and `wp-content/plugins/luxrio-core` to the server.
2. Activate **Luxrio Child** (the parent is a dependency, not the active theme).
3. Activate **Luxrio Core** manually — the theme's installer also bundles it, but deploying the tracked source keeps it in sync with this repo.
4. Install the remaining third-party plugins from **Appearance → Install Plugins** (WooCommerce, Elementor, Redux, CMB2, Contact Form 7, TI Wishlist, One Click Demo Import, Variation Swatches, Max Mega Menu, WPC Smart Quick View, Side Cart).
5. Import demo content **only on a fresh site** — see the demo-import notes below.

---

## Changes made to the vendor code

### Font Awesome Pro → Font Awesome Free 6.6.0
The vendor package shipped **Font Awesome Pro 6.6.0** (`thin`/`light`/`duotone`/`sharp-*`), whose commercial licence does not permit redistribution inside a theme. It has been replaced with the official **Font Awesome Free 6.6.0** npm build:

- `assets/css/fontawesome.min.css` → official `all.min.css`, repointed to `../fonts/`, TTF fallbacks stripped.
- `assets/fonts/` → 4 woff2 files (solid, regular, brands, v4-compat) + `LICENSE-FontAwesome-Free.txt`. **18 MB → 312 KB.**
- All Pro-only icon classes remapped across theme, plugin and demo content: `fal`/`fa-light` → `far` or `fas`, and every `far` that Font Awesome Free does not ship in Regular was moved to `fas`.
- `--icon-font` / pseudo-element families switched from `"Font Awesome 6 Pro"` / `"Font Awesome 5 Pro"` to `"Font Awesome 6 Free"`.
- All **88** remaining icon references validated against the FA 6.6.0 metadata (name and weight both exist).

### Correctness fixes
| File | Fix |
|---|---|
| `inc/luxrio-framework/plugins-activation/luxrio-active-plugins.php` | Plugin name/slug pairs were swapped — "WPC Smart Quick View" pointed at `side-cart-woocommerce` and vice-versa. Corrected. |
| `assets/css/style-editor.css` | **Created.** `add_editor_style()` referenced a file that did not exist (404 on every editor load). |
| `inc/demo-data/demo-import.php` | `get_page_by_title()` (deprecated in WP 6.2) → `WP_Query`; `WP_Post`/`WP_Term` guards around menu and front-page assignment; Elementor cache clear wrapped in `class_exists()`/`method_exists()`; `$_GET['page']` sanitised; Elementor kit write guarded. The import can no longer fatal halfway through. |
| `inc/luxrio-commoncss.php` | The 0-byte `color.schemes.css` request is gone — the handle is now registered inline-only (`wp_register_style( …, false )`). Dead assignment removed. |
| `woocommerce/myaccount/form-login.php` | `sanitize_text_field()` / `sanitize_email()` added to the three `wp_unslash( $_POST[…] )` reads. |
| `inc/essential-scripts.php` | Hardcoded, wrong version strings (Bootstrap shipped as v5.0.0-beta1 but labelled `4.3.1`, Slick as `4.0.13`, …) replaced with a `luxrio_asset_version()` helper keyed to file modification time. Main stylesheet now enqueues `style.min.css`. |
| `assets/img/logo.svg`, `logo-white.svg` | **Created** as neutral placeholders. The theme's default logo previously pointed at `wordpress.vecurosoft.com`. |
| `assets/css/style.min.css` | **Created** (283.8 KB → 230.7 KB). `style.css.map` removed. |
| `wp-content/plugins/luxrio-core/**` | `ABSPATH` guards added to 43 files that lacked one (1 more uncommented); 2 HTML-only partials intentionally skipped. |
| all text files | Line endings normalised to LF. |

### Known remaining issues (deliberately not changed)
- **Google Fonts** (Cormorant, Italiana, Poppins) are still fetched from `fonts.googleapis.com`. Self-hosting needs the font binaries, which were not available in this environment. GDPR/CWV impact.
- **WooCommerce overrides** span template versions 1.6.4 → 9.7.0 and several are stale. Check **WooCommerce → Status → Templates** after deployment and refresh them against your WooCommerce version. No HPOS compatibility is declared.
- **12 plugins are flagged `required`** with no version pins. Pin the versions you ship and update them deliberately.
- Bootstrap 5.0.0-**beta1** (2020) is still the bundled framework.
- No `<main>` landmark on pages (only when the scroll-animation option is on), no skip link.
- `readme.txt` still carries the vendor changelog; the theme version was left at 1.0.1 to avoid implying a vendor release.

---

## Verification performed

- **All 127 PHP files parse cleanly** (`php-parser` AST parse; control test confirmed the linter catches broken syntax).
- All 88 icon references validated against Font Awesome 6.6.0 metadata.
- CSS minification preserves rule/brace counts and `content:"\f0c1"` escapes.
- `luxrio-core.zip` rebuilt from patched source and verified byte-for-byte against it.

**Not performed:** PHP lint via `php -l`, WordPress load test, browser/visual QA, WooCommerce checkout testing, Lighthouse. None of that is possible without a running WordPress install — **smoke-test on staging and place a real test order before going live.**

---

## Maintenance

Patch the plugin in `wp-content/plugins/luxrio-core/`, then rebuild the bundle the theme installer ships:

```bash
./tools/build-core-plugin-zip.sh
```

The script exists so the tracked source and the installer bundle cannot silently drift apart.

### Rebuilding the stylesheet

`assets/css/style.css` is the readable source (compiled from `assets/sass/`); the front end loads `assets/css/style.min.css`. After any CSS change:

```bash
python3 -c "import rcssmin,sys; open('wp-content/themes/luxrio/assets/css/style.min.css','w').write(rcssmin.cssmin(open('wp-content/themes/luxrio/assets/css/style.css').read()))"
```

The enqueue helper keys the cache-busting version to the file's mtime, so a rebuilt file is picked up automatically.

---

## Measured effect of this patch set

| | Vendor package | Now |
|---|---|---|
| Theme working tree | 24 MB | 5.5 MB |
| Webfonts | 18.0 MB (31 files, 6 formats) | 312 KB (4 files, woff2 only) |
| CSS served on the front end | 993.5 KB | 527.9 KB |
| Main stylesheet | 283.8 KB unminified + 59 KB map | 230.7 KB minified, no map |
| Requests per page load | +1 empty stylesheet | –1 |
| PHP files failing a direct-access guard (plugin) | 44 | 0 |
