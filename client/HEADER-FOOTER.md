# Header and footer — where each thing actually lives

There are **two** admin menus involved, and using the wrong one wastes an hour. This theme keeps the *design* apart from the *settings*.

---

## The map

| What you want to change | Where to go |
|---|---|
| **Header structure** — logo, menu position, search, cart icon, top bar | **Queen Dor's Fashion House Builder → Header Builder** (opens in Elementor) |
| **Footer structure** — columns, newsletter, social icons, payment logos | **Queen Dor's Fashion House Builder → Footer Builder** (opens in Elementor) |
| **Which header or footer the site actually uses** | **Queen Dor's Fashion House Options → Header** / **Footer** |
| The **logo image** | **Queen Dor's Fashion House Options → Logo** |
| The **copyright line** | **Queen Dor's Fashion House Options → Footer → Copyright Text** |
| **Menu links** (Home, Shop, About…) | **Appearance → Menus** — not the builder |
| Footer **widget columns**, if used | **Appearance → Widgets** |

Both menus sit in the left sidebar: *Queen Dor's Fashion House Options* and *Queen Dor's Fashion House Builder*.

---

## The catch in the Header tab

`Options → Header` has a choice called **Header Options**, and it decides everything:

- **Default** — the theme's built-in header. Editing a Header Builder layout changes **nothing** on the site.
- **Builder** (the second option) — only then does a dropdown appear listing your saved header layouts, and only then does the one you pick get used.

So: if you edit a header layout and the site doesn't change, this switch is why. Same pattern in the Footer tab, under **Footer Builder**.

---

## Typical jobs

### Replace the logo

**There is more than one logo.** This is what makes a new logo appear on desktop and not on the phone — the two are reading different fields.

| Where the image comes from | When it's the one shown |
|---|---|
| **Options → Logo** | The header's logo widget is set to **Logo Type: Dark** (the default) |
| **Appearance → Customize → Site Identity → Logo** | The widget is set to *Custom*, or to *White* with no white logo uploaded |
| **The logo widget's own “Choose logo” field** | Only when that widget's Logo Type is **Custom** — the option is then ignored |
| **The Mobile Menu widget's “Logo” field** | The slide-out hamburger panel on phones. A completely separate image. |

So a logo uploaded in the options panel updates every header that uses *Dark* — and nothing else. The mobile drawer and any *Custom* logo widget keep whatever they were given at import, which is why the old vendor mark survives on the phone.

**The thirty-second test:** on the phone, long-press the logo → *copy image address*. Do the same on desktop. If the URLs differ, it's a different field — go to that widget and replace it. If they're identical, it's cache, not the logo.

Use `brand/logo.png` from the pack. WordPress rejects `.svg`.

### Change the copyright line### Change the copyright line

`Options → Footer → Copyright Text`.

The demo shipped *"Copyright © … Luxrio. All Rights Reserved by Vecuro"*. Child theme 1.2.0 already replaces that string in code, so the footer reads `© 2026 Queen Dor's Fashion House. All rights reserved.` without you touching it. Editing this field overrides it with your own wording.

### Turn the footer bottom bar on or off

`Options → Footer → Footer Bottom?`. The copyright line only appears when this is on.

### Add a column, newsletter or social icons to the footer

`Queen Dor's Fashion House Builder → Footer Builder` → open the layout → **Edit with Elementor** → drag the widgets you want into the columns → **Update**.

Then confirm the layout is the one selected under `Options → Footer → Footer Builder`.

### Change menu colours

`Options → Header → Header Menu` — link colour, hover, submenu colours, submenu border. Design-level changes to the *layout* still belong in the builder.

---

## When an edit doesn't show

1. **Update/Publish** inside Elementor — the builder layouts are Elementor documents and save separately.
2. **Purge cache** — LiteSpeed Cache → Purge All.
3. **Check the mode switch** — `Header Options` / `Footer Builder` may still be pointing at the default.
4. **Hard reload** — `Ctrl + Shift + R`.

If it still hasn't changed, the page you're editing isn't the one being displayed: Elementor keeps header/footer templates as posts, and only the selected one is rendered.
