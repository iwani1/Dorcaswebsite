# Product photography — what to ask the client for

The shop has ten products and zero photographs. Nothing else on this list matters until that changes: a customer judges jewellery by how it looks at 1200 pixels, not by the copy underneath.

---

## Why not take them off Instagram

I checked. Two reasons, one technical and one commercial.

**Technical.** This workspace can only reach package registries, not Instagram's CDN — so I can't download the files here at all. And Instagram wouldn't give you usable files if I could:

| | Instagram | What a product page needs |
|---|---|---|
| Longest edge | **1080 px** | 1600–2000 px |
| Compression | re-encoded, visibly soft on fine detail | original JPEG, quality 80+ |
| Colour | profile stripped | sRGB |
| Crop | square, or their choice | 4:5 portrait for this theme |
| Metadata | removed | — |

For jewellery the whole product is the detail — a chain link, a symbol's edge. Instagram's recompression is exactly where that detail goes.

**Commercial.** A ₹/₵ 650 ring shown at 1080 px, soft and square-cropped, next to the word "hand-finished", reads as a cheap ring. The photography is the price justification.

**The originals already exist.** Anyone shooting jewellery for Instagram has the camera files. The compressed version is the derivative.

---

## Send this

> **Subject: Photos for the new site**
>
> Hi ___,
>
> The shop is built — ten pieces, live, ready for your products. The one thing I can't write for you is the photography.
>
> Could you send me the **original image files** (not screenshots from Instagram — those are compressed to a fraction of the size and will look soft on the site)?
>
> **What I need, per piece:**
> - 1 photo on a plain background
> - 1 photo worn, or a close detail of the symbol
>
> **Plus 3–5 wider shots** for the homepage banner — you on location, hands, packaging, anything with atmosphere.
>
> **How to send:** Google Drive or WeTransfer, straight from the camera or Lightroom export if you have it.
>
> **Please name each file with the product code** (list below) — e.g. `QD-001-a.jpg`. Then it goes on the right product automatically instead of me matching photos by eye.
>
> If the only copies you have are on Instagram, tell me and we'll work with those — but it will look softer than it should.
>
> Thanks,
> ___

---

## The naming scheme

One file per shot, code plus a letter:

```
QD-001-a.jpg    QD-001-b.jpg    Sankofa Pendant Necklace
QD-002-a.jpg    QD-002-b.jpg    Gye Nyame Pendant Necklace
QD-003-a.jpg    QD-003-b.jpg    Duafe Statement Ring
QD-004-a.jpg    QD-004-b.jpg    Akoma Stud Earrings
QD-005-a.jpg    QD-005-b.jpg    Bese Saka Adjustable Bracelet
QD-006-a.jpg    QD-006-b.jpg    Dwennimmen Signet Ring
QD-007-a.jpg    QD-007-b.jpg    Adinkrahene Stacking Ring Set (3)
QD-008-a.jpg    QD-008-b.jpg    Nkyinkyim Hoop Earrings
QD-009-a.jpg    QD-009-b.jpg    Five Symbols Layered Necklace
QD-010-a.jpg    QD-010-b.jpg    Sankofa Necklace & Akoma Earring Gift Set
```

`-a` is the plain-background shot, `-b` the worn or detail shot. If a piece only has one, `-a` is the one that matters — it becomes the thumbnail everywhere on the site.

**Heroes:** name them `hero-1.jpg` … `hero-5.jpg`. Landscape, at least 1920 px wide.

---

## Minimum spec

- **1600 px** on the longest edge (2400 px for hero images)
- **sRGB**, JPEG, quality 80 or higher
- **4:5 portrait** for product shots where possible — the theme crops to that ratio, so composing for it saves me guessing
- No text overlays, no watermarks, no collage grids
- One product per image

Anything smaller than 1200 px I'd have to upscale, and upscaled jewellery looks like what it is.

---

## If Instagram is genuinely all they have

Then either install **[gallery-dl](https://github.com/mikf/gallery-dl)** on your own machine and pull the highest available version:

```bash
# macOS or Linux — one-off
pip install gallery-dl
gallery-dl "https://www.instagram.com/queendor_fashionhouse/"
```

```powershell
# Windows
pip install gallery-dl
gallery-dl "https://www.instagram.com/queendor_fashionhouse/"
```

It writes into a folder per post. Then:

1. Pick the best frame per piece — Instagram carousels often contain several shots of the same piece.
2. Rename to the SKU scheme above.
3. Crop to 4:5 if the composition allows.

Three caveats, in order importance:

- **This is against Instagram's terms**, and their CDN links expire within hours — the tool fetches live rather than using saved links, which is why it works where a copied URL wouldn't.
- **You'll get 1080 px at best.** Use them, but treat them as a placeholder for real photography, not the final state.
- **It's their own page**, so there's no third-party copyright question — but if a photographer shot it, the usage licence for a commercial site is technically theirs, not Instagram's. One line to the client covering it is enough.

---

## What happens once the files arrive

1. `Media → Add New`, upload all of them at once.
2. For each product: set the **featured image** to the `-a` shot, and add `-b` to the gallery.
3. Check the thumbnail crop — the theme crops to 4:5, and a square Instagram frame will lose the top and bottom. Set the crop anchor so the piece isn't cut.
4. Replace the hero images in Elementor with `hero-*.jpg`.

Ten products × two shots plus five heroes is **25 images**. That's an afternoon of matching and about an hour of uploads.

---

## While you wait

Everything else can proceed without photography: the pages, the menu, the symbols, the size guide, the policy text. The shop will look unfinished — grey placeholders in every grid — but nothing is blocked, and nothing you do now has to be redone when the photos land.
