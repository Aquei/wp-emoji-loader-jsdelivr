(function(w, d){
	"use strict";
	var elm = d.currentScript || d.querySelector("[data-wpv]"),
		regex = /^\d+(?:\.\d+){1,2}$/,
		v;

	if(elm){
		v = elm.getAttribute("data-wpv");
		if(regex.test(v)){
			v = "@" + v;
		}else{
			v = "";
		}
	}
w._wpemojiSettings = {"baseUrl":"https://cdn.jsdelivr.net/gh/twitter/twemoji/assets/72x72/","ext":".png","svgUrl":"https://cdn.jsdelivr.net/gh/twitter/twemoji/assets/svg/","svgExt":".svg","source":{"concatemoji":"https://cdn.jsdelivr.net/gh/WordPress/WordPress" + v + "/wp-includes/js/wp-emoji-release.min.js"}};
})(window, document);
