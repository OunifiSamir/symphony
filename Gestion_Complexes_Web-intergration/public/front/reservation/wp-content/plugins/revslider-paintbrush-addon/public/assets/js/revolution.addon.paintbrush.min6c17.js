/**
 * @preserve
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/
 * @copyright 2019 ThemePunch
 * @version 2.1.9
 */
!function(){var t=!1,i=Math.PI/2-.4,s=Math.PI/2+.4,e={x:0,y:0,block:!1};jQuery("rs-slide[data-revaddonpaintbrush]").each((function(){var t=jQuery(this),i=t.children("img"),s=i.attr("data-bg"),e="";s&&(s=s.split("c:")).length>1&&(e=s[1].split(";")[0]);var a="p:center center;";e&&(a+="c:"+e+";"),i.attr({"data-bg":a,"data-kenburns":"off"}).removeAttr("data-panzoom"),t.attr("data-revaddonpaintbrushedges")&&t.attr("data-anim","ei:d;eo:d;s:1000;r:0;t:fade;sl:0;")})),jQuery("rs-slide[data-revaddonpaintbrushfallback]").each((function(){var t=jQuery(this),i=t.children("img"),s=t.attr("data-revaddonpaintbrushfallback"),e=i.attr("data-lazyload"),a=e?"data-lazyload":"src";e?i.data("lazyload",s):i.attr(a,s)}));var a,n="ontouchend"in document;function h(i,s,e,a,n,h,r,o,d,c){if(this.pause=!0,this.options=s,this.slide=e,this.img=a,this.slot=n,this.levels=h,this.widths=r,this.slider=i,this.fixEdges=o,this.edgeFix=d,this.frame=void 0,t&&(this.options.shadowBlur/=2),c){var l=document.createElement("style");l.type="text/css",document.head.appendChild(l),this.blurstyle={sheet:l,css:"."+c+" rs-sbg, ."+c+" .slot {filter: blur({{blur}}px);}"},this.resizeBlur(),i.on("revolution.slide.afterdraw",this.blurSizer.bind(this))}}window.RevSliderPaintBrush=function(i,s){if(a=i){var e=!(!a.fn.revolution||!a.fn.revolution[s[0].id])&&a.fn.revolution[s[0].id];e&&(t=a.fn.revolution.isFirefox(),s.on("revolution.slide.onloaded",(function(){var t="",i=e.responsiveLevels,n=e.gridwidth;if(Array.isArray(i)||(i=[i]),Array.isArray(n)||(n=[n]),s.find("rs-slide[data-revaddonpaintbrush]").each((function(){var e,r,o,d,c=new Image,l=a(this).addClass("revaddon-paintbrush").data("paintbrushloading",!0),u=l.attr("data-key"),v=l.find("rs-sbg-wrap"),p=JSON.parse(this.getAttribute("data-revaddonpaintbrush"));(p=a.extend(!0,{blurAmount:10,fadetime:1e3,edgefix:10,fixedges:!1,style:"round",blur:!1,scaleblur:!1,responsive:!1,disappear:!1,carousel:!1},p)).blur&&(e="revaddonblurfilter_"+u,p.scaleblur?d=e:t+="."+e+" rs-sbg, ."+e+" .slot {filter: blur("+p.blurAmount+"px);}",l.addClass(e)),p.fixedges&&p.edgefix&&(r=1+.01*p.edgefix,o="scale("+(o=r.toFixed(2))+", "+o+")",v.find("rs-sbg").css("transform",o),t+="."+(e="revaddonblurfilterfix_"+u)+" rs-sbg {transform: "+o+" !important}",l.addClass(e)),c.onload=function(){p.width=this.naturalWidth,p.height=this.naturalHeight;var t=new h(s,p,l,c,v[0],i,n,o,r,d);l.removeData("paintbrushloading").data("revaddonbrush",t),l.data("paintbrushcurrent")&&(t.pause=!1,l.removeData("paintbrushcurrent"),t.inited||t.init())},c.onerror=function(){console.log("PaintBrush Addon: background image could not be loaded")},c.src=p.image})),t){var r=document.createElement("style");r.type="text/css",r.innerHTML=t,document.head.appendChild(r)}})).on("revolution.slide.onbeforeswap",(function(t,i){i.currentslide.removeData("paintbrushcurrent");var s=i.currentslide.data("revaddonbrush");s&&s.canvas&&(s.canvas.className="revaddonpaintbrush swapping")})).on("revolution.slide.onafterswap",(function(t,i){var e;s.find(".revaddon-paintbrush").each((function(){(e=a(this).removeData("paintbrushcurrent").data("revaddonbrush"))&&(e.pause=!0,e.reset(),e.canvas&&(e.canvas.className="revaddonpaintbrush"))}));var n=s.revcurrentslide()-1,h=s.find("rs-slide").eq(n);h.length||(h=s.find("rs-slide").eq(0)),(e=h.data("revaddonbrush"))?(e.pause=!1,e.ready=!0,e.inited||e.init()):h.data("paintbrushloading")&&h.data("paintbrushcurrent",!0)})))}},h.prototype={init:function(){this.canvas=document.createElement("canvas"),this.brush=document.createElement("canvas"),this.canvas.className="revaddonpaintbrush",this.context=this.canvas.getContext("2d"),this.ctx=this.brush.getContext("2d"),this.slot.parentNode.insertBefore(this.canvas,this.slot.nextSibling),this.inited=!0,this.steps=[],this.options.carousel?setTimeout(this.start.bind(this),100):this.start()},start:function(){this.options.carousel?(this.slide.on("touchstart",this.onTouchStart.bind(this)),this.slide.on("mousemove touchmove",this.onMove.bind(this))):(this.slider.on("touchstart",this.onTouchStart.bind(this)),this.slider.on("mousemove touchmove",this.onMove.bind(this))),this.slider.on("revolution.slide.afterdraw",this.sizer.bind(this)),this.resize()},onTouchStart:function(t){n&&((t=t.originalEvent).touches&&(t=t.touches[0]),function(t){e.x=t.clientX,e.y=t.clientY,e.block=!1}(t))},onMove:function(t){if(!this.pause&&"no"!==e.block){if(n){var a=t;if((t=t.originalEvent).touches&&(t=t.touches[0]),e.block||function(t){var a=e.x-t.clientX,n=e.y-t.clientY,h=Math.abs(Math.atan2(n,a));e.block=h>i&&h<s?"no":"yes"}(t),"yes"===e.block&&a.preventDefault(),"no"===e.block)return}var h=this.canvas.getBoundingClientRect();this.steps.unshift({time:Date.now(),x:t.clientX-h.left,y:t.clientY-h.top}),void 0===this.frame&&this.draw()}},updateSteps:function(){for(var t=Date.now(),i=0;i<this.steps.length;i++)t-this.steps[i].time>this.options.fade&&(this.steps.length=i)},paint:function(){for(var t,i,s=this.steps.length,e=Date.now(),a=1;a<s;a++)void 0!==this.steps[a]&&(i=(e-this.steps[a].time)/this.options.fadetime,t=Math.max(1-i,0),this.ctx.strokeStyle="rgba(0, 0, 0, "+t+")",this.ctx.beginPath(),this.ctx.moveTo(this.steps[a-1].x,this.steps[a-1].y),this.ctx.lineTo(this.steps[a].x,this.steps[a].y),this.ctx.stroke(),0===t&&this.steps.splice(a,1))},draw:function(){this.frame=cancelAnimationFrame(this.frame),this.steps.length>1&&(this.frame=window.requestAnimationFrame(this.draw.bind(this))),this.context.clearRect(0,0,this.canvas.width,this.canvas.height),this.options.disappear&&this.ctx.clearRect(0,0,this.canvas.width,this.canvas.height),this.paint(),this.context.globalCompositeOperation="source-over",this.context.drawImage(this.img,this.cx,this.cy,this.cw,this.ch,0,0,this.canvas.width,this.canvas.height),this.context.shadowBlur=this.options.strength,this.context.globalCompositeOperation="destination-in",this.context.drawImage(this.brush,0,0),this.context.shadowBlur=0},reset:function(){this.context&&(this.frame=cancelAnimationFrame(this.frame),this.context.clearRect(0,0,this.canvas.width,this.canvas.height),this.ctx.clearRect(0,0,this.canvas.width,this.canvas.height))},sizer:function(){this.options.carousel?(clearTimeout(this.timer),this.timer=setTimeout(this.resize.bind(this),250)):this.resize()},resize:function(t){t||this.reset();var i=this.slide.width(),s=this.slide.height();this.edgeFix&&(i*=this.edgeFix,s*=this.edgeFix);var e=Math.min(i/this.options.width,s/this.options.height);if(t)return e;var a=this.options.width*e,n=this.options.height*e,h=1;a<i&&(h=i/a),Math.abs(h-1)<1e-14&&n<s&&(h=s/n);var r=window.devicePixelRatio||1;if(this.cw=this.options.width/(a*h/i),this.ch=this.options.height/(n*h/s),this.cx=.5*(this.options.width-this.cw),this.cy=.5*(this.options.height-this.ch),this.canvas.width=this.brush.width=i*r,this.canvas.height=this.brush.height=s*r,this.canvas.style.width=i+"px",this.canvas.style.height=s+"px",this.cw*=r,this.ch*=r,this.canvas.getContext("2d").scale(r,r),this.options.responsive){for(var o=this.levels.length,d=0,c=0;c<o;c++)i<this.levels[c]&&(d=c);var l=Math.min(i/this.widths[d],1);this.options.size=this.options.origsize*l}this.context.shadowColor="#000000",this.ctx.lineCap=this.options.style,this.ctx.lineWidth=this.options.size},blurSizer:function(){this.options.carousel?(clearTimeout(this.blurTimer),this.blurTimer=setTimeout(this.resizeBlur.bind(this),250)):this.resizeBlur()},resizeBlur:function(){var t=this.blurstyle;t.sheet.innerHTML=t.css.replace("{{blur}}",Math.max(Math.round(this.options.blurAmount*this.resize(!0)),1))}}}();