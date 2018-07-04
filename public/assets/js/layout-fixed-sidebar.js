var SetLayout = function() {"use strict";
	//function to initiate ckeditor
	var layoutHandler = function() {
		$("#app").removeClass('app-sidebar-fixed app-navbar-fixed app-footer-fixed').addClass('app-sidebar-fixed');
	};

	return {
		//main function to initiate template pages
		init: function() {
			layoutHandler();
		}
	};
}();
