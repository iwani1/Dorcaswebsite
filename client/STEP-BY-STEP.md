# The pack, step by step

Run these in order. Each step ends with **how you know it worked** — if the check
fails, stop there rather than carrying the problem forward.

You will need: cPanel open, WordPress admin open, and the pack unzipped on your
desktop.

| Part | What | Time |
|---|---|---|
| 0 | Back up | 10 min |
| 1 | **Open the store** | 2 min |
| 2 | Make sure an order can be completed | 5 min |
| 3 | Upload theme 1.8.8 | 3 min |
| 4 | Footer | 10 min |
| 5 | The six policy pages | 40 min |
| 6 | FAQ, product copy, symbols strip | 30 min |
| 7 | Cleanup plugin: old domain, then duplicates | 15 min |
| 8 | Images | client |
| 9 | Email | 15 min |
| 10 | Paystack | 30 min |
| 11 | Launch checks | 10 min |

---

## Part 0 — Back up (do not skip)

**cPanel → File → Backup (or JetBackup):**

1. *Download a Full Account Backup* — save it somewhere that is not the server.
2. **cPanel → phpMyAdmin →** your shop's database → **Export → Go** → save the `.sql`.
3. Write down the current theme version (Appearance → Themes) so you can tell what
   changed if something goes wrong.

**If it all goes wrong**, restore the `.sql`, and rename the theme folder
`wp-content/themes/luxrio-child` to `luxrio-child-off` — WordPress falls back to
the parent theme and the site comes back.

---

## Part 1 — Open the store ⭐

This is the one that matters. Right now every shop page says *"Great things are on
the horizon"*.

1. **WooCommerce → Settings → Site visibility.**
2. Select **Live**.
3. **Save changes.**

If you don't see *Site visibility*: look at the top of any admin screen for the
notice **"Your store is coming soon"** → click **Edit**, or **WooCommerce →
Settings → General**.

**You know it worked when:** `/shop/` shows products instead of the "coming soon"
screen. Then click any product — the product page should render with a price and an
Add to cart button.

> Everything after this is measurable. Until this is done, nothing is.

---

## Part 2 — Make sure an order can actually be completed

The site has no register form on My account, which means account creation may be
switched off.

1. **WooCommerce → Settings → Accounts & Privacy.**
   - **Allow customers to place orders without an account** → **ON** (this is guest
     checkout; without it, and with no register form, nobody can buy)
   - *Allow customers to create an account during checkout* → either is fine
   - *Allow customers to create an account on the My account page* → **ON** if you
     want customers to have accounts
2. **WooCommerce → Settings → General →** Currency **Ghana cedi (GH₵)** ✓ already
   set; *Selling location* Ghana; *Shipping location* Ghana.
3. **Test it:** add a product to the cart, open `/checkout/`, and fill the form up
   to (not including) payment.

**You know it worked when:** the checkout page shows name, address and phone
fields, and a place-order button.

---

## Part 3 — Upload the theme

1. **Appearance → Themes → Add New → Upload Theme.**
2. Choose **`luxrio-child-1.8.8.zip`** → **Install Now** → **Replace current with
   uploaded**.
3. Leave it active — it already is.

**You know it worked when:** Appearance → Themes lists *Queen Dor's Child* at
**1.8.8**, and the front page still looks right (the footer will still be empty —
that's Part 4).

---

## Part 4 — The footer

**Import the template:**

1. **Templates → Saved Templates → Import Templates.**
2. Choose **`footer/queendor-footer-elementor.json`** → **Import**.
3. It appears in the list as **Queen Dor's Footer**.

**Turn it on:**

4. Open the theme options panel — in the left sidebar it is usually **Luxrio** or
   **Theme Options** (the Redux panel, not the WordPress customiser).
5. Find the **Footer** section.
6. *Footer Builder* trigger → **Footer Builder**.
7. *Select Footer* → **Queen Dor's Footer**.
8. **Save Changes.**

**Fill in the details:**

9. **Templates → Saved Templates → Queen Dor's Footer → Edit with Elementor.**
10. Click the HTML widget and replace, in the code:
    - `[STREET ADDRESS], [AREA]`
    - `[PHONE NUMBER]` — in **both** the visible text and the `tel:` link
    - `[EMAIL ADDRESS]` — in **both** the visible text and the `mailto:` link
    - `[9:00–17:00]` and `[10:00–14:00]`, or delete the hours line
    - `[REGISTERED BUSINESS NAME]` and `[NUMBER]`
11. **Update.**

**You know it worked when:** you scroll to the bottom of the home page and see a
teal footer with four columns — brand, Shop, Help, Talk to us — a Paystack line, and
the legal links.

**If nothing appears:** the trigger is still on its old value. The theme only prints
the footer when the trigger is exactly `footer_builder`.

---

## Part 5 — The six policy pages

### 5a. Import them

**Tools → Import → WordPress → Install Now → Run Importer →** choose
**`queendor-paystack-pages.wxr`** → **Submit**.

You get six **drafts**: Terms and Conditions, Returns and Refunds, Shipping &
Delivery, Privacy Policy, Contact, About Us.

### 5b. Publish the three that are new

Open each, fill the square brackets, set the slug, **Publish**:

| Draft | Set the slug to |
|---|---|
| Terms and Conditions | `terms` |
| Privacy Policy | `privacy-policy` |
| About Us | `about` |

> The slug is under the title in the editor — *Permalink: …/wordpress/**slug**/*.
> If WordPress has made it `terms-2`, change it now, not later.

### 5c. Move the other three into the pages that already exist

`returns-exchanges`, `shipping-delivery` and `contact` are already published, so
their imported copies land as `-2` drafts. For each:

1. Open the **draft**, press **Ctrl/Cmd+A** inside the editor and copy.
2. Open the **published** page, select everything in the editor, and paste over it.
3. **Update** the published page.
4. **Trash** the draft.

Do not skip step 4 — Part 7 removes the duplicates, but it is cleaner not to make
them.

### 5d. The details only you have

| Page | Fill in |
|---|---|
| Contact | address, phone, email, opening hours |
| Shipping & Delivery | the three prices, the dispatch cut-off, the free-delivery threshold |
| Privacy | the email address (the live page currently says `________`) |
| Terms | registered name, registration number, address, refund window in days |
| About | registered name, number, address — plus the materials each piece is made of |

**You know it worked when:** `/terms/` loads, and every one of them is linked from
the footer. Click each footer link to be sure.

---

## Part 6 — FAQ, product copy, symbols strip

### 6a. FAQ page

1. **Pages → FAQ's → Edit with Elementor.**
2. Delete the demo accordion block (the six questions starting *"But I must explain
   to you…"*).
3. Drag an **HTML** widget in and paste **`content/faqs.html`**.
4. Replace `[EMAIL ADDRESS]`, `[NUMBER]` and choose one of the two pickup lines.
5. **Update.**

**Check:** `/faqs/` shows the twelve real questions and no lorem ipsum.

### 6b. Product descriptions

For each of the ten products: **Products → [product] → Product short
description** and **Product description**, pasting from
**`content/product-descriptions.md`**.

Fill the measurements — sizes in mm, chain lengths in cm, weights in g, and which
five symbols are on the layered necklace. Two of them need the post metal: sterling
silver or surgical steel.

**Check:** a product page reads like a product page, and the word "gold" never
describes plating.

### 6c. Symbols strip

1. **Pages → [front page] → Edit with Elementor.**
2. Find the band that says **"Why Adinkra" / "A piece that says something"** — it
   currently holds a heading and a small icon and no body text.
3. Delete what is in it, drop an **HTML** widget in its place, paste
   **`content/symbols-strip.html`**.
4. **Update.**

**Check:** six cards, gold labels, links to `/symbol/…`. Those links work once the
store is live (Part 1).

---

## Part 7 — Cleanup plugin: old domain first, then duplicates

**Install:** Plugins → Add New → Upload Plugin → **`queendor-cleanup-1.1.0.zip`** →
Install → **Activate**.

Open **Tools → Queen Dor's Cleanup.** It is a dry run until you press a button —
nothing changes on its own.

### 7a. Section 6 — the old domain

Read the table. It lists the options and meta rows still holding
`blaharbenyah.com` — that is why the side cart still loads its icons from the old
site.

Press **Replace the old domain.**

**Check:** click *Reload*; the table should now say *Clean*. Then view any page's
source and search for `blaharbenyah` — there should be nothing.

### 7b. Section 5 — duplicate pages

The table lists each `-2`/`-3` page and the page it will point at. **All are
pre-ticked.**

Press **Trash N duplicates and redirect them.**

Each one is 301-redirected, so `/privacy-policy-3/` still lands somewhere sensible
instead of 404ing.

**Check:** Pages list shows ~13 pages, not 30. Visit an old duplicate URL — you
should be redirected, not given a 404.

### 7c. Rename the remaining bad slugs

`privacy-policy-2` should be `privacy-policy`, and `about-2` → `about`. Rename the
one you are keeping; the redirects follow the page ID, not the slug.

Then **WooCommerce → Settings → Advanced → Privacy page** — point it at the privacy
page you kept.

### 7d. Remove the tool

**Plugins → Deactivate → Delete.** It is a destructive tool; it should not live on
the server.

---

## Part 8 — Images

Two separate jobs:

1. **Product images** — Products → each product → **Product image**. Nine pieces
   need a photograph. Until they exist, the home page and shop read as a set of
   empty frames, and that is the single biggest thing standing between this site and
   looking like a shop.
2. **The 14 demo images on `wordpress.vecurosoft.com`** — section backgrounds and
   decorative shapes. Do **not** simply delete them; sections will go blank.
   Download each one, upload to the Media Library, and swap the image in the
   Elementor settings.

**Check:** view source on the home page and search `vecurosoft` — nothing should
match.

---

## Part 9 — Email

Nothing on this site has ever proven it can send an email.

1. **cPanel → Email Accounts → Create** → `orders@queendorfashionhouse.com`. Save
   the password; open webmail once to confirm it works.
2. **cPanel → Email Deliverability →** your domain → **Repair** (writes SPF and
   DKIM).
3. **Install WP Mail SMTP** (Plugins → Add New), configure it with that mailbox, and
   use its **Send a test email**.
4. **WooCommerce → Settings → Emails →** set *From* name and address to the new
   mailbox. Save.
5. Place a real test order and confirm **the order confirmation arrives**.

**You know it worked when:** the test email arrives, and then the order email
arrives. If either fails, fix it now — this is what a customer hits first, and it is
the evidence you send in every dispute.

---

## Part 10 — Paystack

Full detail in **`PAYSTACK-SETUP.md`**. The short version:

1. Plugins → Add New → **Paystack** (the official one) → Activate.
2. WooCommerce → Settings → Payments → **Paystack → Manage**.
3. Paste your **test** public and secret keys (Paystack dashboard → Settings → API
   Keys & Webhooks, with *Test mode* on). Leave **Test Mode** ticked.
4. Copy the **webhook URL** from the plugin into the same dashboard page. Test and
   live webhooks are separate — you will do this twice.
5. Enable **Card** and **Mobile Money** channels. Mobile money is how most Ghanaian
   customers pay.
6. Place a test order: `4084 0840 8408 4081`, CVV `408`, PIN `0000`, OTP `123456`.
   **Check the order goes to Processing, not stuck on Pending** — if it sticks, the
   webhook is wrong.
7. Refund it from the Paystack dashboard.
8. Then **live keys, live webhook**, one real ₵1 order, and refund it.
9. Start the **activation request** with the five documents: business registration,
   GRA TIN, Ghana Card, Ghanaian bank account, business address.

---

## Part 11 — Launch checks

1. **Settings → Reading →** untick *Discourage search engines*. (It is currently
   indexable anyway — the robots file allows everything — so the store has been
   crawlable while it was closed.)
2. **SEO plugin → Sitemaps →** regenerate. `/sitemap.xml` currently returns a **500**
   and that is what you submit to Google.
3. **cPanel → Domains →** *Force HTTPS Redirect* on. Confirm the padlock on
   `https://queendorfashionhouse.com`.
4. **Google Search Console** → add the domain → submit the sitemap.
5. Remove the password protection, if one was ever set.
6. Walk the site on a **phone**: home, shop, a product, cart, checkout, footer.

---

## One-page checklist

- [ ] Full backup + `.sql` exported
- [ ] **Store set to Live**
- [ ] Guest checkout ON; test add-to-cart → checkout renders
- [ ] Theme 1.8.8 uploaded and active
- [ ] Footer template imported, assigned, details filled
- [ ] Paystack pages imported
- [ ] `/terms/` published · privacy · about
- [ ] Contact, Delivery, Returns, Privacy replaced with real details
- [ ] FAQ lorem replaced
- [ ] Ten product descriptions pasted
- [ ] Symbols strip on the home page
- [ ] Old domain replaced (cleanup plugin §6)
- [ ] 17 duplicates trashed and redirected (§5)
- [ ] `privacy-policy-2` and `about-2` renamed
- [ ] Cleanup plugin deleted
- [ ] Product photographs added
- [ ] No `vecurosoft` in page source
- [ ] `orders@` mailbox created, SPF/DKIM repaired, SMTP test sent
- [ ] Test order email received
- [ ] Paystack test order → Processing → refunded
- [ ] Paystack live keys + live webhook → ₵1 order refunded
- [ ] Sitemap regenerated (no 500)
- [ ] Force HTTPS on; padlock present
- [ ] Search Console + sitemap submitted
- [ ] Checked on a phone

---

## If something breaks

| Symptom | Cause | Fix |
|---|---|---|
| White screen after a theme update | a PHP error in the child theme | rename `wp-content/themes/luxrio-child` → `luxrio-child-off`; the parent theme renders and you can undo the change |
| Footer still empty | the trigger option is not `footer_builder` | Theme Options → Footer → set both fields, save |
| Products show "coming soon" again | site visibility reset, or a plugin changed it | WooCommerce → Settings → Site visibility → Live |
| Checkout says "no payment methods" | Paystack not enabled, or the zone has no method | Settings → Payments; Settings → Shipping zones |
| Order stuck on "Pending payment" | webhook not set | paste the webhook URL into Paystack, in the matching mode |
| A page 404s after cleanup | the redirect map is in `qclean_redirects` | restore the page from the Trash (30 days) |
