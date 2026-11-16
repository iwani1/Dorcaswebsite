# Home page — audit after the import

**Live:** `https://www.blaharbenyah.com/dorcas/` · fetched 2026-10-31
**Theme:** child **1.7.1** (so 1.7.2 has not been installed — the menu still wraps)
**Compared against:** the export you sent, and the previous audit.

---

## 1. What the import actually fixed

| | Before | Now |
|---|---|---|
| Hero | demo copy, orange button | **"Adinkra jewellery · Accra" / "Jewellery that means something"**, teal button |
| Product slider | nothing | **5 real products**, correct prices |
| "best selling" grid | nothing | **7 real products**, correct prices, newest first |
| "Our work" | `delivered worldwid` | `delivered worldwide` |
| Second promo card | `/shop-2/` (a demo duplicate page) | `/shop/` |
| Instagram tiles | links to `instagram.com/` | links to **her profile** |
| Promo cards | demo text colours, black stars | brand colours |

Two sections that rendered as nothing now sell. That is the biggest change to
this page since the project started.

---

## 2. The two defects that now dominate

### 2.1 The product sections are 85% empty boxes

Ten products are live. **Nine have no featured image.** In both product sections
the only photograph is *Bese Saka Adjustable Bracelet*; everything else is an
empty frame with a title and price under it. On a page whose whole job is to make
jewellery look desirable, this is now the first thing a visitor sees.

| Product | Price | Image |
|---|---|---|
| Akoma Stud Earrings | ₵180 | ✗ |
| Bese Saka Adjustable Bracelet | ₵260 | ✓ |
| Duafe Statement Ring | ₵420 | ✗ |
| Dwennimmen Signet Ring | ₵480 | ✗ |
| Adinkrahene Stacking Ring Set (3) | ₵650 | ✗ |
| Sankofa Necklace & Akoma Earring Gift Set | ₵560 | ✗ |
| Five Symbols Layered Necklace | ₵480 | ✗ |
| Nkyinkyim Hoop Earrings | ₵220 | ✗ |
| Gye Nyame Pendant Necklace | ₵320 | ✗ |
| Sankofa Pendant Necklace | ₵320 | ✗ |

**And the nine photographs you sent do not match this catalogue.** They are
*Geometric Necklace Set, Clover Necklace Set, Swirl Link Bracelet, Clover Heart
Bracelet, Oval Scroll Bracelet, Ornamental Bracelet, Quatrefoil Bracelet,
Geometric Bracelet, Floral Bracelet* — none of which exist as products here.
So the photography is for a catalogue that has not been created yet. Either those
nine become products (and the Adinkra names get their own shoot), or the photos
sit unused. **This is the decision that unblocks the page.**

### 2.2 The "CUSTOM Jewelry" section is still the demo template

Five tabs render **the same three cards, five times over** — and because Slick
duplicates its slides, the HTML carries roughly **three dozen identical cards**:

> *Limited Edition — 20 Product · Diamond Pendant — 06 Product · Luna Rosa — 20 Product*

- The names are the demo's, not yours.
- "20 Product" and "06 Product" are **false counts** — you have ten products.
- Every card links to `#`. Nothing is clickable.
- One image still loads from `wordpress.vecurosoft.com` (`cate-2-2.png`), so it
  will break if the demo host ever goes dark.

The cause is unchanged from my last report: the widget prints Elementor template
**920** inside every tab. It cannot be fixed from the export. The fix is five
templates (one per tab, each querying that category) **or** swapping the widget for
`luxrioproductcategory`, which loops real categories directly.

Given the tabs already read *Necklaces / Earrings / Bracelets / Rings / Sets &
Gifts* — your real taxonomy — the swap is the shorter road, and it would delete
the dead links and the false counts at the same time. It changes the section's
look, which is why I am asking rather than doing.

---

## 3. Smaller faults, with causes

| # | Fault | Cause | Effort |
|---|---|---|---|
| 1 | Instagram strip: **3 tiles, one photo** | Elementor remaps images by attachment **ID** on import. My three slides carried the same `id` with different URLs, so all three resolved back to one image. | regenerate with ids cleared |
| 2 | A tab labelled **"Recent Items"** sits under the heading *best selling* | the widget builds the tab label from the filter slug (`recent-items` → "Recent Items"). Choosing `best-selling` would print "Best Selling" and sort by sales | 1 setting |
| 3 | **"Add to Wishlist" appears twice** on every card | two copies of the wishlist template rendering per product | investigate |
| 4 | Menu still **8 items, wrapped onto two lines** | 1.7.2 (the trim) is not installed — theme reports 1.7.1 | upload |
| 5 | **Footer renders nothing** | Footer Builder assignment, untouched since the first audit | WordPress setting |
| 6 | 13 assets still on `wordpress.vecurosoft.com` | section backgrounds and decorative shapes | download + re-upload |
| 7 | Copy still the demo's: `CUSTOM Jewelry`, `High Class Jewelry`, `Style Keepers`, `Jewelry NOW UPDATE!`, `exclusive categories` | content, not code | 15 min of writing |
| 8 | Both promo cards say **"Shop Now"** and both go to `/shop/` | content | pick two real destinations |

---

## 4. Colour and contrast, still on 1.7.1

The palette work of 1.8.x is gone with the version, so the page is dark again —
your choice, and I am not re-arguing it. What is worth recording is that the one
**measurable** failure is back with it:

| Element | Pairing | Ratio |
|---|---|---|
| Story/process band over the `#CF6D03` veil, white title | white on `#CF6D03` | **3.59:1 — fails AA** |
| Everything else on dark backgrounds | white on `#020203` etc. | 15–21:1, passes |

That band is the only place on the page where text is measurably hard to read.
It is one rule to lift it — a darker veil, or the same linen treatment, without
touching anything else.

The promo cards are now brand-coloured (star gold, title ink, price teal) and read
correctly against the cream banner backgrounds.

---

## 5. What I'd do, in order

1. **Decide the catalogue-vs-photography question** (§2.1). Until it is answered,
   nothing else on this page matters much — it is the difference between a shop
   and a list.
2. **Fix the category section** (§2.2). Swap or build; either is a morning.
3. **Install 1.7.2** — the menu unwraps with it. One upload.
4. **Assign the footer.** Five minutes, and every page gains the trust signals.
5. **Regenerate the Instagram strip** with three distinct images (I can hand back
   a corrected JSON in minutes).
6. **Write the copy**: five headings and two button labels.

Items 3 and 5 are the only ones I can do without decisions from you.
