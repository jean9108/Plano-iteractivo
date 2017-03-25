<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_features xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_features.xsd\">\n";
	
	include("..\..\libs\jqmDB.php");

	$sql = "SELECT c.continentID, c.continent FROM jqm_continents c ORDER BY c.continentID";
	$query = $jqm_db->query($sql);

	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc())
			echo "<feature id=\"" . strtolower($rd['continentID']) . "\" category=\"continent\" label=\"" .  htmlspecialchars($rd['continent']) . "\" popup=\"\" />\n";
	$query->close();
	$jqm_db->close();

	echo "</jqm_features>";
?>