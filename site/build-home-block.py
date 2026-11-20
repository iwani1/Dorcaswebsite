import json, html
P = {p['id']: p for p in json.load(open('products.json'))}
SYM = [
 ("Sankofa","sankofa","Go back and fetch it","The bird flies forward with its head turned back. It is not wrong to return for what you left behind.",1464),
 ("Gye Nyame","gye-nyame","Except for God","The most widely worn of all Adinkra symbols. Everything that has happened and will happen is already known.",1465),
 ("Akoma","akoma","The heart","Patience, tolerance and endurance. A promise that the heart can hold more than the moment it is in.",1466),
 ("Duafe","duafe","The wooden comb","Given as a token of love and care: beauty is something tended, not something owned.",1461),
 ("Dwennimmen","dwennimmen","The ram's horns","The ram fights with its horns, and the same horns mean humility. Strength, and the wisdom to keep it quiet.",1462),
 ("Adinkrahene","adinkrahene","Chief of all symbols","Three concentric circles, and the king of the Adinkra set. The standard the others are measured against.",1463),
 ("Bese Saka","bese-saka","The sack of cola nuts","Abundance and togetherness: plenty that brings people together.",1467),
 ("Nkyinkyim","nkyinkyim","The twisting","Initiative and adaptability, for the ones who change shape and keep going.",1468),
]
def count(sym): return sum(1 for p in P.values() if any(a['name'].lower()=='symbol' and any(t['name']==sym for t in a['terms']) for a in p.get('attributes',[])))
def price(p): 
    m=int(p['prices']['currency_minor_unit']); v=int(p['prices']['price'])/10**m
    return "₵"+f"{v:,.2f}"
def symtxt(p):
    s=[t['name'] for a in p.get('attributes',[]) if a['name'].lower()=='symbol' for t in a['terms']]
    return f"{len(s)} symbols" if len(s)>2 else " · ".join(s)
def ss(im):
    keep=[]
    for part in im['srcset'].split(','):
        if ' ' not in part.strip(): continue
        u,w=part.strip().rsplit(' ',1)
        if int(w[:-1]) in (600,768,936,1024) or int(w[:-1])>=1170: keep.append(f"{u} {w}")
    return ", ".join(keep) or im["src"]
def esc(s): return html.escape(html.unescape(s), quote=True)
SPREAD=[1463,1466,1461,1462,1464,1465]

css = r'''
.qdl{--qdl-bg:#f7f6f3;--qdl-well:#ebe8e2;--qdl-ink:#16130f;--qdl-ink2:#5b554d;--qdl-line:#ddd8d0;--qdl-gold:#d9ad5e;--qdl-serif:"Cormorant Garamond","Cormorant",Georgia,serif;--qdl-sans:"Jost","Futura","Avenir Next",system-ui,sans-serif;background:var(--qdl-bg);color:var(--qdl-ink);font-family:var(--qdl-sans);font-size:15px;line-height:1.6;letter-spacing:.01em}
.qdl *{box-sizing:border-box}
.qdl a{color:inherit}
.qdl h1,.qdl h2,.qdl h3,.qdl p{margin:0}
.qdl .qdl-wrap{max-width:1360px;margin:0 auto;padding-left:max(20px,env(safe-area-inset-left,0px));padding-right:max(20px,env(safe-area-inset-right,0px))}
.qdl .qdl-sr{position:absolute!important;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
.qdl a:focus-visible,.qdl button:focus-visible{outline:2px solid var(--qdl-gold);outline-offset:3px}
.qdl-stage{position:relative;width:100%;height:clamp(560px,88vh,880px);overflow:hidden;background:#0e0d0b;color:#f4f1ea}
.qdl-stage img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transform:scale(1.04);transition:opacity .9s ease,transform 6s ease}
.qdl-stage img.on{opacity:1;transform:scale(1)}
.qdl-stage::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,9,8,.45) 0%,rgba(10,9,8,.05) 30%,rgba(10,9,8,.12) 55%,rgba(10,9,8,.8) 100%);pointer-events:none}
.qdl-copy{position:absolute;z-index:2;left:0;right:0;top:50%;transform:translateY(-55%);text-align:center;padding:0 20px}
.qdl-copy h1{font:500 12px/1.4 var(--qdl-sans);letter-spacing:.3em;text-transform:uppercase;color:rgba(244,241,234,.85)}
.qdl-name{display:block;font:300 clamp(56px,10vw,136px)/1 var(--qdl-serif);margin-top:14px;color:#f4f1ea}
.qdl-gloss{display:block;margin-top:14px;font:italic 400 clamp(20px,2.2vw,26px)/1.3 var(--qdl-serif);color:#f4f1ea}
.qdl .qdl-mean{max-width:46ch;margin:12px auto 0;font-size:16px;color:rgba(244,241,234,.88)}
.qdl-go{display:inline-block;margin-top:30px;color:#f4f1ea!important;text-decoration:none!important;font-size:12px;letter-spacing:.24em;text-transform:uppercase;border-bottom:1px solid currentColor;padding-bottom:6px}
.qdl-rail{position:absolute;z-index:2;left:0;right:0;bottom:0;display:grid;grid-template-columns:repeat(8,minmax(0,1fr));gap:14px;padding:0 max(28px,env(safe-area-inset-right,0px)) 26px max(28px,env(safe-area-inset-left,0px));margin:0;list-style:none}
.qdl-rail button{width:100%;background:none!important;border:0;border-top:1px solid rgba(244,241,234,.35);border-radius:0;color:rgba(244,241,234,.62)!important;text-align:left;padding:12px 0 0;font:500 11px/1.3 var(--qdl-sans);letter-spacing:.2em;text-transform:uppercase;cursor:pointer;min-height:44px;transition:color .3s,border-color .3s;box-shadow:none}
.qdl-rail button:hover{color:#f4f1ea!important}
.qdl-rail button[aria-pressed="true"]{color:#f4f1ea!important;border-top:2px solid var(--qdl-gold)}
@media (max-width:760px){.qdl-rail{grid-template-columns:none;grid-auto-flow:column;grid-auto-columns:34%;overflow-x:auto;scrollbar-width:none;gap:16px}.qdl-rail button{font-size:10px;letter-spacing:.16em}.qdl-copy{transform:translateY(-60%)}}
.qdl-sec{padding:96px 0}
.qdl-head{display:flex;justify-content:space-between;align-items:baseline;gap:16px;border-bottom:1px solid var(--qdl-line);padding-bottom:12px;margin-bottom:56px}
.qdl-head h2{font:400 clamp(32px,4vw,48px)/1 var(--qdl-serif)}
.qdl-head a,.qdl-link{font-size:12px;letter-spacing:.2em;text-transform:uppercase;text-decoration:none!important;border-bottom:1px solid currentColor;padding-bottom:4px}
.qdl-spread{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));gap:56px 24px;list-style:none;margin:0;padding:0}
.qdl-spread>li{min-width:0;margin:0}
.qdl-spread>li:nth-child(1){grid-column:1/8}
.qdl-spread>li:nth-child(2){grid-column:9/13;align-self:end}
.qdl-spread>li:nth-child(3){grid-column:2/6}
.qdl-spread>li:nth-child(4){grid-column:7/13}
.qdl-spread>li:nth-child(5){grid-column:1/6}
.qdl-spread>li:nth-child(6){grid-column:7/11;align-self:center}
@media (max-width:760px){.qdl-spread{grid-template-columns:1fr 1fr;gap:40px 14px}.qdl-spread>li{grid-column:auto!important}.qdl-spread>li:nth-child(3n+1){grid-column:1/-1!important}.qdl-sec{padding:64px 0}}
.qdl-card{position:relative;display:grid;gap:10px}
.qdl-card .qdl-img{background:var(--qdl-well);overflow:hidden}
.qdl-card img{display:block;width:100%;height:auto;aspect-ratio:4/5;object-fit:cover;transition:transform 1.2s cubic-bezier(.2,.7,.2,1)}
.qdl-card:hover img{transform:scale(1.035)}
.qdl-card .qdl-s{font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:var(--qdl-ink2)}
.qdl-card .qdl-row{display:flex;flex-wrap:wrap;justify-content:space-between;gap:4px 16px;align-items:baseline}
.qdl-card h3{font:400 24px/1.15 var(--qdl-serif)}
.qdl-card h3 a{text-decoration:none!important}
.qdl-card h3 a::after{content:"";position:absolute;inset:0}
.qdl-card .qdl-p{font-size:13px;letter-spacing:.08em;font-variant-numeric:tabular-nums;white-space:nowrap}
.qdl-quote{text-align:center;padding:40px 0 112px}
.qdl .qdl-quote p{font:300 clamp(28px,3.6vw,48px)/1.2 var(--qdl-serif);max-width:26ch;margin:0 auto 32px}
.qdl-trade{border-top:1px solid var(--qdl-line);display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;padding:36px 0 72px}
.qdl .qdl-trade p{font:400 clamp(22px,2.4vw,28px)/1.25 var(--qdl-serif)}
@media (prefers-reduced-motion:reduce){.qdl *{transition:none!important}}
'''
imgs=[]; rail=[]
for i,(n,slug,gl,tx,pid) in enumerate(SYM):
    p=P[pid]; im=p['images'][0]
    imgs.append(f'<img src="{im["src"]}" srcset="{ss(im)}" sizes="100vw" alt="" data-s="{slug}" width="1170" height="1280" {"fetchpriority=\"high\" class=\"on\"" if i==0 else "loading=\"lazy\""} decoding="async">')
    rail.append(f'<li><button type="button" data-s="{slug}" data-name="{esc(n)}" data-gloss="{esc(gl)}" data-text="{esc(tx)}" data-n="{count(n)}" aria-pressed="{"true" if i==0 else "false"}">{esc(n)}</button></li>')
cards=[]
for pid in SPREAD:
    p=P[pid]; im=p['images'][0]
    cards.append(f'''<li class="qdl-card" data-id="{pid}"><div class="qdl-img"><img src="{im["src"]}" srcset="{ss(im)}" sizes="(max-width:760px) 50vw, 40vw" alt="{esc(p["name"])}, Adinkra jewellery by Queen Dor's" width="1170" height="1280" loading="lazy" decoding="async"></div><p class="qdl-s">{esc(symtxt(p))}</p><div class="qdl-row"><h3><a href="{p["permalink"]}">{esc(p["name"])}</a></h3><span class="qdl-p">{price(p)}</span></div></li>''')
n0=count("Sankofa")
js = r'''
(function(){
  var root=document.getElementById("qdl"); if(!root) return;
  var btns=root.querySelectorAll(".qdl-rail button"), imgs=root.querySelectorAll(".qdl-stage img");
  function set(b){
    var s=b.getAttribute("data-s"), n=+b.getAttribute("data-n");
    btns.forEach(function(x){x.setAttribute("aria-pressed", x===b?"true":"false")});
    imgs.forEach(function(i){ if(i.getAttribute("data-s")===s){ i.removeAttribute("loading"); i.classList.add("on") } else i.classList.remove("on") });
    root.querySelector(".qdl-name").textContent=b.getAttribute("data-name");
    root.querySelector(".qdl-gloss").textContent=b.getAttribute("data-gloss");
    root.querySelector(".qdl-mean").textContent=b.getAttribute("data-text");
    var go=root.querySelector(".qdl-go"); go.href="/symbol/"+s+"/";
    go.textContent="Shop "+b.getAttribute("data-name")+" · "+n+" piece"+(n===1?"":"s");
  }
  btns.forEach(function(b){ b.addEventListener("click",function(){ set(b) }) });
  /* Keep names, prices and photos in step with the shop. */
  if(window.fetch){
    fetch("/wp-json/wc/store/v1/products?per_page=50").then(function(r){return r.ok?r.json():[]}).then(function(list){
      var by={}; list.forEach(function(p){by[p.id]=p});
      root.querySelectorAll(".qdl-card").forEach(function(c){
        var p=by[c.getAttribute("data-id")]; if(!p) return;
        var m=Math.pow(10,p.prices.currency_minor_unit), v=(+p.prices.price)/m;
        c.querySelector(".qdl-p").textContent="₵"+v.toLocaleString("en-GH",{minimumFractionDigits:2,maximumFractionDigits:2});
        var a=c.querySelector("h3 a"); a.href=p.permalink; var t=document.createElement("textarea"); t.innerHTML=p.name; a.textContent=t.value;
        if(p.images&&p.images[0]){ var im=c.querySelector("img"); im.src=p.images[0].src; if(p.images[0].srcset) im.srcset=p.images[0].srcset; if(p.images[0].alt) im.alt=p.images[0].alt }
      });
    }).catch(function(){});
  }
})();
'''
out=f'''<!-- Queen Dor's homepage, Lumina design. Self-contained: styles, markup and a small script travel together in this one HTML widget.
     The symbol stage swaps photo, meaning and link when a symbol name is chosen. The six pieces below refresh their names,
     prices and photos from the shop on page load, so price changes in WooCommerce show here without editing this block. -->
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,400&family=Jost:wght@400;500&display=swap">
<style>{css}</style>
<div class="qdl" id="qdl">
  <section class="qdl-stage" aria-labelledby="qdl-h1">
    {"".join(imgs)}
    <div class="qdl-copy">
      <h1 id="qdl-h1">Adinkra jewellery, hand-finished in Accra</h1>
      <div aria-live="polite"><span class="qdl-name">Sankofa</span><span class="qdl-gloss">Go back and fetch it</span><p class="qdl-mean">{esc(SYM[0][3])}</p></div>
      <a class="qdl-go" href="/symbol/sankofa/">Shop Sankofa · {n0} piece{"" if n0==1 else "s"}</a>
    </div>
    <ul class="qdl-rail" aria-label="Choose a symbol">{"".join(rail)}</ul>
  </section>
  <section class="qdl-sec" aria-labelledby="qdl-c">
    <div class="qdl-wrap">
      <div class="qdl-head"><h2 id="qdl-c">The collection</h2><a href="/shop/">All {len(P)} pieces</a></div>
      <ul class="qdl-spread">{"".join(cards)}</ul>
    </div>
  </section>
  <section class="qdl-quote" aria-label="About the symbols">
    <div class="qdl-wrap"><p>Every symbol we use already meant something long before we made jewellery from it.</p><a class="qdl-link" href="/symbols/">Read the symbols</a></div>
  </section>
  <div class="qdl-wrap"><div class="qdl-trade"><p>Boutiques and stockists: trade at 50% of retail.</p><a class="qdl-link" href="/wholesale/">Apply for an account</a></div></div>
</div>
<script>{js}</script>
'''
open('lumina.html','w').write(out)
print(len(out), n0, [count(s[0]) for s in SYM])
