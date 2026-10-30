# Live site — fixes found on `blaharbenyah.com/dorcas`

Audited the running install on 2026-10-30. **Nothing is broken at the code level** — the patched theme is deployed and rendering. Everything below is configuration and demo content that wasn't finished.

| | Status |
|---|---|
| Theme version | ✅ **1.0.1** — the patched build, not the vendor zip |
| Front end / no fatals | ✅ renders, header, slider, product grid, side cart all work |
| Media import | ✅ 226 images imported locally (nothing depends on the vendor *for media files*) |
| WooCommerce templates | ✅ the six merged templates didn't error |
| Store open | ❌ **"Coming soon" mode is on** — `/shop/` shows "Great things are on the horizon" |
| Vendor references | ❌ ~30 image URLs and 3 CTA links still point at `wordpress.vecurosoft.com` |
| Indexing | ❌ nothing stops Google indexing `/dorcas/` |

---

## P0 — fix before the client opens it

### 1. Turn off "Coming soon"

`WooCommerce → Settings → Site visibility` → select **Live** → Save.

Right now `https://www.blaharbenyah.com/dorcas/shop/` returns WooCommerce's placeholder:

> *Great things are on the horizon. Something big is brewing! Our store is in the works and will be launching soon!*

Anyone who clicks a product category hits that. The home page products still show (they're cached), which makes it worse — it looks like a broken shop rather than a closed one.

### 2. The menu's "Shop" link goes to an empty page

The demo import created duplicates because the WooCommerce pages already existed:

| Menu links to | Reality |
|---|---|
| `/shop-2/` | empty page — title only, **zero products** |
| `/shop/` | the real WooCommerce shop page (currently coming-soon) |
| `/cart-2/` `/checkout-2/` `/my-account-2/` | demo duplicates |

**Fix:** `Pages` → move `Shop 2`, `Cart 2`, `Checkout 2`, `My Account 2` to Trash. Then `Appearance → Menus` → remove the dead items and point Shop / Cart / Checkout / My account at `/shop/`, `/cart/`, `/checkout/`, `/my-account/`.

Then `WooCommerce → Settings → Advanced` → confirm the four page dropdowns point at the real pages, not the trashed ones.

### 3. Kill every `vecurosoft` reference

The demo import rewrote most content but missed a chunk. These are live right now:

- Hero images: `https://wordpress.vecurosoft.com/luxrio/wp-content/uploads/2024/12/hero-outside-1-1.png` (and ~25 more)
- Instagram strip: all six `inssta-1-*.jpg`
- Newsletter icon: `vs-icon-subscribe-1.svg`
- Buttons: **"Shop Now"** and **"contact us"** in the quote section link to `wordpress.vecurosoft.com/luxrio/shop/`
- Menu item **"404 Page"** → `wordpress.vecurosoft.com/luxrio/404page`

Two reasons this matters more than it looks: the vendor can shut that server down and your client's hero images disappear, and those buttons **take the client off the review site onto someone else's demo**.

**The media files are already local** — I checked two: `hero-slide-1-1-1.png` is media ID 215 and `inssta-1-2.jpg` is ID 653, both at `www.blaharbenyah.com/dorcas/wp-content/uploads/…`. So only the *URLs* in the content are wrong, which means one replace fixes both the images and the links.

**Fix — Better Search Replace** (`Tools → Better Search Replace`):

| Field | Value |
|---|---|
| Search for | `wordpress.vecurosoft.com/luxrio` |
| Replace with | `www.blaharbenyah.com/dorcas` |
| Tables | all (tick "Select tables", leave all checked) |
| Run as dry run | **yes, first** |

Check the dry-run count — expect several hundred cells. Then untick dry run and Run.

After it finishes, in this order:
1. `Elementor → Tools → Regenerate CSS & Data`
2. Purge every cache (`LiteSpeed Cache → Toolbox → Purge All`, plus your browser)
3. Reload the home page — the Instagram strip and newsletter icon should now load from your own domain
4. Run Better Search Replace as a **dry run** again with search `vecurosoft`, replace blank — the count must be **0**

Leaving the protocol off both sides is deliberate: it catches `http://` and `https://` variants in one pass.

> Don't do this with raw SQL. `_elementor_data` is serialized JSON and a plain `UPDATE … REPLACE()` corrupts it — you get a blank page with no error message. Better Search Replace handles serialized data properly.

---

## P1 — before you call it client-ready

### 4. Site title and tagline

`Settings → General`: Title **Dorcas** (it's `My WordPress` right now — that's the browser tab, the OG tag, and the JSON-LD `Organization` name), tagline in place of `Blank`.

### 5. Currency

Prices render as `$30.00`. `WooCommerce → Settings → General` → Country **Ghana**, currency **GHS**. Then the Ghana pass from the build sheet: shipping zones (Accra / Other / International), tax decision, payment gateway in test mode.

### 6. Demo content

Nav currently reads: Home 01 / Home 02 / Home 03 · Page List 1–4 · 404 Page · and blog posts dated November 2024 by author `iwan1`. Delete the extra home pages and the Page List filler, keep one, and rebuild the menu around real sections.

### 7. Nothing is stopping Google from indexing it

Two things worth understanding:

- **`robots.txt` only counts at the domain root.** `/dorcas/robots.txt` returns your 404 page, and it doesn't matter — crawlers never read it. The file that counts is `https://blaharbenyah.com/robots.txt`, which currently says `Allow: /` and lists a sitemap.
- So the only effective control is the **meta robots tag**: `Settings → Reading` → tick **"Discourage search engines from indexing this site"**. That emits `<meta name="robots" content="noindex">` on every page of `/dorcas/`.
- Optionally also add `Disallow: /dorcas/` to the parent site's `robots.txt` — belt and braces, and it stops the parent's sitemap plugin from crawling the demo store.

Note it's a *discouragement*, not access control. Which is why:

### 8. It's open to the world right now

No password. If you're sending this link to one client, put the password on: `cPanel → Files → Directory Privacy` → the `dorcas` document root → password protect, then create the client's user. Otherwise you've published a half-finished demo store on your own domain.

### 9. Your login name is public

`/dorcas/author/iwan1/` resolves, and `iwan1` appears in the JSON-LD of every page. That's a real username, and `wp-login.php` is publicly reachable — so an attacker has half the credentials for free.

Cheap mitigations, in order of effort:
- `Users → Profile` → set **Display name** to something that isn't the login, and set **Nickname** to match — the author URL follows the nickname in current WordPress.
- Install a login limiter (Limit Login Attempts Reloaded or Wordfence).
- At go-live, don't carry `iwan1` over as the admin login — create a fresh one and demote this account.

---

## P2 — worth 20 minutes

**`/dorcas/wp-sitemap.xml` and `/dorcas/sitemap.xml` both return HTTP 500.** Core sitemaps shouldn't 500. Likely a plugin conflict — All in One SEO is active and also builds sitemaps. Check `wp-content/debug.log` or the cPanel error log for the fatal. It's not launch-blocking on a noindex review site, but a 500 nobody explains has a habit of becoming the thing that breaks on launch day.

**All in One SEO is installed** — it wasn't on the plugin list, so either the theme bundled it or the demo import pulled it. It's fine to keep, but make sure it isn't overriding the `noindex` you set in step 7. `All in One SEO → Search Appearance` should inherit the site's visibility setting, not force indexable.

**`www` vs non-`www`.** Site URLs use `www.blaharbenyah.com`, but `blaharbenyah.com` also serves. Pick one and redirect the other — two hostnames serving the same pages splits analytics and crawl budget. Once the real domain is involved this gets messier, so decide now.

---

## Where this leaves the launch

The site is now in a **subdirectory of an existing domain**, not the client's own domain. That's fine for review, but it means go-live is still a migration, not a switch:

1. Back up.
2. `Better Search Replace`: `www.blaharbenyah.com/dorcas` → the new domain, all tables.
3. Point the new domain at a document root, run AutoSSL.
4. `Settings → General` — both URLs show the new domain with `https://`.
5. Regenerate Elementor CSS, purge all caches.
6. Untick "Discourage search engines", remove the directory password.
7. Walk the checkout: add to cart → order → email received → order in admin.

Which is exactly the sequence in `docs/GREENGEEKS-DEPLOY.md` §17 — the subdirectory just changed the string you search for.
