<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_featureCategories xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_featureCategories.xsd\">";
	
	include("..\..\libs\jqmDB.php");

	$sql = "SELECT r.rangeID, r.range_color FROM maps_ranges r WHERE r.mapID = 'usallcounties' AND r.levelID = 1 ORDER BY r.rangeID ";
	$query = $jqm_db->query($sql);
	
	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc()) {
			echo "<category id=\"county_" . $rd['rangeID'] . "\" enabled=\"true\" zoom=\"true\" >\n";
			echo "<style event=\"onMouseOut\" fillColor=\"" . $rd['range_color'] . "\" strokeColor=\"#e5e5e5\" strokeWidth=\"0.25\" />\n";
            echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
			echo "<action event=\"onClick\" target=\"js\" jsFunction=\"jqmDisplayFeaturePopup\" />";
			echo "</category>\n";
		}
	$query->close();
	$jqm_db->close();
	
	echo "<category id=\"state\" enabled=\"false\" zoom=\"false\" >\n";
	echo "<style event=\"onMouseOut\" fillColor=\"RGBA(255,255,255,0.1)\" strokeColor=\"#ffffff\" strokeWidth=\"2\" visible=\"false\" />\n";
	echo "</category>\n";	

	echo "</jqm_featureCategories>";
?>