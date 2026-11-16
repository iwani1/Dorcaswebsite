# Matching the site to the logo

The logo is two colours: a deep teal for the **D** monogram and *Fashion house*, and a warm gold for *QueenDor's* and the crown. Sampled from the file rather than guessed:

| Colour | Hex | Where it's sampled from | What it does on the site |
|---|---|---|---|
| **Teal** | `#0B4B4C` | the D's stroke | buttons, links, prices, headings |
| **Gold** | `#C8AC77` | "QueenDor's" and the crown | borders, rules, hover states |
| Cream | `#F7F3EA` | — | section backgrounds |
| Ink | `#3F4A49` | — | body copy |

Ships in **child theme 1.7.0** — see `COLOR-SYSTEM.md` for the complete system, and `brand/preview.html` for the page to show the client.

---

## Why gold isn't used for text

Measured, not felt:

- **Teal on white: 9.9:1** — comfortably above the 4.5:1 that normal text needs
- **Gold on white: 2.2:1** — below even the 3:1 threshold for large text

So gold does what the logo uses it for: an accent beside something heavier. Buttons hover into gold with dark text on top; rules and underlines are gold; prices and links are teal. A gold sentence on white would be unreadable, and on a phone in sunlight it would be invisible.

---

## What changes the moment you upload

The parent theme feeds almost every colour through CSS variables — there is exactly **one** hardcoded colour in its entire stylesheet — so setting four values repaints the site:

- primary buttons (the orange "SHOP NOW" becomes teal)
- link colours and hover states
- prices throughout the shop
- breadcrumb bars, small circular controls, back-to-top
- the wholesale band, which was built in the demo's gold and is now in yours

## What it won't change

**Section backgrounds set in Elementor.** The hero is a black section, chosen by the page, not the theme — it stays black until you change it. To finish the job: open the hero section → `Style → Background` → set it to the teal, or to cream if you want the page to read lighter.

**Images.** The photos carry their own colour. Nothing here touches them.

**The logo itself** — separately, it's still the file at `wp-content/uploads/2024/11/logo.svg`. Upload the client's PNG in `Theme Options → Logo` if that still shows the demo mark.

---

## Two ways to set it, both valid

**Option A — the settings panel.** `Theme Options → General`:

| Field | Value |
|---|---|
| Primary Color | `#0B4B4C` |
| Secondary Color | `#C8AC77` |
| Heading Color | `#0B4B4C` |

**Option B — the child theme.** Already done in 1.6.0. It also covers the few places the theme hardcodes rather than uses a variable, and it survives someone resetting the options.

Doing both is fine and they won't fight: the child theme loads last.

To change the palette later, edit `tools/brand_palette.py` and run `python3 tools/build-brand-assets.py` — the CSS, the Figma tokens, the preview page and the PDF all regenerate together. See `COLOR-SYSTEM.md` for the full system.

---

## The recommendation

**Prices in teal. Not gold.** Four reasons, in order of weight:

1. **It fails on the surface it lives on.** A price is small text on a white page. Gold measures **2.2:1** there — below even the 3:1 allowed for large type. Teal measures **9.9:1**, roughly double what AA asks for. This alone decides it.
2. **Ghana is a phone market, used outdoors.** Low-contrast type is the first thing to disappear in sunlight, and the price is the one number the customer came for.
3. **Gold price + gold everything = noise.** Accent only works by contrast with restraint. If gold is on the price, the button, the rule and the hover, it stops being an accent.
4. **It costs nothing.** The price already inherits the theme colour. Teal is the default; gold would be an override.

### But the colours aren't interchangeable — that's the real finding

Each one dies on the surface the other is built for:

| | on white | on cream | on teal | on black |
|---|---|---|---|---|
| **Teal** `#0B4B4C` | 9.9:1 | 8.9:1 | — | **2.1:1** |
| **Gold** `#C8AC77` | 2.2:1 | 2.0:1 | 4.5:1 | 9.7:1 |

Teal is a **light-surface** accent. Gold is a **dark-surface** accent. Neither is the brand colour "in general" — they're brand colours *for a surface*.

So 1.6.0 includes a `qd-on-dark` class: put it on any dark Elementor section (Section → Advanced → CSS Classes) and the links, prices and buttons inside it turn gold automatically. Use it on the wholesale band, the footer, and the hero if it stays dark.

## The hero — the one thing I'd change before showing the client

The hero is a black section. Left as it is, two things happen:

- **The top third of the site ignores the new palette.** The client will notice immediately: "you said you matched the logo, but the top is still black."
- **A teal button on black is nearly invisible** — 2.1:1. The main call to action would dim the moment we repaint.

**Recommendation:** make the hero section **teal**, keep the headline cream or white, and make the button **gold**. That gives you the palette in the most valuable 700 pixels on the site, and it's a better look than black anyway — black heroes are the most common thing on the internet, and this is the one brand asset nobody else has.

If the photography is dark and dramatic and black suits it better, then keep black and add `qd-on-dark` to the section so the button goes gold. What you must not do is leave a teal button on a black field.

## Where gold belongs — three places, no more

1. The wholesale band (a dark surface — gold reads at 9.7:1 there)
2. Rules, underlines and the small gold hairlines on cards
3. Hover states on buttons

That's it. Gold earns its "luxury" reading by scarcity; spread it around and it becomes a mustard.

## If the client wants a different balance

The current split is **teal-led**, matching how the logo reads at small size: the mark and the descriptor are teal, the name is gold.

If they'd rather the shop felt warmer — more gold, less teal — the change is one line: set `--theme-color` to the gold and `--theme-color2` to the teal. Worth showing them both on screen before deciding, because gold buttons on a white page look luxurious at full size and washed out on a phone.

Ask them one question: **on a white background, should the price be teal or gold?** That single answer settles the balance, because the price appears on every product in the shop.
