#!/usr/bin/env python3
"""Audit the theme's WooCommerce template overrides against WooCommerce core.

Compares every file in <theme>/woocommerce/ with the matching file in
woocommerce/plugins/woocommerce/templates and reports:

  current   the theme's @version matches core  -> core has not touched it since
  stale     @version differs                   -> core changed; merge required
  custom    no core counterpart                -> theme-specific template

Usage:
    python3 tools/wc-template-audit.py \
        --theme wp-content/themes/luxrio/woocommerce \
        --core  /path/to/woocommerce/plugins/woocommerce/templates

Get an official core copy with:
    curl -L -o wc.tar.gz https://codeload.github.com/woocommerce/woocommerce/tar.gz/refs/tags/<TAG>
    tar xzf wc.tar.gz --wildcards '*/plugins/woocommerce/templates/*'

Advisory: a matching @version means core has not bumped the template since the
override was made. It does not prove the override is semantically correct —
still smoke-test the rendered page.
"""

import argparse
import pathlib
import re


def version_of(text: str):
    match = re.search(r"@version\s+([0-9][0-9A-Za-z.\-]*)", text)
    return match.group(1) if match else "—"


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("--theme", required=True, help="theme's woocommerce/ directory")
    ap.add_argument("--core", required=True, help="WooCommerce core templates/ directory")
    args = ap.parse_args()

    theme = pathlib.Path(args.theme)
    core = pathlib.Path(args.core)

    if not theme.is_dir():
        raise SystemExit(f"theme override dir not found: {theme}")
    if not core.is_dir():
        raise SystemExit(f"core templates dir not found: {core}")

    counts = {"current": 0, "stale": 0, "custom": 0, "missing": 0}
    rows = []

    for path in sorted(theme.rglob("*.php")):
        rel = path.relative_to(theme)
        theme_ver = version_of(path.read_text(encoding="utf-8", errors="ignore"))
        target = core / rel

        if not target.exists():
            counts["custom"] += 1
            rows.append((str(rel), theme_ver, "—", "custom", "no core counterpart"))
            continue

        core_ver = version_of(target.read_text(encoding="utf-8", errors="ignore"))
        if theme_ver == core_ver:
            counts["current"] += 1
            status = "current"
        else:
            counts["stale"] += 1
            status = "stale"
        rows.append((str(rel), theme_ver, core_ver, status, ""))

    print("| Template | Theme | Core | Status |")
    print("|---|---|---|---|")
    for rel, tv, cv, status, note in rows:
        flag = {"current": "OK", "stale": "MERGE", "custom": "n/a"}[status]
        print(f"| `{rel}` | {tv} | {cv} | {flag} {note} |".rstrip())

    print()
    print(f"overrides: {len(rows)} | current: {counts['current']} | "
          f"stale: {counts['stale']} | custom: {counts['custom']}")
    return 1 if counts["stale"] else 0


if __name__ == "__main__":
    raise SystemExit(main())
