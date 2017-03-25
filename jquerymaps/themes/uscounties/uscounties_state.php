<?php
	$id = ""; if (!empty($_REQUEST["id"])) { $id = substr($_REQUEST["id"], 3, 2); }
	$year = ""; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<jqm_theme xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_theme.xsd\" 
		id=\"us\" shapesUrl=\"../../maps/us/states/fm-us_" . $id . ".xml\" backgroundImageUrl=\"\" 
		reloadInterval=\"\" reloadFeatures=\"false\" reloadFeatureCategories=\"false\" reloadMarkers=\"false\" reloadMarkerCategories=\"false\" 
		featuresUrl=\"feature_counties.php?id=" . $id . "&amp;year=" . $year . "\" featureCategoriesUrl=\"feature_categories.php?level=2\" 
		markersUrl=\"marker_counties.php?id=" . $id . "\" markerCategoriesUrl=\"marker_categories.php\">";
	echo "<platformFunctionality id=\"default\" calculatedMapAreas=\"false\" onMouseOverCalculateInterval=\"\" displayPolygons=\"true\" />";
	echo "</jqm_theme>";
?>