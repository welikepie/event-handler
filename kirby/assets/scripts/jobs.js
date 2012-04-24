(function () {
	"use strict";
	
	var extender_init, test_element, event_method;
	
	// Determine available event methods
	test_element = document.createElement('a');
	if (typeof test_element.addEventListener === "function") {
		event_method = 0;
	} else if (typeof test_element.attachEvent === "function") {
		event_method = 1;
	} else {
		event_method = 2;
	}
	
	extender_init = function () {
	
		var event_func, extenders, i;
		event_func = function (ev) {
		
			var divs, description_div;
			ev.preventDefault();
		
			divs = this.parentNode.getElementsByTagName('div');
			for (var i = 0; i < divs.length; i++) {
			
				if (divs[i].className.toLowerCase().indexOf('description') !== -1) {
					description_div = divs[i];
					break;
				}
			
			}
			if (typeof description_div !== 'undefined') {
				if (description_div.className.indexOf('open') !== -1) {
					description_div.className = description_div.className.replace(/\bopen\b/i, '').replace(/\s+/i, ' ').replace(/^\s+|\s+$/i, '');
					this.innerHTML = 'View More';
				} else {
					description_div.className += ' open';
					this.innerHTML = 'Hide';
				}
			}
		
		};
		
		extenders = document.getElementsByTagName('a');
		for (i = 0; i < extenders.length; i++) {
			if (extenders[i].className.toLowerCase().indexOf('extender') !== -1) {
				if (event_method === 0) {
					extenders[i].addEventListener('click', event_func, false);
				} else if (event_method === 1) {
					extenders[i].attachEvent('onclick', event_func);
				} else {
					extenders[i].onclick = event_func;
				}
			}
		}
	
	};
	
	if (event_method === 0) {
		window.addEventListener('load', extender_init, false);
	} else if (event_method === 1) {
		window.attachEvent('onload', extender_init);
	} else {
		if (typeof window.onload === 'function') {
			test_element = window.onload;
			window.onload = function () { test_element(); extender_init(); }; 
		} else {
			window.onload = extender_init;
		}
	}

}());