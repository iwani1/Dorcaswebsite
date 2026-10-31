# Wholesale purchasing

Trade customers log in, see trade prices, and order under a minimum — no plugin, no second shop.

Shipped in **child theme 1.3.0**. Nothing to configure to switch it on; it starts working the moment the theme is updated.

---

## How it behaves

| | Retail visitor | Approved trade customer |
|---|---|---|
| Price shown | Retail, e.g. `₵320.00` | Trade, e.g. `₵160.00` |
| Sale prices | Normal WooCommerce behaviour | Suppressed — the trade price is the agreement |
| Quantity field | 1 | **6**, stepping by 6 |
| Add to cart | Normal | Refused below 6 units per style |
| Order value | No minimum | No minimum unless you set one |

The three numbers live at the top of `wp-content/themes/luxrio-child/inc/wholesale.php`:

```php
define( 'QUEENDOR_WHOLESALE_DISCOUNT',   0.5 );  // trade = 50% of retail
define( 'QUEENDOR_WHOLESALE_MIN_QTY',    6 );    // units per style
define( 'QUEENDOR_WHOLESALE_MIN_ORDER',  0 );    // 0 = no minimum order value
```

Change one, save, done. `0.6` is a 40% trade discount, `0.4` is 60%. A minimum order value is in the shop's currency — `500` for ₵500.

Trade prices are computed **only** for users holding the role. A retail visitor's page never contains the trade number — it isn't hidden with CSS, it's never calculated.

---

## The workflow

### 1. A business applies

On the **My Account** page → *Register* tab, the form now has:

- ☑ **Apply for a wholesale account**
- Business name *(required if ticked)*
- Business phone *(required if ticked)*
- Town or city

The account is created as an ordinary customer — no trade prices yet — and you get an email at the admin address.

### 2. You approve

`Users → All Users` → new column **Wholesale**. Each row shows `Pending`, `Retail` or `Approved`, with an **Approve** or **Revoke** link.

- **Approve** → the account becomes *Wholesale customer*, trade prices apply on their next login, and they're emailed.
- **Revoke** → back to a normal customer.

Approval is manual by design. Nothing about price is granted until a human decides.

### 3. They order

Normal checkout, Paystack or whatever gateway is live. The trade price is what gets charged, and the order records it.

---

## Setup checklist

1. **Update the child theme to 1.3.0** — `Appearance → Themes → Add New → Upload` → `luxrio-child-1.3.0.zip`. The existing theme is replaced; settings are untouched.
2. **Turn registration on** — `WooCommerce → Settings → Accounts & Privacy` → *Allow customers to create an account*. Without this, there's no form to apply through.
3. **Check your email works** — applications and approvals both send mail. If SMTP isn't configured, they land in spam and you'll never know someone applied.
4. **Test with a real account**: register with the wholesale box ticked, approve yourself from `Users`, log in, open a product. The price should halve and the quantity field should show 6.

### Don't test as the administrator

Admins don't get trade prices automatically — deliberately, since you'd then see only one price and couldn't check the retail site. Use a second account with the wholesale role.

---

## Paying online

Wholesale orders go through the normal checkout and the normal gateway — Paystack, card or mobile money. There is no invoicing, no net-30, no deposit step. A trade customer who orders six units pays for six units at the trade price, there and then.

Two consequences worth knowing.

**Staff cannot tell a trade order from a pricing mistake.** A ₵160 line on a product listed at ₵320 looks like someone broke the shop. So every trade order now:

- gets an internal order note — *"Wholesale account: trade pricing applied (50% off retail)"*
- shows a **Trade** badge in the orders list (a new column)
- carries an *Account: Wholesale* line in the order emails, to both customer and staff

**The gateway fee is a percentage, so it scales with the order — and your minimum already protects you.** With a ₵180 product at 50% off, the smallest legal trade line is 6 × ₵90 = **₵540**. At roughly 2% plus a small fixed fee, that's about ₵11 of processing on ₵540 — around 2% of margin, which is the cost of doing business.

A minimum order value is therefore **not** needed: the per-style minimum of six already puts the floor at about ₵540, because the cheapest piece in the catalogue is the ₵180 earring. If you ever add a ₵40 item, that floor drops to ₵120 and a minimum order value starts to matter — set `QUEENDOR_WHOLESALE_MIN_ORDER` then, not before.

### One choice still open

Trade orders can be cancelled like any other, but a **refund** on a wholesale order needs care: refunding the trade price is correct, refunding the retail price would give back money that was never charged. WooCommerce refunds the amount paid, so this is already right — just check the amount on the first refund you issue.

## Two things that will bite if you skip them

**Clear the cart after approval.** WooCommerce stores the price at the moment an item is added. A customer who filled a cart as retail, then got approved, keeps retail prices in that cart until they empty it.

**Caching.** The module sets `DONOTCACHEPAGE` for trade customers. Without it, a page rendered for a logged-in wholesaler could be cached and served to the public with trade prices on it — the standard way trade pricing leaks. If you ever add a CDN, make sure it respects those constants, or exclude logged-in users there too.

---

## What this deliberately doesn't do

- **No second currency, no per-product trade price fields.** Trade is a percentage of retail. If particular styles need different trade prices, that's a field per product and a change here — say the word.
- **No tiered pricing** (25+ at one rate, 50+ at another). It's a single trade price.
- **No net terms or invoicing.** Confirmed: wholesalers pay online at checkout, like retail customers.
- **No trade-only catalogue.** Trade customers see the same products, at trade prices.

---

## Ghana notes

- Prices are in **GHS**; trade percentages don't care about currency.
- If a wholesaler orders 6 units of one style and 6 of another, that's two lines and both pass. The rule is *per style*, not per order.
- Wholesale deliveries usually go by courier rather than rider — worth a separate shipping class when the shipping zones get set up.
