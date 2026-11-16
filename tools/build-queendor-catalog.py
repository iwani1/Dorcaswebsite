#!/usr/bin/env python3
"""Generate the Queen Dor's product import CSV.

WooCommerce > Products > All Products > Import reads this file directly.
Column names are taken from WooCommerce 11.2.1
(plugins/woocommerce/includes/admin/importers/class-wc-product-csv-importer-controller.php),
and variable products are exported as a parent row followed by one row per
variation with `Parent` set to the parent SKU.

Variations do not need a "used for variations" column: WooCommerce 11.1+
promotes the parent attribute automatically in
WC_Product_CSV_Importer::get_variation_parent_attributes().

⚠️  PRICES AND MATERIALS ARE PLACEHOLDERS. Replace before the shop goes public.
    They are listed for review in client/IMPORT-GUIDE.md.
"""

import csv
import pathlib

# Values that need confirming with the client before launch.
SIZES = ["L", "N", "P", "R", "T", "V"]

COLUMNS = [
    "ID", "Type", "SKU", "Name", "Published", "Is featured?",
    "Visibility in catalog", "Short description", "Description",
    "Tax status", "Tax class", "In stock?", "Stock", "Backorders allowed?",
    "Sold individually?", "Weight (kg)", "Allow customer reviews?",
    "Sale price", "Regular price", "Categories", "Tags", "Shipping class",
    "Images", "Parent", "Position",
    "Attribute 1 name", "Attribute 1 value(s)", "Attribute 1 visible", "Attribute 1 global",
    "Attribute 2 name", "Attribute 2 value(s)", "Attribute 2 visible", "Attribute 2 global",
    "Attribute 3 name", "Attribute 3 value(s)", "Attribute 3 visible", "Attribute 3 global",
]

SYMBOL = {
    "Sankofa": ("Go back and fetch it",
                "Carry where you come from into where you're going."),
    "Gye Nyame": ("Except for God",
                  "Wear the reminder that nothing happens outside God's knowledge."),
    "Duafe": ("The wooden comb",
              "A symbol of beauty that is looked after, not just worn."),
    "Akoma": ("The heart", "For the days that ask for patience."),
    "Bese Saka": ("The sack of cola nuts", "Abundance shared is abundance kept."),
    "Dwennimmen": ("The ram's horns", "Strength that doesn't need to announce itself."),
    "Adinkrahene": ("Chief of all Adinkra symbols",
                    "The symbol all other symbols answer to."),
    "Nkyinkyim": ("The twisting", "For the ones who change shape and keep going."),
}


def description(symbol, body, details):
    short, line = SYMBOL[symbol]
    items = "".join(f"<li>{d}</li>" for d in details)
    return (
        f"<p><strong>{symbol}</strong> — {short}. <em>{line}</em></p>"
        f"<p>{body}</p>"
        f"<ul>{items}</ul>"
        f"<p>Hand-finished in Accra and presented in a Queen Dor's pouch.</p>"
    )


def product(**kw):
    row = {c: "" for c in COLUMNS}
    row.update(
        Published="1",
        **{"Is featured?": "0", "Visibility in catalog": "visible"},
        **{"Tax status": "taxable", "In stock?": "1", "Backorders allowed?": "0",
           "Sold individually?": "0", "Allow customer reviews?": "1"},
    )
    row.update(kw)
    return row


PRODUCTS = [
    dict(
        sku="QD-001", name="Sankofa Pendant Necklace", cat="Necklaces",
        featured="1", tags="Everyday, Gifting", price="320", weight="0.050",
        short="A pendant for the symbol that means going back for what matters.",
        symbol="Sankofa",
        body="The Sankofa bird flies forward with its head turned back. Worn alone or "
             "layered, this is the piece people give when they mean something.",
        details=["Adjustable chain", "Also available in a boxed gift set"],
        attrs=[("Symbol", "Sankofa", 1), ("Chain length", "Adjustable 16–18 in", 1),
               ("Material", "Gold-plated", 1)],
    ),
    dict(
        sku="QD-002", name="Gye Nyame Pendant Necklace", cat="Necklaces",
        featured="0", tags="Everyday", price="320", weight="0.050",
        short="The most widely worn of all Adinkra symbols.",
        symbol="Gye Nyame",
        body="Worn as reassurance as much as declaration — a quiet reminder of what "
             "holds everything together.",
        details=["Adjustable chain", "Pairs with the Gye Nyame studs"],
        attrs=[("Symbol", "Gye Nyame", 1), ("Chain length", "Adjustable 16–18 in", 1),
               ("Material", "Gold-plated", 1)],
    ),
    dict(
        sku="QD-004", name="Akoma Stud Earrings", cat="Earrings",
        featured="0", tags="Everyday, Gifting", price="180", weight="0.020",
        short="Small, everyday, and the easiest first piece to give.",
        symbol="Akoma",
        body="Akoma is the heart — patience, tolerance, endurance. A stud to wear on "
             "the days that ask for it.",
        details=["Secure post and butterfly", "Light enough for all-day wear"],
        attrs=[("Symbol", "Akoma", 1), ("Material", "Gold-plated", 1)],
    ),
    dict(
        sku="QD-005", name="Bese Saka Adjustable Bracelet", cat="Bracelets",
        featured="0", tags="Everyday, Gifting", price="260", weight="0.040",
        short="One size, adjustable, and the natural partner to the Sankofa pendant.",
        symbol="Bese Saka",
        body="A sack of cola nuts stood for affluence and for the people who traded "
             "it. Abundance, and the responsibility that comes with it.",
        details=["Adjustable closure — one size fits most", "Stacks with the Adinkrahene set"],
        attrs=[("Symbol", "Bese Saka", 1), ("Material", "Brass", 1)],
    ),
    dict(
        sku="QD-008", name="Nkyinkyim Hoop Earrings", cat="Earrings",
        featured="0", tags="Statement", price="220", weight="0.025",
        short="The twisting — for the ones who change shape and keep going.",
        symbol="Nkyinkyim",
        body="From the proverb about the twists and turns of life. A larger earring "
             "for when the stud is not enough.",
        details=["Lightweight despite the size", "Secure clasp"],
        attrs=[("Symbol", "Nkyinkyim", 1), ("Material", "Gold-plated", 1)],
    ),
    dict(
        sku="QD-009", name="Five Symbols Layered Necklace", cat="Necklaces",
        featured="1", tags="Statement, Gifting, Bridal", price="480", weight="0.060",
        short="Five symbols, five meanings, one piece.",
        symbol="Adinkrahene",
        body="Gye Nyame for what holds everything, Sankofa for what you carry, Bese Saka "
             "for abundance, Dwennimmen for strength held quietly, and Adinkrahene for the "
             "standard. The most photographed piece in the collection, and the one that "
             "needs no explanation once it is on.",
        details=["Layered chain set", "Each symbol is separately finished"],
        attrs=[("Symbol", "Gye Nyame, Sankofa, Bese Saka, Dwennimmen, Adinkrahene", 1),
               ("Material", "Gold-plated", 1)],
    ),
    dict(
        sku="QD-010", name="Sankofa Necklace & Akoma Earring Gift Set", cat="Sets & Gifts",
        featured="0", tags="Gifting, Bridal", price="560", weight="0.150",
        short="The pendant and the studs, boxed together.",
        symbol="Sankofa",
        body="Sankofa for where you come from, Akoma for the patience it takes. A set "
             "made for giving — birthdays, graduations, and the ones who have been there.",
        details=["Boxed and ready to give", "Saves against buying the pieces separately"],
        attrs=[("Symbol", "Sankofa, Akoma", 1), ("Material", "Gold-plated", 1)],
    ),
]

RINGS = [
    dict(
        sku="QD-003", name="Duafe Statement Ring", cat="Rings",
        featured="0", tags="Statement", price="420", weight="0.030",
        short="The comb that stands for beauty looked after, not just worn.",
        symbol="Duafe",
        body="A wide statement band with the Duafe motif. Best worn alone, on the "
             "index or middle finger, where the carving reads.",
        details=[f"Available in UK sizes {SIZES[0]}–{SIZES[-1]}", "Made to order in other sizes"],
        material="Brass",
    ),
    dict(
        sku="QD-006", name="Dwennimmen Signet Ring", cat="Rings",
        featured="0", tags="Statement", price="480", weight="0.035",
        short="Strength and humility held at once — the ram's horns.",
        symbol="Dwennimmen",
        body="A signet shape with the Dwennimmen motif. Unisex, and the piece that "
             "tends to be bought for someone else.",
        details=[f"Available in UK sizes {SIZES[0]}–{SIZES[-1]}", "Made to order in other sizes"],
        material="Brass",
    ),
    dict(
        sku="QD-007", name="Adinkrahene Stacking Ring Set (3)", cat="Rings",
        featured="1", tags="Statement, Gifting", price="650", weight="0.045",
        short="Three bands, the chief of all Adinkra symbols.",
        symbol="Adinkrahene",
        body="Wear all three, or one at a time. Concentric circles — leadership, "
             "greatness, the standard the other symbols are measured against.",
        details=["Set of three rings", f"Available in UK sizes {SIZES[0]}–{SIZES[-1]}"],
        material="Brass",
    ),
]


def build():
    rows = []
    position = 0

    def add(entry, ring=False):
        nonlocal position
        position += 1
        attrs = entry["attrs"]
        row = product(
            SKU=entry["sku"], Name=entry["name"],
            **{"Short description": entry["short"],
               "Description": description(entry["symbol"], entry["body"], entry["details"]),
               "Weight (kg)": entry["weight"], "Regular price": entry["price"],
               "Categories": entry["cat"], "Tags": entry["tags"],
               "Position": str(position), "Is featured?": entry["featured"]},
        )
        for i, (name, value, visible) in enumerate(attrs, start=1):
            global_attr = 1 if name == "Symbol" else 0
            row[f"Attribute {i} name"] = name
            row[f"Attribute {i} value(s)"] = value
            row[f"Attribute {i} visible"] = str(visible)
            row[f"Attribute {i} global"] = str(global_attr)
        rows.append(row)

        if ring:
            row["Type"] = "variable"
            row["Regular price"] = ""          # the range comes from the variations
            for size in SIZES:
                v = product(
                    Type="variation", Parent=entry["sku"], SKU=f"{entry['sku']}-{size}",
                    Name=f"{entry['name']} — {size}",
                    **{"Regular price": entry["price"], "In stock?": "1",
                       "Visibility in catalog": "visible"},
                )
                # A variation names only the attribute that varies. The importer
                # resolves it by sanitised name ("Ring size" -> ring-size) and
                # matches it against the parent, then promotes the parent's
                # attribute to "used for variations" and saves it.
                v["Attribute 1 name"] = "Ring size"
                v["Attribute 1 value(s)"] = size
                v["Attribute 1 visible"] = "1"
                v["Attribute 1 global"] = "0"
                rows.append(v)
        else:
            row["Type"] = "simple"

    for entry in PRODUCTS:
        add(entry)

    for entry in RINGS:
        entry = dict(entry)
        material = entry.pop("material")
        entry["attrs"] = [
            ("Symbol", entry["symbol"], 1),
            ("Ring size", ", ".join(SIZES), 1),
            ("Material", material, 1),
        ]
        add(entry, ring=True)

    return rows


def main():
    rows = build()
    out = pathlib.Path(__file__).resolve().parent.parent / "client" / "queendor-products.csv"
    out.parent.mkdir(parents=True, exist_ok=True)
    with out.open("w", newline="", encoding="utf-8-sig") as fh:
        writer = csv.DictWriter(fh, fieldnames=COLUMNS, quoting=csv.QUOTE_MINIMAL)
        writer.writeheader()
        writer.writerows(rows)

    parents = [r for r in rows if r["Type"] != "variation"]
    variations = [r for r in rows if r["Type"] == "variation"]
    print(f"{out} — {len(rows)} rows ({len(parents)} products, {len(variations)} variations)")
    for r in parents:
        flag = " [featured]" if r["Is featured?"] == "1" else ""
        print(f"  {r['SKU']:<8} {r['Type']:<9} {r['Name'][:44]:<46} GHS {r['Regular price'] or '(range)'}{flag}")


if __name__ == "__main__":
    main()
