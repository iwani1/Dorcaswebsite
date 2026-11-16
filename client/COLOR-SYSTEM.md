# Queen Dor's — colour system

> Generated from `tools/brand_palette.py`. The CSS, the Figma tokens, the PDF and the
> preview page all read the same file, so a colour cannot be right in one place and
> wrong in another.

**Site type:** e-commerce — Adinkra jewellery, retail and wholesale.
**Personality:** rooted, luxurious, unhurried, trustworthy — cultural specificity over
generic "premium".
**Audience:** Accra retail buyers, 25–45, mostly on phones, often outdoors; plus
wholesale stockists.
**Constraint that shapes everything:** low-contrast type dies in Ghanaian daylight on a
mid-range Android screen. Legibility outranks subtlety wherever the two argue.

---

## 1 — Palette extraction

The logo gives two colours and no more: **Adinkra Teal `#0B4B4C`** from the D
monogram, and **Crown Gold `#C8AC77`** from "QueenDor's" and the crown. Both are
sampled from the file rather than picked by eye. Everything else is derived by holding
the sampled hue and moving lightness, so every step belongs to the same family as the
mark.

| | | |
|---|---|---|
| Logo teal | `#0B4B4C` | hue 181°, sat 75%, light 17% |
| Logo gold | `#C8AC77` | hue 39°, sat 42%, light 63% |

### Ramps

**Adinkra Teal — hue 181°**

| | **50** | **100** | **200** | **300** | **400** | **500** | **600** | **700** | **800** | **900** | **950** |
|---|---|---|---|---|---|---|---|---|---|---|---|
| HEX | `#F1F9F9` | `#E2F3F4` | `#C4E8E9` | `#98D6D7` | `#63C4C5` | `#36A9AB` | `#218B8C` | `#146F71` | `#0B4B4C` | `#093435` | `#072122` |

**Crown Gold — hue 39°**

| | **50** | **100** | **200** | **300** | **400** | **500** | **600** | **700** | **800** | **900** | **950** |
|---|---|---|---|---|---|---|---|---|---|---|---|
| HEX | `#FBF7EF` | `#F7EEDE` | `#EFDFC3` | `#E3CCA0` | `#C8AC77` | `#C09A54` | `#AE8537` | `#8F6B28` | `#695021` | `#47371A` | `#2B2212` |

**Warm neutrals — hue 40°, low saturation**

| | **0** | **50** | **100** | **200** | **300** | **400** | **500** | **600** | **700** | **800** | **900** | **950** |
|---|---|---|---|---|---|---|---|---|---|---|---|---|
| HEX | `#FFFFFF` | `#FAF8F5` | `#F3EFE8` | `#E6E1D5` | `#D3CBBB` | `#AEA593` | `#8F8676` | `#6C665A` | `#524E47` | `#34322D` | `#211F1C` | `#141210` |

### The colours that carry the brand

| Colour | HEX | RGB | HSL | Role |
|---|---|---|---|---|
| **Adinkra Teal** | `#0B4B4C` | 11, 75, 76 | 180.9°, 74.7%, 17.1% | Primary — buttons, links, prices, headings |
| **Deep Adinkra** | `#093435` | 9, 52, 53 | 181.4°, 71.0%, 12.2% | Hover and active on primary; footer fields |
| **Midnight Adinkra** | `#072122` | 7, 33, 34 | 182.2°, 65.9%, 8.0% | Hero overlay, overlay scrims |
| **Pale Adinkra** | `#98D6D7` | 152, 214, 215 | 181.0°, 44.1%, 72.0% | Dark-mode primary, teal illustration accents |
| **Teal Mist** | `#F1F9F9` | 241, 249, 249 | 180.0°, 40.0%, 96.1% | Primary-subtle backgrounds, table stripes |
| **Crown Gold** | `#C8AC77` | 200, 172, 119 | 39.3°, 42.4%, 62.5% | Accent — rules, hover, dark-section buttons |
| **Antique Gold** | `#8F6B28` | 143, 107, 40 | 39.0°, 56.3%, 35.9% | The only gold allowed as text on light |
| **Champagne** | `#EFDFC3` | 239, 223, 195 | 38.2°, 57.9%, 85.1% | Badge fills, subtle accent backgrounds |
| **Linen** | `#FAF8F5` | 250, 248, 245 | 36.0°, 33.3%, 97.1% | Section background, alternating with white |
| **Parchment** | `#F3EFE8` | 243, 239, 232 | 38.2°, 31.4%, 93.1% | Muted panels, disabled fields |
| **Warm Ash** | `#6C665A` | 108, 102, 90 | 40.0°, 9.1%, 38.8% | Muted text — 5.7:1 on white |
| **Charcoal Ink** | `#211F1C` | 33, 31, 28 | 36.0°, 8.2%, 12.0% | Body-intense text and headings |

**Why the neutrals are warm.** Every neutral carries hue 40 at 7–14% saturation. Neutral
grey next to Crown Gold looks cold and slightly dirty; a warm grey of the same lightness
reads as linen. This is the single cheapest upgrade in the whole system.

---

## 2 — Roles and priority

| Role | Token | Value | Why it fits |
|---|---|---|---|
| **Primary** | `--qd-primary` | `#0B4B4C` | The logo's own colour. 9.9:1 on white, so it can carry both brand and action without a second colour. |
| **Secondary** | `--qd-primary-hover` | `#093435` | Depth, not a new colour — hover and active must feel like the same thing pressed. |
| **Accent** | `--qd-accent` | `#C8AC77` | The precious colour. Its weakness on white (2.2:1) is exactly why it stays scarce. |
| **Accent text** | `--qd-accent-text` | `#8F6B28` | Same metal, darkened until it can legally carry a sentence (4.9:1). |
| **Background** | `--qd-bg-page` | `#FFFFFF` | Product photography needs a clean field. |
| **Subtle background** | `--qd-bg-subtle` | `#FAF8F5` | Rhythm between sections without a border. |
| **Surface** | `--qd-surface-card` | `#FFFFFF` | Cards float on a hairline, not on a heavy shadow. |
| **Text primary** | `--qd-text-primary` | `#211F1C` | 16.4:1. Nothing worth reading should need squinting. |
| **Text heading** | `--qd-text-heading` | `#0B4B4C` | Ties headings to the mark; the serif carries it at large sizes. |
| **Text muted** | `--qd-text-muted` | `#6C665A` | 5.7:1 — captions and help text stay AA at body size. |

### The 60–30–10 ratio

- **60% neutral** — white product fields, linen bands. The room the jewellery sits in.
- **30% teal** — buttons, links, prices, headings, dark sections. The brand doing the work.
- **10% gold** — rules, hover states, one band, the logo.

Gold is the 10 *by definition*. At 30% it stops reading as precious and starts reading as
beige — which is the most common way a gold-and-teal brand ends up looking like a hotel
lobby.

---

## 3 — Contrast and accessibility

Judged against WCAG 2.1: **AA 4.5:1** normal text, **AAA 7:1**, **3:1** large text
(≥18.66px bold or ≥24px). Borders and controls are judged on **1.4.11**, which asks 3:1
of non-text.

**Light mode**

| Pairing | Text | Background | Ratio | AA normal | AA large |
|---|---|---|---|---|---|
| Body text | `#211F1C` | `#FFFFFF` | **16.44:1** | AAA | AAA |
| Headings | `#0B4B4C` | `#FFFFFF` | **9.88:1** | AAA | AAA |
| Secondary text | `#3F4A49` | `#FFFFFF` | **9.18:1** | AAA | AAA |
| Muted text | `#6C665A` | `#FFFFFF` | **5.70:1** | AA | AAA |
| Muted text on cream | `#6C665A` | `#FAF8F5` | **5.37:1** | AA | AAA |
| Link / heading | `#0B4B4C` | `#FFFFFF` | **9.88:1** | AAA | AAA |
| Link on cream | `#0B4B4C` | `#FAF8F5` | **9.32:1** | AAA | AAA |
| Primary button label | `#FAF8F5` | `#0B4B4C` | **9.32:1** | AAA | AAA |
| Gold label on teal | `#C8AC77` | `#0B4B4C` | **4.53:1** | AA | AAA |
| Dark-section body | `#FAF8F5` | `#0B4B4C` | **9.32:1** | AAA | AAA |
| Gold as text on white | `#C8AC77` | `#FFFFFF` | **2.18:1** | **FAIL** | FAIL |
| Antique gold as text | `#8F6B28` | `#FFFFFF` | **4.88:1** | AA | AAA |
| Input border vs page | `#8F8676` | `#FFFFFF` | **3.60:1** | 3:1 ✓ | — |
| Error text | `#7C3027` | `#FFFFFF` | **9.09:1** | AAA | AAA |
| Success text | `#2F6A4E` | `#FFFFFF` | **6.38:1** | AA | AAA |
| Warning text | `#7A541F` | `#FFFFFF` | **6.74:1** | AA | AAA |

**Dark mode**

| Pairing | Text | Background | Ratio | AA normal | AA large |
|---|---|---|---|---|---|
| Body text | `#EDEAE0` | `#0A1211` | **15.75:1** | AAA | AAA |
| Secondary text | `#CDCBBD` | `#0A1211` | **11.62:1** | AAA | AAA |
| Muted text | `#A3A296` | `#0A1211` | **7.37:1** | AAA | AAA |
| Muted text on card | `#A3A296` | `#12201E` | **6.53:1** | AA | AAA |
| Link | `#98D6D7` | `#0A1211` | **11.68:1** | AAA | AAA |
| Link on card | `#98D6D7` | `#12201E` | **10.34:1** | AAA | AAA |
| Primary button label | `#08100F` | `#98D6D7` | **11.85:1** | AAA | AAA |
| Gold accent on page | `#D6B982` | `#0A1211` | **10.04:1** | AAA | AAA |
| Gold as text | `#E3CCA0` | `#0A1211` | **12.11:1** | AAA | AAA |
| Input border vs page | `#4F6761` | `#0A1211` | **3.11:1** | 3:1 ✓ | — |
| Error text | `#DD887E` | `#0A1211` | **7.13:1** | AAA | AAA |
| Success text | `#8BC6AA` | `#0A1211` | **9.71:1** | AAA | AAA |

### The one deliberate failure

Crown Gold on white is **2.18:1**. It is kept off text
on purpose: the logo's letterforms carry far more optical weight than 15px type, so what
works at 1080px across does not work in a product card.

**Compliant alternatives**

| Situation | Instead of | Use |
|---|---|---|
| Gold lettering on white | `#C8AC77` (2.2:1) | `#8F6B28` — 4.9:1 |
| Gold on a dark band | — | `#C8AC77` on `#0B4B4C` — 4.5:1 |
| Gold icon on white | `#C8AC77` | `#211F1C` icon, gold rule beside it |
| Teal inside a black section | `#0B4B4C` (2.1:1) | `#C8AC77` — 9.7:1 |

### Dark mode

A complete dark set ships in `tokens.css` under `[data-theme="dark"]`. It is **opt-in,
not automatic** — and on this site that is a considered decision, not laziness: the shop's
hero and section backgrounds are set per-section in Elementor, so honouring the OS
preference would flip the text tokens while those sections kept their light backgrounds,
giving the worst of both. Ship it as a toggle, or after every section has a dark variant.

Dark mode is not an inversion. The teal lightens (`#98D6D7`) because
`#0B4B4C` on near-black measures 2.1:1; the gold lightens slightly to
`#D6B982`; surfaces lift in steps (`#0A1211` → `#12201E` → `#182A28`) so elevation is
read by lightness, which is the only cue left when shadows stop working.

---

## 4 — Component application

| Component | Default | Hover | Active | Focus | Disabled |
|---|---|---|---|---|---|
| **Primary button** | Teal 800 field, Linen label | Teal 900 | Teal 950 | 2px teal ring, 2px offset | Linen 100 field, Warm Ash label |
| **Secondary button** | Transparent, 1px Ink 700 border | Teal 50 wash + teal border | Teal 100 wash | as primary | Hairline border, Warm Ash label |
| **Ghost button** | Teal text, no field | Teal 50 wash | Teal 100 wash | as primary | Warm Ash text |
| **Danger button** | Clay Red 700 field, white label | 92% brightness | 88% | as primary | as disabled |
| **Link** | Teal, gold underline | Teal 900 | Teal 950 | teal ring | Warm Ash, no underline |
| **Input** | 1px Warm Ash 500 (3.6:1) | Ink 700 border | — | teal border + 3px teal 15% ring | Linen 100 field |
| **Input, error** | Clay Red border + message | — | — | clay ring 15% | as disabled |
| **Input, success** | Kola Green border + message | — | — | green ring 15% | as disabled |
| **Card** | White, hairline, shadow-sm | shadow-md, lift 2px | — | ring on the card link | Linen, hairline |
| **Nav item** | Ink text | Teal text, gold underline grows | Teal 950 | teal ring | Warm Ash |
| **Gold on dark** | Gold 400 field, Ink 900 label | Gold 300 | Gold 200 | gold ring | 40% gold |
| **Badge / sale** | Champagne field, Antique Gold text | — | — | ring | Linen 100 |

**Rules that keep the states honest**

1. **One primary button per view.** Two primaries is a choice the customer did not ask for.
2. **Hover darkens on light, lightens on dark** — never changes hue, which reads as a
   different meaning.
3. **Error is never colour alone.** The message says what is wrong; roughly one man in
   twelve cannot reliably separate the clay red from the kola green.
4. **Focus is always a ring plus a colour change.** On a cheap screen in daylight, a 1px
   border shift is not a visible state.
5. **Disabled is not invisible.** 45% text on a linen field still reads as "not available";
   20% opacity reads as "broken".

---

## 5 — Design system and tokens

Two layers, deliberately:

- **Primitives** name colours — `--qd-teal-800`, `--qd-gold-400`.
- **Semantic** names jobs — `--qd-primary`, `--qd-bg-subtle`, `--qd-text-muted`.

Components read **only** the semantic layer. That is what lets dark mode swap forty values
instead of rewriting a stylesheet, and what stops "just this once" hex codes spreading.

| Token | Job | Light | Dark |
|---|---|---|---|
| `--qd-bg-page` | Page background | `#FFFFFF` | `#0A1211` |
| `--qd-bg-subtle` | Alternating sections | `#FAF8F5` | `#0F1B1A` |
| `--qd-bg-muted` | Disabled fields, wells | `#F3EFE8` | `#152422` |
| `--qd-surface-card` | Cards, panels | `#FFFFFF` | `#12201E` |
| `--qd-border-subtle` | Hairlines | `#E6E1D5` | `#22332F` |
| `--qd-border-default` | Input borders (3:1) | `#8F8676` | `#4F6761` |
| `--qd-border-strong` | Outline buttons | `#524E47` | `#5B706A` |
| `--qd-text-primary` | Max-contrast text | `#211F1C` | `#EDEAE0` |
| `--qd-text-heading` | Headings | `#0B4B4C` | `#EDEAE0` |
| `--qd-text-body` | Body copy | `#3F4A49` | `#CDCBBD` |
| `--qd-text-muted` | Captions, help | `#6C665A` | `#A3A296` |
| `--qd-primary` | Actions, links | `#0B4B4C` | `#98D6D7` |
| `--qd-accent` | Gold accent | `#C8AC77` | `#D6B982` |
| `--qd-accent-text` | Gold as text | `#8F6B28` | `#E3CCA0` |
| `--qd-focus` | Focus ring | `#0B4B4C` | `#98D6D7` |
| `--qd-success` / `-subtle` | Confirmation | `#2F6A4E` | `#8BC6AA` |
| `--qd-warning` / `-subtle` | Caution | `#7A541F` | `#E0B67B` |
| `--qd-danger` / `-subtle` | Failure, destructive | `#7C3027` | `#DD887E` |
| `--qd-info` / `-subtle` | Neutral notice | `#295565` | `#89B7C8` |

**Layout tokens**

| Group | Scale |
|---|---|
| Spacing | 4px base — `--qd-space-1` 4 · 2 8 · 3 12 · 4 16 · 5 24 · 6 32 · 7 40 · 8 48 · 9 64 · 10 80 · 11 96 · 12 128 |
| Radius | `xs` 2 · `sm` 4 · `md` 6 · `lg` 10 · `xl` 16 · `pill` 999 |
| Elevation | `xs` → `xl`, all teal-tinted; plus `--qd-shadow-focus` and a `gold` glow reserved for one featured card |
| Gradients | `--qd-gradient-gold-sheen`, `-teal-depth`, `-cream-fade`, `-hero-glow` |
| Interaction | `--qd-hover-wash` 6% · `--qd-pressed-wash` 12% · `--qd-disabled-opacity` 45% · `--qd-transition` 160ms |

**When to use which**

- Ordering something → `--qd-primary`. Acknowledging → `--qd-accent`, and only inside a
  dark band.
- Any sentence a customer must read → never `--qd-accent`; use `--qd-accent-text`.
- Separating sections → `--qd-bg-subtle`, never a border.
- A price → `--qd-primary` on light, `--qd-accent` on dark.

**What to avoid**

- Hex codes inside components. If a value is needed twice, it is a token.
- Neutral-grey shadows. Teal-tinted or nothing.
- More than two type colours in a section — heading teal plus body ink is already two.
- `!important` to beat the parent theme. The bridge in `components.css` maps the theme's
  own variables instead, which is why the palette survives a theme update.

---

## 6 — Visual suggestions

**Gradients.** Three, and no more. *Teal depth* (`#0B4B4C` → `#072122`, 160°) for the
hero and footer. *Gold sheen* (`#E3CCA0` → `#C09A54`, 135°) for badge fills and
hairlines — never a large field, which reads as a missing image. *Cream fade* (white →
linen) to soften section joins without a rule.

**Shadows.** Four steps, teal-tinted, low opacity. Cards rest at `shadow-sm` on a hairline
and lift to `shadow-md` with a 2px translate. The gold glow is for one featured product at
most — used twice it stops being a highlight.

**Patterns.** The Adinkra motif belongs to the wholesale band only, at 7% gold on teal,
built from two 45° repeating gradients so it costs nothing to load. Never behind a product.

**Icons.** 1.5px strokes. Ink on light, Linen on dark. Gold icons only inside a teal or
black band (4.6:1 and 9.7:1); gold on white reads as a ghost.

**Photography.** Shoot on white and on linen — the palette assumes a light field around the
product and a dark field behind the story. Gold jewellery photographs warm, so hold a
neutral white balance or the metal turns orange and fights Crown Gold. For dark sections,
shoot on deep teal rather than black: black crushes the shadow under a pendant, teal keeps
the edge of the metal. One product per frame, 4:5, longest edge 1600px.

---

## 7 — Deliverables

| File | What it is |
|---|---|
| `brand/tokens.css` | Primitives, semantic tokens for both modes, spacing, radius, shadows, gradients. |
| `brand/components.css` | Buttons, links, fields, cards, nav, alerts, WooCommerce bridge — every state. |
| `brand/design-tokens.json` | Tokens Studio / Figma import: core ramps + light and dark semantic sets. |
| `brand/preview.html` | Palette, contrast tables and live components in both modes, with a toggle. |
| `brand/queendor-color-guide.pdf` | This document as a printable 8-page guide, with a one-page card at the end. |
| `luxrio-child-1.7.0.zip` | The same CSS wired into the shop, loaded after the theme's own colours. |

### Importing the tokens into Figma

1. Install **Tokens Studio for Figma**.
2. `Tools → Load from file` → `design-tokens.json`.
3. The `core` set holds the ramps; `semantic/light` and `semantic/dark` hold the roles.
   Create two token sets from them to switch themes in Figma the way the CSS does.

### Where this stops

Colour is the one part of a brand system that arithmetic can verify, and this document
does that. Typography, photography and layout are judgements, and the notes above are
offered as such.

Two decisions remain the client's, and both are one line to change:

1. **Prices in teal or gold?** Teal is recommended — 9.9:1 against 2.2:1, and the price is
   the number the customer came for.
2. **Does the hero become teal?** Recommended. Left black, the palette stops at the fold
   and a teal button on black measures 2.1:1.

Both are easier to answer looking at `preview.html` than at a specification.
