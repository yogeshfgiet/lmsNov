/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */
(function(window){'use strict';function classReg(className){return new RegExp("(^|\\s+)"+className+"(\\s+|$)");}
var hasClass,addClass,removeClass;if('classList'in document.documentElement){hasClass=function(elem,c){return elem.classList.contains(c);};addClass=function(elem,c){elem.classList.add(c);};removeClass=function(elem,c){elem.classList.remove(c);};}
else{hasClass=function(elem,c){return classReg(c).test(elem.className);};addClass=function(elem,c){if(!hasClass(elem,c)){elem.className=elem.className+' '+c;}};removeClass=function(elem,c){elem.className=elem.className.replace(classReg(c),' ');};}
function toggleClass(elem,c){var fn=hasClass(elem,c)?removeClass:addClass;fn(elem,c);}
var classie={hasClass:hasClass,addClass:addClass,removeClass:removeClass,toggleClass:toggleClass,has:hasClass,add:addClass,remove:removeClass,toggle:toggleClass};if(typeof define==='function'&&define.amd){define(classie);}else{window.classie=classie;}})(window);var ModalEffects=(function(){function init(){var overlay=document.querySelector('.md-overlay');[].slice.call(document.querySelectorAll(".btn-effect")).forEach(function(el,i){var modal=document.querySelector('#'+el.getAttribute('data-modal')),close=modal.querySelector('.btn-modal');console.log(modal);function removeModal(hasPerspective){classie.remove(modal,'md-show');if(hasPerspective){classie.remove(document.documentElement,'md-perspective');}}
function removeModalHandler(){removeModal(classie.has(el,'md-setperspective'));}
el.addEventListener('click',function(ev){classie.add(modal,'md-show');overlay.removeEventListener('click',removeModalHandler);overlay.addEventListener('click',removeModalHandler);if(classie.has(el,'md-setperspective')){setTimeout(function(){classie.add(document.documentElement,'md-perspective');},25);}});close.addEventListener('click',function(ev){ev.stopPropagation();removeModalHandler();});});}
init();})();