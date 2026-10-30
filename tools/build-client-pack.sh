#!/usr/bin/env bash
#
# Build the Queen Dor's client pack: an installable child theme plus the
# product CSV and the two operator documents, zipped together.
#
#   ./tools/build-client-pack.sh
#
# Output: client/pack/luxrio-child-<version>.zip
#         client/pack/queendor-client-pack.zip
#
# Zips are gitignored on purpose — this script is the source of truth, and a
# binary archive in a repository is a merge conflict waiting to happen.

set -euo pipefail

REPO="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
THEME_DIR="$REPO/wp-content/themes/luxrio-child"
OUT="$REPO/client/pack"

# The header line is indented inside the comment block, so anchor on the label.
VERSION="$(sed -n 's/.*Version:[[:space:]]*\([0-9.]*\).*/\1/p' "$THEME_DIR/style.css" | head -n1 | tr -d '\r')"

if [ -z "$VERSION" ]; then
	echo "error: could not read Version from $THEME_DIR/style.css" >&2
	exit 1
fi

echo "packaging luxrio-child $VERSION"

rm -rf "$OUT"
mkdir -p "$OUT"

STAGE="$(mktemp -d)"
trap 'rm -rf "$STAGE"' EXIT

# Copy the theme without anything that should never ship.
mkdir -p "$STAGE/luxrio-child"
cp -R "$THEME_DIR/." "$STAGE/luxrio-child/"
find "$STAGE/luxrio-child" \( -name '*.zip' -o -name '.DS_Store' -o -name '*.log' -o -name 'Thumbs.db' \) -delete

THEME_ZIP="$OUT/luxrio-child-$VERSION.zip"
( cd "$STAGE" && zip -qr "$THEME_ZIP" luxrio-child )
echo "  $THEME_ZIP"

# The pack.
PACK="$STAGE/queendor-client-pack"
mkdir -p "$PACK"
cp "$THEME_ZIP" "$PACK/"
cp "$REPO/client/queendor-products.csv" "$PACK/"
cp "$REPO/client/IMPORT-GUIDE.md" "$PACK/"
cp "$REPO/client/policies.md" "$PACK/"

# The landing page links to these directly, so they live next to the archives too.
cp "$REPO/client/queendor-products.csv" "$OUT/"
cp "$REPO/client/IMPORT-GUIDE.md" "$OUT/"
cp "$REPO/client/policies.md" "$OUT/"

PACK_ZIP="$OUT/queendor-client-pack.zip"
( cd "$STAGE" && zip -qr "$PACK_ZIP" queendor-client-pack )
echo "  $PACK_ZIP"

# Sanity: one top-level folder per archive, and the theme still has its header.
for archive in "$THEME_ZIP" "$PACK_ZIP"; do
	top="$(unzip -Z1 "$archive" | awk -F/ '{print $1}' | sort -u | wc -l | tr -d ' ')"
	if [ "$top" != "1" ]; then
		echo "error: $(basename "$archive") has $top top-level entries, expected 1" >&2
		exit 1
	fi
done

unzip -p "$THEME_ZIP" luxrio-child/style.css | grep -q "Version: $VERSION" \
	|| { echo "error: style.css version missing inside the zip" >&2; exit 1; }


# A landing page for the download server, so the pack is two clicks away.
cat > "$OUT/index.html" <<HTML
<!doctype html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Queen Dor's — client pack</title>
<style>
  body{margin:0;padding:48px 20px;font:16px/1.6 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;color:#1a1d21;background:#f7f8fa}
  .w{max-width:720px;margin:0 auto}
  h1{font-size:26px;margin:0 0 6px;letter-spacing:-.02em}
  p.sub{color:#6b7280;margin:0 0 28px;font-size:15px}
  a.card{display:block;padding:18px 22px;margin-bottom:14px;background:#fff;border:1px solid #e5e7eb;border-left:4px solid #c8a24a;border-radius:8px;text-decoration:none;color:inherit}
  a.card:hover{background:#faf8f4}
  a.card strong{display:block;font-size:16px;margin-bottom:3px}
  a.card span{font-size:13.5px;color:#6b7280}
  .n{font-size:13px;color:#6b7280;margin-top:26px;padding-top:18px;border-top:1px solid #e5e7eb}
  code{background:#f4f5f7;border:1px solid #e5e7eb;border-radius:4px;padding:1px 5px;font-size:13px}
</style></head><body><div class="w">
<h1>Queen Dor's — client pack</h1>
<p class="sub">Child theme $VERSION plus the product catalogue and operator documents. Everything here is generated from the repository by <code>tools/build-client-pack.sh</code>.</p>

<a class="card" href="luxrio-child-$VERSION.zip">
  <strong>luxrio-child-$VERSION.zip</strong>
  <span>Appearance → Themes → Upload Theme. Symbol panels, care notes, ring-size tab, WhatsApp buttons, shop settings.</span>
</a>

<a class="card" href="queendor-client-pack.zip">
  <strong>queendor-client-pack.zip</strong>
  <span>Everything below in one archive — the theme, the CSV, and both documents.</span>
</a>

<a class="card" href="queendor-products.csv">
  <strong>queendor-products.csv</strong>
  <span>10 products, 18 size variations. Products → All Products → Import.</span>
</a>

<a class="card" href="IMPORT-GUIDE.md">
  <strong>IMPORT-GUIDE.md</strong>
  <span>Seven steps in order, with the placeholder prices that must be replaced.</span>
</a>

<a class="card" href="policies.md">
  <strong>policies.md</strong>
  <span>Shipping, returns, privacy (Act 843), care and about copy.</span>
</a>

<p class="n">Prices and materials in the CSV are placeholders — see step 5 of the guide before the shop goes public.</p>
</div></body></html>
HTML

echo "done — both archives verified"
