# Release state

## Shipped: `QueenDors-child-theme-1.7.1.zip` — 221 KB

This is the version the client is sticking with, and the one live on the site
(`/wp-content/themes/luxrio-child/style.css` reports 1.7.1).

It contains the colour system, the demo-link repair, the wholesale module, the
light-on-nothing decision — and `index.php`, without which WordPress refuses to
install the theme at all.

**Do not regenerate this file from the working tree.** The tree has moved on to
1.8.0. The 1.7.1 archive was built from its own commit so that it is byte-for-byte
what was uploaded:

```bash
git archive 963c656 wp-content/themes/luxrio-child | tar -x -C /tmp/v171
mv /tmp/v171/wp-content/themes/luxrio-child /tmp/v171/luxrio-child
( cd /tmp/v171 && zip -qr QueenDors-child-theme-1.7.1.zip luxrio-child )
```

## Parked: 1.8.0 — not shipped

Adds `brand-light.css`: white header, linen top bar, ink menu, white sticky and
mobile menu, white page ground. The code is on the branch; the archive is not
published.

It is a CSS-only change to the shell, plus `readme.txt`. Nothing in 1.7.1 was
removed or altered, so moving to it later is a single upload and a single
`add_filter` to undo.

## Why 1.8.0 was not taken

The client asked for light mode, and a light header above a dark hero is a
half-measure: it moves the strongest colour change to the least valuable real
estate. The page itself is dark because each Elementor section sets its own
background — see `client/LIGHT-MODE.md`. Until those four sections change, 1.8.0
buys a white stripe at the top of a dark page.

## If 1.8.0 is wanted later

1. Upload `client/pack/luxrio-child-1.8.0.zip` (rebuild with
   `./tools/build-client-pack.sh`).
2. Change the four section backgrounds listed in `client/LIGHT-MODE.md`.
3. Replace the hero photography, which was shot on black.

Steps 1 alone will look unfinished; 1–3 together is a light storefront.
