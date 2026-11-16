# Before you run the plugin — read this page

Everything below is either one button or one short step. Nothing here needs a developer.

---

# Part 1 — the plugin does it (4 minutes)

**Download:** `queendor-fix-1.4.0.zip`

1. **Plugins → Add New → Upload Plugin → Choose File** → `queendor-fix-1.4.0.zip` →
   **Install Now** → **Activate Plugin**.
2. **Tools → Queen Dor's Fixes**.
3. Press **Preview the home page**. Read the list — it changes nothing.
4. Press **Run all fixes**. Read the log.
5. Press **Scan for brackets**. Read the list. **Screenshot it and send it to me.**

"Run all fixes" does twelve things:

| ✓ | What |
|---|---|
| 1 | Clears the page cache (LiteSpeed, object cache, Elementor CSS) |
| 2 | Deletes **`nathan@lushviewhotel.net`** from the Terms, the Privacy Policy and both FAQ answers, replacing it with `info@queendorhouse.com` |
| 3 | Fills `[PHONE NUMBER]` with **+233 54 636 9625**, `[BUSINESS ADDRESS, ACCRA, GHANA]` with **Haatso, Accra, Ghana**, `[REGISTERED BUSINESS NAME]` with **Queen Dor's Fashion House** |
| 4 | Repairs the broken FAQ sentence and removes the stray `_Local pickup_` underscores |
| 5 | Fills the blank **Opening hours** with Mon–Fri 9:00–17:00, Sat 10:00–14:00 |
| 6 | Appends a full **cancellation clause** to `/returns-exchanges/`, with the real email and phone — the gap Paystack named |
| 7 | Adds the teal **footer** to every page, with policy links, payment line and contact details |
| 8 | Trims **Cart** and **Checkout** from the menu; re-adds Contact and FAQ's if missing |
| 9 | Adds the **symbols strip** to the front page |
| 10 | Moves the **13 duplicate pages** to Trash |
| 11 | Fixes both page slugs if they ever drift again |
| 12 | Prints what is still unfinished |

Then, separately: **Clean the home page** (after reading the preview). It backs the
layout up first; **Restore the home page** undoes it.

---

# Part 2 — only you can do these

## A. Four delivery prices — 5 minutes

**Pages → Shipping & Delivery → Edit.**

| Field on the page | What to type |
|---|---|
| Accra — *Cost* | your dispatch-rider price, e.g. `GH₵ 30` |
| Other regions — *Cost* | your courier price, e.g. `GH₵ 60` |
| *Free delivery on orders over* | the threshold, e.g. `GH₵ 800` |
| Made-to-order — *takes ___ working days* | e.g. `seven` |

Update, then **LiteSpeed Cache → Purge All**.

I will not make these numbers up: they are the prices a customer is charged, and a
reviewer comparing your site to your Paystack dashboard will see them.

## B. Registration number — 1 minute

**Pages → Terms and Conditions → Edit.** Find `[REGISTRATION NUMBER]` (section 1) and
type the number from your business registration certificate.

If you have not registered the business, delete the whole sentence *"a business
registered in Ghana under registration number […]"* — an unregistered sole trader is
fine for Paystack, a placeholder in a legal document is not.

## C. Nine product photographs — the biggest visual gap

The shop lists ten pieces and **nine show the grey WooCommerce placeholder**. Photograph
each piece on a plain pale background, upload at **Products → [product] → Product image**,
and make the first image square. `client/PHOTO-REQUEST.md` has the shot list.

## D. Old domain in the side cart — 1 minute

The cart drawer still loads three icons from `blaharbenyah.com/dorcas/`.

**Tools → Queen Dor's Cleanup → tick section 6 (old domain) → Run.** Do **not** tick
section 3 or section 5 — the new plugin already handles the duplicates, and section 3
is an unguarded checklist.

## E. Optional, once you are happy

- **Assign the real footer:** Theme Options → Footer → *Footer Builder* → **Queen Dor's
  Footer**. The plugin then stops printing its own on the next page load, and you can
  delete the plugin.
- **Empty the Trash:** Pages → Trash → Empty Trash, only after you have looked at the
  site and are sure nothing you wanted was in it.
- **Delete the plugin:** Plugins → Deactivate → Delete. Everything it changed stays.

---

# Part 3 — check it yourself (2 minutes)

Open each of these in a private window and look for the thing in the right-hand column:

| Open | You should see | Not |
|---|---|---|
| `/terms/` | "Last updated: …" and **no square brackets** | `[PHONE NUMBER]` |
| `/contact/` | phone, email, Haatso, opening hours | `_______` |
| `/privacy-policy/` | "Write to **info@queendorhouse.com**" | `nathan@lushviewhotel.net` |
| `/faqs/` | clean collection answer | `time., Accra, by appointment` |
| `/returns-exchanges/` | a **Cancelling an order** heading | nothing about cancellation |
| `/shipping-delivery/` | real prices | `GH₵ _______` |
| any page, scrolled to the bottom | the teal footer with Terms · Privacy · Returns · Delivery | empty space |
| `/refund_returns/` | the 404 page | "This is a sample page" |

---

# Part 4 — then reply to Paystack

Once Part 3 is clean, the reply to Faith is ready in
`paystack-reply/email-reply.md`. Two things to update before sending:

- point her at **`/terms/`** (it works now — it did not when the kit was written)
- point her at **`/returns-exchanges/`**, which now contains the cancellation clause

Request **2087034**. Still outstanding and not fixable by code: the completed **Form A**,
proof of purchase / supplier invoices, and real unit counts per product.
