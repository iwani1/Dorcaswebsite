# The Paystack page set — six drafts, ready to edit

Every page Paystack's Merchant Services Agreement (Section B) requires a merchant
to publish, written as paste-ready copy. They are **drafts**: each has square
brackets for the details only the client can supply, and an *Editor's notes* section
at the bottom that is **not part of the page** — delete it before publishing.

| # | File | Page title | Slug | Paystack requirement it satisfies |
|---|---|---|---|---|
| 1 | `1-terms-and-conditions.md` | Terms and Conditions | `/terms/` | "all legally required information" |
| 2 | `2-returns-and-refunds.md` | Returns and Refunds | `/returns-exchanges/` | "merchandise return and refund policy" |
| 3 | `3-delivery-policy.md` | Shipping & Delivery | `/shipping-delivery/` | "delivery policy" |
| 4 | `4-privacy-policy.md` | Privacy Policy | `/privacy-policy/` | "your consumer data protection policy" |
| 5 | `5-contact.md` | Contact | `/contact/` | "customer service contact information, including email address and/or telephone number" + "address" |
| 6 | `6-about-the-business.md` | About Us | `/about/` | "your official name" + "complete description of the goods sold and services offered" |

Plus the **footer**, which is not a page: it must carry the official name, address,
phone and email, and links to pages 1–5, on every page of the site.

---

## Fill these in once, and they appear everywhere

Search each file for `[` and replace:

| Placeholder | What goes there |
|---|---|
| `[REGISTERED BUSINESS NAME]` | exactly as on the Registrar General certificate |
| `[NUMBER]` / `[REGISTRATION NUMBER]` | the business registration number |
| `[STREET ADDRESS], [AREA]` | a real address in Accra — a home address is fine |
| `[EMAIL ADDRESS]` | a mailbox somebody actually reads |
| `[PHONE NUMBER]` | a number somebody actually answers |
| `[DATE]` | the day you publish |
| `[X]`, `[Y]`, `[Z]`, `[AMOUNT]` | real delivery prices |

The client's **name, address, phone and email must be identical** in the footer, on
the Contact page, in the Terms and on the Paystack account. Reviewers compare them.

---

## Or import all six at once

`client/queendor-paystack-pages.wxr` is the same six pages, already converted to
HTML, ready to import as **drafts** in one step:

**Tools → Import → WordPress → Install Now → Run Importer →** choose the `.wxr` →
**Download and import file attachments** does not matter (there are none) → Submit.

You get six drafts, already titled, already at the right slugs. Fill in the brackets
in each, check it, and publish.

Two notes:

- The drafts contain the page copy **without** the editor's notes — those stay in
  the markdown files.
- `/returns-exchanges/`, `/shipping-delivery/` and `/contact/` already exist on the
  site, so WordPress will import those three as `-2` duplicates rather than
  replacing them. Copy the new text into the existing page, then trash the
  imported draft. `terms`, `privacy-policy` and `about` are new and can simply be
  published.

## How to publish one

1. **Pages → Add New.** Title from the table above.
2. Paste the body text — in Elementor, use a **Text Editor** widget (or the
   WordPress editor, then edit with Elementor if the page needs the site header
   design).
3. Set the **slug** from the table (Elementor/WordPress: the *Permalink* field under
   the title).
4. Headings: make the section titles `H2`, not bold paragraphs — it helps both
   readers and Google.
5. Publish, then **add the page to the footer** (Appearance → Widgets, or the Footer
   Builder template).
6. Delete the *Editor's notes* section at the bottom of the file.

Two pages already exist under slightly wrong addresses — `/privacy-policy-2/` and
`/about-2/`. Rename them rather than creating duplicates, otherwise the site ends up
with two of everything, which is exactly what a compliance review reads as
"unfinished".

---

## Why the footer is the blocker, not the pages

Four of these pages already existed before this bundle. None of them was reachable
from any page of the site, because **the footer template was never assigned**. A
reviewer who opens the home page and scrolls to the bottom finds nothing — no name,
no address, no policy links.

Assign the footer first. Then publishing the pages is worth something.

---

## Order of work

1. Assign the **footer template** (WordPress → Appearance → or the theme's Footer
   Builder) with name, address, phone, email and the links.
2. Publish **Contact** and **About** — the two with the details a reviewer checks
   first.
3. Publish **Terms**, **Returns**, **Delivery**, **Privacy**.
4. Fill in the delivery prices in the page **and** in WooCommerce → Settings →
   Shipping.
5. Rename `/privacy-policy-2/` → `/privacy-policy/`, `/about-2/` → `/about/`; trash
   the duplicate pages (`shop-2`, `cart-2`, `checkout-2`, `contact-2`,
   `wishlist-2`, `sample-page`).
6. Then Paystack: test mode → test order → activation request. See
   `../PAYSTACK-SETUP.md`.

---

## One legal note

This is drafted to be accurate for a Ghanaian jewellery retailer and to satisfy
Paystack's published requirements. It is not legal advice. Have a Ghanaian lawyer
read the Terms and the Privacy Policy once — particularly the liability section and
the data-protection registration question — before the site takes live payments.
