# Replace the demo with the client's site

Eight steps. Steps 1–4 clear the demo; 5–8 put Queen Dor's in its place.

**Do them in this order.** The page import has to come after the cleanup, or WordPress creates `about-2` next to the demo's `about` and you end up with two of everything.

---

## 1. Upload the cleanup tool

`Plugins → Add New → Upload Plugin` → `queendor-cleanup-1.0.0.zip` → **Install** → **Activate**.

Then `Tools → Queen Dor's Cleanup`.

It trashes rather than deletes — everything sits in the Trash for 30 days and can be restored from `Pages` / `Products`. Nothing happens until you press a button.

## 2. Trash the demo products

The tool counts two things: products with a `QD-` SKU (yours — 10) and everything else (the demo — 31).

Press **Trash 31 demo products**.

> It refuses to run if it can't find any `QD-` products, because in that state "everything else" means your entire catalogue. If you see that warning, the CSV import hasn't happened — do `IMPORT-GUIDE.md` first.

Then check `Products → All Products`: ten products, all with images missing. That's the correct state.

## 3. Trash the demo posts

Same screen, section 2. The theme ships blog posts dated November–December 2024 by author `iwan1`. Press the button.

## 4. Trash the demo pages — tick them yourself

Section 3 lists every page with a checkbox. The front page, posts page and all four WooCommerce pages are locked and cannot be selected, because trashing those takes the shop apart.

Tick these, and only these:

```
Home 02
Home 03
Shop 2
Cart 2
Checkout 2
My Account 2
FAQ's
Blog
About          ← keep the slug free; step 5 recreates it
Contact        ← same
404 Page
```

**Do not tick `Home 01`** — it is almost certainly still the front page. Leave the theme's Elementor home layout in place; it gets rewritten section by section in step 7.

## 5. Import the client pages

`Tools → Import → WordPress` → install the importer if prompted → **Choose file** → `queendor-pages.wxr` → **Upload file and import**.

On the next screen, **assign posts to an existing user** (yourself), and leave *"Download and import file attachments"* unticked — there are none.

Expect **8 pages**:

| Page | Slug |
|---|---|
| About | `/about/` |
| Contact | `/contact/` |
| Shipping & Delivery | `/shipping-delivery/` |
| Returns & Exchanges | `/returns-exchanges/` |
| Privacy Policy | `/privacy-policy/` |
| Size Guide | `/size-guide/` — renders `[queendor_ring_guide]` |
| Symbols | `/symbols/` — renders `[queendor_symbol_index]` |
| Wholesale | `/wholesale/` |

### If the pages land as "Scheduled"

Older copies of `queendor-pages.wxr` stamped a fixed publishing time in the file. If the file date is in the future when WordPress reads it, every page is filed as **Scheduled** instead of Published — and a scheduled page returns **404** to visitors until the time passes and something triggers WP-Cron.

The current file in the pack cannot do this: it stamps a time five minutes *before* the build. But if pages on your install already show as **Scheduled** in `Pages → All Pages`, fix all of them at once:

1. `Pages → All Pages`
2. Tick the checkbox in the header row to select every page
3. `Bulk actions` → **Edit** → `Apply`
4. `Status: Published`, `Date: 1 October 2026` (any past date)
5. `Update`

Confirm each page now reads **Published** in grey, not **Scheduled**.

**Repeat the import with `queendor-pages.wxr` a second time and you get duplicates** — WordPress will happily create `/about-2/`. Import once.

## 6. Build the menu

`Appearance → Menus` → edit the **Primary Menu** that the demo left behind. Delete every item and add:

```
Home          → Home
Shop          → Shop page (/shop/)
Symbols       → Symbols (/symbols/)
Wholesale     → Wholesale (/wholesale/)
About         → About (/about/)
Contact       → Contact (/contact/)
```

Also remove the `404 Page` item — it currently points at the theme vendor's demo site.

Then check the footer menu and the mobile menu assignment (`Appearance → Menus → Manage Locations`).

**Check the header cart and account links.** The demo points them at `/cart-2/`, `/checkout-2/` and `/my-account-2/`. Every purchase now runs through these, and a customer who lands on a trashed demo page stops there. Fix them in the theme's header options or the menu, and confirm `WooCommerce → Settings → Advanced` assigns Cart, Checkout, My account and Shop to the real pages.

---

# Homepage copy

The home page is an Elementor template — duplicating and editing it is a hundred times faster than starting from scratch. Work top to bottom, replacing section content, and delete any section you don't want rather than leaving it empty.

### The slider widget — the fields you'll actually see

The hero is a **theme widget**, not an Elementor Pro slider. Expand **Slider Content** and each slide opens six fields — two of them misspelled by the vendor, so don't go looking for the correctly-spelled version:

| Field | What it holds in the demo |
|---|---|
| **Slider Image** | The cut-out product on the right — the watch. Transparent PNG; no background of its own. |
| **Subttile** *[sic]* | Small line above the headline: "EXTRA 20% OFF" |
| **Title** | "STYLISH WRIST WATCH" |
| **Discription** *[sic]* | "STARTING AT $150.00" |
| **Button Text** | "SHOP NOW" |
| **Button Url** | Where the button goes — the demo points at the vendor's shop |

- **Add a slide:** `+ Add Item` at the bottom of Slider Content.
- **Reorder:** drag the handle at the left of each slide.
- **Remove:** the bin icon on the slide row.
- **Dots / Autoplay:** under **Slider Settings**. With more than one slide, turn Dots on — otherwise there's no cue that others exist.
- **The dark background** is *not* in this widget. Click the **section** (not the widget) → Style → Background. That image is currently hotlinked from `wordpress.vecurosoft.com`.

Each slide's Title renders as an `<h1>`, so three slides is three `<h1>`s on one page. One slide is the cleaner choice.

### 1. Hero

> **Jewellery that already means something**
> Adinkra pieces, hand-finished in Accra. Retail and wholesale, worldwide.
>
> [ Shop the collection ] → `/shop/`  ·  [ Our symbols ] → `/symbols/`

Image: one strong model shot, or the Five Symbols necklace on a plain background.

### 2. Category tiles

Five tiles, one per category, each linking to its product category:

`Necklaces` · `Earrings` · `Bracelets` · `Rings` · `Sets & Gifts`

### 3. The symbol strip

A quiet band, no images:

> **Gye Nyame** — Except for God  ·  **Sankofa** — Go back and fetch it  ·  **Duafe** — The wooden comb  ·  **Akoma** — The heart
>
> [ What the symbols mean ] → `/symbols/`

### 4. Best sellers

Use a **Featured products** block — the CSV already marks three pieces as featured (Sankofa Pendant Necklace, Five Symbols Layered Necklace, Adinkrahene Stacking Ring Set). It populates itself.

### 5. Their story

> We make Adinkra jewellery in Accra, in small runs, and we have not invented the meanings —
> Gye Nyame for what holds everything together, Sankofa for what you carry with you.
> We just make them wearable.
>
> [ Read more ] → `/about/`

### 6. Wholesale band

> **Stock Queen Dor's**
> Trade prices, minimum six per style, retail-ready and boxed.
>
> [ Wholesale enquiries ] → `/wholesale/`

### 7. Newsletter

> **New pieces, occasionally.**
> A message when something new is finished — nothing else.

### 8. Delete the rest

The demo's newsletter block, Instagram strip and quote sections are full of images hotlinked from the theme vendor's server. **Delete those sections rather than editing them** — one of them is still loading images from `wordpress.vecurosoft.com`, and the Instagram strip shows another brand's products.

---

## 7. Fill the blanks

Every `________` in the imported pages is a real decision. Search the pages for underscores:

| Page | What's missing |
|---|---|
| Contact | phone, email, studio address, opening hours |
| Shipping & Delivery | Accra fee, regional fee, free-delivery threshold, made-to-order lead time |
| Wholesale | minimum order, lead time, terms, wholesale email |
| Privacy Policy | the contact address for data requests |

And outside the pages:

- [ ] **Product prices** — all ten are placeholders (`IMPORT-GUIDE.md` §5)
- [ ] **Product photographs** — every product currently shows the WooCommerce placeholder
- [ ] **Materials** — gold-plated vs brass is assumed per product, and drives the care note shown on that product page
- [ ] **Ring sizes** — L, N, P, R, T, V is a guess; set their real range
- [ ] **Logo** — the Luxrio wordmark is still in the header; see §9
- [ ] **Footer** — registration number and address; the vendor credit is already replaced in code (§9)

## 8. Then deactivate the cleanup tool

`Plugins → Deactivate → Delete`. It has done its job, and a tool that can trash the catalogue should not sit active on a live site.

## 9. The name

Child theme **1.2.0** rewrites the vendor's name automatically — nothing to click:

- The footer credit the demo shipped ("Copyright © … Luxrio. All Rights Reserved by Vecuro") is replaced with `© 2026 Queen Dor's Fashion House. All rights reserved.` — the stored option is rewritten on read, in code, so it survives an options reset.
- If the site name is still the installer's `My WordPress`, every title, schema block and order email now says **Queen Dor's Fashion House** instead. Once you set a real name in `Settings → General`, the filter stops touching it — it only replaces known placeholders.
- The tagline `Blank` becomes *Elegant jewellery for every occasion*.

### What still needs you

**The logo.** The header is showing the demo's `logo.svg`, which is the word **LUXRIO** in a circle — by far the most visible thing left. Two options in the pack:

- `brand/logo.svg` and `brand/logo-white.svg` — clean temporary wordmarks in the client's name. Better than the vendor's mark, not a substitute for their actual logo.
- Or upload their real logo: `Theme Options → Logo` → header logo, and the white version for the footer/dark sections.

**The footer text**, if you want different wording: `Theme Options → Footer → Copyright Text`. The demo value is a Redux option — edit it once and save, and the rewritten default stops being used.

**The theme name in the admin.** `Appearance → Themes` will still list the parent as "Luxrio". That is display-only, comes from the vendor theme's own header, and is never seen by a customer. Renaming it means re-uploading the parent theme — worth doing only if you're re-uploading that anyway.

### ⚠️ Do not run a database search-replace for "Luxrio"

MySQL string comparison is case-**insensitive** on the usual collations, so `Tools → Better Search Replace` with `Luxrio` → `Queen Dor's` also matches **`luxrio`** inside `/wp-content/themes/luxrio/…` in Elementor data and any custom CSS. That rewrites the asset paths and the site loads with no styling, no icons and a broken layout — and the change is inside serialized data, so it's painful to undo.

If a stray "Luxrio" turns up in page content, edit that page. The coded strings are already handled by the child theme.

---

## What should be true when this is finished

- `Products` shows exactly ten, all Queen Dor's
- `Pages` shows the client's pages plus the four WooCommerce pages — no `Home 02`, no `-2` duplicates, no `FAQ's` from the demo
- The menu has six items and none of them 404
- `/symbols/` lists eleven symbols with meanings; `/size-guide/` renders the chart
- The homepage says "Adinkra" and the client's name, not "High Class Jewellery"
