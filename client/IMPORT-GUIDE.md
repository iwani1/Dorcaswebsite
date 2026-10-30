# Queen Dor's — client pack: import guide

Everything in this pack goes onto the live site at `blaharbenyah.com/dorcas` in about 40 minutes.

| File | What it's for | Where it goes |
|---|---|---|
| `luxrio-child-1.1.1.zip` | The code: symbol panels, care notes, ring-size tab, WhatsApp buttons, shop settings | Appearance → Themes → Upload |
| `queendor-products.csv` | The 10 launch products, 18 size variations, real copy | Products → All Products → Import |
| `policies.md` | Draft shipping, returns, privacy and care copy | Pages + WooCommerce settings |

**Do them in this order.** The attribute in step 1 has to exist before the CSV lands, or the symbol pages will have no archives.

---

## Step 1 — create the Symbol attribute (5 min)

`Products → Attributes → Add new`

| Field | Value |
|---|---|
| Name | `Symbol` |
| Slug | `symbol` *(leave as generated — this makes it `pa_symbol`)* |
| Default sort order | Name |
| **Enable archives?** | **✓ tick this** |

Save, then **Configure terms** and add these eight, exactly:

```
Gye Nyame
Sankofa
Duafe
Akoma
Bese Saka
Dwennimmen
Adinkrahene
Nkyinkyim
```

> **Why bother if the CSV creates it anyway?** It does create it — but without archives, and the archives are the point. Every symbol term becomes a landing page (`/symbol/sankofa/`) that can rank for "Sankofa necklace". That's free traffic the theme's demo never had, and it's a checkbox you either tick now or forget.

---

## Step 2 — install the child theme (5 min)

`Appearance → Themes → Add New → Upload Theme` → `luxrio-child-1.1.1.zip` → **Install** → **Replace current with uploaded**.

The version number is 1.1.1 so WordPress offers the replace; you don't lose any settings, because settings live in the database, not the theme.

**Then:** `Settings → Queen Dor's`

| Field | Value |
|---|---|
| WhatsApp number | `233XXXXXXXXX` — digits only, country code first. A number typed as `024 123 4567` is converted automatically |
| Floating button | leave ticked |

Save. **Open the site in a private window** — a green WhatsApp button should appear bottom-right on every page except cart and checkout. If it doesn't, the number isn't saved (the settings page tells you in red).

---

## Step 3 — import the products (10 min)

`Products → All Products → Import` → **Choose file** → `queendor-products.csv` → **Continue**.

On the mapping screen, every column should auto-match because the headers are WooCommerce's own. Check three things before you click through:

- `Type` → **Type**
- `Attribute 1 name` … `Attribute 3 global` → mapped, not "Do not import"
- `Parent` → **Parent**

Then tick **Update existing products** only if you are re-running the import. First run: leave it unticked.

Click **Run the importer**. Expect **10 products and 18 variations**. It will take a minute; the bar sits still while it writes variations.

> If it reports "A new variation cannot be created because the parent product has no 'Ring size' attribute", the parent row didn't import before its variations. Delete the products and re-import — the file is ordered parents-first, so this only happens if a row was edited by hand.

---

## Step 4 — verify the rings (5 min)

Rings are the only variable products, so they're the only thing that can import half-right.

Open each of the three — `Duafe Statement Ring`, `Dwennimmen Signet Ring`, `Adinkrahene Stacking Ring Set` — and check `Product data → Variations`:

- [ ] Six sizes listed (L, N, P, R, T, V)
- [ ] `Product data → Attributes` shows **Ring size** with **"Used for variations"** ticked
- [ ] The product page shows a size dropdown, not "out of stock"
- [ ] A **"Ring size guide"** tab appears next to Description

If the size list is there but "Used for variations" is unticked, tick it and save — WooCommerce 11.1+ normally promotes it automatically, and this is the only place that could go wrong.

---

## Step 5 — ⚠️ replace the placeholders

**These are the commercial values. Do not let the shop go public with them unreplaced.**

| SKU | Product | Price (GHS) | Material assumed |
|---|---|---|---|
| QD-001 | Sankofa Pendant Necklace | 320 | Gold-plated |
| QD-002 | Gye Nyame Pendant Necklace | 320 | Gold-plated |
| QD-003 | Duafe Statement Ring | 420 | Brass |
| QD-004 | Akoma Stud Earrings | 180 | Gold-plated |
| QD-005 | Bese Saka Adjustable Bracelet | 260 | Brass |
| QD-006 | Dwennimmen Signet Ring | 480 | Brass |
| QD-007 | Adinkrahene Stacking Ring Set (3) | 650 | Brass |
| QD-008 | Nkyinkyim Hoop Earrings | 220 | Gold-plated |
| QD-009 | Five Symbols Layered Necklace | 480 | Gold-plated |
| QD-010 | Sankofa Necklace & Akoma Earring Gift Set | 560 | Gold-plated |

Also unconfirmed, and visible to customers on the product page:

- **Ring sizes** L, N, P, R, T, V — the set is a guess; use their real range
- **Chain length** "Adjustable 16–18 in" — confirm
- **Weights** (0.02–0.15 kg) — only matter once international shipping is switched on
- **Product photos** — the CSV deliberately imports none, so you won't get broken images. Upload real ones; the demo's jewellery stock photos are the wrong brand

The **care note** under each product is chosen by the material value, so if a piece is brass and the attribute says gold-plated, the wrong care text shows. Fix the attribute, and the copy follows.

---

## Step 6 — the two extra pages (5 min)

`Pages → Add New`, and paste the shortcode into a **Shortcode block**:

| Page | Shortcode | Add to menu |
|---|---|---|
| **Size Guide** | `[queendor_ring_guide]` | Footer, and link from every ring product |
| **Symbols** | `[queendor_symbol_index]` | Main menu — this is the differentiator |

`[queendor_symbol_index]` renders all eleven symbols with their meanings and a "Shop this symbol" link to each archive. `[queendor_symbol slug="sankofa"]` drops a single symbol block anywhere — useful in Elementor on the About page.

---

## Step 7 — shipping, payment, wholesale

**Shipping** (`WooCommerce → Settings → Shipping`) — two zones only for now:

| Zone | Method |
|---|---|
| Accra | Flat rate — their real fee |
| Other regions | Flat rate — their real fee |

Leave **Rest of world inactive**. It's set up as an empty zone on purpose: when they start shipping abroad, it's a rate, not a rebuild.

**Payments** — two gateways on:

1. **Paystack** in test mode until they have merchant approval. MTN MoMo, Telecel Cash, AirtelTigo and cards all come through it.
2. **Direct bank transfer**, renamed **"Mobile Money transfer"** — put their MoMo number and "send the screenshot on WhatsApp" in the description. Zero integration, works today, and unblocks real orders this week.

**Cash on delivery:** Accra only, and cap it below a low order value. Jewellery is high-value and resaleable.

**Wholesale** — two honest options:

- *Today, no plugin:* a **Wholesale** page with a Contact Form 7 enquiry form and a line-sheet PDF behind it. Invoices raised manually. This is enough to start and tells you whether trade demand is real.
- *When volume justifies it:* B2BKing (or Wholesale Suite) with an approved `wholesale_customer` role — trade price 50% of retail, MOQ 6 per style, approved by hand. Verify the free tier actually includes MOQ before committing to it.

---

## What this pack deliberately doesn't do

- **No product images.** The demo's photos are a different brand's jewellery.
- **No demo deletion.** Archiving 470 imported products is a separate pass — do it after the ten are right, so you can compare.
- **No homepage rewrite.** That's Elementor work in their voice, and it should follow the products, not lead them.
- **No live payments.**

---

## If something looks wrong

| Symptom | Cause | Fix |
|---|---|---|
| Symbol panel missing on a product | Product has no Symbol value, or the value isn't one of the eleven with copy | Set the attribute; the panel only appears for known symbols |
| Care note names the wrong material | Material attribute doesn't match the real piece | Edit the product's Material attribute |
| No ring-size tab | Product has no Ring size attribute | Add it under Product data → Attributes |
| Import says 0 products | Wrong file, or the CSV was opened and re-saved in Excel with a different delimiter | Re-export from the repo with `python3 tools/build-queendor-catalog.py` |
| Prices show with the wrong symbol | Store currency isn't GHS | `WooCommerce → Settings → General → Currency` |
| WhatsApp button missing | No number saved | `Settings → Queen Dor's` |
