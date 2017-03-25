<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_featureCategories xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_featureCategories.xsd\">";
	
	echo "<category id=\"continent\" enabled=\"true\" zoom=\"true\" >\n";
	echo "<style event=\"onMouseOut\" fillColor=\"#F5A738\" strokeColor=\"#ffffff\" strokeWidth=\"1\" />\n";
	echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
	echo "<action event=\"onClick\" target=\"loadChild\" url=\"world_continent.php?id=##id##\" />\n";
	echo "</category>\n";
	
	echo "<category id=\"country\" enabled=\"true\" zoom=\"true\" >\n";
	echo "<style event=\"onMouseOut\" fillColor=\"#F5A738\" strokeColor=\"#ffffff\" strokeWidth=\"1\" />\n";
	echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
	echo "</category>\n";

	echo "</jqm_featureCategories>";
?>