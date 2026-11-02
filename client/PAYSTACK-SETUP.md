# Paystack — what they require, and how to switch it on

Written against the live site as it stands on 2 November 2026, after the move to
`queendorfashionhouse.com`.

---

## 1. What Paystack actually requires on the website

Not folklore — it is in their Merchant Services Agreement, Section B, verbatim:

> You are also required to provide on your website the following information to a
> Cardholder for every Transaction: Your official name, complete description of
> the goods sold and services offered, merchandise return and refund policy,
> customer service contact information, including email address and/or telephone
> number, address, delivery policy, your consumer data protection policy and all
> legally required information to be provided to the Cardholder.

Translated into pages, and checked against the site today:

| Paystack requires | Where it lives | Status |
|---|---|---|
| **Official name** | footer, Contact, Terms | ✗ **footer renders nothing on any page** |
| **Description of goods** | Home, Shop, product pages | ✓ exists — but 9 of 10 products have no photograph |
| **Return & refund policy** | `/returns-exchanges/` | ✓ page exists — not linked anywhere |
| **Customer service contact** (email *and/or* phone) | `/contact/` | ✓ page exists — verify the details are real |
| **Address** | footer, Contact, Terms | ✗ not on the site at all |
| **Delivery policy** | `/shipping-delivery/` | ⚠ exists but **every price is a blank** (`GH₵ ____`) |
| **Consumer data protection policy** | `/privacy-policy-2/` | ✓ exists — but the URL literally says "2" |
| **All legally required information** | Terms & Conditions | ✗ **no such page — `/terms/` is a 404** |

Two of these are hard blockers: **there is no Terms page**, and **the footer is
unassigned**, which means none of the policy pages is reachable from any page of
the site. A reviewer opening the home page cannot find a single one of them.

The Terms page copy is in `client/terms-and-conditions.md` — fill in the bracketed
details and paste it into a new page at `/terms/`.

---

## 2. Test mode works today; live mode needs KYC

You can process test transactions the moment you have an account — no documents,
no approval. What unlocks **live** payments is business verification, and in Ghana
it is these five things:

| Document | Where it comes from |
|---|---|
| Business registration certificate (or Certificate of Incorporation) | Registrar General's Department / ORC portal |
| GRA TIN certificate | Ghana Revenue Authority |
| Ghana Card of the owner / directors | yourself |
| Ghanaian bank account, in the business or owner's name | any commercial bank |
| Business address | whatever you registered |

Confirm the exact list in your Paystack dashboard once you start the activation
request — it can change, and it asks for some of these as uploads rather than
fields.

**The name on the Paystack account, the name on the business certificate and the
name on the website must all match.** A mismatch between what the site sells and
what the account is registered for is one of the most common reasons an
application stalls.

---

## 3. The technical setup — WooCommerce

Assumes WooCommerce is installed and the site is on HTTPS (confirm the padlock on
`https://queendorfashionhouse.com` before starting; Paystack will not run over
plain HTTP).

**1. Currency.** WooCommerce → Settings → General → Currency must be
**Ghana cedi (GH₵)**. It already is.

**2. Install the gateway.** Plugins → Add New → search **Paystack** → the plugin by
*Paystack* (`paystack-woocommerce` / "Paystack WooCommerce Payment Gateway") →
Install → Activate. Do not use a third-party fork.

**3. Enable it.** WooCommerce → Settings → Payments → **Paystack** → toggle on →
**Manage**.

**4. Keys.** In your Paystack dashboard: **Settings → API Keys & Webhooks**. Turn
*Test mode* on at the top of the dashboard, copy the **test public key** and **test
secret key** into the plugin, and leave **Test Mode** ticked in the plugin.

**5. Webhook.** The plugin's settings page shows a webhook URL. Copy it into the
Paystack dashboard → **Settings → API Keys & Webhooks → Webhook URL**.
**Test and live webhooks are separate** — you will do this twice. Without it, an
order can be paid but left sitting as "pending" in WooCommerce.

**6. Payment channels.** In the same dashboard section, enable both **Card** and
**Mobile Money (MTN MoMo, Telecel Cash, AirtelTigo)**. Mobile money — not cards —
is how most Ghanaian customers will pay. Leaving it off halves your orders.

**7. Test one order end to end.** Paystack's test card, from their own docs:

```
Card     4084 0840 8408 4081
Expiry   any future date
CVV      408
PIN      0000
OTP      123456
```

Then check, in this order:

- [ ] Order appears in WooCommerce → Orders
- [ ] Status moves to **Processing**, not stuck on *Pending payment*
- [ ] Stock reduced by one
- [ ] **The order confirmation email arrives** — this has never been tested
- [ ] Refund it from the Paystack dashboard and confirm it shows as refunded

**8. Go live.** Paste the **live** public and secret keys, untick Test Mode, and set
the **live** webhook. Then place one real ₵1 order with a real card or MoMo number
and refund it. That is the only test that proves settlement works.

---

## 4. What will fail a review today

Beyond the missing Terms page and the empty footer:

| Problem | Why it matters to a reviewer |
|---|---|
| **9 of 10 products have no image** | the site must show "a complete description of the goods" |
| **Delivery fees are blanks** on `/shipping-delivery/` | an incomplete delivery policy is not a policy |
| **`/privacy-policy-2/`** in the address bar | looks unfinished; rename to `/privacy-policy/` |
| **Demo leftovers**: "CUSTOM Jewelry", *Limited Edition · 20 Product*, cards linking to `#` | reads as an unfinished or template site |
| **"Add to Wishlist" twice** on every product | same |
| **Side-cart assets still loading from `blaharbenyah.com`** | mixed domains in a payment review |
| **Duplicate pages live**: `shop-2`, `cart-2`, `checkout-2`, `contact-2`, `wishlist-2`, `sample-page` | two of everything, one of them broken |
| **Sitemap 500s** (`/sitemap.xml`, `/sitemap_index.xml` both error) | the SEO plugin's sitemap needs regenerating |
| **No contact address anywhere** | required in the list above |

---

## 5. After go-live

- **Settlement** goes to the bank account on the account, on Paystack's schedule —
  it is shown in your dashboard, and it can start on a reserve while you are new.
- **Refunds** are issued *by you* from the Paystack dashboard; Paystack never
  refunds on your behalf and does not refund its own processing fee.
- **Disputes** — Paystack's terms put a 45-day limit on claims against them, but a
  customer can dispute a card payment for longer. Answer disputes inside the
  dashboard with the order receipt; ignoring them loses them automatically.
- Keep the **order email** working. It is the evidence you send in every dispute.

---

## 6. Order of operations

1. Create the **Terms and Conditions** page from `client/terms-and-conditions.md`
   and fill in the bracketed details.
2. Assign the **footer template** and put Terms · Returns · Shipping · Privacy ·
   Contact in it. This one step makes every policy reachable from every page.
3. Fill in the **delivery prices** and the **contact details** (phone, email,
   address).
4. Rename `/privacy-policy-2/` → `/privacy-policy/`, trash the duplicate pages.
5. Photograph the nine products without images, or hide them until you have.
6. Install and configure Paystack in **test mode**, place a test order, refund it.
7. Start the **activation request** in Paystack and upload the five documents.
8. When it is approved: live keys, live webhook, one real ₵1 order, refund it.
9. Untick *Discourage search engines*, submit the sitemap, tell the client.
