# Pre-launch audit — `blaharbenyah.com/dorcas`

**Audited:** 30 October 2026 · **Method:** every page fetched live (HTTP 200 or 404 confirmed), plus a read of the deployed theme and the child theme in this repo.

**What this audit cannot see.** No browser and no session: page weight, layout, mobile, the checkout flow behind a cart, response headers, TLS grade and admin settings are all outside reach. Those are listed separately at the end with a procedure, rather than guessed at.

---

## Scorecard

| Area | Status | One line |
|---|---|---|
| Hosting / uptime | 🟢 | Serving, HTTPS, no fatal errors on any page |
| Catalogue | 🟢 | Exactly the ten QD products; demo products gone |
| Currency / tax display | 🟢 | `₵320.00`, GHS |
| Symbol archives | 🟢 | `/symbol/sankofa/` works — 3 products |
| Product pages | 🟡 | Content and structure good; no imagery; duplicated UI |
| **Navigation** | 🔴 | "Shop" goes to an **empty page**; five links are demo |
| **Home page** | 🔴 | Still 100% demo copy and vendor-hosted images |
| **Pages** | 🔴 | About / Wholesale / policies not imported — 404 |
| Media | 🔴 | ~30 images hotlinked to the vendor's server |
| Checkout | ⚪ | Unverified — needs a real cart |
| Security | 🟡 | Admin username published in blog URLs |
| SEO | 🟡 | Title/meta ok; no descriptions, no canonical strategy |
| Accessibility | 🟡 | Alt text generic; heading order broken in places |

---

## P0 — blocks launch

### 1. The main menu's "Shop" link is an empty page

`/shop-2/` returns **200 with zero products** — it's the demo's duplicate *page*, not WooCommerce's shop. The header and footer both point there.

```
Menu "Shop"     → https://…/dorcas/shop-2/     → 200, "Shop", 0 products
Real shop       → https://…/dorcas/shop/       → 200, 10 products
```

Same class of bug for `Cart → /cart-2/`, `Checkout → /checkout-2/`, `My account → /my-account-2/`, and `Watch → /product-category/luxry-watch/` (a demo category). `404 Page → wordpress.vecurosoft.com/luxrio/404page` still leaves the site entirely.

**Fix — 5 minutes.** `Appearance → Menus`: delete every item except Home, then add Shop (`/shop/`), Symbols, Wholesale, About, Contact. Delete the "Pages" mega-menu tree and both "Page List 3/4" parents. Then `Pages → Shop 2, Cart 2, Checkout 2, My Account 2` → Trash.

### 2. About, Wholesale and the policy pages do not exist

`/about/` → **404**, `/wholesale/` → **404**. The eight replacement pages in `queendor-pages.wxr` have not been imported.

**Fix.** `Tools → Import → WordPress` → `queendor-pages.wxr`. Import once; a second import creates `about-2`, `about-3` and so on. Then fill the `________` blanks — the About page currently ships with placeholder markers by design.

### 3. ~30 images are loaded from the theme vendor's server

The home page pulls its hero, category tiles, offer banners, testimonial avatars and Instagram strip from `https://wordpress.vecurosoft.com/luxrio/wp-content/uploads/…`.

That is the theme author's demo site. If they reorganise their install — and demo sites get archived routinely — every one of those images becomes a broken box, on the one page a customer sees first. It also makes the page slower, since each image crosses an extra connection.

**Fix — 10 minutes, no code.** In Elementor, for each of the demo sections: replace the image with a client asset. Since the sections are being rewritten anyway (see §4), this disappears with them. If any section is being kept, re-upload its image in the media library and re-select it.

### 4. The home page is entirely demo copy

Verbatim, live right now:

- Heading: **"Necklacejeweellery"** — two words run together
- Slider: *"HOLY JEWELRY and diamonds pendants"* → "Shop Now"
- Section: **"Find the perfect / High Class Jewellery"**
- Category tiles: **"wedding ring — 10 Product"**, *"Diamond Pendant — 12 Product"*, *"Woman Earring — 15 Product"*, all linking to `#`
- Offers: **"save up to 40% off / custom wedding Rings"**, twice
- Testimonials: *"Lorem ipsum dolor sit amet…"* attributed to **"alaxander lee"** and **"Vivi Marian"**
- Newsletter: *"Sign up to our newsletter for information on sales"*
- Instagram strip: six vendor photos

None of it is true. "40% off custom wedding rings" is a pricing claim the shop doesn't honour, and a fake testimonial with a misspelt name is worse than no testimonial.

**Fix.** `REPLACE-DEMO.md` §5 has section-by-section replacement copy for this exact page. Delete the testimonial and Instagram blocks unless the client supplies real ones.

### 5. Product photography

Every product shows WooCommerce's grey placeholder — a 600×600 webp of a camera icon. See `PHOTO-REQUEST.md`. Nothing else on the site can compensate for this, and no amount of copy fixes it.

### 6. WordPress's default post is live, and it names the admin account

`/blog/` shows one post: **"Hello world!"** — *"Welcome to WordPress. This is your first post. Edit or delete it, then start writing!"* — credited to **Iwan1**, with a public author archive at `/author/iwan1/`.

Two problems in one line. The post is visibly unfinished plumbing. And publishing the admin's login name tells anyone attacking `/wp-login.php` or `/xmlrpc.php` exactly which username to try, which removes half the guesswork from a password attack.

**Fix.** Delete the post (`Posts → Hello world! → Trash`). Then break the username link: `Users → Add New`, create a new administrator with a different username and a display name of your choosing, log in as it, and demote or delete `Iwan1`. Note the cleanup plugin's date rule (posts before 2025) never caught this one because it was created at install time — **cleanup plugin 1.0.1** now matches it explicitly.

### 7. Payment has never been exercised

No gateway has been confirmed, and checkout cannot be reached without a cart. A shop that cannot take money is not launched, whatever else is finished. Procedure is in *Cannot verify* below.

---

## P1 — fix before showing the client

### 8. Every product page has the H1 "Shop Details"

The `<h1>` on all ten products is the theme's option default, **"Shop Details"** — not the product name. Ten pages with an identical main heading is a real SEO problem and reads oddly to a screen reader announcing the page.

**Fix.** `Theme Options → Shop → (single product banner title)` — set it to `Shop`, or clear it. Same screen: the related-products heading defaults to **"highly recommend"**, visible on every product page — change to "You may also like".

### 9. "Add to Wishlist" renders four times per product

Confirmed on the shop grid, the single product page and the symbol archive. Four identical links in the same card. One is the plugin's, one is the theme's, and the rest are likely duplicated markup.

**Fix.** `Appearance → Widgets` / TI Wishlist settings — disable the theme's button and keep one. If it survives that, it needs a browser inspection; there are three candidate hooks and I can't tell which fires twice without seeing the DOM.

### 10. Related products are output twice

On `/product/sankofa-pendant-necklace/` under "top related products", the same six products appear, then appear again. On the shop page the entire grid repeats below the pagination. This looks like the carousel library cloning slides for infinite scrolling — normal markup, but if it's *visible* duplication it's a layout bug. **Needs one browser check**: scroll to the bottom of a product page. If you see two rows of related products, tell me and I'll patch it out.

### 11. Ten products, nine per page

`Showing 1–9 of 10 results` with a pagination link to page 2. One product alone on a second page is a bad customer experience for a ten-item catalogue.

**Fix.** `Appearance → Customize → WooCommerce → Product Catalogue → Products per page` → `12`.

### 12. There is no filtering on the shop

No category filter, no symbol filter, no price or material filter — only the default sort dropdown. For a shop built on *symbols*, the single most obvious way to browse is missing from the shop itself (it exists at `/symbol/sankofa/`, but nothing links there except product attribute tables).

**Fix.** `Appearance → Widgets` → add Filter Products by Attribute (`Symbol`) and Filter by Category to the shop sidebar, or use the shop's filter bar if the theme option enables one. This is the highest-value five minutes in this document after the menu.

### 13. Registration is off, and wholesale needs it

`/my-account/` shows a login form only — no Register tab. That's consistent with guest checkout, but the wholesale plan depends on accounts (role `wholesale_customer`, manual approval). Turn on `WooCommerce → Settings → Accounts & Privacy → Allow customers to create an account`.

### 14. Trust claims the shop hasn't earned

The side cart says **"Secure Checkout · Fast Shipping · Easy Returns"** on every page. Until a gateway is live and delivery terms exist, "secure checkout" is a claim, not a fact. Either finish the checkout or soften the wording — `Easy Returns` also contradicts the earrings-are-non-returnable policy that's already written.

### 15. The FAQ page is demo content

`/faqs/` is in the menu twice ("FAQ's" in the Pages tree and again standalone). It's still the theme's demo Q&A. Either import the client's real answers or remove it from the menu until there are any.

---

## P2 — before you hand over

| # | Issue | Where |
|---|---|---|
| 16 | No meta descriptions — every search result will be auto-snippeted | all pages |
| 17 | Alt text is `logo`, `cate 1 1`, `insta 1 2` — the theme's demo filenames | all pages |
| 18 | Heading order: `<h3>` product titles sit under `<h2>` section titles on some sections and leap straight from `<h1>` on others | home, shop |
| 19 | Share links point at `twitter.com` and `http://pinterest.com` (insecure protocol) | blog |
| 20 | No cookie/consent notice; Ghana's Data Protection Act 843 covers analytics and newsletter signups | sitewide |
| 21 | Newsletter form has no visible consent line or double opt-in | home footer |
| 22 | No analytics, no Meta pixel, no Search Console verification — nothing measures launch | head |
| 23 | Order emails will send from the host with no SMTP — they'll land in spam | WooCommerce |
| 24 | Demo categories still in the store: `luxry-watch` is linked from the menu | Products → Categories |
| 25 | No `noindex` on the staging install — Google can index `/dorcas/` and will compete with the real site later | head |
| 26 | Preloader animation on first paint ("Cancel Preloader" is the first thing in the DOM) — it delays the largest paint for no benefit | theme options |

---

## Cannot verify — and how to

| Thing | Why | How to check in 5 minutes |
|---|---|---|
| **Checkout end to end** | Needs a session and a cart | Add a product to the cart, go to checkout, pay with a **GH₵1 test product** on Paystack test keys. Confirm: order confirmation page, admin email, customer email, stock decrement |
| **Which gateways exist** | Not visible from HTML | `WooCommerce → Settings → Payments` — screenshot it to me |
| **Response headers / TLS** | No header access here | [securityheaders.com](https://securityheaders.com) and [ssllabs.com/ssltest](https://www.ssllabs.com/ssltest/) on the domain |
| **Page weight / Core Web Vitals** | Needs a browser | PageSpeed Insights on `/dorcas/` — expect a poor LCP purely from the hotlinked vendor images (§3) |
| **Layout and mobile** | Text extraction strips CSS | Resize to 390 px wide: check the header, the product grid, and the side cart |
| **Footer content** | The text extractor didn't return it | Scroll to the bottom — confirm the credit no longer says "Luxrio / Vecuro" (child theme 1.2.0, not yet installed) |
| **Indexing** | `robots.txt` at the domain root is the one that counts | `Settings → Reading` → tick "Discourage search engines" until launch day |

---

## Order of work

| When | Task | Time |
|---|---|---|
| **Now** | Rebuild the menu (§1) — a customer currently lands on an empty page | 5 min |
| **Now** | Import `queendor-pages.wxr` (§2) | 2 min |
| **Now** | Delete "Hello world!", rename the admin account (§6) | 10 min |
| **Now** | Products per page → 12 (§11), symbol filter on shop (§12) | 5 min |
| **Now** | Fix the two theme-option headings (§8) | 2 min |
| **Today** | Install child theme 1.2.0 + cleanup 1.0.1 from the pack | 2 min |
| **Today** | Rewrite the home page from `REPLACE-DEMO.md` §5, deleting the fake testimonials and the 40%-off banners (§4) | 2 h |
| **This week** | Photography (`PHOTO-REQUEST.md`) | client |
| **This week** | Paystack + shipping zones + the GH₵1 test order (§7) | 1 h |
| **Before handover** | P2 block: meta descriptions, alt text, consent, SMTP, analytics | 3 h |
| **Launch day** | Remove `/dorcas/` from the URL, `https` + `www` canonical, untick "discourage search engines" | 1 h |

---

## What is genuinely finished

Worth stating plainly, because the list above is long: the theme is patched and running without errors; the catalogue is exactly the ten intended products with real SKUs, GHS prices, attributes and copy; the Adinkra symbol taxonomy works as an archive; currency, tax display and the product page structure are all correct; and the demo products, posts and pages that the cleanup tool targets are gone. Everything left is content and configuration — no architectural problem remains.
