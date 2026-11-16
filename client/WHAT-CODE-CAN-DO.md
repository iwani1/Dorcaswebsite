# The split: what code fixes, what only you can

Writing a child-theme module is faster than clicking through Elementor when the problem is *behaviour* — a wrong link, a missing price, a rule. It's no faster than clicking when the problem is *the page itself*, because the page's content lives in the Elementor document and only the editor changes that.

This page is the honest boundary, and the running list of what's left.

---

## Already done in code

| What | Version |
|---|---|
| Rebrand — footer credit, placeholder site name, admin labels | 1.2.0 |
| Trade pricing, minimum order, approval workflow | 1.3.0 |
| Trade orders marked for staff | 1.3.1 |
| Wholesale band on the home page, trade line on product pages, application form | 1.4.0 |
| **Every demo link repaired** — see below | 1.5.0 |

### 1.5.0 — the links

| Was | Now |
|---|---|
| `wordpress.vecurosoft.com/luxrio/shop/` (left the site entirely) | `/shop/` |
| `wordpress.vecurosoft.com/luxrio/contact/` | `/contact/` |
| `.../404page` in the menu | `/` |
| `/shop-2/` · `/cart-2/` · `/checkout-2/` · `/my-account-2/` | `/shop/` · `/cart/` · `/checkout/` · `/my-account/` |
| Instagram strip → `instagram.com` | `@queendor_fashionhouse` |
| `GHC 300.00` | `₵300.00` |

Nothing is written into your database — the rewrite happens on the way to the browser, in menus, Elementor widgets and page content. **Each rule retires itself**: once the real link is stored, the string it looks for is gone and it does nothing.

To stop the currency normalisation: `add_filter( 'queendor_normalise_currency', '__return_false' );`

---

## Only you can do these

These are page structure and content. No amount of code changes them safely, because a filter that rewrote your Elementor document would fight you the next time you opened the editor.

| Left to do | Where | Time |
|---|---|---|
| Delete the fake testimonial block (*"Vivi Marian, Google Ceo"*, lorem ipsum) | Home page → Elementor | 2 min |
| Replace the 12 duplicated category tiles (3 designs × 4, all linking to `#`) | Home page → Elementor | 15 min |
| Put a real product grid where "best selling" renders nothing | Home page → Elementor → Products widget | 5 min |
| Rewrite the watch copy — "High Class Timekeepers", "customize wrist jewelry", *"tjari watch business solution"* | Home page → Elementor | 20 min |
| Fix "Best **Luxry** Jewelry" | Hero slide 2 | 1 min |
| Add the **Wholesale** menu item and rename "Jewelry House" | Appearance → Menus | 3 min |
| Upload the 9 product images to their products | Products | 20 min |
| Shipping zones, Paystack keys, SMTP | WooCommerce / host | 45 min |

That's roughly **two hours**, and every one of them is a decision only the client can make — which products are "best selling", what the testimonials say, what replaces the watch copy.

---

## What I can still do in code, if you want it

| Idea | Why it's worth it |
|---|---|
| **Hide the footer Instagram strip** entirely until the client's account is wired up | It currently shows five identical images |
| **A noindex switch** for the staging URL, so Google never indexes `/dorcas/` | Audit item 25 — currently nothing stops it |
| **Replace the fake testimonials with real ones**, if the client supplies two quotes | Same trick as the wholesale band |
| **A product grid injected after the hero** — a real one, with the nine photographed pieces | Only if you'd rather not touch Elementor |
| **Order-tracking and support links in the top bar** pointed at real pages | Those three are still demo |

Say which and I'll build it the same way — one version, one upload.
