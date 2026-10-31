# Home page — UI and colour audit

**Page:** `https://www.blaharbenyah.com/dorcas/`
**Theme live:** **1.8.1** (verified from the server, 2026-10-31)
**Scope:** the home page, interface and colour only
**Sources:** the rendered markup; the page's own Elementor stylesheet
(`wp-content/uploads/elementor/css/post-25.css`), which states every section's
background and every title's colour by ID; the child theme's tokens; computed
WCAG ratios.

**What I cannot see:** the rendering. Everything below is measured from the CSS
and markup that produce it. Contrast is arithmetic and reliable; "looks right" is
not, so the last section is a checklist for your eyes.

---

## 1. Verdict

**The palette is now correct and the contrast is clean.** Every key pair on the
page passes WCAG AA after 1.8.1 — most pass AAA. What remains is not colour
wrongness but **colour inconsistency**: the page now speaks two colour languages
at once — the brand's (teal, gold, linen, warm ink) and the demo's (neutral greys,
pure black, and an orange that is still sitting in the Elementor global palette).

The UI problems are structural rather than chromatic: **five display headings
competing at 80–90px**, **two different content widths**, **four different
section paddings**, and a width hack that can push a phone sideways.

---

## 2. Colour as it stands now

| Role | Value | Where on the page | Contrast |
|---|---|---|---|
| Hero field | `#0B4B4C` teal | hero section | white on it **9.88:1 AAA** |
| Page bands | `#FAF8F5` linen | categories, products, story | teal on it **9.32:1 AAA** |
| Headings | `#0B4B4C` teal | five section titles | 9.32:1 AAA |
| Body copy | `#3F4A49` ink | band paragraphs | 8.66:1 AAA |
| Eyebrow | `#8F6B28` antique gold | above the story title | 4.61:1 AA |
| Emphasis word | `#8F6B28` antique gold | inside one title | 4.61:1 AA |
| Actions | `#0B4B4C` teal | buttons, links | — |

**That column is the whole story of the last change.** Before 1.8.1 the page had
white titles on photographs with a 20% orange veil over them: white on that
orange, `#CF6D03`, measures **3.59:1** — below AA, in the largest text on the page.
Now the same words sit on linen at 9.32:1.

---

## 3. The one colour problem left, and it is not on this page

The demo's colours are still in **Elementor → Site Settings → Global Colours**.
Evidence, straight from the page's CSS:

```css
.elementor-element-181ea56 .title-selector span {
  color: var(--e-global-color-luxrio_opt_primary);
}
```

That variable is the kit's global primary. The kit came from the demo, where the
primary is the orange `#ff3e01`. 1.8.1 overrides that one span by ID, so the home
page is protected — **but any other template using the global palette will still
paint orange.** The shop, the product pages and anything built later inherit it.

**Fix, one screen:** Site Settings → Global Colours → set Primary to `#0B4B4C`,
Secondary to `#C8AC77`, Text to `#3F4A49`, Accent to `#8F6B28`. Do this before
building another page, or the old orange will keep reappearing inside new work.

---

## 4. Colour inconsistency, itemised

| Demo colour | Where | Why it jars | Suggest |
|---|---|---|---|
| `#3C3B3B` | product price in the promo banner | neutral grey in a warm system | `#0B4B4C` |
| `#021210` | promo banner title | near-black with a blue cast | `#211F1C` |
| `#000000` | star rating | pure black is the one colour never in the palette | `#8F6B28` |
| `#CF6D03` + 20% | story band veil | the demo's orange, over brand photography | removed in 1.8.1 |
| `#FFFFFF` on photographs | five titles | unmeasurable contrast over an image | removed in 1.8.1 |

Six distinct colours in the page's own CSS — four neutral, one near-black, one
orange. None of the four neutral ones is from the logo. That is why the page can
feel assembled rather than designed, even when every individual element is
perfectly legible.

---

## 5. UI findings, measured

### 5.1 Five headings competing at display size

| Element | Size / line-height | Ratio |
|---|---|---|
| `3031698` | 90px / 85px | 0.94 — tight |
| `1e90125` | 80px / 95px | 1.19 |
| `181ea56` | 46px / 52px | 1.13 |
| `01e6aeb` | inherited | — |
| `adfb89e` | inherited | — |

Five sections all open with a large display title. **Nothing is the biggest**, so
the page has no single focal point after the hero — the eye gets five equal
shouts and settles on none. Three sizes would be enough: one per page, one per
band, one for everything else.

The 90/85 line-height at ratio 0.94 is deliberate tightness for a two-line title,
but it only works if the title *is* two lines. At three lines the descenders touch.

### 5.2 A width hack that can push a phone sideways

```css
.elementor-element-3031698 { width: 111.129%; max-width: 111.129%; }
```

The same is set on `181ea56`. This was the demo's way of letting a title bleed
past its column gutter. On a narrow viewport, a box 11% wider than its container
is a horizontal-scroll candidate — the failure mode that makes a site feel broken
on a phone before anything else does.

**Check:** open the page on a phone and try to drag it left and right. If it moves,
this is why.

### 5.3 Two content widths, four rhythms

| Band | Content width | Padding |
|---|---|---|
| Hero row | 1600px | — |
| Categories | 1330px | 120 / 120 |
| Products | 1330px | 120 / 90 |
| Story | 1330px | 160 / 160 |
| Advisory | — | 120 / 90 |

Gutters jump 270px between the hero and everything below it, and section spacing
takes four values with no structural logic — 160 vs 120 is a 33% difference that a
reader feels as "slightly off" without being able to name it. Two widths and one
rhythm (say 120 top / 120 bottom, with 80 on mobile) would read as intentional.

### 5.4 Eyebrow tracking

`.sec-text` is 700 weight with **3px letter-spacing** at eyebrow size. At ~13px
text, 3px is a very wide gap — fine for a four-word label, awkward when it wraps,
and it is the element most likely to look different in your browser than in mine.

### 5.5 Two buttons, one label

Both promo tiles' calls to action read "Shop Now", and all five Instagram links
read "Instagram". For a screen reader those are five indistinguishable links.
"Shop necklaces", "Shop gifts", "See this on Instagram" — the fix is the label,
not the colour.

---

## 6. What 1.8.1 changed, measured

| | Before | After |
|---|---|---|
| Hero field | dark photo, white text | teal `#0B4B4C`, white text — 9.88:1 |
| Section titles | white on photo + orange veil | teal on linen — 3.59:1 → **9.32:1** |
| Story band | photo, orange `#CF6D03` at 20% | linen, veil removed |
| Eyebrow | white | antique gold, 4.61:1 |
| Emphasis word | global primary (orange) | antique gold |
| Header, top bar | black | white / linen |

---

## 7. Priority

| # | Item | Effort | Why |
|---|---|---|---|
| 1 | **Set the Elementor global colours** to the brand four | 3 min | stops orange leaking into every future page |
| 2 | Reduce the display scale to three sizes | 15 min | the page has no focal point |
| 3 | Remove `width:111.129%` from the two titles | 5 min | horizontal scroll on phones |
| 4 | One vertical rhythm, two content widths | 20 min | the "slightly off" feeling, removed |
| 5 | Product price `#3C3B3B` → teal | 2 min | last warm/cool clash in the buying path |
| 6 | Distinct link labels | 10 min | accessibility, and clearer intent |
| 7 | Star rating `#000` → antique gold | 1 min | free consistency |
| 8 | Assign the footer | 5 min | missing trust signals on a page that takes money |

Items 1, 3, 5 and 7 are settings changes measured in minutes, and together they
remove the last of the demo's colour language.

---

## 8. What to look at, in this order

I can measure contrast but not beauty, so these four checks are worth two minutes
of your eyes:

1. **The hero.** Teal field, white headline, two product photos that are still
   dark rectangles. Do the photos sit on the teal comfortably, or do they read as
   holes? If holes: that is the photography problem, not the colour one.
2. **The seam between the hero and the first linen band.** Teal to linen is the
   strongest transition on the page. It should read as a cut, deliberately.
3. **The five titles in sequence.** Scroll fast. If you cannot tell which one
   matters most, neither can a customer.
4. **A phone, dragged sideways.** If the page moves, see §5.2.

---

## 9. The honest summary

The colour work is finished: the page is now legible everywhere, on brand
everywhere, and measurable. It is the *hierarchy* that is still the demo's — five
equal headlines, four spacings, two widths — and hierarchy is the part a customer
feels without being able to point at.

If you want, the same treatment for the other pages is one fetch each: their
Elementor stylesheets are public in the same place, and the overrides are the same
four colour rules.
