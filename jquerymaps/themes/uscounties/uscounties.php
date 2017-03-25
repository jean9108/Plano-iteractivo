<?php
	$year = "2010"; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	echo "<jqm_theme xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_theme.xsd\" 
		id=\"us\" shapesUrl=\"../../maps/us/fm-us.xml\" backgroundImageUrl=\"\" 
		reloadInterval=\"\" reloadFeatures=\"false\" reloadFeatureCategories=\"false\" reloadMarkers=\"false\" reloadMarkerCategories=\"false\" 
		featuresUrl=\"feature_states.php?year=" . $year . "\" featureCategoriesUrl=\"feature_categories.php?level=1&amp;year=" . $year . "\" 
		markersUrl=\"marker_states.php\" markerCategoriesUrl=\"marker_categories.php\">";
	echo "<platformFunctionality id=\"default\" calculatedMapAreas=\"false\" onMouseOverCalculateInterval=\"\" displayPolygons=\"true\" />";
	echo "</jqm_theme>";
?>