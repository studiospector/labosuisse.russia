(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[37],{115:function(e,t,c){"use strict";var n=c(6),a=c.n(n),l=c(0),s=c(14),o=c(4),r=c.n(o);c(153),t.a=e=>{let{className:t="",disabled:c=!1,name:n,permalink:o="",target:i,rel:u,style:d,onClick:b,...p}=e;const m=r()("wc-block-components-product-name",t);if(c){const e=p;return Object(l.createElement)("span",a()({className:m},e,{dangerouslySetInnerHTML:{__html:Object(s.decodeEntities)(n)}}))}return Object(l.createElement)("a",a()({className:m,href:o,target:i},p,{dangerouslySetInnerHTML:{__html:Object(s.decodeEntities)(n)},style:d}))}},153:function(e,t){},291:function(e,t,c){"use strict";var n=c(95);let a={headingLevel:{type:"number",default:2},showProductLink:{type:"boolean",default:!0},linkTarget:{type:"string"},productId:{type:"number",default:0}};Object(n.b)()&&(a={...a,align:{type:"string"}}),t.a=a},292:function(e,t,c){"use strict";var n=c(0),a=c(4),l=c.n(a),s=c(29),o=c(95),r=c(58),i=c(115),u=c(78),d=c(140),b=c(221),p=c(131);c(336);const m=e=>{let{children:t,headingLevel:c,elementType:a="h"+c,...l}=e;return Object(n.createElement)(a,l,t)};t.a=Object(r.withProductDataContext)(e=>{const{className:t,headingLevel:c=2,showProductLink:a=!0,linkTarget:r,align:j}=e,{parentClassName:O}=Object(s.useInnerBlockLayoutContext)(),{product:k}=Object(s.useProductDataContext)(),{dispatchStoreEvent:y}=Object(u.a)(),g=Object(d.a)(e),h=Object(b.a)(e),w=Object(p.a)(e);return k.id?Object(n.createElement)(m,{headingLevel:c,className:l()(t,g.className,"wc-block-components-product-title",{[O+"__product-title"]:O,["wc-block-components-product-title--align-"+j]:j&&Object(o.b)()}),style:Object(o.b)()?{...h.style,...w.style,...g.style}:{}},Object(n.createElement)(i.a,{disabled:!a,name:k.name,permalink:k.permalink,target:r,onClick:()=>{y("product-view-link",{product:k})}})):Object(n.createElement)(m,{headingLevel:c,className:l()(t,g.className,"wc-block-components-product-title",{[O+"__product-title"]:O,["wc-block-components-product-title--align-"+j]:j&&Object(o.b)()}),style:Object(o.b)()?{...h.style,...w.style,...g.style}:{}})})},336:function(e,t){},549:function(e,t,c){"use strict";c.r(t);var n=c(58),a=c(292),l=c(291);t.default=Object(n.withFilteredAttributes)(l.a)(a.a)}}]);