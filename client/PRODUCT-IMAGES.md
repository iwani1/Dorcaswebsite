# The photo set — what arrived, and the problem with it

**18 files in. Nine pieces, two hero cut-outs, and one mismatch that needs a decision before anything is uploaded.**

---

## What arrived

Every piece came in two formats, which is more useful than it first looks:

| Format | Files | What it's for |
|---|---|---|
| **Transparent cut-out**, 218–594 px | `01_…png` etc. | Product pages, where the background is white |
| **900 × 900 on black** | `…-2.png` etc. | Dark sections — the hero slider is black, so these need no work at all |

Two pieces (`03_Swirl_Link_Bracelet`, `09_Floral_Bracelet`) exist **only** on black. I keyed the black out of those two so they could join the product set — the result is clean, though slightly softer at the edges than the true cut-outs.

## What I've made from them

```
client/product-images/
  source/     18 originals, untouched
  products/   9 cut-outs, 900×900, transparent — for the shop grid and product pages
  hero/       9 black-background renders, 900×900 — drop straight into the slider
              slider-1.png, 475×553 — hero cut-outs sized for the slider's image field
  CONTACT-SHEET.png  all nine at a glance
```

Each product file is trimmed to the piece, scaled to fill about 90% of the frame, sharpened after the resize, and stripped of metadata. They're consistent with each other, which matters more on a grid than absolute sharpness.

---

## The problem

**The photographs and the catalogue are two different ranges of jewellery.**

| Catalogue product | Photograph available |
|---|---|
| QD-001 Sankofa Pendant Necklace | **none** |
| QD-002 Gye Nyame Pendant Necklace | **none** |
| QD-003 Duafe Statement Ring | **none — no ring was photographed** |
| QD-004 Akoma Stud Earrings | only as part of two sets, no solo shot |
| QD-005 Bese Saka Adjustable Bracelet | **none** |
| QD-006 Dwennimmen Signet Ring | **none** |
| QD-007 Adinkrahene Stacking Ring Set (3) | **none** |
| QD-008 Nkyinkyim Hoop Earrings | **none** |
| QD-009 Five Symbols Layered Necklace | **none** |
| QD-010 Sankofa Necklace & Akoma Earring Gift Set | possibly — see below |

And in the other direction: **six of the nine photographs are bracelets**, while the catalogue sells one bracelet.

Counting honestly: **two or three** of the ten products could be given a real photograph today. The rest would keep the grey placeholder.

### The candidate matches

These are shape readings, not facts — the client has to confirm them:

| Photo | Shape | Could be |
|---|---|---|
| `01-geometric-necklace-set` | Hourglass pendant with spiral terminals, plus matching studs | A gift set — possibly QD-010 |
| `02-clover-necklace-set` | Four-lobed heart pendant, plus matching studs | **Akoma** (heart) — possibly QD-010, or a new product |
| `08-geometric-bracelet` | Comb-shaped plaques on a chain | **Duafe** (the comb) — but the catalogue's Duafe is a *ring* |
| `03`, `05`, `06`, `07`, `09` | Assorted scroll, oval, quatrefoil and floral links | No catalogue equivalent |

The rest — Sankofa, Gye Nyame, Nkyinkyim, Adinkrahene, Bese Saka — aren't in the photo set at all.

---

## Three ways forward

**A. Rebuild the catalogue around what was photographed.** *(recommended)*

Nine pieces, nine photographs, every product page complete. The Adinkra naming gets redone to match the actual shapes, and the shop opens with a full grid of real gold instead of a mix of photographs and grey boxes. Costs: rewriting ten product descriptions and SKUs, which I can generate in an hour.

**B. Keep the catalogue, get the missing photography.** Seven more pieces needed — three rings, two earring pairs, and the necklaces. Until they arrive the shop shows placeholders.

**C. Ship as is.** Ten products, three with images. This is the option that makes a finished site look unfinished.

Whichever you choose, the nine files are ready to upload — they don't need to be redone.

---

## Uploading them

For each product:

1. `Products → All Products` → open the product
2. Right-hand panel, **Product image** → *Upload files* → choose the matching file from `products/`
3. **Set the alt text** while you're there — `Gold plated Adinkra bracelet, oval scroll links` beats `05-oval-scroll-bracelet`
4. **Update**

The **Product gallery** box below it is a different slot — put a second angle there, never the main image twice.

For the slider: `hero/` files into the widget's **Slider Image** field. They're already 900 × 900 on black, which is what that section is built for.

---

## Three quality notes

**These are upscales.** The cut-outs arrive at 218–594 px and are now 820 px tall — between 1.4× and 1.9×. Fine at grid size (the theme shows about 400 px), soft if a customer opens the lightbox. If the photographer has the originals at 2000 px, send them; re-processing takes minutes.

**There's a reflection shadow under each piece.** It came with the renders. It reads as a soft shadow on cream and as a smudge on white, and it can't be cleanly removed without damaging the metal — the correct fix is an export without the shadow layer.

**The hero cut-outs are 208 × 436.** That's roughly a fifth of what a full-width hero needs. At 400 px wide in the slider they're fine; stretched across a desktop they'll be visibly soft. A 2400 px hero is a different job from a product shot.
