# Release state

## Ship this: `QueenDors-child-theme-1.8.5.zip` — 227 KB

The text-visibility fix. 1.8.4's light layer left the theme's own templates —
shop, product, cart, checkout, account, policies, blog — with white headings and
pale grey body copy on a white page: 1.00:1 and 1.61:1. Both are now driven from
the variables the theme actually reads, and headings are repainted only inside
those templates.

Also in this version: header on teal (1.8.4), light home page (1.8.3), display
scale, orange removal, menu trim.

Full findings with the measured table: `client/CONTRAST-AUDIT.md`.

## Superseded: `QueenDors-child-theme-1.8.3.zip` — 226 KB

The light storefront, rebuilt against the page **as it now is** (post 1628, after
the template import) — plus the demo palette removed at its source. This is the
answer to the client sending the Bijoux reference: warm ground, dark type, gold
in small doses.

| | |
|---|---|
| white page, linen bands, white header, teal hero | `brand-light.css` |
| the orange veil and the orange global colour | gone — 3.59:1 was the only AA failure |
| display scale, width hack, rhythm | 60/40/32, one content width, one padding |
| menu trim | carried forward from 1.7.2 |

Undo without touching files: `add_filter( 'queendor_light_storefront', '__return_false' );`
Full reasoning: `client/CLIENT-REFERENCE-BIJOUX.md`.

## Also good: `QueenDors-child-theme-1.7.2.zip` — 222 KB

1.7.1 plus one change: the header menu stops wrapping. Cart and Checkout leave
the menu (they are already in the header — cart icon with count, and cart leads to
checkout), which puts Jewelry House / Wholesale / FAQ's / Contact / Shop / My
account on one line instead of two.

| | |
|---|---|
| `inc/menu-trim.php` | new — front-end filter on `wp_nav_menu_objects` |
| the stored menu | **untouched** — items return if the theme is rolled back |
| everything else | identical to 1.7.1 |

Off-switch: `add_filter( 'queendor_trim_header_menu', '__return_false' );`

## Live: `1.7.1` — confirmed from the server on 2026-10-31, twice:

- `…/themes/luxrio-child/style.css` reports `Version: 1.7.1` with a cache-buster.
- `…/themes/luxrio-child/assets/css/brand-light.css` returns **404**, so the
  1.8.x files are gone from the server — this is a real downgrade, not a
  half-applied one.

The repo's theme directory is now **byte-identical to the 1.7.1 build**
(`git diff 963c656 -- wp-content/themes/luxrio-child` is empty). Nothing from
1.8.0, 1.8.1 or 1.8.2 is in the tree.

## One thing to check on the site

The first, uncached-looking request for `style.css` returned **`Version: 1.8.1`**
from LiteSpeed's page cache; the same URL with a query string returned `1.7.1`.
So the theme file on disk is right, but **a cached copy of the newer stylesheet is
still being served to some visitors**. Purge it:

1. LiteSpeed Cache → Toolbox → **Purge All**
2. If a CDN is in front (Cloudflare), purge that too
3. Reload the homepage with `?test=1` appended to bypass the cache

Until that is done, whether a visitor sees the dark header (1.7.1) or the light one
(1.8.1) is a coin toss.

## What was discarded

| Item | Status |
|---|---|
| 1.8.0 / 1.8.1 light shell and home-page repaint | removed from the tree |
| 1.8.2 hierarchy pass (`brand-light.css` §4) | removed from the tree |
| 1.8.2 Elementor global-palette override | removed from the tree |
| `QueenDors-child-theme-1.8.1.zip`, `…-1.8.2.zip` | deleted from the repo root |

The commits are still in history (`210289f`, `75aa705`), so any of it can be
brought back with one `git checkout` if you change your mind. Nothing was
force-pushed and nothing was rewritten.

## Kept deliberately

- **`client/HOMEPAGE-ANALYSIS.md`** and **`client/HOMEPAGE-UI-COLOUR.md`** — the
  two audits. They describe the demo's faults and where the colour work would go;
  they are findings, not site changes, and they are still true.
- **`tools/build-client-pack.sh`** — the version that no longer deletes other
  release zips from the root. Reverting that would bring back the bug where a
  build wiped the pinned 1.7.1 zip.

Say the word and both go.

## The catch with 1.7.1

`style.css` now reads `Version: 1.7.1`. WordPress refuses to upload a theme zip
at a version already installed ("destination folder already exists" / no update
offered), so **the next release has to carry a higher number** — 1.7.2 or 1.8.3,
not 1.7.1 again.

1.7.1 also predates the light shell, so the site is back to the demo's black
top bar, black header, and four dark home-page sections. That is the version you
preferred, so this is recorded rather than argued with.
