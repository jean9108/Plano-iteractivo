<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_features xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_features.xsd\">\n";

	$id = ""; if (!empty($_REQUEST["id"])) { $id = $_REQUEST["id"]; }	
	include("..\..\libs\jqmDB.php");

	$sql = "SELECT c.continentID, c.countryID, c.country FROM jqm_countries c WHERE c.continentID = '" . $id . "' ORDER BY c.countryID";
	$query = $jqm_db->query($sql);

	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc())
			echo "<feature id=\"" . strtolower($rd['countryID']) . "\" category=\"country\" label=\"" .  htmlspecialchars($rd['country']) . "\" popup=\"\" />\n";
	$query->close();
	$jqm_db->close();

	echo "</jqm_features>";
?>