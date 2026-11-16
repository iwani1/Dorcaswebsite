# Live check — every page, current state

Re-read from `https://queendorfashionhouse.com` just now, page by page, against the
REST inventory. This is the state **before** the plugin runs.

## Headline

A lot changed since the last sweep and most of it is good: **Terms, Contact and Privacy
all load at their proper URLs now**, the sample refund policy is gone, and the menu is
clean. What is left is small, specific and mostly in one place.

**Two things are wrong that you would not spot by eye:**

1. **`nathan@lushviewhotel.net` is on the site** — in the Terms (§1 and §13), the Privacy
   Policy and twice in the FAQs. It is the WordPress admin address, a hotel domain, and
   it does not belong on a jewellery shop.
2. **The FAQ collection answer is broken.** A hand edit left:
   *"…and we will confirm a time., Accra, by appointment. Choose _Local pickup_ at checkout
   and wait for our message before coming.]"*

---

## Page by page

| # | Page | URL | Loads | State |
|---|---|---|---|---|
| 1 | Jewelry House | `/` | 200 | 🔴 still the Luxrio demo — *Limited Edition · 20 Product*, the vecurosoft image. No footer |
| 2 | Terms and Conditions | `/terms/` | **200 ✓** | 🟡 live and readable. Date, VAT sentence and "five working days" now correct. Still `[REGISTERED BUSINESS NAME]`, `[REGISTRATION NUMBER]`, `[BUSINESS ADDRESS, ACCRA, GHANA]`, `[PHONE NUMBER]` ×2, and the hotel email |
| 3 | Contact | `/contact/` | **200 ✓** | 🟡 right slug, real phone, real email, Haatso address. Only **Opening hours** is blank. Says "we answer faster on WhatsApp" |
| 4 | Privacy Policy | `/privacy-policy/` | **200 ✓** | 🟡 right slug, body good, hotel email in "Your rights" |
| 5 | FAQ's | `/faqs/` | **200 ✓** | 🟡 16 questions, good answers. Hotel email ×2, the mangled collection sentence, stray `_Local pickup_` underscores |
| 6 | Refund and Returns Policy | `/refund_returns/` | **404 ✓** | ✓ gone. Exactly right |
| 7 | Shipping & Delivery | `/shipping-delivery/` | 200 | 🔴 four blanks: Accra price, other-region price, free-delivery threshold, made-to-order days |
| 8 | Shipping & Delivery | `/shipping-delivery-2/`, `-3/` | 200 | 🔴 duplicates |
| 9 | Returns & Exchanges | `/returns-exchanges/` | 200 | 🔴 **no cancellation clause, no contact details** — the exact thing Paystack asked for |
| 10 | Returns & Exchanges | `/returns-exchanges-2/` | 200 | 🔴 duplicate |
| 11 | Symbols | `/symbols/`, `-2/` | 200 | ✓ good; the `-2` is a duplicate |
| 12 | Size Guide | `/size-guide/`, `-2/` | 200 | ✓ good; the `-2` is a duplicate |
| 13 | Wholesale | `/wholesale/`, `-2/` | 200 | ✓ good; the `-2` is a duplicate |
| 14 | About | `/about/`, `-2/` | 200 | ⚠ two copies, pick one |
| 15 | Shop | `/shop/`, `-2/` | 200 | ✓ 10 products, prices and SKUs correct. **9 of 10 have no photograph** |
| 16 | Cart | `/cart/`, `-2/` | 200 | ✓ works; the `-2` is a duplicate |
| 17 | Checkout | `/checkout/`, `-2/` | 200 | ✓ resolves; untested with an item in the cart |
| 18 | My account | `/my-account/`, `-2/` | 200 | ⚠ no register form |
| 19 | Wishlist | `/wishlist/`, `-2/` | 200 | ⚠ theme feature, two copies |
| 20 | Sample Page | `/sample-page/` | 200 | 🔴 WordPress default — delete |

---

## On every single page

| Item | State |
|---|---|
| **Footer** | 🔴 absent — every page ends at the side cart |
| **Side cart icons** | 🔴 still served from `www.blaharbenyah.com/dorcas/` |
| **Header menu** | ✓ six items, no Cart, no Checkout. Contact and FAQ's restored |
| **Logo** | ✓ real |
| **404 page** | ✓ good |

---

## What is left, and who does it

| Item | Who |
|---|---|
| Hotel email on four pages | **Plugin** (button: Fill the blanks) |
| Broken FAQ sentence | **Plugin** |
| Blank opening hours | **Plugin** (assumes Mon–Fri 9–17, Sat 10–14) |
| `[PHONE NUMBER]`, `[BUSINESS ADDRESS]`, `[REGISTERED BUSINESS NAME]` on Terms | **Plugin** — your phone and address are now known from the Contact page |
| `[REGISTRATION NUMBER]` on Terms | **You** — nothing on the site holds it |
| Four delivery blanks | **You** — they are prices, I will not invent them |
| No cancellation clause | **Plugin** (button: Add the cancellation clause) |
| No footer | **Plugin** — it prints one until the theme's is assigned |
| Demo home page | **Plugin** (Preview → Clean), then **you** for the real sections |
| 13 duplicate pages | **Plugin** (Trash the duplicates) |
| 9 products without photographs | **You** |
| Old domain in the side cart | **You** — cleanup plugin, section 6 |

Full instructions: **`DO-THIS-NOW.md`**.
