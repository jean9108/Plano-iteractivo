<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_markers xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_markers.xsd\">\n";
	
	$id = ""; if (!empty($_REQUEST["id"])) { $id = $_REQUEST["id"]; }	
	include("..\..\libs\jqmDB.php");

	//****************
	//*** AIRPORTS ***	
	//****************
	$sql = "SELECT a.*, c.country FROM jqm_airports a, jqm_countries c WHERE a.countryID = c.countryID AND a.lat <> 0 AND a.lon <> 0 AND a.continentID = '" . $id . "' ";
	$sql .= "ORDER BY passengers_2011 ASC ";
	$query = $jqm_db->query($sql);

	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc())
			if ($rd['passengers_2011'] > 0)
				echo "<marker id=\"" . $rd['airportID'] . "\" category=\"airport_main\" label=\"" . htmlspecialchars($rd['airport']) . "\" lat=\"" . $rd['lat'] . "\" lon=\"" . $rd['lon'] . "\" popup=\"" . htmlspecialchars($rd['city']) . "\" />\n";
			else
				echo "<marker id=\"" . $rd['airportID'] . "\" category=\"airport\" label=\"" . htmlspecialchars($rd['airport']) . "\" lat=\"" . $rd['lat'] . "\" lon=\"" . $rd['lon'] . "\" popup=\"" . htmlspecialchars($rd['city'] . ", " . $rd['country']) . "\" />\n";
	$query->close();
	$jqm_db->close();

	echo "</jqm_markers>";
?>