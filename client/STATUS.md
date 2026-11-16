# Status — the site is nearly there

Checked live, after your scan came back clean.

## What is now done

| ✓ | Evidence from the live site |
|---|---|
| **Footer on every page** | Teal footer with Shop / Help / Talk to us, the Paystack line and the four policy links — on every page I opened |
| **Terms** | No brackets. `info@queendorhouse.com`, **+233 54 636 9625**, Haatso, Accra. The registration sentence was removed cleanly |
| **Returns & Exchanges** | Full **Cancelling an order** section with how-to-cancel, refusal of parcel, made-to-order, refund timing and contact details |
| **Privacy Policy** | Real email, correct URL |
| **Contact** | Real phone, email, studio, opening hours |
| **FAQs** | 16 questions, hotel email gone |
| **Wholesale** | Four blanks filled — 6 pieces per style, ten working days, 50% of retail paid online, enquiries with email and phone |
| **Shipping** | Free-delivery threshold and made-to-order days filled |
| **Sample refund policy** | Gone |
| **Duplicates** | Trashed |

---

## Four things still open

### 1. The home page is still Luxrio's demo in one band 🔴

Under *"CUSTOM Jewelry"* the page still repeats **Limited Edition · 20 Product**,
**Diamond Pendant · 06 Product** and **Luna Rosa · 20 Product**, one image still served
from `wordpress.vecurosoft.com`.

The top of the page is yours now — hero, wholesale band, *For the shop*, *For the gift*,
products — so this is the last demo block.

**Fix:** Tools → Queen Dor's Fixes → **Preview the home page** (reads it, changes
nothing) → **Clean the home page**. It backs the layout up first; **Restore the home
page** undoes it.

### 2. The menu lost Shop and My account 🔴

The header is now four items: *Jewelry House · Wholesale · Contact · FAQ's*. Shop and My
account disappeared because their menu items pointed at `shop-2` and `my-account-2`,
which the duplicate clean-up trashed — and a trashed page takes its menu item with it.

A shop whose header has no **Shop** link is a conversion problem, not a cosmetic one.

**Fix in 1.4.0** — Trim the menu now re-adds Shop, Wholesale, Contact, FAQ's and My
account against the canonical pages.

### 3. The shipping cost column reads "Estimated by Delivery service" 🟡

Not a price, and not a sentence. **Fixed in 1.4.0** → *"Calculated at checkout"*, which
is what actually happens.

### 4. Two numbers look wrong — please confirm 🟡

- **Free delivery over GH₵ 5000.** Your pieces are ₵180–₵650. A customer would have to
  buy nine or ten pieces before free delivery ever applies. If you meant **₵500**, say so
  and I will change it.
- **Made to order: 2–3 working days** on Shipping, but the FAQ says **five working
  days**. Pick one — the FAQ is the promise a customer reads before ordering.

---

## Do this now — three minutes

1. Upload **`queendor-fix-1.7.0.zip`**, activate, **Run all fixes**.
   It restores the menu and fixes the shipping wording.
2. **Preview the home page**, then **Clean the home page**. Look at the site. Wrong?
   **Restore the home page**.
3. Flush the cache again (cPanel → *LiteSpeed Web Cache Manager* → **Flush All**) —
   every change is invisible until you do.

---

## What is left after that

| Item | Who |
|---|---|
| Free-delivery threshold and made-to-order days | **You** — confirm the two numbers above |
| Nine product photographs | **You** — `client/PHOTO-REQUEST.md` has the shot list |
| Old domain in the cart drawer (`blaharbenyah.com`) | **You** — Tools → Queen Dor's Cleanup → **section 6 only** |
| Paystack reply | Ready in `paystack-reply/email-reply.md`; point Faith at **`/terms/`** and **`/returns-exchanges/`**, both of which now work |
| Form A, proof of purchase, unit counts | **You** — nothing on the site holds these |

---

## The line to remember before you write to Faith

The three things she asked for and could not find — a terms page, a refund and
cancellation policy, and a footer that links them — **all exist now and all load at the
address she will type.** Send her this:

- Terms: `https://queendorfashionhouse.com/terms/`
- Returns and cancellation: `https://queendorfashionhouse.com/returns-exchanges/`
- Privacy: `https://queendorfashionhouse.com/privacy-policy/`
- Contact: `https://queendorfashionhouse.com/contact/`
