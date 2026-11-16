# Getting the storefront into light mode

## What shipped in 1.8.0 — done for you

The demo's **shell** is black, and it is Elementor content rather than a theme
setting, so there was no switch to click. 1.8.0 overrides it:

| Element | Before | Now |
|---|---|---|
| Top bar (Order Tracking · LOGIN · REGISTER) | black | **linen `#FAF8F5`** with a hairline |
| Header (logo, menu, icons) | black | **white** with a hairline underneath |
| Menu links | white | **ink `#211F1C`**, teal on hover, teal for the current page |
| Search / cart / heart icons | white | **ink** |
| Sticky header on scroll | black | **white with a soft shadow** |
| Mobile slide-out menu | black | **white** |
| Page ground, preloader | black | **white** |

Upload 1.8.0 and the top of every page changes immediately. Nothing to configure.

To undo it, one line in `functions.php`:

```php
add_filter( 'queendor_light_storefront', '__return_false' );
```

---

## What CSS cannot do, and why

The rest of the page is dark because **each section sets its own background and
its own text colour in Elementor**. A blanket "make every section white"
stylesheet would put white headings on white cards on every dark section — the
demo's sections carry white text precisely *because* their backgrounds are black.

Worse, the hero's headline sits **on top of a photograph**, not on the section
background. Its colour has to stay light or it disappears into the image. So the
hero is a design decision, not a CSS switch.

`brand-light.css` deliberately stops at the shell. That boundary is the honest
one.

---

## The four sections to change

Open the page in Elementor, click the section, then `Style → Background`:

| # | Section (as it reads on the page) | Background | Headline colour |
|---|---|---|---|
| 1 | Hero — "Jewellery that means something" | `#FAF8F5` | `#0B4B4C` |
| 2 | "For the shop" / "For the gift" tiles | `#FFFFFF` | `#0B4B4C` |
| 3 | "THE PROCESS" / process band | `#FAF8F5` | `#0B4B4C` |
| 4 | "Style Keepers" / Instagram strip | `#FFFFFF` | `#0B4B4C` |

Eyebrow labels ("ADINKRA JEWELLERY · ACCRA") go **`#8F6B28`** — Antique Gold, the
darker gold that passes contrast on light. Body copy stays `#3F4A49`.

**Leave two things dark**, on purpose:

- **The wholesale band** ("Stock Queen Dor's") — it is the one place gold reads at
  9.7:1, and it is the 10% in the 60-30-10 rule. On a white page it becomes the
  anchor that makes the rest look calm.
- **The footer** — a deep teal `#0B4B4C` footer grounds a light page. A white
  footer under a white page looks unfinished.

---

## The hero photo is the real blocker

Your hero is currently two photographs shot on **black**. On a cream section they
stay two black rectangles — a dark card floating in a light page. That is not a
colour problem, it is a photography one.

Two honest options:

**A — light photography (best).** One piece on cream or white, shot from a phone
is enough. Put it right of the headline, set the section to `#FAF8F5`, and the
page reads as a Queen Dor's page rather than a template.

**B — no hero photo.** Cream section, headline in teal, gold rule above it, and
the product photograph moved down into the category grid where it belongs. Fewer
images, more confidence — and it costs nothing to try.

I did attempt to build you a light hero from the existing cut-outs. I stopped:
those files carry a **shadow baked for a black background**, and on cream it shows
up as a dark smudge under the piece. Shipping that would have looked like a
mistake on the most important image on the site.

---

## The fastest route if you'd rather not click

**Send me the Elementor JSON for the home page** and I will do all four sections
myself.

1. In Elementor, right-click the page → **Save as Template** → name it
   `home-light`.
2. `Templates → Saved Templates → Export` — or **Elementor → Tools → Export**.
3. Send me the `.json`.
4. I rewrite every `background_color`, `title_color` and `text_color` in the file
   and hand it back. You import it and set it as the page.

That is a file edit, not a click-through, and it is the only reliable way for me
to change section styling without a browser. It also means the change is
reviewable before it goes live.

---

## One thing to watch after uploading

The white header above a black hero is a strong contrast line. It reads as
deliberate on most sites — but if it bothers you, the alternative is the teal hero
recommended in `BRAND-COLOURS.md`: a `#0B4B4C` band under a white header, gold
button, which joins the two halves instead of stacking them.
