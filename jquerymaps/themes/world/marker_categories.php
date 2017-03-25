<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_markerCategories xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_markerCategories.xsd\">";

	echo "<category id=\"airport\" enabled=\"true\" >\n";
	echo "<markerStyle event=\"onMouseOut\" iconUrl=\"../../images/icons/airport.png\" scale=\"1\" opacity=\"1\" visible=\"true\" />";
	echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
	echo "<action event=\"onClick\" target=\"js\" jsFunction=\"jqmDisplayMarkerPopup\" />";
	echo "</category>\n";

	echo "<category id=\"airport_main\" enabled=\"true\" >\n";
	echo "<markerStyle event=\"onMouseOut\" iconUrl=\"../../images/icons/airport_main.png\" scale=\"1\" opacity=\"1\" visible=\"true\" />";
	echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
	echo "<action event=\"onClick\" target=\"js\" jsFunction=\"jqmDisplayMarkerPopup\" />";
	echo "</category>\n";

	echo "</jqm_markerCategories>";
?>