#!/usr/bin/env bash
# Rebuild the luxrio-core plugin bundle that the theme's TGMPA installer ships.
# Source of truth: wp-content/plugins/luxrio-core/  (git-tracked)
# Output:          wp-content/themes/luxrio/inc/luxrio-framework/plugins/luxrio-core.zip
#
# Run this whenever you patch wp-content/plugins/luxrio-core/ so the installer
# and the deployed plugin never drift apart.
set -euo pipefail

root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
src="$root/wp-content/plugins/luxrio-core"
out="$root/wp-content/themes/luxrio/inc/luxrio-framework/plugins/luxrio-core.zip"

[ -d "$src" ] || { echo "missing plugin source: $src" >&2; exit 1; }

rm -f "$out"
( cd "$root/wp-content/plugins" && zip -rq "$out" luxrio-core -x '*.DS_Store' '*/.git/*' )
echo "built $(basename "$out") ($(du -h "$out" | cut -f1))"
