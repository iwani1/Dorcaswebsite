#!/usr/bin/env bash
#
# Build the Queen Dor's client pack: the installable child theme, the cleanup
# plugin, the page import file and the operator documents.
#
#   ./tools/build-client-pack.sh
#
# Output: client/pack/  (served as the download page)
#
# Zips are gitignored on purpose — this script is the source of truth, and a
# binary archive in a repository is a merge conflict waiting to happen.

set -euo pipefail

REPO="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
THEME_DIR="$REPO/wp-content/themes/luxrio-child"
PLUGIN_DIR="$REPO/client/queendor-cleanup"
OUT="$REPO/client/pack"

THEME_VERSION="$(sed -n 's/.*Version:[[:space:]]*\([0-9.]*\).*/\1/p' "$THEME_DIR/style.css" | head -n1 | tr -d '\r')"
PLUGIN_VERSION="$(sed -n 's/^ \* Version:[[:space:]]*\([0-9.]*\).*/\1/p' "$PLUGIN_DIR/queendor-cleanup.php" | head -n1 | tr -d '\r')"

for pair in "theme:$THEME_VERSION" "plugin:$PLUGIN_VERSION"; do
	if [ -z "${pair#*:}" ]; then
		echo "error: could not read a version number (${pair%%:*})" >&2
		exit 1
	fi
done

# A theme without these is rejected at upload time. Fail here instead of
# letting the client discover it in wp-admin.
for required in style.css index.php functions.php; do
	if [ ! -f "$THEME_DIR/$required" ]; then
		echo "error: the theme is missing $required — WordPress will refuse to install it" >&2
		exit 1
	fi
done

PARENT="$(sed -n 's/^[[:space:]]*Template:[[:space:]]*\(.*\)/\1/p' "$THEME_DIR/style.css" | tr -d '\r' | head -n1)"
if [ -z "$PARENT" ] || [ ! -d "$REPO/wp-content/themes/$PARENT" ]; then
	echo "error: style.css declares Template: '${PARENT}', which has no matching parent theme" >&2
	exit 1
fi

echo "packaging luxrio-child $THEME_VERSION, queendor-cleanup $PLUGIN_VERSION"

rm -rf "$OUT"
mkdir -p "$OUT"

STAGE="$(mktemp -d)"
trap 'rm -rf "$STAGE"' EXIT

# --- child theme -------------------------------------------------------------
mkdir -p "$STAGE/luxrio-child"
cp -R "$THEME_DIR/." "$STAGE/luxrio-child/"
find "$STAGE/luxrio-child" \( -name '*.zip' -o -name '.DS_Store' -o -name '*.log' -o -name 'Thumbs.db' \) -delete

THEME_ZIP="$OUT/luxrio-child-$THEME_VERSION.zip"
( cd "$STAGE" && zip -qr "$THEME_ZIP" luxrio-child )

# --- cleanup plugin ----------------------------------------------------------
mkdir -p "$STAGE/queendor-cleanup"
cp "$PLUGIN_DIR/queendor-cleanup.php" "$STAGE/queendor-cleanup/"

PLUGIN_ZIP="$OUT/queendor-cleanup-$PLUGIN_VERSION.zip"
( cd "$STAGE" && zip -qr "$PLUGIN_ZIP" queendor-cleanup )

# --- documents and data ------------------------------------------------------
DOCS=(UPLOAD-THEME.md COLOR-SYSTEM.md BRAND-COLOURS.md HOMEPAGE-FIX.md IMPORT-GUIDE.md REPLACE-DEMO.md PAGES-AND-MENU.md HEADER-FOOTER.md WHOLESALE.md WHAT-CODE-CAN-DO.md PHOTO-REQUEST.md IMAGES-NOT-SHOWING.md policies.md)
DATA=(queendor-products.csv queendor-pages.wxr)

mkdir -p "$OUT/brand"
cp "$REPO"/client/brand/*.svg "$REPO"/client/brand/*.png "$REPO"/client/brand/*.css \
   "$REPO"/client/brand/*.json "$REPO"/client/brand/*.html "$REPO"/client/brand/*.pdf "$OUT/brand/"

for f in "${DOCS[@]}" "${DATA[@]}"; do
	if [ ! -f "$REPO/client/$f" ]; then
		echo "error: client/$f is missing" >&2
		exit 1
	fi
	cp "$REPO/client/$f" "$OUT/"
done

# --- combined pack -----------------------------------------------------------
PACK="$STAGE/queendor-client-pack"
mkdir -p "$PACK"
cp "$THEME_ZIP" "$PACK/"
cp "$PLUGIN_ZIP" "$PACK/"
for f in "${DOCS[@]}" "${DATA[@]}"; do cp "$REPO/client/$f" "$PACK/"; done
mkdir -p "$PACK/brand"
cp "$REPO"/client/brand/*.svg "$REPO"/client/brand/*.png "$REPO"/client/brand/*.css \
   "$REPO"/client/brand/*.json "$REPO"/client/brand/*.html "$REPO"/client/brand/*.pdf "$PACK/brand/"

PACK_ZIP="$OUT/queendor-client-pack.zip"
( cd "$STAGE" && zip -qr "$PACK_ZIP" queendor-client-pack )

# --- validation --------------------------------------------------------------
for archive in "$THEME_ZIP" "$PLUGIN_ZIP" "$PACK_ZIP"; do
	top="$(unzip -Z1 "$archive" | awk -F/ '{print $1}' | sort -u | wc -l | tr -d ' ')"
	if [ "$top" != "1" ]; then
		echo "error: $(basename "$archive") has $top top-level entries, expected 1" >&2
		exit 1
	fi
	unzip -tq "$archive" >/dev/null || { echo "error: $(basename "$archive") is corrupt" >&2; exit 1; }
done

unzip -Z1 "$THEME_ZIP" | grep -qx "luxrio-child/index.php" \
	|| { echo "error: index.php is missing from the theme zip" >&2; exit 1; }

unzip -p "$THEME_ZIP" luxrio-child/style.css | grep -q "Version: $THEME_VERSION" \
	|| { echo "error: style.css version missing inside the theme zip" >&2; exit 1; }

unzip -p "$PLUGIN_ZIP" queendor-cleanup/queendor-cleanup.php | grep -q "Version:  *$PLUGIN_VERSION" \
	|| { echo "error: plugin header version missing inside the plugin zip" >&2; exit 1; }

# removes the path dependency that made /preview.html 404. The downloads page

# --- download page -----------------------------------------------------------
cat > "$OUT/index.html" <<HTML
<!doctype html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Queen Dor's — client pack</title>
<style>
  body{margin:0;padding:48px 20px;font:16px/1.6 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;color:#1a1d21;background:#f7f8fa}
  .w{max-width:740px;margin:0 auto}
  h1{font-size:26px;margin:0 0 6px;letter-spacing:-.02em}
  p.sub{color:#6b7280;margin:0 0 26px;font-size:15px}
  h2{font-size:13px;letter-spacing:.1em;text-transform:uppercase;color:#6b7280;margin:30px 0 10px;font-weight:600}
  a.card{display:block;padding:16px 20px;margin-bottom:12px;background:#fff;border:1px solid #e5e7eb;border-left:4px solid #c8a24a;border-radius:8px;text-decoration:none;color:inherit}
  a.card:hover{background:#faf8f4}
  a.card strong{display:block;font-size:15.5px;margin-bottom:3px}
  a.card span{font-size:13.5px;color:#6b7280}
  .n{font-size:13px;color:#6b7280;margin-top:28px;padding-top:18px;border-top:1px solid #e5e7eb}
  code{background:#f4f5f7;border:1px solid #e5e7eb;border-radius:4px;padding:1px 5px;font-size:13px}
</style></head><body><div class="w">
<h1>Queen Dor's — client pack</h1>
<p class="sub">Rebuild the shop: clear the demo, import the client's pages, upload the theme and the cleanup tool. Everything is generated from the repository by <code>tools/build-client-pack.sh</code>.</p>

<h2>Install these</h2>
<a class="card" href="luxrio-child-$THEME_VERSION.zip" style="border-left-color:#0b4b4c">
  <strong>luxrio-child-$THEME_VERSION.zip</strong>
  <span>Appearance → Themes → Upload Theme → Replace current with uploaded. Read <a href="UPLOAD-THEME.md">UPLOAD-THEME.md</a> first — one extra field in Elementor.</span>
</a>
<a class="card" href="queendor-cleanup-$PLUGIN_VERSION.zip">
  <strong>queendor-cleanup-$PLUGIN_VERSION.zip</strong>
  <span>Plugins → Add New → Upload. Clears the demo; delete it when you are done.</span>
</a>

<h2>Import these</h2>
<a class="card" href="queendor-products.csv">
  <strong>queendor-products.csv</strong>
  <span>10 products, 18 size variations. Products → All Products → Import.</span>
</a>
<a class="card" href="queendor-pages.wxr">
  <strong>queendor-pages.wxr</strong>
  <span>8 client pages: About, Contact, Shipping, Returns, Privacy, Size Guide, Symbols, Wholesale. Tools → Import → WordPress.</span>
</a>

<h2>Read these</h2>
<a class="card" href="REPLACE-DEMO.md">
  <strong>REPLACE-DEMO.md</strong>
  <span>The run order: clear demo → import pages → menus → homepage copy → the blanks to fill.</span>
</a>
<a class="card" href="IMPORT-GUIDE.md">
  <strong>IMPORT-GUIDE.md</strong>
  <span>The catalogue import, step by step, with the placeholder prices to replace.</span>
</a>
<a class="card" href="UPLOAD-THEME.md">
  <strong>UPLOAD-THEME.md</strong>
  <span>Install, purge the cache in the right order, and the four checks that prove it worked.</span>
</a>
<a class="card" href="COLOR-SYSTEM.md">
  <strong>COLOR-SYSTEM.md</strong>
  <span>The full colour system: ramps, roles, WCAG tables, component states, tokens, dark mode.</span>
</a>
<a class="card" href="brand/preview.html">
  <strong>brand/preview.html</strong>
  <span>Open this first. Palette and components in light and dark, with a toggle.</span>
</a>
<a class="card" href="brand/queendor-color-guide.pdf">
  <strong>brand/queendor-color-guide.pdf</strong>
  <span>Eight pages, print-ready, ending in a one-page card to pin up.</span>
</a>
<a class="card" href="brand/design-tokens.json">
  <strong>brand/design-tokens.json</strong>
  <span>Drop into Tokens Studio for Figma. Core ramps plus light and dark semantic sets.</span>
</a>
<a class="card" href="BRAND-COLOURS.md">
  <strong>BRAND-COLOURS.md</strong>
  <span>The palette sampled from the logo, and why the gold never carries text.</span>
</a>
<a class="card" href="brand-palette.png">
  <strong>brand-palette.png</strong>
  <span>The four colours, side by side — show this to the client.</span>
</a>
<a class="card" href="HOMEPAGE-FIX.md">
  <strong>HOMEPAGE-FIX.md</strong>
  <span>Ten steps, in order, with the exact words to paste. Start here.</span>
</a>
<a class="card" href="WHAT-CODE-CAN-DO.md">
  <strong>WHAT-CODE-CAN-DO.md</strong>
  <span>What the child theme fixes without you touching anything, and the short list only you can do.</span>
</a>
<a class="card" href="WHOLESALE.md">
  <strong>WHOLESALE.md</strong>
  <span>Trade prices at 50%, minimum six per style, manual approval. No plugin — it ships in the child theme.</span>
</a>
<a class="card" href="HEADER-FOOTER.md">
  <strong>HEADER-FOOTER.md</strong>
  <span>Two admin menus do different jobs. The builder holds the design, the options panel decides whether the site uses it.</span>
</a>
<a class="card" href="PAGES-AND-MENU.md">
  <strong>PAGES-AND-MENU.md</strong>
  <span>Publishing the eight pages, trashing the 28-page demo pile-up, and rebuilding the menu so "Shop" stops opening an empty page.</span>
</a>
<a class="card" href="PHOTO-REQUEST.md">
  <strong>PHOTO-REQUEST.md</strong>
  <span>The message to send the client, the SKU naming scheme, and what happens when the files land.</span>
</a>
<a class="card" href="policies.md">
  <strong>policies.md</strong>
  <span>Source copy for the policy pages, and the footer checklist.</span>
</a>

<h2>Brand</h2>
<a class="card" href="IMAGES-NOT-SHOWING.md">
  <strong>IMAGES-NOT-SHOWING.md</strong>
  <span>Uploaded an image and it isn't on the page? Triage in four checks, then the eleven causes in order of likelihood.</span>
</a>
<a class="card" href="brand/logo.png">
  <strong>logo.png</strong>
  <span>Upload this one — WordPress rejects SVG files by default.</span>
</a>
<a class="card" href="brand/logo.svg">
  <strong>logo.svg</strong>
  <span>Temporary wordmark until the real one arrives. Theme Options → Logo.</span>
</a>
<a class="card" href="brand/logo-white.svg">
  <strong>logo-white.svg</strong>
  <span>The same, for dark backgrounds and the footer.</span>
</a>

<h2>Everything</h2>
<a class="card" href="queendor-client-pack.zip">
  <strong>queendor-client-pack.zip</strong>
  <span>All of the above in one archive.</span>
</a>

<p class="n">Prices, materials, ring sizes and every <code>________</code> in the page copy are placeholders. Check them before the shop goes public.</p>
</div></body></html>
HTML

# The colour system is the root page: it is the thing worth looking at, and it
# removes the path dependency that made /preview.html 404. The downloads page
# moves to /pack.html, still linked from the cards below.
# moves to /pack.html.
mv "$OUT/index.html" "$OUT/pack.html"
cp "$REPO/client/brand/preview.html" "$OUT/index.html"
cp "$REPO/client/brand/preview.html" "$OUT/preview.html"
cp "$REPO/client/brand/preview.html" "$PACK/index.html"
cp "$REPO/client/brand/preview.html" "$PACK/preview.html"

echo "done — 3 archives verified, $(ls "$OUT" | wc -l | tr -d ' ') files in client/pack/"
