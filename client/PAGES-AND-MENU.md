# Pages and menu — the 28 pages, sorted out

Two jobs, in this order: **publish the eight real pages**, then **trash the demo ones**, then **rebuild the menu**. Doing them out of order creates `about-2` permalinks that you then have to clean up by hand.

Work through it top to bottom. Should take about 20 minutes, including the clicking-about at the end.

---

## Step 0 — Publish the eight imported pages

If `Pages → All Pages` still shows them as **Scheduled**, they are 404s to the public. Fix all eight at once:

1. `Pages → All Pages`
2. Tick the checkbox in the **header row** (left of "Title") — this selects all pages
3. `Bulk actions` dropdown → **Edit** → **Apply**
4. In the panel that appears: `Status → Published`, `Date → 1 October 2026`
5. **Update**

Check: every one of the eight now reads **Published** in plain grey, not **Scheduled** in orange.

You should see: About · Contact · Shipping & Delivery · Returns & Exchanges · Privacy Policy · Size Guide · Symbols · Wholesale.

> If any page still says Scheduled after this, open it individually and press **Publish** in the top-right — that clears a stuck schedule.

---

## Step 1 — See what you actually have

`Pages → All Pages`, then set `Screen Options` (top right) → `Pagination` → **100**. You'll see all 28 on one screen.

Sort by **Title** (click the column header) so duplicates sit next to each other — `Cart` next to `Cart 2`, and so on. That is the whole trick: **any page with a `2` after its name is demo leftover.**

---

## Step 2 — The keep list

These must survive. Everything not on this list can go.

| Page | Why it stays |
|---|---|
| **Home 01** | Still the front page (`Settings → Reading`). Trash it and the site goes blank. |
| **Shop** | WooCommerce's shop archive. It's the one showing ten products. |
| **Cart** | WooCommerce cart. |
| **Checkout** | WooCommerce checkout. |
| **My Account** | WooCommerce account. |
| **Blog** | The posts page — WordPress needs a page to hold the blog index. |
| **About · Contact · Shipping & Delivery · Returns & Exchanges · Privacy Policy · Size Guide · Symbols · Wholesale** | The eight you just published. |

The theme's cleanup tool locks Home 01, Blog and the four WooCommerce pages automatically — their checkboxes are greyed out. If a page you *want* to trash is greyed out, it's one of those, and trashing it breaks the store.

---

## Step 3 — Trash the demo pages

**Either** `Tools → Queen Dor's Cleanup` → tick the listed demo pages → **Trash**,
**or** `Pages → All Pages` → hover the page → **Trash**.

The demo pages, by name:

| Trash | What it is |
|---|---|
| `Home 02` | Demo home layout, second variant |
| `Home 03` | Demo home layout, third variant |
| `Shop 2` | **The one your menu points at now.** Shows zero products. |
| `Cart 2` | Duplicate cart made by the demo import |
| `Checkout 2` | Duplicate checkout |
| `My Account 2` | Duplicate account page |
| `FAQ's` | Demo Q&A — nothing true in it |
| `404 Page` | A CMS page imitating the 404 screen; the theme already has a real 404 template |
| `Sample Page` | WordPress's default "hello" page, if present |
| `Refund and Returns Policy` | WooCommerce's auto-generated draft, replaced by `Returns & Exchanges` |
| `Terms and conditions` | Same, if the demo created one |

Anything else you don't recognise: check its permalink. If it's `something-2`, trash it.

### Do not empty the trash

Trashed pages sit there for 30 days and can be restored in two clicks (`Pages → Trash → Restore`). Emptying it removes that safety net for no benefit.

### If a new page has a `-2` permalink

Possible if you imported *before* trashing the demo `About`/`Contact`. Open the new page, and under the title click **Edit** next to the permalink, change `about-2` to `about`, **Update**. WordPress allows it the moment the old page is in the trash. Repeat for `contact-2`.

---

## Step 4 — Check WooCommerce still points at the right pages

`WooCommerce → Settings → Products`:

- **Shop page** → `Shop`
- **Terms and conditions page** → `Returns & Exchanges` (or leave blank)

Then `WooCommerce → Settings → Advanced` is not needed unless the four WooCommerce pages were altered.

Sanity check: visit `/shop/`. Ten products. If it says "no products found", you've trashed the wrong page — restore it from Trash.

---

## Step 5 — Rebuild the menu

This is the fix for "Shop opens an empty page."

1. `Appearance → Menus`
2. Select the menu that's currently in use (probably **Primary** or **Main Menu**) — the one with "Home", "Watch", "Pages", "Shop", "Cart", "Checkout" in it
3. **Delete these items** — hover each, click the red *Remove*:
   - `Home` (the dropdown parent, with Home 01 / Home 02 / Home 03 under it)
   - `Watch`
   - `Blog` (the dropdown parent)
   - `Pages` and everything nested under it: Page List 1, 2, 3, 4 and their children
   - `Shop`, `Cart`, `Checkout`, `My account`, `FAQ's`, `404 Page`

   Deleting an item from a menu does **not** delete the page. This menu is the only thing being rebuilt.
4. Now build it, in this order, using the **Add menu items** panel on the left:

| Label | Where it comes from |
|---|---|
| Home | **Custom Links** → URL `/` |
| Shop | **Shop** (under *Product Categories* or *Pages*) — the WooCommerce shop page |
| Symbols | **Pages → Symbols** |
| Wholesale | **Pages → Wholesale** |
| About | **Pages → About** |
| Contact | **Pages → Contact** |

5. Drag them into that order.
6. Under **Menu Settings**, tick **Primary Menu** (whatever the theme calls the main location — there may be two, e.g. `Main Menu` and `Mobile Menu`; tick both).
7. **Save Menu**.

### About "Custom Links" for Home

Use a custom link with `/` rather than the Home 01 page. A page-based link breaks the moment you change the front page; a URL doesn't.

---

## Step 6 — Verify, in this exact order

Click through all six menu items on the live site. Expected:

| Click | You should land on | You should see |
|---|---|---|
| Home | `/` | The site home — currently still demo copy, see `REPLACE-DEMO.md` §7 |
| Shop | `/shop/` | **Ten products**, ₵ prices, pagination to page 2 |
| Symbols | `/symbols/` | The Adinkra symbol index |
| Wholesale | `/wholesale/` | The trade page, with `________` blanks still to fill |
| About | `/about/` | The client story, blanks to fill |
| Contact | `/contact/` | The contact page |

If Symbols shows a blank area, the child theme's `[queendor_symbol_index]` shortcode is fine but the products' `pa_symbol` terms may not have been set yet — check one product's **Attributes** tab.

Then check the **footer** menu too (`Appearance → Menus → Manage Locations`) — it usually has its own copy of the same demo links, and it's a separate menu.

---

## Step 7 — What's still demo after this

Trashing pages and rebuilding the menu does **not** touch:

- The **home page content**, which is an Elementor layout full of demo copy and vendor-hosted images — `REPLACE-DEMO.md` §7
- The **logo**, still the vendor's LUXRIO wordmark — upload `brand/logo.svg` or the client's real file
- The **footer credit** — already handled in code by child theme 1.2.0
- **`Hello world!`** on the blog, and the `iwan1` username it publishes

Those are the next four jobs, and the first is the biggest.
