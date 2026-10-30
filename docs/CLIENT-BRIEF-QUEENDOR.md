# Queen Dor's Fashion House — client profile (corrected)

**Source:** `instagram.com/queendor_fashionhouse`, read through a mirror (imginn) because Instagram returns 403 to unauthenticated requests.

> ## Correction to the previous version of this brief
>
> I assumed from the name "Fashion house" that this was an apparel label and recommended restructuring the catalogue for garments. **That was wrong.** They sell *jewellery*. Luxrio is a jewellery theme, so the theme is the right buy and the demo's structure largely holds. What was wrong was my read of the business, not their choice of theme.
>
> The relevant point survives in a different form: the demo's *vocabulary* is still wrong — "diamond", "High Class Jewellery", "wedding ring" — but it's now a copy problem inside a correct structure, not a re-platforming problem.

---

## 1. What the profile actually says

| | |
|---|---|
| Handle | `@queendor_fashionhouse` |
| Name | Queen Dor's Fashion house |
| Followers / following | **8.9K** / 1,712 |
| Bio line 1 | *"Elegant jewelry for every occasion"* |
| Bio line 2 | *"Adinkra & timeless pieces 🇬🇭"* |
| Bio line 3 | *"Retail \| Wholesale \| Worldwide delivery 🌍"* |
| Bio line 4 | *"📍 Accra, Ghana"* |
| CTA | *"👇 Shop / Order on WhatsApp"* |

I could see the post thumbnails but not the captions, so product range, price points and materials are still **unconfirmed** (see §8).

---

## 2. Four facts in that bio that change the build

### a. They sell Adinkra-motif jewellery, not generic fine jewellery

Adinkra are Akan symbols, each with a name and a meaning — Gye Nyame (except for God), Sankofa (go back and fetch it), Duafe (beauty), Akoma (patience), Bese Saka (abundance), Dwennimmen (humility and strength), Adinkrahene (leadership), Nkyinkyim (initiative).

This is the single most useful thing in the profile. **The symbol is the product story.** Competitors sell "a gold necklace"; they sell Sankofa. That gives you:

- A second axis for navigation: shop **by symbol**, not only by type
- Real copy on every product page — the symbol's meaning, 40–80 words — instead of "Lorem ipsum necklace"
- The SEO that wins: nobody searching "Sankofa necklace meaning" lands on a jewellery template demo
- A gift narrative — symbol jewellery sells because the meaning is the gift

The demo has none of this. Its categories are `diamond`, `silver`, `classic-ring`, `luxry-watch` — fine-jewellery language for what is, culturally, a different product. **"Diamond" and "High Class Jewellery" copy must go**; it misrepresents both the material and the brand.

### b. Retail **and wholesale** are both revenue lines

The theme, like every default WooCommerce setup, shows one price to everyone. Wholesale means a second, lower price for approved accounts — usually with a minimum order quantity.

| Approach | How | Cost |
|---|---|---|
| **A. Wholesale role** | WooCommerce role-based pricing (B2BKing, Wholesale Prices, or a snippet + `wholesale_customer` role) — approved accounts see trade prices | free–$150/yr |
| **B. Enquiry only** | "Wholesale enquiry" form → CF7, you quote by email | free |
| **C. Separate catalogue** | password-protected wholesale page with a PDF line sheet | free |

**Recommendation: B now, A if wholesale becomes a real share of revenue.** A wholesale tier adds complexity to every product page and every plugin interaction; ship the retail store first. B also tells you *whether* wholesale demand justifies it.

**Open question: are their wholesale prices worth showing at all?** They may do wholesale on an enquiry basis only, in which case A is wasted plugin weight.

### c. "Worldwide delivery" is core, not an afterthought

The demo ships placeholder zones. For a brand whose customers are in the diaspora, international shipping is the *main* channel, not the edge case:

| Zone | Method | Notes |
|---|---|---|
| Accra | flat rate / same-day rider | Yango Delivery, Bolt Send, or own dispatch |
| Other regions | courier | Kumasi, Takoradi, Tamale |
| **International** | **DHL / courier, weight-based** | UK, US, Canada — the diaspora buyers |

Jewellery is light and small, so weight-based rates work well and DHL is cheap enough to be viable. Get real rates from the client — international buyers abandon at an unexpected shipping cost faster than at a product price.

**Currency decision:** many Ghanaian jewellers display GHS but settle diaspora sales in USD. If a large share of buyers is abroad, a currency switcher is worth it. Don't guess — ask.

### d. They already sell on WhatsApp

The CTA is *"Shop / Order on WhatsApp"* — which suggests the link in their bio is a WhatsApp link, and that the checkout may not exist yet. Whatever the truth, **the website must not fight the channel that already works**:

- Floating WhatsApp button, site-wide
- "Order on WhatsApp" on every product, message prefilled with the product name and price
- Runs *alongside* the cart, not instead of it

This also means the site can go live and be useful on day one, before the catalogue is complete.

---

## 3. Taxonomy to build

The demo's type categories are a usable skeleton. Keep the shape, change the vocabulary, add the axis that matters.

**By type** (demo's, cleaned up):

```
Necklaces · Earrings · Bracelets · Rings (if stocked) · Sets & Bridal
```

Delete: `luxry-watch`, `diamond`, `silver`, `classic-ring`, `trending-rings` — fine-jewellery language that doesn't describe Adinkra pieces.

**By symbol** — the differentiator:

```
Gye Nyame · Sankofa · Duafe · Akoma · Bese Saka · Dwennimmen · Adinkrahene · Nkyinkyim
```

**By occasion** — straight from their own words, *"for every occasion"*:

```
Everyday · Occasion & Evening · Gifting · Bridal
```

Three menus is one too many for a boutique this size. Ship **type + symbol**, and use occasion as a homepage/edit collection rather than a third nav axis.

---

## 4. Product data model

Jewellery is simpler than apparel — no dress sizes — but it has its own attributes:

| Attribute | Values | Notes |
|---|---|---|
| `Symbol` | the Adinkra name | the copy hook, and a filter |
| `Material / Finish` | gold-plated · brass · beaded · sterling | drives care instructions |
| `Chain / Band length` | adjustable · 16" · 18" · custom | the #1 jewellery question |
| `Ring size` | UK sizes, only if rings are stocked | |
| `Colour` | per piece | drives the swatches |

**Variation Swatches** is already installed, so colour/size render as buttons. It finally does real work here.

**Care instructions** — a short block on every product page (avoid perfume, store dry, gold-plated vs solid). Cheap to write, cuts complaints, and it's what a serious jeweller has.

---

## 5. Shipping, payment, and the Ghana realities

**Payments.** Mobile Money is how Ghana pays online — a card-only checkout will convert a fraction of what a MoMo-enabled one does.

- **Paystack Ghana** — MTN MoMo, Telecel Cash, AirtelTigo Money, plus cards. Default recommendation.
- **Hubtel** — strong local alternative.
- **Pay on delivery** — normal in Accra, enable for Accra only.
- **International buyers** will use cards — make sure the same gateway handles them, or add PayPal for the diaspora.

**Wholesale MOQ** — if they take wholesale orders through the site, minimum quantities per line need enforcing. That's the point at which option A above becomes necessary; option B avoids it entirely.

**Privacy.** Ghana's Data Protection Act (Act 843) applies as soon as they collect names, addresses and phone numbers. The policy page must be real text.

---

## 6. What the demo gets wrong, concretely

| Demo currently says | Should say |
|---|---|
| "Necklace jewellery — HOLY JEWELRY and diamonds" | A collection lead: Sankofa, Gye Nyame, or their strongest seller |
| "High Class Jewellery" | "Elegant jewellery for every occasion" — their own line |
| Categories: diamond, silver, luxry-watch | Necklaces, Earrings, Bracelets, Sets + symbol axis |
| Product: "Adjustable Rings $30" | Real product, real price in GHS, the symbol's meaning below the fold |
| Nav: Home 01/02/03, Page List 1–4 | Home, Shop, Symbols/Collections, Wholesale, About, Contact |
| 470 imported items | **20–60 real SKUs.** A boutique with 8.9K followers doesn't carry 470 products; pruning makes the shop look curated rather than scraped |

That last row matters more than it looks. A demo-scale catalogue reads as padding. Twelve well-shot products convert better than 470 imported ones.

---

## 7. Assets to collect

- [ ] Logo — vector (SVG/AI/PDF) **and** a white/light version. Not an Instagram screenshot.
- [ ] Brand colours (hex), or the two or three colours from the logo/packaging
- [ ] **20–40 product photos**, square or 4:5, minimum 1200 px, on a plain background — plus any on-model shots
- [ ] Per product: name · **Adinkra symbol** · price (GHS) · material/finish · chain/band length · colours · ring sizes if applicable
- [ ] **The meaning of each symbol they use**, in their own words — or authority to write them and have them approve
- [ ] 3–5 wide lifestyle/campaign images for the hero slider (1920 px+)
- [ ] Delivery fees: Accra / other regions / international, and who ships internationally
- [ ] Wholesale terms: minimum quantity, price list, or "enquiry only"
- [ ] Payment: Paystack or Hubtel merchant details (or "test mode for now")
- [ ] WhatsApp business number
- [ ] Business name, address, phone, registration number for the footer
- [ ] Privacy policy + returns/exchange text (jewellery: hygiene rules usually mean earrings are non-returnable — confirm theirs)
- [ ] Confirmed Instagram handle for the feed block

---

## 8. Questions for the client

1. **Wholesale through the site, or by enquiry only?** (If enquiry, we skip a plugin and a lot of complexity.)
2. **Do most sales go abroad or in Ghana?** This decides whether we build a currency switcher and how hard we push international shipping.
3. **Is there a checkout today, or does everything go through WhatsApp?** Determines whether the site replaces a flow or creates one.
4. **What are their best-selling 10 pieces?** Build the homepage around those, not around the demo's layout.
5. **Do they sell rings?** Ring sizing is the only fiddly attribute; if it's necklaces and earrings, the product model stays very simple.

---

## 9. Revised build order

**Downgraded from the last version:** the catalogue rebuild is *not* a re-platforming job. The structure stays.

**Changed from `docs/LIVE-SITE-FIXES.md`:** §3, the `vecurosoft` hotlink replacement, is **back on**. The theme is jewellery and so is the client, so the demo's product photography actually fits the review — it's better to show the client a working jewellery shop than a broken one. Run the Better Search Replace pass as written; it costs 10 minutes and makes the review link coherent.

Order from here:

1. **Fix the three P0s already found** — coming-soon off, menu pointing at `/shop-2/`, `vecurosoft` replace. The site should look correct before anything else.
2. Get the asset list (§7) — blocks all visual work
3. Rebuild taxonomy: type categories + `Symbol` attribute, delete the diamond/watch vocabulary
4. Rewrite the homepage sections in their voice — *"Elegant jewellery for every occasion"*, symbol-led
5. Build **one category end-to-end** with 6 real products, including a symbol story and care instructions
6. Paystack in test mode + WhatsApp button
7. Prune the demo to a curated catalogue, rebuild the menu, add Wholesale/About/Contact
8. Review link with the directory password on

Step 5 exists to surface every problem — swatches, imagery, shipping class, symbol copy, care block — at six products instead of forty.
