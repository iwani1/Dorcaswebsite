# Matching the site to the logo

The logo is two colours: a deep teal for the **D** monogram and *Fashion house*, and a warm gold for *QueenDor's* and the crown. Sampled from the file rather than guessed:

| Colour | Hex | Where it's sampled from | What it does on the site |
|---|---|---|---|
| **Teal** | `#0B4B4C` | the D's stroke | buttons, links, prices, headings |
| **Gold** | `#C8AC77` | "QueenDor's" and the crown | borders, rules, hover states |
| Cream | `#F7F3EA` | — | section backgrounds |
| Ink | `#3F4A49` | — | body copy |

Ships in **child theme 1.6.0**.

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

To change the palette later, edit `assets/css/brand-colours.css` in the child theme — four lines at the top.

---

## If the client wants a different balance

The current split is **teal-led**, matching how the logo reads at small size: the mark and the descriptor are teal, the name is gold.

If they'd rather the shop felt warmer — more gold, less teal — the change is one line: set `--theme-color` to the gold and `--theme-color2` to the teal. Worth showing them both on screen before deciding, because gold buttons on a white page look luxurious at full size and washed out on a phone.

Ask them one question: **on a white background, should the price be teal or gold?** That single answer settles the balance, because the price appears on every product in the shop.
