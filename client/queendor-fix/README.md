# Queen Dor's — Launch Fixes (plugin, v1.0.0)

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

**Run all fixes** is the first four, then a second cache purge, then the scan.

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

## What it deliberately does not do

- **Registration number, business address, delivery prices.** No value exists anywhere
  in WordPress to copy, and inventing them would put a false statement in a legal
  document. They stay as brackets and the scan names them.
- **The home page demo sections.** Those are Elementor templates, not database rows —
  import `client/content/` templates instead.
- **Photographs.** Nine products still need files.
- **Anything destructive.** Trash, never delete; no `$wpdb` writes; no SQL.

---

## What "fill the blanks" will put on the site

Read this before pressing it, because these are statements attributed to the client:

| Placeholder | Filled with | Source |
|---|---|---|
| `[EMAIL ADDRESS]`, `{email address}`, `________` after "Write to" / "Email:" | the site's admin email | Settings → General |
| `[PHONE NUMBER]`, `Phone / WhatsApp: _______` | WooCommerce store phone | WooCommerce → Settings → General — **left alone if empty** |
| `Studio: _______` | WooCommerce store address | WooCommerce → Settings → General — **left alone if empty** |
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
