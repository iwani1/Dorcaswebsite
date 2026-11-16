# Home page — fix it step by step

Work down the list. Each step is one change, says exactly where to make it, gives the words to paste, and tells you how to know it worked. Don't skip to step 5 because it looks more interesting — steps 1–3 are what make the page stop looking like a template.

**Total: about 90 minutes.** Step 1 is the only one that isn't editing.

---

## The diagnosis, in one paragraph

The home page's **structure is fine** — hero, promo pair, categories, story, best sellers, wholesale, testimonials, Instagram is a normal shop spine. What's wrong is that every organ inside it belongs to a different business: a watch shop in the demo author's imagination. The page is a watch template wearing gold jewellery. So this is not a rebuild; it's a transplant, section by section.

Six defects, in the order you'll meet them:

| # | Defect | Evidence |
|---|---|---|
| 1 | Links leave the site or hit empty pages | "Premium Model" → `wordpress.vecurosoft.com/luxrio/shop/`; menu Shop → `/shop-2/` (zero products) |
| 2 | Hero copy is wrong and misspelt | "stylish wrist Jewelry", "Best **Luxry** Jewelry", `GHC` instead of `₵`, "extra 25% off" |
| 3 | Category section is broken | 3 designs × 4 copies = 12 tiles, all the same image, all linking to `#` |
| 4 | Watch copy throughout | "High Class Timekeepers", "customize wrist jewelry", *"tjari watch business solution"*, tabs Adinkra/Gold/**Watches** |
| 5 | Sections that render nothing | "best selling" shows heading and tabs, **no products** |
| 6 | Fake social proof | lorem ipsum attributed to "Vivi Marian, Google Ceo" and "alaxander lee" |

---

## Step 1 — Install child theme 1.5.0 (2 min)

`Appearance → Themes → Add New → Upload Theme` → `luxrio-child-1.5.0.zip` → **Replace current**.

This fixes, without you touching anything: the vendor links, every `-2` page link, the Instagram strip URL, and `GHC` → `₵`.

Then **LiteSpeed Cache → Purge All**, and reload the page.

**Done when:** the menu's Shop link reads `/shop/` (not `/shop-2/`) and the hero says `₵300.00`.

> If it still says `GHC`, the theme upload didn't take or the cache didn't purge. Check `Appearance → Themes` — the active theme card should read *Queen Dor's Child 1.5.0*.

---

## Step 2 — Hero: one slide, not two (10 min)

The slider has **two slides**. Two messages on one screen means neither lands, and the second one promises *"extra 25% off"* — a discount I doubt anyone agreed to.

`Edit with Elementor` → click the hero → **Slider Content** → on the second slide press the **bin icon**.

Then on the remaining slide:

| Field | Replace with |
|---|---|
| **Subttile** | `Adinkra jewellery · Accra` |
| **Title** | `Jewellery that already means something` |
| **Discription** | `Hand-finished pieces, made to be given.` |
| **Button Text** | `Shop the collection` |
| **Button Url** | `/shop/` |

**Slider Image:** one cut-out from `product-images/products/` — the `02-clover-necklace-set` reads best against the dark background.

**Done when:** one headline, one button, no "wrist", no "Luxry", no percentage.

---

## Step 3 — The two promo blocks (10 min)

"Premium Model — Only From GHC 200.00" and "Premium editions — GHC65.00" are demo tiles with prices that match no product in the shop. A customer who clicks one lands on a page that doesn't sell what the tile promised.

Either delete both blocks, or turn them into **two real doors**:

| Tile | Heading | Line | Links to |
|---|---|---|---|
| Left | `For the shop` | `Trade prices, six per style` | `/wholesale/` |
| Right | `For the gift` | `Boxed and ready to give` | `/product-category/sets-gifts/` |

**Done when:** no tile says a price that isn't in the catalogue.

---

## Step 4 — Replace "High Class Timekeepers" (10 min)

The heading, its four decorative icons, and the section beneath it are all watch demo material. The client sells symbols that mean things — that's the whole differentiator and the page never mentions it.

Delete the four icon images. Replace the heading block with:

> **Kicker:** `Why Adinkra`
> **Heading:** `A piece that says something`
> **Body:** *Sankofa — go back and fetch what matters. Gye Nyame — the supremacy of God. Akoma — patience. Every piece carries a symbol with a meaning the wearer chose.*
> **Button:** `Explore the symbols` → `/symbols/`

**Done when:** the words Sankofa, Gye Nyame or Akoma appear on the home page.

---

## Step 5 — The category section (20 min — the worst one)

Under "CUSTOM Jewelry / exclusive categories" you currently have **twelve tiles**: three designs (Diamond Pendant · 06 Product, Luna Rosa · 20 Product, Limited Edition · 20 Product) repeated four times. Every one shows the same photo. Every one links to `#`.

Delete the whole grid. Rebuild with **five tiles**, one per real category, each linking to its archive:

| Tile | Links to | Count |
|---|---|---|
| Necklaces | `/product-category/necklaces/` | 3 |
| Earrings | `/product-category/earrings/` | 2 |
| Bracelets | `/product-category/bracelets/` | 1 |
| Rings | `/product-category/rings/` | 3 |
| Sets & Gifts | `/product-category/sets-gifts/` | 1 |

Also in that section: the tab labels read **Adinkra / Gold / Watches** — delete "Watches".

**Done when:** five tiles, five different images, five working links.

> Note: the shop has one bracelet but you have six bracelet photographs. That mismatch is the catalogue-versus-photos decision still open — unrelated to this step, but it's why "Bracelets" will read `1`.

---

## Step 6 — "THE PROCESS / customize wrist jewelry" (10 min)

> *"always committed to providing its partners with a comprehensive and excellent tjari watch business solution only design."*

That sentence is the single most damaging thing on the page — it's not just wrong, it's gibberish, and it sits above a photo on a page selling ₵650 pieces.

Replace the section with the client's actual story, or delete it and link to About:

> **Kicker:** `Our work`
> **Heading:** `Made in Accra, worn anywhere`
> **Body:** *Each piece is finished by hand, boxed in a Queen Dor's pouch, and sent from Accra. Retail and wholesale, delivered worldwide.*
> **Button:** `Read our story` → `/about/`

**Done when:** the word "tjari" exists nowhere on the site.

---

## Step 7 — Put products where "best selling" is (10 min)

The section renders its heading (*Graceful Ear Drops*), its tabs (All / Classic / Modern), and **no products at all**. A shop's home page with nothing to buy on it is the reason this step exists.

Inside that section, add an Elementor **Products** widget:

- **Columns:** 4
- **Limit:** 8
- **Order by:** Popularity (or Featured, once you mark pieces as featured)
- **Heading:** `Best sellers`

Then delete the tabs *All / Classic / Modern* — they filter by tag and the products have no such tags.

**Done when:** eight real products with `₵` prices appear mid-page.

---

## Step 8 — Delete the testimonials (2 min)

Select the whole testimonial section — the one with "people love us" and the two carousel quotes — and delete it.

Those quotes are lorem ipsum attributed to **"Vivi Marian, Google Ceo"** and **"alaxander lee, Google Ceo"**. Invented reviewers with misspelt job titles are worse than no reviews: a visitor who spots one stops believing the rest of the page too, including the prices.

Bring it back the day the client has two real quotes from real stockists. I can drop them in by code in ten minutes.

**Done when:** no lorem ipsum anywhere on the page.

---

## Step 9 — The Instagram strip (2 min)

Five identical images, all linking to `instagram.com` — not even the client's profile. Until their account is wired up with real photos, this section is five copies of one picture.

Delete it, or hide it. Hiding is one line and I can ship it — say the word.

---

## Step 10 — Menu label (3 min)

`Appearance → Menus` → the first item says **Jewelry House** and points at the home page. Rename it `Home`.

While you're there, add **Wholesale** → `/wholesale/`. It's the item buyers look for first and it's currently missing entirely.

---

## Done when you can answer yes to all ten

- [ ] Theme reads **1.5.0** and prices show `₵`
- [ ] One hero slide, one message, one button
- [ ] No tile promises a price that isn't in the shop
- [ ] The page mentions at least one Adinkra symbol
- [ ] Five category tiles with five working links
- [ ] The word "tjari" appears nowhere
- [ ] Eight products visible mid-page
- [ ] No lorem ipsum, no invented reviewers
- [ ] No Instagram strip full of duplicates
- [ ] Menu says Home, and has Wholesale

At that point the home page is a jewellery shop's home page. Then we move to the next page — and the same method applies.
