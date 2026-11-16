# Fix all — what I changed, and the two things left

You asked me to fix everything on the list. Here is what is now implemented, what you
have to press, and the two things no code can decide for you.

---

## One download, one button

**`queendor-fix-1.5.0.zip`** — in `client/pack/`, and inside the client pack.

1. Plugins → **Add New** → **Upload Plugin** → choose the zip → **Install Now** →
   **Activate Plugin**.
2. **Tools → Queen Dor's Fixes**.
3. Press **Run all fixes**.
4. Read the log it prints, then press **Scan for brackets**.

That is the whole instruction. The plugin does not run anything on activation; the
button is the trigger.

---

## What the plugin fixes

| # | Problem from the sweep | Fix |
|---|---|---|
| 1 | `/terms/` returns 404 although the page is published | **Clears the cache.** LiteSpeed is serving a cached 404 from when the page was deleted. It also flushes the object cache, WooCommerce and Elementor CSS caches |
| 2 | Contact live at `/contact-2/`, Privacy at `/privacy-policy-2/` | **Renames both pages** to `contact` and `privacy-policy`. Page IDs are unchanged, so the menu item and the home page links keep working |
| 3 | WooCommerce's "This is a sample page" policy published at `/refund_returns/` | **Trashes it** and points WooCommerce's refund-page setting at `/returns-exchanges/` |
| 4 | Bracketed placeholders on Terms, Privacy, Contact, FAQ, Shipping | **Fills every blank that has a real value on the site** — admin email, store address, store phone, today's date — plus the four judgement calls listed below |
| 5 | No page anywhere has a footer | **Prints the footer itself** on every page that has none, using the same markup and stylesheet as the pack |
| 6 | You cannot tell what is still unfinished | **Scan** lists every published page still holding `[SOMETHING]`, `{email}` or `GH₵ ____` |
| 7 | The front page is still Luxrio's demo | **Preview** names every demo block; **Clean** removes them and backs the layout up first; **Restore** undoes it |
| 8 | No symbols strip on the home page | **Add the symbols strip** appends it as an HTML widget, once |
| 9 | Menu still carries Cart and Checkout | **Trim the menu** removes both and adds Contact and FAQ's if missing |
| 11 | `nathan@lushviewhotel.net` on four pages | **Fill the blanks** replaces it with `info@queendorhouse.com` |
| 12 | FAQ collection answer left half-rewritten | Repaired, and the stray `_Local pickup_` underscores removed |
| 13 | Returns page had no cancellation clause | **Add the cancellation clause** appends one with the real email and phone |
| 10 | 13 duplicate pages | **Trash the duplicates** — never the front page, never a WooCommerce page, never the last copy of anything |

All six are safe to run twice. Nothing is deleted — the sample page goes to Trash.

---

## Four statements I had to assume

These are in a legal document, so check them. Each is one line, and the plugin will not
overwrite your edit afterwards.

| Assumption | What it now says | Change it if |
|---|---|---|
| Not VAT-registered | "We are not currently VAT-registered; no VAT is charged." | the business is VAT-registered |
| Five-day refund | "within **five working days**" | your window is different |
| Opening hours | Mon–Fri 9:00–17:00, Sat 10:00–14:00 | those are wrong |
| Collection | "Collection can be arranged in Accra — message us before you order" | you do not offer collection |

---

## New in 1.1.0 — the home page

"Run all fixes" now also trims the menu, adds the strip and trashes the duplicates.
**Cleaning the home page stays a separate button**, because it is the only fix that
changes the design:

1. **Preview the home page** — names the blocks that would go. Changes nothing.
2. **Clean the home page** — removes them, backs the layout up first.
3. Look at the page. Wrong? **Restore the home page**.

The demo sections are removed rather than replaced — putting the client's own sections
in their place is the Elementor template import, which is in the pack
(`content/symbols-strip-elementor.json`, `footer/`).

---

## Two things I cannot fix from here

### 1. The registration number and the business address

Every legal page needs them, and no code can know them. They stay as
`[REGISTRATION NUMBER]` and `[BUSINESS ADDRESS, ACCRA, GHANA]`, and the scan will name
them until they are filled.

Send me these five and I will write them into the pages and rebuild:

- registered business name (as on the certificate)
- registration number
- business address
- phone number
- email address you want public

If WooCommerce → Settings → General already holds the phone and store address, the
plugin uses those automatically and you only owe me the registration details.

### 2. The home page demo sections

Those are Elementor templates, not database rows — a plugin cannot edit them safely.
The replacements are already built and are in the pack:

- `content/symbols-strip.html` (or `symbols-strip-elementor.json` for the Elementor route)
- `footer/` — though the plugin now covers this

Until they go in, the front page still shows *Limited Edition · 20 Product* eight times
and one image served from `wordpress.vecurosoft.com`.

---

## After you press it — what should be true

| Check | Expected |
|---|---|
| `queendorfashionhouse.com/terms/` | the Terms page, fourteen sections, no `[DATE]`, no `[EMAIL ADDRESS]` |
| `/contact/` | the Contact page at the right URL |
| `/privacy-policy/` | the Privacy page at the right URL |
| `/refund_returns/` | 404 or trashed — not a sample policy |
| Any page, scrolled to the bottom | the teal footer with policy links |
| Tools → Queen Dor's Fixes → Scan | a short list, ideally only the registration number and the delivery prices |

Send me the scan output and I will finish what it lists.

---

## Order after this

1. This plugin — Run all fixes.
2. Send me the scan output + the five business details.
3. Symbols strip and the demo home sections (Elementor template import).
4. The nine product photographs.
5. Then the old-domain cleanup and the duplicate pages — **section 6 before section 5**
   of the cleanup plugin, and never section 3.
6. Then reply to Faith, request 2087034.
