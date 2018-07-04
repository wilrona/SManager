'use strict';
var UISliders = function() {

	var slidersHandler = function() {
		$(".budegt-slider").slider({
			formatter : function(value) {
				return value + ' $';
			}
		});
		$(".euro-slider").slider({
			formatter : function(value) {
				return value + ' €';
			}
		});
		$(".km-slider").slider({
			formatter : function(value) {
				return value + ' Km';
			}
		});
		$(".simple-slider").slider({});
	};
	return {
		init : function() {
			slidersHandler();
		}
	};
}();
