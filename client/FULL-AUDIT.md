# Full site audit — 2 November 2026

**Site:** `https://queendorfashionhouse.com` · theme **1.8.8** · child theme live, domain live
**Method:** every page fetched and read as served, plus the WordPress REST API
(30 published pages) and the public WooCommerce Store API (10 products, 5 categories).
**Not checked:** JavaScript console, mobile layout, form submission, payment flow,
page speed. There is no browser here — those need a person with one.

---

## The headline

**The shop cannot be used by anyone right now.**

Every WooCommerce page returns WooCommerce's *Coming soon* screen:

> **Great things are on the horizon** — Something big is brewing! Our store is in
> the works and will be launching soon!

Confirmed on `/shop/`, `/cart/`, `/checkout/`, a product page, and the
`/symbol/sankofa/` archive. The store is in **WooCommerce → Settings → Site
visibility → Coming soon** mode.

Why this matters more than any other finding:

- No customer can browse, add to cart, or check out.
- The product pages cannot be reviewed — there is nothing to review.
- Paystack cannot be tested or approved against a store that is closed.
- The home page *does* show products, because those are Elementor widgets
  rendering server-side, not store pages — so the site looks alive from the front
  door and is dead one click in. That is the worst possible state to demo from.

**Fix: WooCommerce → Settings → Site visibility → Live.** One setting. Nothing else
in this document can be judged until it is off — and it should be switched off
before the next screenshot, not after.

---

## Page by page

30 published pages, of which **17 are duplicates**. Rendering status is what a
visitor gets today.

| Page | URL | State |
|---|---|---|
| Home | `/` | ⚠ renders — 9 of 10 products are empty frames, demo category section, "Why Adinkra" band is a heading and an icon with no text |
| Shop | `/shop/` | ⛔ coming soon |
| Product | `/product/…` | ⛔ coming soon (10 products) |
| Cart | `/cart/` | ⛔ coming soon |
| Checkout | `/checkout/` | ⛔ coming soon |
| My account | `/my-account/` | ✅ login renders — **no register form** |
| Wishlist | `/wishlist/` | ⚠ renders, wishlist template renders twice per product elsewhere |
| Contact | `/contact/` | 🔴 **demo data** — "dains wQ 966 munich Expresswa 70 Germany, TX 7859", phone `+9-555-888-679`, email `luxrio@info.com` |
| About | `/about/` | ⚠ real copy, but no registered name, address or contact block |
| Wholesale | `/wholesale/` | ✅ real content and an application form — form untested |
| Symbols | `/symbols/` | ✅ excellent — 12 symbols with meanings |
| Symbol archive | `/symbol/sankofa/` | ⛔ coming soon — every "Shop this symbol" link lands here |
| Size guide | `/size-guide/` | ✅ excellent, real ring-size table |
| Returns & Exchanges | `/returns-exchanges/` | ⚠ correct, but no refund timing, no contact, no steps |
| Shipping & Delivery | `/shipping-delivery/` | 🔴 **every price is a blank** `GH₵ ____` |
| Privacy Policy | `/privacy-policy-2/` | 🔴 contains a literal `________` where the contact email should be |
| FAQs | `/faqs/` | 🔴 **100% demo lorem text** — *"Waters one you'll creeping?"* |
| Terms & Conditions | `/terms/` | 🔴 **404 — the page does not exist** |
| Sample page | `/sample-page/` | 🔴 WordPress default, should be deleted |

### The 17 duplicates

`contact-2`, `contact-3`, `about-2`, `wholesale-2`, `symbols-2`, `size-guide-2`,
`privacy-policy-3`, `returns-exchanges-2`, `shipping-delivery-2`, `shop-2`,
`cart-2`, `checkout-2`, `wishlist-2`, `my-account-2`, `sample-page` — plus the
`-2/-3` slugs on the live privacy, returns and shipping pages themselves.

Two or three of everything, all indexed, all publicly reachable, many of them
stale. A payment reviewer clicking around this site sees an unfinished template
site; a customer searching Google finds whichever copy ranks first.

---

## Feature by feature

| Feature | State |
|---|---|
| **WooCommerce visibility** | ⛔ **coming soon — everything below is moot until off** |
| Currency | ✅ GHS, ₵ symbol, 2 decimals |
| Products | ✅ 10, all in stock, correct prices and SKUs (QD-001…010) |
| Product images | 🔴 **9 of 10 have none** — only *Bese Saka* has a photograph |
| Categories | ✅ 5 real ones: necklaces, earrings, bracelets, rings, sets-gifts |
| Header | ✅ teal, white logo and menu, 6 items, no wrap |
| Footer | 🔴 **renders nothing on every page** — theme options unset |
| Side cart drawer | ⚠ works, but its icons still load from `www.blaharbenyah.com/dorcas/…` |
| Contact form | ⚠ untested — has never been proven to deliver |
| Wholesale form | ⚠ untested |
| Account registration | 🔴 no register form on My account — **and guest checkout is unverified**; if both are off, nobody can order |
| Paystack | ⚠ not configured; untestable while the store is closed |
| Order email | ⚠ never tested |
| Search | ⚠ untested (would hit closed product pages) |
| Wishlist | ⚠ "Add to Wishlist" appears **twice** on every product card |
| Instagram strip | ⚠ 3 tiles, 1 photo (imported with one attachment ID) |
| 404 page | ✅ renders correctly |
| `robots.txt` | ⚠ valid, **permits indexing** while the store is closed |
| Sitemap | 🔴 `/sitemap.xml` and `/sitemap_index.xml` both **HTTP 500** |
| HTTPS | ✅ pages serve over HTTPS; force-HTTPS not confirmed |
| Demo assets | 🔴 14 images still loading from `wordpress.vecurosoft.com` |
| Old domain leakage | 🔴 side-cart icons, cart "Return to Shop" link |

---

## Defect register

### P0 — blocks launch

| # | Defect | Fix | Owner |
|---|---|---|---|
| 1 | WooCommerce **Coming soon** mode on | Settings → Site visibility → Live | you |
| 2 | **No Terms page** (`/terms/` 404) | publish `paystack-pages/1-terms-and-conditions.md` | you |
| 3 | **Footer renders nothing** | Theme Options → Footer → Footer Builder → select template | you |
| 4 | **9 of 10 products have no image** | photographs, or hide them until you have them | client |
| 5 | Contact page is **German demo data** | paste `5-contact.md` with real details | you |
| 6 | Delivery prices are blanks | fill the table + WooCommerce shipping settings | client |
| 7 | FAQs is **lorem ipsum** | delete the four nonsense questions, keep the headings, write real answers | you |
| 8 | Order email **never tested** | place a test order, confirm arrival | you |
| 9 | Account registration off **and guest checkout unverified** | check both in WooCommerce → Settings → Accounts & Privacy | you |

### P1 — will fail a Paystack review

| # | Defect | Fix |
|---|---|---|
| 10 | Privacy policy has `________` where the email should be | paste `4-privacy-policy.md` |
| 11 | Contact/shipping icons from the old domain | Better Search Replace the plugin paths, or re-save the plugin |
| 12 | 14 demo assets on `wordpress.vecurosoft.com` | download and re-upload |
| 13 | 17 duplicate pages live | trash them |
| 14 | `/privacy-policy-2/`, `/about-2/` slugs | rename, and trash the `-3`/`-2` copies |
| 15 | Sitemap 500s | regenerate the SEO plugin's sitemap |

### P2 — quality

| # | Defect | Fix |
|---|---|---|
| 16 | "Add to Wishlist" twice per card | find the second template, remove |
| 17 | Home page "CUSTOM Jewelry" section is the demo | swap for the real category loop |
| 18 | Home page "Why Adinkra" band has no body text | fill it, or link to `/symbols/` |
| 19 | Instagram strip: 3 tiles, 1 photo | regenerate with 3 distinct images |
| 20 | Both promo cards say "Shop Now" → `/shop/` | make one "Wholesale" |
| 21 | Hero image is an AI placeholder | replace with real product photography |
| 22 | Product page heading reads "Shop Details" | theme string |
| 23 | `home-03` as the front page slug | cosmetic, harmless |

---

## What is genuinely good

Not everything here is a defect, and the parts that work should not be rebuilt:

- **The Symbols page** is the best thing on the site — 12 Adinkra symbols, correct
  meanings, real prose. It is the brand's whole differentiator and nothing else on
  the internet has it.
- **The Size Guide** is properly done: a real ring-size table in mm, and the
  instruction to measure an existing ring rather than a finger.
- **The header** — teal, white logo, six clean items, no wrap.
- **Products are correctly priced, SKU'd and in stock**, in five real categories.
- **Wholesale** is a complete, coherent page: terms, minimum, 50% trade price, and
  an application form.
- **The 404 page** works.
- **The whole light-mode rebuild holds**: readable text everywhere it can be read.

---

## Order of work

1. **Switch the store live.** Everything else is unmeasurable until this is done.
2. **Check accounts**: is guest checkout on? If registration is off *and* guest
   checkout is off, no customer can complete an order even once the store is live.
3. **Footer** — four clicks, and it makes the six policy pages reachable.
4. **Publish Terms**, then paste the corrected Contact, Delivery, Privacy and
   Returns pages over their existing versions.
5. **Rewrite the FAQs** — delete, don't translate, the lorem.
6. **Trash the 17 duplicates** and rename `-2`/`-3` slugs.
7. **Order email + contact form + wholesale form**: send three test messages. This
   has never been done and it is the thing that will cost a customer if it is wrong.
8. **Photography** — nine pieces, and the site stops looking like a template.
9. Then Paystack: test keys → test order → activation request.

Items 1–6 are all settings and copy: no photography, no decisions, no waiting on
anyone. That is one focused afternoon, and it moves the site from "obviously
unfinished" to "ready to be reviewed".
