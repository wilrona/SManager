'use strict';
var Index = function() {
	var chart1Handler = function() {
		if ($("#acquisitionChart").length) {
			var data = {
				labels : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets : [{
					label : 'dataset',
					fillColor : 'rgba(148,116,153,0.7)',
					strokeColor : 'rgba(148,116,153,0)',
					highlightFill : 'rgba(148,116,153,1)',
					highlightStroke : 'rgba(148,116,153,1)',
					data : [65, 59, 80, 81, 56, 55, 40]
				}]
			};

			var options = {
				maintainAspectRatio : false,
				showScale : false,
				barDatasetSpacing : 0,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				responsive : true,
				scaleBeginAtZero : true,
				scaleShowGridLines : false,
				scaleLineColor : "transparent",
				barShowStroke : false,
				barValueSpacing : 5
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#acquisitionChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart1 = new Chart(ctx).Bar(data, options);
		}
	};
	var chart2Handler = function() {
		if ($("#conversionChart").length) {
			// Chart.js Data
			var data = {
				labels : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets : [{
					label : 'Transactions',
					fillColor : 'rgba(91,155,209,0.5)',
					strokeColor : 'rgba(91,155,209,1)',
					data : [65, 59, 80, 81, 56, 55, 40, 84, 64, 120, 132, 87]
				}, {
					label : 'Unique Visitors',
					fillColor : 'rgba(91,155,209,0.5)',
					strokeColor : 'rgba(91,155,209,0.5)',
					data : [172, 175, 193, 194, 161, 175, 153, 190, 175, 231, 234, 250]
				}]
			};

			// Chart.js Options
			var options = {
				maintainAspectRatio : false,
				showScale : false,
				scaleLineWidth : 0,
				responsive : true,
				scaleFontFamily : "'Helvetica', 'Arial', sans-serif",
				scaleFontSize : 11,
				scaleFontColor : "#aaa",
				scaleShowGridLines : true,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontSize : 12,
				scaleGridLineColor : 'rgba(0,0,0,.05)',
				scaleGridLineWidth : 1,
				bezierCurve : true,
				bezierCurveTension : 0.5,
				scaleLineColor : 'transparent',
				scaleShowVerticalLines : false,
				pointDot : false,
				pointDotRadius : 4,
				pointDotStrokeWidth : 1,
				pointHitDetectionRadius : 20,
				datasetStroke : true,
				datasetStrokeWidth : 2,
				datasetFill : true,
				animationEasing : "easeInOutExpo"
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#conversionChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart2 = new Chart(ctx).Line(data, options);
		}

	};
	var chart3Handler = function() {
		if ($("#productsChart").length) {
			// Chart.js Data
			var data = {
				labels : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				datasets : [{
					label : 'Alpha',
					fillColor : 'rgba(90,135,112,0)',
					strokeColor : 'rgba(90,135,112,1)',
					pointColor : 'rgba(90,135,112,1)',
					data : [656, 594, 806, 817, 568, 557, 408, 843, 642, 1202, 1322, 847]
				}, {
					label : 'Omega',
					fillColor : 'rgba(127,140,141,0)',
					strokeColor : 'rgba(127,140,141,1)',
					pointColor : 'rgba(127,140,141,1)',
					data : [282, 484, 402, 194, 864, 275, 905, 1025, 123, 1455, 650, 1651]
				}, {
					label : 'Kappa',
					fillColor : 'rgba(148,116,153,0)',
					strokeColor : 'rgba(148,116,153,1)',
					pointColor : 'rgba(148,116,153,1)',
					data : [768, 368, 253, 163, 437, 678, 1239, 1345, 1898, 1766, 1603, 2116]
				}]
			};

			// Chart.js Options
			var options = {
				maintainAspectRatio : false,
				responsive : true,
				scaleFontFamily : "'Helvetica', 'Arial', sans-serif",
				scaleFontSize : 11,
				scaleFontColor : "#aaa",
				scaleShowGridLines : true,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontSize : 12,
				scaleGridLineColor : 'rgba(0,0,0,.05)',
				scaleGridLineWidth : 1,
				bezierCurve : false,
				bezierCurveTension : 0.4,
				scaleLineColor : 'transparent',
				scaleShowVerticalLines : false,
				pointDot : false,
				pointDotRadius : 4,
				pointDotStrokeWidth : 1,
				pointHitDetectionRadius : 20,
				datasetStroke : true,
				tooltipXPadding : 20,
				datasetStrokeWidth : 2,
				datasetFill : true,
				animationEasing : "easeInOutExpo"
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#productsChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart3 = new Chart(ctx).Line(data, options);
		}
	};
	var chart4Handler = function() {
		if ($("#lineChart").length) {
			// Chart.js Data
			var data = {
				labels : ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
				datasets : [{
					label : 'dataset',
					fillColor : 'rgba(0,0,0,0)',
					strokeColor : 'rgba(0,0,0,0.2)',
					data : [65, 59, 80, 81, 56, 95, 100]
				}]
			};

			// Chart.js Options
			var options = {
				maintainAspectRatio : false,
				showScale : false,
				scaleLineWidth : 0,
				responsive : true,
				scaleFontFamily : "'Helvetica', 'Arial', sans-serif",
				scaleFontSize : 11,
				scaleFontColor : "#aaa",
				scaleShowGridLines : true,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontSize : 12,
				scaleGridLineColor : 'rgba(0,0,0,.05)',
				scaleGridLineWidth : 1,
				bezierCurve : false,
				bezierCurveTension : 0.2,
				scaleLineColor : 'transparent',
				scaleShowVerticalLines : false,
				pointDot : true,
				pointDotRadius : 4,
				pointDotStrokeWidth : 1,
				pointHitDetectionRadius : 20,
				datasetStroke : true,
				datasetStrokeWidth : 2,
				datasetFill : true,
				animationEasing : "easeInOutExpo"
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#lineChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart4 = new Chart(ctx).Line(data, options);
		}
	};

	var chart5Handler = function() {
		if ($("#barChart").length) {
			// Chart.js Data
			var data = {
				labels : ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'a', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'i', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'],
				datasets : [{
					label : 'dataset',
					fillColor : 'rgba(255,255,244,0.3)',
					strokeColor : 'rgba(255,255,244,0.5)',
					data : [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 80, 81]
				}]
			};

			// Chart.js Options
			var options = {
				maintainAspectRatio : false,
				showScale : false,
				barDatasetSpacing : 0,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				responsive : true,
				scaleBeginAtZero : true,
				scaleShowGridLines : false,
				scaleLineColor : 'transparent',
				barShowStroke : false,
				barValueSpacing : 5
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#barChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart5 = new Chart(ctx).Bar(data, options);
		}
	};
	var chart6Handler = function() {
		if ($("#socialChart").length) {
			// Chart.js Data
			var data = [{
				value : 300,
				color : "#6F83B6",
				label : "Fb"
			}, {
				value : 50,
				color : "#79BEF1",
				label : "YT"
			}, {
				value : 100,
				color : "#ED5952",
				label : "Tw"
			}];

			// Chart.js Options
			var options = {
				responsive : false,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipCornerRadius : 0,
				tooltipCaretSize : 2,
				segmentShowStroke : true,
				segmentStrokeColor : '#fff',
				segmentStrokeWidth : 2,
				percentageInnerCutout : 50,
				animationSteps : 100,
				animationEasing : 'easeOutBounce',
				animateRotate : true,
				animateScale : false
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#socialChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart6 = new Chart(ctx).Doughnut(data, options);
		}
	};
	var chart7Handler = function() {
		if ($("#social2Chart").length) {
			// Chart.js Data
			var data = [{
				value : 200,
				color : "#8BC33E",
				label : "Sc"
			}, {
				value : 150,
				color : "#7F8C8D",
				label : "Ad"
			}];

			// Chart.js Options
			var options = {
				responsive : false,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipCornerRadius : 0,
				tooltipCaretSize : 2,
				segmentShowStroke : true,
				segmentStrokeColor : '#fff',
				segmentStrokeWidth : 2,
				percentageInnerCutout : 50,
				animationSteps : 100,
				animationEasing : 'easeOutBounce',
				animateRotate : true,
				animateScale : false
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#social2Chart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart6 = new Chart(ctx).Doughnut(data, options);
		}
	};
	var chart8Handler = function() {
		if ($("#social3Chart").length) {
			// Chart.js Data
			var data = [{
				value : 300,
				color : "#6F83B6",
				label : "Facebook"
			}, {
				value : 150,
				color : "#79BEF1",
				label : "Twitter"
			}, {
				value : 100,
				color : "#ED5952",
				label : "YouTube"
			}, {
				value : 80,
				color : "#8BC33E",
				label : "Spotify"
			}];

			// Chart.js Options
			var options = {
				responsive : false,
				scaleShowLabelBackdrop : true,
				scaleBackdropColor : 'rgba(255,255,255,0.75)',
				scaleBeginAtZero : true,
				scaleBackdropPaddingY : 2,
				scaleBackdropPaddingX : 2,
				scaleShowLine : true,
				segmentShowStroke : true,
				segmentStrokeColor : '#fff',
				segmentStrokeWidth : 2,
				animationSteps : 100,
				animationEasing : 'easeOutBounce',
				animateRotate : true,
				animateScale : false
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#social3Chart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart6 = new Chart(ctx).PolarArea(data, options);
		}
	};
	var chart9Handler = function() {
		if ($("#social4Chart").length) {
			// Chart.js Data
			var data = [{
				value : 180,
				color : "#6F83B6",
				label : "Facebook"
			}, {
				value : 210,
				color : "#79BEF1",
				label : "Twitter"
			}, {
				value : 97,
				color : "#ED5952",
				label : "YouTube"
			}, {
				value : 60,
				color : "#8BC33E",
				label : "Spotify"
			}];

			// Chart.js Options
			var options = {
				responsive : false,
				scaleShowLabelBackdrop : true,
				scaleBackdropColor : 'rgba(255,255,255,0.75)',
				scaleBeginAtZero : true,
				scaleBackdropPaddingY : 2,
				scaleBackdropPaddingX : 2,
				scaleShowLine : true,
				segmentShowStroke : true,
				segmentStrokeColor : '#fff',
				segmentStrokeWidth : 2,
				animationSteps : 100,
				animationEasing : 'easeOutBounce',
				animateRotate : true,
				animateScale : false
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#social4Chart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart6 = new Chart(ctx).PolarArea(data, options);
		}
	};
	var chart10Handler = function() {
		if ($("#salesChart").length) {
			// Chart.js Data
			var data = {
				labels : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets : [{
					label : 'First',
					fillColor : 'rgba(148,116,153,0.7)',
					highlightFill : 'rgba(148,116,153,1)',
					data : [65, 59, 80, 81, 56, 55, 40]
				}, {
					label : 'Second',
					fillColor : 'rgba(127,140,141,0.7)',
					highlightFill : 'rgba(127,140,141,1)',
					data : [28, 48, 40, 19, 86, 27, 90]
				}]
			};

			// Chart.js Options
			var options = {
				maintainAspectRatio : false,
				responsive : true,
				scaleFontFamily : "'Helvetica', 'Arial', sans-serif",
				scaleFontSize : 11,
				scaleFontColor : "#aaa",
				scaleBeginAtZero : true,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontFamily : "'Helvetica', 'Arial', sans-serif",
				tooltipTitleFontSize : 12,
				scaleShowGridLines : true,
				scaleLineColor : "transparent",
				scaleShowVerticalLines : false,
				scaleGridLineColor : "rgba(0,0,0,.05)",
				scaleGridLineWidth : 1,
				barShowStroke : false,
				barStrokeWidth : 2,
				barValueSpacing : 5,
				barDatasetSpacing : 1
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#salesChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart8 = new Chart(ctx).Bar(data, options);
		}
	};
	var chart11Handler = function() {
		if ($("#bar2Chart").length) {
			// Chart.js Data
			var data = {
				labels : ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'a', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'i', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'],
				datasets : [{
					label : 'dataset',
					fillColor : 'rgba(154,137,181,0.6)',
					highlightFill : 'rgba(154,137,181,0.9)',
					data : [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 80, 81]
				}]
			};

			// Chart.js Options
			var options = {
				maintainAspectRatio : false,
				showScale : false,
				barDatasetSpacing : 0,
				tooltipFontSize : 11,
				tooltipFontFamily : "'Helvetica', 'Arial', sans-serif",
				responsive : true,
				scaleBeginAtZero : true,
				scaleShowGridLines : false,
				scaleLineColor : 'transparent',
				barShowStroke : false,
				barValueSpacing : 5
			};
			// Get context with jQuery - using jQuery's .get() method.
			var ctx = $("#bar2Chart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var chart9 = new Chart(ctx).Bar(data, options);
		}
	};
	var randomUserHandler = function() {
		var randomUsers = 0;
		var interval = 1500;
		$('.random-user').text(randomUsers);
		var realtime = function() {

			var random = setInterval(function() {
				randomUsers = Math.floor((Math.random() * 6) + 100);
				interval = Math.floor((Math.random() * 5000) + 1000);
				$('.random-user').text(randomUsers);
				clearInterval(random);
				realtime();
			}, interval);
		};
		realtime();
	};

	var knob1Handler = function() {
		$(".dial").knob({
			'min' : 0,
			'max' : 100,
			'readOnly' : true,
			'width' : 70,
			'height' : 70,
			'thickness' : .25,
			'fgColor' : "#8773A8",
			'bgColor' : "#C3B8D3",
			'inputColor' : 'transparent',
			'format' : function(value) {
				return value + '%';
			}
		});
		$(".dial-sales").knob({
			'min' : 0,
			'max' : 100,
			'readOnly' : true,
			'width' : 135,
			'height' : 135,
			'thickness' : .16,
			'fgColor' : "#98E1E6",
			'bgColor' : "#EBF5FC",
			'inputColor' : 'transparent',
			'format' : function(value) {
				return value + '%';
			}
		});
	};
	$(".budegt-slider").slider({
		formatter : function(value) {
			return value + ' $';
		}
	});
	return {
		init : function() {
			chart1Handler();
			chart2Handler();
			chart3Handler();
			chart4Handler();
			chart5Handler();
			chart6Handler();
			chart7Handler();
			chart8Handler();
			chart9Handler();
			chart10Handler();
			chart11Handler();
			randomUserHandler();
			knob1Handler();
		}
	};
}();
