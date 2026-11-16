# Moving to `queendorfashionhouse.com`

**Situation:** the shop currently answers at `https://www.blaharbenyah.com/dorcas/`.
The domain is registered **and** hosted at GreenGeeks, and the shop is its own
addon domain in cPanel with its own document root. That combination is the easy
case: no registrar change, no nameserver propagation wait, and — if you do it the
way below — **not a single file moves.**

**Why now rather than at launch:** Elementor writes absolute URLs into its page
data, and Paystack, SMTP and canonical tags are all keyed to the domain. Every
page built on the old URL is work to re-point later. Doing it now costs an
afternoon; doing it at the end costs a full re-test of everything.

**What does not change:** the child theme has no reference to the old domain.
`inc/demo-links.php` rewrites every demo URL through `home_url()`, so the theme
follows the domain by itself.

---

## 0. Back up first — 10 minutes, do not skip

cPanel → **File → Backup** (or **JetBackup** if it is in the sidebar):

1. *Download a Full Account Backup* — this is the one you actually want.
2. Separately: cPanel → **phpMyAdmin** → select the shop's database → **Export**
   → Go → save the `.sql` file to your computer. The full backup can be awkward
   to restore a single table from; this one is not.

If anything below goes wrong, step 9 puts you back exactly here.

---

## 1. Confirm the domain is attached to this hosting account

GreenGeeks is both registrar and host, so there is no nameserver to change — the
domain only needs its DNS zone on this account.

1. cPanel → **Domains**.
2. Look for `queendorfashionhouse.com`. If it is already listed → go to step 3.
3. If it is **not** listed → cPanel → **Domains → Create A New Domain** → enter
   `queendorfashionhouse.com`. It will be created with a default document root;
   you will point it somewhere else in step 3.

Because the registrar and host are the same company, this usually resolves in
**minutes**, not hours. If the domain shows a GreenGeeks parking page after 30
minutes, the DNS zone exists but the document root is the default one — step 3
fixes the page.

---

## 2. Note where the shop actually lives

cPanel → **Domains**. Find the row whose domain is the `dorcas` addon (or
subdomain) and read its **Document Root**. It will look like:

```
/home/YOURUSER/public_html/dorcas
```

Write it down exactly. That folder is the whole website — files, `wp-config.php`,
uploads — and it stays exactly where it is.

---

## 3. Point the new domain at that folder

cPanel → **Domains** → the `queendorfashionhouse.com` row → **Manage** (or
**Create A New Domain** if it is not there yet) → set **Document Root** to the
path from step 2, e.g. `/home/YOURUSER/public_html/dorcas` → **Submit**.

cPanel will warn that the document root is already in use. **That warning is the
plan** — two domains serving one folder is exactly what a staged domain move is.
Accept it.

> **If cPanel refuses** (some builds do), do this instead:
> 1. Domains → the `dorcas` row → Manage → change its document root to
>    `/home/YOURUSER/public_html/_dorcas-old` (create the folder in File Manager
>    as an empty directory first). **Do not tick anything that says delete files.**
> 2. Now create `queendorfashionhouse.com` with the original `…/public_html/dorcas`
>    path. It will be accepted because nothing else claims it.

At this point `https://queendorfashionhouse.com` loads the site — over plain HTTP,
possibly with a certificate warning, and with every link still pointing at
blaharbenyah. That is expected; the next step fixes it.

---

## 4. Switch WordPress to the new address

**Do this in `wp-config.php`, not only in the admin.** Settings → General can lock
you out of the dashboard if the new URL is not live yet; the constants cannot,
because they apply before anything else loads.

File Manager → `public_html/dorcas/wp-config.php` → Edit. Find the line that says
`/* That's all, stop editing! Happy publishing. */` and add **above** it:

```php
define( 'WP_HOME',    'https://queendorfashionhouse.com' );
define( 'WP_SITEURL', 'https://queendorfashionhouse.com' );
```

Save. Log in at `https://queendorfashionhouse.com/wp-admin` (you will be asked for
the password again — that is the cookie changing domain, not a problem).

> If step 3 got stuck and the new domain is not resolving yet, **stop here** and
> come back. Do not add these two lines while the old address is the only working
> one.

---

## 5. Rewrite the old URLs in the database

Install **Better Search Replace** (Plugins → Add New). Then Tools → **Better
Search Replace**:

| Field | Value |
|---|---|
| Search for | `https://www.blaharbenyah.com/dorcas` |
| Replace with | `https://queendorfashionhouse.com` |
| Select tables | all of them (use *Select All*) |
| Run as dry run | **ticked** |

Run it. It reports how many rows *would* change — expect a few hundred. Then untick
dry run and run it again.

Also run a second pass for the same string without `www.`:

| Search for | `https://blaharbenyah.com/dorcas` |
|---|---|
| Replace with | `https://queendorfashionhouse.com` |

This is a **URL** search-replace. It is not the `Luxrio → Queen Dor's` rename that
was ruled out; a domain move cannot be done without one, because Elementor,
WooCommerce and the media library all store full addresses in the database.

---

## 6. Flush what WordPress caches

1. **Settings → Permalinks → Save Changes** (no edits needed — saving rebuilds the
   rewrite rules).
2. **Elementor → Tools → Regenerate Files & Data** → both switches on → **Save
   Changes**. Then open the home page in Elementor and press **Update** once.
3. **LiteSpeed Cache → Toolbox → Purge All** (GreenGeeks runs LiteSpeed).

---

## 7. Certificate and forced HTTPS

1. cPanel → **Security → SSL/TLS Status** → tick `queendorfashionhouse.com` and
   `www.queendorfashionhouse.com` → **Run AutoSSL**. It normally finishes in a
   couple of minutes; AutoSSL also runs nightly if you would rather wait.
2. cPanel → **Domains** → toggle **Force HTTPS Redirect** on for the new domain.

Paystack will not process a live payment over plain HTTP, and Chrome will brand
the site "Not secure" without this. Confirm the padlock before moving on.

---

## 8. Send the old address to the new one

Because both domains serve the **same folder**, a blanket redirect in `.htaccess`
would loop forever. The rule must fire only when the request arrives under the old
hostname.

File Manager → `/home/YOURUSER/public_html/dorcas/.htaccess` → Edit → add at the
**very top**, above `# BEGIN WordPress`:

```apache
# Old address -> new domain, during the move
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTP_HOST} ^(www\.)?blaharbenyah\.com$ [NC]
RewriteRule ^(.*)$ https://queendorfashionhouse.com/$1 [R=301,L]
</IfModule>
```

Test: `https://www.blaharbenyah.com/dorcas/shop/` should now land on
`https://queendorfashionhouse.com/shop/` with a 301, and the new domain itself must
still load normally.

Leave the old addon domain in place for a month so the redirect keeps working,
then remove it from cPanel → Domains.

---

## 9. Rollback, if it goes wrong

1. Remove the two `define()` lines from `wp-config.php`.
2. cPanel → Domains → remove `queendorfashionhouse.com`.
3. Restore the database from the `.sql` file in step 0 (phpMyAdmin → Import), and
   the files from the full backup if needed.
4. Purge LiteSpeed.

The site is back on `blaharbenyah.com/dorcas` exactly as it was.

---

## 10. Now that the domain is real — the gates that block launch

These are not domain problems, but the domain is what makes them visible to
customers, so they belong on the same list.

- [ ] **Email.** cPanel → **Email Accounts** → create `orders@queendorfashionhouse.com`.
      Then cPanel → **Email Deliverability** → **Repair** on the domain (writes SPF
      and DKIM). Set it as the WooCommerce "From" address, configure SMTP, and place
      a real test order — **order email has never been tested**.
- [ ] **Paystack.** Live keys, callback/webhook URL set to the new domain, then a ₵1
      order placed and refunded with a real card.
- [ ] **Footer template** — still unassigned; every page is missing its trust strip.
- [ ] **Nine products without photographs** — the home page is still 85% empty frames.
- [ ] **Font Awesome licence** — a legal gate, not a technical one.
- [ ] **13 assets still loading from `wordpress.vecurosoft.com`** — they die with the
      demo server.
- [ ] **Re-import the home page** with `elementor-1628-home-page-queendorfashionhouse.json`
      (in the repo root), whose 13 links already point at the new domain.
- [ ] Keep **Settings → Reading → Discourage search engines** on and the site
      **password-protected** until launch; both come off the same day.
- [ ] Launch day: Google Search Console, `sitemap.xml`, and remove the password.

---

## Post-move test list

| Page | What to check |
|---|---|
| `/` | header teal, no white seam, hero renders, products have prices |
| `/shop/` | product **titles readable** (this was the 1.00:1 failure) |
| a product page | description, add-to-cart, image |
| `/cart/` → `/checkout/` | fields readable, totals correct |
| `/my-account/` | login form usable |
| `/wholesale/` | the 50% tier applies at 6 units |
| `/contact/` | form submits **and arrives by email** |
| any page | padlock present, no mixed-content warnings in the console |
| view source | no `blaharbenyah`, no `vecurosoft` |
