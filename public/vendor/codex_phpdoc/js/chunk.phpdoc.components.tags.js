(window.webpackJsonp=window.webpackJsonp||[]).push([[32],{1135:function(e,t,a){"use strict";a.r(t),function(e){var n=a(1),r=a.n(n),s=a(28),c=a(31),o=a(23),l=(a(1749),a(292)),p=a(623),i=function(){var e=function(t,a){return(e=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(e,t){e.__proto__=t}||function(e,t){for(var a in t)t.hasOwnProperty(a)&&(e[a]=t[a])})(t,a)};return function(t,a){function n(){this.constructor=t}e(t,a),t.prototype=null===a?Object.create(a):(n.prototype=a.prototype,new n)}}(),u=function(e,t,a,n){var r,s=arguments.length,c=s<3?t:null===n?n=Object.getOwnPropertyDescriptor(t,a):n;if("object"==typeof Reflect&&"function"==typeof Reflect.decorate)c=Reflect.decorate(e,t,a,n);else for(var o=e.length-1;o>=0;o--)(r=e[o])&&(c=(s<3?r(c):s>3?r(t,a,c):r(t,a))||c);return s>3&&c&&Object.defineProperty(t,a,c),c},f=function(e,t){if("object"==typeof Reflect&&"function"==typeof Reflect.metadata)return Reflect.metadata(e,t)},m=(a(14)("components:PhpdocTags"),function(t){function a(){var e=null!==t&&t.apply(this,arguments)||this;return e.classNames=function(){for(var t=[],a=0;a<arguments.length;a++)t[a]=arguments[a];return o.classes.apply(void 0,t.filter(Boolean).map(function(t){return Object(c.strEnsureLeft)(t,e.props.prefixCls+"-")}))},e}var m;return i(a,t),Object.defineProperty(a.prototype,"filteredTags",{get:function(){var e=this.props,t=e.onlyTags,a=e.withoutTags;return t&&t.length>0?this.props.tags.whereIn("name",t):a&&a.length>0?this.props.tags.whereNotIn("name",a):this.props.tags},enumerable:!0,configurable:!0}),a.prototype.render=function(){var e=this,t=this.props,a=t.style,n=t.className,s=t.prefixCls;return r.a.createElement("div",{style:a,className:Object(o.classes)(s,n)},this.filteredTags.map(function(t,a){return e.renderTag(t,a)}))},a.prototype.renderTag=function(e,t){void 0===t&&(t=null);var a=this.classNames,n=this.props,s=n.size,l=n.color;return r.a.createElement("div",{className:a("tag"),key:t||e.name+e.line,style:{fontSize:s,color:Object(c.getColor)(l)}},r.a.createElement("span",{className:a("tag-left")},r.a.createElement("span",{className:Object(o.classes)("tag-at")},"@"),r.a.createElement("span",{className:Object(o.classes)("tag-name")},e.name)),r.a.createElement("span",{className:a("tag-right")},this.renderTagContent(e)))},a.prototype.renderTagContent=function(e){this.classNames;var t=this.props,a=(t.size,t.color,e.variable),s=e.refers,p=e.link,i=(e.line,e.description),u=(e.type,e.name),f=e.types;a=r.a.createElement("span",{className:Object(o.classes)("tag-variable")},a);try{i=this.hc.parse(i)}catch(e){}switch(i=r.a.createElement("span",{className:Object(o.classes)("tag-description")},i),u){case"example":return r.a.createElement(c.CodeHighlight,{language:"php",withLineNumbers:!0,code:e.description});case"see":if(p)return r.a.createElement(n.Fragment,null,r.a.createElement(l.a,{type:p}),i);case"return":case"throws":return r.a.createElement(n.Fragment,null,r.a.createElement(l.a,{type:f}),i);case"param":return r.a.createElement(n.Fragment,null,r.a.createElement(l.a,{type:f}),a,i)}return r.a.createElement(n.Fragment,null,i,p?r.a.createElement("a",{className:Object(o.classes)("tag-link"),href:p,target:"_blank"},p):null,s?r.a.createElement("span",{className:Object(o.classes)("tag-refers")},s):null)},a.displayName="PhpdocTags",a.defaultProps={size:11,prefixCls:"phpdoc-tags"},u([Object(c.lazyInject)("components"),f("design:type","function"==typeof(m=void 0!==c.HtmlComponents&&c.HtmlComponents)?m:Object)],a.prototype,"hc",void 0),a=u([Object(p.hot)(e),s.observer],a)}(r.a.Component));t.default=m}.call(this,a(59)(e))},1749:function(e,t,a){}}]);