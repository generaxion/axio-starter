"use strict";var tag_first_and_last_block=function(){var e=document.querySelector(".wysiwyg");if(e){for(var t=0;t<e.childNodes.length;t++)if(3!==e.childNodes[t].nodeType&&"undefined"!==e.childNodes[t].classList){e.childNodes[t].classList.add("is-first-block");break}for(var n=e.childNodes.length-1;0<=n;n--)if(3!==e.childNodes[n].nodeType&&"undefined"!==e.childNodes[n].classList){e.childNodes[n].classList.add("is-last-block");break}}},responsive_tables_in_content=function(){var e=document.querySelectorAll(".wysiwyg .wp-block-table table");if(e)for(var t=0;t<e.length;t++){e[t].classList.add("wp-block-table--responsive");var n=document.createElement("div");n.setAttribute("class",e[t].getAttribute("class")),e[t].removeAttribute("class"),e[t].parentNode.insertBefore(n,e[t]),n.appendChild(e[t])}},wrap_old_images_with_caption=function(){var e=document.querySelectorAll(".wysiwyg .wp-caption");if(e.length)for(var t,n=0;n<e.length;n++){e[n].parentNode.classList.contains("wp-block-image")||((t=document.createElement("div")).setAttribute("class","wp-block-image"),e[n].parentNode.insertBefore(t,e[n]),t.appendChild(e[n]))}};wrap_old_images_with_caption();var wrap_old_aligned_images=function(){var e,t=document.querySelectorAll(".wysiwyg img.alignleft, .wysiwyg img.alignright");if(t.length)for(var n=0;n<t.length;n++){"P"===(e=t[n].parentNode).nodeName&&(e.parentNode.insertBefore(t[n],e),0===e.childNodes.length&&e.parentNode.removeChild(e));var i=t[n].classList.contains("alignleft")?"alignleft":"alignright";t[n].classList.remove(i);var a=document.createElement("figure");a.setAttribute("class",i),t[n].parentNode.insertBefore(a,t[n]),a.appendChild(t[n]);var o=document.createElement("div");o.setAttribute("class","wp-block-image"),a.parentNode.insertBefore(o,a),o.appendChild(a)}};wrap_old_aligned_images();var body_hero_background_indicator=function(){document.querySelector(".hero--no-background")&&document.body.classList.add("has-no-hero-background")};body_hero_background_indicator();var init_lightboxes_in_content=function(){var e=document.querySelectorAll(".blocks-gallery-item > figure > a, .gallery-item > .gallery-icon > a, .wp-block-image a, p > a > img, p > a > .wp-block-image");e.length&&e.forEach(function(t){var e=[".jpg",".png",".jpeg",".gif"];t.href?(e.some(function(e){return t.href.includes(e)})&&t.classList.add("lightbox"),t.nextElementSibling?"figcaption"===t.nextElementSibling.nodeName.toLowerCase()&&(t.dataset.caption=t.nextElementSibling.innerText):t.parentNode.nextElementSibling&&"figcaption"===t.parentNode.nextElementSibling.nodeName.toLowerCase()&&(t.dataset.caption=t.parentNode.nextElementSibling.innerText)):t.parentNode.href&&e.some(function(e){return t.parentNode.href.includes(e)})&&t.parentNode.classList.add("lightbox")})};document.addEventListener("DOMContentLoaded",function(){tag_first_and_last_block(),responsive_tables_in_content(),wrap_old_images_with_caption(),wrap_old_aligned_images(),body_hero_background_indicator(),init_lightboxes_in_content()});
//# sourceMappingURL=critical.js.map
