# Getting the files onto the website

Most of what is in the pack is **not uploaded** — it is pasted into pages that
already exist. Only four items are actual files the site accepts: two zips, one WXR,
two Elementor templates.

Look at this table first. It tells you, for every file, which of the four methods it
needs.

| File in the pack | Ends up as | Method |
|---|---|---|
| `luxrio-child-1.8.8.zip` | the theme | **A — upload a zip** |
| `queendor-cleanup-1.1.0.zip` | Tools → Queen Dor's Cleanup | **A — upload a zip** |
| `queendor-paystack-pages.wxr` | 6 draft pages | **B — import a WXR** |
| `footer/queendor-footer-elementor.json` | a saved template | **C — import an Elementor template** |
| `content/symbols-strip-elementor.json` | a saved template | **C — import an Elementor template** |
| `footer/queendor-footer.html` | inside the footer | **D — paste into a widget** |
| `content/symbols-strip.html` | the home page band | **D — paste into a widget** |
| `content/faqs.html` | `/faqs/` | **D — paste into a widget** |
| `paystack-reply/reviews-section.html` | home page (later) | **D — paste into a widget** |
| `paystack-reply/cancellation-policy.md` | `/returns-exchanges/` + `/terms/` | **D — paste into the editor** |
| `content/product-descriptions.md` | 10 products | **D — paste into product fields** |
| `paystack-pages/*.md` | the policy pages | **D — paste** (or use the WXR) |
| `paystack-reply/email-reply.md`, `stock-list.*` | **not the website** — the email to Paystack | attach / paste |

---

## A — Uploading a zip (theme and plugin)

### A1. Theme, from WordPress

1. **Appearance → Themes → Add New** (button at the top).
2. **Upload Theme → Choose File** → `luxrio-child-1.8.8.zip` → **Install Now**.
3. If WordPress says *"Destination folder already exists"* — it will, the theme is
   already installed — use **method A2** instead. Do not delete the active theme.

### A2. Theme, from cPanel (the reliable way)

1. **cPanel → File Manager.**
2. Navigate to
   `/home/lushview/public_html/blaharbenyah.com/dorcas/wp-content/themes/`
3. **Upload** → choose `luxrio-child-1.8.8.zip` → wait for 100% → **Go Back**.
4. Right-click the uploaded zip → **Extract** → path stays `/…/themes/` → **Extract
   Files**.
5. It will ask whether to overwrite — **yes, overwrite all**.
6. Delete the zip afterwards.
7. WordPress admin → **Appearance → Themes** → confirm *Queen Dor's Child* shows
   **1.8.8** and is active.

> If the site white-screens after this, rename the folder `luxrio-child` to
> `luxrio-child-off`. WordPress falls back to the parent theme and the site returns
> while you find out what broke.

### A3. Plugin, from WordPress

1. **Plugins → Add New → Upload Plugin** (button at the top).
2. **Choose File** → `queendor-cleanup-1.1.0.zip` → **Install Now**.
3. **Activate Plugin**.
4. It appears under **Tools → Queen Dor's Cleanup**.

That one is uploaded, used, then **deleted** — see `STEP-BY-STEP.md` Part 7.

---

## B — Importing the pages (WXR)

1. **Tools → Import.**
2. Find **WordPress** in the list → **Install Now** (only the first time) → **Run
   Importer**.
3. **Choose File** → `queendor-paystack-pages.wxr` → **Upload file and import**.
4. On the next screen: *Assign posts to an existing user* → pick your own account.
   Leave **Download and import file attachments** unticked — there are none.
5. **Submit.**

You now have six **drafts** under **Pages**: Terms and Conditions, Returns and
Refunds, Shipping & Delivery, Privacy Policy, Contact, About Us.

Three of them will have `-2` in the slug because those pages already exist. That is
expected — the workflow for those three is in `STEP-BY-STEP.md` §5c: copy the draft's
content over the published page, then trash the draft.

Nothing imported is published. A draft cannot be seen by a customer or a reviewer.

---

## C — Importing an Elementor template (footer, symbols strip)

1. In the admin sidebar: **Templates → Saved Templates.** (On some versions it is
   **Elementor → Templates**.)
2. At the top, **Import Templates**.
3. **Choose File** → `footer/queendor-footer-elementor.json` → **Import**.
4. Repeat for `content/symbols-strip-elementor.json`.
5. Both now appear in the list: **Queen Dor's Footer** and **Queen Dor's — Symbols
   Strip**.

Importing a template does **not** put it on the site. The footer still has to be
assigned (Theme Options → Footer → trigger *Footer Builder* → select it), and the
symbols strip still has to be dropped onto the home page (**C2** below).

### C2. Putting a template on a page

1. **Pages → [the page] → Edit with Elementor.**
2. Bottom-left, the **folder icon** (Add Template).
3. **My Templates** tab → find the template → **Insert**.
4. **Update.**

That folder icon is also how the home-page section gets inserted if you would rather
not paste HTML.

---

## D — Pasting into a page

This is the method for everything else, and it is always the same three moves:
**open the page → add an HTML widget → paste → Update.**

### D1. Pasting HTML (FAQ, symbols strip, reviews)

1. **Pages → [page] → Edit with Elementor.**
2. In the left panel, search **`HTML`** → drag the **HTML** widget onto the canvas.
3. In the right-hand panel, the **HTML Code** box → paste the entire file, starting
   with `<!--` and ending with `</div>`.
4. **Update.**
5. Open the page in a normal browser tab and check it renders. Elementor's canvas
   does not always show everything the front end does.

**Deleting the old content first:** for `/faqs/`, delete the demo accordion widget
before adding the HTML widget, or you will have both.

### D2. Pasting text (cancellation clause, policy pages)

1. **Pages → [page] → Edit with Elementor.**
2. Either edit the existing **Text Editor** widget, or drag a new one in.
3. Paste the text. Keep the headings real headings — select a line and set it to
   **H2**/**H3** in the toolbar.
4. **Update.**

The `.md` files are plain text with `##` heading marks. When pasting into WordPress,
either paste the text and format the headings by hand, or paste the **HTML** versions
where they exist (`content/faqs.html`).

### D3. Pasting into a product (descriptions)

Product copy does not go through Elementor.

1. **Products → All Products → [product] → Edit.**
2. **Product short description** — one line, above the main editor.
3. **Product description** — the big editor. Use the **Text** tab if you want the
   paragraphs to keep their spacing.
4. **Update.**
5. Repeat for all ten. The measurements are the only thing that changes between them.

---

## After everything — clear the cache and check

GreenGeeks serves through LiteSpeed, so a change can take a minute to appear.

1. **LiteSpeed Cache → Toolbox → Purge All.**
2. Open each changed page in a **private / incognito window** — logged-out is what a
   reviewer sees.
3. Check these five things specifically:
   - `/terms/` — no square brackets anywhere
   - `/shipping-delivery/` — no `GH₵ ____`
   - `/faqs/` — no *"But I must explain to you…"*
   - any page, scrolled to the bottom — the teal footer with four columns
   - `/shop/` — products, not *"Great things are on the horizon"*

---

## If something goes wrong

| What you see | What it means | Fix |
|---|---|---|
| "Destination folder already exists" | the theme is already installed | use cPanel extraction (A2) |
| "The link you followed has expired" | upload size or a stale form | reload the page and try again; the file is under 1 MB |
| "Sorry, you are not allowed to upload this file type" | zip blocked by the host | upload through cPanel File Manager instead |
| Import runs, then nothing appears | you are looking at published pages | **Pages → Drafts** |
| Template import says "Invalid file" | the JSON was altered by an editor | re-download it; do not open and re-save in a text editor |
| Footer template imported but the site still has no footer | the theme option is unset | Theme Options → Footer → *Footer Builder* → select it |
| White screen | a PHP error | rename `luxrio-child` → `luxrio-child-off` in cPanel |
| Changes do not appear | cache | LiteSpeed → Purge All, then Ctrl/Cmd+Shift+R |
