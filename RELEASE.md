# Release state

## Ship this: `QueenDors-child-theme-1.8.2.zip` — 227 KB

The fix pass for the home page's UI and colour. Upload it over 1.8.1.

| | |
|---|---|
| `brand-light.css` §4 | three display sizes instead of five; one content width; one vertical rhythm; the `111.129%` width hack removed |
| `brand-light.css` §4.5 | the promo pair's blue-black title, grey price and pure-black stars — the last demo colours on the page |
| `brand-colours.php` | Elementor's **global palette** replaced in the head: the kit still held the demo's orange |
| Photography | **untouched** |
| Copy | **untouched** |
| Other pages | **untouched** — only the kit's global colours reach them |

### What changed, and why each one

| Item | Before | After | Why |
|---|---|---|---|
| Display scale | 90/85, 80/95, 46/52, plus two sizes nobody set | 60/68, 40/50, 32/42 | five equal shouts, no focal point below the hero |
| Title width | `width: 111.129%` on two titles | 100% | 11% wider than the column is how a page starts scrolling sideways on a phone |
| Content width | 1600px promo row, 1330px every band | 1330px throughout | the gutters jumped 270px in one scroll |
| Section padding | 120/90, 120/120, 120/90, 160/160 | 120/120 (80/80 tablet) | four rhythms with no logic behind the differences |
| Promo title / price | `#021210` / `#3C3B3B` | ink / teal | demo neutrals in a warm palette |
| Star rating | `#000000` | antique gold `#8F6B28` | pure black is the one colour the palette does not contain |
| Eyebrow tracking | 3px | 1.8px | a gap per letter, at ~13px text |
| Elementor globals | demo orange `#ff3e01` | teal / gold / ink / antique gold | the home page was protected by ID, every future page would not be |

### The global palette, specifically

The page's own stylesheet still reads:

```css
.elementor-element-181ea56 .title-selector span { color: var(--e-global-color-luxrio_opt_primary); }
```

That variable is the demo kit's orange. `inc/brand-colours.php` now redeclares it,
and Elementor's standard four, on `body[class*="elementor-kit-"]` at `wp_head`
priority 99 — higher specificity than the kit's own rule, so it wins wherever a
global colour is used, on every page. The kit screen can still be set properly
later; nothing here depends on that being done.

Turn it off independently of everything else:
`add_filter( 'queendor_brand_kit_palette', '__return_false' );`

**What I could not check:** the result on screen. Every selector is transcribed
from `post-25.css`, but only a browser confirms it looks right. If a band reads
badly, send a screenshot and I'll adjust the one ID responsible.

## Live: `1.8.1` — background and text colour only

Still on the site until 1.8.2 is uploaded. Contains the light shell and the
home-page repaint, without the hierarchy pass.

## Superseded: `QueenDors-child-theme-1.8.1.zip` — 225 KB

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
