# The client's reference, and version 1.8.3

## What she sent

`themes.vamtam.com/?theme=bijoux` — VamTam's **Bijoux**, a jewellery-store theme.
Their own description: *"for jewelers, handmade jewelry brands, and luxury
accessory shops… showcases gold pieces, handmade details, and fashion-forward
collections in a **clean, premium layout**."*

I can read the theme's specification and description but I cannot render the demo
(it sits behind VamTam's preview frame), so treat the visual reading below as
inference from the category, not a pixel comparison. What is not inference: the
direction is **light, warm and quiet**, and the site she is looking at is black.

## What that means concretely

A reference like this is almost never sent for the layout. It is sent because of
the *feeling* — and what produces that feeling is a short, specific list:

| | The reference reads as | Your site today |
|---|---|---|
| Ground | warm white / ivory | black `#020203` |
| Type | dark ink on light, serif display | white on dark |
| Accent | gold, used in small doses | gold, used everywhere |
| Sections | separated by whitespace, not by photographs | four full-bleed photo bands |
| Photographs | product on light | product on black |

None of that is a colour the palette lacks. It is the palette **inverted** —
which is why I could not fix this by adjusting one or two values, and why 1.8.1
was the right idea.

## Version 1.8.3 — what it does

A light layer over 1.7.2, gated behind one filter, written against the page **as
it now is**.

| | |
|---|---|
| Page ground | white |
| Top bar | linen `#FAF8F5`, hairline border |
| Header | white, dark menu text, teal hover |
| Hero | Adinkra Teal `#0B4B4C` — white on it is **9.88:1** |
| "CUSTOM Jewelry", product slider, "Our work" bands | linen `#FAF8F5` |
| The orange veil `#CF6D0333` | **removed** — it was the only AA failure on the page, 3.59:1 |
| Section titles | teal `#0B4B4C` — **9.32:1** on linen |
| Eyebrow + the emphasised word | antique gold `#8F6B28` — **4.61:1**, AA |
| Body copy | `#3F4A49` — **8.66:1** |
| Promo card title / price / stars | ink / teal / antique gold, replacing `#021210`, `#3C3B3B`, `#000000` |
| Elementor's global palette | **remapped** — the demo orange that coloured one word of "High Class Jewelry" can no longer appear on any page |
| Display scale | 90/85, 80/95, 46/52, and two sizes nobody chose → **60/68, 40/50, 32/42** |
| `width: 111.129%` on two titles | removed — it is how a page starts scrolling sideways on a phone |
| Content width | 1600px and 1330px → **1330px** throughout |
| Section padding | 120/90, 120/120, 120/90, 160/160 → **120/120**, 80/80 on tablet |
| Menu | Cart and Checkout dropped (1.7.2's change, carried forward) |

Two things I did **not** do, deliberately:

- **Photography.** The hero keeps a dark field because its headline is white and
  set inside the widget — lightening the field without rebuilding the hero would
  put white on ivory. That is a hero rebuild, not a stylesheet.
- **Copy.** `High Class Jewelry`, `CUSTOM Jewelry`, `Style Keepers` are still the
  demo's words. Those need writing, not colouring.

## Why the IDs changed

The page is now **1628**, not 25. The template import created a new page and every
element got a new ID, so a stylesheet written against the old page would hit
nothing. Every selector in `brand-light.css` was re-derived from
`uploads/elementor/css/post-1628.css` — the page's own stylesheet, fetched from
the server after the import. Nothing is guessed.

## Trying it, and undoing it

Upload `QueenDors-child-theme-1.8.3.zip` over 1.7.1 or 1.7.2, then purge
LiteSpeed. If she does not like it:

```
add_filter( 'queendor_light_storefront', '__return_false' );
```

That returns the black storefront instantly, without changing the files. Or
re-upload `QueenDors-child-theme-1.7.2.zip`.

**One caveat worth stating plainly:** I still cannot see the site render. The
contrast numbers are arithmetic and reliable; whether the linen ground suits her
jewellery photography is a judgement only a screen can settle. If a band reads
wrong, send a screenshot of that band and I'll adjust the one ID responsible.
