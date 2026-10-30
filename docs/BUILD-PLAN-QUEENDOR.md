# Queen Dor's — build plan

Built from your five answers. This is the executable version: what to create, in what order, with the values typed out.

| Your answer | Effect on the plan |
|---|---|
| **1. Wholesale and retail** | Two price tiers. Decided below — trade prices behind an approved role, not a public second price |
| **2. Ghana now, abroad later** | Build **Accra + regions** only. International zone left *inactive* so nobody can order into a void. Weight-based classes set up now so DHL switches on later without a rebuild |
| **3. Checkout today** | Full cart + checkout. No enquiry-only compromise |
| **4. Recommend the 10** | Specified below — a launch set that covers every product type, so nothing new surprises you at SKU 40 |
| **5. Rings, yes** | Ring size becomes a real attribute, with its own size guide |

> Reading 3 as *"a checkout exists / is wanted now"*. If that means an existing storefront on another platform, tell me which one — order and customer migration is a separate job that's much cheaper to plan before launch than after.

---

## 1. The launch catalogue — ten pieces

This is a *merchandising* recommendation, not a claim about their stock. Take it to them and substitute their actual best sellers where they exist.

| # | Piece | Type | Symbol | Why it's in the launch set |
|---|---|---|---|---|
| 1 | Sankofa pendant necklace, adjustable chain | Necklace | Sankofa | The single most recognisable Adinkra symbol after Gye Nyame; strongest gift story |
| 2 | Gye Nyame pendant necklace | Necklace | Gye Nyame | Most-searched symbol; your default "first necklace" |
| 3 | Duafe ring, statement | Ring | Duafe | Gives you a hero product with ring sizing done properly, once |
| 4 | Akoma stud earrings | Earrings | Akoma | Lowest price point, cheapest gift, drives first-time buyers |
| 5 | Bese Saka adjustable bracelet | Bracelet | Bese Saka | One-size → no sizing friction, good upsell next to #1 |
| 6 | Dwennimmen signet ring | Ring | Dwennimmen | Unisex; opens the male gifting market you probably don't serve yet |
| 7 | Adinkrahene stacking ring set (3) | Ring (set) | Adinkrahene | A bundle, so you learn how multi-item carts behave before you have 40 SKUs |
| 8 | Nkyinkyim hoop earrings | Earrings | Nkyinkyim | Second earring at a different shape/price — tests whether hoops or studs sell |
| 9 | "Five Symbols" layered necklace | Necklace | Multi | Your emotional hero. Five meanings in one piece — the best product to photograph and to gift |
| 10 | Necklace + earring gift set, boxed | Set | Sankofa / Akoma | Sets are where jewellery margin lives; also the only piece that needs packaging photography |

Three necklaces, two earrings, one bracelet, three ring listings, one set. Every type is exercised, so the rest of the catalogue is repetition rather than discovery.

**Price architecture** — replace these bands with their real numbers; the *structure* is what matters:

| Band | Role | Suggested share of catalogue |
|---|---|---|
| Entry — earrings, simple pendants | Wins the first order | 30% |
| Core — necklaces, bracelets | Where most revenue comes from | 50% |
| Statement — ring sets, layered pieces, gift sets | Makes the brand look expensive; sells at gifting occasions | 20% |

Most boutiques over-weight the entry band and end up looking cheap. The statement pieces are what make the entry pieces read as affordable rather than as the whole brand.

**Everything else gets archived.** 470 imported products in front of a boutique reads as scraped inventory. Ten to twenty curated pieces reads as a brand.

---

## 2. Taxonomy and attributes — exact values

**Product categories** (Products → Categories). Delete `diamond`, `silver`, `classic-ring`, `trending-rings`, `luxry-watch`.

```
Necklaces
Earrings
Bracelets
Rings
Sets & Gifts
```

**Attributes** (Products → Attributes):

| Attribute | Slug | Values | Used for |
|---|---|---|---|
| Symbol | `pa_symbol` | Gye Nyame · Sankofa · Duafe · Akoma · Bese Saka · Dwennimmen · Adinkrahene · Nkyinkyim · Nsaa · Eban · Nkonsonkonson · Odo Nnyew Fie Kwan | Filter, and the product page story |
| Ring size | `pa_ring-size` | UK sizes — see §3 | Variable rings only |
| Material | `pa_material` | Brass · Gold-plated · Sterling silver · Beaded | Care instructions |
| Chain length | `pa_chain-length` | 16" · 18" · 20" · Adjustable | Necklaces |
| Colour | `pa_colour` | per piece | Swatches |

Tick **"Enable archives"** on Symbol only. Symbol pages (`/symbol/sankofa/`) then become real landing pages — that's your SEO play, and it's free.

**"Shop by occasion"** — *Everyday · Occasion · Gifting · Bridal* — should be **cross-category links or an Elementor collection block, not a fourth nav axis.** Four menus on a ten-product store is how a shop feels emptier than it is.

---

## 3. Ring sizing

Rings need a size guide before they need a product page. Two ways customers measure:

1. **Existing ring** — measure the inner diameter in mm, look it up
2. **Finger** — wrap paper/string, mark, measure the circumference

Publish a UK chart (UK sizing is standard in Ghana — **confirm against their actual manufacturer**, since tolerance varies by supplier):

| UK | Circumference (mm, approx) |
|---|---|
| L | 51 |
| N | 54 |
| P | 56 |
| R | 59 |
| T | 61 |
| V | 64 |
| X | 67 |
| Z | 69 |

Practical rules for the site:

- Offer **half sizes or "made to order"** on the statement rings — resizing a finished Adinkra ring is not always possible
- Say **"if between sizes, size up"** on the product page
- Rings are the one item where a wrong size means a return, so put the guide *in a tab on the ring page*, not only in the footer

---

## 4. Wholesale — the decision

Both retail and wholesale, Ghana-first, one site. Three ways, and the choice is about how much complexity you want in the product page:

| | How it works | Cost | Verdict |
|---|---|---|---|
| **A. Role-based trade pricing** | A `wholesale_customer` role; approved accounts log in and see trade prices. Guests see retail | free–$150/yr (B2BKing free tier, or Wholesale Suite) | **Recommended.** One catalogue, two prices, no duplicate products |
| **B. Hidden catalogue** | Prices hidden for guests entirely; everything is "enquire" | free | Kills retail. Rejected |
| **C. Line sheet + form** | PDF price list behind a wholesale enquiry form (CF7), invoiced manually | free | Ship this on day one even if you also do A |

**Recommendation: A, with C running underneath.** B2BKing's free tier covers wholesale roles and role-based pricing; **verify it covers minimum order quantities before committing** — if MOQ is behind the paid tier, either pay for it or drop MOQ and enforce it by conversation. Don't let a plugin's paywall decide your commercial terms.

**What to set:**

- **Trade price = 50% of retail** to start. Standard, easy to explain, leaves room for their own margin.
- **MOQ = 6 per style**, assorted sizes on rings. Low enough that a small Accra boutique can open an account; high enough to be worth packing.
- Wholesale accounts are **approved manually** — `Users → Add New` with the wholesale role, or a registration form that lands in a queue. Never auto-approve; that's how trade prices leak.
- **Hide trade prices from Google** — no `?wholesale` URLs, no cached price tables. This is the main reason A beats a public second price.

⚠️ **MOQ + ring sizes interact badly** if you let customers pick 6 of each size. Set MOQ per *style* and let them specify the size breakdown in the order notes.

---

## 5. Shipping — Ghana only, structured for later

**Zones** (WooCommerce → Settings → Shipping):

| Zone | Method | Rate |
|---|---|---|
| **Accra** | Flat rate (same-day rider where possible) | their real fee |
| **Other regions** | Flat rate, courier | their real fee |
| Rest of world | **leave inactive** | — |

Set the international zone up but **disabled**. It costs nothing and means "we ship abroad now" is a checkbox and a rate, not a rebuild.

**Shipping classes** to create now — `Earrings (light)`, `Necklace (light)`, `Ring set (boxed)`. You won't use them for flat rates in Ghana, but they're exactly what weight-based DHL pricing needs later.

**Payment** (WooCommerce → Settings → Payments):

| Gateway | Status | Notes |
|---|---|---|
| **Paystack** | test mode now, live at launch | MTN MoMo, Telecel Cash, AirtelTigo, cards — this is how Ghana pays |
| **Direct bank transfer**, relabelled "Mobile Money transfer" | on | Instructions + their MoMo number. Zero integration, works today, unblocks launch before Paystack onboarding clears |
| **Cash on delivery** | Accra only, **cap at a low order value** | Jewellery is high-value and resaleable. COD above a threshold is how you get robbed politely |

Keep **no live keys** on the review site, as already planned.

---

## 6. The eleven symbol meanings — draft copy

The whole strategic argument for this site is that the symbol *is* the product. Here's a starting draft for the product-page block; **have the client confirm the wording**, since they may use a house interpretation.

| Symbol | Meaning (one line) | Product-page line |
|---|---|---|
| **Gye Nyame** | "Except for God" — the supremacy of the divine | *Wear the reminder that nothing happens outside God's knowledge.* |
| **Sankofa** | The bird looking back — go back and fetch what was lost | *Carry where you come from into where you're going.* |
| **Duafe** | The wooden comb — beauty, care, femininity | *A symbol of beauty that is looked after, not just worn.* |
| **Akoma** | The heart — patience, tolerance, endurance | *For the days that ask for patience.* |
| **Bese Saka** | The sack of cola nuts — abundance and unity | *Abundance shared is abundance kept.* |
| **Dwennimmen** | Ram's horns — humility together with strength | *Strength that doesn't need to announce itself.* |
| **Adinkrahene** | Chief of all Adinkra symbols — leadership, greatness | *The symbol all other symbols answer to.* |
| **Nkyinkyim** | The twisting — initiative, adaptability, versatility | *For the ones who change shape and keep going.* |
| **Nsaa** | Hand-woven blanket — quality, excellence | *Excellence is a standard, not a finish.* |
| **Eban** | The fence — safety, security | *Home, worn close.* |
| **Nkonsonkonson** | Chain links — unity, community | *We are held together.* |

Note *Odo Nnyew Fie Kwan* — "love never loses its way home" — is the strongest bridal/gifting symbol of the set if they do wedding pieces.

---

## 7. Order of work

Do it in this order; each step depends on the one above.

1. **Finish the P0 fixes already found** — coming-soon off, menu off `/shop-2/`, the `vecurosoft` replace. The site should look right before it changes shape.
2. **Attributes and categories** (§2) — create them before products, so nothing gets retyped
3. **Shipping zones + payment** (§5) — including the Mobile Money transfer gateway, which unblocks real orders immediately
4. **The ten products** (§1) — one at a time, with the symbol block and care text on each
5. **Ring size guide** (§3) as a page *and* a product tab
6. **Wholesale** (§4) — role, trade prices, MOQ, approval queue
7. **Homepage rebuild** — their words, not the demo's: *"Elegant jewellery for every occasion"*, symbol-led, statement pieces in the hero
8. **Prune and menu** — archive the demo products, build Home / Shop / Symbols / Wholesale / About / Contact
9. **Test order end to end** — add to cart → checkout → confirmation email → order in admin. Then a *wholesale* test order to prove trade pricing and MOQ behave
10. **Password on, link sent**

Step 9 has two halves for a reason. Wholesale pricing is the thing most likely to be wrong in a way nobody notices until a trade customer sees retail prices, or a retail customer sees trade ones.

---

## 8. Still outstanding from the client

- Real product photos — 20–40 pieces, plain background, 1200 px+
- Prices in GHS for the ten, and their real delivery fees for Accra and the regions
- Confirmation of the symbol meanings in §6, or their own house wording
- Wholesale terms: their intended MOQ and trade discount (my defaults: 6 units, 50%)
- Paystack/Hubtel merchant details, or "test mode until launch"
- WhatsApp business number
- Logo in vector, plus a white version
- Business registration, address and phone for the footer
- Returns policy — **earrings are usually non-returnable for hygiene**; confirm their position before publishing one
