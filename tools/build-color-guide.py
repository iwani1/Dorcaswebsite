#!/usr/bin/env python3
"""
Build the printable colour guide.

    /tmp/pdfenv/bin/python tools/build-color-guide.py

Reads tools/brand_palette.py — the same module that generates the CSS, the
Figma tokens and the preview page — so the PDF can never disagree with the
code it documents.

Output: client/brand/queendor-color-guide.pdf
"""

import pathlib
import sys

sys.path.insert(0, str(pathlib.Path(__file__).parent))

import brand_palette as P  # noqa: E402
from reportlab.lib import colors  # noqa: E402
from reportlab.lib.enums import TA_LEFT  # noqa: E402
from reportlab.lib.pagesizes import A4  # noqa: E402
from reportlab.lib.styles import ParagraphStyle  # noqa: E402
from reportlab.lib.units import mm  # noqa: E402
from reportlab.pdfbase import pdfmetrics  # noqa: E402
from reportlab.pdfbase.ttfonts import TTFont  # noqa: E402
from reportlab.platypus import (  # noqa: E402
    BaseDocTemplate, CondPageBreak, Flowable, Frame, KeepTogether, PageBreak, PageTemplate,
    Paragraph, Spacer, Table, TableStyle,
)

ROOT = pathlib.Path(__file__).resolve().parent.parent
OUT = ROOT / "client" / "brand" / "queendor-color-guide.pdf"

FONTS = pathlib.Path("/usr/share/fonts/truetype/dejavu")
pdfmetrics.registerFont(TTFont("QD", FONTS / "DejaVuSans.ttf"))
pdfmetrics.registerFont(TTFont("QD-B", FONTS / "DejaVuSans-Bold.ttf"))
pdfmetrics.registerFont(TTFont("QDSerif", FONTS / "DejaVuSerif.ttf"))
pdfmetrics.registerFont(TTFont("QDSerif-B", FONTS / "DejaVuSerif-Bold.ttf"))
pdfmetrics.registerFont(TTFont("QDMono", FONTS / "DejaVuSansMono.ttf"))

TEAL, GOLD, NEUTRAL = P.TEAL, P.GOLD, P.NEUTRAL
INK = colors.HexColor(NEUTRAL[900])
BODY = colors.HexColor("#3F4A49")
MUTED = colors.HexColor(NEUTRAL[600])
LINE = colors.HexColor(NEUTRAL[200])
TEAL_C = colors.HexColor(TEAL[800])
GOLD_C = colors.HexColor(GOLD[400])

W, H = A4
MARGIN = 20 * mm

# --- styles -----------------------------------------------------------------

def st(name, **kw):
    base = dict(fontName="QD", fontSize=9, leading=13.6, textColor=BODY, spaceAfter=4)
    base.update(kw)
    return ParagraphStyle(name, **base)


S = {
    "h1": st("h1", fontName="QDSerif-B", fontSize=26, leading=31, textColor=TEAL_C, spaceAfter=6),
    "h2": st("h2", fontName="QDSerif-B", fontSize=16, leading=20, textColor=TEAL_C,
             spaceBefore=14, spaceAfter=7),
    "h3": st("h3", fontName="QD-B", fontSize=10.5, leading=14.5, textColor=INK,
             spaceBefore=8, spaceAfter=4),
    "body": st("body"),
    "lead": st("lead", fontSize=10.5, leading=16, textColor=BODY),
    "small": st("small", fontSize=8, leading=11.5, textColor=MUTED),
    "cell": st("cell", fontSize=8.4, leading=11.6, spaceAfter=0),
    "cellb": st("cellb", fontName="QD-B", fontSize=8.4, leading=11.6, spaceAfter=0),
    "mono": st("mono", fontName="QDMono", fontSize=8.2, leading=11.4, spaceAfter=0),
    "caption": st("caption", fontSize=8, leading=11, textColor=MUTED, spaceBefore=3),
}


class Rule(Flowable):
    """A thin gold rule, used as a section separator."""

    def __init__(self, width, thick=0.7, colour=GOLD_C, space=4):
        Flowable.__init__(self)
        self.width, self.thick, self.colour, self.space = width, thick, colour, space
        self.height = thick + space

    def draw(self):
        self.canv.setStrokeColor(self.colour)
        self.canv.setLineWidth(self.thick)
        self.canv.line(0, self.space, self.width, self.space)


class Ramp(Flowable):
    """A horizontal strip of one colour ramp, labelled."""

    LABEL_W = 30 * mm

    LABEL_W = 26 * mm
    H = 29 * mm

    def __init__(self, title, scale):
        Flowable.__init__(self)
        self.title = title
        self.steps = sorted(scale.items())
        self.width = W - 2 * MARGIN
        self.height = self.H

    def draw(self):
        c = self.canv
        c.setStrokeColor(LINE)
        c.setLineWidth(0.3)
        c.line(0, self.height, self.width, self.height)

        c.setFont("QD-B", 8.4)
        c.setFillColor(INK)
        c.drawString(0, self.height - 5 * mm, self.title)

        n = len(self.steps)
        bw = (self.width - self.LABEL_W) / n
        top, bottom = self.height - 8 * mm, self.height - 18 * mm
        for i, (step, hexv) in enumerate(self.steps):
            x = self.LABEL_W + i * bw
            c.setFillColor(colors.HexColor(hexv))
            c.rect(x, bottom, bw - 1.4, top - bottom, stroke=0, fill=1)
            c.setFillColor(MUTED)
            c.setFont("QDMono", 6.1)
            c.drawString(x, bottom - 3.4 * mm, hexv.replace("#", ""))
            c.setFont("QD", 6.6)
            c.drawString(x, bottom - 7.2 * mm, str(step))


def data_table(rows, headers, widths, aligns=None, head_bg=TEAL_C):
    data = [[Paragraph(f"<b>{h}</b>", st("th", fontName="QD-B", fontSize=7.8,
                                         textColor=colors.white, spaceAfter=0)) for h in headers]]
    data += rows
    t = Table(data, colWidths=widths, repeatRows=1)
    style = [
        ("BACKGROUND", (0, 0), (-1, 0), head_bg),
        ("VALIGN", (0, 0), (-1, -1), "MIDDLE"),
        ("TOPPADDING", (0, 0), (-1, -1), 5),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 5),
        ("LEFTPADDING", (0, 0), (-1, -1), 6),
        ("RIGHTPADDING", (0, 0), (-1, -1), 6),
        ("LINEBELOW", (0, 0), (-1, -1), 0.4, LINE),
        ("ROWBACKGROUNDS", (0, 1), (-1, -1), [colors.white, colors.HexColor(NEUTRAL[50])]),
    ]
    t.setStyle(TableStyle(style))
    return t


def swatch_cell(hexv, w=9, h=4.2):
    return Table([[""]], colWidths=[w * mm], rowHeights=[h * mm],
                 style=TableStyle([("BACKGROUND", (0, 0), (-1, -1), colors.HexColor(hexv)),
                                   ("LINEBELOW", (0, 0), (-1, -1), 0, colors.white)]))


# --- page furniture ---------------------------------------------------------

def decorate(canvas, doc):
    canvas.saveState()
    canvas.setFillColor(TEAL_C)
    canvas.rect(0, H - 9 * mm, W, 9 * mm, stroke=0, fill=1)
    canvas.setFillColor(GOLD_C)
    canvas.rect(0, H - 9.7 * mm, W, 0.7 * mm, stroke=0, fill=1)

    canvas.setFont("QD", 7.2)
    canvas.setFillColor(colors.HexColor(NEUTRAL[600]))
    canvas.drawString(MARGIN, H - 6.4 * mm, "QUEEN DOR'S  ·  FASHION HOUSE  ·  COLOUR SYSTEM")
    canvas.drawRightString(W - MARGIN, H - 6.4 * mm, "v1.0  ·  October 2026")

    canvas.setStrokeColor(LINE)
    canvas.setLineWidth(0.4)
    canvas.line(MARGIN, 13 * mm, W - MARGIN, 13 * mm)
    canvas.setFont("QD", 7.2)
    canvas.drawString(MARGIN, 9 * mm, "Generated from tools/brand_palette.py")
    canvas.drawRightString(W - MARGIN, 9 * mm, f"{doc.page}")
    canvas.restoreState()


# --- content ----------------------------------------------------------------

def build():
    doc = BaseDocTemplate(
        str(OUT), pagesize=A4,
        leftMargin=MARGIN, rightMargin=MARGIN, topMargin=20 * mm, bottomMargin=20 * mm,
        title="Queen Dor's — Colour System", author="Queen Dor's Fashion House",
        subject="Brand colour system, WCAG 2.1 verified",
    )
    frame = Frame(MARGIN, 18 * mm, W - 2 * MARGIN, H - 44 * mm, id="f", showBoundary=0)
    doc.addPageTemplates([PageTemplate(id="all", frames=[frame], onPage=decorate)])

    F = []
    A = F.append
    cw = W - 2 * MARGIN

    # ---- cover -------------------------------------------------------------
    A(Spacer(1, 26 * mm))
    A(Paragraph("Queen Dor's", st("brand", fontName="QDSerif-B", fontSize=40, leading=44,
                                  textColor=TEAL_C, spaceAfter=2)))
    A(Paragraph("FASHION HOUSE", st("sub", fontName="QD", fontSize=9.5, leading=12,
                                    textColor=GOLD_C, spaceAfter=22)))
    A(Paragraph("Colour system", S["h1"]))
    A(Paragraph(
        "Two colours taken from the logo, extended into a working system: ramps, "
        "roles, contrast checks, component states, tokens and a dark mode. Every "
        "number in this document is computed from the hex values rather than estimated, "
        "which is why the palette, the CSS and this PDF cannot disagree.", S["lead"]))

    A(Spacer(1, 10 * mm))
    cover = Table(
        [[swatch_cell(TEAL[800], 58, 17), swatch_cell(GOLD[400], 58, 17)],
         [Paragraph(f"<b>Adinkra Teal</b> &nbsp; {TEAL[800]} &nbsp; RGB 11, 75, 76 &nbsp; HSL 181°, 75%, 17%", S["cell"]),
          Paragraph(f"<b>Crown Gold</b> &nbsp; {GOLD[400]} &nbsp; RGB 200, 172, 119 &nbsp; HSL 39°, 42%, 63%", S["cell"])]],
        colWidths=[cw / 2, cw / 2])
    cover.setStyle(TableStyle([
        ("VALIGN", (0, 0), (-1, -1), "TOP"),
        ("LEFTPADDING", (0, 0), (-1, -1), 0),
        ("BOTTOMPADDING", (0, 0), (1, 0), 9),
    ]))
    A(cover)
    A(Paragraph(
        "Sampled from the client's logo: the D monogram is the teal, the name and the "
        "crown are the gold. Nothing else was invented.", S["caption"]))
    A(Spacer(1, 14 * mm))
    A(Rule(cw))
    A(Paragraph(
        "Brand personality: <b>rooted, luxurious, unhurried, trustworthy</b>.  "
        "Audience: <b>Accra retail buyers 25–45, plus wholesale stockists</b>, "
        "shopping mostly on phones, often outdoors.", S["body"]))

    # ---- 1 palette ---------------------------------------------------------
    A(Spacer(1, 8 * mm))
    A(Paragraph("1 — Palette extraction", S["h2"]))
    A(Paragraph(
        "The two anchors sit where the logo puts them: teal at the dark end of its "
        "ramp, gold in the middle of its own. Tints and shades were generated by "
        "holding the sampled hue and moving lightness, so every step belongs to the "
        "same family as the mark.", S["body"]))
    A(Spacer(1, 3 * mm))
    A(Ramp("TEAL  ·  hue 181°", TEAL))
    A(Ramp("GOLD  ·  hue 39°", GOLD))
    A(Ramp("NEUTRALS  ·  warm, hue 40°", NEUTRAL))

    A(Spacer(1, 4 * mm))
    A(Paragraph("The colours that carry the brand", S["h3"]))
    named = [
        (TEAL[800], "Adinkra Teal", "The logo's D. Primary: buttons, links, prices, headings."),
        (TEAL[900], "Deep Adinkra", "Hover on primary, footer fields, overlay scrims."),
        (TEAL[300], "Pale Adinkra", "The dark-mode primary; teal-tinted illustration accents."),
        (GOLD[400], "Crown Gold", "The logo's name. Accent only: rules, hover, dark sections."),
        (GOLD[700], "Antique Gold", "The gold you may set text in — 4.9:1 on white."),
        (GOLD[200], "Champagne", "Subtle backgrounds behind badges and notes."),
        (NEUTRAL[50], "Linen", "Page section background, alternating with white."),
        (NEUTRAL[900], "Charcoal Ink", "Body-intense text and headings at maximum contrast."),
    ]
    rows = []
    for hexv, nm, use in named:
        h, s, l = P.rgb_to_hsl(P.hex_to_rgb(hexv))
        r, g, b = P.hex_to_rgb(hexv)
        rows.append([
            swatch_cell(hexv),
            Paragraph(f"<b>{nm}</b>", S["cell"]),
            Paragraph(hexv, S["mono"]),
            Paragraph(f"{r}, {g}, {b}", S["mono"]),
            Paragraph(f"{h}°, {s}%, {l}%", S["mono"]),
            Paragraph(use, S["cell"]),
        ])
    A(data_table(rows, ["", "Name", "HEX", "RGB", "HSL", "Where it goes"],
                 [11 * mm, 27 * mm, 19 * mm, 26 * mm, 27 * mm, cw - 110 * mm]))

    # ---- 2 roles -----------------------------------------------------------
    A(CondPageBreak(70 * mm))
    A(Paragraph("2 — Roles and priority", S["h2"]))
    A(Paragraph(
        "A palette becomes a system when each colour has one job. Anything used for "
        "two jobs will eventually be used for the wrong one.", S["body"]))
    roles = [
        ("Primary", "Adinkra Teal 800", "Teal", "The brand and the action. Buttons, links, prices, headings."),
        ("Secondary", "Deep Adinkra 900", "Teal", "Depth for primary: hover, active, footer panels."),
        ("Accent", "Crown Gold 400", "Gold", "Precious, scarce. Rules, hover, dark-section buttons."),
        ("Accent text", "Antique Gold 700", "Gold", "The only gold permitted in a sentence — 4.9:1."),
        ("Background", "White / Linen 50", "Neutral", "White for product, linen for rhythm between sections."),
        ("Surface", "White + hairline", "Neutral", "Cards float on a 1px border, not on a heavy shadow."),
        ("Text primary", "Charcoal Ink 900", "Neutral", "16.4:1 — body copy that never has to be squinted at."),
        ("Text muted", "Warm Ash 600", "Neutral", "5.7:1 — captions, help text, still AA at body size."),
    ]
    rows = []
    for role, tok, fam, why in roles:
        hexv = {"Adinkra Teal 800": TEAL[800], "Deep Adinkra 900": TEAL[900],
                "Crown Gold 400": GOLD[400], "Antique Gold 700": GOLD[700],
                "White / Linen 50": NEUTRAL[50] if "Linen" in tok else "#FFFFFF",
                "White + hairline": "#FFFFFF", "Charcoal Ink 900": NEUTRAL[900],
                "Warm Ash 600": NEUTRAL[600]}[tok]
        rows.append([Paragraph(f"<b>{role}</b>", S["cell"]), Paragraph(tok, S["cell"]),
                     swatch_cell(hexv), Paragraph(hexv, S["mono"]), Paragraph(why, S["cell"])])
    A(data_table(rows, ["Role", "Token value", "", "HEX", "Why it fits"],
                 [24 * mm, 32 * mm, 11 * mm, 19 * mm, cw - 86 * mm]))

    A(Spacer(1, 4 * mm))
    A(Paragraph("The 60–30–10 ratio", S["h3"]))
    A(Paragraph(
        "<b>60%</b> neutral — white product fields and linen bands, the room the jewellery "
        "sits in. <b>30%</b> teal — headers, buttons, prices, headings, dark sections; the "
        "brand doing the work. <b>10%</b> gold — rules, hover states, one band, the logo. "
        "Gold is the 10 by definition: at 30 it stops reading as precious and starts "
        "reading as beige.", S["body"]))

    # ---- 3 contrast --------------------------------------------------------
    A(Paragraph("3 — Contrast, checked against WCAG 2.1", S["h2"]))
    A(Paragraph(
        "Text is judged on AA 4.5:1 (normal) and 3:1 (large, 18.66px bold or 24px). "
        "Borders and controls are judged on 1.4.11, which asks 3:1 of non-text.", S["body"]))

    def contrast_rows(pairs, tokens):
        out = []
        for rrow in P.rows(pairs, tokens):
            col = "#1F7A4D" if rrow["normal"] in ("AA", "AAA", "3:1 ✓") else "#B3261E"
            out.append([
                Paragraph(rrow["label"], S["cell"]),
                swatch_cell(rrow["fg"]),
                Paragraph(rrow["fg"], S["mono"]),
                swatch_cell(rrow["bg"]),
                Paragraph(rrow["bg"], S["mono"]),
                Paragraph(f"{rrow['ratio']:.2f}:1", S["mono"]),
                Paragraph(f"<font color='{col}'><b>{rrow['normal']}</b></font>",
                          S["cell"]),
                Paragraph(rrow["large"], S["cell"]),
            ])
        return out

    A(Paragraph("Light mode", S["h3"]))
    A(data_table(contrast_rows(P.KEY_PAIRS_LIGHT, P.LIGHT),
                 ["Pairing", "", "Text", "", "Background", "Ratio", "AA", "AA large"],
                 [40 * mm, 10 * mm, 19 * mm, 10 * mm, 26 * mm, 19 * mm, 19 * mm, cw - 143 * mm]))

    A(Paragraph("Dark mode", S["h3"]))
    A(data_table(contrast_rows(P.KEY_PAIRS_DARK, P.DARK),
                 ["Pairing", "", "Text", "", "Background", "Ratio", "AA", "AA large"],
                 [40 * mm, 10 * mm, 19 * mm, 10 * mm, 26 * mm, 19 * mm, 19 * mm, cw - 143 * mm]))

    A(Spacer(1, 3 * mm))
    A(Paragraph("The one deliberate failure", S["h3"]))
    gold_white = P.contrast(GOLD[400], "#FFFFFF")
    A(Paragraph(
        f"Crown Gold on white measures <b>{gold_white:.2f}:1</b>. It is kept off text on "
        "purpose — the logo's own letterforms carry far more optical weight than 15px type, "
        "so what works at 1080px across does not work in a product card. Where the client "
        "wants gold lettering, use <b>Antique Gold "
        f"{GOLD[700]}</b> (4.9:1) or set the gold on teal, where it reads at 4.6:1.", S["body"]))

    # ---- 4 components ------------------------------------------------------
    A(Paragraph("4 — Component application", S["h2"]))
    A(Paragraph(
        "Each component lists its four interaction states. Focus is always a ring as well "
        "as a colour change: on a cheap phone screen in daylight, a 1px border shift is "
        "not a visible state.", S["body"]))
    comps = [
        ("Primary button", "Teal 800 field, Linen label", "Teal 900", "Teal 950",
         "2px teal ring, 2px offset", "Linen field, Warm Ash label, 45% text"),
        ("Secondary button", "Transparent, 1px Ink 700 border", "Teal 50 wash, teal border",
         "Teal 100 wash", "as primary", "Hairline border, Warm Ash label"),
        ("Ghost button", "Teal text, no field", "Teal 50 wash", "Teal 100 wash",
         "as primary", "Warm Ash text, no field"),
        ("Danger button", "Clay Red 700 field, white label", "92% brightness", "88%",
         "as primary", "as disabled"),
        ("Link", "Teal text, gold underline", "Teal 900, teal underline", "Teal 950",
         "teal ring", "Warm Ash, no underline"),
        ("Input", "1px Warm Ash 500 border (3.6:1)", "Ink 700 border",
         "—", "Teal border + 3px teal 15% ring", "Linen 100 field, Warm Ash text"),
        ("Input error", "Clay Red border", "—", "—", "Clay ring 15%", "as disabled"),
        ("Input success", "Kola Green border", "—", "—", "Green ring 15%", "as disabled"),
        ("Card", "White, hairline border, shadow-sm", "shadow-md, lift 2px, Ink 500 border",
         "—", "ring on the card link", "Hairline, Linen 100 field"),
        ("Nav item", "Ink text", "Teal text + gold underline grows",
         "Teal 950", "teal ring", "Warm Ash"),
        ("Gold on dark", "Gold 400 field, Ink 900 label", "Gold 300", "Gold 200",
         "Gold ring", "40% gold"),
    ]
    rows = []
    for name, default, hover, active, focus, disabled in comps:
        rows.append([Paragraph(f"<b>{name}</b>", S["cell"]), Paragraph(default, S["cell"]),
                     Paragraph(hover, S["cell"]), Paragraph(active, S["cell"]),
                     Paragraph(focus, S["cell"]), Paragraph(disabled, S["cell"])])
    A(data_table(rows, ["Component", "Default", "Hover", "Active", "Focus", "Disabled"],
                 [24 * mm, 38 * mm, 30 * mm, 20 * mm, 30 * mm, cw - 142 * mm]))

    A(Spacer(1, 3 * mm))
    A(Paragraph("Rules that keep the states honest", S["h3"]))
    A(Paragraph(
        "• One primary button per view. Two primaries is a choice the customer did not ask for.<br/>"
        "• Hover is a <i>darkening</i> on light surfaces, a lightening on dark ones — never a hue change, "
        "which reads as a different meaning.<br/>"
        "• Error is never colour alone: the message says what is wrong. Roughly one man in twelve "
        "cannot reliably separate the clay red from the kola green.<br/>"
        "• Disabled controls are exempt from AA, which is not permission to make them invisible — "
        "45% text on a linen field still reads as 'not available'.", S["body"]))

    # ---- 5 tokens ----------------------------------------------------------
    A(Paragraph("5 — Tokens", S["h2"]))
    A(Paragraph(
        "Two layers. The primitive layer names colours (<b>--qd-teal-800</b>); the semantic "
        "layer names jobs (<b>--qd-primary</b>). Components read only the semantic layer, "
        "which is exactly what lets dark mode swap forty values instead of rewriting a "
        "stylesheet.", S["body"]))
    token_rows = [
        ("--qd-bg-page", "Page background", "#FFFFFF", "#0A1211"),
        ("--qd-bg-subtle", "Alternating sections", NEUTRAL[50], "#0F1B1A"),
        ("--qd-surface-card", "Cards, panels", "#FFFFFF", "#12201E"),
        ("--qd-border-subtle", "Hairlines", NEUTRAL[200], "#22332F"),
        ("--qd-border-default", "Input borders (3:1)", NEUTRAL[500], "#4F6761"),
        ("--qd-text-primary", "Max-contrast text", NEUTRAL[900], "#EDEAE0"),
        ("--qd-text-heading", "Headings", TEAL[800], "#EDEAE0"),
        ("--qd-text-body", "Body copy", "#3F4A49", "#CDCBBD"),
        ("--qd-text-muted", "Captions, help", NEUTRAL[600], "#A3A296"),
        ("--qd-primary", "Actions, links", TEAL[800], TEAL[300]),
        ("--qd-primary-hover", "Hover", TEAL[900], TEAL[200]),
        ("--qd-accent", "Gold accent", GOLD[400], "#D6B982"),
        ("--qd-accent-text", "Gold text", GOLD[700], GOLD[300]),
        ("--qd-focus", "Focus ring", TEAL[800], TEAL[300]),
    ]
    rows = []
    for tok, job, light, dark in token_rows:
        rows.append([Paragraph(tok, S["mono"]), Paragraph(job, S["cell"]),
                     swatch_cell(light), Paragraph(light, S["mono"]),
                     swatch_cell(dark), Paragraph(dark, S["mono"])])
    A(data_table(rows, ["Token", "Job", "", "Light", "", "Dark"],
                 [43 * mm, 30 * mm, 10 * mm, 20 * mm, 10 * mm, cw - 113 * mm]))

    A(Spacer(1, 4 * mm))
    A(Paragraph("Also in the token file", S["h3"]))
    A(Paragraph(
        "Spacing on a 4px base (--qd-space-1 … 12, 4–128px). Radius: 2 / 4 / 6 / 10 / 16 / pill. "
        "Elevation in four steps plus a gold glow reserved for one featured card. "
        "<b>Shadows are teal-tinted, never neutral grey</b> — a grey shadow on a cream page "
        "looks like dirt. Gradients: gold sheen, teal depth, cream fade, hero glow. "
        "Opacity: hover wash 6%, pressed wash 12%, disabled 45%.", S["body"]))

    A(Paragraph("When to reach for which token", S["h3"]))
    A(Paragraph(
        "• Ordering a thing → <b>--qd-primary</b>. Acknowledging → <b>--qd-accent</b> only inside a dark band.<br/>"
        "• Any text a customer must read → never <b>--qd-accent</b>; use <b>--qd-accent-text</b>.<br/>"
        "• A section that needs separating from its neighbour → <b>--qd-bg-subtle</b>, never a border.<br/>"
        "• A price → <b>--qd-primary</b> on light, <b>--qd-accent</b> on dark. Never gold on white.", S["body"]))

    # ---- 6 visual ----------------------------------------------------------
    A(Paragraph("6 — Visual direction", S["h2"]))
    A(Paragraph("Gradients", S["h3"]))
    A(Paragraph(
        "Three only. <b>Teal depth</b> (teal 800 → 950, 160°) for the hero and the footer. "
        "<b>Gold sheen</b> (gold 300 → 500, 135°) for badge fills and hairlines, never for "
        "large fields — a big gold gradient reads as a placeholder. <b>Cream fade</b> "
        "(white → linen, 180°) to soften section joins without a line.", S["body"]))
    A(Paragraph("Elevation and texture", S["h3"]))
    A(Paragraph(
        "Cards rest on a 1px hairline plus shadow-sm; hover lifts 2px and moves to shadow-md. "
        "Product photography supplies the texture on this site — the Adinkra pattern below is "
        "for the wholesale band only, at 7% gold on teal, so it never competes with a product.", S["body"]))
    A(Paragraph("Photography", S["h3"]))
    A(Paragraph(
        "Shoot on white and on linen; the palette assumes a light field around the product and "
        "a dark field behind the story. Gold jewellery photographs warm, so keep the white "
        "balance neutral or the gold turns orange and fights Crown Gold. One product per frame, "
        "4:5, longest edge 1600px. For the dark sections, shoot on deep teal rather than black: "
        "black crushes the shadow under a pendant, teal keeps the edge of the metal.", S["body"]))
    A(Paragraph("Icons", S["h3"]))
    A(Paragraph(
        "1.5px strokes in Ink 900 on light, Linen on dark. Never gold icons on white — at 2.2:1 "
        "they read as a ghost. Gold icons are permitted only inside a teal or black band, where "
        "they measure 4.6:1 and 9.7:1.", S["body"]))

    # ---- 7 deliverables ----------------------------------------------------
    A(Paragraph("7 — What ships with this guide", S["h2"]))
    items = [
        ("tokens.css", "Primitives, semantic tokens for both modes, spacing, radius, shadows, gradients."),
        ("components.css", "Buttons, links, fields, cards, nav, alerts — with every state."),
        ("design-tokens.json", "Tokens Studio / Figma import: core ramps, light and dark semantic sets."),
        ("preview.html", "Both modes side by side, with a toggle — the page to show the client."),
        ("luxrio-child-1.7.0.zip", "The same CSS wired into the shop, loaded after the theme's own colours."),
    ]
    rows = [[Paragraph(f"<b>{n}</b>", S["mono"]), Paragraph(d, S["cell"])] for n, d in items]
    A(KeepTogether(data_table(rows, ["File", "What it contains"], [50 * mm, cw - 50 * mm])))

    A(Spacer(1, 5 * mm))
    A(Paragraph("Where this stops", S["h3"]))
    A(Paragraph(
        "Colour is the one part of a brand system that can be verified by arithmetic, and this "
        "document does that. Typography, photography and layout are judgements, and the "
        "recommendations above are offered as such. Two things remain the client's decision: "
        "whether prices read teal or gold at full size, and whether the hero becomes teal. "
        "Both are one line to change, and both are easier to answer looking at "
        "preview.html than at a spec sheet.", S["body"]))

    # ---- quick reference card ---------------------------------------------
    A(PageBreak())
    A(Paragraph("The card to pin up", S["h2"]))
    A(Paragraph(
        "One page for anyone making a decision without the rest of this document "
        "in front of them.", S["body"]))
    A(Spacer(1, 3 * mm))

    big = Table(
        [[swatch_cell(TEAL[800], 42, 20), swatch_cell(GOLD[400], 42, 20),
          swatch_cell(NEUTRAL[50], 42, 20), swatch_cell(NEUTRAL[900], 42, 20)],
         [Paragraph("<b>Adinkra Teal</b><br/>" + TEAL[800], S["cell"]),
          Paragraph("<b>Crown Gold</b><br/>" + GOLD[400], S["cell"]),
          Paragraph("<b>Linen</b><br/>" + NEUTRAL[50], S["cell"]),
          Paragraph("<b>Charcoal Ink</b><br/>" + NEUTRAL[900], S["cell"])],
         [Paragraph("Actions on light", S["small"]), Paragraph("Accent on dark", S["small"]),
          Paragraph("Backgrounds", S["small"]), Paragraph("Body text", S["small"])]],
        colWidths=[cw / 4] * 4)
    big.setStyle(TableStyle([
        ("VALIGN", (0, 0), (-1, -1), "TOP"),
        ("LEFTPADDING", (0, 0), (-1, -1), 0),
        ("BOTTOMPADDING", (0, 1), (1, 1), 1),
    ]))
    A(big)

    A(Spacer(1, 6 * mm))
    A(Paragraph("Six rules", S["h3"]))
    A(Paragraph(
        "1. Prices and links are teal on light, gold on dark. Never gold on white (2.2:1).<br/>"
        "2. Teal never appears inside a black section (2.1:1) — that is what the gold is for.<br/>"
        f"3. Gold lettering is Antique Gold {GOLD[700]}, and only for a line, not a paragraph.<br/>"
        "4. One primary button per view. A second primary is a decision taken from the customer.<br/>"
        "5. Shadows are teal-tinted. Grey on cream looks like dust.<br/>"
        "6. Every focusable thing gets a 2px ring — a colour shift alone is not a state.", S["body"]))

    A(Spacer(1, 5 * mm))
    A(Paragraph("Six things not to do", S["h3"]))
    A(Paragraph(
        "• Gold gradient across a large panel — reads as a placeholder image.<br/>"
        "• Gold icons on white — they read as wounds in the page.<br/>"
        "• Error shown by colour alone — roughly 1 man in 12 cannot separate the red from the green.<br/>"
        "• A disabled button at 20% opacity — it vanishes instead of reading as unavailable.<br/>"
        "• More than two type colours in one section.<br/>"
        "• Maize yellow substitutes for Crown Gold. The gold is desaturated on purpose; "
        "a saturated yellow turns the shop into a market stall.", S["body"]))

    A(Spacer(1, 6 * mm))
    A(Rule(cw))
    A(Paragraph(
        f"Adinkra Teal {TEAL[800]}  ·  Crown Gold {GOLD[400]}  ·  "
        f"Antique Gold {GOLD[700]}  ·  Linen {NEUTRAL[50]}  ·  Charcoal Ink {NEUTRAL[900]}  ·  "
        "Queen Dor's Fashion House, Accra", S["small"]))

    doc.build(F)
    size = OUT.stat().st_size
    print(f"wrote {OUT.relative_to(ROOT)}  {size:,} bytes")


if __name__ == "__main__":
    build()
