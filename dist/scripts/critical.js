!function(e,t){var a=function(n,m){"use strict";if(!m.getElementsByClassName)return;var z,y,v=m.documentElement,r=n.Date,i=n.HTMLPictureElement,s="addEventListener",g="getAttribute",t=n[s],u=n.setTimeout,a=n.requestAnimationFrame||u,o=n.requestIdleCallback,f=/^picture$/i,l=["load","error","lazyincluded","_lazyloaded"],d={},h=Array.prototype.forEach,c=function(e,t){return d[t]||(d[t]=new RegExp("(\\s|^)"+t+"(\\s|$)")),d[t].test(e[g]("class")||"")&&d[t]},p=function(e,t){c(e,t)||e.setAttribute("class",(e[g]("class")||"").trim()+" "+t)},C=function(e,t){var a;(a=c(e,t))&&e.setAttribute("class",(e[g]("class")||"").replace(a," "))},b=function(t,a,e){var n=e?s:"removeEventListener";e&&b(t,a),l.forEach(function(e){t[n](e,a)})},A=function(e,t,a,n,i){var r=m.createEvent("Event");return a||(a={}),a.instance=z,r.initEvent(t,!n,!i),r.detail=a,e.dispatchEvent(r),r},E=function(e,t){var a;!i&&(a=n.picturefill||y.pf)?(t&&t.src&&!e[g]("srcset")&&e.setAttribute("srcset",t.src),a({reevaluate:!0,elements:[e]})):t&&t.src&&(e.src=t.src)},N=function(e,t){return(getComputedStyle(e,null)||{})[t]},w=function(e,t,a){for(a=a||e.offsetWidth;a<y.minSize&&t&&!e._lazysizesWidth;)a=t.offsetWidth,t=t.parentNode;return a},M=(L=[],S=[],T=L,B=function(){var e=T;for(T=L.length?S:L,x=!(W=!0);e.length;)e.shift()();W=!1},F=function(e,t){W&&!t?e.apply(this,arguments):(T.push(e),x||(x=!0,(m.hidden?u:a)(B)))},F._lsFlush=B,F),e=function(a,e){return e?function(){M(a)}:function(){var e=this,t=arguments;M(function(){a.apply(e,t)})}},_=function(e){var t,a,n=function(){t=null,e()},i=function(){var e=r.now()-a;e<99?u(i,99-e):(o||n)(n)};return function(){a=r.now(),t||(t=u(i,99))}};var W,x,L,S,T,B,F;!function(){var e,t={lazyClass:"lazyload",loadedClass:"lazyloaded",loadingClass:"lazyloading",preloadClass:"lazypreload",errorClass:"lazyerror",autosizesClass:"lazyautosizes",srcAttr:"data-src",srcsetAttr:"data-srcset",sizesAttr:"data-sizes",minSize:40,customMedia:{},init:!0,expFactor:1.5,hFac:.8,loadMode:2,loadHidden:!0,ricTimeout:0,throttleDelay:125};for(e in y=n.lazySizesConfig||n.lazysizesConfig||{},t)e in y||(y[e]=t[e]);n.lazySizesConfig=y,u(function(){y.init&&D()})}();var R=(oe=/^img$/i,le=/^iframe$/i,de="onscroll"in n&&!/(gle|ing)bot/.test(navigator.userAgent),ce=0,ue=0,fe=-1,me=function(e){ue--,e&&e.target&&b(e.target,me),(!e||ue<0||!e.target)&&(ue=0)},ze=function(e){return null==Z&&(Z="hidden"==N(m.body,"visibility")),Z||"hidden"!=N(e.parentNode,"visibility")&&"hidden"!=N(e,"visibility")},ye=function(e,t){var a,n=e,i=ze(e);for(U-=t,Y+=t,V-=t,X+=t;i&&(n=n.offsetParent)&&n!=m.body&&n!=v;)(i=0<(N(n,"opacity")||1))&&"visible"!=N(n,"overflow")&&(a=n.getBoundingClientRect(),i=X>a.left&&V<a.right&&Y>a.top-1&&U<a.bottom+1);return i},ve=function(){var e,t,a,n,i,r,s,o,l,d,c,u,f=z.elements;if((G=y.loadMode)&&ue<8&&(e=f.length)){for(t=0,fe++,d=!y.expand||y.expand<1?500<v.clientHeight&&500<v.clientWidth?500:370:y.expand,c=d*y.expFactor,u=y.hFac,Z=null,ce<c&&ue<1&&2<fe&&2<G&&!m.hidden?(ce=c,fe=0):ce=1<G&&1<fe&&ue<6?d:0;t<e;t++)if(f[t]&&!f[t]._lazyRace)if(de)if((o=f[t][g]("data-expand"))&&(r=1*o)||(r=ce),l!==r&&(K=innerWidth+r*u,Q=innerHeight+r,s=-1*r,l=r),a=f[t].getBoundingClientRect(),(Y=a.bottom)>=s&&(U=a.top)<=Q&&(X=a.right)>=s*u&&(V=a.left)<=K&&(Y||X||V||U)&&(y.loadHidden||ze(f[t]))&&(I&&ue<3&&!o&&(G<3||fe<4)||ye(f[t],r))){if(Ee(f[t]),i=!0,9<ue)break}else!i&&I&&!n&&ue<4&&fe<4&&2<G&&(q[0]||y.preloadAfterLoad)&&(q[0]||!o&&(Y||X||V||U||"auto"!=f[t][g](y.sizesAttr)))&&(n=q[0]||f[t]);else Ee(f[t]);n&&!i&&Ee(n)}},ee=ve,ae=0,ne=y.throttleDelay,ie=y.ricTimeout,re=function(){te=!1,ae=r.now(),ee()},se=o&&49<ie?function(){o(re,{timeout:ie}),ie!==y.ricTimeout&&(ie=y.ricTimeout)}:e(function(){u(re)},!0),ge=function(e){var t;(e=!0===e)&&(ie=33),te||(te=!0,(t=ne-(r.now()-ae))<0&&(t=0),e||t<9?se():u(se,t))},he=function(e){p(e.target,y.loadedClass),C(e.target,y.loadingClass),b(e.target,Ce),A(e.target,"lazyloaded")},pe=e(he),Ce=function(e){pe({target:e.target})},be=function(e){var t,a=e[g](y.srcsetAttr);(t=y.customMedia[e[g]("data-media")||e[g]("media")])&&e.setAttribute("media",t),a&&e.setAttribute("srcset",a)},Ae=e(function(e,t,a,n,i){var r,s,o,l,d,c;(d=A(e,"lazybeforeunveil",t)).defaultPrevented||(n&&(a?p(e,y.autosizesClass):e.setAttribute("sizes",n)),s=e[g](y.srcsetAttr),r=e[g](y.srcAttr),i&&(o=e.parentNode,l=o&&f.test(o.nodeName||"")),c=t.firesLoad||"src"in e&&(s||r||l),d={target:e},c&&(b(e,me,!0),clearTimeout(j),j=u(me,2500),p(e,y.loadingClass),b(e,Ce,!0)),l&&h.call(o.getElementsByTagName("source"),be),s?e.setAttribute("srcset",s):r&&!l&&(le.test(e.nodeName)?function(t,a){try{t.contentWindow.location.replace(a)}catch(e){t.src=a}}(e,r):e.src=r),i&&(s||l)&&E(e,{src:r})),e._lazyRace&&delete e._lazyRace,C(e,y.lazyClass),M(function(){(!c||e.complete&&1<e.naturalWidth)&&(c?me(d):ue--,he(d))},!0)}),Ee=function(e){var t,a=oe.test(e.nodeName),n=a&&(e[g](y.sizesAttr)||e[g]("sizes")),i="auto"==n;(!i&&I||!a||!e[g]("src")&&!e.srcset||e.complete||c(e,y.errorClass)||!c(e,y.lazyClass))&&(t=A(e,"lazyunveilread").detail,i&&k.updateElem(e,!0,e.offsetWidth),e._lazyRace=!0,ue++,Ae(e,t,i,n,a))},Ne=function(){if(!I)if(r.now()-J<999)u(Ne,999);else{var e=_(function(){y.loadMode=3,ge()});I=!0,y.loadMode=3,ge(),t("scroll",function(){3==y.loadMode&&(y.loadMode=2),e()},!0)}},{_:function(){J=r.now(),z.elements=m.getElementsByClassName(y.lazyClass),q=m.getElementsByClassName(y.lazyClass+" "+y.preloadClass),t("scroll",ge,!0),t("resize",ge,!0),n.MutationObserver?new MutationObserver(ge).observe(v,{childList:!0,subtree:!0,attributes:!0}):(v[s]("DOMNodeInserted",ge,!0),v[s]("DOMAttrModified",ge,!0),setInterval(ge,999)),t("hashchange",ge,!0),["focus","mouseover","click","load","transitionend","animationend","webkitAnimationEnd"].forEach(function(e){m[s](e,ge,!0)}),/d$|^c/.test(m.readyState)?Ne():(t("load",Ne),m[s]("DOMContentLoaded",ge),u(Ne,2e4)),z.elements.length?(ve(),M._lsFlush()):ge()},checkElems:ge,unveil:Ee}),k=(O=e(function(e,t,a,n){var i,r,s;if(e._lazysizesWidth=n,n+="px",e.setAttribute("sizes",n),f.test(t.nodeName||""))for(i=t.getElementsByTagName("source"),r=0,s=i.length;r<s;r++)i[r].setAttribute("sizes",n);a.detail.dataAttr||E(e,a.detail)}),P=function(e,t,a){var n,i=e.parentNode;i&&(a=w(e,i,a),(n=A(e,"lazybeforesizes",{width:a,dataAttr:!!t})).defaultPrevented||(a=n.detail.width)&&a!==e._lazysizesWidth&&O(e,i,n,a))},$=_(function(){var e,t=H.length;if(t)for(e=0;e<t;e++)P(H[e])}),{_:function(){H=m.getElementsByClassName(y.autosizesClass),t("resize",$)},checkElems:$,updateElem:P}),D=function(){D.i||(D.i=!0,k._(),R._())};var H,O,P,$;var q,I,j,G,J,K,Q,U,V,X,Y,Z,ee,te,ae,ne,ie,re,se,oe,le,de,ce,ue,fe,me,ze,ye,ve,ge,he,pe,Ce,be,Ae,Ee,Ne;return z={cfg:y,autoSizer:k,loader:R,init:D,uP:E,aC:p,rC:C,hC:c,fire:A,gW:w,rAF:M}}(e,e.document);e.lazySizes=a,"object"==typeof module&&module.exports&&(module.exports=a)}(window),document.addEventListener("lazybeforeunveil",function(e){e.target.addEventListener("load",function(e){var t=this.parentNode.querySelector(".lazyload-preload");t&&t.classList.add("lazyload-preload--ready")})});
//# sourceMappingURL=critical.js.map
