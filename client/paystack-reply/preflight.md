# Before you reply to Faith — 45 minutes, in this order

I checked the live site against every point in her email. **Sending the reply now
would fail on the first bullet**, because the pages she will open are the ones that
are still unfinished:

| What she asked for | What she will find today |
|---|---|
| "terms of service" | ✅ `/terms/` exists — but it is **full of `[REGISTERED BUSINESS NAME]`, `[DATE]`, `[EMAIL ADDRESS]`** and still contains the line *"Delete whichever does not apply"* |
| "refund and cancellation policy" | ⚠ `/returns-exchanges/` is written, but there is **no cancellation policy** at all |
| "shipping policy" | 🔴 `/shipping-delivery/` — **every price is `GH₵ ____`** |
| "FAQs" | 🔴 `/faqs/` — still lorem ipsum (*"Waters one you'll creeping?"*) |
| "customer feedback" | 🔴 no reviews section anywhere |
| "a variety of sections" | 🔴 **the footer renders nothing** — no page links to any policy page |
| "full extent of your business activities" | ⚠ 9 of 10 products have **no photograph** |

Not one of those is hard. Every fix is a paste, and all the copy is in the pack you
already downloaded.

---

## 1. Finish the Terms page (15 min)

Open `https://queendorfashionhouse.com/terms/` → Edit → replace **every** bracketed
item:

| Placeholder | Replace with |
|---|---|
| `[DATE]` | today's date |
| `[REGISTERED BUSINESS NAME]` | exactly as on the business certificate |
| `[REGISTRATION NUMBER]` | the registration number |
| `[BUSINESS ADDRESS, ACCRA, GHANA]` | the real address |
| `[EMAIL ADDRESS]` | a mailbox someone reads |
| `[PHONE NUMBER]` | a number someone answers |
| `[NUMBER] working days` | your refund window — 5 is normal |
| `[Delete whichever does not apply: …]` | **delete the whole sentence**, keep one VAT line |

Then publish. **Search the page for `[` afterwards — there must be no square brackets
left anywhere.**

## 2. Finish the Shipping page (10 min)

Replace the three blanks on `/shipping-delivery/` with real prices, and the
made-to-order lead time. Then set the same numbers in **WooCommerce → Settings →
Shipping** so the page and the checkout agree.

## 3. Add the cancellation policy (5 min)

Paystack asked for "refund **and cancellation**" — the site only has returns. Paste
the clause from `cancellation-policy.md` into `/returns-exchanges/`, and a one-line
reference into Terms §7.

## 4. Replace the FAQ page (10 min)

Paste `content/faqs.html` over the demo accordion on `/faqs/`.

## 5. Assign the footer (5 min)

Theme Options → Footer → trigger **Footer Builder** → select **Queen Dor's Footer**.
Without it, none of the pages above is linked from anywhere, and a reviewer has to
guess the URLs.

## 6. Turn on customer feedback (5 min)

WooCommerce → Settings → Products → **Enable product reviews**. Then, once you have
a handful of real reviews, paste `reviews-section.html` on the home page.

Do **not** invent testimonials. A reviewer who finds fake reviews treats it as a
trust problem, and so does a customer.

---

## Then send the reply

`email-reply.md`, one answer per bullet, in her order.
