#!/usr/bin/env python3
"""Generate a WordPress eXtended RSS (WXR) file with the client's real pages.

Import with Tools > Import > WordPress. The pages are plain HTML, so they render
with the theme's default page template and can be restyled in Elementor later.

Run the demo cleanup first: importing a page whose slug already exists gives
WordPress an excuse to create `about-2`, and then there are two of everything.
"""

import datetime
import pathlib
import xml.etree.ElementTree as ET

SITE = "https://www.blaharbenyah.com/dorcas"
AUTHOR = "iwan1"
# Must be in the PAST when the file is imported. WordPress treats a WXR item
# whose post_date is in the future as a scheduled post, so a hardcoded stamp
# silently files every page under "Scheduled" and they 404 until cron catches
# up — which is exactly what happened on the first import.
NOW = datetime.datetime.now().replace(second=0, microsecond=0) - datetime.timedelta(minutes=5)

PAGES = [
    {
        "slug": "about",
        "title": "About",
        "body": """
<h2>Jewellery that already means something</h2>
<p>Queen Dor's Fashion House makes Adinkra jewellery in Accra.</p>
<p>Every symbol we use already means something — Gye Nyame for what holds everything together,
Sankofa for what you carry with you, Akoma for the patience it takes. We did not invent those
meanings, and we do not need to. We make them wearable.</p>
<p>Each piece is hand-finished here in Accra, in small runs. We sell retail and wholesale, and we
look after both the same way.</p>
<p>If you are buying for yourself, for someone you love, or for a shop — thank you. You are wearing
something that was made on purpose.</p>
<p><em>Elegant jewellery for every occasion.</em></p>
""",
    },
    {
        "slug": "contact",
        "title": "Contact",
        "body": """
<h2>Talk to us</h2>
<p>We answer faster on WhatsApp, but everything below works too.</p>
<ul>
<li><strong>Phone / WhatsApp:</strong> ________</li>
<li><strong>Email:</strong> ________</li>
<li><strong>Studio:</strong> ________, Accra, Ghana</li>
<li><strong>Opening hours:</strong> ________</li>
</ul>
<h3>Wholesale enquiries</h3>
<p>If you are a shop or a stockist, tell us what you carry and how many pieces you would like to
start with, and we will send you a trade price list.</p>
<h3>Orders</h3>
<p>Ready to buy? <a href="/shop/">Browse the collection</a>. Made-to-order pieces take a little
longer — we will confirm the date before we start.</p>
""",
    },
    {
        "slug": "shipping-delivery",
        "title": "Shipping & Delivery",
        "body": """
<h2>Where we deliver</h2>
<table>
<thead><tr><th>Where</th><th>How</th><th>Cost</th></tr></thead>
<tbody>
<tr><td><strong>Accra</strong></td><td>Dispatch rider, usually 1–2 working days</td><td>GH₵ ________</td></tr>
<tr><td><strong>Other regions</strong></td><td>Courier, 2–4 working days</td><td>GH₵ ________</td></tr>
</tbody>
</table>
<p>Free delivery on orders over <strong>GH₵ ________</strong> within Accra.</p>
<h2>Made-to-order pieces</h2>
<p>Pieces made to order take <strong>________ working days</strong> before dispatch. We confirm the
date with you before we start.</p>
<h2>Tracking</h2>
<p>Every parcel is packed and tracked by us. You will get a message with your tracking details once
it is on its way.</p>
<h2>Outside Ghana</h2>
<p>We do not ship internationally just yet. If you are abroad and want a piece, message us and we
will tell you honestly whether we can get it to you.</p>
""",
    },
    {
        "slug": "returns-exchanges",
        "title": "Returns & Exchanges",
        "body": """
<h2>Earrings</h2>
<p><strong>Earrings cannot be returned</strong> for hygiene reasons, unless they arrive damaged or
faulty. This is standard for jewellery and we cannot make exceptions.</p>
<h2>Everything else</h2>
<ul>
<li>Contact us within <strong>7 days</strong> of delivery</li>
<li>The piece must be unworn, unaltered, and in its original packaging</li>
<li>We will exchange it or refund it — your choice</li>
<li><strong>Made-to-order and personalised pieces cannot be returned</strong> unless faulty</li>
</ul>
<h2>If something arrives damaged</h2>
<p>Send us a photo the same day and we will replace it at our cost.</p>
<h2>Return delivery</h2>
<p>Return delivery is paid by the customer unless the item was faulty or we sent the wrong piece.</p>
""",
    },
    {
        "slug": "privacy-policy",
        "title": "Privacy Policy",
        "body": """
<h2>Who we are</h2>
<p>Queen Dor's Fashion House ("we") sells jewellery online to customers in Ghana.</p>
<h2>What we collect</h2>
<p>Your name, delivery address, phone number, email address, and the details of what you ordered.
If you pay by card or mobile money, the payment is handled by our payment provider — we never see
or store your card details.</p>
<h2>Why we collect it</h2>
<p>To deliver your order, to contact you about it, and to keep the records the law requires us to
keep. If you tick the newsletter box, we also use your email to tell you about new pieces — you can
unsubscribe at any time.</p>
<h2>Who we share it with</h2>
<p>Our delivery partners (your name, address and phone number, because they need them to deliver),
our payment provider, and our email provider. Nobody else. We do not sell your data.</p>
<h2>How long we keep it</h2>
<p>Order records for six years, as required for tax and accounting. Marketing consent until you
withdraw it.</p>
<h2>Your rights</h2>
<p>Under the Data Protection Act, 2012 (Act 843), you can ask us what we hold about you, ask us to
correct it, or ask us to delete it. Write to <strong>________</strong> and we will respond within
30 days.</p>
<h2>Cookies</h2>
<p>This site uses cookies to keep your cart working and to understand which pages people use. You
can block them in your browser, though the cart will stop working.</p>
""",
    },
    {
        "slug": "size-guide",
        "title": "Size Guide",
        "body": """
<p>Measuring a ring you already own is more accurate than measuring your finger. If you are between
two sizes, size up — a ring that is slightly loose sits better than one that is tight.</p>
[queendor_ring_guide]
""",
    },
    {
        "slug": "symbols",
        "title": "Symbols",
        "body": """
<p>Every piece we make carries an Adinkra symbol, and every symbol already means something. Here is
what they stand for — and the pieces that wear them.</p>
[queendor_symbol_index]
""",
    },
    {
        "slug": "wholesale",
        "title": "Wholesale",
        "body": """
<h2>Stock Queen Dor's</h2>
<p>We supply boutiques and stockists with Adinkra jewellery, retail-ready and boxed.</p>
<ul>
<li><strong>Minimum order:</strong> ________ pieces per style</li>
<li><strong>Lead time:</strong> ________ working days</li>
<li><strong>Terms:</strong> ________</li>
</ul>
<p>Send us a short note with your shop name, where you are, and what you would like to start with.
We will send the trade price list and the current lookbook.</p>
<p><strong>Wholesale enquiries:</strong> ________</p>
""",
    },
]

WXR_NS = {
    "excerpt": "http://wordpress.org/export/1.2/excerpt/",
    "content": "http://purl.org/rss/1.0/modules/content/",
    "wfw": "http://wellformedweb.org/CommentAPI/",
    "dc": "http://purl.org/dc/elements/1.1/",
    "wp": "http://wordpress.org/export/1.2/",
}


def build():
    for prefix, uri in WXR_NS.items():
        ET.register_namespace(prefix, uri)

    # register_namespace() makes ElementTree emit the prefixes it needs; adding
    # xmlns attributes by hand as well produces duplicate declarations.
    rss = ET.Element("rss", {"version": "2.0"})
    channel = ET.SubElement(rss, "channel")

    ET.SubElement(channel, "title").text = "Queen Dor's — pages"
    ET.SubElement(channel, "link").text = SITE
    ET.SubElement(channel, "description").text = "Client page content for Queen Dor's Fashion House"
    ET.SubElement(channel, "pubDate").text = NOW.strftime("%a, %d %b %Y %H:%M:%S +0000")
    ET.SubElement(channel, "language").text = "en-GB"
    ET.SubElement(channel, f"{{{WXR_NS['wp']}}}wxr_version").text = "1.2"
    ET.SubElement(channel, f"{{{WXR_NS['wp']}}}base_site_url").text = SITE
    ET.SubElement(channel, f"{{{WXR_NS['wp']}}}base_blog_url").text = SITE

    author = ET.SubElement(channel, f"{{{WXR_NS['wp']}}}author")
    ET.SubElement(author, f"{{{WXR_NS['wp']}}}author_id").text = "1"
    ET.SubElement(author, f"{{{WXR_NS['wp']}}}author_login").text = AUTHOR
    ET.SubElement(author, f"{{{WXR_NS['wp']}}}author_email").text = "orders@example.com"
    ET.SubElement(author, f"{{{WXR_NS['wp']}}}author_display_name").text = "Queen Dor's"

    for index, page in enumerate(PAGES, start=1):
        item = ET.SubElement(channel, "item")
        ET.SubElement(item, "title").text = page["title"]
        ET.SubElement(item, "link").text = f"{SITE}/{page['slug']}/"
        ET.SubElement(item, "pubDate").text = NOW.strftime("%a, %d %b %Y %H:%M:%S +0000")
        ET.SubElement(item, f"{{{WXR_NS['dc']}}}creator").text = AUTHOR
        ET.SubElement(item, "guid", {"isPermaLink": "false"}).text = f"{SITE}/?page_id={900 + index}"
        ET.SubElement(item, "description").text = ""
        ET.SubElement(item, f"{{{WXR_NS['content']}}}encoded").text = page["body"].strip()
        ET.SubElement(item, f"{{{WXR_NS['excerpt']}}}encoded").text = ""
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_id").text = str(900 + index)
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_date").text = NOW.strftime("%Y-%m-%d %H:%M:%S")
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_date_gmt").text = NOW.strftime("%Y-%m-%d %H:%M:%S")
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}comment_status").text = "closed"
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}ping_status").text = "closed"
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_name").text = page["slug"]
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}status").text = "publish"
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_parent").text = "0"
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}menu_order").text = str(index)
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_type").text = "page"
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}post_password").text = ""
        ET.SubElement(item, f"{{{WXR_NS['wp']}}}is_sticky").text = "0"

    return rss


def main():
    root = build()
    ET.indent(root, space="\t")
    out = pathlib.Path(__file__).resolve().parent.parent / "client" / "queendor-pages.wxr"
    xml = ET.tostring(root, encoding="utf-8", xml_declaration=True)
    out.write_bytes(xml)

    # Re-parse to prove it is well-formed before anyone tries to import it.
    ET.parse(out)
    print(f"{out} — {len(PAGES)} pages, {len(xml)} bytes, well-formed")
    for page in PAGES:
        flags = []
        if "________" in page["body"]:
            flags.append("has blanks")
        if "[" in page["body"]:
            flags.append("shortcode")
        print(f"  /{page['slug']:<20} {page['title']:<20} {', '.join(flags) or ''}")


if __name__ == "__main__":
    main()
