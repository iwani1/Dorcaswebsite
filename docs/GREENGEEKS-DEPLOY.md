# GreenGeeks deployment runbook — client review site

**Goal:** a working WordPress + Luxrio store on a temporary address, with SSL, that the client can browse and comment on — without touching the real domain yet.

**Time:** ~2–3 hours of active work, plus DNS/SSL waits.
**You need:** your GreenGeeks login, the three ZIPs from the downloads pane, and the client's email address.

---

## 0. Read this first — the temporary-domain reality on GreenGeeks

GreenGeeks shared hosting does **not** provide a usable temporary domain:

- The `http://server.greengeeks.net/~username` URL is documented by GreenGeeks as **Managed VPS only**. On shared it has **no SSL** and shows a browser warning, and cPanel's own "temporary domain" feature displays a *"technical domain, not for live use"* banner to every visitor. Not something to send a client.
- There is **no built-in staging** on GreenGeeks (unlike SiteGround/Kinsta), so "staging" here means a second domain or subdomain on the same account.

So pick one of these three:

| Option | Cost | SSL | Client-friendly | Best when |
|---|---|---|---|---|
| **A. Use the real domain from day one** ⭐ | $0 extra | Yes | ✅ | You've chosen/bought the domain and can keep it `noindex` + password-protected until launch |
| **B. Buy a throwaway staging domain** | ~$10–12/yr | Yes | ✅ | You don't have the real domain yet, or don't want the real one "used" before launch |
| **C. Subdomain of a domain you already own** | $0 | Yes | ✅ | You already host another domain on this GreenGeeks account (e.g. `review.yourmaindomain.com`) |

**Recommendation:** Option **A** if the domain is settled — it avoids a migration step and the "URL changes at launch" confusion. Option **B** if the client might keep the current site live until sign-off, since it leaves the real domain free.

Avoid: the `~username` URL, and cPanel's random "Temporary Domain" if present (no SSL, warning banner).

The rest of this runbook assumes you picked **A**, **B** or **C** and ends with a normal, SSL-enabled `https://` address. Where the steps differ, they're marked.

---

## 1. Add the domain to GreenGeeks

### Option A — real domain, registered at GreenGeeks
1. Log in at GreenGeeks → **Hosting** → the plan → **Manage**.
2. If the domain isn't on the account yet: **Domains → Parked/Alias Domains** (or **cPanel → Domains → Create A New Domain**) and add it.
3. Point the domain's nameservers to GreenGeeks (`ns1.greengeeks.net`, `ns2.greengeeks.net`, `ns3.greengeeks.net`) at your registrar.
4. Wait for propagation — usually 15 min to 4 h. Check with `whatsmydns.net`.

### Option B — buy a staging domain
1. Register something obvious: `dorcas-review.com`, `dorcas-staging.com`, `dorcas-preview.com`.
2. At the registrar, set the nameservers to the three GreenGeeks nameservers above.
3. In GreenGeeks: **Domains → Create A New Domain → Registered Domain**, enter it, **uncheck "Share document root"**, and note the document root it suggests (e.g. `public_html/dorcas-review.com`).

### Option C — subdomain of an existing domain
1. **cPanel → Domains → Create A New Domain** → enter `review.yourdomain.com` → **uncheck "Share document root"** → note the document root.
2. Subdomains of a domain already on GreenGeeks get their own docroot and their own AutoSSL certificate.

**Verify:** `https://your-temp-address` loads *something* (a default page or 403). If it 404s, the docroot isn't right — stop and fix that before installing WordPress.

---

## 2. Turn on SSL (do this before installing WordPress)

1. **cPanel → Security → SSL/TLS Status**.
2. Tick the temp domain → **Run AutoSSL**.
3. Wait 5–20 minutes. Re-check until the domain shows a valid certificate.
4. In **cPanel → Domains**, make sure **Force HTTPS Redirect** is on for the domain.

> If AutoSSL can't issue because DNS hasn't propagated, it will keep failing until it has. Don't proceed to a client hand-off without a working padlock.

**Why before WordPress:** installing first means the database stores `http://` URLs, and you get mixed-content warnings later.

---

## 3. Set PHP before you install anything

**cPanel → Software → Select PHP Version**

| Setting | Value | Why |
|---|---|---|
| PHP version | **8.3** (latest patch GreenGeeks provides) | WordPress + WooCommerce 11 target 8.2/8.3. The theme only declares 7.0, but 8.3 is what you want in 2026. |
| Extensions | Reset to default, then confirm: `mbstring`, `pdo_mysql`, `curl`, `gd` (or `imagick`), `intl`, `zip`, `exif`, `fileinfo` | WooCommerce needs `intl` for currency formatting; the theme needs `gd` for image sizes |

Then **Switch to PHP Options** and raise the limits — **this matters most for the demo import** (470 items, 226 images):

| Directive | Value |
|---|---|
| `memory_limit` | `256M` |
| `max_execution_time` | `300` |
| `max_input_time` | `300` |
| `upload_max_filesize` | `64M` |
| `post_max_size` | `64M` |
| `max_input_vars` | `5000` |

`max_input_vars` at 5000 is not optional: Elementor and the theme's Redux options panel both submit large forms, and the default 1000 silently truncates saves.

**Record what you set** — you'll re-check this after any PHP branch change.

---

## 4. Install a clean WordPress

**cPanel → Software → Softaculous Installer → WordPress → Install**

1. **Choose Protocol:** `https://`
2. **Choose Domain:** your temp domain (not `www`)
3. **In Directory:** leave blank for Option A/B (domain root). For Option C, blank if the subdomain has its own docroot.
4. **Site Name:** `Dorcas` (changeable later)
5. **Admin Username:** *not* `admin` — use something like `dorcas_admin`
6. **Admin Password:** generate a strong one, store it in your password manager
7. **Admin Email:** an address **you** control and actually read (order notifications will land there during testing)
8. **Language:** English
9. **Advanced Options:**
   - **Disable the default WP plugins/themes:** leave as is (Softaculous installs a bare site anyway)
   - **Database Name:** accept the generated one
   - **Auto Upgrade:** set to **"Do not auto upgrade"** ← important, see §5
   - **Disable Search Engine Visibility:** tick it

Install, then log in at `https://your-temp-address/wp-admin`.

---

## 5. Baseline hardening (10 minutes)

Do these before any theme work, so nothing gets built on a bad foundation.

1. **Settings → General** — Site Title `Dorcas`; Timezone **Africa/Accra**; date format your choice.
2. **Settings → Permalinks** — choose **Post name**. *(Without this, WooCommerce product URLs and the theme's pretty links break.)*
3. **Settings → Reading** — confirm **"Discourage search engines"** is ticked.
4. **Users** — delete any other admin; confirm yours has a strong password.
5. **GreenGeeks auto-updates** — in your GreenGeeks dashboard, find the WordPress auto-update setting for this site and **turn plugin/theme auto-updates off**. An Elementor or WooCommerce major landing unannounced will break the header builder. You'll update deliberately, on your schedule.
6. **Delete the default plugins** — Hello Dolly, Akismet (reinstall Akismet later if you want it).
7. **Delete the default themes** (Twenty* series) *after* you've confirmed Luxrio works — keep one until then as an escape hatch.

---

## 6. Install the theme package

You have three ZIPs. Two ways to get them up — try method A first.

### Method A — WordPress uploader (simplest)
1. **Appearance → Themes → Add New → Upload Theme → Choose File** → `luxrio-1.0.1-patched.zip` → **Install Now**.
   - *Do not click Activate yet.*
2. **Upload Theme** again → `luxrio-child-1.0.0.zip` → **Install**.
3. **Activate "Luxrio Child"**.
4. **Plugins → Add New → Upload Plugin** → `luxrio-core-1.0.1.zip` → **Install** → **Activate**.

### Method B — File Manager (use if the uploader times out or says "link has expired")
1. **cPanel → Files → File Manager** → navigate to `public_html/wp-content/themes/`.
2. **Upload** → select `luxrio-1.0.1-patched.zip` and `luxrio-child-1.0.0.zip`.
3. Back in File Manager, right-click each ZIP → **Extract** → extract into the current directory.
4. Delete both ZIPs afterwards (they're not needed and are publicly reachable).
5. Navigate to `public_html/wp-content/plugins/`, upload `luxrio-core-1.0.1.zip`, extract, delete the ZIP.
6. **Check permissions:** folders `755`, files `644`. (File Manager → right-click → Change Permissions. Getting this wrong is the #1 cause of a white screen or missing styles.)

**Verify before moving on:**

- Appearance → Themes shows **Luxrio Child** active, with Luxrio as its parent.
- Plugins shows **Luxrio Core** active, no error notice.
- The front end of the site loads *without* a white screen. It will look unstyled/plain — that's expected until plugins and options are in.
- `wp-content/debug.log` doesn't exist, or is empty.

> If you see "The package could not be installed. The theme is missing the style.css stylesheet" — you uploaded the **complete package** by mistake. Use `luxrio-1.0.1-patched.zip`, which has a single `luxrio/` folder at its root.

---

## 7. Install the remaining plugins

**Appearance → Install Plugins** (the theme's TGMPA screen) — install and activate in this order:

1. **WooCommerce** (run the setup wizard: Ghana, GHS, I'll set details manually)
2. **Elementor**
3. **Redux Framework**
4. **CMB2**
5. **One Click Demo Import**
6. **Contact Form 7**
7. **TI WooCommerce Wishlist**
8. **Variation Swatches for WooCommerce**
9. **Max Mega Menu**
10. **WPC Smart Quick View for WooCommerce** ← confirm the install pulls `woo-smart-quick-view`
11. **Side Cart WooCommerce** ← confirm it pulls `side-cart-woocommerce`

That last pair was swapped in the vendor build and I corrected it — but verify the *installed* plugin matches the label. If either installs the other one, stop and tell me.

Then add three more that GreenGeeks hosting wants:

12. **LiteSpeed Cache** (GreenGeeks runs LiteSpeed — this is your page cache)
13. **WP Mail SMTP** (transactional email; see §12)
14. **Better Search Replace** (only needed at go-live; install now, keep deactivated)

**Do not install a second caching plugin** (no W3TC, no WP Rocket alongside). Two page caches on LiteSpeed is how you get stale carts.

---

## 8. Theme setup, in this order

Do these *before* importing demo content, so the import inherits your settings.

1. **Theme Options → Logo** — upload the real dark logo and white logo. The bundled `logo.svg` / `logo-white.svg` are placeholders I generated; they will look wrong on the live site.
2. **Theme Options → General** — primary colour (default `#ff3e01`) and typography. Changing the primary colour here also drives the Elementor global colours.
3. **Appearance → Menus** — create a menu named **Primary Menu** and assign it to *Primary Menu* and *Mobile Menu*. The demo importer looks for a menu with that exact name.
4. **Appearance → Widgets** — leave alone; the import fills them.
5. **Settings → Reading** — leave "Your homepage displays" as *Your latest posts* for now; the import sets it.

---

## 9. Import the demo content

**Only on a fresh site.** The import creates 470 items and pulls **226 images from the vendor's server** — re-running it gives you duplicates.

1. Confirm PHP limits from §3 are still in place (`max_execution_time` 300, `memory_limit` 256M).
2. **Appearance → Import Demo Data** → **Import**.
3. It will sit on a progress bar for **3–10 minutes**. Do not refresh the tab, do not close it. On LiteSpeed hosts the request sometimes 504s around the 60-second mark if the limits weren't applied — if it does, raise `max_execution_time` and retry on a *fresh* install.
4. Wait for "All done".
5. **Check the result:**
   - Front page is the Luxrio home layout, not a blog list
   - Product images are present (not grey placeholders)
   - **Icons render** — search, cart, social, star ratings. This is the one visual thing that changed: the theme shipped Font Awesome **Pro**, which I replaced with **Free**. I remapped and validated all 88 icon references, but this is where you'd see it if anything slipped.
   - Nothing shows as a blank square/tofu glyph.

> The demo import also pulls demo *copy* and the "Vecuro" demo branding. Budget an hour to strip it (§11).

---

## 10. WooCommerce settings for Ghana

**WooCommerce → Settings**

- **General:** Country **Ghana**, currency **GHS (₵)**, thousand separator `,`, decimal `2`, currency position left.
- **Products:** weight `kg`, dimensions `cm`, enable reviews and star ratings.
- **Tax:** decide now — GHS prices inclusive or exclusive of VAT (15% + NHIL/GETFund levies = 21.9% effective, or 15% if you're not VAT-registered). **If you're not VAT-registered, disable taxes entirely** — charging VAT you don't remit is a real problem.
- **Shipping:** create zones — *Accra* (flat rate or free over GHS 500), *Other regions* (flat rate), *International* (flat rate). The demo ships placeholder zones; replace them.
- **Payments:** for the client review, enable **Cash on delivery** only, or put Paystack/Flutterwave in **test mode**. Do not take live payments on the review site. Live keys go in at go-live.
- **Accounts:** allow customer registration; guest checkout on or off per your preference.
- **Advanced → Page setup:** confirm Cart, Checkout, My account pages are assigned (the import usually does this).

---

## 11. Replace the demo content

Budget an hour. This is what makes it look like *their* shop rather than a template.

- [ ] Delete demo products (Products → select all → Trash), demo posts, demo pages you won't use
- [ ] Replace the logo, favicon, and any "Vecuro"/"Luxrio" footer attribution
- [ ] Rewrite the home page sections in Elementor with real copy and real product photography
- [ ] Contact page: real address, phone, email; test the Contact Form 7 form actually sends
- [ ] Privacy policy, terms, returns page — WooCommerce can generate skeletons at **Settings → Privacy**, but the text must be real
- [ ] Remove demo users (there may be an "author" account from the import)

---

## 12. Email — do this before the client tests checkout

By default WordPress sends mail through PHP `mail()`, which GreenGeeks' shared IPs get filtered on. Order confirmations will silently vanish and you'll chase a bug that doesn't exist.

1. **WP Mail SMTP → Settings**
2. Mailer: **Other SMTP** (use a mailbox created in **cPanel → Email Accounts** on your domain), or a transactional provider if you have one
3. Host/port: `mail.yourdomain.com`, port `587`, encryption **TLS**
4. Username/password: the mailbox credentials
5. From Email: `orders@yourdomain.com` (must match the domain — otherwise SPF fails)
6. **Send a test email** and confirm it lands in an inbox, not spam
7. Ask GreenGeeks support (or check the DNS zone in cPanel) that **SPF, DKIM and DMARC** records exist for the domain

---

## 13. Performance on LiteSpeed

1. **LiteSpeed Cache → Presets** → choose a **Advanced** preset.
2. **Cache → Excludes** — exclude these URLs (mandatory, or customers see stale carts):
   ```
   /cart/
   /checkout/
   /my-account/
   /wc-api/
   /?add-to-cart=
   /?wc-ajax=
   ```
3. **Optimize → JS/CSS** — enable **CSS/JS minify** and **combine** *only after* you've confirmed the site works. LSCache's CSS combine can break the theme's Font Awesome icon fonts; if icons disappear, disable "Load CSS Asynchronously" first.
4. **Do not enable "Critical CSS" / "UCSS"** without testing — it regularly mangles Elementor layouts.
5. Purge cache after every settings change (**LiteSpeed Cache → Toolbox → Purge All**).

Realistic target on a LiteSpeed shared host: mobile Lighthouse 70–85. If you're under 60, check image sizes first — the demo images are large.

---

## 14. Give the client access (but not to Google)

The site is already `noindex` from §5. Now add a password so only people you choose can see it.

**cPanel → Files → Directory Privacy** → select the temp domain's document root → tick **Password protect this directory** → name it "Dorcas review".

Then **Create User** twice:

| User | Password | For |
|---|---|---|
| `dorcas` | share with client | client review |
| `you` | your own | your access |

Send the client **both** the URL and this username/password — the browser will prompt before the site loads.

> Two caveats, both normal:
> - Logged-out requests to `/wp-json/` and the Elementor editor will also hit the password prompt. You just enter it once per session.
> - Some uptime/security scanners will report 401. Ignore it during review.
>
> If Directory Privacy causes trouble, the alternative is the **Password Protected** plugin (single password, no .htpasswd) — weaker, but simpler and doesn't touch server config.

Create a **client editor account** as well, so they can log in and see the admin if they want to: **Users → Add New**, role **Subscriber** (or **Shop manager** if they'll manage products — not Administrator).

---

## 15. What to send the client

Copy-paste, fill the blanks:

> **Subject: Your new website — preview link**
>
> Hi ___,
>
> The site is ready for your first look. It's on a temporary address while we finish it:
>
> **Link:** https://__________
> **Password:** __________(username `dorcas`)
>
> A few notes:
> - This is a **review link, not the final address** — everything transfers to your real domain at launch.
> - **Please don't share the link** — it's password-protected so search engines and the public can't see it.
> - Products, prices and photos are **placeholders** from the design template. Send me your real ones (or a Dropbox/Drive folder) and I'll swap them in.
> - Try it on your phone. Tell me anything that reads badly, feels slow, or looks wrong — screenshots are perfect.
>
> Could you reply by **___day** with your feedback? Then we move to the real domain.
>
> Thanks,
> ___

---

## 16. QA before you call it ready

Run `docs/STAGING-QA-CHECKLIST.md` from the complete package — it's ordered and tick-boxed. On this host, prioritise:

- [ ] Every page loads with no white screen, no 500
- [ ] **One full test order** in WooCommerce test mode: add to cart → checkout → order email received → order in admin → mark complete
- [ ] Cart and checkout are **not** being cached (add an item, refresh, check the count updates)
- [ ] Mobile: 375 px wide, menu opens, nothing overflows sideways
- [ ] All icons render (the Font Awesome Free swap)
- [ ] Contact form delivers to a real inbox
- [ ] `Tools → Site Health` — no critical issues; PHP 8.3, `intl` loaded, HTTPS working
- [ ] SSL padlock, no mixed-content warnings in the browser console

---

## 17. Going live on the real domain

### If you used Option A (real domain already)
Almost nothing to do: remove the password protection, untick "Discourage search engines" (**Settings → Reading**), purge LiteSpeed, add Google Analytics, and place one real order.

### If you used Option B or C (staging domain)
1. **Back up first** (see §18).
2. Add the real domain in **cPanel → Domains → Create A New Domain**, pointing at the *same document root* as the staging site. Or use **Domains → Manage → Replace with a registered domain** (newer cPanel builds).
3. Update the database URLs: **Tools → Better Search Replace** → search `staging-domain.com` → replace `realdomain.com` → tick **all tables** → **Run**. (Plain find-and-replace in the DB breaks serialized data — this plugin handles it.)
4. Run AutoSSL for the real domain (**SSL/TLS Status → Run AutoSSL**), then remove the old staging domain from the account once the cert is live.
5. **Settings → General** → verify both WordPress Address and Site Address show the real domain with `https://`.
6. Purge LiteSpeed cache; clear your browser cache.
7. Untick "Discourage search engines"; confirm `https://realdomain.com/robots.txt` allows crawling.
8. Update the WooCommerce store address, the payment gateway webhook URL, and the SPF/DKIM records to the real domain.
9. Place a real (small) order and refund it.

---

## 18. Backups and rollback

- **GreenGeeks takes nightly backups** on shared plans. Confirm the retention window with support and, critically, **ask how a restore is requested** — you don't want to learn that during an outage.
- Before any risky step (theme update, plugin update, domain change): **Files → Backup** in cPanel, or use **All-in-One WP Migration / UpdraftPlus** to push one to Google Drive.
- Write down the restore process in your own notes. A backup nobody has restored is a guess.

---

## 19. Troubleshooting

| Symptom | Cause | Fix |
|---|---|---|
| Upload fails: "The link you followed has expired" | PHP upload limits | Set `upload_max_filesize`/`post_max_size` to 64M (§3), or use File Manager (§6B) |
| Theme installs but the site is blank white | Permissions, or a missing file | Set dirs 755 / files 644; check `debug.log`; switch to a default theme to confirm the theme is the cause |
| Site loads with no styling | `assets/css/style.min.css` missing, or LiteSpeed CSS-combine broke it | Re-extract the theme ZIP; disable LSCache CSS combine |
| Icons show as empty squares | Font Awesome Free missing a glyph | Tell me the page and the icon — I validated them, but this is the swap's failure mode |
| Demo import stalls or 504s | `max_execution_time` too low | Raise to 300, fresh install, retry |
| Demo import "fatal error" | Missing Elementor | Activate Elementor before importing |
| Order emails never arrive | `mail()` filtered | WP Mail SMTP + SPF/DKIM (§12) |
| Cart count doesn't update | Page cache serving `/cart/` | Add the exclusions from §13 |
| AutoSSL keeps failing | DNS not pointed yet | Wait for propagation, re-run; don't install WordPress over plain HTTP in the meantime |
| Mixed content warnings | Site was installed on `http://` | Set both URLs to `https://` in Settings → General, Better Search Replace `http://yourdomain` → `https://yourdomain` |

---

## 20. Quick reference

**Paths**
- WordPress root: `public_html/` (Option A/B) or `public_html/sub.domain.com/` (Option C)
- Theme: `wp-content/themes/luxrio/`
- Child theme: `wp-content/themes/luxrio-child/`
- Plugin: `wp-content/plugins/luxrio-core/`

**Version baseline to record at hand-off**
WordPress · PHP 8.3.x · WooCommerce · Elementor (+Pro if used) · Redux · CMB2 · CF7 · TI Wishlist · Variation Swatches · WPC Quick View · Side Cart · Max Mega Menu · Luxrio 1.0.1 (patched) · Luxrio Core 1.0.1 (patched)

**Don't forget**
- `max_input_vars = 5000` (theme options silently truncate without it)
- `/cart/`, `/checkout/`, `/my-account/` excluded from every cache
- No live payment keys on the review site
- Take the password off before launch, and untick "Discourage search engines"
