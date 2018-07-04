var FormPickers = function() {
	"use strict";

	var datePickerHandler = function() {
		$('.datepicker').datepicker({
			autoclose : true,
		});
		$('.format-datepicker').datepicker({
			format : "M, d yyyy",
		});

	};
	var timePickerHandler = function() {
		$('#timepicker-default').timepicker();
	};
	var colorPickerHandler = function() {
		$("#flat").spectrum({
			flat : true,
			showInput : true
		});
		$("#flatPalette").spectrum({
			flat : true,
			showInput : true,
			showPaletteOnly : true,
			togglePaletteOnly : true,
			palette : [['#000', '#444', '#666', '#999', '#ccc', '#eee', '#f3f3f3', '#fff'], ['#f00', '#f90', '#ff0', '#0f0', '#0ff', '#00f', '#90f', '#f0f'], ['#f4cccc', '#fce5cd', '#fff2cc', '#d9ead3', '#d0e0e3', '#cfe2f3', '#d9d2e9', '#ead1dc'], ['#ea9999', '#f9cb9c', '#ffe599', '#b6d7a8', '#a2c4c9', '#9fc5e8', '#b4a7d6', '#d5a6bd'], ['#e06666', '#f6b26b', '#ffd966', '#93c47d', '#76a5af', '#6fa8dc', '#8e7cc3', '#c27ba0'], ['#c00', '#e69138', '#f1c232', '#6aa84f', '#45818e', '#3d85c6', '#674ea7', '#a64d79'], ['#900', '#b45f06', '#bf9000', '#38761d', '#134f5c', '#0b5394', '#351c75', '#741b47'], ['#600', '#783f04', '#7f6000', '#274e13', '#0c343d', '#073763', '#20124d', '#4c1130']]
		});
		$("#preferredHsl").spectrum({
			preferredFormat : "hsl",
			showInput : false
		});
		$("#preferredHsv").spectrum({
			preferredFormat : "hsv",
			showInput : false
		});
		$("#preferredRgb").spectrum({
			preferredFormat : "rgb",
			showInput : false
		});
		$("#preferredHex").spectrum({
			preferredFormat : "hex",
			showInput : false
		});
		$("#preferredHex8").spectrum({
			preferredFormat : "hex8",
			showInput : false
		});
		$("#preferredAlpha").spectrum({
			preferredFormat : "rgb",
			showInput : false,
			showAlpha : true
		});
		$("#showInput").spectrum({
			preferredFormat : "hex",
			showInput : true
		});
		$("#disabled").spectrum({
			disabled : true
		});
		$("#showPalette").spectrum({
			showPalette : true,
			preferredFormat : "hex",
			palette : [['black', 'white', 'blanchedalmond', 'rgb(255, 128, 0);', 'hsv 100 70 50'], ['red', 'yellow', 'green', 'blue', 'violet']]
		});
		$("#showPaletteOnly").spectrum({
			showPalette : true,
			showPaletteOnly : true,
			preferredFormat : "hex",
			hideAfterPaletteSelect : true,
			palette : [['#000', '#444', '#666', '#999', '#ccc', '#eee', '#f3f3f3', '#fff'], ['#f00', '#f90', '#ff0', '#0f0', '#0ff', '#00f', '#90f', '#f0f'], ['#f4cccc', '#fce5cd', '#fff2cc', '#d9ead3', '#d0e0e3', '#cfe2f3', '#d9d2e9', '#ead1dc'], ['#ea9999', '#f9cb9c', '#ffe599', '#b6d7a8', '#a2c4c9', '#9fc5e8', '#b4a7d6', '#d5a6bd'], ['#e06666', '#f6b26b', '#ffd966', '#93c47d', '#76a5af', '#6fa8dc', '#8e7cc3', '#c27ba0'], ['#c00', '#e69138', '#f1c232', '#6aa84f', '#45818e', '#3d85c6', '#674ea7', '#a64d79'], ['#900', '#b45f06', '#bf9000', '#38761d', '#134f5c', '#0b5394', '#351c75', '#741b47'], ['#600', '#783f04', '#7f6000', '#274e13', '#0c343d', '#073763', '#20124d', '#4c1130']]
		});
		$("#togglePalette").spectrum({
			showPaletteOnly: true, 
			togglePaletteOnly: true, 
			togglePaletteLessText: 'less', 
			palette: [['#000','#444','#666','#999','#ccc','#eee','#f3f3f3','#fff'], ['#f00','#f90','#ff0','#0f0','#0ff','#00f','#90f','#f0f'], ['#f4cccc','#fce5cd','#fff2cc','#d9ead3','#d0e0e3','#cfe2f3','#d9d2e9','#ead1dc'], ['#ea9999','#f9cb9c','#ffe599','#b6d7a8','#a2c4c9','#9fc5e8','#b4a7d6','#d5a6bd'], ['#e06666','#f6b26b','#ffd966','#93c47d','#76a5af','#6fa8dc','#8e7cc3','#c27ba0'], ['#c00','#e69138','#f1c232','#6aa84f','#45818e','#3d85c6','#674ea7','#a64d79'], ['#900','#b45f06','#bf9000','#38761d','#134f5c','#0b5394','#351c75','#741b47'], ['#600','#783f04','#7f6000','#274e13','#0c343d','#073763','#20124d','#4c1130']]
		});
		$("#showSelectionPalette").spectrum({
			showPalette: true, 
			showSelectionPalette: true, 
			palette: [ ]
		});
		$("#showInitial").spectrum({
			showInitial: true
		});
		$("#showInputInitial").spectrum({
			showInitial: true, 
			showInput: true
		});
		$("#buttonText").spectrum({
			allowEmpty:true, 
			chooseText: 'Alright', 
			cancelText: 'No way'
		});
	};
	return {
		//main function to initiate template pages
		init : function() {
			datePickerHandler();
			timePickerHandler();
			colorPickerHandler();
		}
	};
}();
