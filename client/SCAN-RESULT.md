# The scan worked — here is what it told me, and 1.3.0

## First: the good news, and one thing you need to know

Your scan is proof the plugin ran. It reported **only three pages** with blanks. Before
the run there were seven, with about twenty placeholders across them — including
`nathan@lushviewhotel.net` on four pages. All of that is gone from the database.

**But the public pages are still serving the old copy from cache.** I checked by adding
`?nc=1` to the URL, which bypasses the cache:

| URL | Result |
|---|---|
| `/terms/` | still shows `nathan@lushviewhotel.net`, `[BUSINESS ADDRESS]`, `[PHONE NUMBER]` |
| `/terms/?nc=1` | **correct** — `info@queendorhouse.com`, **+233 54 636 9625**, **Haatso, Accra, Ghana** |
| `/returns-exchanges/` | no cancellation clause |
| `/returns-exchanges/?nc=1` | **the full cancellation clause, with your email and phone** |

So the writes landed. The "Clear the cache" button did **not** reach LiteSpeed — the
site is being cached by the server, not by a WordPress plugin, so a WordPress action
cannot flush it.

### How to flush it for real — 1 minute

**cPanel → LiteSpeed Web Cache Manager → Flush All.** Or, if your host shows a
*LiteSpeed Cache* box on the cPanel home page, open it and press **Flush All**.

If there is no such icon: open a support ticket — *"Please purge the LiteSpeed page
cache for queendorfashionhouse.com."* It is a one-line request and they do it instantly.

Until that is done, **every visitor sees the old pages**, including Faith.

---

## What your scan found

| Page | Left over | Verdict |
|---|---|---|
| **Terms** | `[REGISTRATION NUMBER]` ×1 | Only you can fill it — see below |
| **Wholesale** | `______` ×4 | **Fixed in 1.3.0.** The old wholesale block is still in the page behind the new one: *Minimum order: ___ pieces per style · Lead time: ___ working days · Terms: ___ · Wholesale enquiries: ___* |
| **Shipping & Delivery** | `GH₵ ____` ×3, `______` ×4 | **You must give me four numbers** — see below |

Two more things the scan could not see, which I found by reading the pages:

1. **`[PHONE NUMBER]` in Terms §1 survived the fix** because the editor had put a line
   break inside it — `[PHONE` ↵ `NUMBER]` — so the search never matched. 1.3.0 matches
   across the break. (The one in §13 *was* replaced, which is why the page looked
   half-fixed.)
2. **The footer never appeared.** The output-buffer method I used did not survive your
   theme's own buffering. 1.3.0 prints it from `wp_footer` instead, which the theme must
   fire — its side cart depends on it.

---

## 1.3.0 does three more things

| Button (already in Run all fixes) | What changed |
|---|---|
| Fill the blanks | Matches placeholders even when the editor broke them over a line; fills the four Wholesale blanks |
| The footer | Prints from `wp_footer`, so it actually renders |
| Scan | Normalises whitespace first, so it stops reporting a placeholder that is only broken by a line break |

**Wholesale values I used** — correct them if they are wrong:
6 pieces per style · lead time **ten working days** · terms **50% of the retail price,
paid online at checkout before dispatch** · enquiries **info@queendorhouse.com ·
+233 54 636 9625**.

---

## What only you can do — four numbers and one number

### 1. The four delivery figures

Pages → **Shipping & Delivery** → Edit, and replace each blank:

- Accra, dispatch rider: `GH₵ ______`
- Other regions, courier: `GH₵ ______`
- Free delivery within Accra over: `GH₵ ______`
- Made-to-order pieces take: `______ working days`

### 2. The registration number

Pages → **Terms and Conditions** → Edit → section 1, `[REGISTRATION NUMBER]`.

If the business is not registered, delete the words *"a business registered in Ghana
under registration number […]"* and leave *"operated by Queen Dor's Fashion House, with
its address at Haatso, Accra, Ghana"*. Paystack accepts sole traders; it does not accept
a placeholder.

---

## Then

1. Upload and activate **1.3.0**, press **Run all fixes**.
2. **Flush LiteSpeed from cPanel** (above). This is the step that makes any of it visible.
3. Open `/terms/` in a private window. No brackets except the registration number.
4. Scroll to the bottom of any page. The teal footer should be there.
5. Fill the four shipping numbers, flush the cache again.
6. Send me the new scan. It should say **"no brackets left"** or name only the
   registration number.
