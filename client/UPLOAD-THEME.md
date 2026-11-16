# Uploading the theme

**File:** `luxrio-child-1.7.1.zip` (221 KB)

---

## Why 1.7.0 would not install

It was missing `index.php`. WordPress validates a theme's structure before it
accepts it and refuses the whole package:

> The package could not be installed. The theme is missing the `index.php` template.

A child theme needs one even though every real template — single, archive, page,
404 — lives in the parent. 1.7.1 adds it, and it hands over to the parent's
`index.php`, so blog and archive pages keep the theme's design rather than
falling back to a bare loop.

The build script now refuses to produce a zip without it, so this cannot recur.

---

## Install

1. Keep the old theme installed. You are uploading *over* it, not switching to
   something new — the parent theme `luxrio` must stay installed too.
2. **Appearance → Themes → Add New → Upload Theme.**
3. Choose `luxrio-child-1.7.1.zip` → **Install Now.**
4. You will be offered **Replace current with uploaded** → click it.
5. Do **not** activate a different theme in between. If you activate the parent
   by accident, the child deactivates and the site loses its styling until you
   switch back.

**Back up first** — *Plugins → UpdraftPlus*, or your host's one-click backup. A
theme swap is the one operation that can leave the site unstyled, and a backup
turns a 30-minute fire into a 2-minute restore.

---

## Then clear the cache, in this order

Order matters: the stylesheets carry a version number, so a stale page is almost
always a caching layer, not a broken theme.

1. **Elementor → Tools → Regenerate CSS & Data** (the theme's own element CSS).
2. Your caching plugin (LiteSpeed, W3TC, WP Super Cache) → **Purge all**.
3. GreenGeeks → **cPanel → LiteSpeed Web Cache Manager → Flush All** if present.
4. The browser: a private window, not a normal refresh.

If the site still shows the old orange after all four, the theme did not replace.
Check **Appearance → Themes → Queen Dor's Child → Version 1.7.1**.

---

## What to check, in one minute

Open the shop in a private window and look for these four:

| Check | Should be | If not |
|---|---|---|
| Header menu link | `…/shop/` | theme still the old one, or a menu cache |
| A price | `₵320.00` | the `GHC` → `₵` rewrite (1.5.0) is not running |
| Any button | deep **teal** | stylesheet not loading — see below |
| Hover a button | **gold** | same |

### If buttons are still orange

The palette is in `brand-tokens.css` and `brand-components.css`, loaded after the
theme's own colours. Two ways it fails, in order of likelihood:

1. **Caching** — see the four steps above.
2. **The theme options are overriding it.** `Theme Options → General` may hold
   the demo's orange. Set Primary `#0B4B4C`, Secondary `#C8AC77`, Heading
   `#0B4B4C`. This is belt and braces: the child theme loads last and wins, but
   setting both removes any doubt.

---

## One field to add in Elementor

The hero is a **black** section. Teal on black measures 2.1:1, so a teal button
there is nearly invisible and the gold hover is the only thing that reads.

Open the hero section → **Advanced → CSS Classes** → type:

```
qd-on-dark
```

Everything inside the hero — buttons, links, prices — turns gold automatically.
Do the same on any other dark or teal section (the wholesale band already handles
itself).

Do this in the same sitting as **step 2 of `HOMEPAGE-FIX.md`**, where you are
rewriting that hero anyway.

---

## What is in the package

| File | What changed |
|---|---|
| `index.php` | **new** — the file that was blocking installation |
| `assets/css/brand-tokens.css` | **new** — palette, semantic tokens, dark mode, spacing, radius, shadows |
| `assets/css/brand-components.css` | **new** — buttons, links, fields, cards, nav, states, WooCommerce bridge |
| `inc/brand-colours.php` | now loads the two token files instead of the old single stylesheet |
| `assets/css/queendor.css`, `wholesale.css` | unchanged; wholesale re-coloured to the logo palette |
| `inc/*` (rebrand, demo-links, wholesale, ring-size, symbol-guide) | unchanged since 1.5.0 |

---

## If it goes wrong

Switch to the parent theme `luxrio` in **Appearance → Themes**. The site will
look like the demo, but it will be up and you can re-upload. Nothing in the child
theme touches the database, so switching back restores everything.

The one thing that does touch the database is `queendor-cleanup-1.0.1.zip`. If
you have already run it, do not run it twice — it deletes demo pages by name, and
on a second run those pages are already gone.
