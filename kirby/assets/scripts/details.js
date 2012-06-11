(function () {
	"use strict";

	var details_init, test_element, event_method;
	
	// Determine available event methods
	test_element = document.createElement('details');
	if (typeof test_element.addEventListener === "function") {
		event_method = 0;
	} else if (typeof test_element.attachEvent === "function") {
		event_method = 1;
	} else {
		event_method = 2;
	}
	
	details_init = function () {
	
		var i, event_func, details_collection;
		
		event_func = function (ev) {
			ev.preventDefault();
		
			var i, details_element, sibling_details;
			
			// Verify that the target of the event is details/summary
			if ((ev.target.tagName === 'SUMMARY') && (ev.target.parentNode.tagName === 'DETAILS')) {
			
				details_element = ev.target.parentNode;
				if (details_element.hasAttribute('open')) {
					details_element.removeAttribute('open');
				} else {
				
					// Close everyone else
					sibling_details = details_element.parentNode.getElementsByTagName('details');
					for (i = 0; i < sibling_details.length; i++) {
						sibling_details[i].removeAttribute('open');
					}
				
					details_element.setAttribute('open', 'open');
					
				}
			
			}
		
		};

		details_collection = document.getElementsByTagName('summary');
		for (i = 0; i < details_collection.length; i++) {
			if (details_collection[i].parentNode.tagName.toUpperCase() === 'DETAILS') {
				if (event_method === 0) {
					details_collection[i].addEventListener('click', event_func, false);
				} else if (event_method === 1) {
					details_collection[i].attachEvent('onclick', event_func);
				} else {
					details_collection[i].onload = event_func;
				}
			}
		}
	
	};
	
	
	if (event_method === 0) {
		window.addEventListener('load', details_init, false);
	} else if (event_method === 1) {
		window.attachEvent('onload', details_init);
	} else {
		if (typeof window.onload === "function") {
			test_element = window.onload;
			window.onload = function () { test_element(); details_init(); }; 
		} else {
			window.onload = details_init;
		}
	}

}());

