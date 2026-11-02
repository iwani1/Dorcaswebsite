# The footer — markup, template, and how to switch it on

Right now **the footer renders nothing on every page of the site.** It is not a
styling problem: the theme has a footer slot, the slot is empty, and it stays empty
until something is selected in the theme options.

That single setting is why four of the six Paystack pages already existed and no
customer could reach one.

| File | What it is |
|---|---|
| `queendor-footer.html` | the markup — paste into an Elementor **HTML** widget |
| `queendor-footer-elementor.json` | the same markup as an importable Elementor template |
| `queendor-footer.css` | already inside theme **1.8.8**, wired up in `inc/brand-colours.php` |

---

## How the theme decides what to put there

From `wp-content/themes/luxrio/inc/hooks/hooks-functions.php`, the footer content
comes from a hook that reads exactly two theme options:

```php
$luxrio_footer_builder_trigger = luxrio_opt( 'luxrio_footer_builder_trigger' ); // must be 'footer_builder'
$luxrio_global_footer_select   = get_post( luxrio_opt( 'luxrio_footer_builder_select' ) );
echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_post->ID );
```

If `luxrio_footer_builder_trigger` is anything other than `footer_builder`, the
theme falls back to `luxrio_footer_global_option()`, which prints **only a
copyright strip** — and if `luxrio_copyright_text` is empty, that strip is empty
too. Which is the page you are looking at now: nothing.

So there are two steps, not one: **create something to render**, then **point the
option at it**. Neither alone does anything.

---

## Route A — import the template (fastest)

1. **Templates → Saved Templates → Import Templates →** choose
   `queendor-footer-elementor.json` → **Import**.
2. It appears in the list as **Queen Dor's Footer**.
3. **Theme Options → Footer** (the Luxrio/Redux panel, not the WordPress customiser):
   - *Footer Builder* trigger → **Footer Builder**
   - *Select Footer* → **Queen Dor's Footer**
4. **Save Changes.**
5. Reload any page and scroll to the bottom.

## Route B — build it by hand (if the import misbehaves)

1. **Pages → Add New**, call it **Footer** (it will never be linked or visited —
   it is only a container), and **Edit with Elementor**.
2. Drag an **HTML** widget into the canvas.
3. Paste the whole of `queendor-footer.html` in — including the top comment is fine.
4. **Publish**, note the page.
5. **Theme Options → Footer** → trigger **Footer Builder**, select **Footer**, Save.

Route B is also the one to use if your Elementor refuses the JSON — the file is a
plain page-type template so it should import anywhere, but a hand-built page always
works.

---

## Then fill in the brackets

The markup carries placeholders on purpose:

| Placeholder | Fill with |
|---|---|
| `[STREET ADDRESS], [AREA]` | the real business address |
| `[PHONE NUMBER]` | in both the visible text *and* the `tel:` link |
| `[EMAIL ADDRESS]` | in both the visible text *and* the `mailto:` link |
| `[9:00–17:00]`, `[10:00–14:00]` | real opening hours, or delete the line |
| `[REGISTERED BUSINESS NAME]`, `[NUMBER]` | as on the Registrar General certificate |

These must be **identical** to the Contact page, the Terms page and the Paystack
account. A footer address that disagrees with the Terms page is exactly the kind of
thing a payment review flags.

---

## What is in it, and why

- **Brand column** — the name, one line about what the shop is, and Instagram. This
  is the "official name" Paystack asks for, in the place every visitor ends up.
- **Shop** — All jewellery, Wholesale, The symbols, Size guide.
- **Help** — Contact, FAQs, Shipping & delivery, Returns & refunds, My account.
- **Talk to us** — address, phone, email, opening hours. Paystack requires an
  address on the site; this is where it lives on every page.
- **Payment strip** — "Secure payment by Paystack — Visa · Mastercard · MTN MoMo ·
  Telecel Cash · AirtelTigo", plus the reassurance that card details are never
  stored here.
- **Bottom bar** — registered name, registration number, address, and the four
  legal links (Terms · Privacy · Returns · Delivery).

Deliberately **not** included: category links (`/product-category/…` slugs have never
been verified — they would 404), WhatsApp ordering, and any payment logo image
(Paystack supplies brand assets; do not redraw them).

---

## Colours, measured

| Pairing | Ratio |
|---|---|
| Linen `#FAF8F5` text on teal `#0B4B4C` | **9.88:1** — AAA |
| White `#FFFFFF` business name on teal | **11.3:1** |
| Gold `#C8AC77` column headings on teal | **4.53:1** — AA |

The gold is only used for the small uppercase column headings, never for body copy,
because 4.53 is a pass but not a comfortable one for a paragraph.

---

## After the footer is on

1. The six Paystack pages become **reachable** — the footer is the only thing
   linking them on non-checkout pages.
2. Run the site through **a real phone** once. The footer is a four-column grid that
   collapses to two at 980px and one at 620px; check it does not look cramped on a
   small screen.
3. Consider enabling the theme's copyright strip as well — the CSS hides it when our
   footer is directly above it, so it will not double up.
