# What next — the shortest path to "live"

The website is done. What is left is four things only you can supply, one button, and
two numbers. Total hands-on time: about ninety minutes, most of it photographing
jewellery.

---

## Do these in this order

### 1. One button, two minutes — the last demo band

**Tools → Queen Dor's Fixes → Preview the home page → Clean the home page.**

Under *"CUSTOM Jewelry"* the page still repeats *Limited Edition · 20 Product*,
*Diamond Pendant*, *Luna Rosa*, plus one image served from `vecurosoft.com`. Everything
above and below it is yours. The button backs the layout up, and **Restore the home page**
undoes it.

### 2. Two numbers, one minute — and only you can decide

| Where | Currently says | Question |
|---|---|---|
| Shipping | Free delivery over **GH₵ 5000** | Your pieces are ₵180–₵650. Nobody reaches ₵5000. Did you mean **₵500**? |
| Shipping vs FAQ | Made to order **2–3** days there, **five** in the FAQ | Pick one |

Tell me both and I change every page that mentions them, so they agree.

### 3. Ten numbers, ten minutes — the stock list

`paystack-reply/stock-list.csv` has all ten SKUs, retail prices and trade prices. The
**units held** column is empty. Faith asked for "the list of items in stock" — a list
without quantities does not answer it.

Send me ten numbers (or one line: "QD-001 4, QD-002 3…") and I finish the file as a
PDF-ready document.

### 4. Nine photographs, one hour — the biggest visible gap

`/shop/` shows **one** real image and nine grey "Awaiting product image" boxes. This is
the single thing that makes the shop look unfinished to a customer and thin to a
reviewer.

Plain pale background, square, one photograph per piece, plus one close-up if you have
it. **Products → [product] → Product image.** The shot list is in
`client/PHOTO-REQUEST.md`.

### 5. Three real reviews, one afternoon of waiting

Message three customers: *"Could you send me one line about your piece and a rating out
of five?"* Add each at **WooCommerce → Comments → Add comment** (rating 5, type Review,
tied to the product).

Then replace the three placeholder quotes on the home page — open the page in Elementor,
click the HTML widget, change three lines. **The email to Faith says the feedback is
real, so this has to be done before you send it.**

---

## Then the Paystack package — 30 minutes

| Item | Where |
|---|---|
| **Form A**, every page, signed | This is what held the review last time |
| **Component invoices** — findings, chains, boxes, packaging, in the business name | Photos or PDFs are fine |
| **Stock list** with unit counts | From step 3 |
| **The email** | `paystack-reply/email-reply.md` — updated, send-ready, seven links |

Send all of it in one message, in her numbered order.

---

## After activation — the launch test nobody has done yet

Once Paystack switches the account on, **buy something yourself**. This is the only step
where the site can still surprise you:

1. Add a piece to the cart, go to checkout, pay with a real card or MoMo.
2. Check that **the order confirmation email arrives** — to a customer's inbox, not just
   yours. If order emails are not leaving the server, every customer who pays disappears.
3. Check that the order appears in **WooCommerce → Orders** with the right amount.
4. Try one refund in the WooCommerce order screen, and confirm Paystack processes it.
5. Do it on a phone, on mobile data, not office wifi.

Anything that fails there is a 15-minute fix before customers meet it. Anything that
fails in front of a customer is a week.

---

## Small things, whenever

| Item | Where |
|---|---|
| Old domain in the cart drawer (`blaharbenyah.com`) | Tools → Queen Dor's Cleanup → **section 6 only** |
| Shop and My account back in the header | Already fixed in 1.6.0 — Trim the menu |
| Sitemap returns HTTP 500 | Ask hosting, or install a sitemap plugin. Low priority for Paystack, matters for Google |
| Duplicate pages in Pages → Trash | Empty the Trash once you are sure |

---

## The honest summary

**Nothing on the website is blocking a customer or a reviewer any more.** Every page
Faith named loads, reads correctly, and is linked from the footer. What is left is
evidence of a real trading business: quantities, invoices, a completed form, and nine
photographs of the things you sell.
