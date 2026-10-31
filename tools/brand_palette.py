"""
The Queen Dor's palette, in one place.

Everything else — the CSS tokens, the Figma JSON, the preview page, the PDF
guide — is generated from this module, so the four can never disagree.

The two anchor colours are sampled from the client's logo, not chosen:
the D monogram is #0B4B4C (teal) and "QueenDor's" with the crown is #C8AC77
(gold). Every other value is derived from them.
"""

# --- the two colours that came from the logo --------------------------------

TEAL_ANCHOR = "#0B4B4C"   # hue 181, sat 75%, light 17%
GOLD_ANCHOR = "#C8AC77"   # hue 39,  sat 42%, light 63%


# --- colour maths -----------------------------------------------------------

def hex_to_rgb(h):
    h = h.lstrip("#")
    return tuple(int(h[i:i + 2], 16) for i in (0, 2, 4))


def rgb_to_hex(rgb):
    return "#" + "".join(f"{max(0, min(255, round(c))):02X}" for c in rgb)


def rgb_to_hsl(rgb):
    r, g, b = (c / 255 for c in rgb)
    mx, mn = max(r, g, b), min(r, g, b)
    d = mx - mn
    l = (mx + mn) / 2
    if d == 0:
        h = s = 0.0
    else:
        s = d / (2 - mx - mn) if l > 0.5 else d / (mx + mn)
        if mx == r:
            h = (60 * ((g - b) / d)) % 360
        elif mx == g:
            h = 60 * ((b - r) / d) + 120
        else:
            h = 60 * ((r - g) / d) + 240
    return round(h, 1), round(s * 100, 1), round(l * 100, 1)


def hsl_to_rgb(h, s, l):
    h = h % 360
    s, l = s / 100, l / 100
    c = (1 - abs(2 * l - 1)) * s
    x = c * (1 - abs((h / 60) % 2 - 1))
    m = l - c / 2
    seg = int(h // 60) % 6
    r, g, b = [
        (c, x, 0), (x, c, 0), (0, c, x), (0, x, c), (x, 0, c), (c, 0, x),
    ][seg]
    return tuple(round((v + m) * 255) for v in (r, g, b))


def hsl_hex(h, s, l):
    return rgb_to_hex(hsl_to_rgb(h, s, l))


def rel_lum(h):
    out = []
    for c in hex_to_rgb(h):
        c /= 255
        out.append(c / 12.92 if c <= 0.03928 else ((c + 0.055) / 1.055) ** 2.4)
    return 0.2126 * out[0] + 0.7152 * out[1] + 0.0722 * out[2]


def contrast(a, b):
    la, lb = rel_lum(a), rel_lum(b)
    hi, lo = max(la, lb), min(la, lb)
    return round((hi + 0.05) / (lo + 0.05), 2)


def verdict(ratio, large=False):
    """WCAG 2.1 AA / AAA for normal text, or the 3:1 rule for large text."""
    if large:
        return "AAA" if ratio >= 4.5 else ("AA" if ratio >= 3 else "FAIL")
    return "AAA" if ratio >= 7 else ("AA" if ratio >= 4.5 else "FAIL")


def ratio_word(r):
    return f"{r:.2f}:1"


# --- scales -----------------------------------------------------------------

def scale(hue, steps):
    return {k: hsl_hex(hue, s, l) for k, (s, l) in steps.items()}


TEAL = scale(181, {
    50: (40, 96), 100: (44, 92), 200: (45, 84), 300: (44, 72),
    400: (46, 58), 500: (52, 44), 600: (62, 34), 700: (70, 26),
    800: (75, 17), 900: (72, 12), 950: (66, 8),
})

GOLD = scale(39, {
    50: (60, 96), 100: (60, 92), 200: (58, 85), 300: (55, 76),
    400: (42, 63), 500: (46, 54), 600: (52, 45), 700: (56, 36),
    800: (52, 27), 900: (46, 19), 950: (42, 12),
})

NEUTRAL = scale(40, {
    0: (0, 100), 50: (33, 97), 100: (30, 93), 200: (26, 87),
    300: (22, 78), 400: (14, 63), 500: (10, 51), 600: (9, 39),
    700: (7, 30), 800: (7, 19), 900: (8, 12), 950: (10, 7),
})

# The ramp is generated around the two sampled colours; force those exact
# values back in so the brand colours stay byte-identical to the logo.
TEAL[800] = TEAL_ANCHOR
GOLD[400] = GOLD_ANCHOR

# --- semantic colours -------------------------------------------------------
#
# Hues are pulled toward the brand so a success tick or an error border looks
# like it belongs to this shop rather than to Bootstrap.

SUCCESS = scale(152, {100: (35, 92), 300: (34, 66), 700: (38, 30)})
WARNING = scale(35, {100: (60, 91), 300: (62, 68), 700: (60, 30)})
DANGER = scale(6, {100: (55, 93), 300: (58, 68), 700: (52, 32)})
INFO = scale(196, {100: (40, 92), 300: (36, 66), 700: (42, 28)})

# --- names ------------------------------------------------------------------
#
# A colour with a name gets used correctly by people who are not designers.

NAMES = {
    TEAL[800]: "Adinkra Teal",
    TEAL[300]: "Pale Adinkra",
    TEAL[950]: "Deep Adinkra",
    GOLD[400]: "Crown Gold",
    GOLD[700]: "Antique Gold",
    GOLD[200]: "Champagne",
    NEUTRAL[50]: "Linen",
    NEUTRAL[100]: "Parchment",
    NEUTRAL[500]: "Warm Ash",
    NEUTRAL[800]: "Slate Teal",
    NEUTRAL[900]: "Charcoal Ink",
    SUCCESS[700]: "Kola Green",
    WARNING[700]: "Bronze",
    DANGER[700]: "Clay Red",
    INFO[700]: "Harbour Blue",
}


def name(h):
    return NAMES.get(h.upper(), "")


# --- semantic tokens --------------------------------------------------------

LIGHT = {
    "bg.page": "#FFFFFF",
    "bg.subtle": NEUTRAL[50],
    "bg.muted": NEUTRAL[100],
    "bg.inverse": TEAL[800],
    "surface.card": "#FFFFFF",
    "surface.raised": NEUTRAL[50],
    "border.subtle": NEUTRAL[200],
    "border.default": NEUTRAL[500],
    "border.strong": NEUTRAL[700],
    "text.primary": NEUTRAL[900],
    "text.heading": TEAL[800],
    "text.body": "#3F4A49",
    "text.muted": NEUTRAL[600],
    "text.onDark": NEUTRAL[50],
    "text.onPrimary": NEUTRAL[50],
    "primary": TEAL[800],
    "primary.hover": TEAL[900],
    "primary.active": TEAL[950],
    "primary.subtle": TEAL[50],
    "accent": GOLD[400],
    "accent.text": GOLD[700],
    "accent.subtle": GOLD[100],
    "success": SUCCESS[700],
    "success.subtle": SUCCESS[100],
    "warning": WARNING[700],
    "warning.subtle": WARNING[100],
    "danger": DANGER[700],
    "danger.subtle": DANGER[100],
    "info": INFO[700],
    "info.subtle": INFO[100],
    "focus": TEAL[800],
    "focus.onDark": GOLD[400],
}

DARK = {
    "bg.page": "#0A1211",
    "bg.subtle": "#0F1B1A",
    "bg.muted": "#152422",
    "bg.inverse": NEUTRAL[50],
    "surface.card": "#12201E",
    "surface.raised": "#182A28",
    "border.subtle": "#22332F",
    "border.default": "#4F6761",
    "border.strong": "#5B706A",
    "text.primary": "#EDEAE0",
    "text.heading": "#EDEAE0",
    "text.body": "#CDCBBD",
    "text.muted": "#A3A296",
    "text.onDark": "#EDEAE0",
    "text.onPrimary": "#08100F",
    "primary": TEAL[300],
    "primary.hover": TEAL[200],
    "primary.active": TEAL[100],
    "primary.subtle": "#12292A",
    "accent": "#D6B982",
    "accent.text": GOLD[300],
    "accent.subtle": "#241E12",
    "success": SUCCESS[300],
    "success.subtle": "#0E2119",
    "warning": WARNING[300],
    "warning.subtle": "#241B0C",
    "danger": DANGER[300],
    "danger.subtle": "#26110E",
    "info": INFO[300],
    "info.subtle": "#0C1D22",
    "focus": TEAL[300],
    "focus.onDark": GOLD[400],
}

# --- the pairings that must be checked --------------------------------------

KEY_PAIRS_LIGHT = [
    ("Body text", "text.primary", "bg.page"),
    ("Headings", "text.heading", "bg.page"),
    ("Secondary text", "text.body", "bg.page"),
    ("Muted text", "text.muted", "bg.page"),
    ("Muted text on cream", "text.muted", "bg.subtle"),
    ("Link / heading", "primary", "bg.page"),
    ("Link on cream", "primary", "bg.subtle"),
    ("Primary button label", "text.onPrimary", "primary"),
    ("Gold label on teal", "accent", "primary"),
    ("Dark-section body", "text.onDark", "primary"),
    ("Gold as text on white", "accent", "bg.page"),
    ("Antique gold as text", "accent.text", "bg.page"),
    ("Input border vs page", "border.default", "bg.page"),
    ("Error text", "danger", "bg.page"),
    ("Success text", "success", "bg.page"),
    ("Warning text", "warning", "bg.page"),
]

KEY_PAIRS_DARK = [
    ("Body text", "text.primary", "bg.page"),
    ("Secondary text", "text.body", "bg.page"),
    ("Muted text", "text.muted", "bg.page"),
    ("Muted text on card", "text.muted", "surface.card"),
    ("Link", "primary", "bg.page"),
    ("Link on card", "primary", "surface.card"),
    ("Primary button label", "text.onPrimary", "primary"),
    ("Gold accent on page", "accent", "bg.page"),
    ("Gold as text", "accent.text", "bg.page"),
    ("Input border vs page", "border.default", "bg.page"),
    ("Error text", "danger", "bg.page"),
    ("Success text", "success", "bg.page"),
]


def rows(pairs, tokens):
    out = []
    for label, fg, bg in pairs:
        a, b = tokens[fg], tokens[bg]
        r = contrast(a, b)
        is_border = "border" in fg
        out.append({
            "label": label,
            "fg": a, "bg": b,
            "ratio": r,
            "normal": "3:1 ✓" if is_border and r >= 3 else ("3:1 ✗" if is_border else verdict(r)),
            "large": "—" if is_border else verdict(r, large=True),
            "kind": "ui" if is_border else "text",
        })
    return out


if __name__ == "__main__":
    print("TEAL", TEAL)
    print("GOLD", GOLD)
    print("NEUTRAL", NEUTRAL)
    print()
    for title, pairs, toks in (
        ("LIGHT", KEY_PAIRS_LIGHT, LIGHT),
        ("DARK", KEY_PAIRS_DARK, DARK),
    ):
        print(f"--- {title} ---")
        for r in rows(pairs, toks):
            print(f"{r['label']:24} {r['fg']} on {r['bg']:8} {ratio_word(r['ratio']):>8}  "
                  f"normal {r['normal']:5} large {r['large']}")
        print()
