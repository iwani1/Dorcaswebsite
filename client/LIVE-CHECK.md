# Live check — every page

Source: `https://queendorfashionhouse.com`, read page by page, plus the WordPress REST
API (`/wp-json/wp/v2/pages`) for the full inventory.

**Answer to "is it the latest build?": the theme is. `style.css` reports 1.8.8, which is
the newest build. The pages are not, because the content they hold is still being
replaced.**

**Answer to "does every page load?": no. `/terms/` is published but still returns 404 to
a visitor, and Contact and Privacy are live at the wrong addresses.**

---

## The three things that are broken right now

### 1. `/terms/` is 404 — but only because of the cache

The page **is** published. Page ID 9101, slug `terms`, status `publish`, full 14-section
copy. Load it with a cache-buster and it renders perfectly:

- `https://queendorfashionhouse.com/terms/` → **404**
- `https://queendorfashionhouse.com/terms/?nocache=1` → **the full Terms page**

LiteSpeed cached the 404 from when the page was deleted, and is still serving it. Any
visitor — including the Paystack reviewer — gets the 404.

**Fix:** LiteSpeed Cache → **Purge All**. Or hosting → cPanel → LiteSpeed Web Cache
Manager → Flush All. It takes five seconds and it is the single highest-value action on
this list.

### 2. Contact and Privacy are live, but at the wrong URLs

| Page | Published slug | Works at | Should be |
|---|---|---|---|
| Contact (1497) | `contact-2` | `/contact-2/` | `/contact/` |
| Privacy Policy (905) | `privacy-policy-2` | `/privacy-policy-2/` | `/privacy-policy/` |

Every "Contact Us" link on the home page, and the `/privacy-policy/` link in §10 of the
Terms, points at the short URL — which 404s. The `-2` pages were restored rather than the
originals, and WordPress kept the old slug.

**Fix:** Pages → hover the page → **Quick Edit** → change the slug from `contact-2` to
`contact` (and `privacy-policy-2` to `privacy-policy`) → Update. The address is free, so
WordPress will accept it. Then purge the cache again.

### 3. No page anywhere has a footer

Every page I loaded — Terms, Contact, Privacy, Refund, FAQ — ends with the side cart and
then stops. Blank space where the footer should be.

The footer template is uploaded. The theme option that activates it is not:
**Theme Options → Footer → Footer Builder trigger → select *Queen Dor's Footer***

---

## Page by page

| # | Page | URL | Loads? | Latest build? | Still wrong |
|---|---|---|---|---|---|
| 1 | Jewelry House (front page) | `/` | 200 | ✗ | Demo sections: *Limited Edition · 20 Product* repeated ~8×, one image from `wordpress.vecurosoft.com`. No symbols strip. No footer |
| 2 | Terms and Conditions | `/terms/` | **404** | ⚠ content yes, URL no | Cached 404. `[DATE]`, `[REGISTERED BUSINESS NAME]`, `[REGISTRATION NUMBER]`, `[BUSINESS ADDRESS]`, `[EMAIL ADDRESS]` ×2, `[PHONE NUMBER]` ×2, `[NUMBER] working days`, `[Delete whichever does not apply…]` |
| 3 | Contact | `/contact-2/` | 200 | ⚠ wrong URL | **Every field is `_______`** — phone, email, studio, hours. Also says "we answer faster on WhatsApp", which you rejected |
| 4 | Privacy Policy | `/privacy-policy-2/` | 200 | ⚠ wrong URL | Body is good. Email is `________` |
| 5 | FAQ's | `/faqs/` | 200 | ✓ replaced | `[EMAIL ADDRESS]` ×2, `[NUMBER] working days` ×2, the `[Choose one: …]` block |
| 6 | Refund and Returns Policy | `/refund_returns/` | 200 | ✗ **sample** | WooCommerce stock text: *"This is a sample page"*, 30-day returns, *"Downloadable software products, CD, DVD, VHS tape"*, `{email address}`, `{physical address}`. **Contradicts the real 7-day policy. Trash it** |
| 7 | Shipping & Delivery | `/shipping-delivery/` | 200 | ✗ | `GH₵ ____` in all three rows (checked earlier; not re-fetched) |
| 8 | Shipping & Delivery | `/shipping-delivery-2/` | 200 | — | duplicate |
| 9 | Shipping & Delivery | `/shipping-delivery-3/` | 200 | — | duplicate |
| 10 | Returns & Exchanges | `/returns-exchanges/` | 200 | ✗ | No cancellation clause, no contact details |
| 11 | Returns & Exchanges | `/returns-exchanges-2/` | 200 | — | duplicate |
| 12 | Symbols | `/symbols/` | 200 | ✓ | good — leave it |
| 13 | Symbols | `/symbols-2/` | 200 | — | duplicate |
| 14 | Size Guide | `/size-guide/` | 200 | ✓ | good — leave it |
| 15 | Size Guide | `/size-guide-2/` | 200 | — | duplicate |
| 16 | Wholesale | `/wholesale/` | 200 | ✓ | good — leave it |
| 17 | Wholesale | `/wholesale-2/` | 200 | — | duplicate |
| 18 | About | `/about/` | 200 | ⚠ | not re-checked this round |
| 19 | About | `/about-2/` | 200 | — | duplicate |
| 20 | Shop | `/shop/` | 200 | ✓ live | 10 products, prices and SKUs correct — **9 of 10 have no photo** |
| 21 | Shop | `/shop-2/` | 200 | — | duplicate |
| 22 | Cart | `/cart/` | 200 | ✓ | works |
| 23 | Cart | `/cart-2/` | 200 | — | duplicate |
| 24 | Checkout | `/checkout/` | 200 | ✓ | redirects to the empty cart; untested with an item |
| 25 | Checkout | `/checkout-2/` | 200 | — | duplicate |
| 26 | My account | `/my-account/` | 200 | ⚠ | no register form |
| 27 | My account | `/my-account-2/` | 200 | — | duplicate |
| 28 | Wishlist | `/wishlist/` | 200 | — | theme feature, keep or drop |
| 29 | Wishlist | `/wishlist-2/` | 200 | — | duplicate |
| 30 | Sample Page | `/sample-page/` | 200 | ✗ | WordPress default. Delete |

**30 published pages, 0 drafts. 13 of the 30 are duplicates or defaults.**

---

## Header menu — fixed ✓

Six items, all pointing somewhere live:

`Jewelry House · Wholesale · Contact · FAQ's · Shop · My account`

Contact and FAQ's are back. Contact just needs its slug changed (§2).

---

## Cross-cutting, on every page

| Item | State |
|---|---|
| **Footer** | 🔴 missing everywhere — the theme option is not set |
| **Side cart icons** | 🔴 still load from `www.blaharbenyah.com/dorcas/` — cleanup plugin §6 fixes this |
| **Favicon / logo** | ✓ real logo, `uploads/2024/11/logo.svg` |
| **404 page** | ✓ good |

---

## Do these six, in this order

1. **LiteSpeed → Purge All.** Un-404s `/terms/` immediately.
2. **Rename the two slugs**: `contact-2` → `contact`, `privacy-policy-2` → `privacy-policy`.
3. **Trash `/refund_returns/`** (the sample page) and point WooCommerce → Settings →
   Advanced → *Refund and returns page* at `/returns-exchanges/`.
4. **Assign the footer** — Theme Options → Footer → select *Queen Dor's Footer*.
5. **Fill the blanks** — Contact (4 fields), Privacy (email), Terms (9 brackets), FAQ
   (4 brackets), Shipping (3 prices). The values I need from you: business registration
   name and number, business address, phone, email, VAT status, refund window in working
   days, delivery prices.
6. **Then** the old domain, then the demo home sections and the duplicate pages.

Nothing in 6 is worth doing before 1–4. Right now the site has a Terms page that
visitors cannot reach, a Contact page with no contact details, and a published policy
that calls itself a sample.

---

## Not checked

No browser here: I read what the server returns, not how it looks. Mobile layout, the
Elementor canvas, checkout with an item in the cart, and every form still need a person
with a screen. Shipping, Returns, About, Symbols, Size Guide and Wholesale were verified
in the previous sweep and not re-fetched in this one.
