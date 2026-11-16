# Home page analysis

**Page:** `https://www.blaharbenyah.com/dorcas/`
**Fetched:** 2026-10-31, live, whole page both chunks
**Theme live:** 1.7.1 · **Scope:** the home page only
**Method:** the rendered page as a crawler sees it — every heading, link, image
source and string, in document order. No browser, so anything about *appearance*
is inferred from markup and flagged as such.

---

## Verdict

The **chrome is now client-grade**: brand name, real currency, working links, a
wholesale band with true numbers, and one honest headline. What remains is the
**body of the page**, and it is still the demo's: twelve dead tiles, a product
carousel with no products, and a section with a heading and no words under it.

A visitor decides in about eight seconds. In the current order, those eight
seconds contain the best material on the page (hero) followed immediately by the
worst (the tile grid). That order is the problem — not the palette, not the theme.

---

## The page as a visitor meets it

| # | Section | What is actually there | Verdict |
|---|---|---|---|
| 1 | Top bar | Order Tracking · FAQs · Support · LOGIN · REGISTER | demo links |
| 2 | Header | logo, 8 menu items, search/heart/cart | works; one label still demo |
| 3 | Hero | "Jewellery that means something" · "Hand-finished pieces, made to be given." · **Shop the collection** | **client-ready** |
| 4 | Wholesale band | "Stock Queen Dor's" · trade from ₵90 · 6 per style · apply | **client-ready** |
| 5 | Promo pair | "For the shop — Only From ₵100.00" · "For the gift — Only From ₵300.00" | **two false prices** |
| 6 | Why Adinkra | heading "A piece that says something", then **no copy at all** — four vendor ornaments and nothing else | **broken** |
| 7 | Categories | "CUSTOM Jewelry" + 5 tabs + **12 tiles from 3 demo names**, one photograph, every link `#` | **worst section** |
| 8 | Process | "THE PROCESS" / "High Class Jewelry" + "Our work" + one paragraph ending "delivered worldwid" | half-fixed, typo |
| 9 | Best selling | "best selling" / "Graceful Ear Drops" + All/Classic/Modern tabs + **zero products** | **empty** |
| 10 | Instagram | "Style Keepers" / "Jewelry NOW UPDATE!" + **5 copies of one photo**, each labelled "Instagram" | **duplicate** |
| 11 | Footer | **nothing in the rendered output** | verify — see §7 |

---

## Measured defects

| Defect | Count | Evidence |
|---|---|---|
| Category tiles pointing at `#` | **12** | every tile `href="#"` |
| Distinct product names in those 12 tiles | **3** | Diamond Pendant · Luna Rosa · Limited Edition |
| Distinct photographs across those 12 tiles | **1** | `IMG_8580-1-e1793443127157.png` reused |
| Products rendered in "best selling" | **0** | heading + tabs, no items |
| Identical images in the Instagram strip | **5** | same file, five times |
| Images hotlinked from `wordpress.vecurosoft.com` | **6+** | title-shape ×2, cate-ele ×4, cate-2-2 |
| Words of body copy under "Why Adinkra" | **0** | heading then images |
| Menu labels still demo | **1** | "Jewelry House" |
| Sections with no purpose on a shop home page | **3** | process band, Instagram strip, empty carousel |

---

## The five things that make it read as unfinished

**1. Twelve identical tiles.** Three names repeated four times, one photo, no
destinations. This is the single strongest "this is a template" signal on the
site, and it sits directly under the hero where attention is highest. Either five
real tiles linked to real archives, or delete the section until it is real.

**2. Two prices that don't exist.** "Only From ₵100.00" and "Only From ₵300.00".
The catalogue's cheapest piece is **₵180**; the cheapest gift set is **₵560**.
A customer who taps through and finds nothing at ₵100 learns something about the
shop that is worse than a slow page.

**3. A carousel with nothing in it.** "Graceful Ear Drops" promises product and
delivers a tab bar. It is the one section on a shop home page that must work.

**4. A heading with no words under it.** "Why Adinkra / A piece that says
something" then — nothing. This was the section built to answer *why buy this
rather than a cheaper pendant*, and it is currently the emptiest block on the page.

**5. The same photo five times.** Five identical images with five identical
"Instagram" links. It reads as a broken feed, which is worse than no feed.

---

## Copy defects — exact strings

| Where | String | Problem |
|---|---|---|
| Process | `delivered worldwid` | truncated — missing the `e` |
| Process | `High Class Jewelry` | demo phrasing, and American spelling |
| Categories | `CUSTOM Jewelry` | shouting caps; American spelling |
| Carousel | `Graceful Ear Drops` | demo name; describes a category, not a product |
| Instagram | `Jewelry NOW UPDATE!` | demo filler |
| Header | `Jewelry House` | demo page name, also the page `<title>` |

**Spelling is inconsistent across the page**: the hero says "Jewellery" (British,
correct for Ghana), while five other places say "Jewelry" (American). Pick British
and hold it — the brand is Ghanaian and the headline already commits.

---

## Accessibility and SEO, home page only

| Check | Result |
|---|---|
| One `<h1>` | ✓ "Jewellery that means something" |
| Heading order | ✓ h1 → h2 → h3, no skips |
| Hero image `alt` | ✗ `ChatGPT Image Oct 31 2026 08_39_23 AM 6 e1793436450913` — a filename |
| Category image `alt` | ✗ `IMG_8580 1 e1793443127157` — a filename |
| Ornament `alt` | ✗ `phone icon` on an advert-shaped flourish |
| Link text | ✗ "Shop Now" ×2, "Instagram" ×5 — identical, no context |
| Page `<title>` | ✗ `Jewelry House - Queen Dor's Fashion House` — demo page name |
| Language of currency | ✓ ₵ throughout, no `GHC` |

Alt text is free to fix and currently the weakest part of the page's SEO: a
filename tells Google nothing and a screen reader reads it aloud.

---

## Performance and third-party dependency

Six images load from `wordpress.vecurosoft.com` — the theme author's demo site.
They are decorative flourishes, and the day that site is retired the home page
loses them with no error on your side. They are also the only reason the page
waits on a third domain.

The hero and wholesale images are AI-generated PNGs (`ChatGPT-Image-Oct-31…`).
They're doing their job today; flagged only because they are the two largest
images on the page and the first thing worth replacing with photography.

---

## The footer returns nothing

The rendered page ends after the Instagram strip. No columns, no address, no
policy links, no payment marks. Either the footer builder is not assigned
(`Options → Footer` must point at a template) or it is empty.

For a shop this matters twice: policy links are a trust signal, and Ghana's
consumers look for an address before they pay online.

---

## Already fixed, credit where it's due

Since the first pass on this page: the hero rewritten and cut to one honest
statement · currency now ₵ everywhere · every menu link points at a real page ·
the wholesale band added with true trade numbers · testimonials removed · the
category tabs renamed to real taxonomies · the Instagram URL corrected.

The page has moved a long way. What's left is concentrated in three blocks.

---

## What I'd do, in this order

| # | Task | Time | Why first |
|---|---|---|---|
| 1 | Replace the 12 tiles with **5 real tiles** → Necklaces, Earrings, Bracelets, Rings, Sets & Gifts | 25 min | biggest credibility jump per minute |
| 2 | Put a **Products widget** in "best selling": 4 columns, 8 items, sort by popularity | 15 min | a shop home page with no products |
| 3 | Fix the two promo prices to real starting points (₵180 and ₵560) | 5 min | a false price is a broken promise |
| 4 | Write the "Why Adinkra" copy (Sankofa · Gye Nyame · Akoma) | 20 min | the section exists to sell the meaning |
| 5 | Retitle the process band, fix `worldwid` | 5 min | visible error |
| 6 | Delete the Instagram strip, or give it five different photos | 10 min | duplicate reads as broken |
| 7 | Alt text on the hero and the three product images | 5 min | free SEO and screen readers |
| 8 | `Jewelry House` → `Home`; assign the footer | 5 min | finishes the chrome |

About **90 minutes**, and steps 1–3 alone change the page's impression more than
everything else combined.

---

## What I can do without you

**A stopgap in code, if you want one.** The child theme can hide the emptiest
blocks — the dead tile grid, the five-photo strip, the empty carousel — so the
page stops advertising itself as unfinished while you work on the real content.
It is a two-line change and it reverses just as easily. I would not hide the
hero or the wholesale band; those are working.

**The full job, if you export the page.** Elementor → right-click → *Save as
Template* → *Templates → Export*. Send me the `.json` and I will rebuild all
three problem sections in it: five real tiles with real links, a products widget
in place of the empty carousel, and the copy filled in. You import the result and
look at it before it goes live.

That is the only route where I do the work and you see the outcome, which is what
you asked for from the beginning.

---

## What only you or the client can settle

1. **Real photography** — nine of ten products have no image at all, so any
   products widget on the home page will show grey placeholders until they do.
2. **The "Why Adinkra" copy** — I can draft it (Sankofa, Gye Nyame, Akoma), but
   the client should approve the claim that each symbol carries a meaning.
3. **Whether the process band stays** — it says "retail and wholesale, delivered
   worldwide", which is a promise about shipping the site cannot yet keep at
   checkout.
