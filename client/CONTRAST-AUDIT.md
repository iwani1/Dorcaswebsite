# Full text-visibility audit

**Question asked:** every word must be readable; no background colour or image may
stop a customer reading text.
**Live:** 2026-10-31 · child theme 1.8.4 · page inventory from the site's own REST API.

---

## 1. The headline finding

The light mode shipped on the home page **did not break the home page**. It broke
**every other page**, because the parent theme is written for a black site and two
of its defaults are fatal on a white ground:

```css
/* parent: assets/css/style.css */
.h1, h1 … .h6, h6 { color: var(--white-color); }   /* #FFFFFF */
body, p, a        { color: var(--smoke-color); }   /* #D3CBBB in this child */
```

| Text | Colour | On | Ratio | Verdict |
|---|---|---|---|---|
| Every heading in the theme's templates | `#FFFFFF` | white page | **1.00:1** | invisible |
| Every heading | `#FFFFFF` | linen band | **1.06:1** | invisible |
| Body copy, paragraphs, links | `#D3CBBB` | white page | **1.61:1** | invisible |
| Body copy | `#D3CBBB` | linen band | **1.52:1** | invisible |
| Breadcrumb text | `#BDBBBA` | white page | **1.91:1** | invisible |
| Pagination | `#B0ACAC` | white page | **2.25:1** | invisible |
| `--gray-color2` small print | `#A7A7A7` | white page | **2.41:1** | fails |
| `--gray-color3` small print | `#7D7C7C` | white page | **4.16:1** | fails AA |

This is not "low contrast". At 1.00:1 the text is the same colour as the paper.

The home page escaped it only because every colour there is set inside Elementor
and overridden in `brand-light.css`. Every page **not** built in Elementor — the
shop, a product, the cart, the checkout, the account area, the policy pages, the
FAQ, the blog — is rendered by those theme defaults.

## 2. Pages affected

The site has **22 pages**. Sorted by how they are built:

| Page | ID | Built with | Text risk in light mode |
|---|---|---|---|
| Home | 25 | Elementor (template 1628) | **covered** by `brand-light.css` |
| Shop | 6 | WooCommerce template | headings + prices: **broken before 1.8.5** |
| Product (×10) | — | WooCommerce template | title, price, tabs, reviews: **broken** |
| Cart | 7 | WooCommerce shortcode | table, coupons: **broken** |
| Checkout | 8 | WooCommerce shortcode | form labels, fields: **broken** |
| My account | 9 | WooCommerce shortcode | login/register form: **broken** |
| Wholesale | 908 | Elementor | own colours, unverified |
| FAQ's | 1048 | Elementor or template | headings at risk |
| Contact | 29 | Elementor | own colours, unverified |
| About | 901 | Elementor | own colours, unverified |
| Symbols | 907 | Elementor | own colours, unverified |
| Size guide | 1498 | template/Elementor | unknown |
| Shipping, Returns, Privacy | 903, 904, 905 | template (page content) | headings + body: **broken** |
| Wishlist | 17, 496 | plugin template | unknown |
| Duplicates | 1434–1436, 1497, 12, 2 | demo copies | should be deleted |

## 3. What 1.8.5 changes

Everything below is scoped to `body.qd-light`, so turning the light layer off
restores the dark site exactly as it was.

| Fix | Mechanism |
|---|---|
| Body copy, paragraphs, links | `--smoke-color` and the `--text-color*` family → `#3F4A49` (**9.18:1**) |
| Small print | `--gray-color1/2/3` → `#6C665A` / `#524E47` (**5.70:1**) |
| Pagination | `--pagi-text-color` → `#524E47` |
| Footer text | `--footer-text-color` → `#6C665A` |
| Rules and dividers | `--vs-border-color*` → `#E6E1D5` |
| Headings in theme templates | teal `#0B4B4C` (**9.88:1**), scoped to `.woocommerce`, `.page--item`, `.entry-content`, `.faq-area`, `.blog`, `.sidebar` — **not** blanket, because Elementor pages set their own colours and some still sit on dark bands |
| Form fields | white ground, ink text, visible borders, visible placeholders |
| Hero | explicitly kept white — the hero field is teal, white on it is **9.88:1** |
| Top bar | linen with ink text, so the small print is not lost when `--smoke-color` darkens |

Two things deliberately **not** touched:

- **The breadcrumb band.** The theme paints it with a background image and white
  type on top. Colouring those headings dark would have been the same mistake
  inverted — I cannot see the image, so I left the band alone.
- **Elementor pages other than the home page.** Their colours live in inline CSS
  I cannot read from here. A blanket rule could turn a white heading dark on a
  dark band. They are listed above as *unverified*, not as *fine*.

## 4. Already measured and fixed earlier

| Item | Ratio |
|---|---|
| Orange veil `#CF6D0333` behind "Our work", white title | 3.59:1 → **removed** in 1.8.3 |
| Home page section titles on linen | 9.32:1 |
| Home page body copy on linen | 8.66:1 |
| Home page eyebrow / emphasised word | 4.61:1 (AA) |
| Header menu on teal | 9.88:1 |
| Dropdown items on white | 16.44:1 |

## 5. What I need from a screen

Four things I cannot settle from here, in the order they matter:

1. **The shop page** — product titles and prices. If they are teal now, 1.8.5
   worked.
2. **A product page** — the title, the price, the tabs, the trade line.
3. **The cart and the checkout** — labels and field text are the highest-stakes
   text on the site, and they are the ones most likely to be styled by a plugin
   rather than the theme.
4. **The wholesale, contact and about pages** — these are Elementor and I have
   reason to think they carry their own dark bands. If a heading is dark on dark,
   send that page and I will scope the rule away from it.

## 6. The method, stated plainly

Contrast ratios are arithmetic on values read from the live stylesheets — the
theme's own `style.css`, the child theme's tokens, and the Elementor CSS files
WordPress generates per post. That part is exact.

What it is **not** is a render. I cannot see a pixel of the site, so I cannot tell
you whether a photograph behind a heading is dark at the top left, or whether a
plugin injects its own colours at runtime. Those are the gaps §5 exists to close.
