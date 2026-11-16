# Checkout — what is actually broken

Checked live just now with an item in the cart:

`https://queendorfashionhouse.com/checkout/?add-to-cart=1466`

## The page works. The payment gateway is switched off.

Everything renders correctly — contact, billing address, order summary, the ₵180 total,
and the line *"By proceeding with your purchase you agree to our Terms and Conditions"*.
Then, at the bottom:

> **"There are no payment methods available. Please contact us for help placing your
> order."**

And in the payment section it lists **Debit/Credit Cards** with the Paystack logo, but
no way to select it.

That message means WooCommerce found **zero usable payment gateways**. The page is fine;
the gateway is failing its own availability check. A customer sees a working checkout
that cannot take money — worse than a broken one, because they only discover it after
typing their address.

---

## Why it happens, in order of likelihood

| # | Cause | How to tell |
|---|---|---|
| 1 | **Paystack keys are empty.** A gateway with no public/secret key reports itself unavailable, even while listed | Settings → Payments → Paystack — are both fields filled? |
| 2 | **The gateway is not enabled.** The toggle is off, or "Enable/Disable" is unticked | Same screen, the toggle at the top |
| 3 | **Test mode with no test keys**, or live mode with test keys | The mode switch in the Paystack settings |
| 4 | **Currency not GHS.** Paystack Ghana only supports GHS here | Settings → General → Currency — should be `GH₵` |
| 5 | **Account not activated yet** (request 2087034), so no live keys exist to paste | Paystack dashboard → Settings → API Keys |

You told me the account is still under review, so **#1 or #5 is almost certainly it**:
there are no live keys to paste yet, and nobody has pasted the test ones.

---

## Fix it in ten minutes — and test the whole flow today

You do **not** need Faith's approval to take test payments. Paystack gives every account
test keys before activation.

### 1. Get the test keys

Paystack dashboard → **Settings → API Keys & Webhooks** → copy the **Test** public key
(`pk_test_…`) and **Test** secret key (`sk_test_…`).

### 2. Paste them into WooCommerce

**WooCommerce → Settings → Payments → Paystack → Manage**

- **Enable/Disable** → tick
- **Test mode** → tick *(while unactivated)*
- **Test Public Key** → `pk_test_…`
- **Test Secret Key** → `sk_test_…`
- **Save changes** — the toggle at the top of the Payments list must read **Enabled**

### 3. Check the currency

**WooCommerce → Settings → General → Currency** → **Ghana cedi (GH₵)**.
Paystack Ghana will not process a store priced in anything else.

### 4. Clear the cache

cPanel → LiteSpeed Web Cache Manager → **Flush All**. The old checkout HTML is cached.

### 5. Buy something

Open `https://queendorfashionhouse.com/cart/?add-to-cart=1466` → **Proceed to Checkout** →
fill the address → **Place Order**.

Use Paystack's test card:

```
Card number   4084 0840 8408 4081
CVV           408
Expiry        any future date
PIN           0000
OTP           123456
```

If the order completes, the checkout is correct end to end and the only thing between
you and taking money is the activation.

---

## If it still says "no payment methods"

Work down this list, it narrows fast:

1. **WooCommerce → Status → Logs** → open the newest `paystack` or `fatal-errors` file.
   The reason is almost always written there.
2. **Settings → Payments** — is there another gateway (Cash on Delivery) you can enable
   for a moment? If that one appears at checkout, the checkout page is fine and Paystack
   is the problem.
3. **WooCommerce → Settings → General → Selling location(s)** — set to *Sell to all
   countries*, or at least to Ghana. A store selling to "specific countries" that does
   not include the billing country removes every gateway.
4. **Settings → Payments → Paystack** — if there is a "Payment channels" or
   "Currency" field, make sure it is not restricted to a channel you have not enabled on
   the Paystack account.

---

## One more thing that will bite a customer today

The cart drawer still links **View Cart** and **Checkout** to
`www.blaharbenyah.com/dorcas/…`, which is a 404. Anyone who adds a piece and uses the
drawer loses the sale at the last click.

**[`queendor-fix-1.7.0.zip`](https://raw.githubusercontent.com/iwani1/Dorcaswebsite/arena/336564b6-dorcaswebsite/client/pack/queendor-fix-1.7.0.zip)** → Tools → Queen Dor's Fixes → **Fix the old domain**.
Do that before you test checkout, or you will be testing the wrong button.

---

## After activation

1. Paystack dashboard → copy the **Live** keys.
2. Settings → Payments → Paystack → un-tick **Test mode**, paste `pk_live_…` / `sk_live_…`,
   save.
3. Flush the cache.
4. **Buy one thing yourself, on a phone, on mobile data**, with a real card or MoMo.
5. Confirm three things: the money leaves, the order appears in **WooCommerce → Orders**,
   and **the confirmation email arrives at a customer's inbox** — not just yours.

That last one is the failure nobody notices until a customer complains they paid and
heard nothing.
