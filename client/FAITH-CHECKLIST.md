# Faith's seven points — checked against the live site

Activation request **2087034** · checked page by page today.

## Verdict

**Four of the seven are done. One is done but empty. Two need documents only you have.**

Nothing on the site is now a reason for rejection. What is left is paperwork and three
small visible gaps.

| # | Faith asked for | Status | Evidence / what is left |
|---|---|---|---|
| 1 | Website showing the **full extent of business activity** — FAQs, customer feedback, about, terms, refund **and cancellation** policy, a variety of sections | 🟡 **5 of 6** | See the breakdown below |
| 2 | Is stock **held or dropshipped**? | ✅ answer ready | `paystack-reply/email-reply.md` §2. Not yet sent |
| 3 | **Delivery timeline** | ✅ on the site | `/shipping-delivery/` — Accra 1–2 days by rider, other regions 2–4 by courier |
| 4 | **Link to refund and shipping policy** | ✅ live | `/returns-exchanges/` (with cancellation) and `/shipping-delivery/`. Send the URLs |
| 5 | **List of items in stock** | 🟡 drafted | `paystack-reply/stock-list.csv` — 10 SKUs, prices and trade prices filled; **unit counts blank** |
| 6 | **Proof of purchase / supplier invoice** | 🔴 yours | Invoices for components: findings, chains, boxes. Nothing on the site can answer this |
| 7 | **Form A, completed** | 🔴 yours | This is what held the review last time |

---

## Point 1, opened up

She listed six things under "full extent of business activity". Checked live:

| What she named | Live now | |
|---|---|---|
| **FAQs** | `/faqs/` — 16 real questions across Ordering, Delivery, Returns, The jewellery, Wholesale. No lorem ipsum | ✅ |
| **Terms of service** | `/terms/` — 14 sections, no brackets, real email, phone and address | ✅ |
| **Refund policy** | `/returns-exchanges/` — 7-day window, earrings excluded, faulty items, who pays return delivery | ✅ |
| **Cancellation policy** | **`/returns-exchanges/` → "Cancelling an order"** — before dispatch, after dispatch, made-to-order, refund timing, contact details | ✅ new |
| **About** | `/about/` — live | ✅ |
| **Customer feedback** | Product reviews are **switched on** ("Reviews (0)", "Be the first to review" works). **There are zero reviews**, and there is no feedback section on the home page | 🟡 |
| **A variety of sections** | Footer now on every page with Shop, Help, Talk to us, the Paystack line and Terms · Privacy · Returns · Delivery links | ✅ new |

Publishing your **legal name, a goods description, a returns and refund policy, contact
email/phone, a physical address, a delivery policy and a data-protection policy** is what
Paystack's merchant agreement requires. All seven are now on the site and all seven are
reachable from the footer.

---

## The three visible gaps

### 1. Zero customer feedback

Reviews are enabled but nobody has left one. She asked for "customer feedback" and will
look for it.

**Do this:** message three customers who have bought from you, ask for one line and a
rating, and add them yourself via **Products → [product] → Reviews** (you can create a
review on a customer's behalf in WooCommerce → Comments). Three honest reviews beat a
fake testimonial wall, and a fake one is a trust problem with a customer as much as a
reviewer. Once you have them, `paystack-reply/reviews-section.html` puts a feed on the
home page.

### 2. Nine of ten products have no photograph

`/shop/` shows one image — Bese Saka — and nine grey "Awaiting product image" boxes. A
reviewer checking that you actually make and sell these pieces reads empty product
pages as a thin business.

**Do this:** photograph each piece on a plain pale background, square, and set it at
**Products → [product] → Product image**. `client/PHOTO-REQUEST.md` has the shot list.

### 3. Shipping costs read "Estimated by Delivery service"

Not a price, not a sentence. Fixed by **1.4.0** → *"Calculated at checkout"*, which is
what actually happens. Also in 1.4.0: Shop and My account return to the header menu.

---

## Two inconsistencies to settle before she reads them

| Where | Says | Also says |
|---|---|---|
| Free delivery | over **GH₵ 5000** | your pieces are ₵180–₵650 — nobody reaches ₵5000. Did you mean ₵500? |
| Made to order | **2–3 working days** on Shipping | **five working days** in the FAQ |

A reviewer comparing two pages of the same site will spot either one.

---

## The order to do it in

1. **Upload `queendor-fix-1.4.0.zip`**, activate, **Run all fixes** → menu restored,
   shipping wording fixed.
2. **Home page → Preview → Clean** (the last demo band).
3. **Fill the unit counts** in `stock-list.csv` — ten numbers. Send them to me and I will
   rebuild the file.
4. **Photograph the nine pieces.**
5. **Collect three reviews.**
6. **Complete Form A** and gather the component invoices.
7. **Flush the cache**, then send `email-reply.md` — updated with the four URLs.

---

## What to put in the email

```
Terms of service        https://queendorfashionhouse.com/terms/
Refund & cancellation   https://queendorfashionhouse.com/returns-exchanges/
Shipping & delivery     https://queendorfashionhouse.com/shipping-delivery/
Privacy policy          https://queendorfashionhouse.com/privacy-policy/
FAQs                    https://queendorfashionhouse.com/faqs/
Contact                 https://queendorfashionhouse.com/contact/
Wholesale               https://queendorfashionhouse.com/wholesale/
```

Every one of those loads and reads correctly today. Six weeks ago not one of them would
have survived her opening it.
