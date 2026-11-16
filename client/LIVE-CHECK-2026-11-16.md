# Live check — 16 November 2026, 14:00

Fetched every page that matters from `https://queendorfashionhouse.com` and compared
against the latest build.

**Short answer: the theme is on the latest build (1.8.8), but the site has lost three
of the pages Paystack asked for, and a WooCommerce sample policy is now published in
their place.**

---

## What is on the latest build ✅

| Check | Result |
|---|---|
| Child theme version | **1.8.8** — the current build, with the footer CSS |
| Store visibility | **live** — `/shop/` lists all 10 products, cart works |
| Products | 10 published, correct prices and SKUs |
| FAQ page | **replaced** — 16 real questions, no lorem ipsum |
| Wholesale, Symbols, Size Guide, About, Shipping | all present |

The FAQ import worked. `Tools → Import` published it as the page at `/faqs/`, and the
demo text is gone.

---

## Regressions since this morning 🔴

Three pages that were live at 09:00 are now **404**:

| URL | This morning | Now |
|---|---|---|
| `/contact/` | live, demo German address | **404** |
| `/terms/` | live, placeholders | **404** |
| `/privacy-policy/` | (at `-2`) | **404 — no privacy page exists at all now** |

The header menu has dropped from six items to four: **Contact and FAQ's are gone**,
because both menu items were tied to those pages.

And in their place, WooCommerce's stock policy page is published at
`/refund_returns/`:

> **This is a sample page.**
> Our refund and returns policy lasts **30 days**…
> …Downloadable software products, CD, DVD, VHS tape…
> please contact us at **{email address}**
> send your item to: **{physical address}**

That is worse than a missing page. It contradicts the real returns page (7 days, not
30), it names products this shop does not sell, and it still has `{email address}` in
it. A reviewer will read it as either careless or dishonest.

**Most likely cause:** the cleanup plugin's section 3 (the page checklist) was ticked
broadly, or pages were deleted by hand while tidying. Nothing about the import itself
would have removed them.

---

## Recover in this order — 10 minutes

### 1. Restore the three pages from the Trash

**Pages → Trash** (the link at the top of the Pages list).

Hover each of **Contact**, **Terms and Conditions** and **Privacy Policy** → **Restore**.

WordPress keeps trashed pages for **30 days**, so they are almost certainly still
there. Restoring keeps their IDs, so nothing else breaks.

### 2. If they are not in the Trash

Re-import `queendor-paystack-pages.wxr` (Tools → Import → WordPress → Run Importer),
then publish Terms, Privacy and Contact at the slugs `terms`, `privacy-policy`,
`contact`, filling the brackets from `paystack-pages/`.

### 3. Trash the sample policy

**Pages → Refund and Returns Policy → Trash**, then empty only that item. It must not
be linked from anywhere. If you want WooCommerce's "refund policy" field populated,
point it at `/returns-exchanges/` instead:
**WooCommerce → Settings → Advanced → Refund and returns page.**

### 4. Put the menu back

**Appearance → Menus →** main menu → **Add Items → Pages** → tick **Contact** and
**FAQ's** → **Add to Menu** → drag into position → **Save Menu.**

---

## Still not applied — the build is current, the content is not

| Item | State |
|---|---|
| **Footer** | still renders nothing. The home page ends at the side cart |
| **Symbols strip** | not added — "Why Adinkra" is still a heading with no body |
| **CUSTOM Jewelry** section | still the demo: 30+ cards saying *Limited Edition · 20 Product*, linking to `#`, one image from `wordpress.vecurosoft.com` |
| **"High Class Jewelry" / "Style Keepers" / "Jewelry NOW UPDATE!"** | demo copy, unchanged |
| **Products** | 9 of 10 have no image — `woocommerce-placeholder` is showing on the cart page |
| **Side cart** | still loads its icons from `www.blaharbenyah.com/dorcas/…` |
| **Returns page** | no cancellation clause |
| **Shipping page** | `GH₵ ____` in all three rows (verified this morning) |
| **"Our work" button** | links to `/contact/`, which is now a 404 |
| **Duplicates** | `shipping-delivery` ×3, `returns-exchanges` ×2, `about` ×2, `symbols` ×2, `size-guide` ×2, `wholesale` ×2, `wishlist` ×2, `shop`/`cart`/`checkout`/`my-account` ×2, `sample-page` |

---

## The order that unbreaks it

1. **Restore the three pages** (§1). Nothing else matters until `/terms/`,
   `/privacy-policy/` and `/contact/` load.
2. **Trash the sample refund policy** (§3) and re-point the WooCommerce setting.
3. **Fix the menu** (§4).
4. **Assign the footer** — Theme Options → Footer → trigger *Footer Builder* → select
   *Queen Dor's Footer*. It is uploaded; the option is the only thing missing.
5. Finish the brackets in Terms, Privacy, Contact, Shipping and the FAQ.
6. Add the symbols strip, replace the demo category section.
7. Then the old domain, then the duplicates — **section 6 before section 5**, and do
   not use section 3 of the cleanup plugin at all. It is an unguarded checklist and
   it is the most likely reason the three pages vanished.

---

## What I could not check

No browser here: I read what the site serves, not how it looks. Mobile layout, the
Elementor canvas, the checkout with an item in the cart, and every form still need a
person with a screen. The one screenshot I have — the teal header — was the 1.8.4
build.
