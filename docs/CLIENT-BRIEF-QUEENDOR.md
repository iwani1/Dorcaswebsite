# Queen Dor's Fashion House — client profile and what it changes

**Source:** `instagram.com/queendor_fashionhouse` (supplied by you).
**Note:** Instagram returns 403 to unauthenticated requests and the handle isn't indexed anywhere I can reach, so **I could not read the profile**. Everything below about the brand's *product range* is flagged as needing confirmation. What is not in doubt is the category of business: a **fashion house**, not a jeweller.

---

## 1. The problem this creates

Luxrio is a **jewellery theme**, and the demo content is jewellery all the way down. From `luxrio-demo.xml`, the demo taxonomy is:

```
rings · wedding-ring · classic-ring · modern-ring · trending-rings · women-ring
woman-earring · necklace · pendent · padent · bracelate · luxry-watch
diamond · silver · green · pink · orange
```

And the live home page says: *"Necklace jewellery — HOLY JEWELRY and diamonds pendants"*, *"High Class Jewellery"*, *"Find the perfect High Class Jewellery"*.

So as it stands, the client opens their review link and sees **a diamond and watch shop bearing their name**. That is worse than showing them nothing.

This isn't a content-swap job. Four things are wrong at once:

| Layer | Demo has | Fashion house needs |
|---|---|---|
| Taxonomy | rings, earrings, bracelets | ready-to-wear, kaba & slit, bridal, occasion |
| Attributes | ring size, metal, stone colour | UK dress size, colour/print, fabric |
| Product model | fixed SKU | size/colour variations, made-to-measure, lead times |
| Imagery | macro shots of stones | full-look editorial on a model |

---

## 2. What survives — the case for keeping Luxrio

The **layout bones are genre-neutral** and genuinely suit a fashion label:

- Full-bleed hero slider — lookbook/campaign imagery
- Product grid with **4:5 portrait crops** — the standard fashion ratio
- Category tiles, lookbook/Instagram strip, testimonial slider, newsletter block
- Mega menu with room for Lookbook / Collections / Bespoke / About

That's an editorial fashion layout with jewellery copy layered on top. Keep the theme. Re-platforming now would throw away the WooCommerce 11.2.1 template merges, the Font Awesome Free swap and the 44 hardening fixes — for a cosmetic gain.

**One condition:** no jewellery word survives into the handover. Not in menus, not in the footer, not in an alt tag, not in an Elementor template still sitting in the library.

---

## 3. The catalogue model to build

**Categories** — replace the jewellery tree entirely:

```
Ready to Wear        → Dresses · Two-piece · Tops · Skirts
Kaba & Slit
Bridal / Traditional Bridal
Occasion & Evening
Bespoke (Made to Measure)
Accessories          → Headwraps · Bags
```

Confirm the real split with the client — a house that mainly does bridal has a very different homepage from one selling ready-to-wear.

**Attributes** (WooCommerce → Products → Attributes):

| Attribute | Values | Notes |
|---|---|---|
| `Size` | UK 6–20, **Made to measure** | confirm UK vs S/M/L — Ghana mostly uses UK |
| `Colour / Print` | per product | drives the swatches |
| `Fabric` | Kente · Ankara · Lace · Satin · Chiffon | useful filter, and shoppers search by fabric |

**Variation Swatches** is already installed, so size/colour selection renders as buttons rather than dropdowns. That was in the plugin list for a reason — it now does real work.

**Product types:**

- **Simple** — ready-to-wear, fixed price, stock count
- **Variable** — size × colour
- **Bespoke** — the one that needs a decision (see §4)

---

## 4. The decision that shapes the build: bespoke

A Ghanaian fashion house usually sells two things that behave nothing alike — ready-to-wear off the shelf, and made-to-measure with a 2–3 week production window. WooCommerce has no native concept of the second.

Three ways to do it, in ascending cost:

| Option | How | Cost | Trade-off |
|---|---|---|---|
| **A. Enquiry** | "Request this piece" button → Contact Form 7, prefilled with the product name | free | no checkout, no deposit, you quote manually |
| **B. Add-on fields** | PPOM for WooCommerce (free tier) or WooCommerce Product Add-ons ($49/yr) puts measurement fields on the product, carried into the cart | free–$49 | the real answer if bespoke is the core business |
| **C. Deposit** | 50% deposit product + balance invoice | paid plugin or manual | accounting complexity worth avoiding at launch |

**Recommendation: B for bespoke products, A as the fallback.** Measurements captured at the point of sale is what prevents the "that's not my size" conversation, which is the single most expensive failure mode in made-to-measure.

Whatever you pick, put the **production lead time on the product page** and set the item to backorder so it doesn't show "out of stock" while it's being made.

---

## 5. Ghana commerce setup — this is where the money is won or lost

**Payments.** Mobile Money is how Ghana pays online. A card-only checkout will convert a fraction of what a MoMo-enabled one does.

- **Paystack Ghana** — MTN MoMo, Telecel Cash, AirtelTigo Money, plus Visa/Mastercard. This is the default recommendation.
- **Hubtel** — strong local alternative, good MoMo coverage.
- **Pay on delivery** — normal and expected in Accra. Enable it for Accra only.

Until they have a merchant account, keep the review site in **test mode** as already planned.

**WhatsApp.** For a Ghanaian boutique, WhatsApp is not a nice-to-have — it's the primary sales channel, and a large share of buyers will message before they buy a dress. Add:

- A floating WhatsApp button (site-wide)
- "Order on WhatsApp" on each product, with the product name and price prefilled in the message

This runs *alongside* the cart, not instead of it. It also gives you a working sales channel on day one while the catalogue is still being filled.

**Delivery zones** — the jewellery-theme defaults are useless here:

| Zone | Method | Notes |
|---|---|---|
| Accra | flat rate / same-day rider | Yango Delivery, Bolt Send, or their own dispatch |
| Other regions | courier | Kumasi, Takoradi, Tamale etc. |
| International | DHL / courier | the diaspora market is real for Ghanaian labels — price it, don't leave it vague |

**Size guide.** Build **"How to measure"** as a real page with their actual sizing. For apparel this is the highest-leverage page on the site — it cuts returns and returns arguments more than any design choice will.

**Returns.** Apparel returns are not jewellery returns. Sensible default: exchange within 7 days, unworn with tags, **bespoke non-returnable**. State it plainly on the product page, not just in a policy buried in the footer.

**Privacy.** Ghana's Data Protection Act (Act 843) applies as soon as they collect names, addresses and phone numbers. The policy page must be real text, not the WordPress skeleton — and it names who holds the data.

---

## 6. Assets to collect from the client

Send this as one message; it's the critical path.

- [ ] Logo — vector (SVG/AI/PDF) **and** a white/light version. Not a screenshot from Instagram.
- [ ] Brand colours (hex) if defined, or the two or three colours from the logo
- [ ] **15–25 product photos**, portrait 4:5, minimum 1200 × 1500 px, model shots preferred over flat-lays
- [ ] Per product: name · price (GHS) · sizes available · colours/prints · fabric · ready-to-wear or made-to-measure
- [ ] 3–5 **lifestyle/campaign** images for the hero slider (wide, 1920 px+)
- [ ] Their size chart and how they measure (bust/waist/hips in inches or cm)
- [ ] Delivery fees: Accra / other regions / international
- [ ] Paystack or Hubtel merchant details (or "test mode for now")
- [ ] WhatsApp business number
- [ ] Business name, address, phone, and registration number for the footer
- [ ] Privacy policy + returns text (or authority to write a draft for their review)
- [ ] Instagram handle confirmed

---

## 7. Decisions I need from you

1. **Shop model** — full checkout, WhatsApp-enquiry catalogue, or both? (I'd say both.)
2. **Bespoke** — quote-only, or measurements captured at checkout with a deposit?
3. **Range** — ready-to-wear only, or RTW + bespoke + bridal?
4. **Copy** — do they write it, or do I draft from their Instagram captions for approval?

---

## 8. Revised build order — what changes from the build sheet

Two steps in `docs/LIVE-SITE-FIXES.md` are now **downgraded**:

- **§3 "Kill every `vecurosoft` reference"** — don't spend the time replacing hotlinked images you're about to delete. Fix only what survives: the footer newsletter icon, and replace the Instagram strip with their real feed or remove it. Everything else dies with the demo content.
- **§6 "Strip the demo content"** — promoted from "nice to have before launch" to **the next task**. The jewellery catalogue cannot be the first thing they see.

Revised order from here:

1. Get the asset list from §6 (blocks everything visual)
2. Rebuild taxonomy and attributes — categories, `Size`, `Colour`, `Fabric`
3. Build **one** real category end-to-end with 6 products (variable + one bespoke), including size guide and returns copy
4. Wire MoMo/Paystack in test mode + WhatsApp button
5. Only then strip the remaining demo pages and rebuild the menu
6. Review link with the directory password on

Building one category properly first is deliberate — six products expose every problem in the setup (variations, swatches, images, size guide, shipping class, returns) without you discovering them 40 products later.
