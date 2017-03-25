/*
jQueryMaps Map Management Library

This file contains everything directed related to the map:
- The reference to the jQueryMaps library.
- The JQueryMaps class instancing when the page is loaded.
- The functions that interact with the map.

Call 1-866-392-0071 or email us at support@jquerymaps.com for support.
*/

// Load the jQueryMaps library
if (window.location.href.indexOf('jqmdebug') != -1)
	// Load the debug version of the jQueryMaps library if '?jqmdebug' is added to the URL
	// This lets our technicians help you if anything doesn't work as expected
	document.write("<script src='http://localhost/jqm/jquerymaps/libs/jquerymaps/JQueryMaps_debug.js'><\/script>");
else
	// Load the standard jQueryMaps library
	document.write("<script src='jquerymaps/libs/jquerymaps/JQueryMaps.js'><\/script>");

// jqmMap is the map instance
var jqmMap;
var ytbplayer;

// Miscelaneaus variables
var jqmChart;
var jqmMapZoom = [];
var jqmMapZoomBack = [];
var jqmMapLat = "";
var jqmMapLon = "";
var jqmMapID = "";

var map_id 		= "";
var map_title	= "";

// Actions to run when the document has been loaded
$(document).ready(function() {
	$('#slider').slider({orientation: 'horizontal', min: 1970, max: 2010, step: 10, range: 'min', value: 2010, change: function(event, ui) { jqmSetYear(ui.value); }  });
	$("#jqm_dialog").dialog({autoOpen: false});	

	jqmGetSelectedMap();
});

// Get the selected map
function jqmGetSelectedMap() {
	$("#jqm_menu > li > a").each(function(){ 
		if ($(this).hasClass("select")) { 
			map_id = $(this).attr("id").substr(4); 
			map_title = $(this).html(); 
			// Load the map
			jqmLoadMap();
		}
	});
}

// Load the map
function jqmLoadMap() {

	// Set the map title
	$("#jqm_breadcrumbs").html(map_title); 

	// Set the map background
	jqmSetMapBackground();
	
	var theme = "jquerymaps/themes/" + map_id + "/" + map_id + ".php";
	
	// Set the parameters to create the map
	var params = {mapDivId: "jqm_map", 				// The DIV element that will contain the map
		configUrl: "jquerymaps/jqm_config.xml", 	// The general configuration URL
		initialThemeUrl: theme, 					// The initial theme URL (children themes may be loaded later on)
		width: "780", 								// Map width
		height: "400"};								// Map height
		
	// Create the map by instancing the JQueryMaps.Map class
	jqmMap = new JQueryMaps.Map(params);
	
	// Load the info box
	jqmLoadInfoBox();
}

// Called from the map on system events
function jqmFromMap(obj) { 
	// obj.event is the event that triggered the call
	switch (obj.event) {
		case "allDataProcessed":
			jqmLoadLegend(obj.level+1);

			if (map_id == "uscounties") 
				jqmLoadInfoBox(); 

			if (jqmMapZoom.length > 0) {
				jqmMap.clickOnFeature(jqmMapZoom[0]);
				jqmMapZoom.splice(0, 1);
			}
			
			if (jqmMapZoomBack.length == 0 && jqmMapZoom.length == 0 && jqmMapLat != "") {
				jqmMap.focusOnPoint({lat: jqmMapLat, lon: jqmMapLon, scale:	"10000000"});
				jqmMapLat = jqmMapLon = "";
				if (jqmMapID != "") { jqmLoadMarkerPopup(jqmMapID); jqmMapID = ""; }
			}
			break;
		case "zoomFinished":
			jqmWriteBreadcrumbs(obj.clickedFeatures);
			
			if (obj.level == 0 && jqmMapZoomBack.length > 0) { 
				jqmMapZoom = jqmMapZoomBack;
				jqmMapZoomBack = [];
				jqmMap.clickOnFeature(jqmMapZoom[0]);
				jqmMapZoom.splice(0, 1); 
			}
			break;
		case "buttonClicked":
			if (obj.button == "back")
				if ($("#jqm_dialog").dialog("isOpen")) { $("#jqm_dialog").dialog("close"); }
			break;
		case "levelBack":
			if ($("#jqm_dialog").dialog("isOpen")) { $("#jqm_dialog").dialog("close"); }
			break;
	}
}


// Write the breadcrumbs of the map
function jqmWriteBreadcrumbs(features) {
	var title = "";
	if (features.length > 0) { 
		for (i = features.length; i > 0; i--)
			title += " &raquo; " + features[features.length - i].label;
	}
	$("#jqm_breadcrumbs").html(map_title + "" + title);
}

// Load the legend box
function jqmLoadLegend(level) {
	$.ajax({url: "jquerymaps/info/legend.php", data: "map=" + map_id + "&level=" + level, success: function(data) { $("#box_legend").html(data).show("blind");  } });
}

// Load the info box
function jqmLoadInfoBox() {
	var y = "";
	var id = "";
	
	switch(map_id) {
		case "us":
			y = $("#slider").slider("value");
			break;
		case "uscounties":
			y = $("#slider").slider("value");
			if (jqmMap.getCurrentLevel() > 0) { var features = jqmMap.getClickedFeatures(); id = features[0].id; }
			break;
		case "usallcounties":
			y = $("input[name=radio]:checked").attr("id");
			break;
	}

	$("#info_box").html("");
	$.ajax({url: "jquerymaps/info/info_box.php", data: "map=" + map_id + "&year=" + y + "&id=" + id, success: function(data) { $("#info_box").html(data).show("blind"); } });
}

// Set the year on the slider
function jqmSelectYear(y) { 
	$("#slider").slider('value', y); 
}	

// Set the year from the slider
function jqmSetYear(y) {
	if ($("#jqm_dialog").dialog("isOpen") === true) { $("#jqm_dialog").dialog("close"); }	

	// Load a new theme
	var theme = "jquerymaps/themes/" + map_id + "/" + map_id + ".php?year=" + y;
	jqmMap.loadInitialTheme(theme);

	// Load the info box
	jqmLoadInfoBox();
}

// Simulate a click on a feature or marker
function jqmRunInfoBoxAction(feature, marker, lat, lon) {
	switch(map_id) {
		case "us":
		case "uscounties":
		case "usallcounties":
			jqmMap.clickOnFeature(feature);
			break;
		case "world":
			jqmMapLat = lat;
			jqmMapLon = lon;
			jqmMapID = marker;		
			if (jqmMap.getCurrentLevel() == 0) {
				jqmMapZoom = feature.split(",");
				jqmMap.clickOnFeature(jqmMapZoom[0]);
				jqmMapZoom.splice(0, 1);
			} else {
				jqmMapZoomBack = feature.split(",");
				jqmMap.displayInitialView();
			}
			break;
	}
}

// Show or hide a feature category
function jqmShowOrHideFeaturesRange(category, feature_category) { 
	if ($("#feature_" + category).hasClass("enable") == true) {
		$("#feature_icon_" + category).css("background-color","#E5E5E5");
		$("#feature_" + category).removeClass("enable").addClass("disable").html("Show " + $("#feature_" + category).attr('label'));
		if (feature_category != "") {
			var list = feature_category.split(",");
			jqmMap.hideFeaturesByCategory(list[jqmMap.getCurrentLevel()] + "_" + category); 
		} else {
			jqmMap.hideFeaturesByCategory(category); 
		}
	} else {
		$("#feature_icon_" + category).css("background-color", $("#feature_icon_" + category).attr('color'));
		$("#feature_" + category).removeClass("disable").addClass("enable").html("Hide " + $("#feature_" + category).attr('label'));
		if (feature_category != "") {
			var list = feature_category.split(",");
			jqmMap.showFeaturesByCategory(list[jqmMap.getCurrentLevel()] + "_" + category); 
		} else {
			jqmMap.showFeaturesByCategory(category); 
		}
	}
}

// Show or hide a marker category
function jqmShowOrHideMarkersRange(category) { 
	if ($("#category_" + category).hasClass("enable") == true) {
		$("#category_icon_"  + category).fadeTo("fast", 0.4);
		$("#category_" + category).removeClass("enable").addClass("disable").html("Show " + $("#category_" + category).attr('label'));
		jqmMap.hideMarkersByCategory(category); 
	} else {
		$("#category_icon_" + category).fadeTo("fast", 1);
		$("#category_" + category).removeClass("disable").addClass("enable").html("Hide " + $("#category_" + category).attr('label'));
		jqmMap.showMarkersByCategory(category); 
	}
	jqmMap.refreshMarkers();
}

// Display the popup when an feature has been clicked
function jqmDisplayFeaturePopup(obj) {
	
	// Load feature data
	$.ajax({ url: "jquerymaps/info/popup_chart.php", data: "map=" + map_id + "&id=" + obj.id + "&year=" + obj.y, cache: false, success: function(data) {
		switch(map_id) {
			case "us":
			case "uscounties":
				$("#jqm_dialog").dialog({autoOpen: true, dialogClass: 'box_dialog', width: 360, height: 225, position: { of: "#jqm_map" }, resizable: false, show: "blind", title: obj.label });
				$("#jqm_box_dialog").hide();
				$("#ytplayer").hide();
				$("#jqm_box_canvas").show();
			
				var info = [];
				for (i = 0; i < data.length; i++) { info.push(parseFloat(data[i]["y"])); }

				var bar_data = { labels : ["1970","1980","1990","2000","2010"], datasets : [{fillColor : "#4da1bd", strokeColor : "rgba(220,220,220,1)", pointColor : "#DD3F24", pointStrokeColor : "#ffffff", data: info}] }
				var bar_options = {	barShowStroke: false, scaleShowLabels: true, animation: true, scaleFontSize: 10, scaleFontFamily: "'Verdana'" }
				var bar = new Chart(document.getElementById("jqm_box_canvas").getContext("2d")).Line(bar_data, bar_options);

				break;
			case "usallcounties":
				$("#jqm_dialog").dialog({autoOpen: true, dialogClass: 'box_dialog', width: 500, height: 300, position: { of: "#jqm_map" }, resizable: false, show: "blind", title: obj.label });
				$("#jqm_box_canvas").hide();
				$("#ytplayer").hide();
				$("#jqm_box_dialog").html(data).show();
				break;
		}
	} });
}

// Display the popup when a marker has been clicked
function jqmDisplayMarkerPopup(obj) {
	jqmLoadMarkerPopup(obj.id);
}

// Display the marker popup
function jqmLoadMarkerPopup(id) {
	$.ajax({ url: "jquerymaps/info/popup.php", data: "map=" + map_id + "&id=" + id, cache: false, success: function(data) {
		switch(map_id) {
			case "us":
			case "uscounties":
				$("#jqm_dialog").dialog({autoOpen: true, dialogClass: 'box_dialog', modal: false, width: 300, height: 100, position: { of: "#jqm_map" }, resizable: false, show: "blind", title: "City" });
				$("#jqm_box_dialog").html(data).show();
				$("#jqm_box_canvas").hide();
				$("#ytplayer").hide();
				break;
			case "world":
				$("#jqm_dialog").dialog({autoOpen: true, dialogClass: 'box_dialog', modal: false, width: 400, height: 200, position: { of: "#jqm_map" }, resizable: false, show: "blind", title: "Airport" });
				$("#jqm_box_dialog").html(data).show();
				$("#jqm_box_canvas").hide();
				$("#ytplayer").hide();
				break;
		}
	} });
}

// Zoom in on a feature
function jqmZoomIn(id) {
	if ($("#jqm_dialog").dialog("isOpen") === true) { 
		$("#jqm_dialog").dialog("close"); 
	}	
	if (jqmMap.getCurrentLevel() == 0) {
		jqmMapZoom = id.split(",");
		jqmMap.clickOnFeature(jqmMapZoom[0]);
		jqmMapZoom.splice(0, 1);
	} else {
		jqmMapZoomBack = id.split(",");
		jqmMap.displayInitialView();
	}
}

// Display the initial view
function jqmDisplayInitialView() {
	if ($("#jqm_dialog").dialog("isOpen") === true) { 
		$("#jqm_dialog").dialog("close"); 
	}
	jqmMap.displayInitialView();
}

// Focus on a point and show a popup
function jqmFocusOnPoint(id, lat, lon, scale) {
	jqmMap.focusOnPoint({lat: lat, lon: lon, scale:	scale});
	jqmLoadMarkerPopup(id);
}

// Scale a feature
function jqmScaleFeature(id, scale) {
	jqmMap.hideMarkersByCategory("*"); 
	jqmMap.refreshMarkers();		
	jqmMap.scaleFeature(id, scale);
}

// Unscale features
function jqmUnscaleFeatures() {
	jqmMap.showMarkersByCategory("*"); 
	jqmMap.refreshMarkers();		
	jqmMap.unscaleFeatures();
	jqmMap.redraw();
}

// Show or hide the background
function jqmToogleBackground() {
	if ($("#f_back").hasClass("enable") == true) {
		$("#f_back").removeClass("enable");
		$("#f_back").addClass("disable");
		jqmRemoveMapBackground();
	} else {
		$("#f_back").removeClass("disable");
		$("#f_back").addClass("enable");
		jqmSetMapBackground();
	}
}

// Set map background
function jqmSetMapBackground() {
	if (vIE() == true) {
		$("#jqm_map").css("background", "#ffffff url(images/backgrounds/map_back_" + map_id + ".jpg) top left no-repeat ");
	} else {
		$("#jqm_map").css("background", "url(images/backgrounds/map_back_" + map_id + ".jpg) center no-repeat ");
		$("#jqm_map").css("background-size", "cover");
	}
}

// Remove map background
function jqmRemoveMapBackground() {
	$("#jqm_map").css("background", "none");
}

// Display/hide a box
function toogleBox(id) { 
	if ($("#" + id).is(":visible") == false) {
		$("#" + id + "_icon").removeClass("more").addClass("less");
	} else {
		$("#" + id + "_icon").removeClass("less").addClass("more");
	}
	$("#" + id).toggle("blind"); 
}

// Check IE version
function vIE(){
	if (document.documentMode < 9) 
		return true
	else
		return false
}


// show video
	function showVideo() {
		$("#jqm_dialog").dialog({autoOpen: true, dialogClass: 'box_dialog', modal: true, width: 590, height: 370, position: { of: "#jqm_map" }, resizable: false, title: "About jQueryMaps", beforeClose: function(event, ui) { ytbplayer.stopVideo(); } });	
		$("#jqm_box_dialog").hide();
		$("#jqm_box_canvas").hide();
		$("#ytplayer").show();
	
		if (ytbplayer == undefined) {
			ytbplayer = new YT.Player('ytplayer', {width: "560", height: "315", videoId: '4vYstDr-vZ0', events: { 'onReady': onPlayerReady,  'onStateChange': onPlayerStateChange }});
		} else {
			ytbplayer.seekTo(0,true);
		}
	}

	// autoplay video
	function onPlayerReady(event) { 
	//	event.target.playVideo(); 
	}

	// when video ends
	function onPlayerStateChange(event) { if(event.data === 0) { $("#jqm_dialog").dialog("close") } }