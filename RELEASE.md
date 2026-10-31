# Release state

## Ship this: `QueenDors-child-theme-1.8.1.zip` — 225 KB

Background and text colour on the home page, plus the light shell. Nothing else.

| | |
|---|---|
| `brand-light.css` | white header and top bar, ink menu, white page ground |
| + section repaint | the four dark home-page sections become linen; the hero becomes teal |
| + title colours | five white titles become teal; eyebrows become antique gold |
| Photography | **untouched** |
| Copy | **untouched** |

### How the sections were targeted

Not by guessing. The home page's own Elementor stylesheet was fetched from the
live site — `/wp-content/uploads/elementor/css/post-25.css` — and it states every
section's background and every title's colour by ID:

| ID | Was | Now |
|---|---|---|
| `3c5f51b` hero section | dark background image | teal `#0B4B4C` |
| `c25843e` hero container | `#020203` + image | transparent |
| `e2bd445` categories band | background image | linen `#FAF8F5` |
| `e900ec0` product band | background image | linen `#FAF8F5` |
| `ee5646a` story band | photo + orange `#CF6D03` veil | linen, veil removed |
| `01e6aeb` `3031698` `181ea56` `adfb89e` `1e90125` | white titles | teal |

Scoped to `.elementor-25`, which is the home page only. Other pages are not
touched by this pass.

**What I could not check:** the result on screen. The selectors are exact and
come from the site's own CSS, but a browser is the only way to confirm the page
looks right — so if something reads badly, send a screenshot of that band and
I'll adjust the one ID responsible.

## Known good fallback: `QueenDors-child-theme-1.7.1.zip` — 221 KB

The version currently live before this change, built from its own commit. If
1.8.1 ever looks wrong in public, re-upload this: same files, dark header.

## Parked: 1.8.0

Superseded. Its light shell is inside 1.8.1 — shipping the white header without
the section backgrounds was the half-measure that made it look unfinished.

## Still not done, and not attempted here

- Product photography (nine of ten products have no image)
- The twelve dead category tiles, the empty carousel, the five-photo strip
- Copy: `worldwid`, `High Class Jewelry`, the mixed American/British spelling
- The footer renders nothing — check `Options → Footer`
