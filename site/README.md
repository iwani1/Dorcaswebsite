# Queen Dor's · Lumina design

Files behind the Lumina redesign of queendorfashionhouse.com.

| File | Where it lives on the site |
|---|---|
| `home-lumina-block.html` | The homepage's Elementor HTML widget (page "Adinkra Jewellery in Accra", ID 25). Readable source; the live copy is the same markup minified. |
| `build-home-block.py` | Regenerates `home-lumina-block.html` from the shop's Store API (`products.json` from `/wp-json/wc/store/v1/products?per_page=20`). |
| `lumina-site.css` | Site-wide styles for the header, page title band, shop, product pages, buttons and footer. Goes in Appearance › Customize › Additional CSS. |

The homepage also has a second small HTML widget with layout fixes (full-bleed stage, removing the theme's padding, heading colours).

To undo the homepage, restore page 25's revision 9522 in WordPress.
