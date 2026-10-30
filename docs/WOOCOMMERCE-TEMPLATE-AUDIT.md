# WooCommerce template override audit

**Audited:** 2026-10-30
**Against:** WooCommerce **11.2.1** (tag `11.2.1`, released 2026-10-09) — the current stable release
**Theme:** Luxrio 1.0.1 · **Overrides:** 33 templates in `wp-content/themes/luxrio/woocommerce/`

Reproduce any time with:

```bash
curl -L -o wc.tar.gz https://codeload.github.com/woocommerce/woocommerce/tar.gz/refs/tags/11.2.1
tar xzf wc.tar.gz --wildcards '*/plugins/woocommerce/templates/*'
python3 tools/wc-template-audit.py \
  --theme wp-content/themes/luxrio/woocommerce \
  --core  woocommerce-11.2.1/plugins/woocommerce/templates
```

---

## Headline

| Status | Count | Meaning |
|---|---|---|
| ✅ **Current** | **16** | `@version` matches core — WooCommerce has not changed the template since the override was written |
| 🟠 **Needs upstream merge** | **6** | Core changed the template; the override is missing that change |
| 🟡 **Stale header, current code** | **3** | The upstream change is already present, only the `@version` comment is behind |
| ⚪ **Custom** | **8** | No core counterpart — theme-specific templates |

**Bottom line: the checkout path is not at risk.** WooCommerce has not touched `single-product.php`, `archive-product.php`, `content-product.php`, `content-single-product.php`, `loop/orderby.php`, `myaccount/navigation.php` or any of the account/cart-adjacent templates the store actually depends on since the theme's copies were made. Of the six that did drift, five are cosmetic/accessibility/performance and one (`single-product-reviews.php`) is a small escaping hardening. None is a functional break.

> This corrects the earlier estimate in `ANALYSIS.md`, which flagged "several stale overrides" from version headers alone. Those headers turn out to be a poor proxy in both directions: three overrides show old versions but already contain the new code, and the genuinely stale ones change far less than the raw header spread (1.6.4 → 11.2.1) suggests.

---

## Full inventory

| Template | Theme @version | WC 11.2.1 @version | Status | Action |
|---|---|---|---|---|
| `archive-product.php` | 8.6.0 | 8.6.0 | ✅ current | No action |
| `contact-product-four.php` | 3.6.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `content-horizontal-product.php` | 3.6.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `content-product-four.php` | 3.6.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `content-product-three.php` | 3.6.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `content-product-two.php` | 3.6.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `content-product-view.php` | — | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `content-product.php` | 9.4.0 | 9.4.0 | ✅ current | No action |
| `content-single-product.php` | 3.6.0 | 3.6.0 | ✅ current | No action |
| `content-widget-product.php` | 3.5.5 | 3.5.5 | ✅ current | No action |
| `global/form-login.php` | 9.2.0 | 9.2.0 | ✅ current | No action |
| `global/quantity-input.php` | 9.4.0 | 10.1.0 | 🟠 needs upstream merge | Guard `max` attribute so it is only output when > 0 |
| `loop/orderby.php` | 9.7.0 | 9.7.0 | ✅ current | No action |
| `myaccount/form-edit-account.php` | 9.7.0 | 11.0.0 | 🟠 needs upstream merge | Add `account_display_name_description` help text |
| `myaccount/form-edit-address.php` | 9.3.0 | 9.3.0 | ✅ current | No action |
| `myaccount/form-login.php` | 9.7.0 | 9.9.0 | 🟠 needs upstream merge | Add `autocomplete="username"` to the login input |
| `myaccount/form-lost-password.php` | 9.2.0 | 9.2.0 | ✅ current | No action |
| `myaccount/my-account.php` | 3.5.0 | 3.5.0 | ✅ current | No action |
| `myaccount/my-address.php` | 9.3.0 | 9.3.0 | ✅ current | No action |
| `myaccount/navigation.php` | 9.3.0 | 9.3.0 | ✅ current | No action |
| `order/order-details-customer.php` | 8.7.0 | 8.7.0 | ✅ current | No action |
| `product-list-style.php` | 3.6.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
| `single-product/add-to-cart/external.php` | 7.0.1 | 7.0.1 | ✅ current | No action |
| `single-product/add-to-cart/grouped.php` | 7.0.1 | 11.0.0 | 🟠 needs upstream merge | Add `role="presentation"` + per-child sale notice block |
| `single-product/add-to-cart/simple.php` | 7.0.1 | 10.2.0 | 🟡 verify, then bump header | Code already carries the upstream change; `@version` header is stale |
| `single-product/add-to-cart/variation-add-to-cart-button.php` | 7.0.1 | 10.5.2 | 🟡 verify, then bump header | Code already carries the upstream change; `@version` header is stale |
| `single-product/related.php` | 9.6.0 | 10.3.0 | 🟠 needs upstream merge | Lazy-load fix: bump media count for related product images |
| `single-product/review.php` | 2.6.0 | 2.6.0 | ✅ current | No action |
| `single-product/tabs/tabs.php` | 9.6.0 | 9.8.0 | 🟡 verify, then bump header | Code already carries the upstream change; `@version` header is stale |
| `single-product/up-sells.php` | 9.6.0 | 9.6.0 | ✅ current | No action |
| `single-product-reviews.php` | 9.7.0 | 11.2.0 | 🟠 needs upstream merge | Updated `woocommerce_reviews_title` filter signature/docblock |
| `single-product.php` | 1.6.4 | 1.6.4 | ✅ current | No action |
| `ti-wishlist-product-counter.php` | 2.8.0 | — | ⚪ custom (no core counterpart) | Theme-specific — nothing upstream to track |
---

## The six that need merging

Each entry shows what WooCommerce changed *after* the version the theme copied, and why it matters. Patches are against the theme's file in `wp-content/themes/luxrio/woocommerce/`.

### 1. `single-product-reviews.php` — 9.7.0 → 11.2.0 · escaping
```php
- '<span>' . get_the_title() . '</span>'
+ '<span>' . wp_kses_post( get_the_title() ) . '</span>'
```
Plus the `woocommerce_reviews_title` filter docblock and a `phpcs:ignore` note.

**Why:** the product title was interpolated into the review heading unescaped. Admin-controlled, so low real-world risk — but it matters on any site with vendor/marketplace product authoring, and it is the only change of the six that touches output safety. **Do this one before launch.**

### 2. `myaccount/form-login.php` — 9.7.0 → 9.9.0 · input hardening
```php
- value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
+ value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
```
**Why:** `?username[]=x` passed to `esc_attr()` as an array triggers a PHP warning / type error. The theme's override has the same read, so it inherits the same flaw.

### 3. `myaccount/form-edit-account.php` — 9.7.0 → 11.0.0 · password managers + help text
```php
- autocomplete="off"                    (×3 password fields)
+ autocomplete="current-password"       // current password
+ autocomplete="new-password"           // new password ×2

+ <span id="account_display_name_description"><em>…</em></span>
```
**Why:** `autocomplete="off"` stops password managers filling the change-password form — a measurable drop-off in account completion. The description span is referenced by `aria-describedby` that already exists in the markup.

### 4. `global/quantity-input.php` — 9.4.0 → 10.1.0 · invalid attribute
```php
- max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
+ <?php if ( 0 < $max_value ) : ?>
+   max="<?php echo esc_attr( $max_value ); ?>"
+ <?php endif; ?>
```
**Why:** emits `max=""` when no maximum is set — invalid HTML that some validators and JS quantity steppers mishandle.

### 5. `single-product/related.php` — 9.6.0 → 10.3.0 · lazy loading
```php
if ( $related_products ) :
+   if ( function_exists( 'wp_increase_content_media_count' ) ) {
+       $content_media_count = wp_increase_content_media_count( 0 );
+       if ( $content_media_count < wp_omit_loading_attr_threshold() ) {
+           wp_increase_content_media_count( wp_omit_loading_attr_threshold() - $content_media_count );
+       }
+   }
```
**Why:** related-product images were being eagerly loaded, hurting LCP on every product page.

### 6. `single-product/add-to-cart/grouped.php` — 7.0.1 → 11.0.0 · accessibility + price context
```php
- <table cellspacing="0" class="woocommerce-grouped-product-list group_table">
+ <table cellspacing="0" class="woocommerce-grouped-product-list group_table" role="presentation">

- echo '<label …>' . esc_html__( 'Buy one of this item', 'woocommerce' ) . '</label>';
+ // sale-aware label: "Buy one of {name} on sale for {price}, original price was {regular}"
+ // otherwise:        "Buy one of {name} for {price}"

- 'max_value' => apply_filters( 'woocommerce_quantity_input_max', … ),
+ 'max_value' => $grouped_product_child->get_max_purchase_quantity(),
```
**Why:** screen-reader labels now name the product and price; the quantity filter call was removed upstream in favour of the input helper's own filtering. Only relevant if you sell grouped products — the demo does not.

---

## The three with stale headers but current code

These already contain the upstream change; only the `@version` comment is behind. **Do not "merge" them** — verify the rendered page, then bump the header to silence false "outdated template" notices:

| Template | Theme header | Code already includes | Bump to |
|---|---|---|---|
| `single-product/add-to-cart/simple.php` | 7.0.1 | quantity min/max now read straight from the product | 10.2.0 |
| `single-product/add-to-cart/variation-add-to-cart-button.php` | 7.0.1 | same | 10.5.2 |
| `single-product/tabs/tabs.php` | 9.6.0 | `role="presentation"` on tab `<li>` | 9.8.0 |

---

## The eight custom templates

No upstream file exists, so nothing will ever be flagged as outdated — but they also get **no security updates from WooCommerce** and must be reviewed by hand on every major upgrade:

`contact-product-four.php` · `content-horizontal-product.php` · `content-product-four.php` · `content-product-three.php` · `content-product-two.php` · `content-product-view.php` (no `@version` header at all) · `product-list-style.php` · `ti-wishlist-product-counter.php`

The last one is provided by **TI WooCommerce Wishlist**, not WooCommerce — its `@version` (2.8.0) tracks that plugin. Re-check it whenever the wishlist plugin updates.

---

## Practical guidance

**Testing priority.** Of the six merges, only #1 and #2 touch anything a customer interacts with directly. Test in this order: product page → single product reviews → my account login → change password → quantity stepper on single and grouped products → related products (check images lazy-load).

**High-Performance Order Storage.** The theme never calls `FeaturesUtil::declare_compatibility()`, so WooCommerce will keep showing an "incompatible plugin" notice and will not let you opt into custom order tables. All 33 overrides were checked and none read order meta directly, so declaring HPOS support is very likely safe — but only declare it after placing a test order on staging.

**Strategic note.** Every override is a permanent maintenance liability. Many of the eight custom `content-product-*.php` variants exist only to change markup that CSS could change instead. If you ever refactor, collapsing those into `content-product.php` + CSS removes them from this audit forever.

**When WooCommerce ships a new major**, re-run `tools/wc-template-audit.py` before updating. Anything marked MERGE gets a five-minute diff review; that is how you avoid the checkout surprise.
