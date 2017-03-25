<?php
	$id = ""; if (!empty($_REQUEST["id"])) { $id = $_REQUEST["id"]; }

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	echo "<jqm_theme xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_theme.xsd\" 
		id=\"us\" shapesUrl=\"../../maps/world/continents/fm-world_" . $id . ".xml\" backgroundImageUrl=\"\" 
		reloadInterval=\"\" reloadFeatures=\"false\" reloadFeatureCategories=\"false\" reloadMarkers=\"false\" reloadMarkerCategories=\"false\" 
		featuresUrl=\"feature_countries.php?id=" . $id . "\" featureCategoriesUrl=\"feature_categories.php\" 
		markersUrl=\"marker_continent.php?id=" . $id . "\" markerCategoriesUrl=\"marker_categories.php\">";
	echo "<platformFunctionality id=\"default\" calculatedMapAreas=\"false\" onMouseOverCalculateInterval=\"\" displayPolygons=\"true\" />";
	echo "</jqm_theme>";
?>