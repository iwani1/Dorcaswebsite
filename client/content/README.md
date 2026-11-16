# Content I could write without you

Four files, none of which needed a decision, a photograph or a login. Everything
here is written and ready to paste; the square brackets are the facts only the
client has.

| File | Goes on | How |
|---|---|---|
| `faqs.html` | `/faqs/` — currently **lorem ipsum** | paste into an Elementor HTML widget over the demo accordion |
| `faqs.md` | same, as plain text | paste into the editor if you prefer |
| `faqs.wxr` | same, as an importable page | Tools → Import → WordPress |
| `product-descriptions.md` | all ten products | copy each block into Products → *Short description* / *Description* |
| `symbols-strip.html` | the home page — the empty "Why Adinkra" band | paste into an HTML widget |
| `symbols-strip-elementor.json` | same | Templates → Saved Templates → Import Templates |

The symbols strip carries its own `<style>` block, so it needs **no theme update** —
drop it anywhere and it looks right.

---

## `faqs.wxr` — the importable version

Tools → Import → WordPress → **Run Importer** → `faqs.wxr` → **Upload file and
import** → assign to your user → **Submit**.

You get **one draft page**, titled *FAQ's*, at the slug `faqs`, with all sixteen
questions already marked up as `h3` headings.

**It arrives as a draft on purpose** — the imported page cannot accidentally replace
the live one, and nothing with `[EMAIL ADDRESS]` still in it can be seen by a
customer.

### Two ways to finish it

**A — keep the page you have** (recommended):

1. Open the imported draft → in the editor, select all the content and copy it.
2. Open **Pages → FAQ's** (the published one) → replace its content.
3. **Update**, then trash the imported draft.

> Do it this way and the menu keeps working. The header's **FAQ's** menu item points
> at the existing page; delete that page and the menu item disappears with it.

**B — use the imported page instead:**

1. Delete the published FAQ page **after** importing, and empty the trash.
2. Rename the draft's slug from `faqs-2` to `faqs`.
3. Re-point the menu item: **Appearance → Menus →** open the *FAQ's* item → it is now
   a *Custom Link* or gone — delete it and re-add **Pages → FAQ's**.

Route A is two minutes; route B costs you the menu. The WordPress importer never
overwrites an existing page — it creates a copy with `-2` on the end, which is why
either route above involves a manual step.

---

## What changed, and why these four

**The FAQ page** was the last page on the site that was pure demo text — twelve
questions, all answering *"But I must explain to you how all this mistaken idea of
denouncing pleasure…"*, with headings like *"Waters one you'll creeping?"*. It is
now twelve real questions in four groups: ordering, delivery, returns, the
jewellery, wholesale.

**The product descriptions** exist because Paystack's agreement asks for "a
complete description of the goods sold", and nine of the ten products have neither
a photograph nor a word of text. Each description does three jobs: says what the
piece physically is, says what its symbol means, and states the materials — because
that is the paragraph a customer reads back to you during a dispute.

**The symbols strip** gives the empty "Why Adinkra" band something to say. It links
to `/symbols/`, which is the strongest page on the site and currently has nothing
pointing at it except the menu.

**The duplicate cleaner** is a plugin update, not a content file — see
`../queendor-cleanup/` and the notes below.

---

## The duplicates

`queendor-cleanup` **1.1.0** adds two sections to Tools → **Queen Dor's Cleanup**:

**5. Duplicate pages** — finds every page whose address ends in `-2`, `-3` and so
on, shows the page it should point at, and pre-ticks them all. Each one you remove
is **301-redirected** to its canonical page, so nothing already linked or indexed
breaks. `privacy-policy-3` goes to `privacy-policy-2` because no clean slug exists
yet; rename `-2` afterwards and the redirect follows the page, not the slug.

**6. The old domain** — lists every option and post-meta row still containing
`blaharbenyah.com`, then replaces them with the current host. This is what is
feeding the side cart's icons from the old site. The replace is serialisation-safe:
it unserialises first and lets WordPress re-serialise, because a plain `str_replace`
on serialized data corrupts it silently.

Both are dry-run first — nothing changes until you press the button.

> Run **6** before you switch the store live, and **5** after you have published the
> replacement pages. Deleting a duplicate whose good version is still a draft leaves
> you with a redirect to nothing.

---

## Still empty, after all this

- Ten product **photographs** — mine cannot substitute, and a stock image of
  someone else's jewellery is worse than an empty frame.
- The **real address, phone, email** and **three delivery prices** — the only
  brackets that appear in more than one file.
- The **ring sizes and measurements** in the product descriptions.

## customer-feedback.html

A customer-feedback band for the home page — three cards, five stars each, self-contained
styles. **The three quotes are placeholders**; replace them with real customer words
before launch. The plugin can add it (Tools → Queen Dor's Fixes → *Add customer feedback*),
or paste the file into an Elementor HTML widget.
