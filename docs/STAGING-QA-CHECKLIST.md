# Staging QA checklist — Luxrio store

Use this on a **password-protected staging site** with `noindex` on, before switching DNS.

**Store:** Dorcas · **Theme:** Luxrio 1.0.1 (patched, `arena/336564b6-dorcaswebsite`) · **Builder:** Elementor · **Commerce:** WooCommerce
**Tester:** ______________  **Date:** ____________  **Environment URL:** ____________________________

> Nothing in this theme has been executed by PHP or rendered in a browser yet — every change so far was static, parse-checked and reviewed. Treat the first three sections as "does it even boot", and do not skip the payment section.

---

## 0. Pre-flight (30 min)

- [ ] Staging is a **full copy**, not a fresh install — same WordPress, PHP, MySQL versions as production will be
- [ ] `wp-content/uploads/` copied, `.htaccess`/nginx config copied
- [ ] **Backup taken** and restore tested (a backup you have not restored is a guess)
- [ ] `DISALLOW_FILE_EDIT` and `WP_DEBUG_LOG` set on staging; `WP_DEBUG` off in production
- [ ] Record versions now, in the table at the bottom — this becomes your frozen baseline
- [ ] Site is `noindex` + password protected (`Settings → Reading → Search engine visibility`)
- [ ] Deploy the patched theme, child theme and `luxrio-core` plugin from this repo
- [ ] Run `./tools/build-core-plugin-zip.sh` if you patched the plugin, so the installer bundle matches

---

## 1. Boot and activate (15 min)

- [ ] Upload `wp-content/themes/luxrio`, `wp-content/themes/luxrio-child`, `wp-content/plugins/luxrio-core` — **no PHP fatal, no white screen**
- [ ] Activate **Luxrio Child** (not the parent)
- [ ] Activate **Luxrio Core** manually; confirm no "plugin file does not exist" notice
- [ ] Install the third-party plugins from **Appearance → Install Plugins**
- [ ] **Verify the two plugin slugs are right:** "WPC Smart Quick View" installs `woo-smart-quick-view`, "Side Cart WooCommerce" installs `side-cart-woocommerce` (they were swapped in the vendor build)
- [ ] No PHP notices in `wp-content/debug.log` after visiting: home, shop, product, cart, checkout, my-account, blog post, 404
- [ ] Admin → Appearance → Themes shows the Luxrio screenshot and the child theme as active

---

## 2. Demo import (45 min)

- [ ] Import runs to completion **without a fatal error** (this was the main crash path — it now uses `WP_Query` and guarded object access)
- [ ] Front page is set to **Home 01**, blog page to **Blog**
- [ ] Menus assigned to Primary + Mobile locations
- [ ] Elementor global colours match the theme (primary `#ff3e01`)
- [ ] **All 226 demo images imported locally** — confirm no `wordpress.vecurosoft.com` URLs remain in the media library or page source
- [ ] Demo products, variations, reviews and categories present
- [ ] **Icons render:** check the header search icon, minicart, social icons, star ratings — Font Awesome was downgraded from Pro to Free, so this is the one visual thing most likely to have shifted
- [ ] Nothing shows a blank square / tofu glyph

---

## 3. Branding

- [ ] Upload the real logo (dark + white) in **Theme Options → Logo** — the bundled `logo.svg` / `logo-white.svg` are placeholders, and the white one must go on dark headers
- [ ] Favicon set
- [ ] **Replace Google Fonts with self-hosted files**, or consciously accept the external request (privacy + render performance)
- [ ] Contact details, address, phone, social links, footer copyright correct
- [ ] **Remove leftover "Vecuro"/"Luxrio" demo attribution** if any remains in the footer or demo pages

---

## 4. Catalogue

- [ ] Shop archive loads; filters/sorting/orderby work
- [ ] Product page: gallery, zoom, variation swatches, tabs, related, up-sells
- [ ] Quantity stepper respects min/max and stock (this is one of the six templates needing an upstream merge)
- [ ] **Variable products:** every combination selectable, price and stock update
- [ ] **Grouped products** (if used): label reads sensibly to a screen reader
- [ ] Out-of-stock and backorder behaviour correct
- [ ] Search returns products; empty search state is styled
- [ ] Product reviews post and display; rating stars render
- [ ] Wishlist add/remove (TI Wishlist)
- [ ] Quick view and side cart open correctly

---

## 5. Cart

- [ ] Add to cart from shop, product, and quick view
- [ ] Cart totals, shipping estimate, coupon apply/remove
- [ ] Quantity change and remove-item update without page reload errors
- [ ] Empty cart page renders (uses `assets/img/empty-cart.png`)
- [ ] Cart persists across login/refresh
- [ ] Cross-sells render if enabled

---

## 6. Checkout and payments — **the gate**

- [ ] Checkout fields validate; required-field errors display
- [ ] Guest checkout works **and** logged-in checkout works
- [ ] Shipping method selection recalculates totals
- [ ] Currency displays **GHS** with correct symbol and decimals
- [ ] **Test order #1 — card:** Paystack/Flutterwave/Hubtel test card, successful payment
- [ ] **Test order #2 — mobile money:** MTN MoMo (and Vodafone/Telecel if offered) end-to-end
- [ ] **Test order #3 — failed payment:** decline a card, confirm the customer sees a clear message and no order is marked paid
- [ ] **Test order #4 — cancelled payment:** abandon at the gateway, confirm return to site
- [ ] Order-received page shows the order, not a blank or 500
- [ ] Stock reduced correctly; coupon usage counted
- [ ] VAT display matches your decision (inclusive vs exclusive)

---

## 7. Emails

- [ ] Order confirmation arrives at a real inbox (not spam) within 1 minute
- [ ] Admin new-order email arrives
- [ ] Password reset email arrives
- [ ] Emails render on mobile; logo and colours correct
- [ ] **SPF, DKIM and DMARC pass** for the sending domain
- [ ] From-name and reply-to are the store's, not the host's default

---

## 8. Accounts

- [ ] Register → confirmation → login
- [ ] Login with wrong password shows a friendly error, not a PHP warning
- [ ] **Login form rejects `?username[]=x`** without a PHP warning (merged fix)
- [ ] Password reset flow completes
- [ ] Account dashboard, orders, addresses, and **edit-account password change** all submit (the `autocomplete` fix affects browser password managers here)
- [ ] Logout works; session ends

---

## 9. Orders and fulfilment

- [ ] Order visible in admin with correct line items, tax, shipping
- [ ] Order status change triggers the right customer email
- [ ] Invoice/packing slip (if any plugin) renders
- [ ] **Refund processed** in test mode; stock restored if configured
- [ ] **WooCommerce → Status → Templates:** ideally still shows overrides; re-run `tools/wc-template-audit.py` and confirm only the known six are marked MERGE
- [ ] **HPOS:** after confirming the above, declare compatibility and re-test one order before enabling custom order tables

---

## 10. Content pages

- [ ] Home, About, Contact (form submits + email received), FAQ, Shop, Cart, Checkout, My Account, Blog, 404, search results
- [ ] Elementor header/footer builder pages render on desktop and mobile
- [ ] Blog listing, single post, categories, pagination
- [ ] Contact Form 7 submissions arrive and show the success message
- [ ] Breadcrumbs appear on inner pages

---

## 11. Responsive and cross-browser

- [ ] 360 px, 375 px, 768 px, 1024 px, 1440 px, 1920 px
- [ ] Off-canvas / mobile menu opens, closes, and is keyboard-operable
- [ ] Sticky header behaves; no horizontal scrollbar on any page
- [ ] Safari (iOS), Chrome (Android), Chrome/Firefox/Edge desktop
- [ ] **Animation check:** GSAP/ScrollTrigger/Lenis effects do not hide content or break on slow connections
- [ ] Touch targets ≥ 44 px on mobile CTAs

---

## 12. Performance

- [ ] Lighthouse mobile ≥ 70 performance on home, shop, product
- [ ] LCP < 2.5 s on 4G throttling
- [ ] CLS < 0.1 — watch hero slider and sticky header
- [ ] Images served in WebP/AVIF with correct `srcset`
- [ ] Page caching + object caching active; **cache purged after deploy**
- [ ] CSS/JS minified & combined per your host's pipeline; confirm `style.min.css` is the file served
- [ ] **Total page weight < 2 MB** on a product page (fonts are now 312 KB, not 18 MB — verify it stayed that way after plugins)
- [ ] No 404s in the network tab (watch for `style-editor.css`, `color.schemes.css`, Font Awesome variants)

---

## 13. Accessibility

- [ ] Full keyboard pass: tab through header → nav → product → cart → checkout, all reachable, visible focus
- [ ] Skip link present and functional *(not yet implemented — add to `header.php` or accept the gap)*
- [ ] Colour contrast on CTAs and body text ≥ 4.5:1
- [ ] All images have alt text; icon-only buttons have accessible names
- [ ] Screen-reader spot check on product and checkout (VoiceOver/NVDA)
- [ ] Form labels tied to inputs

---

## 14. SEO and analytics

- [ ] `noindex` **removed** and `robots.txt` allows crawling at go-live
- [ ] XML sitemap generated and reachable
- [ ] Titles/meta descriptions on key pages
- [ ] Product structured data validates (Rich Results Test)
- [ ] Analytics + consent banner installed; consent mode configured
- [ ] Google Search Console / Merchant Center verified (if used)
- [ ] 301s mapped from any old URLs

---

## 15. Security and legal

- [ ] HTTPS everywhere; HTTP redirects; HSTS considered
- [ ] Security headers: `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, CSP (at least report-only)
- [ ] Admin user renamed from `admin`; strong passwords; 2FA on all admin accounts
- [ ] Least privilege: shop manager vs administrator roles correct
- [ ] `wp-config.php` keys/salts regenerated; `DISALLOW_FILE_EDIT` true in production
- [ ] File permissions 644/755; directory listing disabled
- [ ] **Daily offsite backups** scheduled + one restore rehearsed
- [ ] Uptime monitoring and error alerting configured
- [ ] Privacy policy, terms, **returns/refund policy**, cookie policy published
- [ ] **Ghana Data Protection Act (2012)**: lawful basis for customer data, retention defined, contact for data requests stated
- [ ] Business registration / seller details displayed as required by your payment provider

---

## 16. Go-live switch

- [ ] Final content freeze communicated
- [ ] Fresh backup of staging taken
- [ ] DNS/pointing switched; SSL certificate issued for the live domain
- [ ] `WP_HOME`/`WP_SITEURL` and any hardcoded staging URLs updated (search-and-replace on the DB)
- [ ] Staging password protection removed **only** on the live copy; staging stays protected and `noindex`
- [ ] Caches purged (page cache, object cache, CDN, browser)
- [ ] **Live smoke test:** home → shop → product → cart → checkout (real card, small amount) → refund
- [ ] Confirmation email received from the live domain
- [ ] Payment webhook URL updated in the gateway dashboard to the live domain

---

## 17. First 48 hours

- [ ] Monitor error log hourly on day 1
- [ ] Watch the first three real orders end-to-end
- [ ] Check Search Console for crawl errors
- [ ] Verify backups ran
- [ ] No plugin updates during this window

---

## Rollback plan

If checkout breaks: **restore the pre-launch backup + point DNS back**, do not debug live.
- Backup location: ______________________
- Restore command/process: ______________________
- Decision owner: ______________________

---

## Version baseline (fill in at sign-off)

| Component | Version | Date frozen |
|---|---|---|
| WordPress | | |
| PHP | | |
| WooCommerce | | |
| Elementor | | |
| Elementor Pro | | |
| Redux Framework | | |
| CMB2 | | |
| Contact Form 7 | | |
| TI WooCommerce Wishlist | | |
| Variation Swatches | | |
| WPC Smart Quick View | | |
| Side Cart WooCommerce | | |
| Max Mega Menu | | |
| One Click Demo Import | | |
| Luxrio (theme) | 1.0.1 (patched) | |
| Luxrio Core (plugin) | 1.0.1 (patched) | |

**Do not auto-update any row above.** Update one at a time, on staging, with a backup — then re-run `tools/wc-template-audit.py`.

---

## Sign-off

| Gate | Passed | By | Date |
|---|---|---|---|
| Boots without fatals | ☐ | | |
| Demo imported, icons render | ☐ | | |
| Test order — card | ☐ | | |
| Test order — mobile money | ☐ | | |
| Emails deliverable | ☐ | | |
| Performance acceptable | ☐ | | |
| Legal pages published | ☐ | | |
| **Approved for production** | ☐ | | |
