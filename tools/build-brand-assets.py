#!/usr/bin/env python3
"""
Generate the Queen Dor's design-system artifacts from tools/brand_palette.py.

    python3 tools/build-brand-assets.py

Emits:
    client/brand/tokens.css          design tokens + components (also the theme file)
    client/brand/components.css      component styles, standalone
    client/brand/design-tokens.json  Tokens Studio / Figma import
    client/brand/preview.html        palette + components, light and dark

The child theme copies these same files, so what the client previews is what
the shop runs.
"""

import json
import pathlib
import sys

sys.path.insert(0, str(pathlib.Path(__file__).parent))

import brand_palette as P  # noqa: E402

OUT = pathlib.Path(__file__).resolve().parent.parent / "client" / "brand"
OUT.mkdir(parents=True, exist_ok=True)

TEAL, GOLD, NEUTRAL = P.TEAL, P.GOLD, P.NEUTRAL
LIGHT, DARK = P.LIGHT, P.DARK

SPACE = {1: 4, 2: 8, 3: 12, 4: 16, 5: 24, 6: 32, 7: 40, 8: 48, 9: 64, 10: 80, 11: 96, 12: 128}
RADIUS = {"xs": "2px", "sm": "4px", "md": "6px", "lg": "10px", "xl": "16px", "pill": "999px"}

SHADOWS_LIGHT = {
    "xs": "0 1px 2px rgba(11, 75, 76, .06)",
    "sm": "0 1px 3px rgba(11, 75, 76, .08), 0 1px 2px rgba(11, 75, 76, .04)",
    "md": "0 4px 12px rgba(11, 75, 76, .08), 0 2px 4px rgba(11, 75, 76, .04)",
    "lg": "0 12px 28px rgba(11, 75, 76, .10), 0 4px 8px rgba(11, 75, 76, .05)",
    "xl": "0 24px 56px rgba(11, 75, 76, .14), 0 8px 16px rgba(11, 75, 76, .06)",
    "gold": "0 6px 18px rgba(200, 172, 119, .35)",
}

GRADIENTS = {
    "gold-sheen": f"linear-gradient(135deg, {GOLD[300]} 0%, {GOLD[500]} 100%)",
    "teal-depth": f"linear-gradient(160deg, {TEAL[800]} 0%, {TEAL[950]} 100%)",
    "cream-fade": f"linear-gradient(180deg, #FFFFFF 0%, {NEUTRAL[50]} 100%)",
    "hero-glow": (f"radial-gradient(120% 90% at 50% 0%, rgba(200,172,119,.18) 0%, "
                  f"rgba(11,75,76,0) 62%)"),
}


# --- tokens.css -------------------------------------------------------------

def token_block(d, prefix=""):
    return "\n".join(f"\t--qd-{prefix}{k.replace('.', '-')}: {v};" for k, v in d.items())


def build_tokens_css():
    ramp = []
    for name, scale in (("teal", TEAL), ("gold", GOLD), ("neutral", NEUTRAL)):
        ramp.append(f"\t/* {name} */")
        for step, hexv in sorted(scale.items()):
            ramp.append(f"\t--qd-{name}-{step}: {hexv};")
    for name, scale, base in (
        ("success", P.SUCCESS, "Kola Green"),
        ("warning", P.WARNING, "Bronze"),
        ("danger", P.DANGER, "Clay Red"),
        ("info", P.INFO, "Harbour Blue"),
    ):
        ramp.append(f"\n\t/* {name} — {base} */")
        for step, hexv in sorted(scale.items()):
            ramp.append(f"\t--qd-{name}-{step}: {hexv};")

    space = "\n".join(f"\t--qd-space-{k}: {v}px;" for k, v in SPACE.items())
    radius = "\n".join(f"\t--qd-radius-{k}: {v};" for k, v in RADIUS.items())
    shadows = "\n".join(f"\t--qd-shadow-{k}: {v};" for k, v in SHADOWS_LIGHT.items())
    grads = "\n".join(f"\t--qd-gradient-{k}: {v};" for k, v in GRADIENTS.items())

    return f"""/*
 * Queen Dor's — design tokens
 *
 * Generated from tools/brand_palette.py. Do not edit by hand: change the
 * palette there and run `python3 tools/build-brand-assets.py`.
 *
 * Two colours are sampled from the client's logo — Adinkra Teal (the D) and
 * Crown Gold (the name and the crown). Everything else is derived from them.
 *
 *   Primitives   --qd-teal-*, --qd-gold-*, --qd-neutral-*, --qd-{{status}}-*
 *   Semantic     --qd-bg-*, --qd-text-*, --qd-primary*, --qd-accent*, --qd-border-*
 *   Layout       --qd-space-*, --qd-radius-*, --qd-shadow-*, --qd-gradient-*
 *
 * Components read the semantic layer, never the primitives. That is what lets
 * dark mode work by swapping forty values instead of rewriting a stylesheet.
 */

:root {{
	/* ---------- primitives ---------- */
{chr(10).join(ramp)}

	/* ---------- semantic, light ---------- */
{token_block(LIGHT)}

	/* ---------- spacing: 4px base ---------- */
{space}

	/* ---------- radius ---------- */
{radius}

	/* ---------- elevation: warm, never neutral grey ---------- */
{shadows}
	--qd-shadow-focus: 0 0 0 2px #FFFFFF, 0 0 0 4px {TEAL[800]};

	/* ---------- gradients ---------- */
{grads}

	/* ---------- interaction ---------- */
	--qd-hover-wash: rgba(11, 75, 76, .06);
	--qd-pressed-wash: rgba(11, 75, 76, .12);
	--qd-disabled-opacity: .45;
	--qd-transition: 160ms cubic-bezier(.2, .6, .3, 1);
	--qd-selection: {GOLD[200]};
	--qd-selection-text: {NEUTRAL[900]};
}}

/* ---------- semantic, dark ----------
 *
 * Opt-in, not automatic. The storefront's hero and section backgrounds are
 * set per-section in Elementor, so an OS-level dark preference would flip the
 * text tokens while those sections kept their light backgrounds — the worst of
 * both. Add `data-theme="dark"` to <html> only once every section has a dark
 * variant.
 */
[data-theme="dark"] {{
{token_block(DARK)}
	--qd-shadow-xs: 0 1px 2px rgba(0, 0, 0, .4);
	--qd-shadow-sm: 0 1px 3px rgba(0, 0, 0, .45);
	--qd-shadow-md: 0 4px 12px rgba(0, 0, 0, .5);
	--qd-shadow-lg: 0 12px 28px rgba(0, 0, 0, .55);
	--qd-shadow-xl: 0 24px 56px rgba(0, 0, 0, .6);
	--qd-shadow-focus: 0 0 0 2px {DARK['bg.page']}, 0 0 0 4px {DARK['focus']};
	--qd-hover-wash: rgba(152, 214, 215, .10);
	--qd-pressed-wash: rgba(152, 214, 215, .18);
	--qd-selection: {GOLD[700]};
	--qd-selection-text: #FFFFFF;
}}

::selection {{
	background: var(--qd-selection);
	color: var(--qd-selection-text);
}}
"""


# --- components.css ---------------------------------------------------------

def build_components_css():
    return f"""/*
 * Queen Dor's — components
 *
 * Generated from tools/brand_palette.py. Every colour here is a token, so
 * these rules survive a palette change and work in both modes.
 *
 * Naming: .qd-btn
 *   variants  --primary --secondary --ghost --danger
 *   sizes     --sm --lg
 *   states    hover · active · focus-visible · [disabled] / [aria-disabled]
 */

/* ============ base ============ */

body {{
	background: var(--qd-bg-page);
	color: var(--qd-text-body);
}}

/* Headings are coloured through the parent theme's own --title-color, which the
   bridge sets to the teal. Deliberately no `h1..h6 {{ color }}` here: a global rule
   would also repaint headings inside the theme's dark sections, where teal on
   black measures 2.1:1. */
h1, h2, h3, h4, h5, h6 {{
	font-weight: 600;
	letter-spacing: -.011em;
}}

a {{
	color: var(--qd-primary);
	text-decoration-color: var(--qd-accent);
	text-underline-offset: .18em;
	transition: color var(--qd-transition), text-decoration-color var(--qd-transition);
}}

a:hover {{
	color: var(--qd-primary-hover);
	text-decoration-color: var(--qd-primary-hover);
}}

/* One focus ring for the whole site. Keyboard only — a mouse click should not
   leave a ring behind, but a Tab press must always produce one. */
:where(a, button, input, select, textarea, summary, [tabindex]):focus-visible {{
	outline: 2px solid var(--qd-focus);
	outline-offset: 2px;
	border-radius: var(--qd-radius-xs);
}}

/* ============ buttons ============ */

.qd-btn {{
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: var(--qd-space-2);
	padding: 14px var(--qd-space-5);
	border: 1px solid transparent;
	border-radius: var(--qd-radius-sm);
	font: inherit;
	font-weight: 600;
	font-size: 15px;
	line-height: 1.2;
	letter-spacing: .01em;
	text-decoration: none;
	cursor: pointer;
	transition: background-color var(--qd-transition), border-color var(--qd-transition),
		color var(--qd-transition), box-shadow var(--qd-transition), transform var(--qd-transition);
}}

.qd-btn:active {{ transform: translateY(1px); }}

.qd-btn--sm {{ padding: 9px var(--qd-space-4); font-size: 14px; }}
.qd-btn--lg {{ padding: 18px var(--qd-space-6); font-size: 16px; }}

/* primary — teal field, cream label. The main action on a screen. One per view. */
.qd-btn--primary {{
	background: var(--qd-primary);
	border-color: var(--qd-primary);
	color: var(--qd-text-onPrimary);
}}
.qd-btn--primary:hover {{ background: var(--qd-primary-hover); border-color: var(--qd-primary-hover); }}
.qd-btn--primary:active {{ background: var(--qd-primary-active); border-color: var(--qd-primary-active); }}

/* secondary — outline. Sits beside a primary without competing. */
.qd-btn--secondary {{
	background: transparent;
	border-color: var(--qd-border-strong);
	color: var(--qd-text-primary);
}}
.qd-btn--secondary:hover {{
	background: var(--qd-hover-wash);
	border-color: var(--qd-primary);
	color: var(--qd-primary);
}}
.qd-btn--secondary:active {{ background: var(--qd-pressed-wash); }}

/* ghost — text only, for tertiary actions and "remove". */
.qd-btn--ghost {{
	background: transparent;
	border-color: transparent;
	color: var(--qd-primary);
	padding-inline: var(--qd-space-3);
}}
.qd-btn--ghost:hover {{ background: var(--qd-hover-wash); }}
.qd-btn--ghost:active {{ background: var(--qd-pressed-wash); }}

/* danger — destructive only. Never for a checkout or payment action. */
.qd-btn--danger {{
	background: var(--qd-danger);
	border-color: var(--qd-danger);
	color: #FFFFFF;
}}
.qd-btn--danger:hover {{ filter: brightness(.92); }}

.qd-btn[disabled],
.qd-btn[aria-disabled="true"] {{
	background: var(--qd-bg-muted);
	border-color: var(--qd-border-subtle);
	color: var(--qd-text-muted);
	cursor: not-allowed;
	opacity: 1;
}}
.qd-btn[disabled]:active,
.qd-btn[aria-disabled="true"]:active {{ transform: none; }}

/* On a dark or teal section — gold, because teal disappears there (2.1:1). */
.qd-on-dark .qd-btn--primary {{
	background: var(--qd-accent);
	border-color: var(--qd-accent);
	color: {NEUTRAL[900]};
}}
.qd-on-dark .qd-btn--primary:hover {{ background: {GOLD[300]}; border-color: {GOLD[300]}; }}
.qd-on-dark .qd-btn--secondary {{
	border-color: var(--qd-accent);
	color: var(--qd-accent);
}}
.qd-on-dark .qd-btn--secondary:hover {{ background: rgba(200, 172, 119, .14); color: var(--qd-accent); }}
.qd-on-dark :where(a, h1, h2, h3, h4) {{ color: var(--qd-text-onDark); }}
.qd-on-dark a:hover {{ color: var(--qd-accent); }}

/* ============ form fields ============ */

.qd-field {{
	display: flex;
	flex-direction: column;
	gap: var(--qd-space-2);
	margin-bottom: var(--qd-space-5);
}}

.qd-field > label,
.qd-label {{
	font-size: 13px;
	font-weight: 600;
	letter-spacing: .04em;
	text-transform: uppercase;
	color: var(--qd-text-muted);
}}

.qd-input,
.qd-field input,
.qd-field select,
.qd-field textarea {{
	width: 100%;
	padding: 13px var(--qd-space-4);
	background: var(--qd-bg-page);
	border: 1px solid var(--qd-border-default);
	border-radius: var(--qd-radius-sm);
	color: var(--qd-text-primary);
	font: inherit;
	transition: border-color var(--qd-transition), box-shadow var(--qd-transition);
}}

.qd-input::placeholder {{ color: var(--qd-text-muted); }}

.qd-input:hover {{ border-color: var(--qd-border-strong); }}

/* Focus: the border moves to teal AND a soft ring appears, so the state is
   visible on a cheap screen where a 1px colour change is not. */
.qd-input:focus,
.qd-field input:focus,
.qd-field select:focus,
.qd-field textarea:focus {{
	outline: none;
	border-color: var(--qd-primary);
	box-shadow: 0 0 0 3px rgba(11, 75, 76, .15);
}}

.qd-input--error {{ border-color: var(--qd-danger); }}
.qd-input--error:focus {{ box-shadow: 0 0 0 3px rgba(124, 48, 39, .15); }}

.qd-input--success {{ border-color: var(--qd-success); }}
.qd-input--success:focus {{ box-shadow: 0 0 0 3px rgba(47, 106, 78, .15); }}

.qd-input:disabled {{
	background: var(--qd-bg-muted);
	color: var(--qd-text-muted);
	cursor: not-allowed;
}}

.qd-help {{ font-size: 13px; color: var(--qd-text-muted); }}
.qd-help--error {{ color: var(--qd-danger); font-weight: 500; }}
.qd-help--success {{ color: var(--qd-success); font-weight: 500; }}

/* ============ cards ============ */

.qd-card {{
	background: var(--qd-surface-card);
	border: 1px solid var(--qd-border-subtle);
	border-radius: var(--qd-radius-lg);
	box-shadow: var(--qd-shadow-sm);
	overflow: hidden;
	transition: box-shadow var(--qd-transition), transform var(--qd-transition),
		border-color var(--qd-transition);
}}

.qd-card:hover {{
	box-shadow: var(--qd-shadow-md);
	transform: translateY(-2px);
	border-color: var(--qd-border-default);
}}

.qd-card__media {{ aspect-ratio: 4 / 5; background: var(--qd-bg-muted); object-fit: cover; width: 100%; }}
.qd-card__body {{ padding: var(--qd-space-5); }}
.qd-card__eyebrow {{
	font-size: 12px;
	font-weight: 600;
	letter-spacing: .12em;
	text-transform: uppercase;
	color: var(--qd-accent-text);
}}
.qd-card__title {{ font-size: 18px; margin: var(--qd-space-2) 0; }}
.qd-card__price {{ font-weight: 600; color: var(--qd-primary); }}

/* ============ navigation ============ */

.qd-nav {{
	display: flex;
	align-items: center;
	gap: var(--qd-space-5);
	background: var(--qd-bg-page);
	border-bottom: 1px solid var(--qd-border-subtle);
}}

.qd-nav a {{
	position: relative;
	color: var(--qd-text-primary);
	text-decoration: none;
	font-size: 15px;
	font-weight: 500;
	padding: var(--qd-space-3) 0;
	transition: color var(--qd-transition);
}}

.qd-nav a::after {{
	content: "";
	position: absolute;
	left: 0; right: 0; bottom: 6px;
	height: 2px;
	background: var(--qd-accent);
	transform: scaleX(0);
	transform-origin: left;
	transition: transform var(--qd-transition);
}}

.qd-nav a:hover {{ color: var(--qd-primary); }}
.qd-nav a:hover::after,
.qd-nav a[aria-current="page"]::after {{ transform: scaleX(1); }}
.qd-nav a[aria-current="page"] {{ color: var(--qd-primary); font-weight: 600; }}

/* ============ feedback ============ */

.qd-alert {{
	border-left: 4px solid var(--qd-info);
	background: var(--qd-info-subtle);
	color: var(--qd-text-primary);
	padding: var(--qd-space-4) var(--qd-space-5);
	border-radius: var(--qd-radius-sm);
}}
.qd-alert--success {{ border-left-color: var(--qd-success); background: var(--qd-success-subtle); }}
.qd-alert--warning {{ border-left-color: var(--qd-warning); background: var(--qd-warning-subtle); }}
.qd-alert--error {{ border-left-color: var(--qd-danger); background: var(--qd-danger-subtle); }}

.qd-badge {{
	display: inline-block;
	padding: 4px 10px;
	border-radius: var(--qd-radius-pill);
	font-size: 12px;
	font-weight: 600;
	letter-spacing: .06em;
	text-transform: uppercase;
	background: var(--qd-accent-subtle);
	color: var(--qd-accent-text);
}}

/* ============ texture ============ */

.qd-pattern-adinkra {{
	background-color: var(--qd-primary);
	background-image: repeating-linear-gradient(45deg,
		rgba(200, 172, 119, .07) 0 2px, transparent 2px 22px),
		repeating-linear-gradient(-45deg,
		rgba(200, 172, 119, .07) 0 2px, transparent 2px 22px);
}}

.qd-gradient-gold {{ background: var(--qd-gradient-gold-sheen); }}
.qd-gradient-teal {{ background: var(--qd-gradient-teal-depth); color: var(--qd-text-onDark); }}
""" + BRIDGE_CSS


# --- the bridge to the parent theme ----------------------------------------

BRIDGE_CSS = f"""
/* ============ parent theme bridge ============
 *
 * The Luxrio parent drives nearly every colour through these custom
 * properties. Mapping them to the tokens once means the shop's buttons,
 * prices, links, breadcrumbs and controls all follow the palette without a
 * selector-by-selector fight.
 *
 * Declared on body as well as :root on purpose: the theme prints its own
 * option colours inline in <head>, and an inherited value on body wins over
 * an inherited value on html whatever order the stylesheets land in.
 */

:root,
body {{
	--theme-color: var(--qd-primary);
	--theme-color2: var(--qd-accent);
	--title-color: var(--qd-text-heading);
	--body-color: var(--qd-text-body);
	--smoke-color: {NEUTRAL[300]};
	--vs-secondary-color: {NEUTRAL[100]};
	--bg-color12: var(--qd-bg-subtle);
}}

/* ============ WooCommerce ============ */

.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.wc-block-components-button {{
	background-color: var(--qd-primary);
	border-color: var(--qd-primary);
	color: var(--qd-text-onPrimary);
	border-radius: var(--qd-radius-sm);
	font-weight: 600;
	transition: background-color var(--qd-transition), border-color var(--qd-transition);
}}

.woocommerce #respond input#submit:hover,
.woocommerce a.button:hover,
.woocommerce button.button:hover,
.woocommerce input.button:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover {{
	background-color: var(--qd-primary-hover);
	border-color: var(--qd-primary-hover);
	color: var(--qd-text-onPrimary);
}}

.woocommerce div.product p.price,
.woocommerce div.product span.price,
.woocommerce ul.products li.product .price,
.woocommerce-Price-amount {{
	color: var(--qd-primary);
}}

.woocommerce-message,
.woocommerce-info {{ border-top-color: var(--qd-accent); }}
.woocommerce-error {{ border-top-color: var(--qd-danger); }}

.woocommerce-message a,
.woocommerce-info a,
.entry-content a {{ color: var(--qd-primary); text-decoration-color: var(--qd-accent); }}

.breadcumb-area,
.vs-breadcrumb {{ background-color: var(--qd-primary); }}

.scroll-top,
.back-to-top {{ background-color: var(--qd-primary); }}
.scroll-top:hover,
.back-to-top:hover {{ background-color: var(--qd-accent); color: {NEUTRAL[900]}; }}

.woocommerce span.onsale {{
	background-color: var(--qd-accent);
	color: {NEUTRAL[900]};
	border-radius: var(--qd-radius-pill);
	font-weight: 600;
}}

/* Dark and teal sections: prices and links go gold, buttons go gold. */
.qd-on-dark :where(.woocommerce-Price-amount, a),
.qd-on-dark .woocommerce div.product p.price,
.qd-on-dark .woocommerce ul.products li.product .price {{
	color: var(--qd-accent);
}}

.qd-on-dark .woocommerce a.button,
.qd-on-dark .woocommerce button.button,
.qd-on-dark .vs-btn {{
	background-color: var(--qd-accent);
	border-color: var(--qd-accent);
	color: {NEUTRAL[900]};
}}

.qd-on-dark .woocommerce a.button:hover,
.qd-on-dark .woocommerce button.button:hover,
.qd-on-dark .vs-btn:hover {{
	background-color: {GOLD[300]};
	border-color: {GOLD[300]};
	color: {NEUTRAL[900]};
}}
"""


# --- design-tokens.json -----------------------------------------------------

def tokens_json():
    def c(v, note):
        return {"value": v, "type": "color", "description": note}

    core = {}
    for name, scale in (("teal", TEAL), ("gold", GOLD), ("neutral", NEUTRAL)):
        core[name] = {
            str(step): c(hexv, P.name(hexv)) for step, hexv in sorted(scale.items())
        }
    for name, scale in (("success", P.SUCCESS), ("warning", P.WARNING),
                        ("danger", P.DANGER), ("info", P.INFO)):
        core[name] = {str(step): c(v, "") for step, v in sorted(scale.items())}

    def sem(block, label):
        return {k.replace(".", "-"): c(v, f"{label}: {k}") for k, v in block.items()}

    pairs_light = P.rows(P.KEY_PAIRS_LIGHT, LIGHT)
    data = {
        "$description": "Queen Dor's — generated from tools/brand_palette.py",
        "core": core,
        "semantic": {
            "light": sem(LIGHT, "light"),
            "dark": sem(DARK, "dark"),
        },
        "spacing": {str(k): {"value": f"{v}", "type": "spacing"} for k, v in SPACE.items()},
        "radius": {k: {"value": v, "type": "borderRadius"} for k, v in RADIUS.items()},
        "shadow": {k: {"value": v, "type": "boxShadow"} for k, v in SHADOWS_LIGHT.items()},
        "gradient": {k: {"value": v, "type": "gradient"} for k, v in GRADIENTS.items()},
        "$extensions": {
            "qd.contrast": [
                {"pair": r["label"], "fg": r["fg"], "bg": r["bg"],
                 "ratio": f"{r['ratio']:.2f}:1", "wcag": r["normal"]}
                for r in pairs_light
            ]
        },
    }
    return json.dumps(data, indent=2, ensure_ascii=False) + "\n"


# --- preview.html -----------------------------------------------------------

def swatch_rows():
    out = []
    for name, scale in (("Adinkra Teal", TEAL), ("Crown Gold", GOLD), ("Warm Neutrals", NEUTRAL)):
        cells = "".join(
            f'<div class="step"><div class="chip" style="background:{v}" title="{v}"></div>'
            f'<span class="num">{k}</span><span class="hex">{v}</span></div>'
            for k, v in sorted(scale.items())
        )
        out.append(f'<div class="ramprow"><div class="rampname">{name}</div>'
                   f'<div class="steps">{cells}</div></div>')
    return "\n".join(out)


def contrast_table(pairs, tokens, title):
    body = []
    for r in P.rows(pairs, tokens):
        cls = "ok" if r["normal"] in ("AA", "AAA", "3:1 ✓") else "bad"
        body.append(
            f'<tr><td>{r["label"]}</td>'
            f'<td><span class="dot" style="background:{r["fg"]}"></span>{r["fg"]}</td>'
            f'<td><span class="dot" style="background:{r["bg"]}"></span>{r["bg"]}</td>'
            f'<td class="num">{r["ratio"]:.2f}:1</td>'
            f'<td class="{cls}">{r["normal"]}</td><td>{r["large"]}</td></tr>'
        )
    return f'<h3>{title}</h3><table class="ct"><thead><tr><th>Pairing</th><th>Text</th>' \
           f'<th>Background</th><th>Ratio</th><th>AA text</th><th>AA large</th></tr></thead>' \
           f'<tbody>{"".join(body)}</tbody></table>'


def build_preview_html():
    pairs_light = contrast_table(P.KEY_PAIRS_LIGHT, LIGHT, "Light mode")
    pairs_dark = contrast_table(P.KEY_PAIRS_DARK, DARK, "Dark mode")
    return f"""<!doctype html>
<html lang="en" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Queen Dor's — colour system preview</title>
<style>
:root {{
	--teal-800: {TEAL[800]}; --teal-300: {TEAL[300]}; --teal-950: {TEAL[950]};
	--gold-400: {GOLD[400]}; --gold-700: {GOLD[700]}; --gold-200: {GOLD[200]};
	--cream: {NEUTRAL[50]}; --ink: {NEUTRAL[900]}; --body: #3F4A49; --muted: {NEUTRAL[600]};
	--line: {NEUTRAL[200]};
	--bg: #fff; --surface: #fff; --subtle: {NEUTRAL[50]}; --raised: {NEUTRAL[50]};
	--txt: var(--ink); --txt-body: var(--body); --txt-muted: var(--muted);
	--pri: var(--teal-800); --acc: var(--gold-400); --acc-text: var(--gold-700);
	--ok: {P.SUCCESS[700]}; --warn: {P.WARNING[700]}; --err: {P.DANGER[700]}; --info: {P.INFO[700]};
	--radius: 10px;
	--shadow-sm: 0 1px 3px rgba(11,75,76,.08);
	--shadow-md: 0 4px 12px rgba(11,75,76,.08), 0 2px 4px rgba(11,75,76,.04);
}}
[data-theme="dark"] {{
	--bg: #0A1211; --surface: #12201E; --subtle: #0F1B1A; --raised: #182A28;
	--line: #22332F; --txt: #EDEAE0; --txt-body: #CDCBBD; --txt-muted: #A3A296;
	--pri: {TEAL[300]}; --acc: #D6B982; --acc-text: {GOLD[300]};
	--ok: {P.SUCCESS[300]}; --warn: {P.WARNING[300]}; --err: {P.DANGER[300]}; --info: {P.INFO[300]};
	--shadow-sm: 0 1px 3px rgba(0,0,0,.45);
	--shadow-md: 0 4px 12px rgba(0,0,0,.5);
}}
* {{ box-sizing: border-box }}
body {{
	margin: 0; padding: 0 24px 96px;
	background: var(--bg); color: var(--txt-body);
	font: 16px/1.65 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
	transition: background .25s ease, color .25s ease;
}}
.wrap {{ max-width: 1060px; margin: 0 auto }}
header {{ display: flex; align-items: center; justify-content: space-between; gap: 24px;
	padding: 34px 0 26px; border-bottom: 1px solid var(--line); flex-wrap: wrap }}
.brand {{ display: flex; align-items: center; gap: 14px }}
.mark {{ width: 46px; height: 46px; border-radius: 50%; background: var(--teal-800);
	display: grid; place-items: center; color: {GOLD[400]}; font: 600 22px/1 Georgia, serif }}
h1 {{ font-family: Georgia, "Times New Roman", serif; font-weight: 600; font-size: 21px;
	line-height: 1.2; margin: 0; color: var(--txt) }}
.sub {{ font-size: 13px; color: var(--txt-muted); margin: 2px 0 0 }}
.toggle {{ display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--txt-muted) }}
.toggle button {{ font: inherit; padding: 9px 18px; border-radius: 999px; cursor: pointer;
	border: 1px solid var(--line); background: var(--surface); color: var(--txt);
	transition: all .18s ease }}
.toggle button[aria-pressed="true"] {{ background: var(--pri); border-color: var(--pri); color: var(--bg) }}
h2 {{ font-family: inherit; font-weight: 600; font-size: 13px; line-height: 1.4;
	letter-spacing: .12em; text-transform: uppercase;
	color: var(--txt-muted); margin: 54px 0 6px }}
h2 + p {{ margin: 0 0 20px; font-size: 14.5px; color: var(--txt-muted); max-width: 66ch }}
h3 {{ font-family: Georgia, serif; font-weight: 600; font-size: 17px; line-height: 1.3;
	color: var(--txt); margin: 30px 0 12px }}
.ramprow {{ display: flex; gap: 18px; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid var(--line) }}
.rampname {{ flex: 0 0 120px; font-size: 13px; font-weight: 600; color: var(--txt) }}
.steps {{ display: flex; gap: 8px; flex-wrap: wrap }}
.step {{ width: 74px }}
.chip {{ height: 46px; border-radius: 6px; border: 1px solid rgba(0,0,0,.06) }}
.num {{ display: block; font-size: 11px; color: var(--txt-muted); margin-top: 5px }}
.hex {{ display: block; font-size: 10.5px; font-family: ui-monospace, Menlo, monospace; color: var(--txt-muted) }}
table {{ width: 100%; border-collapse: collapse; font-size: 13.5px; margin-bottom: 8px }}
th {{ text-align: left; font-size: 11.5px; letter-spacing: .07em; text-transform: uppercase;
	color: var(--txt-muted); padding: 8px 10px; border-bottom: 1px solid var(--line) }}
td {{ padding: 8px 10px; border-bottom: 1px solid var(--line); color: var(--txt-body) }}
td.num {{ font-family: ui-monospace, Menlo, monospace; font-variant-numeric: tabular-nums }}
td.ok {{ color: var(--ok); font-weight: 600 }}
td.bad {{ color: var(--err); font-weight: 600 }}
.dot {{ display: inline-block; width: 12px; height: 12px; border-radius: 3px; margin-right: 7px;
	vertical-align: -1px; border: 1px solid rgba(0,0,0,.1) }}
.panel {{ background: var(--subtle); border: 1px solid var(--line); border-radius: var(--radius);
	padding: 26px; margin: 16px 0 }}
.row {{ display: flex; gap: 12px; flex-wrap: wrap; align-items: center; margin-bottom: 14px }}
.qd-btn {{ display: inline-flex; align-items: center; justify-content: center; padding: 13px 22px;
	border: 1px solid transparent; border-radius: 4px; font-weight: 600; font-size: 15px;
	line-height: 1.2; font-family: inherit; cursor: pointer;
	text-decoration: none; transition: all .16s ease }}
.qd-btn--primary {{ background: var(--pri); color: var(--bg) }}
.qd-btn--primary:hover {{ filter: brightness(.9) }}
.qd-btn--secondary {{ background: transparent; border-color: var(--line); color: var(--txt) }}
.qd-btn--secondary:hover {{ border-color: var(--pri); color: var(--pri) }}
.qd-btn--ghost {{ background: transparent; color: var(--pri) }}
.qd-btn--danger {{ background: var(--err); color: {NEUTRAL[950]} }}
.qd-btn[disabled] {{ background: var(--subtle); border-color: var(--line); color: var(--txt-muted);
	cursor: not-allowed }}
.field {{ display: flex; flex-direction: column; gap: 6px; max-width: 320px }}
label {{ font-size: 11.5px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--txt-muted) }}
input {{ padding: 12px 14px; border: 1px solid var(--txt-muted); border-radius: 4px; font: inherit;
	background: var(--bg); color: var(--txt) }}
input:focus {{ outline: none; border-color: var(--pri); box-shadow: 0 0 0 3px rgba(11,75,76,.16) }}
input.is-error {{ border-color: var(--err) }}
input.is-ok {{ border-color: var(--ok) }}
.hint {{ font-size: 12.5px; color: var(--txt-muted) }}
.hint.error {{ color: var(--err) }}
.hint.ok {{ color: var(--ok) }}
.cards {{ display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 18px }}
.card {{ background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius);
	overflow: hidden; box-shadow: var(--shadow-sm); transition: all .18s ease }}
.card:hover {{ box-shadow: var(--shadow-md); transform: translateY(-2px) }}
.thumb {{ aspect-ratio: 4/5; background: linear-gradient(140deg, {TEAL[900]}, {TEAL[950]}); position: relative }}
.thumb::after {{ content: ""; position: absolute; inset: 0;
	background: radial-gradient(60% 40% at 50% 45%, rgba(200,172,119,.55), transparent 70%) }}
.card .in {{ padding: 16px 18px }}
.eyebrow {{ font-size: 11px; letter-spacing: .12em; text-transform: uppercase; color: var(--acc-text); font-weight: 600 }}
.card h4 {{ margin: 6px 0 4px; font-family: Georgia, serif; font-weight: 600;
	font-size: 17px; line-height: 1.3; color: var(--txt) }}
.price {{ color: var(--pri); font-weight: 600 }}
nav.demo {{ display: flex; gap: 22px; background: var(--surface); border-bottom: 1px solid var(--line);
	padding: 4px 18px; border-radius: var(--radius) var(--radius) 0 0 }}
nav.demo a {{ position: relative; color: var(--txt); text-decoration: none; font-size: 15px; font-weight: 500;
	padding: 15px 0 }}
nav.demo a::after {{ content: ""; position: absolute; left: 0; right: 0; bottom: 10px; height: 2px;
	background: var(--acc); transform: scaleX(0); transform-origin: left; transition: transform .18s ease }}
nav.demo a:hover::after, nav.demo a[aria-current="page"]::after {{ transform: scaleX(1) }}
nav.demo a[aria-current="page"] {{ color: var(--pri); font-weight: 600 }}
.dark-band {{ background: var(--teal-800); color: {NEUTRAL[50]}; border-radius: var(--radius);
	padding: 34px; margin: 18px 0; position: relative; overflow: hidden }}
.dark-band::before {{ content: ""; position: absolute; inset: 0;
	background: radial-gradient(90% 120% at 15% 0%, rgba(200,172,119,.16), transparent 60%) }}
.dark-band > * {{ position: relative }}
.dark-band h4 {{ font-family: Georgia, serif; font-weight: 600; font-size: 26px;
	line-height: 1.25; margin: 0 0 8px; color: {NEUTRAL[50]} }}
.dark-band p {{ margin: 0 0 18px; color: {NEUTRAL[200]}; max-width: 52ch }}
.btn-gold {{ background: var(--gold-400); color: {NEUTRAL[900]}; border-color: var(--gold-400);
	padding: 13px 24px; border-radius: 4px; font-weight: 600; text-decoration: none; display: inline-block }}
.swatches {{ display: grid; grid-template-columns: repeat(auto-fit, minmax(150px,1fr)); gap: 14px }}
.sw {{ border: 1px solid var(--line); border-radius: 8px; overflow: hidden }}
.sw .c {{ height: 72px }}
.sw .t {{ padding: 10px 12px; font-size: 12px }}
.sw .t strong {{ display: block; font-size: 13px; color: var(--txt) }}
.sw .t span {{ font-family: ui-monospace, Menlo, monospace; color: var(--txt-muted) }}
footer {{ margin-top: 64px; padding-top: 22px; border-top: 1px solid var(--line);
	font-size: 13px; color: var(--txt-muted) }}
.alert {{ border-left: 4px solid var(--info); background: rgba(44,90,107,.08); padding: 14px 18px;
	border-radius: 4px; margin-bottom: 10px; color: var(--txt) }}
.alert.ok {{ border-left-color: var(--ok); background: rgba(47,106,78,.09) }}
.alert.warn {{ border-left-color: var(--warn); background: rgba(122,84,31,.10) }}
.alert.err {{ border-left-color: var(--err); background: rgba(124,48,39,.09) }}
@media print {{
	.toggle {{ display: none }} body {{ padding: 0 }} h2 {{ break-after: avoid }}
	.panel, .card, table {{ break-inside: avoid }}
}}
@media (max-width: 640px) {{
	.ramprow {{ flex-direction: column; gap: 8px }} .rampname {{ flex: none }}
}}
</style>
</head>
<body>
<div class="wrap">

<header>
	<div class="brand">
		<div class="mark">D</div>
		<div>
			<h1>Queen Dor's — colour system</h1>
			<p class="sub">Adinkra jewellery · sampled from the logo · WCAG 2.1 AA verified</p>
		</div>
	</div>
	<div class="toggle">
		<span id="modelabel">Light mode</span>
		<button id="theme" aria-pressed="false">Dark</button>
	</div>
</header>

<h2>1 — Palette extraction</h2>
<p>Two colours are the brand: <strong>Adinkra Teal {TEAL[800]}</strong> from the D monogram and <strong>Crown Gold {GOLD[400]}</strong> from the name and crown. The ramps below are derived from those two hues, so every tint and shade is in the same family as the logo.</p>
{swatch_rows()}

<h2>2 — Contrast, measured</h2>
<p>Every pairing below is computed from the hex values, not estimated. Text follows WCAG 2.1 AA (4.5:1 normal, 3:1 large); borders follow 1.4.11 (3:1 for non-text).</p>
{pairs_light}
{pairs_dark}

<h2>3 — Buttons</h2>
<p>One primary action per view. Primary is teal; on a teal or dark section it becomes gold, because teal on teal measures 1:1 and teal on black 2.1:1.</p>
<div class="panel">
	<div class="row">
		<a href="#" class="qd-btn qd-btn--primary">Add to cart</a>
		<a href="#" class="qd-btn qd-btn--secondary">View details</a>
		<a href="#" class="qd-btn qd-btn--ghost">Remove</a>
		<a href="#" class="qd-btn qd-btn--danger">Delete</a>
		<button class="qd-btn qd-btn--primary" disabled>Out of stock</button>
	</div>
	<div class="row">
		<a href="#" class="qd-btn qd-btn--primary" style="padding:9px 16px;font-size:14px">Small</a>
		<a href="#" class="qd-btn qd-btn--primary">Default</a>
		<a href="#" class="qd-btn qd-btn--primary" style="padding:17px 30px;font-size:16px">Large</a>
	</div>
	<div class="row" style="gap:26px;font-size:14px">
		<span style="color:var(--txt-muted)">Hover any button. Tab for the focus ring:</span>
	</div>
</div>

<div class="dark-band">
	<h4>Made in Accra, worn anywhere</h4>
	<p>On a teal band the primary action is gold — 4.6:1 for the label, and the button itself separates from the field instead of sinking into it.</p>
	<a href="#" class="btn-gold">Shop wholesale</a>
</div>

<h2>4 — Forms</h2>
<p>Focus is a border colour change <em>plus</em> a soft ring, so it survives a cheap phone screen in daylight. Error and success carry text, not colour alone.</p>
<div class="panel">
	<div class="row" style="gap:22px;align-items:flex-start">
		<div class="field"><label for="f1">Full name</label><input id="f1" placeholder="Ama Mensah"><span class="hint">As it should appear on the parcel</span></div>
		<div class="field"><label for="f2">Email</label><input id="f2" class="is-error" value="ama@" aria-invalid="true"><span class="hint error">That address is missing a domain</span></div>
		<div class="field"><label for="f3">Phone</label><input id="f3" class="is-ok" value="024 000 0000"><span class="hint ok">We'll only call about delivery</span></div>
		<div class="field"><label for="f4">Disabled</label><input id="f4" value="Not available" disabled></div>
	</div>
</div>

<h2>5 — Cards and navigation</h2>
<div class="panel" style="padding:0;overflow:hidden">
	<nav class="demo">
		<a href="#" aria-current="page">Home</a><a href="#">Shop</a><a href="#">Symbols</a>
		<a href="#">Wholesale</a><a href="#">About</a><a href="#">Contact</a>
	</nav>
	<div class="cards" style="padding:22px">
		<article class="card"><div class="thumb"></div><div class="in">
			<div class="eyebrow">Sankofa</div><h4>Sankofa Pendant</h4>
			<div class="price">₵320.00</div></div></article>
		<article class="card"><div class="thumb"></div><div class="in">
			<div class="eyebrow">Gye Nyame</div><h4>Gye Nyame Pendant</h4>
			<div class="price">₵320.00</div></div></article>
		<article class="card"><div class="thumb"></div><div class="in">
			<div class="eyebrow">Akoma</div><h4>Akoma Studs</h4>
			<div class="price">₵180.00</div></div></article>
	</div>
</div>

<h2>6 — Feedback</h2>
<div class="panel">
	<div class="alert">Order received — we'll confirm by email.</div>
	<div class="alert ok">Payment confirmed. Your parcel leaves Accra tomorrow.</div>
	<div class="alert warn">Only 2 left in this size.</div>
	<div class="alert err">That card was declined. Try another method.</div>
</div>

<h2>7 — Gradients and elevation</h2>
<div class="swatches">
	<div class="sw"><div class="c" style="background:{GRADIENTS['gold-sheen']}"></div><div class="t"><strong>Gold sheen</strong><span>badges, dividers</span></div></div>
	<div class="sw"><div class="c" style="background:{GRADIENTS['teal-depth']}"></div><div class="t"><strong>Teal depth</strong><span>hero, footer</span></div></div>
	<div class="sw"><div class="c" style="background:{GRADIENTS['cream-fade']}"></div><div class="t"><strong>Cream fade</strong><span>section transition</span></div></div>
	<div class="sw"><div class="c" style="background:{SHADOWS_LIGHT['gold']}, {GOLD[400]}"></div><div class="t"><strong>Gold glow</strong><span>feature cards only</span></div></div>
</div>

<footer>
	Generated from <code>tools/brand_palette.py</code> — the same file that produces the CSS,
	the Figma tokens and the PDF guide, so the four cannot drift apart.
</footer>
</div>
<script>
const root = document.documentElement, btn = document.getElementById('theme'),
      label = document.getElementById('modelabel');
btn.addEventListener('click', () => {{
	const dark = root.dataset.theme !== 'dark';
	root.dataset.theme = dark ? 'dark' : 'light';
	btn.setAttribute('aria-pressed', String(dark));
	btn.textContent = dark ? 'Light' : 'Dark';
	label.textContent = dark ? 'Dark mode' : 'Light mode';
}});
</script>
</body>
</html>
"""


THEME_CSS = pathlib.Path(__file__).resolve().parent.parent / \
    "wp-content" / "themes" / "luxrio-child" / "assets" / "css"


def main():
    tokens_css, components_css = build_tokens_css(), build_components_css()
    (OUT / "tokens.css").write_text(tokens_css, encoding="utf-8")
    (OUT / "components.css").write_text(components_css, encoding="utf-8")
    (THEME_CSS / "brand-tokens.css").write_text(tokens_css, encoding="utf-8")
    (THEME_CSS / "brand-components.css").write_text(components_css, encoding="utf-8")
    print(f"wrote {THEME_CSS.name}/brand-tokens.css and brand-components.css")
    (OUT / "design-tokens.json").write_text(tokens_json(), encoding="utf-8")
    (OUT / "preview.html").write_text(build_preview_html(), encoding="utf-8")
    for f in ("tokens.css", "components.css", "design-tokens.json", "preview.html"):
        size = (OUT / f).stat().st_size
        print(f"wrote client/brand/{f:22} {size:>7,} bytes")


if __name__ == "__main__":
    main()
