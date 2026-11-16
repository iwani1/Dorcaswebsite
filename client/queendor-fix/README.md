# Queen Dor's — Launch Fixes (plugin, v1.2.0)

Five fixes that cannot be done from a WXR import or an HTML widget, because each one
writes to the database: a cached 404, two page slugs, a page status, a WooCommerce
option, and page content.

**Install:** Plugins → Add New → Upload Plugin → `queendor-fix-1.0.0.zip` → Install →
**Activate**. Then **Tools → Queen Dor's Fixes** and press **Run all fixes**.

Nothing runs on activation. Every fix is a button, each is safe to press twice, and
nothing is deleted — the sample policy is trashed.

---

## The five buttons

| Button | What it does | Why it can't be done by hand faster |
|---|---|---|
| **Clear the cache** | LiteSpeed purge all (also WP Rocket, W3TC, WP Super Cache, object cache, Elementor CSS) | This is the only reason `/terms/` still shows a 404 while the page is published |
| **Fix the two URLs** | `/contact-2/` → `/contact/`, `/privacy-policy-2/` → `/privacy-policy/` | Renaming keeps the page ID, so the menu item keeps working and no link needs editing |
| **Remove the sample policy** | Trashes the "This is a sample page" refund policy, points WooCommerce's refund page setting at `/returns-exchanges/` | A page status and an option row |
| **Fill the blanks** | Email, store address, opening hours, today's date, "five working days", the VAT sentence, the collection answer | Forty-odd string replacements across six pages |
| **Scan for brackets** | Lists every published page that still contains `[SOMETHING]`, `{email}` or `GH₵ ____` | The check you run before the reviewer does |
| **Preview the home page** | Counts the demo blocks on the front page and names what would go. Changes nothing | You cannot see the Elementor tree from the outside |
| **Clean the home page** | Removes every Elementor block still carrying demo copy — *Limited Edition*, *Diamond Pendant*, *Luna Rosa*, `vecurosoft`. Backs the layout up first, drops columns and sections that empty out, refuses if it would empty the page | Elementor's layout is a JSON blob in post meta; nothing else can edit it safely |
| **Restore the home page** | Puts the backed-up layout back | Your undo |
| **Add the symbols strip** | Appends the Adinkra strip to the front page as an HTML widget, once | Same JSON blob |
| **Trim the menu** | Removes Cart and Checkout, adds Contact and FAQ's if they are missing | Menu items are posts |
| **Add the cancellation clause** | Appends the cancellation policy and contact details to `/returns-exchanges/` — the gap Paystack named |
| **Trash the duplicates** | Trashes the `-2` / `-3` copies, never the front page or anything WooCommerce is assigned to, never a page with no original left | 13 duplicate pages |

**Run all fixes** is the five content fixes, the menu, the strip and the duplicates, then a second cache purge and the scan. **It does not clean the home page** — that one is a separate button, because it is the only fix that changes the design.

---

## The footer

While the plugin is active it prints the Queen Dor's footer on every page that would
otherwise have none — the theme's footer builder is still unassigned, so every page
currently ends in blank space. The markup is the same as `client/footer/` and it is
styled by `assets/css/queendor-footer.css` from the child theme.

**When you assign the footer in Theme Options → Footer, the plugin stops printing its
own** (it checks for `qd-footer` in the page before injecting) and you can delete the
plugin.

---

## The home page

The front page is stored as Elementor JSON in `_elementor_data`. "Clean" walks the tree,
drops any element whose settings contain a demo string, and then drops columns and
sections that have lost every child — otherwise the page becomes a stack of empty bands.
Before it writes anything it copies the original JSON into an option, so **Restore** is
always available.

It refuses to save if fewer than one top-level section would remain, and it clears
Elementor's generated CSS afterwards. If the page looks wrong, press **Restore the home
page** — that is what it is for.

---

## What it deliberately does not do

- **Registration number, business address, delivery prices.** No value exists anywhere
  in WordPress to copy, and inventing them would put a false statement in a legal
  document. They stay as brackets and the scan names them.
- **Rebuild the home page.** It removes what is demo; putting the client's sections in
  their place is the Elementor template import (`client/content/`).
- **Photographs.** Nine products still need files.
- **Anything destructive.** Trash, never delete; no `$wpdb` writes; no SQL.

---

## What "fill the blanks" will put on the site

Read this before pressing it, because these are statements attributed to the client:

| Placeholder | Filled with | Source |
|---|---|---|
| `[EMAIL ADDRESS]`, `{email address}`, `________` after "Write to" / "Email:", and **`nathan@lushviewhotel.net` everywhere** | `info@queendorhouse.com` | the client's own Contact page |
| `[PHONE NUMBER]`, `Phone / WhatsApp: _______` | `+233 54 636 9625` | the client's own Contact page |
| `Studio: _______`, `[BUSINESS ADDRESS, ACCRA, GHANA]` | `Haatso, Accra, Ghana` | the client's own Contact page |
| `[REGISTERED BUSINESS NAME]` | `Queen Dor's Fashion House` | the client's trading name — **confirm it matches the certificate** |
| `Opening hours: _______` | Monday–Friday 9:00–17:00; Saturday 10:00–14:00 | **assumed** — change if wrong |
| `[DATE]` | today's date | system |
| `[NUMBER] working days` | "five working days" | **assumed** — change if wrong |
| `[Delete whichever does not apply: VAT …]` | "We are not currently VAT-registered; no VAT is charged." | **assumed** — change if the business is VAT-registered |
| `[Choose one: …]` (FAQ, collection) | "Collection can be arranged in Accra — message us before you order…" | **assumed** — change if collection is not offered |

The four assumptions are marked. If any is wrong, edit that line before the pages go
in front of Paystack — the plugin will not overwrite it a second time, because the
placeholder is gone after the first run.

---

## Removing it

Deactivate and delete. The page renames, the trashed sample page and the filled text
are permanent — the plugin only performed them. If you want the footer from the theme
instead, assign it first, then delete.
