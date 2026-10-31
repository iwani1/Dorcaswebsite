# The home page export, repaired

**File:** `elementor-1628-home-page-fixed.json` (37 KB)
**Source:** `elementor-1628-2026-10-31.json`, exported from page 1628 "home page".

---

## Why the page had empty sections

I read the widget sources in `wp-content/plugins/luxrio-core/addons/widgets/`
rather than guessing, and each empty section has a named cause:

| Section | Setting in your export | What it does |
|---|---|---|
| Product slider | `product_cats: ["luxry-watch"]` | the demo's watch category. `WP_Query` gets a slug with no term → **zero rows** |
| "best selling" grid | `product_filter_by: "2"` + `product_cats: ["classic","modern"]` | two more demo slugs. The `product_attributes` you also set (`top-rated`, `featured`) were being **ignored**, because the widget only reads them when the filter is `"1"` |
| "CUSTOM Jewelry" tabs | all five tabs → `luxrio_tab_builder_title_option: 906 / 920 / 920 / 920 / 920` | that control renders an Elementor **template by post ID**. Four tabs share 920, so one template prints four times — the same three tiles, twelve times over, with the dead links baked into the template |

So the page was not failing to load products. It was asking for products that
have never existed on this site.

## What the fixed file changes — 15 edits

| # | Where | Was | Now |
|---|---|---|---|
| 1 | product slider `7382287d` | `["luxry-watch"]` | empty → **all products**, newest first |
| 2 | product grid `235a6a14` | filter `"2"`, cats `classic/modern` | filter `"1"`, attributes `["recent-items"]` → **renders your real catalogue** |
| 3 | banner 1 `60568b76` | no colours set (demo defaults) | star gold, title ink, price teal |
| 4 | banner 2 `4a932dfd` | star `#000000`, title `#021210`, price `#3C3B3B` | `#C8AC77`, `#211F1C`, `#0B4B4C` |
| 5 | banner 2 link | `/shop-2/` — a **demo duplicate page** | `/shop/` |
| 6 | banner 2 price | `GHC300.00` | `GHC 300.00` |
| 7 | Instagram strip | 5 slides, **the same photo five times**, all → `instagram.com/` | 3 slides, three different photos you already uploaded, all → **her profile** |
| 8 | Instagram `slide_to_show` | 5 | 3, to match |
| 9 | "Our work" copy | `delivered worldwid` | `delivered worldwide` |
| 10 | one empty text-editor widget `529dcbd5` | `{"editor": ""}` | removed |

Nothing else moved. All 40 elements keep their IDs, `page_settings` is
byte-identical, and the schema version stays `0.4`.

**Why `recent-items` and not `best-selling`:** the widget's `best-selling` mode
orders by the `total_sales` meta key. With no orders yet that column is all zeros,
which renders an arbitrary nine products and looks broken to you later. Switch it
to `best-selling` once there are real orders and it will mean something.

## How to import

1. **Templates → Saved Templates → Import Templates** → upload
   `elementor-1628-home-page-fixed.json`. It arrives as a template called
   *home page*.
2. Open the page → **Edit with Elementor** → click the folder icon →
   **My Templates** → insert *home page*.
3. Delete the old section stack above/below it, then **Update**.
4. Purge LiteSpeed. The old page is still in revisions if you want it back.

Do it the other way round — import, look, then delete — because the template
lands beside the page, not on it.

---

## What I could not fix from a JSON file

Three things, and they are the reason the page will still not be finished after
the import:

**1. The "CUSTOM Jewelry" tiles.** They come from Elementor templates 906 and 920,
which live in your database, not in the export. To fix them properly you need five
templates — one per tab — each containing a product query for that category. That
is build work, not file surgery. **Announce this rather than half-fix it:** the
alternative is to swap that widget for `luxrioproductcategory`, which loops real
categories with images and no templates — but it looks different, and you chose
the current look, so I did not make that call for you.

**2. Fourteen assets still on `wordpress.vecurosoft.com`.** Three section
backgrounds (`2.jpg`, `3.jpg`, `4.jpg`), the category background, two banner
backgrounds, five decorative SVGs, and the hero background. I cannot fetch them —
they are on a host this workspace cannot reach. **If that demo site goes down,
your sections lose their backgrounds and the shapes disappear.** Download them
once and re-upload to your own library; it is twenty minutes and it removes a
dependency you do not control.

**3. Five Instagram photos.** The strip now shows three different photos instead
of one photo three times over — an improvement, not a fix. Real Instagram posts
are the only correct content there.

## One more: the menu (theme 1.7.2)

You said trim it. `inc/menu-trim.php` drops items whose label or URL says *cart*
or *checkout* from the front-end menu, leaving Jewelry House / Wholesale / FAQ's /
Contact / Shop / My account on one line. Nothing is deleted from the menu itself —
the stored menu is untouched, and the items return if the theme is rolled back.

Turn it off: `add_filter( 'queendor_trim_header_menu', '__return_false' );`
Keep Cart but drop Checkout: filter `queendor_trim_menu_needles` to
`array( 'checkout' )`.
