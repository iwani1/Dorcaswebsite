# "I added an image and it doesn't show"

Work down this page until it's fixed. Nine times out of ten it's step 1 or step 3, and both take under a minute.

---

## First: which of the three is broken?

In WordPress an uploaded file and a displayed image are **two different things**. Uploading to the Media Library puts a file on the server; it does not put it anywhere on the page. Something has to point at it.

So find out where the chain breaks:

| | Test | If this fails |
|---|---|---|
| **A. The file** | Media Library → click the image → copy the **File URL** → paste into a new browser tab | The upload itself failed — see *File won't load* below |
| **B. The link** | Right-click the broken spot → *Inspect* (or *Open image in new tab*) — does the URL match the file you uploaded? | Something still points at the old image — see *It's pointing at the old one* |
| **C. The page** | Does it look right in a different browser or in Incognito, logged out? | It's a cache |

---

## The five fixes, in the order they actually happen

### 1. Cache — the most common cause by a mile

You replaced the image, the server has it, the page you're looking at is a saved copy from before.

- **Purge the site cache:** admin bar → **LiteSpeed Cache → Purge All** (or the equivalent if it's WP Rocket / W3 Total Cache / SiteGround Optimizer).
- **Then hard-reload:** `Ctrl + Shift + R` (Windows) or `Cmd + Shift + R` (Mac). A normal refresh can reuse the cached image.
- **Then check in Incognito.** Logged-out Incognito is the only reliable test — logged-in admins are often served uncached pages and see things visitors don't, and vice versa.

If it appears in Incognito but not in your normal window, it was your browser, and you're done.

### 2. It's uploaded but not assigned

The image is in the library and nothing on the page is pointing at it. This is the one people miss, because "upload" feels like "place".

| Where | What actually controls it |
|---|---|
| **Product** | `Products → [product] → Product image` (the box on the right). The **Product gallery** below it is a separate slot — filling one does nothing for the other. |
| **Logo** | `Theme Options → Logo`. There is usually more than one slot: header, sticky header, mobile, and a **light/white** version used when the header sits over a dark hero. Filling the dark logo and looking at a transparent header shows nothing. |
| **Blog post** | `Posts → [post] → Featured image`. |
| **Elementor section** | Click the actual image widget on the canvas → *Choose Image* → pick it. Uploading to the library does not replace what the widget already shows. |

The grey camera icon on the shop grid is WooCommerce's placeholder. It means *no featured image is set*, not "the image failed".

### 3. It's pointing at the old one

Very common after replacing a demo image. The Elementor widget, or the theme option, still holds the old attachment ID or the old URL. Changing the file on the server does nothing, because nothing reads that file any more.

Check the URL in the page source. If it says `wordpress.vecurosoft.com/...`, the section is still using the theme vendor's demo image — that's the hotlinking issue from the audit, and the fix is to re-select the image in the widget.

### 4. WordPress refused the file

Two formats bite people:

- **SVG** — WordPress blocks it by default: *"Sorry, you are not allowed to upload this file type."* That's deliberate; an SVG can carry a script. **Use the PNG versions** in `brand/` (`logo.png`, `logo-white.png`) — 840 px wide, transparent background, ready to upload.
- **HEIC** — the iPhone's default photo format. WordPress won't take it. `Settings → Camera → Formats → Most Compatible` on the phone, or export as JPEG.

Other rejections and what they mean:

| Message | Means | Fix |
|---|---|---|
| "exceeds the upload_max_filesize" | File bigger than the server allows | Resize to 2000 px longest edge before uploading — a 4000 px phone photo is far more than the site needs anyway |
| "HTTP error" on upload | Usually a permissions or disk problem | See §5 |
| Upload bar sticks at 100% | Same | See §5 |

### 5. Permissions

If the File URL from step A returns **403 Forbidden** instead of the image, the file exists but the web server won't serve it.

cPanel → **File Manager** → `public_html/dorcas/wp-content/uploads`:
- Folders: **755**
- Files: **644**
- Owner: your account user

Fix with *Permissions* in File Manager (applies recursively). If it reverts, GreenGeeks support fixes it in a minute — say "uploads directory permissions are wrong, images return 403".

---

## Symptom → cause, at a glance

| What you see | Cause | Fix |
|---|---|---|
| Grey camera placeholder on shop | No featured image set | `Product → Product image` |
| Broken-image icon with alt text showing | Image URL 404s | Re-upload; re-select in the widget |
| Fine in admin, missing on the front end | Page cache | Purge, then hard reload |
| Fine on desktop, missing on mobile | Separate mobile logo / image slot | `Theme Options → Logo` mobile slot |
| Blurry or stretched | File smaller than the slot | Upload ~2× the displayed size |
| Only appears after you log out | Caching or a plugin hiding it for admins | Purge; check the plugin's lazy-load settings |
| Appears in the editor, not on the live site | Elementor's generated CSS is stale | `Elementor → Tools → Regenerate CSS & Data` |
| Upload silently vanishes | Permissions, or file type rejected | §4 and §5 |
| Was fine, broke after changing the domain | Images saved with the old absolute URL | A search-replace of the old domain → new (serialization-aware — use Better Search Replace, not raw SQL) |

---

## If it's the logo

Three things to know about this theme:

1. **It has multiple logo slots.** `Theme Options → Logo` — header, sticky, mobile, and a white version for dark/transparent headers. A logo that "doesn't show" is usually in the wrong slot, not missing.
2. **SVG will be rejected.** Use `brand/logo.png` or `brand/logo-white.png`.
3. **Size.** 840 × 190 px is generous for a header. If it renders huge or tiny, the theme's CSS caps it by height — crop the transparent padding rather than fighting the CSS.

---

## If it's a product photo

1. `Products → [product]` → **Product image** (right-hand box). Save.
2. If the grid still shows the placeholder after a purge, the image is attached to the wrong product — check the Media Library's "Attached to" column.
3. If the image shows in the editor but the grid crops it badly, the thumbnail sizes predate the upload: install **Regenerate Thumbnails** and run it once, or `wp media regenerate --yes` over SSH.

---

## When to stop guessing

If the File URL works and the page still doesn't show it, the answer is in the browser console — right-click → *Inspect* → **Console** tab, reload, and look for a red line naming the image. Send me a screenshot of that, plus the page URL, and I'll tell you exactly which of the above it is.
