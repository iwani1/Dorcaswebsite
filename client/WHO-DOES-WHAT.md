# What I can do, and what I can't

A straight division of labour, written against the 23 items in
`FULL-AUDIT.md`. If something is on the wrong side of this line, tell me and I
will try again — but this is an honest list of where the line sits today.

---

## The line, in one sentence

**I can author any file. I cannot change anything that is a database row, a server
setting, a plugin setting, or a photograph.**

I have: the repository, write access to it, read access to your live site, and the
ability to build and verify downloadable archives.
I do not have: WordPress admin, the database, the server, a browser, or a camera.

---

## What I can do

### A. Content — the biggest share of the audit

| # | Item | What I'd hand you |
|---|---|---|
| 7 | **FAQs are lorem ipsum** | a full page — 10 real questions and answers, in the brand's voice, covering orders, delivery, returns, care and wholesale |
| 5 | **Contact page demo data** | the page rewritten around real details, the moment you give me them |
| 6 | **Delivery prices are blanks** | the page completed, the moment you give me the three numbers |
| 10 | Privacy `________` | already drafted in `paystack-pages/4-privacy-policy.md` |
| 2 | **Terms page missing** | already drafted in `paystack-pages/1-terms-and-conditions.md` |
| — | **10 product descriptions** | Paystack needs "a complete description of the goods". None exists. I can write all ten — materials, dimensions, what the symbol means, care — with brackets for the measurements only she has |
| 18 | "Why Adinkra" band has no text | 60 words that connect the home page to the Symbols page |
| 20 | Both promo cards say "Shop Now" | two labels and two destinations |
| 16 | Duplicate "Add to Wishlist" | diagnosis + a CSS or PHP fix |

### B. Theme code — real fixes, shipped as a versioned zip

| Item | What I can build |
|---|---|
| **Hide the 9 imageless products** until they are photographed | I know their IDs. A CSS ruleset hides those exact cards on the home page and shop, so the grid reads as deliberate instead of broken. One line to reverse when the photos land |
| Duplicate wishlist button | PHP filter or CSS, scoped |
| "Shop Details" heading on product pages | `gettext` filter in the child theme |
| Trust line under add-to-cart | "Ships from Accra · Paystack secure checkout" |
| Side-cart assets on the old domain | an output-buffer bridge that rewrites `blaharbenyah.com/dorcas` → the new domain in the final HTML. A bridge, not a cure — the plugin's stored URLs still need fixing |
| Footer | done — `client/footer/` + CSS in 1.8.8 |

### C. Importable artifacts — content I can't publish, but can package

| Item | Format |
|---|---|
| The six Paystack pages | WXR — done, `client/queendor-paystack-pages.wxr` |
| The footer | Elementor JSON — done |
| **A replacement for the demo "CUSTOM Jewelry" section** | Elementor JSON, built on your five real categories, with a working loop instead of five dead tabs |
| **A Symbols strip for the home page** | Elementor JSON — six symbols, linked to `/symbol/…` |
| **A corrected Instagram row** | Elementor JSON with three distinct image IDs (needs the three photos in the media library) |
| **The FAQs page** | WXR, ready to import as a draft |

### D. Tooling — the duplicates, safely

The repo already ships `queendor-cleanup` (dry run, trash not delete, protected
pages list). I can extend it with:

- **the 17 duplicate pages**, detected by pattern, with the canonical one protected
- **a 301 from each duplicate to its canonical page**, so nothing 404s
- **a "rewrite the old domain" tool** that finds `blaharbenyah.com/dorcas` in
  `wp_options` and replaces it — dry run first — which is what is still feeding the
  side cart's icons

You install it, tick the boxes, read the dry run, run it. Then delete the plugin.

### E. Verification — after you change something

I can re-read the live site and tell you whether it landed: is `/shop/` still
showing "Coming soon", does the footer render, does `/terms/` exist, did the old
domain vanish from the HTML. I cannot see *appearance* — for that I need a
screenshot from you.

---

## What I can't do

| Item | Why | Who |
|---|---|---|
| 1. Turn off **Coming soon** | WooCommerce setting | you, 30 seconds |
| 3. **Assign the footer** | theme option | you, 4 clicks |
| 2. Publish Terms / 5 / 6 / 7 | content must be pasted and published; I can't write to the database | you, ~30 min |
| 9. Check **guest checkout** and registration | WooCommerce settings, invisible from outside | you |
| 8. **Test the order email** | needs a real order and a real inbox | you |
| — Test the contact and wholesale forms | same | you |
| 11, 12. **Old-domain and vecurosoft assets** | stored in the database; the images must be downloaded and re-uploaded | you (tooling above helps with 11) |
| 13, 14. **Trash 17 duplicates, rename `-2` slugs** | database rows | plugin above, then you |
| 15. **Sitemap 500** | SEO plugin setting or its cache | you |
| 4. **Nine product photographs** | physical objects, a camera, and her hands | the client — nothing I generate can stand in for a photograph of a real piece |
| 21. Hero image | same | the client |
| — Paystack account, KYC documents | a real business with real papers | she applies, I write the site's half |
| — Upload any zip, install any plugin | no admin access | you |
| — Mobile layout, JavaScript, page speed | no browser | you, once, on a phone |
| — Confirm the PHP actually runs | **there is no PHP here** — I write it, nobody has executed it | you, on upload |
| — Legal advice on the Terms | not a lawyer | a Ghanaian lawyer |

---

## The honest caveats

1. **I have never executed the theme's PHP.** No PHP runtime in this environment.
   It is written carefully and reviewed by eye; the first real test is your upload.
   If a page white-screens after an update, that is the likely cause and it is
   fixable in minutes — rename the child theme folder to fall back to the parent.
2. **I cannot see the site.** `fetch_page` gives me the text and the links, not the
   layout. Colours, spacing and mobile behaviour are all blind to me; a screenshot
   closes that gap instantly.
3. **The live site is public and indexable right now**, with 17 duplicates and a
   lorem FAQ page. That is the one thing in the audit with an audience and no
   turnaround — every day it stays that way, Google indexes more of it.

---

## What I'd do next, in the order that removes the most risk

1. **You:** switch the store to **Live** (item 1). Nothing else is measurable until
   then, and I can verify it in a minute afterwards.
2. **You:** check guest checkout (item 9). If it is off and registration is off, no
   order can be completed no matter how good the rest is.
3. **Me, in parallel:** the FAQ page, the ten product descriptions, the Symbols
   strip, and the duplicate cleaner. None of it needs a decision from you.
4. **You:** footer → Terms → paste the five corrected pages → trash the duplicates.
5. **Me:** re-audit every page against this document and report what still fails.

Hand me the real address, phone, email and the three delivery prices and items 5
and 6 stop being yours — I will fill them, publish-ready.
