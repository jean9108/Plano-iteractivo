<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_featureCategories xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_featureCategories.xsd\">";
	
	$year = ""; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }		//POPULATION YEAR
	$level = ""; if (!empty($_REQUEST["level"])) { $level = $_REQUEST["level"]; }	//MAP LEVEL

	include("..\..\libs\jqmDB.php");

	$sql = "SELECT r.rangeID, r.range_color FROM maps_ranges r WHERE r.mapID = 'uscounties' AND r.levelID = " . $level . " ORDER BY r.rangeID ";
	$query = $jqm_db->query($sql);
	
	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc()) {
			echo "<category id=\"state_" . $rd['rangeID'] . "\" enabled=\"true\" zoom=\"true\" >\n";
			echo "<style event=\"onMouseOut\" fillColor=\"" . $rd['range_color'] . "\" strokeColor=\"#e5e5e5\" strokeWidth=\"1\" />\n";
            echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
			echo "<action event=\"onClick\" target=\"loadChild\" url=\"uscounties_state.php?id=##id##&amp;year=" . $year . "\" />\n";
			echo "<letteredLabel attributeName=\"label_map\" textStyle=\"label\" />";
			echo "</category>\n";
			
			echo "<category id=\"county_" . $rd['rangeID'] . "\" enabled=\"true\" zoom=\"true\" >\n";
			echo "<style event=\"onMouseOut\" fillColor=\"" . $rd['range_color'] . "\" strokeColor=\"#e5e5e5\" strokeWidth=\"1\" />\n";
            echo "<action event=\"onMouseOver\" target=\"infowindow\" infoWindowDiv=\"jqm_popup\" align=\"mouse,10,10\" />";
			echo "<action event=\"onClick\" target=\"js\" jsFunction=\"jqmDisplayFeaturePopup\" />";
			echo "<letteredLabel attributeName=\"label_map\" textStyle=\"label\" />";
			echo "</category>\n";
		}
	$query->close();
	$jqm_db->close();

	echo "</jqm_featureCategories>";
?>